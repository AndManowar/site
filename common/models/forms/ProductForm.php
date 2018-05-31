<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 31.05.18
 * Time: 13:31
 */

namespace common\models\forms;

use common\models\products\Product;
use common\models\products\ProductImage;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class ProductForm
 * @package common\models\forms
 */
class ProductForm extends Model
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var double
     */
    public $price;

    /**
     * @var double
     */
    public $old_price;

    /**
     * @var double
     */
    public $width;

    /**
     * @var double
     */
    public $height;

    /**
     * @var double
     */
    public $thickness;

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
    public $title_file;

    /**
     * @var integer
     */
    public $category_id;

    /**
     * @var UploadedFile[]
     */
    public $files;

    /**
     * @var Product
     */
    public $product;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'width', 'height', 'thickness', 'caption', 'description', 'title', 'keywords', 'description_text', 'category_id', 'title_file'], 'required'],
            [['price', 'old_price', 'width', 'height', 'thickness'], 'number'],
            [['description_text'], 'string'],
            ['is_shown', 'boolean'],
            ['category_id', 'integer'],
            [['name', 'caption', 'title', 'keywords', 'description'], 'string', 'max' => 255],
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
            'title_image'      => 'Титульное изображение',
            'price'            => 'Цена',
            'old_price'        => 'Старая цена',
            'width'            => 'Ширина',
            'height'           => 'Высота',
            'thickness'        => 'Толщина',
            'description_text' => 'Описание',
            'title_file'       => 'Главное изображение',
            'files'            => 'Дополнительные изображения',
            'caption'          => 'Заголовок h1',
            'title'            => 'Title',
            'keywords'         => 'Keywords',
            'description'      => 'Description',
            'category_id'      => 'Категория',
            'is_shown'         => 'Отображение позиции',
            'created_at'       => 'Created At',
            'updated_at'       => 'Updated At',
        ];
    }

    /**
     * ProductForm constructor.
     * @param null $id
     * @param array $config
     * @throws \yii\web\NotFoundHttpException
     */
    public function __construct($id = null, array $config = [])
    {
        if ($id == null) {
            $this->product = new Product();
        } else {
            $this->product = Product::findOneStrictException($id);
            $this->setAttributes($this->product->getAttributes(), false);
        }

        parent::__construct($config);
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function create()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->setUploadedImage();
        $this->product->setAttributes($this->getAttributes(), false);

        $transaction = Yii::$app->db->beginTransaction();

        if (!$this->product->save()) {
            $transaction->rollBack();
        }

        if (!$this->setAdditionalImages()) {
            $transaction->rollBack();
        }

        $transaction->commit();
        return true;
    }

    public function update()
    {
        return true;
    }

    /**
     * @return array
     */
    public function getPreview()
    {
        $images = [];

        $images['title'] = Yii::getAlias('@productImagePreviewPath/') . $this->product->title_image;

        foreach ($this->product->productsImages as $productImage) {
            $images['additional'][] = Yii::getAlias('@productImagePreviewPath/') . $productImage->image;
        }

        return $images;
    }

    /**
     * @return array
     */
    public function buildSortable()
    {
        $result = [];

        foreach ($this->product->productsImages as $productImage){
            $result[]['content'] = "<img src='{$productImage->getPreview()}'>";
        }

        return $result;
    }

    /**
     * @return void
     */
    private function setUploadedImage()
    {
        if ($this->title_file) {
            $this->product->file = $this->title_file;
            $this->product->title_image = $this->product->getImageFileUrl('file');
        }
    }

    /**
     * @return bool
     */
    private function setAdditionalImages()
    {
        if ($this->files) {

            foreach ($this->files as $file) {

                $image = new ProductImage([
                    'product_id' => $this->product->id,
                    'file'       => $file,
                ]);

                $image->image = $image->getImageFileUrl('file');
                if (!$image->save()) {
                    return false;
                }
            }
        }

        return true;
    }
}