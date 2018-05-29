<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 09.03.18
 * Time: 10:16
 */

namespace common\helpers;

use common\models\ProductsInfo;
use common\models\ProductsProperties;
use Yii;

/**
 * Class ProductsHelper
 * @package common\helpers
 */
class ProductsHelper
{

    /**
     * @const
     */
    const DEFAULT_VALUE = 1;

    /**
     * @const
     */
    const LABEL_NEW = 2;

    /**
     * @const
     */
    const HANDBOOK_RELATION_CATEGORY_BRAND = 5;

    /**
     * @return array
     */
    public static function getProductsForSelect()
    {
        $products = [];
        /** @var ProductsProperties $productsProperty */
        foreach (ProductsProperties::find()->all() as $productsProperty) {
            $products[$productsProperty->id] = $productsProperty->color_id == ProductsProperties::MISSING_COLOR ? $productsProperty->product->name.'('.$productsProperty->remains.' шт.)' : $productsProperty->product->name.'('.\Yii::$app->handbook->getHandbookDataItem('colors', $productsProperty->color_id)->title.')'.'('.$productsProperty->remains.' шт.)';
        }

        return $products;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getNewProducts()
    {
        if (ProductsInfo::find()->where(['label_id' => self::LABEL_NEW])->count() >= 4) {
            return ProductsInfo::find()->where(['label_id' => self::LABEL_NEW])->limit(4)->orderBy(['created_at' => SORT_DESC])->all();
        }

        return [];
    }

    /**
     * @return array
     */
    public static function getProductsCategories()
    {
        $categories = Yii::$app->handbook->getHandbooksListByName('categories');
        unset($categories[self::DEFAULT_VALUE]);

        return $categories;
    }

}