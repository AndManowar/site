<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 03.06.2018
 * Time: 13:41
 */

namespace common\components\behaviors;

use yii\base\Behavior;
use yii\base\InvalidArgumentException;
use yii\db\ActiveRecord;

/**
 * Class ImageManagerBehavior
 * @package common\components\behaviors
 *
 * @property ActiveRecord $owner
 */
class ImageManagerBehavior extends Behavior
{
    /**
     * Field with path to image
     *
     * @var string
     */
    public $image = 'image';

    /**
     * Field with currently uploaded file
     *
     * @var string
     */
    public $file = 'file';

    public $directoryPath;

    /**
     * @throws InvalidArgumentException
     */
    public function init()
    {
        if (!$this->directoryPath) {
            throw new InvalidArgumentException("Directory Path must be set");
        }
    }

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_VALIDATE => 'removeChangedImage',
            ActiveRecord::EVENT_BEFORE_DELETE  => 'removeImageAfterDelete',
        ];
    }

    /**
     * @param string $fileName
     * @return void
     */
    public function removeImage($fileName)
    {
        if (is_file($fileName) && file_exists($fileName)) {
            unlink($fileName);
        }
    }

    /**
     * Remove old image if new image is given
     *
     * @return void
     */
    public function removeChangedImage()
    {
        if (!$this->owner->isNewRecord && $this->owner->{$this->file}) {
            $this->removeImage($this->directoryPath.'/'.$this->owner->oldAttributes[$this->image]);
        }
    }

    /**
     * Remove file after delete
     */
    public function removeImageAfterDelete()
    {
        $this->removeImage($file = $this->directoryPath.'/'.$this->owner->{$this->image});
    }
}