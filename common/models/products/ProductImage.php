<?php

namespace common\models\products;

use common\models\AppActiveRecord;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * This is the model class for table "products_images".
 *
 * @property int $id
 * @property int $product_id
 * @property string $image
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Product $product
 * @method string getImageFileUrl(string $fileName);
 */
class ProductImage extends AppActiveRecord
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
        return '{{%products_images}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'image'], 'required'],
            [['product_id', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['image'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'product_id' => 'Product ID',
            'image'      => 'Image',
            'sort'       => 'Sort',
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
                'filePath'  => '@productImagePath/[[filename]].[[extension]]',
                'fileUrl'   => '[[filename]].[[extension]]',
            ],
        ];
    }

    /**
     * @return string
     */
    public function getPreview()
    {
        return Yii::getAlias('@productImagePreviewPath/') . $this->image;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
