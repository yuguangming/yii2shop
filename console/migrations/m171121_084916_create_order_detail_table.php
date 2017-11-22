<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_detail`.
 */
class m171121_084916_create_order_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order_detail', [
            'id' => $this->primaryKey(),
            'order_info_id'=>$this->integer()->comment('订单id'),
            'goods_id'=>$this->integer()->comment('商品id'),
            'goods_name'=>$this->string()->comment('商品名称'),
            'logo'=>$this->string()->comment('商品logo'),
            'price'=>$this->decimal()->comment('商品单价'),
            'amount'=>$this->integer()->comment('商品数量'),
            'total_price'=>$this->decimal()->comment('总价')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order_detail');
    }
}
