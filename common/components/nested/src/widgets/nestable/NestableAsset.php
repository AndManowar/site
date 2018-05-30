<?php

namespace common\components\nested\src\widgets\nestable;

use yii\web\AssetBundle;

/**
 * Class NestableAsset
 * @package voskobovich\tree\manager\widgets
 */
class NestableAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@common/components/nested/src/widgets/nestable/assets';

    /**
     * @var array
     */
    public $css = [
        'jquery.nestable.css'
    ];

    /**
     * @var array
     */
    public $js = [
        'jquery.nestable.js'
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
    ];
}