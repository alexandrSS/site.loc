<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\pages\models\Category */

$this->title = Yii::t('user', 'Новая категория');
$this->params['breadcrumbs'][] = ['label' => '<i class="fa  fa-files-o"></i> Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = '<i class="fa  fa-plus"></i> ' . $this->title;
$this->params['subtitle'] = Yii::t('user', 'Список Категорий');
?>
<div class="pages-create">

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