<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_details`.
 */
class m171107_035649_create_goods_details_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_details', [
            'id' => $this->primaryKey(),
            'details'=>$this->text()->comment('详细内容'),
            'goods_id'=>$this->integer()->comment('商品id'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_details');
    }
}
