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
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * Class CategoryForm
 * @package common\models\forms
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
    public $is_root = true;

    /**
     * @var int
     */
    public $root;

    /**
     * @var Category
     */
    private $category;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'alias', 'description_text', 'caption', 'title', 'keywords', 'description'], 'required', 'message' => 'Поле необходимо к заполнению'],
            ['is_root', 'boolean'],
            ['root', 'integer'],
            ['alias', 'unique', 'targetClass' => Category::class, 'filter' => !$this->category->isNewRecord ? ['!=', 'id', $this->category->id] : null],
            ['alias', 'match', 'pattern' => '/[A-Za-z]/i', 'message' => 'Разрешен ввод только латиницей'],
            ['file', 'file', 'maxFiles' => 1, 'mimeTypes' => 'image/*', 'skipOnEmpty' => true],
            [['description_text'], 'string'],
            [['name', 'alias', 'caption', 'title', 'keywords', 'description'], 'string', 'max' => 255],
        ];
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
            'level'            => 'Level',
            'lft'              => 'Lft',
            'rgt'              => 'Rgt',
            'depth'            => 'Depth',
            'is_root'          => 'Сделать корневым элементом?',
            'root'             => 'Родительский элемент',
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

        if (!$this->category->isNewRecord && !$this->category->isRoot()) {
            $this->is_root = false;
        }

        if (!$this->is_root) {
            $this->root = Category::getDefaultRootValue();
        }

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
     * @throws BadRequestHttpException
     */
    public function create()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->setUploadedImage();
        $this->category->setAttributes($this->attributes, false);

        return $this->setToTree();
    }

    /**
     * @return bool
     */
    public function update()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->setUploadedImage();
        $this->category->setAttributes($this->attributes, false);

        return $this->category->save();
    }

    /**
     * @return false|int
     */
    public function delete()
    {
        return $this->category->deleteWithChildren();
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
        $this->category->file = UploadedFile::getInstance($this, 'file');
        if ($this->category->file) {
            $this->category->image = $this->category->getImageFileUrl('file');
        }
    }

    /**
     * Set category to tree on create or update
     *
     * @return boolean
     * @throws BadRequestHttpException
     */
    private function setToTree()
    {
        if (!$this->is_root && $this->root <= 0) {
            throw new BadRequestHttpException('Element must be a root or a child of some tree');
        }

        if (!$this->is_root && $this->root > 0) {
            $parent = Category::find()->roots()->where(['id' => $this->root])->one();
            return $this->category->appendTo($parent)->save();
        }

        return $this->category->makeRoot()->save();
    }
}