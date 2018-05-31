<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 13.03.2018
 * Time: 23:09
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class ProductsAsset
 * @package frontend\assets
 */
class ProductsAsset extends AssetBundle
{
    public $baseUrl = '@web/style';
    public $sourcePath = '@webroot/style';
    public $jsOptions = ['position' => View::POS_HEAD];
    public $css = [
        'css/flexslider1.css',
        'css/jquery-ui.css',
    ];
    public $js = [
        'js/main.js',
        'js/jquery-ui.js',
        '/js/main.js',
        'js/sweetalert2.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'frontend\assets\AppAsset'
    ];
}