<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 31.05.18
 * Time: 14:02
 */

namespace common\models\products;

use yii\data\ActiveDataProvider;

/**
 * Class ColorSearch
 * @package common\models\products
 */
class ColorSearch extends Color
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'safe']
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