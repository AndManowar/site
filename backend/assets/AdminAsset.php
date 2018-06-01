<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class AdminAsset extends AssetBundle
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
        'js/app.config.js',
        'js/notification/SmartNotification.min.js',
        'js/smartwidgets/jarvis.widget.min.js',
        'js/demo.min.js',
        'js/app.min.js',
        'js/main.js',
        'js/scan-js.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
