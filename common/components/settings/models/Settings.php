<?php

namespace common\components\settings\models;

use common\components\settings\helpers\FormFieldsHelper;
use common\models\AppActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string $systemName
 * @property string $description
 * @property int $fieldType
 * @property string $value
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property string $currentValue
 */
class Settings extends AppActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['systemName', 'description', 'fieldType', 'value'], 'required'],
            [['fieldType'], 'integer'],
            [['systemName', 'description', 'value'], 'string', 'max' => 1000],
            ['value', function () {
                if (!FormFieldsHelper::validation($this->fieldType, $this->value)) {
                    $this->addError('value', FormFieldsHelper::$errors);
                }
            }]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'systemName'  => 'Системное название',
            'description' => 'Описание',
            'fieldType'   => 'Тип поля',
            'value'       => 'Значение',
            'created_at'  => 'Дата создания',
            'updated_at'  => 'Дата обновления',
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * @return string
     */
    public function getCurrentValue()
    {
        if ($this->fieldType == FormFieldsHelper::FIELD_TYPE_CHECKBOX) {

            if ($this->value) {

                return '<span class="label label-success">Включено</span>';
            } else {

                return '<span class="label label-danger">Выключено</span>';
            }
        }

        return $this->value;
    }
}
