<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 31.05.18
 * Time: 14:38
 */

namespace common\models\products;

use yii\data\ActiveDataProvider;

/**
 * Class ProductSearch
 * @package common\models\products
 */
class ProductSearch extends Product
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }

        return $dataProvider;
    }
}