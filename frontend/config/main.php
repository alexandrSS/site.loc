<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'name' => 'Site',
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'site/default/index',
    'layoutPath' => '@frontend/modules/site/views/layouts',
    'viewPath' => '@frontend/modules/site/views',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'site' => [
            'class' => 'frontend\modules\site\Site',
        ],
        'user' => [
            'class' => 'frontend\modules\user\User',
        ],
    ],
    'components' => [
        'request'=>[
            //'class' => 'common\components\Request',
            //'web'=> '/frontend/web',
            'baseUrl' => '',
            'cookieValidationKey' => '№:u)pWlQ"s0:isXHoNPGT):0;nOK)DojB*s'
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
            'errorAction' => 'site/default/error',
        ],
        'urlManager' => [
            'rules' => [
                // Модуль [[Site]]
                '' => 'site/default/index',
                '<_a:(about|contact|error|captcha)>' => 'site/default/<_a>',

                //Модуль [[User]]
                '<_a:(login|logout|signup|requestPasswordResetToken|resetPassword|edit)>' => 'user/default/<_a>',
            ]
        ],
        'i18n' => [
            'translations' => [
                'site' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'ru',
                    'basePath' => '@frontend/modules/site/messages',
                ],
                'user' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'ru',
                    'basePath' => '@frontend/modules/user/messages',
                ]
            ]
        ]
    ],
    'params' => $params,
];
