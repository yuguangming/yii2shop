<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m171116_060816_create_member_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'username'=>$this->string(30)->comment('用户名'),
            'password'=>$this->string(100)->comment('密码'),
            'tel'=>$this->string(11)->comment('手机号码'),
            'emaile'=>$this->string(50)->comment('邮箱'),
            'add_time'=>$this->integer()->comment('加入时间'),
            'last_login_time'=>$this->integer()->comment('最后登录时间'),
            'last_login_ip'=>$this->bigInteger()->comment('最后登录IP'),
            'status'=>$this->integer()->comment('状态'),
            'token'=>$this->string(50)->comment('令牌字符串'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('member');
    }
}
