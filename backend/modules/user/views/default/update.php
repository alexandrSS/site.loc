<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\modules\user\models\User $model
 */

$this->title = Yii::t('user', 'Обновление пользователя') . ' - "' . $model->username . '"';
$this->params['breadcrumbs'][] = ['label' => '<i class="fa  fa-group"></i> Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = '<i class="fa  fa-user"></i> ' . $this->title;
$this->params['breadcrumbs'][] = ['label' => '<i class="fa  fa-user"></i> ' . $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['subtitle'] = $this->title;
?>
<div class="user-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
        'roleArray' => $roleArray,
        'statusArray' => $statusArray
    ]) ?>

</div>
