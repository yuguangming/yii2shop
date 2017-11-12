<?php

namespace backend\controllers;

use backend\models\AuthItem;

class PermissionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=\Yii::$app->authManager->getPermissions();
        return $this->render('index',['models'=>$models]);
    }

    /**
     * 添加权限
     * @return string|\yii\web\Response
     */
    public function actionAdd(){
        //创建模型对象
        $permission=new AuthItem();
        //创建HTTP请求对象
        $request=\Yii::$app->request;

        if ($request->isPost){
            if ($permission->load($request->post()) && $permission->validate()){
                //调用authManager
                $auth=\Yii::$app->authManager;
                //创建权限
                $permissions=$auth->createPermission($permission->name);
                //创建描述
                $permissions->description=$permission->description;
                //添加权限
                $auth->add($permissions);

                \Yii::$app->session->setFlash('success','添加权限'.$permissions->name.'成功');

                return $this->redirect(['index']);
            }
        }



        return $this->render('add',['permission'=>$permission]);
    }

    /**
     * 修改权限
     * @return string|\yii\web\Response
     */
    public function actionEdit($name){
        //创建模型对象
        //$permission=new AuthItem();
        $permission=AuthItem::findOne($name);
        //创建HTTP请求对象
        $request=\Yii::$app->request;

        if ($request->isPost){
            if ($permission->load($request->post()) && $permission->validate()){
                //调用authManager
                $auth=\Yii::$app->authManager;
                //创建权限
                //$permissions=$auth->createPermission($permission->name);
                //得到权限
                $permissions=$auth->getPermission($permission->name);
                if ($permissions){
                    //创建描述
                    $permissions->description=$permission->description;
                    //修改权限
                    $auth->update($permission->name,$permissions);

                    \Yii::$app->session->setFlash('success','修改权限'.$permissions->name.'成功');

                    return $this->redirect(['index']);
                }else{
                    \Yii::$app->session->setFlash('danger',"不能修改权限名称".$permission->name);
                }

                //添加权限
                //$auth->add($permissions);



            }
        }



        return $this->render('add',['permission'=>$permission]);
    }

    /**
     * 删除权限
     * @param $name
     * @return \yii\web\Response
     */
    public function actionDel($name){

        $auth=\Yii::$app->authManager;

        //找出删除对象
        $permission=$auth->getPermission($name);
        //删除权限
        if ($auth->remove($permission)){

            \Yii::$app->session->setFlash('success','删除'.$name.'成功');
            return $this->redirect(['index']);
        }


    }
}
