<?php
/* @var $this yii\web\View */
?>
<h1>管理员列表</h1>

<a href="add" class="btn btn-info">添加</a>
<table class="table">

    <tr>
        <th>用户名</th>
        <th>角色</th>
        <th>邮箱</th>
        <th>登录令牌</th>
        <th>注册时间</th>
        <th>最后登录时间</th>
        <th>最后登录ip</th>
        <th>操作</th>
    </tr>

    <?php foreach ($model as $models):?>
        <tr>
            <td><?=$models->username?></td>
            <td>
                <?php
                $auth=Yii::$app->authManager->getRolesByUser($models->id);
                foreach ($auth as $auths){
                    echo $auths->description.'/';
                }

                ?>
            </td>
            <td><?=$models->email?></td>
            <td><?=$models->token?></td>
            <td><?=date('Y-m-d H:i:s',$models->add_time)?></td>
            <td><?php if ($models->last_login_time!==null){echo date('Y-m-d H:i:s',$models->last_login_time);}?></td>
            <td><?=$models->last_login_ip?></td>
            <td><a href="<?=\yii\helpers\Url::to(['admin/edit','id'=>$models->id])?>" class="glyphicon glyphicon-edit" title="编辑"></a>
                <a href="<?=\yii\helpers\Url::to(['admin/del','id'=>$models->id])?>" class="glyphicon glyphicon-trash" title="删除"></a></td>
        </tr>


    <?php endforeach;?>

</table>
