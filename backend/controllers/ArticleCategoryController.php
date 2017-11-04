<?php

namespace backend\controllers;

use backend\models\ArticleCategory;

class ArticleCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $articleCategory=ArticleCategory::find()->all();

        return $this->render('index',['articleCategory'=>$articleCategory]);
    }

    public function actionAdd()
    {
        //创建对象
        $actionCategory = new ArticleCategory();


        //$cate=ArrayHelper::map()

        //创建HTTP请求对象
        $request = \Yii::$app->request;

        //判断是否是POST提交
        if ($request->isPost){

            $actionCategory->load($request->post());

            //验证数据
            if ($actionCategory->validate()){


                //提示
                \Yii::$app->session->setFlash('success',"添加成功");

                //保存数据

                if ($actionCategory->save(false)){
                    //跳转
                    $this->redirect(['article-category/index']);
                }
            }
        }
        //默认选择
        $actionCategory->is_help=0;
        //显示视图
        return $this->render('add',['articleCategory'=>$actionCategory]);
    }

    public function actionEdit($id)
    {
        //创建对象
        //$actionCategory = new ArticleCategory();

        $actionCategory=ArticleCategory::findOne($id);

        //$cate=ArrayHelper::map()

        //创建HTTP请求对象
        $request = \Yii::$app->request;

        //判断是否是POST提交
        if ($request->isPost){

            $actionCategory->load($request->post());

            //验证数据
            if ($actionCategory->validate()){


                //提示
                \Yii::$app->session->setFlash('success',"添加成功");

                //保存数据

                if ($actionCategory->save(false)){
                    //跳转
                    $this->redirect(['article-category/index']);
                }
            }
        }
        //默认选择
        $actionCategory->is_help=0;
        //显示视图
        return $this->render('add',['articleCategory'=>$actionCategory]);
    }

    public function actionDel($id)
    {
        $article=ArticleCategory::findOne($id);
        $article->delete();

        return $this->redirect(['article-category/index']);
    }

}
