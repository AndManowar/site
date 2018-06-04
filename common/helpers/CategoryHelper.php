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
    const CACHE_NAME = 'cate3goriesCache';

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
        /**
         * @var Category $rootCategory
         */
        foreach (Category::find()->roots()->all() as $id => $rootCategory) {
            self::$categories[$id] = [
                'category' => $rootCategory,
                'children' => $rootCategory->children()->all()
            ];
        }

        Yii::$app->cache->add(self::CACHE_NAME, self::$categories, self::CACHE_DURATION);
    }
}