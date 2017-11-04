<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_category`.
 */
class m171104_031222_create_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(30)->comment('分类名称'),
            'intro'=>$this->string()->comment('简介'),
            'sort'=>$this->integer()->comment('排序'),
            'is_help'=>$this->integer()->comment('是否是帮助相关的分类')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_category');
    }
}
