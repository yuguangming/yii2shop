<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_details".
 *
 * @property integer $id
 * @property string $details
 * @property integer $goods_id
 */
class GoodsDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['details'],'required'],
            [['details'], 'string'],
            [['goods_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'details' => '详细内容',
            'goods_id' => '商品id',
        ];


    }

    /*public function UEditor()
    {
        \crazydb\ueditor\UEditor::widget([
            'model' => $model,
            'attribute' => 'content',
            'config' => [
                //client config @see http://fex-team.github.io/ueditor/#start-config
                'serverUrl' => ['/ueditor/index'],//确保serverUrl正确指向后端地址
                'lang' => 'zh-cn',
                'iframeCssUrl' => Yii::getAlias('@web') . '/static/css/ueditor.css',// 自定义编辑器内显示效果
            ]
        ]);
    }*/
}
