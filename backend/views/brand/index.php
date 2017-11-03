<?php
/* @var $this yii\web\View */
?>
<h1>品牌列表</h1>
<a href="add" class="btn btn-info">添加</a>
<table class="table">
    <tr>
        <th>名称</th>
        <th>简介</th>
        <th>排序</th>
        <th>状态</th>
        <th>图片</th>
        <th>操作</th>
    </tr>

    <?php foreach ($brand as $brands):?>

        <tr>
            <td><?=$brands->name?></td>
            <td><?=$brands->intro?></td>
            <td><?=$brands->sort?></td>
            <td><?=$brands->status?></td>
            <td><?=\yii\bootstrap\Html::img("@web/".$brands->logo,['height'=>60])?></td>
            <td><a href="<?=\yii\helpers\Url::to(['brand/edit','id'=>$brands->id]) ?>" class="btn btn-info">编辑</a> <a
                        href="<?=\yii\helpers\Url::to(['brand/del','id'=>$brands->id])?>" class="btn btn-danger">删除</a></td>
        </tr>

    <?php endforeach;?>
</table>

<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page
]);
?>
