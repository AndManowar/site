<?php

namespace common\models\products;

use common\models\AppActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "products_colors".
 *
 * @property int $id
 * @property int $product_id
 * @property int $color_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Color $color
 * @property Product $product
 */
class ProductColor extends AppActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%products_colors}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'color_id'], 'required'],
            [['product_id', 'color_id', 'created_at', 'updated_at'], 'integer'],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::class, 'targetAttribute' => ['color_id' => 'id']],
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
            'color_id'   => 'Color ID',
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
            TimestampBehavior::class
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(Color::class, ['id' => 'color_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
