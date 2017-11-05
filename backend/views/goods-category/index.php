<a href="add" class="btn btn-success">添加分类</a>


<?php
use yii\web;
use leandrogehlen\treegrid\TreeGrid;
echo TreeGrid::widget([
    'dataProvider' => $dataProvider,
    'keyColumnName' => 'id',
    'parentColumnName' => 'parent_id',
    'parentRootValue' => '0', //first parentId value
    'pluginOptions' => [
        'initialState' => 'collapsed',
    ],
    'columns' => [
        'name',
        'id',
        'parent_id',
        ['class' => '\backend\components\TreeColumn']
    ]
]);
?>