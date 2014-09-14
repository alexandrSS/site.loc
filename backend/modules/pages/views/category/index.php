<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use backend\modules\pages\models\Category;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\pages\models\SearchCategory */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('user', 'Категории');
$this->params['breadcrumbs'][] = '<i class="fa  fa-files-o"></i> ' . $this->title;
$this->params['subtitle'] = Yii::t('user', 'Список Категорий');
?>
<div class="pages-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr>
    <p>
        <?= Html::a(Yii::t('user', 'Создать Категорию'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            [
                'attribute' => 'parent_id',
                'value' => function ($model) {
                        return $model->ParentList;
                    },
                'filter' => Html::activeDropDownList($searchModel, 'view', $parentList, ['class' => 'form-control', 'prompt' => Yii::t('pages', 'Родитель')])
            ],
            'alias',
            [
                'attribute' => 'view',
                'value' => function ($model) {
                        return $model->PageView;
                    },
                'filter' => Html::activeDropDownList($searchModel, 'view', $viewArray, ['class' => 'form-control', 'prompt' => Yii::t('pages', 'Вид страницы')])
            ],
            [
                'attribute' => 'position',
                'value' => function ($model) {
                        return $model->CategoryPosition;
                    },
                'filter' => Html::activeDropDownList($searchModel, 'position', $positionArray, ['class' => 'form-control', 'prompt' => Yii::t('pages', 'Позиция')])
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                        if ($model->status === $model::CATEGORY_STATUS_PUBLISHED) {
                            $class = 'label-success';
                        } elseif ($model->status === $model::CATEGORY_STATUS_HIDDEN) {
                            $class = 'label-warning';
                        } else {
                            $class = 'label-danger';
                        }

                        return '<span class="label ' . $class . '">' . $model->CategoryStatus . '</span>';
                    },
                'filter' => Html::activeDropDownList(
                        $searchModel,
                        'status',
                        $statusArray,
                        ['class' => 'form-control', 'prompt' => Yii::t('user', 'Выберите статус')]
                    )
            ],
            // 'created',
            // 'updated',
            // 'meta_title',
            // 'meta_keywords',
            // 'meta_description',

            [
                'class' => ActionColumn::className(),
                //'header' => Yii::t('user', 'Управление')
            ]
        ],
    ]); ?>

    <?php

        print_r($parentList);
        echo '<br>';
        print_r($menu);
    use yii\widgets\Menu;

//    echo Menu::widget(
//        [
//            'items' => [
//                Category::getMenu()
//            ]
//        ]
//    );
    ?>

</div>
