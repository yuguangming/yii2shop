<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m171104_032611_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(30)->comment('文章名称'),
            'article_category_id'=>$this->integer()->comment('文章分类id'),
            'intro'=>$this->string()->comment('文章简介'),
            'status'=>$this->smallInteger()->comment('状态'),
            'sort'=>$this->integer()->comment('排序'),
            'inputtime'=>$this->integer()->comment('录入时间')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
