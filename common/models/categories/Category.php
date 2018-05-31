<?php

namespace common\models\categories;

use common\models\AppActiveRecord;
use paulzi\adjacencyList\AdjacencyListBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

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
 * @property int $parent_id
 * @property boolean $sort
 * @property int $created_at
 * @property int $updated_at
 *
 *
 * @method Category makeRoot();
 * @method bool deleteWithChildren();
 * @method string getImageFileUrl(string $fileName);
 * @method Category appendTo($model);
 */
class Category extends AppActiveRecord
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
        return '{{%categories}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            AdjacencyListBehavior::class,
            [
                'class'     => ImageUploadBehavior::class,
                'attribute' => 'file',
                'filePath'  => '@categoryImagePath/[[filename]].[[extension]]',
                'fileUrl'   => '[[filename]].[[extension]]',
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
            'parent_id'        => 'Parent',
            'sort'             => 'Sort',
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

        return ArrayHelper::map($query->all(), 'id', 'name');
    }

    /**
     * Get first available root for dropdown
     *
     * @return integer
     */
    public static function getDefaultRootValue()
    {
        return self::find()->roots()->one()->id;
    }

    /**
     * @return bool
     */
    public function isRoot()
    {
        return self::find()->roots()->andWhere(['id' => $this->id])->exists();
    }
}
