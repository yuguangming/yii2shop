<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_tetail".
 *
 * @property integer $id
 * @property integer $article_id
 * @property string $content
 */
class ArticleTetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_tetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'],'required'],
            [['article_id'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => '文章管理id',
            'content' => '文章内容',
        ];
    }
}
