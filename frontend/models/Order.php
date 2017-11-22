<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $name
 * @property string $province
 * @property string $city_name
 * @property string $area_name
 * @property string $detail_address
 * @property string $tel
 * @property integer $delivery_id
 * @property string $delivery_name
 * @property integer $delivery_price
 * @property integer $payment_id
 * @property string $payment_name
 * @property string $price
 * @property integer $status
 * @property string $trade_no
 * @property integer $create_time
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'delivery_id', 'delivery_price', 'payment_id', 'status', 'create_time'], 'integer'],
            [['price'], 'number'],
            [['name', 'province', 'city', 'area', 'delivery_name', 'payment_name'], 'string', 'max' => 30],
            [['detail_address', 'trade_no'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '会员ID',
            'name' => '收货人',
            'province' => '省份',
            'city' => '城市',
            'area' => '区县',
            'detail_address' => '详细地址',
            'tel' => '手机号码',
            'delivery_id' => '配送方式ID',
            'delivery_name' => '配送方式',
            'delivery_price' => '运费',
            'payment_id' => '支付方式ID',
            'payment_name' => '支付方式名字',
            'price' => '商品金额',
            'status' => '订单状态',
            'trade_no' => '交易号',
            'create_time' => '创建时间',
        ];
    }
}
