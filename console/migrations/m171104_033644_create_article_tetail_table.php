<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_tetail`.
 */
class m171104_033644_create_article_tetail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_tetail', [
            'id' => $this->primaryKey(),
            'article_id'=>$this->integer()->comment('文章管理id'),
            'content'=>$this->text()->comment('文章内容')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_tetail');
    }
}
