<?php

namespace backend\controllers;

use backend\models\Admin;

use backend\models\LoginForm;
use yii\web\UploadedFile;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model=Admin::find()->all();

        return $this->render('index',['model'=>$model]);
    }

    public function actionAdd()
    {
        $model=new Admin();


        //判断是不是POST提交
       $request=\Yii::$app->request;
        if ($request->isPost){
            //绑定数据
            $model->load($request->post());

            //注册时间
            $model->add_time=time();
            //验证数据
            if ($model->validate()){

//                echo 1111;exit;
                //密码加密
                $model->password=\Yii::$app->security->generatePasswordHash($model->password);

                $model->token=\Yii::$app->security->generateRandomString();

                //保存数据
              if( $model->save()){

                  //跳转
                  $this->redirect(['admin/index']);
              } else{

                  var_dump($model->getErrors());exit;
              }

            }
        }
        //显示视图
        return $this->render('add',['model'=>$model]);

    }

    public function actionEdit($id)
    {
        $model=Admin::findOne($id);

        //判断是不是POST提交
        $request=\Yii::$app->request;
        if ($request->isPost){
            //绑定数据
            $model->load($request->post());

            //注册时间
            $model->add_time=time();
            //验证数据
            if ($model->validate()){

//                echo 1111;exit;
                //密码加密
                $model->password=\Yii::$app->security->generatePasswordHash($model->password);

                $model->token=\Yii::$app->security->generateRandomString();

                //保存数据
                if( $model->save()){

                    //跳转
                    $this->redirect(['admin/index']);
                } else{

                    var_dump($model->getErrors());exit;
                }

            }
        }
        //显示视图
        return $this->render('add',['model'=>$model]);

    }

    public function actionDel($id){
        $model=Admin::findOne($id);
        $model->delete();

        return $this->redirect(['admin/index']);
    }

    public function actionLogin(){
        //创建表单模型
        $model=new LoginForm();

        $request=\Yii::$app->request;

        //判断是不是POST提交
        if ($request->isPost){
            //接收数据并绑定model
            $model->load($request->post());
//            var_dump($model);exit;
            //后端验证
            if ($model->validate()){
                //var_dump($model);exit;
                //验证用户存不存在
                $admin=Admin::findOne(['username'=>$model->username]);
                if ($admin){
                    //验证密码
                    $password=\Yii::$app->security->validatePassword($model->password,$admin->password);
                    if ($password){
                        //验证成功后登录，保存session自动登录
                        \Yii::$app->user->login($admin,$model->rememberMe?3600*24*7:0);

                        //最后一次登录时间
                        $admin->last_login_time=time();
                        //最后一次登录ip
                        $admin->last_login_ip=\Yii::$app->request->userIP;
                        //保存
                        $admin->save();


                        return $this->redirect(['index']);
                    }else{
                        $model->addError('password','密码错误');
                    }
                }else{
                    $model->addError('username','用户不存在');
                }
            }
        }
        //显示视图
        return $this->render('login',['model'=>$model]);
    }


    public function actionLogout(){
        \Yii::$app->user->logout();

        $this->redirect(['login']);
    }

}
