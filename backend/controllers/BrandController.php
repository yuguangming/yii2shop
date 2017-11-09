<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\web\UploadedFile;
use flyok666\qiniu\Qiniu;

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
            ///$model->imgfile=UploadedFile::getInstance($model,'imgfile');

            //拼装路径
            //$path="images/brand/".uniqid().".".$model->imgfile->extension;

            //保存图片
            //$model->imgfile->saveAs($path,false);

            //验证数据
            if ($model->validate()){
                //和数据库里logo字段绑定
                //$model->logo=$path;

                //提示
                \Yii::$app->session->setFlash("success","添加成功");

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
        //创建HTTP请求对象
        $request=\Yii::$app->request;
        //判断是否是POST提交
        if ($model->load($request->post())){
            //创建文件上传对象
            ///$model->imgfile=UploadedFile::getInstance($model,'imgfile');

            //拼装路径
            //$path="images/brand/".uniqid().".".$model->imgfile->extension;

            //保存图片
            //$model->imgfile->saveAs($path,false);

            //验证数据
            if ($model->validate()){
                //和数据库里logo字段绑定
                //$model->logo=$path;

                //提示
                \Yii::$app->session->setFlash("success","添加成功");

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

    public function actionRemove($id)
    {
        $model=Brand::findOne($id);
        if ($model->status==0){

            $model->status=1;

        }elseif ($model->status==1){

            $model->status=0;

        }
        $model->save();

        return $this->redirect('index');
    }

    public function actionUpload()
    {


        //七牛云上传
        //配置
        $config = [
            'accessKey'=>'Y7yUqppldH3NyvnTSQmOpo0KC5WECezW6vwLuNrQ',//ak
            'secretKey'=>'2qVEShQYlLonxUlAnWD4YX0vC4i-laVAyDeNBR0n',//sk
            'domain'=>'http://oywalm53l.bkt.clouddn.com/',//域名
            'bucket'=>'yuguangming-php',//空间名称
            'area'=>Qiniu::AREA_HUANAN //区域
        ];


        //实例化对象
        $qiniu = new Qiniu($config);
        $key = uniqid();
        //调用上传方法
        $qiniu->uploadFile($_FILES["file"]['tmp_name'],$key);
        $url = $qiniu->getLink($key);
        //exit($url);
        $info=[
            'code'=>0,
            'url'=>$url,
            'attachment'=>$url
        ];
        exit(Json::encode($info));
        /*$info=[
            'code'=>0,
            'url'=>'http:http://www.itsource.cn/upload/superStar/superStar_picture/2017-08-21/9395f2d0-a49f-4120-bd88-9ddb663a0d3c.jpg',
            'attachment'=>'upload/superStar/superStar_picture/2017-08-21/9395f2d0-a49f-4120-bd88-9ddb663a0d3c.jpg'
        ];*/

        //exit(Json::encode($info));
    }

    public function actionDel7()
    {
        $qiNiu=new Qiniu($config = [
            'accessKey'=>'Y7yUqppldH3NyvnTSQmOpo0KC5WECezW6vwLuNrQ',//ak
            'secretKey'=>'2qVEShQYlLonxUlAnWD4YX0vC4i-laVAyDeNBR0n',//sk
            'domain'=>'http://oywalm53l.bkt.clouddn.com/',//域名
            'bucket'=>'yuguangming-php',//空间名称
            'area'=>Qiniu::AREA_HUANAN //区域
        ]);

        $qiNiu->delete("我姓余.jpg","yuguangming-php");
    }

}
