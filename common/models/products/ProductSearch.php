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
     * @var integer
     */
    public $active_search;

    /**
     * @var bool
     */
    public $is_admin = true;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'width', 'height', 'thickness', 'price', 'active_search'], 'safe'],
        ];
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        if (!$this->is_admin) {
            $query = self::find()->where(['is_shown' => true])->orderBy(['price' => SORT_ASC]);
        } else {
            $query = self::find();
        }

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        $this->load($params);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['price' => $this->price]);
        $query->andFilterWhere(['width' => $this->width]);
        $query->andFilterWhere(['height' => $this->height]);
        $query->andFilterWhere(['thickness' => $this->thickness]);
        $query->andFilterWhere(['category_id' => $this->category_id]);

        if ($this->active_search) {
            $query->andFilterWhere(['is_shown' => $this->active_search]);
        }

        if (!$this->validate()) {

            return $dataProvider;
        }

        return $dataProvider;
    }
}