<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\modules\user\models\User $model
 */

$this->title = Yii::t('user', 'Новый пользователь');
$this->params['breadcrumbs'][] = ['label' => '<i class="fa  fa-group"></i> Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = '<i class="fa  fa-plus"></i> ' . $this->title;
$this->params['subtitle'] = Yii::t('user', 'Список Пользователей');


?>
<div class="user-create">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr>

    <?= $this->render('_form', [
        'model' => $model,
        'roleArray' => $roleArray,
        'statusArray' => $statusArray
    ]) ?>

</div>
