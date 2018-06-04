<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 04.06.18
 * Time: 13:27
 */

namespace common\helpers;

use common\models\categories\Category;
use Yii;

/**
 * Class CategoryHelper
 * @package common\helpers
 */
class CategoryHelper
{
    /**
     * @const
     */
    const CACHE_NAME = 'categoryCache';

    /**
     * @const
     */
    const CACHE_DURATION = 36000;

    /**
     * @var array
     */
    private static $categories;

    /**
     * @return array
     */
    public static function getFromCache()
    {
        self::$categories = Yii::$app->cache->get(self::CACHE_NAME);

        if (empty(self::$categories)) {
            self::setToCache();
        }

        return self::$categories;
    }

    /**
     * @return void
     */
    public static function setToCache()
    {
        foreach (Category::find()->roots()->all() as $id => $rootCategory) {
            self::$categories[$id] = [
                'name'  => $rootCategory->name,
                'alias' => $rootCategory->alias,
            ];

            foreach ($rootCategory->children as $child) {
                self::$categories[$id]['children'][] = [
                    'name'  => $child->name,
                    'alias' => $child->alias
                ];
            }
        }

        Yii::$app->cache->add(self::CACHE_NAME, self::$categories, self::CACHE_DURATION);
    }
}