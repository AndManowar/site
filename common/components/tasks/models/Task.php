<?php

namespace common\components\tasks\models;

use common\models\AppActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $position
 * @property int $status
 * @property int $previousStatus
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 */
class Task extends AppActiveRecord
{
    /**
     * @const
     */
    const STATUS_DEFAULT = 1;

    /**
     * @const Важные задачи
     */
    const STATUS_IMPORTANT = 2;

    /**
     * @const Срочные
     */
    const STATUS_URGENT = 3;

    /**
     * @const Выполненые
     */
    const STATUS_DONE = 5;

    /**
     * @const Выполненый и убранный из списка
     */
    const STATUS_REMOVED = 6;

    /**
     * @var array
     */
    public static $statusList = [
        self::STATUS_DEFAULT   => 'Простые задачи',
        self::STATUS_IMPORTANT => 'Важные задачи',
        self::STATUS_URGENT    => 'Срочные задачи',
        self::STATUS_DONE      => 'Выполненые задачи',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tasks}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'status', 'created_by', 'updated_by'], 'required'],
            [['description'], 'string'],
            [['position', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at', 'previousStatus'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'title'          => 'Заголовок',
            'description'    => 'Описание',
            'position'       => 'Position',
            'status'         => 'Статус',
            'previousStatus' => 'Previous Status',
            'created_by'     => 'Created By',
            'updated_by'     => 'Updated By',
            'created_at'     => 'Created At',
            'updated_at'     => 'Updated At',
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
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->created_by = Yii::$app->user->id;
        }

        $this->updated_at = Yii::$app->user->id;

        return parent::beforeSave($insert);
    }
}
