<?php
/* @var $this yii\web\View */
?>
<h1>角色列表</h1>

<a href="add" class="btn btn-info">添加角色</a>

<table class="table">
    <tr>
        <th>角色名称</th>
        <th>角色描述</th>
        <th>操作</th>
    </tr>

    <?php foreach ($models as $model):?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->description?></td>
            <td><?=\yii\bootstrap\Html::a("",['edit','name'=>$model->name],['class'=>'glyphicon glyphicon-edit','title'=>'编辑'])?> <?=\yii\bootstrap\Html::a("",['del','name'=>$model->name],['class'=>'glyphicon glyphicon-trash','title'=>'删除'])?></td>
        </tr>
    
    <?php endforeach;?>
</table>


