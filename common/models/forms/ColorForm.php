<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 31.05.18
 * Time: 13:37
 */

namespace common\models\forms;

use common\models\products\Color;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class ColorForm
 * @package common\models\forms
 */
class ColorForm extends Model
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $file;

    /**
     * @var Color
     */
    private $color;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Поле обязательно к заполнению'],
            ['file', 'file', 'mimeTypes' => 'image/*'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'file' => 'Изображение',
        ];
    }

    /**
     * ColorForm constructor.
     * @param null $id
     * @param array $config
     * @throws \yii\web\NotFoundHttpException
     */
    public function __construct($id = null, array $config = [])
    {
        if ($id == null) {
            $this->color = new Color();
        } else {
            $this->color = Color::findOneStrictException($id);
            $this->setAttributes($this->color->getAttributes(), false);
        }

        parent::__construct($config);
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
        $this->color->setAttributes($this->getAttributes(), false);

        return $this->color->save();
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
        $this->color->setAttributes($this->getAttributes(), false);

        return $this->color->save();
    }

    /**
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function delete()
    {
        return $this->color->delete();
    }

    /**
     * @return string
     */
    public function getPreviewImage()
    {
        return Yii::getAlias('@colorImagePreviewPath/') . $this->color->image;
    }

    /**
     * Set uploaded image name to model
     */
    private function setUploadedImage()
    {

        $this->color->file = UploadedFile::getInstance($this, 'file');
        if ($this->color->file) {
            $this->color->image = $this->color->getImageFileUrl('file');
        }
    }
}