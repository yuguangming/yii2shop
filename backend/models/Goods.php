<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property string $sn
 * @property integer $goods_catecory_id
 * @property integer $brand_id
 * @property integer $isonline
 * @property integer $status
 * @property integer $sort
 * @property string $logo
 * @property integer $market_price
 * @property integer $shop_price
 * @property integer $createtime_at
 */
class Goods extends \yii\db\ActiveRecord
{
    public $imgFiles=[];

    public static $status=['0'=>'隐藏','1'=>'显示'];
    public static $isonline=['1'=>'上架','2'=>'下架'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','brand_id','isonline','status','sort','market_price','shop_price'],'required'],
            [['goods_category_id', 'brand_id', 'isonline', 'status', 'sort', 'market_price', 'shop_price','stock'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['logo'], 'string', 'max' => 100],
            [['imgFiles'],'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'sn' => '商品编号',
            'goods_category_id' => '分类',
            'brand_id' => '品牌',
            'isonline' => '是否上架',
            'status' => '状态',
            'sort' => '排序',
            'logo' => 'Logo',
            'market_price' => '市场售价',
            'shop_price' => '本店售价',
            'stock'=>'库存',
            'createtime_at' => '创建时间',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT=>['createtime_at'],
                ],
            ]

        ];
    }

    public function getImage()
    {

        if (substr($this->logo,0,7)=="http://"){
            return $this->logo;
        }else{
            return "@web/".$this->logo;
        }

    }

    public function getCategory()
    {
        return GoodsCategory::findOne($this->goods_category_id)->name;

    }

    public function getBrand()
    {
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);

    }




}
