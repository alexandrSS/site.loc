<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\SerialColumn;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\user\models\UserSearch $searchModel
 */


$this->title = Yii::t('user', 'Пользователи');
$this->params['breadcrumbs'][] = '<i class="fa  fa-group"></i> ' . $this->title;
$this->params['subtitle'] = Yii::t('user', 'Список Пользователей');
?>
<div class="user-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr>
    <p>
        <?= Html::a(Yii::t('user', 'Создать Пользователя'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'id' => 'user-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => CheckboxColumn::classname()
            ],
            [
                'class' => SerialColumn::className(),
            ],

            [
                'attribute' => 'username',
                'format' => 'html',
                'value' => function ($model) {
                        return Html::a($model['username'], ['view', 'id' => $model['id']]);
                    }
            ],
            'email',
            [
                'attribute' => 'role',
                'value' => function ($model) {
                        return $model->Role;
                    },
                'filter' => Html::activeDropDownList($searchModel, 'role', $roleArray, ['class' => 'form-control', 'prompt' => Yii::t('user', 'Роль')])
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                        if ($model->status === $model::STATUS_ACTIVE) {
                            $class = 'label-success';
                        } elseif ($model->status === $model::STATUS_INACTIVE) {
                            $class = 'label-warning';
                        } else {
                            $class = 'label-danger';
                        }

                        return '<span class="label ' . $class . '">' . $model->Status . '</span>';
                    },
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'status',
                        $statusArray,
                        ['class' => 'form-control', 'prompt' => Yii::t('user', 'Выберите статус')]
                    )
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'd.m.Y']
            ],
            //'updated_at',

            [
                'class' => ActionColumn::className(),
                'header' => Yii::t('user', 'Управление'),
            ]
        ],
    ]); ?>

</div>
