<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\pages\models\SearchPages */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('pages', 'Страницы');
$this->params['breadcrumbs'][] = '<i class="fa  fa-file-text"></i> ' . $this->title;
$this->params['subtitle'] = Yii::t('pages', 'Список Страниц');
?>
<div class="base-pages-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr>
    <p>
        <?= Html::a(Yii::t('user', 'Создать Страницу'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'category_id',
                'format' => 'html',
                'value' => function ($model) {
                        return Html::a($model->category['title'], ['/category/default/view', 'id' => $model->category['id']]);
                    }
            ],
            [
                'attribute' => 'author_id',
                'format' => 'html',
                'value' => function ($model) {
                        return Html::a($model->author['username'], ['/user/default/view', 'id' => $model->author['id']]);
                    }
            ],
            'title',
            //'alias',
            // 'snippet:ntext',
            // 'content:ntext',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                        return $model->PagesStatus;
                    },
                'filter' => Html::activeDropDownList($searchModel, 'status', $statusArray, ['class' => 'form-control', 'prompt' => Yii::t('pages', 'Статус')])
            ],
            // 'created',
            // 'updated',
            // 'meta_title',
            // 'meta_description',
            // 'meta_keywords',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
