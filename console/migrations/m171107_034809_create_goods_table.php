<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m171107_034809_create_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(30)->comment('商品名称'),
            'sn'=>$this->string()->comment('商品编号'),
            'goods_category_id'=>$this->integer()->comment('分类id'),
            'brand_id'=>$this->integer()->comment('品牌id'),
            'isonline'=>$this->smallInteger()->comment('是否上架'),
            'status'=>$this->smallInteger()->comment('状态'),
            'sort'=>$this->integer()->comment('排序'),
            'logo'=>$this->string(100)->comment('LOGO'),
            'market_price'=>$this->integer()->comment('市场价'),
            'shop_price'=>$this->integer()->comment('本店价'),
            'createtime_at'=>$this->integer()->comment('创建时间'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods');
    }
}
