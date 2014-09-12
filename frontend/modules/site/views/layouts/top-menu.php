<?php
/*
 * Верхнее меню frontend приложения
 * */

use yii\bootstrap\Nav;

$menuItems = [
    [
        'label' => Yii::t('site', 'Главная'),
        'url' => ['/']
    ],
    [
        'label' => Yii::t('site', 'О нас'),
        'url' => ['/about']
    ],
    [
        'label' => Yii::t('site', 'Обратная связь'),
        'url' => ['/contact']
    ],
];
if (Yii::$app->user->can(3)) {
    $menuItems[] = [
        'label' => Yii::t('site', 'Панель управления'),
        'url' => ['/backend']
    ];
}

if (Yii::$app->user->isGuest) {
    $menuItems[] = [
        'label' => Yii::t('site', 'Регистрация'),
        'url' => ['/signup']
    ];
    $menuItems[] = [
        'label' => Yii::t('site', 'Вход'),
        'url' => ['/login']
    ];
} else {
    $menuItems[] = [
        'label' => Yii::$app->user->identity->username . ' - ' . Yii::t('site', 'Личный кабинет'),
        'items' => [
            [
                'label' => Yii::t('site', 'Редактировать личные данные'),
                'url' => ['/edit']
            ]
        ],
    ];
    $menuItems[] = [
        'label' => Yii::t('site', 'Выйти'),
        'url' => ['/logout'],
        'linkOptions' => ['data-method' => 'post']
    ];
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);