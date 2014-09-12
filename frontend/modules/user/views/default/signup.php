<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = Yii::t('user', 'Регистрация') . ' / ' . Yii::$app->name;
?>
<div class="site-signup">
    <h1><?= Yii::t('user', 'Регистрация') ?></h1>

    <p> <?= Yii::t('user', 'Пожалуйста, заполните следующие поля для регистрации:') ?> </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'repassword')->passwordInput() ?>
                <div class="form-group">
                    <?= Html::submitButton((Yii::t('user', 'Регистрация')), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
