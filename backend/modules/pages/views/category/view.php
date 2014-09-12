<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\pages\models\Category */


$this->title = Yii::t('pages', 'Категория') .' - '. $model->title;
$this->params['breadcrumbs'][] = ['label' => '<i class="fa  fa-files-o"></i> Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = '<i class="fa  fa-files-o"></i> ' . $this->title;
$this->params['subtitle'] = $this->title;
?>
<div class="pages-view">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'parent_id',
            'alias',
            [
                'attribute' => 'view',
                'value' => $model->PageView
            ],
            [
                'attribute' => 'position',
                'value' => $model->CategoryPosition
            ],
            [
                'attribute' => 'status',
                'value' => $model->CategoryStatus
            ],
            [
                'attribute' => 'created',
                'format' => ['date', 'd.m.Y']
            ],
            [
                'attribute' => 'updated',
                'format' => ['date', 'd.m.Y']
            ],
            'meta_title',
            'meta_keywords',
            'meta_description',
        ],
    ]) ?>

</div>
