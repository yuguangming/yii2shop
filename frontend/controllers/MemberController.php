<?php

namespace frontend\controllers;

use frontend\components\Cart;
use frontend\models\Address;
use frontend\models\Member;
use Mrgoon\AliSms\AliSms;

class MemberController extends \yii\web\Controller
{
    public $enableCsrfValidation=false;
    public $layout="login";

    /**
     * 注册
     * @return string|\yii\web\Response
     */
    public function actionRegist()
    {
        $model=new Member();

        //创建HTTP请求对象
        $request=\Yii::$app->request;
        //绑定数据$model
        if ($request->isPost){

//            var_dump(1111);exit;
            if ($model->load($request->post())){
                //验证数据
                if ($model->validate()){
                    //赋值需要自动生成的字段
                    $model->password=\Yii::$app->security->generatePasswordHash($model->password);

                    $model->add_time=time();

                    $model->token=\Yii::$app->security->generateRandomString();

                    $model->status=1;
                    //保存数据
                    //var_dump($model);exit;
                    $model->save();
                   //\Yii::$app->user->login($model);
                }
                \Yii::$app->session->setFlash("success","恭喜您注册成功,马上为您登录");
                //跳转
                return $this->redirect(['login']);
            }
        }
        //显示页面
        return $this->render('regist',['model'=>$model]);
    }

    /**
     * 登录
     * @return string|\yii\web\Response
     */
    public function actionLogin(){
        $model=new Member();

        $request=\Yii::$app->request;

        //判断是不是POST提交
        if ($request->isPost){
            //接收数据并绑定model
            $model->load($request->post());

            //后端验证
            if ($model->validate()){
                //验证用户存不存在
                $member=Member::findOne(['username'=>$model->username]);
                if ($member){
                    //验证密码
                    $password=\Yii::$app->security->validatePassword($model->password,$member->password);
                    if ($password){
                        //验证成功后登录,保存session自动登录
                        \Yii::$app->user->login($member,$model->rememberMe?3600*24*7:0);

                        //最后一次登录时间
                        $member->last_login_time=time();
                        //最后一次登录ip
                        $member->last_login_ip=ip2long(\Yii::$app->request->userIP);

//                        var_dump($member->last_login_ip);exit;
                        //保存
                        $member->save();
                       /*if( $member->save()){

                           echo 111;exit;
                       }else{
                           echo 66666;
                           var_dump($member->getErrors());exit;
                       };*/

                        (new Cart())->synDb()->flush()->save();

                        return $this->redirect(['index/index']);
                    }else{
                        $model->addError('password',"密码错误");
                    }
                }else{
                    $model->addError('username',"用户不存在");
                }
            }
        }


        //显示视图
        return $this->render('login',['model'=>$model]);
    }

    /**
     * 退出登录
     */
    public function actionLogout(){
        \Yii::$app->user->logout();

        $this->redirect(['login']);
    }

    /**
     * 短信
     */
    public function actionMessage(){
        $request=\Yii::$app->request;

        if ($request->isPost){
            $config = [
                'access_key' => 'LTAIgeZvfRhLnuSM',
                'access_secret' => 'Y7YaLd6zl6ShUrV4XQilyyaZE4g0f5',
                'sign_name' => '余光明商城',
            ];

            $aliSms = new AliSms();
            $code=rand(9999,999999);
            $response = $aliSms->sendSms($request->post('tel'), 'SMS_110885002', ['code'=> $code], $config);

            echo $code;
        }
    }

    /**
     * 地址
     * @return string
     */
    public function actionAddress(){
        $this->layout='add';

        $model=new Address();

        $request=\Yii::$app->request;

        if ($request->isGet){
            //var_dump($request->get());exit;
            //var_dump($model->load($request->post()));exit;
            if ($model->load($request->get())){

                if ($model->validate()){
                    $id=\Yii::$app->user->id;
                    //var_dump($id);exit;
                    $model->member_id=$id;

                    $model->save();
                }
            }
        }

        return $this->render('address',['model'=>$model]);
    }


}
