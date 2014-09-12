<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\pages\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'parent_id')->dropDownList($categoryArray, [
        'prompt' => Yii::t('pages', 'Выберите категорию')
    ]); ?>

    <?= $form->field($model, 'view')->dropDownList($viewArray, [
        'prompt' => Yii::t('pages', 'Выберите вид страницы')
    ]) ?>

    <?= $form->field($model, 'position')->dropDownList($positionArray, [
        'prompt' => Yii::t('pages', 'Выберите позицию категории')
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList($statusArray, [
        'prompt' => Yii::t('pages', 'Выберите статус категории')
    ]) ?>

    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('user', 'Создать') : Yii::t('yii', 'Сохранить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
