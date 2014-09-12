<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\pages\models\Pages */

$this->title = Yii::t('pages', 'Страница - ') . $model->title;
$this->params['control'] = [
    'brandLabel' => Yii::t('pages', 'Страницы'),
    'modelId' => $model['id']
];
?>
<div class="base-pages-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category_id',
            'title',
            'alias',
            'author_id',
            'snippet:ntext',
            'content:ntext',
            [
                'attribute' => 'status',
                'value' => $model->PagesStatus
            ],
            [
                'attribute' => 'created',
                'format' => ['date', 'H:m d.m.Y']
            ],
            [
                'attribute' => 'updated',
                'format' => ['date', 'H:m d.m.Y']
            ],
            'meta_title',
            'meta_description',
            'meta_keywords',
        ],
    ]) ?>

</div>
