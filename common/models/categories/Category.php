<?php

namespace common\models\categories;

use common\models\AppActiveRecord;
use creocoder\nestedsets\NestedSetsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 * @property string $caption
 * @property string $image
 * @property string $description_text
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property int $tree
 * @property boolean $is_root
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 * @property int $created_at
 * @property int $updated_at
 *
 * @method bool makeRoot();
 * @method bool appendTo($model);
 */
class Category extends AppActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%categories}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            'tree' => [
                'class'         => NestedSetsBehavior::class,
                'treeAttribute' => 'tree',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => 'ID',
            'name'             => 'Название',
            'alias'            => 'Alias',
            'caption'          => 'Заголовок h1',
            'image'            => 'Изображение',
            'description_text' => 'Описание',
            'title'            => 'Title',
            'keywords'         => 'Keywords',
            'description'      => 'Description',
            'tree'             => 'Tree',
            'lft'              => 'Lft',
            'rgt'              => 'Rgt',
            'is_root'          => 'Is Root',
            'depth'            => 'Depth',
            'created_at'       => 'Created At',
            'updated_at'       => 'Updated At',
        ];
    }

    /**
     * @return array
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @return CategoryQuery
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    /**
     * Get roots list
     *
     * @param null $id
     * @return array
     */
    public static function getRootList($id = null)
    {
        $query = self::find()->roots();

        if ($id != null) {
            $query->where(['!=', 'id', $id]);
        }

        return ArrayHelper::map($query->all(), 'tree', 'name');
    }
}
