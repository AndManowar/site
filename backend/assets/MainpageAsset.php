<?php
/**
 * Created by PhpStorm.
 * User: manowartop
 * Date: 25.04.18
 * Time: 11:15
 */

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class MainpageAsset
 * @package backend\assets
 */
class MainpageAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $baseUrl = '@web/style';

    /**
     * @var string
     */
    public $sourcePath = '@webroot/style';

    /**
     * @var array
     */
    public $jsOptions = ['position' => View::POS_BEGIN];

    /**
     * @var array
     */
    public $css = [
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/smartadmin-production-plugins.min.css',
        'css/smartadmin-production.min.css',
        'css/smartadmin-skins.min.css',
        'css/smartadmin-rtl.min.css',
        'css/demo.min.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'js/plugin/jquery-touch/jquery.ui.touch-punch.min.js',
        'js/plugin/bootstrap-slider/bootstrap-slider.min.js',
        'js/plugin/msie-fix/jquery.mb.browser.min.js',
        'js/plugin/fastclick/fastclick.min.js',
        'js/plugin/flot/jquery.flot.cust.min.js',
        'js/plugin/flot/jquery.flot.resize.min.js',
        'js/plugin/flot/jquery.flot.time.min.js',
        'js/plugin/flot/jquery.flot.tooltip.min.js',
        'js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js',
        'js/plugin/vectormap/jquery-jvectormap-world-mill-en.js',
        'js/plugin/moment/moment.min.js',
        'js/plugin/fullcalendar/fullcalendar.min.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}