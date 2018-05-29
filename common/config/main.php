<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases'    => [
        '@bower'      => '@vendor/bower-asset',
        '@npm'        => '@vendor/npm-asset',
    ],
    'components' => [
        'language' => 'ru-RU', //
        'cache'    => [
            'class' => 'yii\caching\FileCache',
        ],
        'handbook' => [
            'class' => 'common\components\handbook\Main',
        ],

        'settings'    => [
            'class' => 'common\components\settings\Main',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

        'accessControl' => [
            'class'   => 'common\components\rbac\Main',
            'branches' => [
                ['b', '@backend/controllers', 'Админ панель', '\backend\controllers'],
                ['f', '@frontend/controllers', 'Публичная часть', '\frontend\controllers'],
            ],
        ],
    ],
];
