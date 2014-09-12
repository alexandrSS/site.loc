<?php

use yii\helpers\Html;


$this->title = Yii::t('admin', 'Панель управления');
$this->params['breadcrumbs'][] = '<i class="fa fa-dashboard"></i> ' . $this->title;
$this->params['subtitle'] = Yii::t('admin', 'Центральная страница');
?>
<div class="jumbotron text-center">
    <h1><?php echo Html::encode($this->title); ?></h1>
    <p><?= Yii::t('admin', 'Yii2-Demo панель управления.') ?></p>
</div>
<?php
// Example of data.
$data = [
    ['title' => 'Node 1', 'key' => 1],
    ['title' => 'Folder 2', 'key' => '2', 'folder' => true, 'children' => [
        ['title' => 'Node 2.1', 'key' => '3'],
        ['title' => 'Node 2.2', 'key' => '4']
    ]]
];

echo \wbraganca\fancytree\FancytreeWidget::widget([
    'options' =>[
        'source' => $data,
        'extensions' => ['dnd'],
        'dnd' => [
            'preventVoidMoves' => true,
            'preventRecursiveMoves' => true,
            'autoExpandMS' => 400,
            'dragStart' => new JsExpression('function(node, data) {
                return true;
            }'),
            'dragEnter' => new JsExpression('function(node, data) {
                return true;
            }'),
            'dragDrop' => new JsExpression('function(node, data) {
                data.otherNode.moveTo(node, data.hitMode);
            }'),
        ],
    ]
]);
?>