<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 31.01.18
 * Time: 11:12
 */

namespace common\components\settings\models;

use yii\data\ActiveDataProvider;

/**
 * Class SettingsSearch
 *
 * @package common\models
 */
class SettingsSearch extends Settings
{

    public function rules()
    {
        return [
            [['systemName', 'description', 'value'], 'safe']
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
                'pageSize' => 15,
            ]
        ]);

        $this->load($params);

        $query->andFilterWhere(['like', 'systemName', $this->systemName]);
        $query->andFilterWhere(['like', 'description', $this->description]);

        if (!$this->validate()) {

            return $dataProvider;
        }


        return $dataProvider;
    }

}