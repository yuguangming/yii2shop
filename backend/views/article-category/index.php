<?php
/* @var $this yii\web\View */
?>
<h1>分类列表</h1>
<a href="add" class="btn btn-success">添加</a>

<table class="table">
    <tr>
        <th>名称</th>
        <th>简介</th>
        <th>排序</th>
        <th>是否是帮助相关的分类</th>
        <th>操作</th>
    </tr>

    <?php foreach ($articleCategory as $articleCategorys):?>

        <tr>
            <td><?=$articleCategorys->name?></td>
            <td><?=$articleCategorys->intro?></td>
            <td><?=$articleCategorys->sort?></td>
            <td><?=\backend\models\ArticleCategory::$help[$articleCategorys->is_help]?></td>
            <td><a href="<?=\yii\helpers\Url::to(['edit','id'=>$articleCategorys->id])?>" class="btn btn-info">编辑</a> <a
                        href="<?=\yii\helpers\Url::to(['del','id'=>$articleCategorys->id])?>" class="btn btn-danger">删除</a></td>
        </tr>

    <?php endforeach;?>
</table>
