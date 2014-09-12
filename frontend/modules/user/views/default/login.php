<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var \common\modules\user\models\LoginForm $model
 */
$this->title = Yii::t('user', 'Авторизация') . ' / ' . Yii::$app->name;
?>
<div class="site-login">
    <h1><?= Yii::t('user', 'Авторизация') ?></h1>

    <p> <?= Yii::t('user', 'Пожалуйста, заполните следующие поля для входа:') ?> </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div style="color:#999;margin:1em 0">
                     <?=  Yii::t('user','Если Вы забыли пароль его можно') .' '. Html::a(Yii::t('user', 'восстановить'), ['site/request-password-reset']) ?>.
                </div>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('user', 'Войти'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
