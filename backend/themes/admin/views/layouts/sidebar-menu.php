<?php

/**
 * Sidebar menu layout.
 *
 * @var \yii\web\View $this View
 */

use backend\themes\admin\widgets\Menu;

echo Menu::widget(
    [
        'options' => [
            'class' => 'sidebar-menu'
        ],
        'items' => [
            [
                'label' => Yii::t('admin', 'Панель управления'),
                'url' => Yii::$app->homeUrl,
                'icon' => 'fa-dashboard',
                'active' => Yii::$app->request->url === Yii::$app->homeUrl
            ],
            [
                'label' => Yii::t('admin', 'Пользователи'),
                'url' => ['/user/default/index'],
                'icon' => 'fa-group'
            ],
            [
                'label' => Yii::t('admin', 'Содержание сайта'),
                'url' => ['/#'],
                'icon' => 'fa-book',
                'iconLeft' => 'fa-book fa-angle-left',
                'options' => ['class' => 'treeview'],
                'items' => [
                    [
                        'label' => Yii::t('admin', 'Категории'),
                        'url' => ['/category'],
                        'icon' => 'fa-files-o',
                    ],
                    [
                        'label' => Yii::t('admin', 'Страницы'),
                        'url' => ['/pages'],
                        'icon' => 'fa-file-text',
                    ],
                ]
            ]
        ]
    ]
);