<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\pages\models\Pages */

$this->title = Yii::t('pages', 'Новая Страница');
$this->params['breadcrumbs'][] = ['label' => '<i class="fa  fa-file-text"></i> Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = '<i class="fa  fa-plus"></i> ' . $this->title;
$this->params['subtitle'] = Yii::t('pages', 'Список Страниц');
?>
<div class="base-pages-create">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr>

    <?= $this->render('_form', [
        'model' => $model,
        'statusArray' => $statusArray,
        'categoryArray' => $categoryArray,
    ]) ?>

</div>
