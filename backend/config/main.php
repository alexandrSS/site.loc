<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name' => 'Yii2-Demo',
    'language' => 'ru',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'admin/default/index',
    'bootstrap' => ['log'],
    'components' => [
        'request'=>[
            'baseUrl' => '/backend',
            'cookieValidationKey' => '!2k%ZE0Rl;0*BPEnTavЗczj№CEZlKuH6hS%',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'admin/default/error',
        ],
        'urlManager' => [
            'rules' => [
                // Модуль [[Admin]]
                '' => 'admin/default/index',

                // Модуль [[Users]]
                '<_a:(login|logout)>' => 'user/<_a>',

                // Модуль [[Pages]]
                'category'=>'pages/category/index',
                'pages'=>'pages/pages/index',


                // Общие правила
                '<_m:[\w\-]+>/<_sm:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_m>/<_sm>/<_c>/<_a>',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_m>/<_c>/<_a>',
            ]
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@backend/views' => '@backend/themes/admin/views',
                    '@backend/modules' => '@backend/themes/admin/modules'
                ]
            ]
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => '@backend/themes/admin',
                    'css' => [
                        'css/bootstrap.min.css'
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => '@backend/themes/admin',
                    'js' => [
                        'js/bootstrap.min.js'
                    ]
                ]
            ]
        ],
        'i18n' => [
            'translations' => [
                'user' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'ru',
                    'basePath' => '@backend/modules/user/messages',
                ],
                'admin' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'ru',
                    'basePath' => '@backend/modules/admin/messages',
                ],
                'pages' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'ru',
                    'basePath' => '@backend/modules/pages/messages',
                ],
                'u' => [
                    'class' => 'backend\modules\u\Module',
                ],
            ]
        ]
    ],
    'modules' => [
        'admin' => [
            'class' => 'backend\modules\admin\Admin',
        ],
        'user' => [
            'class' => 'backend\modules\user\User',
        ],
        'pages' => [
            'class' => 'backend\modules\pages\Pages',
        ],
    ],
    'params' => $params,
];
