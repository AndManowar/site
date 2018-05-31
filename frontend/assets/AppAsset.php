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
    public $jsOptions = ['position' => View::POS_HEAD];
    public $css = [
        'css/style.css',
        'css/animate.min.css',
    ];
    public $js = [
        'js/bootstrap.js',
        'js/modernizr.custom.js',
//        'js/simpleCart.min.js',
        'js/wow.min.js',
        'js/move-top.js',
        'js/easing.js',
        'js/jquery.countdown.min.js',
        'js/jquery.flexslider.js',
        'js/mainpage.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
