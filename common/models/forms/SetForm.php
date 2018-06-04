<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 03.06.2018
 * Time: 17:44
 */

namespace common\models\forms;

use common\models\products\Product;
use common\models\sets\Set;
use common\models\sets\SetProduct;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * Class SetForm
 * @package common\models\forms
 */
class SetForm extends Model
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $alias;

    /**
     * @var string
     */
    public $description_text;

    /**
     * @var string
     */
    public $caption;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $keywords;

    /**
     * @var string
     */
    public $description;

    /**
     * @var boolean
     */
    public $is_shown;

    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * @var Set
     */
    public $set;

    /**
     * @var string
     */
    public $errorsMessage;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
            ['alias', 'match', 'pattern' => '/[A-Za-z]/i', 'message' => 'Разрешен ввод только латиницей'],
            [['description_text'], 'string'],
            [['is_shown'], 'boolean'],
            ['file', 'file', 'mimeTypes' => 'image/*'],
            [['name', 'alias', 'caption', 'title', 'keywords', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => 'ID',
            'name'             => 'Наименование',
            'alias'            => 'Alias',
            'file'             => 'Изображение',
            'description_text' => 'Описание',
            'caption'          => 'Заголовок h1',
            'title'            => 'Title',
            'keywords'         => 'Keywords',
            'description'      => 'Description',
            'is_shown'         => 'Отображение',
        ];
    }

    /**
     * Set model by id or create new
     *
     * @param null|integer $id
     */
    public function setModel($id = null)
    {
        $this->set = Set::findOrCreateStrictException($id);

        if (!$this->set->isNewRecord) {
            $this->setAttributes($this->set->getAttributes(), false);
        }
    }

    /**
     * @return bool
     */
    public function create()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->set->setAttributes($this->getAttributes(), false);
        $this->setUploadedImage();

        return $this->set->save();
    }

    /**
     * @return bool
     */
    public function update()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->set->setAttributes($this->getAttributes(), false);
        $this->setUploadedImage();

        return $this->set->save();
    }

    /**
     * @return false|int
     */
    public function delete()
    {
        return $this->set->delete();
    }

    /**
     * Add product to set
     *
     * @param array $attributes
     * @return bool
     */
    public function addProductToSet(array $attributes)
    {
        $setItem = new SetProduct();

        if (!$setItem->load($attributes)) {
            $this->errorsMessage = 'Не удается добавить товар';

            return false;
        }

        $oldSetItem = SetProduct::find()->where(['set_id' => $setItem->set_id])->andWhere(['product_id' => $setItem->product_id])->one();

        if ($oldSetItem) {
            $oldSetItem->quantity += $setItem->quantity;

            if (!$oldSetItem->save()) {
                $this->errorsMessage = 'Не удается добавить количество товаров к существующей позиции подборки';

                return false;
            }
        } else {
            if (!$setItem->save()) {
                $this->errorsMessage = 'Произошла ошибка во время добавления товара';

                return false;
            }
        }

        return true;
    }

    public function removeProductFromSet()
    {

    }

    /**
     * @return array
     */
    public function getActiveProducts()
    {
        return ArrayHelper::map(Product::find()->where(['is_shown' => true])->all(), 'id', 'name');
    }

    /**
     * Set uploaded image name to model
     */
    private function setUploadedImage()
    {
        if ($this->file) {
            $this->set->file = $this->file;
            $this->set->image = $this->set->getImageFileUrl('file');
        }
    }
}