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
    const CACHE_NAME = 'c1atsCache';

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

        if (!self::$categories) {
            self::setToCache();
        }

        return self::$categories;
    }

    /**
     * @return void
     */
    public static function setToCache()
    {
        self::$categories = [];

        /**
         * @var Category $rootCategory
         */
        foreach (Category::find()->roots()->addOrderBy('root, lft')->all() as $id => $rootCategory) {
            if ($rootCategory->alias) {
                self::$categories[$rootCategory->id]['root'] = [
                    'name'  => $rootCategory->name,
                    'alias' => $rootCategory->alias,
                ];
            }
            foreach (Category::find()->where(['parent_id' => $rootCategory->id])->addOrderBy('root, lft')->all() as $child) {
                if ($child->alias) {
                    self::$categories[$rootCategory->id]['root']['children'][$child->id] = [
                        'name'  => $child->name,
                        'alias' => $child->alias,
                    ];
                }
                foreach (Category::find()->where(['parent_id' => $child->id])->addOrderBy('root, lft')->all() as $sub) {
                    if ($sub->alias) {
                        self::$categories[$rootCategory->id]['root']['children'][$child->id]['sub'][] = [
                            'name'  => $sub->name,
                            'alias' => $sub->alias,
                        ];
                    }
                }
            }

        }

        Yii::$app->cache->add(self::CACHE_NAME, self::$categories, self::CACHE_DURATION);
    }
}