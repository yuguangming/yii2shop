<?php

namespace backend\controllers;

use backend\models\AuthItem;
use yii\helpers\ArrayHelper;

class RoleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $models=\Yii::$app->authManager->getRoles();

        return $this->render('index',['models'=>$models]);
    }

    public function actionAdd(){
        $role=new AuthItem();

        $request=\Yii::$app->request;
        //实例化authManager
        $auth=\Yii::$app->authManager;
        $permission=$auth->getPermissions();
        $permission=ArrayHelper::map($permission,'name','description');

//        var_dump($permission);exit;
        if ($request->isPost){
            if ($role->load($request->post()) && $role->validate()){

                //创建角色
                $preRole=$auth->createRole($role->name);
                //创建描述
                $preRole->description=$role->description;
                //添加角色
                //$auth->add($preRole);
                if ($auth->add($preRole)){
                    foreach ($role->permissions as $per){
                        $auth->addChild($preRole,$auth->getPermission($per));
                    }
                }
                \Yii::$app->session->setFlash('success',"添加角色".$preRole->name."成功");
                return $this->redirect(['index']);

            }
        }
        return $this->render('add',['role'=>$role,'permission'=>$permission]);
    }

    public function actionEdit($name){
        //$role=new AuthItem();
        $role=AuthItem::findOne($name);

        $request=\Yii::$app->request;
        //实例化authManager
        $auth=\Yii::$app->authManager;
        $permission=$auth->getPermissions();
        $permission=ArrayHelper::map($permission,'name','description');

        $perRule=$auth->getPermissionsByRole($name);

        $perRule=array_keys($perRule);

        foreach ($perRule as $p){
            $role->permissions[]=$p;
        }
//        var_dump($permission);exit;
        if ($request->isPost){
            if ($role->load($request->post()) && $role->validate()){

                //创建角色
                //$preRole=$auth->createRole($role->name);

                //得到角色
                $preRole=$auth->getRole($role->name);
                if ($preRole){
                    //创建描述
                    $preRole->description=$role->description;
                    //修改角色
                    if ($auth->update($preRole->name,$preRole)){
                        $auth->removeChildren($preRole);

                        foreach ($role->permissions as $per){
                            $auth->addChild($preRole,$auth->getPermission($per));
                        }
                    }
                    \Yii::$app->session->setFlash('success',"添加角色".$preRole->name."成功");
                    return $this->redirect(['index']);
                }else{
                    \Yii::$app->session->setFlash('danger',"不能修改角色名称");
                }



            }
        }
        return $this->render('add',['role'=>$role,'permission'=>$permission]);
    }

    public function actionDel($name){
        $auth=\Yii::$app->authManager;

        //找出删除对象
        $role=$auth->getRole($name);
        $auth->removeChildren($role);
        if ($auth->remove($role)){

            \Yii::$app->session->setFlash('success','删除'.$name.'成功');
            return $this->redirect(['index']);
        }
    }

}
