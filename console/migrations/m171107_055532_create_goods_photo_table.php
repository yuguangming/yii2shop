<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_photo`.
 */
class m171107_055532_create_goods_photo_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_photo', [
            'id' => $this->primaryKey(),
            'path'=>$this->string()->comment('图片地址'),
            'goods_id'=>$this->integer()->comment('商品id'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_photo');
    }
}
