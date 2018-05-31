<?php

namespace common\models\products;

use common\models\AppActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * This is the model class for table "colors".
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ProductColor[] $productsColors
 *
 * @method string getImageFileUrl(string $fileName);
 */
class Color extends AppActiveRecord
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
        return '{{%colors}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'name'       => 'Name',
            'image'      => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
                'filePath'  => '@colorImagePath/[[filename]].[[extension]]',
                'fileUrl'   => '[[filename]].[[extension]]',
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsColors()
    {
        return $this->hasMany(ProductColor::class, ['color_id' => 'id']);
    }
}
