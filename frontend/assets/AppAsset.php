<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $baseUrl = '@web/style';
    public $sourcePath = '@webroot/style';
    public $jsOptions = ['position' => View::POS_END];
    public $css = [
        'css/style.min.css'
    ];
    public $js = [
        'js/commons.js',
        'js/app.js',
        'js/gallery.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
