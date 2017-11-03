<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\data\Pagination;
use yii\web\UploadedFile;

class BrandController extends \yii\web\Controller
{
    /**
     * 品牌列表
     * @return string
     */
    public function actionIndex()
    {

        // 1.总条数
        $count=Brand::find()->count();
        //2 每页显示条数
        $pageSize=4;
        //创建分页对象
        $page=new Pagination(
            [
                'pageSize'=>$pageSize,
                'totalCount'=>$count
            ]
        );
        $brand=Brand::find()->limit($page->limit)->offset($page->offset)->all();

        //显示视图
        return $this->render('index',['brand'=>$brand,'page'=>$page]);


    }

    public function actionAdd()
    {
        //创建对象
        $model=new Brand();
        //创建HTTP请求对象
        $request=\Yii::$app->request;
        //判断是否是POST提交
        if ($model->load($request->post())){
            //创建文件上传对象
            $model->imgfile=UploadedFile::getInstance($model,'imgfile');

            //拼装路径
            $path="images/brand/".uniqid().".".$model->imgfile->extension;

            //保存图片
            $model->imgfile->saveAs($path,false);

            //验证数据
            if ($model->validate()){
                //和数据库里logo字段绑定
                $model->logo=$path;

                //保存数据
                if ($model->save(false)){
                    //跳转
                    return $this->redirect(['index']);

                }
            }

        }


        //显示视图
        $model->status=1;
        return $this->render('add',['model'=>$model]);

    }

    public function actionEdit($id)
    {
        //创建对象
        //$model=new Brand();

        $model=Brand::findOne($id);

        $request=\Yii::$app->request;

        if ($model->load($request->post())){
            //创建文件上传对象
            $model->imgfile=UploadedFile::getInstance($model,'imgfile');
            if ($model->imgfile){
                //拼装路径
                $path="images/brand/".uniqid().".".$model->imgfile->extension;

                //保存图片
                $model->imgfile->saveAs($path,false);

                //和数据库里logo字段绑定
                $model->logo=$path;
            }



            if ($model->validate()){


                //保存数据
                if ($model->save(false)){
                    //跳转
                    return $this->redirect(['index']);

                }
            }

        }

        //显示视图
        $model->status=1;
        return $this->render('add',['model'=>$model]);

    }

    public function actionDel($id)
    {
        $model=Brand::findOne($id);
        $model->delete();

        return $this->redirect(['brand/index']);
    }

}
