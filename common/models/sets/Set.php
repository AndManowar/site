<?php

namespace common\models\sets;

use common\components\behaviors\ImageManagerBehavior;
use common\models\AppActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * This is the model class for table "sets".
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 * @property string $image
 * @property string $description_text
 * @property string $caption
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property int $is_shown
 * @property int $created_at
 * @property int $updated_at
 *
 * @property SetProduct[] $products
 *
 * @method string getImageFileUrl(string $fileName);
 */
class Set extends AppActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sets}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => 'ID',
            'name'             => 'Name',
            'alias'            => 'Alias',
            'image'            => 'Image',
            'description_text' => 'Description Text',
            'caption'          => 'Caption',
            'title'            => 'Title',
            'keywords'         => 'Keywords',
            'description'      => 'Description',
            'is_shown'         => 'Is Shown',
            'created_at'       => 'Created At',
            'updated_at'       => 'Updated At',
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class'     => ImageUploadBehavior::class,
                'attribute' => 'file',
                'filePath'  => '@setImagePath/[[filename]].[[extension]]',
                'fileUrl'   => '[[filename]].[[extension]]',
            ],
            [
                'class'         => ImageManagerBehavior::class,
                'file'          => 'file',
                'image'         => 'image',
                'directoryPath' => Yii::getAlias('@setImagePath'),
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(SetProduct::class, ['set_id' => 'id']);
    }
}
