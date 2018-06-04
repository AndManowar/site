<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 04.06.18
 * Time: 14:21
 */

namespace common\models\categories;

use common\components\behaviors\ImageManagerBehavior;
use common\components\tree\models\Tree;
use common\components\tree\TreeView;
use creocoder\nestedsets\NestedSetsBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class Category
 * @package common\models\categories
 * @property int $id [int(11)]
 * @property string $name [varchar(255)]
 * @property string $alias [varchar(255)]
 * @property string $caption [varchar(255)]
 * @property string $image [varchar(255)]
 * @property string $description_text
 * @property string $title [varchar(255)]
 * @property string $keywords [varchar(255)]
 * @property string $description [varchar(255)]
 * @property int $root [int(11)]
 * @property int $lft [int(11)]
 * @property int $rgt [int(11)]
 * @property int $lvl [int(11)]
 * @property bool $active [tinyint(1)]
 * @property bool $selected [tinyint(1)]
 * @property bool $disabled [tinyint(1)]
 * @property bool $readonly [tinyint(1)]
 * @property bool $visible [tinyint(1)]
 * @property bool $icon_type [tinyint(1)]
 * @property string $icon [varchar(255)]
 * @property bool $collapsed [tinyint(1)]
 * @property bool $movable_u [tinyint(1)]
 * @property bool $movable_d [tinyint(1)]
 * @property bool $movable_l [tinyint(1)]
 * @property bool $movable_r [tinyint(1)]
 * @property bool $removable [tinyint(1)]
 * @property bool $removable_all [tinyint(1)]
 * @property int $created_at [int(11)]
 * @property int $updated_at [int(11)]
 *
 * @method bool makeRoot();
 * @method string getImageFileUrl($filename);
 */
class Category extends Tree
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'name'       => 'Категория',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        $module = TreeView::module();
        $settings = ['class' => NestedSetsBehavior::class] + $module->treeStructure;

        $behaviors = [
            TimestampBehavior::class,
            [
                'class'     => ImageUploadBehavior::class,
                'attribute' => 'file',
                'filePath'  => '@colorImagePath/[[filename]].[[extension]]',
                'fileUrl'   => '[[filename]].[[extension]]',
            ],
            [
                'class'         => ImageManagerBehavior::class,
                'file'          => 'file',
                'image'         => 'image',
                'directoryPath' => Yii::getAlias('@colorImagePath'),
            ],
        ];

        return array_merge(empty($module->treeBehaviorName) ? [$settings] : [$module->treeBehaviorName => $settings], $behaviors);
    }
}