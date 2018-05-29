<?php
$params = array_merge(
    require(__DIR__.'/../../common/config/params.php'),
    require(__DIR__.'/../../common/config/params-local.php'),
    require(__DIR__.'/params.php'),
    require(__DIR__.'/params-local.php')
);
return [
    'id'                  => 'app-backend',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap'           => ['log'],
    'modules'             => [
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
    ],
    'controllerMap'       => [
        'elfinder' => [
            'class'            => 'mihaildev\elfinder\PathController',
            'access'           => ['@'],
            'disabledCommands' => ['netmount'],
            'root'             => [
                'baseUrl' => '/uploads',
                'basePath'    => '@frontend/web/uploads',
                'name'    => 'Uploads',
            ],

        ],
    ],
    'components'          => [
        'request'      => [
            'csrfParam' => '_csrf-backend',
            'baseUrl'   => '/dashboard',
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                ''                                        => 'site/index',
                '<controller:\w+>/<action:\w+>/'          => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>/' => '<controller>/<action>',
            ],
        ],
        'user'         => [
            'identityClass'   => 'common\models\users\User',
            'enableAutoLogin' => true,
            'identityCookie'  => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session'      => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        //        'assetManager' => [
        //            'class'     => 'yii\web\AssetManager',
        //            'forceCopy' => true,
        //        ],
        'view'         => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@backend/views/layouts',
                ],
            ],
        ],
    ],
    'params'              => $params,
];