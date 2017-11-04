<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleTetail;
use yii\helpers\ArrayHelper;

class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $article = Article::find()->all();

        return $this->render('index',['article'=>$article]);
    }

    public function actionAdd()
    {
        //创建对象
        $article = new Article();

        //创建文章内容对象
        $articleTetail=new ArticleTetail();


        $articleCategory=ArticleCategory::find()->all();
        $cate=ArrayHelper::map($articleCategory,'id','name');


        //创建HTTP请求对象
        $request = \Yii::$app->request;

        //判断是否是POST提交
        if ($request->isPost){

//            var_dump($request->post());exit;

            $article->load($request->post());

            $articleTetail->load($request->post());

//            var_dump($articleTetail,$article);exit;

            //验证数据
            if ($article->validate()){

                //提示
                \Yii::$app->session->setFlash('success',"添加成功");

                //保存数据

                if ($article->save(false)){

//                    var_dump($article->id);exit;
                    $articleTetail->article_id=$article->id;

                    $articleTetail->save();
                    //跳转
                    $this->redirect(['article/index']);
                }
            }
        }
        //默认选择
        $article->status=1;
        //显示视图
        return $this->render('add',['article'=>$article,'cate'=>$cate,'articleTetail'=>$articleTetail]);
    }

    public function actionEdit($id)
    {
        //创建对象
        //$article = new Article();

        $article=Article::findOne($id);

        //创建文章内容对象
        $articleTetail=new ArticleTetail();

        $articleCategory=ArticleCategory::find()->all();
        $cate=ArrayHelper::map($articleCategory,'id','name');
        //$cate=ArrayHelper::map()

        //创建HTTP请求对象
        $request = \Yii::$app->request;

        //判断是否是POST提交
        if ($request->isPost){

            $article->load($request->post());

            $articleTetail->load($request->post());

            //验证数据
            if ($article->validate()){

                $article->inputtime=time();

                //提示
                \Yii::$app->session->setFlash('success',"添加成功");

                //保存数据

                if ($article->save(false)){

                    $articleTetail->article_id=$article->id;

                    $articleTetail->save();
                    //跳转
                    $this->redirect(['article/index']);
                }
            }
        }
        //显示视图
        return $this->render('add',['article'=>$article,'cate'=>$cate,'articleTetail'=>$articleTetail]);
    }

    public function actionDel($id)
    {
        $article=Article::findOne($id);
        $article->delete();

        $this->redirect(['article/index']);
    }

    public function actionShow($id)
    {
        $article=Article::findOne($id);

        $action=ArticleTetail::findOne(['article_id'=>$id]);

        $action=$action->content;

        return $this->render('show',['article'=>$article,'action'=>$action]);


    }


}
