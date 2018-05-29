<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 29.05.2018
 * Time: 17:59
 */

namespace common\models\categories;

use yii\data\ActiveDataProvider;

/**
 * Class CategorySearch
 * @package common\models\categories
 */
class CategorySearch extends Category
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