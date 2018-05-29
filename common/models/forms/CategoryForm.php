<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 29.05.2018
 * Time: 17:56
 */

namespace common\models\forms;

use common\models\categories\Category;
use yii\base\Model;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class CategoryForm
 * @package common\models\forms
 * @method string getImageFileUrl(string $fileName);
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
    public $tree_id = 0;

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
            [['name', 'alias'], 'required'],
            ['is_root', 'boolean'],
            ['tree_id', 'integer'],
            ['alias', 'unique', 'targetClass' => Category::class, 'filter' => !$this->category->isNewRecord ? ['!=', 'id', $this->category->id] : null],
            ['file', 'file', 'maxFiles' => 1, 'mimeTypes' => 'image/*'],
            [['description_text'], 'string'],
            [['is_root', 'tree_id'], function ($attribute) {
                if (!$this->is_root && $this->tree_id == 0) {
                    $this->addError($attribute, 'Необходимо выбрать конфигурацию категории');
                }
            }],
            [['name', 'alias', 'caption', 'title', 'keywords', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class'     => ImageUploadBehavior::class,
                'attribute' => 'file',
                'filePath'  => '@webroot/uploads/images/[[pk]].[[extension]]',
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
            'tree'             => 'Tree',
            'lft'              => 'Lft',
            'rgt'              => 'Rgt',
            'depth'            => 'Depth',
            'is_root'          => 'Позиция в дереве',
        ];
    }

    /**
     * CategoryForm constructor.
     * @param null $id
     * @param array $config
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
        $this->tree_id = $category->tree;
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
     * Set uploaded image name to model
     */
    private function setUploadedImage()
    {
        $this->file = UploadedFile::getInstance($this, 'file');
        $this->category->image = $this->getImageFileUrl('file');
    }

    /**
     * @throws BadRequestHttpException
     * @return boolean
     */
    private function setToTree()
    {
        if (!$this->is_root && $this->tree_id == 0) {
            throw new BadRequestHttpException('Invalid tree configuration');
        }

        if ($this->is_root) {
            return $this->category->makeRoot();
        }

        $parent = Category::find()->roots()->where(['tree' => $this->tree_id])->one();

        return $this->category->appendTo($parent);
    }
}