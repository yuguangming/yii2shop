<?php

namespace frontend\controllers;

use backend\models\Goods;

use dosamigos\qrcode\QrCode;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderDetail;
use yii\db\Exception;
use yii\helpers\Url;
use EasyWeChat\Foundation\Application;

class OrderController extends \yii\web\Controller
{

        public function actionIndex()
        {

            //1. 未登录跳登录页面
            if (\Yii::$app->user->isGuest){
                return $this->redirect(['member/login','backUrl'=>Url::to(['order/index'])]);
            }



            $user = \Yii::$app->user->id;


            $address = Address::find()->where(['member_id' => $user])->all();

            $carts = \frontend\models\Cart::find()->where(['member_id' => $user])->asArray()->all();

            $cart_count=Cart::find()->andWhere(['member_id'=>$user])->count();



//        var_dump($carts[0]);exit;
            $goods = [];

            //总价
            $totalPrice=0;
            //循环得到商品信息
            foreach ($carts as $cart) {

                //查出商品
                $good = Goods::find()->where(['id' => $cart['goods_id']])->asArray()->one();

                $good['num'] = $cart['num'];
                $totalPrice+=$good['shop_price']*$good['num'];
                $goods[] = $good;


            }

            $request=\Yii::$app->request;

            if ($request->isPost){

                $db = \Yii::$app->db;
                $transaction = $db->beginTransaction();//开启事务

                try {
//1. 把订单表order一一赋值 然后保存
                    $order=new Order();



                    //地址
                    $addre=Address::findOne($request->post("address_id"));

                    $order->member_id=$user;
                    $order->name=$addre->name;
                    $order->province=$addre->province;
                    $order->city=$addre->city;
                    $order->area=$addre->county;
                    $order->detail_address=$addre->address;
                    $order->tel=$addre->mobile;
                    $order->delivery_id=$request->post("delivery");
                    $order->delivery_name=\Yii::$app->params["delivers"][$order->delivery_id-1]['name'];
                    $order->delivery_price=\Yii::$app->params["delivers"][$order->delivery_id-1]['price'];
                    $order->payment_id=$request->post("pay");
                    $order->payment_name=\Yii::$app->params["payType"][$order->payment_id-1]['name'];
                    $order->status=1;//等待付款
                    $order->trade_no=date("ymdHis").rand(1000,9999);
                    $order->create_time=time();
                    //总价
                    $order->price=$totalPrice+$order->delivery_price;

                    //保存数据
                    $order->save();
//var_dump($order);exit;

                    //把订单商品如order_detail表

                    foreach ($goods as $good){

                        $goodsModel=Goods::findOne($good['id']);
//                        var_dump($goodsModel['stock']);exit;
                        //判断库存是否充足
                        if ($good['num']>$goodsModel['stock']){
                            //抛出异常
                            throw new Exception("库存不足,请重新下单");
                        }
                        $orderDetail=new OrderDetail();
                        $orderDetail->order_info_id=$order->id;//订单id
                        $orderDetail->goods_id=$good['id'];
                        $orderDetail->amount=$good['num'];
                        $orderDetail->goods_name=$good['name'];
                        $orderDetail->logo=$good['logo'];
                        $orderDetail->price=$good['shop_price'];
                        $orderDetail->total_price=$good['shop_price']*$good['num'];
                        $orderDetail->save();
                        //减库存
                        $goodsModel['stock']=$goodsModel['stock']-$good['num'];
                        $goodsModel->save(false);

                    }

                    //清空购物车
                    Cart::deleteAll(['member_id'=>$user]);

                    $transaction->commit();//事务提交

                } catch(Exception $e) {

                    $transaction->rollBack();//事务回滚

//                    var_dump($e->getMessage());exit;
                    echo "<script>alert('".$e->getMessage()."')</script>";
//                    throw $e;
                }





            }
//        var_dump($goods[0]->logo);exit;

            //var_dump($carts);exit;


            //var_dump($address->name);exit;


            return $this->renderPartial('index', ['address' => $address, 'good' => $goods,'cart_count'=>$cart_count,'totalPrice'=>$totalPrice]);

        }


        public function actionComplete(){
            return $this->renderPartial('complete');
        }


        public function actionPay($orderId){

            //查询当前订单
            $orderModel=Order::findOne($orderId);

            $orderDetail=OrderDetail::find()->where(['order_info_id'=>$orderId])->one();

            $app = new Application(\Yii::$app->params['wechatOption']);
            $payment = $app->payment;
$attributes = [
    'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP... 交易类型
    'body'             => '京西商城订单',//商品描述
    'detail'           => $orderDetail->goods_name."...",//商品详情
    'out_trade_no'     => $orderModel->trade_no,
    'total_fee'        => $orderModel->price*100, // 单位：分
    'notify_url'       => Url::to(['ok'],true), // 支付结果通知网址，如果不设置则会使用配置里的默认地址
    //'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
    // ...
];
//生成订单
$order = new \EasyWeChat\Payment\Order($attributes);
//调用微信接口统一下单
$result = $payment->prepare($order);
if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
                $prepayId = $result->prepay_id;
                //var_dump($result->code_url);
                header('Content-Type: image/png');

                return QrCode::png($result->code_url,false,3,6);
            }
        }


        public function actionDemo(){

            return $this->render('demo');
        }


        
        public function actionOk(){

            $app = new Application(\Yii::$app->params['wechatOption']);

            $response = $app->payment->handleNotify(function($notify, $successful){
                // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
                //$order = ($notify->out_trade_no);
                //查询是否存在此订单
                $order=Order::find()->where(['trade_no'=>$notify->out_trade_no])->one();
                if (!$order) { // 如果订单不存在
                    return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
                }
                // 如果订单存在
                // 检查订单是否已经更新过支付状态
                if ($order->status!=1) { // 如果不是等于付款就说明已经操作
                    return true; // 已经支付成功了就不再更新了
                }
                // 用户是否支付成功
                if ($successful) {
                    // 不是已经支付状态则修改为已经支付状态
                    //$order->paid_at = time(); // 更新支付时间为当前时间
                    $order->status = 2;
                } else { // 用户支付失败
                    //$order->status = 'paid_fail';
                }
                $order->save(); // 保存订单
                return true; // 返回处理完成
            });
            return $response;
        }
}
