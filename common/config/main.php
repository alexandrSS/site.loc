<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'sourceLanguage' => 'en',
    'language' => 'ru',
    'charset' => 'utf-8',
    'timeZone' => 'Europe/Moscow',
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'suffix' => '/'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\modules\user\models\User',
            'loginUrl' => ['/login']
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => [
                'guest'.
                0, // User
                1, // Administrator
                2, // Super Administrator
                3, // Moderator
            ],
            'itemFile' => '@common/rbac/items.php',
            'assignmentFile' => '@common/rbac/assignments.php',
            'ruleFile' => '@common/rbac/rules.php',
        ],
        'components.mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mails'
        ],
        'i18n' => [
            'translations' => [
                'category' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'ru',
                    'basePath' => '@common/modules/category/messages',
                ],
                'pages' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'ru',
                    'basePath' => '@common/modules/pages/messages',
                ],
            ]
        ]
    ],
    'modules' => [
        'user' => [
            'class' => 'common\modules\user\User',
        ],
        'pages' => [
            'class' => 'common\modules\pages\Pages',
        ],
    ],
];
