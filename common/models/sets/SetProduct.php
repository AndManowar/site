<?php

namespace common\models\sets;

use common\models\AppActiveRecord;
use common\models\products\Product;

/**
 * This is the model class for table "products_sets".
 *
 * @property int $id
 * @property int $product_id
 * @property int $set_id
 * @property int $quantity
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Set $set
 * @property Product $product
 */
class SetProduct extends AppActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%products_sets}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'set_id'], 'required'],
            [['product_id', 'set_id', 'quantity', 'created_at', 'updated_at'], 'integer'],
            [['set_id'], 'exist', 'skipOnError' => true, 'targetClass' => Set::class, 'targetAttribute' => ['set_id' => 'id']],
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
            'product_id' => 'Товар',
            'set_id'     => 'Set ID',
            'quantity'   => 'Количество',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSet()
    {
        return $this->hasOne(Set::class, ['id' => 'set_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
