<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m171120_125609_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'member_id'=>$this->integer()->comment('会员ID'),
            'name'=>$this->string(30)->comment('收货人'),
            'province_name'=>$this->string(30)->comment('省份'),
            'city_name'=>$this->string(30)->comment('城市'),
            'area_name'=>$this->string(30)->comment('区县'),
            'detail_address'=>$this->string()->comment('详细地址'),
            'tel'=>$this->string(11)->comment('手机号码'),
            'delivery_id'=>$this->integer()->comment('配送方式ID'),
            'delivery_name'=>$this->string(30)->comment('配送方式'),
            'delivery_price'=>$this->integer()->comment('运费'),
            'pay_type_id'=>$this->integer()->comment('支付方式ID'),
            'pay_type_name'=>$this->string(30)->comment('支付方式名字'),
            'price'=>$this->integer()->comment('商品金额'),
            'status'=>$this->integer()->comment('订单状态'),
            'trade_no'=>$this->string()->comment('交易号'),
            'create_time'=>$this->integer()->comment('创建时间'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
