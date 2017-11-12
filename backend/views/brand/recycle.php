<h1>回收站</h1>
<a href="index" class="btn btn-info">返回</a>
<table class="table">
    <tr>
        <th>名称</th>
        <th>简介</th>
        <th>排序</th>
        <th>状态</th>
        <th>图片</th>
        <th>操作</th>
    </tr>

    <?php foreach ($display as $displays):?>

    <tr>
        <td><?=$displays->name?></td>
        <td><?=$displays->intro?></td>
        <td><?=$displays->sort?></td>
        <td><?=\backend\models\Brand::$status[$displays->status]?></td>
        <td><?=\yii\bootstrap\Html::img($displays->image,['height'=>60])?></td>
        <td><a href="<?=\yii\helpers\Url::to(['brand/reduction','id'=>$displays->id])?>" class="btn btn-info">还原</a>
            <a href="<?=\yii\helpers\Url::to(['brand/del','id'=>$displays->id])?>" class="glyphicon glyphicon-trash" title="删除"></a>
        </td>
    </tr>

<?php endforeach;?>
</table>


