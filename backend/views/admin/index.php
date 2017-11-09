<?php
/* @var $this yii\web\View */
?>
<h1>管理员列表</h1>

<a href="add" class="btn btn-info">添加</a>
<table class="table">

    <tr>
        <td>用户名</td>
        <td>邮箱</td>
        <td>登录令牌</td>
        <td>注册时间</td>
        <td>最后登录时间</td>
        <td>最后登录ip</td>
        <td>操作</td>
    </tr>

    <?php foreach ($model as $models):?>
        <tr>
            <td><?=$models->username?></td>
            <td><?=$models->email?></td>
            <td><?=$models->token?></td>
            <td><?=date('Y-m-d H:i:s',$models->add_time)?></td>
            <td><?=date('Y-m-d H:i:s',$models->last_login_time)?></td>
            <td><?=$models->last_login_ip?></td>
            <td><a href="<?=\yii\helpers\Url::to(['admin/edit','id'=>$models->id])?>" class="glyphicon glyphicon-edit" title="编辑"></a>
                <a href="<?=\yii\helpers\Url::to(['admin/del','id'=>$models->id])?>" class="glyphicon glyphicon-trash" title="删除"></a></td>
        </tr>


    <?php endforeach;?>

</table>
