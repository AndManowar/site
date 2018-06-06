<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
return [
    'id'                  => 'app-frontend',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'modules'             => [
        'treemanager' => [
            'class' => '\common\components\tree\Module',
        ],
    ],
    'language'            => 'ru-RU',
    'controllerNamespace' => 'frontend\controllers',
    'components'          => [
        'request'      => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl'   => '',
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                ''                                           => 'site',
                '<controller:\w+>/<action:\w+>/<id:\d+>/'    => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<alias:\w+>/' => '<controller>/<action>',
                'product/<id:\d+>'                           => 'product/detail',
                'catalog'                                   => 'catalog/index',
            ],
        ],
        'user'         => [
            'identityClass'   => 'common\models\users\User',
            'enableAutoLogin' => true,
            'identityCookie'  => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session'      => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'class'     => 'yii\web\AssetManager',
            'forceCopy' => true,
        ],
    ],
    'params'              => $params,
];