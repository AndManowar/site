<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 29.05.2018
 * Time: 17:56
 */

namespace common\models\forms;

use common\models\categories\Category;
use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * Class CategoryForm
 * @package common\models\forms
 *
 * @property string $previewImage
 */
class CategoryForm extends Model
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
     * @var UploadedFile
     */
    public $file;

    /**
     * @var string
     */
    public $caption;

    /**
     * @var string
     */
    public $description_text;

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
    public $active;

    /**
     * @var Category
     */
    private $category;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = [
            [['name', 'alias', 'description_text', 'caption', 'title', 'keywords', 'description'], 'required', 'message' => 'Поле необходимо к заполнению'],
            ['active', 'boolean'],
            ['alias', 'unique', 'targetClass' => Category::class, 'filter' => !$this->category->isNewRecord ? ['!=', 'id', $this->category->id] : null],
            ['alias', 'match', 'pattern' => '/^[A-Za-z]*$/u', 'message' => 'Разрешен ввод только латиницей'],
            ['file', 'file', 'maxFiles' => 1, 'mimeTypes' => 'image/*', 'skipOnEmpty' => true],
            [['description_text'], 'string'],
            [['name', 'alias', 'caption', 'title', 'keywords', 'description'], 'string', 'max' => 255],
        ];

        if (!$this->category->image) {
            $rules[] = [['file'], 'required'];
        }

        return $rules;
    }

    /**
     * @return array
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
            'active'           => 'Активная?',
        ];
    }

    /**
     * CategoryForm constructor.
     * @param null $id
     * @param array $config
     * @throws NotFoundHttpException
     */
    public function __construct($id = null, array $config = [])
    {
        $this->category = $this->getCategory($id);

        parent::__construct($config);
    }

    /**
     * @param null $id
     * @return Category
     * @throws NotFoundHttpException
     */
    public function getCategory($id = null)
    {
        if ($id == null) {
            return new Category();
        }

        $category = Category::findOneStrictException($id);
        $this->setAttributes($category->getAttributes(), false);

        return $category;
    }

    /**
     * @return bool
     */
    public function create()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->category->setAttributes($this->attributes, false);
        $this->setUploadedImage();

        return $this->category->makeRoot();
    }

    /**
     * @return bool
     */
    public function update()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->category->setAttributes($this->attributes, false);
        $this->setUploadedImage();

        return $this->category->save();
    }

    /**
     * @return false|int
     */
    public function delete()
    {
        return $this->category->delete();
    }

    /**
     * @return string
     */
    public function getPreviewImage()
    {
        return Yii::getAlias('@categoryImagePreviewPath/') . $this->category->image;
    }

    /**
     * @return bool
     */
    public function hasImage()
    {
        return $this->category->image != '';
    }

    /**
     * Set uploaded image name to model
     */
    private function setUploadedImage()
    {
        if ($this->file) {
            $this->category->file = $this->file;
            $this->category->image = $this->category->getImageFileUrl('file');
        }
    }

}