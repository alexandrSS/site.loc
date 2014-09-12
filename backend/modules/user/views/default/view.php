<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\modules\user\models\User $model
 */

$this->title = Yii::t('user', 'Пользователь') .' - '. $model->username;
$this->params['breadcrumbs'][] = ['label' => '<i class="fa  fa-group"></i> Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = '<i class="fa  fa-user"></i> ' . $this->title;
$this->params['subtitle'] = $this->title;
?>
<div class="user-view">

    <h2><?= Html::encode($this->title) ?></h2>
    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            [
                'attribute' => 'role',
                'value' => $model->Role,
            ],
            [
                'attribute' => 'status',
                'value' => $model->Status
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'd.m.Y']
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'd.m.Y']
            ],
        ],
    ]) ?>

</div>
