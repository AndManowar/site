<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 09.08.17
 * Time: 10:12
 */

namespace common\components\handbook\models;

use yii\base\Model;

/**
 * Class HandbookFields
 * @package common\components\handbook\models
 *
 * @property boolean $isEmpty
 */
class HandbookFields extends Model
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var integer
     */
    public $type;

    /**
     * @var bool
     */
    public $notNull = false;

    /**
     * @var integer
     */
    public $created_at;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'description', 'type'], 'required', 'when' => function () {
                return !$this->isEmpty;
            }],
            [['name', 'description'], 'string'],
            ['type', 'integer'],
            [['notNull'], 'boolean'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name'        => 'Системное название поля',
            'description' => 'Описание',
            'type'        => 'Тип поля',
            'notNull'     => 'Обязательно к заполнению',
        ];
    }

    /**
     * Get if model fields are empty
     *
     * @return bool
     */
    public function getIsEmpty()
    {
        return (!$this->name && !$this->description && !$this->type);
    }
}