<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m171108_062702_create_admin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'username'=>$this->string(30)->comment('用户名'),
            'password'=>$this->char(32)->comment('密码'),
            'salt'=>$this->char(6)->comment('盐'),
            'email'=>$this->string(30)->comment('邮箱'),
            'token'=>$this->string(32)->comment('自动登录令牌'),
            'token_create_time'=>$this->integer()->comment('令牌创建时间'),
            'add_time'=>$this->integer()->comment('注册时间'),
            'last_login_time'=>$this->integer()->comment('最后登录时间'),
            'last_login_ip'=>$this->string(16)->comment('最后登录ip'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin');
    }
}
