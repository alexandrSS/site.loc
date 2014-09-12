<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\pages\models\Pages */

$this->title = Yii::t('pages', 'Редактирование страницы - ' . $model->title);
$this->params['control'] = [
    'brandLabel' => 'Страницы'
];
?>
<div class="base-pages-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'statusArray' => $statusArray,
        'categoryArray' => $categoryArray,
    ]) ?>

</div>
