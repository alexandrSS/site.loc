<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\pages\models\Category */


$this->title = Yii::t('pages', 'Обновление категории') . ' - "' . $model->title . '"';
$this->params['breadcrumbs'][] = ['label' => '<i class="fa  fa-files-o"></i> Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = '<i class="fa  fa-files-o"></i> ' . $this->title;
$this->params['breadcrumbs'][] = ['label' => '<i class="fa  fa-files-o"></i> ' . $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['subtitle'] = $this->title;
?>
<div class="pages-update">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr>

    <?= $this->render('_form', [
        'model' => $model,
        'categoryArray' => $categoryArray,
        'viewArray' => $viewArray,
        'positionArray' => $positionArray,
        'statusArray' => $statusArray,
    ]) ?>

</div>
