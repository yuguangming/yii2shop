<?php
/* @var $this yii\web\View */
?>
<h1>文章管理</h1>
<a href="add" class="btn btn-success">添加</a>
<table class="table">
    <tr>
        <th>名称</th>
        <th>类别</th>
        <th>简介</th>
        <th>状态</th>
        <th>排序</th>
        <th>录入时间</th>
        <th>操作</th>
    </tr>

    <?php foreach ($article as $articles):?>

        <tr>
            <td><?=$articles->name?></td>
            <td><?=$articles->category->name?></td>
            <td><?=$articles->intro?></td>
            <td><?=\backend\models\Article::$status[$articles->status]?></td>
            <td><?=$articles->sort?></td>
            <td><?=date('Y-m-d H:i:s',$articles->inputtime)?></td>
            <td><a href="<?=\yii\helpers\Url::to(['edit','id'=>$articles->id])?>" class="btn btn-info">编辑</a> <a
                        href="<?=\yii\helpers\Url::to(['del','id'=>$articles->id])?>" class="btn btn-danger">删除</a><a
                        href="<?=\yii\helpers\Url::to(['show','id'=>$articles->id])?>" class="btn btn-info">查看详情</a></td>
        </tr>

    <?php endforeach;?>
</table>
