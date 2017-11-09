<?php
/* @var $this yii\web\View */
?>
<h1>商品列表</h1>
<div class="row">
<div class="col-md-2"><a href="add" class="btn btn-info">添加</a></div>
    <div class="col-md-10">

        <form class="form-inline pull-right">
            <input type="text" class="form-control" id="minPrice" name="minPrice" size="8" placeholder="最低价" value="<?=Yii::$app->request->get('minPrice')?>"> -
            <input type="text" class="form-control" id="maxPrice" name="maxPrice"  size="8" placeholder="最高价" value="<?=Yii::$app->request->get('maxPrice')?>">
            <input type="text" class="form-control" id="keyword" name="keyword" placeholder="请输入商品名称或货号" value="<?=Yii::$app->request->get('keyword')?>">
            <a href="#" class="btn btn-default glyphicon glyphicon-search"></a>
        </form>

    </div>

</div>
<table class="table">

    <tr>
        <th>名称</th>
        <th>商品编号</th>
        <th>分类</th>
        <th>品牌</th>
        <th>是否上架</th>
        <th>状态</th>
        <th>排序</th>
        <th>LOGO</th>
        <th>市场售价</th>
        <th>本店售价</th>
        <th>库存</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>

    <?php foreach ($model as $models):?>

        <tr>
            <td><?=$models->name?></td>
            <td><?=$models->sn?></td>
            <td><?=$models->category->name?></td>
            <td><?=$models->brand->name?></td>
            <td><?=\backend\models\Goods::$isonline[$models->isonline]?></td>
            <td><?=\backend\models\Goods::$status[$models->status]?></td>
            <td><?=$models->sort?></td>
            <td><?=\yii\bootstrap\Html::img($models->image,['height'=>60])?></td>
            <td><?=$models->market_price?></td>
            <td><?=$models->shop_price?></td>
            <td><?=$models->stock?></td>
            <td><?=date('Y-m-d H:i:s',$models->createtime_at)?></td>
            <td><a href="<?= \yii\helpers\Url::to(['goods/edit','id'=>$models->id]) ?>" class="glyphicon glyphicon-pencil"></a> <a
                        href="<?=\yii\helpers\Url::to(['goods/del','id'=>$models->id])?>" class="glyphicon glyphicon-trash"></a> <a
                        href="<?=\yii\helpers\Url::to(['goods/show','id'=>$models->id])?>" class="glyphicon glyphicon-eye-open"></a></td>
        </tr>

    <?php endforeach;?>

</table>
<?php
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$page
]);
?>

