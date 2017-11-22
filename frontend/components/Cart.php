<?php
/**
 * Created by PhpStorm.
 * User: Hasee
 * Date: 2017/11/20
 * Time: 14:21
 */

namespace frontend\components;


use yii\base\Component;
use yii\web\Cookie;

class Cart extends Component
{

    //设置一个私有属性用来存储购物车数据
    private $_cart=[];
    private $expireTime=3600*24*7;
    public function __construct(array $config = [])
    {

        //1. 设置cookie
        $getCookie=\Yii::$app->request->cookies;
        //2. 得到cookie中购物车的数据
        if ($getCookie->has("cart")){

            $cart=$getCookie->getValue("cart");

        }else{
            $cart=[];
        }

        //3.给_cart赋值
        $this->_cart=$cart;

        parent::__construct($config);
    }
    
    //增
    public function add($goodsId,$num)
    {
        if (key_exists($goodsId,$this->_cart)) {
            //如果存在则加num
            $this->_cart[$goodsId]=$this->_cart[$goodsId]+=$num;
        }else{
            //不存在追加
            $this->_cart[$goodsId]=$num;
        }
        return $this;

    }

    //删
    public function del($goodsId)
    {
        if (isset($this->_cart[$goodsId])){
            //删除当前商品
            unset($this->_cart[$goodsId]);
        }
        return $this;
    }
    
    //改
    public function update($goodsId,$num)
    {
        //修改直接把原来的值覆盖
        $this->_cart[$goodsId]=$num;

        return $this;
    }
    
    //查
    public function get()
    {
        return $this->_cart;
    }

    //清空
    public function flush()
    {
        $this->_cart=[];

        return $this;
    }

    //保存数据
    public function save()
    {
        //1.操作cookie对象
        $setCookie=\Yii::$app->response->cookies;


        //2.生成cookie对象
        $cartCookie=new Cookie(
            [
                'name'=>'cart',
                'value'=>$this->_cart,
                'expire'=>time()+$this->expireTime
            ]
        );

        //3.把cookie对象添加到cookie里
        $setCookie->add($cartCookie);
    }

    //用户登录后同步到数据库
    public function synDb(){

        //1.得到Cookie中购物车数据


        //2.检测Cookie中购物车把数据在数据库中农是否存在
        foreach ($this->_cart as $goodsId=>$num){

            //检测在数据库是否存在
            $memberId=\Yii::$app->user->id;
            $cart=\frontend\models\Cart::find()->where(['goods_id'=>$goodsId,'member_id'=>$memberId])->one();

            if ($cart===null){
                $cart=new \frontend\models\Cart();
                $cart->member_id=$memberId;
                $cart->goods_id=$goodsId;
                $cart->num=$num;
            }else{
                $cart->num+=$num;
            }
            $cart->save();

        }

        return $this;

    }
}