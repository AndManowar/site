<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 03.06.2018
 * Time: 17:41
 */

namespace common\models\sets;

use yii\data\ActiveDataProvider;

/**
 * Class SetSearch
 * @package common\models\sets
 */
class SetSearch extends Set
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'safe'],
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
            'query'      => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        $query->andFilterWhere(['like', 'name', $this->name]);

        if (!$this->validate()) {

            return $dataProvider;
        }

        return $dataProvider;
    }
}