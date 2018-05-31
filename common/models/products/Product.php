<?php

namespace common\models\products;

use common\models\AppActiveRecord;
use common\models\categories\Category;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property string $title_image
 * @property double $price
 * @property double $old_price
 * @property double $width
 * @property double $height
 * @property double $thickness
 * @property string $description_text
 * @property string $caption
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property boolean $is_shown
 * @property integer $category_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ProductColor[] $productsColors
 * @property ProductImage[] $productsImages
 * @property Category $category
 *
 * @method string getImageFileUrl(string $fileName);
 */
class Product extends AppActiveRecord
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
        return '{{%products}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => 'ID',
            'name'             => 'Name',
            'title_image'      => 'Title Image',
            'price'            => 'Price',
            'old_price'        => 'Old Price',
            'width'            => 'Width',
            'height'           => 'Height',
            'thickness'        => 'Thickness',
            'description_text' => 'Description Text',
            'caption'          => 'Caption',
            'title'            => 'Title',
            'keywords'         => 'Keywords',
            'description'      => 'Description',
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
                'filePath'  => '@productImagePath/[[filename]].[[extension]]',
                'fileUrl'   => '[[filename]].[[extension]]',
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsColors()
    {
        return $this->hasMany(ProductColor::class, ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsImages()
    {
        return $this->hasMany(ProductImage::class, ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
}
