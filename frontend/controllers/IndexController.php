<?php
/**
 * Created by PhpStorm.
 * User: Hasee
 * Date: 2017/11/18
 * Time: 15:18
 */

namespace frontend\controllers;


use backend\models\Goods;
use backend\models\GoodsCategory;

use frontend\components\Cart;
use frontend\models\Address;
use yii\web\Controller;
use yii\web\Cookie;

class IndexController extends Controller
{
    public $layout="index";

    //public $enableCsrfValidation=false;
    public function actionIndex(){
        return $this->render('/index/index');
    }

    public function actionList($id){
        $cate=GoodsCategory::findOne($id);

        //得到包括当前分类及所有子分类
        $cates=GoodsCategory::find()->where(['tree'=>$cate->tree])->andWhere(['>=','lft',$cate->lft])->andWhere(['<=','rgt',$cate->rgt])->asArray()->all();

        //把这些分类的ID取出来
        $catesId=array_column($cates,'id');
        //var_dump($catesId);exit;

        //查询商品的分类ID在上面提取出来的ID中的商品'goods_category_id in $catesId'
        $goods=Goods::find()->where(['in','goods_category_id',$catesId])->all();
        //var_dump($goods);exit;

        return $this->renderPartial('list',['goods'=>$goods]);
    }

    public function actionGoods($id){
        $good=Goods::findOne($id);
        return $this->renderPartial('goods',['good'=>$good]);
    }

    public function actionAddCart($goodsId,$num){

        if (Goods::findOne($goodsId)===null){

            //判断有没有商品
            return $this->redirect(['index']);
        }

        //判断是否登录
        if (\Yii::$app->user->isGuest) {

            /*$cart=new Cart();

            $cart->add($goodsId,$num);

            $cart->save();*/

            \Yii::$app->cart->add($goodsId,$num)->save();



        }else{
            //2.已登录 存数据库
            $memberId=\Yii::$app->user->id;

            $cart=\frontend\models\Cart::find()->where(['goods_id'=>$goodsId,'member_id'=>$memberId])->one();

            //判断不存在
            if ($cart===null){
                //执行添加操作
                $cart=new \frontend\models\Cart();

                $cart->goods_id=$goodsId;
                $cart->member_id=$memberId;
                $cart->num=$num;
                $cart->save();
            }else{
                $cart->num+=$num;
            }


            $cart->save();
        }
        //跳转到购物车页面
        return $this->redirect(['cart']);
    }

    public function actionCart(){

        if (\Yii::$app->user->isGuest) {
            //1. 没有登录 操作cookie
            $getCookie=\Yii::$app->request->cookies;


            //1.1 得到购物车数据
            $carts=$getCookie->has('cart')?$getCookie->getValue('cart'):[];

            $goods=[];
            foreach ($carts as $goodsId=>$num){

                $good=Goods::find()->where(['id'=>$goodsId])->asArray()->one();

                $good['num']=$num;
                //var_dump($good);exit;
                $goods[]=$good;

            }

//            var_dump($goods);exit;
        }else{
            //2.已经登录 从数据库查
            $memberId=\Yii::$app->user->id;
            //从数据库中得到当前用户所有的购物车数据
         $carts=\frontend\models\Cart::find()->where(['member_id'=>$memberId])->asArray()->all();

            $goods=[];
            //循环得到商品信息
            foreach ($carts as $k=>$v){

                //查出商品
                $good=Goods::find()->where(['id'=>$v['goods_id']])->asArray()->one();

                //每个商品购买的数量
                $good['num']=$v['num'];
                //var_dump($good);exit;
                $goods[]=$good;

            }

        }

//        var_dump($goods);exit;

        return $this->renderPartial('cart',compact('goods'));
    }

    /**
     * 专门用来做Ajax
     */
    public function actionAjax($type){

        switch ($type){
            case "change";
                $request=\Yii::$app->request;
                //接收参数
                $id=$request->post('id');
                $num=$request->post('num');
                //如果没有登录
                if (\Yii::$app->user->isGuest){

                    \Yii::$app->cart->update($id,$num)->save();
                }
            //如果登录
            break;

            //如果是删除操作
            case "del";
                $request=\Yii::$app->request;
                //接收参数
                $id=$request->post('id');
               //判断是否登录
                if (\Yii::$app->user->isGuest){

                   /* $cart=new Cart();
                    $cart->del($id)->save();*/

                    (new Cart())->del($id)->save();

                }else{
                    //已登录
                }

            return "success";
            break;

        }


    }


}
