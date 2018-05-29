<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 26.07.17
 * Time: 18:34
 */

namespace common\components\handbook\models;

use common\models\AppActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

/**
 * @property integer $id
 * @property string $systemName
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $fields
 * @property integer $relation
 *
 * @property HandbookData[] $handbookData
 */
class Handbook extends AppActiveRecord
{
    /**
     * Scenario create
     *
     * @const
     */
    const SCENARIO_CREATE = 'create';

    /**
     * Scenario search
     *
     * @const
     */
    const SCENARIO_SEARCH = 'search';

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%handbook}}';
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['systemName', 'fields', 'description', 'created_at', 'updated_at', 'relation'],
            self::SCENARIO_SEARCH => ['systemName', 'description', 'created_at', 'updated_at'],

        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['systemName', 'description'], 'string'],
            [['created_at', 'updated_at', 'relation'], 'integer'],
            [['systemName', 'description',], 'required', 'on' => self::SCENARIO_CREATE],
            [['systemName', 'description', 'created_at', 'updated_at'], 'safe', 'on' => self::SCENARIO_SEARCH],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'systemName'  => 'Системное имя',
            'description' => 'Описание',
            'created_at'  => 'Создано в',
            'updated_at'  => 'Обновлено в',
            'relation'    => 'Зависимый справочник',
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * Relation - Handbook <-> HandbookData
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHandbookData()
    {
        return $this->hasMany(HandbookData::class, ['handbook_id' => 'id']);
    }

    /**
     * Get JSON_decoded additional fields
     *
     * @return array
     */
    public function getFields()
    {
        $decodedFields = [];

        foreach (json_decode($this->fields) as $field) {
            $decodedFields[] = new HandbookFields((array)$field);
        }

        return $decodedFields;
    }

    /**
     * Get handbookData with decoded additional fields data
     *
     * @return mixed
     */
    public function getData()
    {
        foreach ($this->handbookData as $item) {
            $item->additionalFields = $item->getCustomFields();
        }

        return $this->handbookData;
    }

    /**
     * Search method
     *
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}