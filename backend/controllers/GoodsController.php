<?php

namespace backend\controllers;

use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsDetails;
use backend\models\GoodsPhoto;
use backend\models\GoodsSearchForm;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class GoodsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //构造查询对象
        $query = Goods::find();

        $request=\Yii::$app->request;
//var_dump($request);exit;
        //接收变量
        $keyword=$request->get('keyword');
        $minPrice=$request->get('minPrice');
        $maxPrice=$request->get('maxPrice');
        $status=$request->get('status');

        if ($minPrice>0){
            //拼接条件
            $query->andWhere("shop_price >= {$minPrice}");
        }

        if ($maxPrice>0){
            $query->andWhere("shop_price <= {$maxPrice}");
        }

        if (isset($keyword)){
            $query->andWhere("name like '%{$keyword}%' or sn like '%{$keyword}%'");
        }

        //判断0和1的情况必须用三等号
        if ($status==='0' or $status==='1'){
            $query->andWhere("status={$status}");
        }

        $count=$query->count();
     //   echo $count;exit;

        $searchFprm=new GoodsSearchForm();

        //$model=Goods::find()->all();

        // 1.总条数
        //$count=Goods::find()->count();
        //2 每页显示条数
        $pageSize=4;
        //创建分页对象
        $page=new Pagination(
            [
                'pageSize'=>$pageSize,
                'totalCount'=>$count
            ]
        );
        $model=$query->limit($page->limit)->offset($page->offset)->all();
        return $this->render('index',['model'=>$model,'page'=>$page,'searchFprm'=>$searchFprm]);
    }

    public function actionAdd()
    {
        $model=new Goods();

        $photo=new GoodsPhoto();

        $content=new GoodsDetails();



        //分类添加
        $cates=GoodsCategory::find()->orderBy('tree,lft')->asArray()->all();

        $count=count($cates);

        for($i=0;$i<$count;$i++){

            $cates[$i]['nametest']=str_repeat('-',$cates[$i]['depth']*5).$cates[$i]['name'];
        }

        $cates=ArrayHelper::map($cates,'id','nametest');

        $brand=Brand::find()->all();
        $brand=ArrayHelper::map($brand,'id','name');

        //创建HTTP请求
        $request=\Yii::$app->request;

        //判断是不是POST提交
        if ($request->isPost){

                $dayCount=new GoodsDayCount();

                $model->load($request->post());

                $day=GoodsDayCount::findOne(["day"=>date('Ymd')]);

                if($day){
                    $day->count=$day->count+1;
                    $day->save();

                    $nowcount=$day->count;
                }else{

                    $dayCount->day=date('Ymd');
                    $dayCount->count=1;

                    $dayCount->save();
                    $nowcount=$dayCount->count;
                }

            $nowcount="0000".$nowcount;

            $nowcount=substr($nowcount, -5, 5);


            $model->sn=date('Ymd').$nowcount;

            if ($model->validate()){


                //保存数据
                if ($model->save(false)){

                    $content->load($request->post());

                    $content->goods_id=$model->id;

                      $content->save();

                    $photo->load($request->post());


//         var_dump($photo->path);exit;
                    //$photonum=count($photo->path);

//         echo $photonum;exit;


//var_dump($model->imgFiles);exit;
                    foreach ($model->imgFiles as $imgFile){
                        $goodsPhoto=new GoodsPhoto();
                        $goodsPhoto->goods_id=$model->id;
                        $goodsPhoto->path=$imgFile;
                        $goodsPhoto->save();

                    }



                    //提示
                    \Yii::$app->session->setFlash("success","添加商品成功");
                    //跳转
                    return $this->redirect(['index']);
                }


            }

        }
        $model->isonline=1;
        $model->status=1;
        //显示视图
        return $this->render('add',['model'=>$model,'cates'=>$cates,'brand'=>$brand,'photo'=>$photo,'content'=>$content]);
    }


    public function actionEdit($id)
    {
        $model=Goods::findOne($id);

        $photo=GoodsPhoto::find()->where(['goods_id'=>$id])->one();

        $content=GoodsDetails::find()->where(['goods_id'=>$id])->one();

        $goodsPhoto=GoodsPhoto::find()->where(['goods_id'=>$id])->all();
        foreach ($goodsPhoto as $photos){
            $model->imgFiles[]=$photos->path;
        }
        //分类添加
        $cates=GoodsCategory::find()->orderBy('tree,lft')->asArray()->all();

        $count=count($cates);

        for($i=0;$i<$count;$i++){

            $cates[$i]['nametest']=str_repeat('-',$cates[$i]['depth']*5).$cates[$i]['name'];
        }

        $cates=ArrayHelper::map($cates,'id','nametest');

        $brand=Brand::find()->all();
        $brand=ArrayHelper::map($brand,'id','name');

        //创建HTTP请求
        $request=\Yii::$app->request;

        //判断是不是POST提交
        if ($request->isPost){

            $dayCount=new GoodsDayCount();

            $model->load($request->post());

            $day=GoodsDayCount::findOne(["day"=>date('Ymd')]);

            if($day){
                $day->count=$day->count+1;
                $day->save();

                $nowcount=$day->count;
            }else{

                $dayCount->day=date('Ymd');
                $dayCount->count=1;

                $dayCount->save();
                $nowcount=$dayCount->count;
            }

            $model->sn=date('Ymd').$nowcount;

            if ($model->validate()){

                foreach ($goodsPhoto as $photo){
                    $photo->delete();
                }

                //保存数据
                if ($model->save(false)){

                    $content->load($request->post());

                    $content->goods_id=$model->id;

                    $content->save();

                    //$photo->load($request->post());
                    //var_dump($photo->load($request->post()));exit;



//         var_dump($photo->path);exit;
                    $photonum=count($model->imgFiles);

                    for($i=0;$i<$photonum;$i++){

                        $photo1=new GoodsPhoto();

                        $photo1->goods_id=$model->id;

                        $photo1->path=$model->imgFiles[$i];

                        $photo1->save();

                    }

                    //提示
                    \Yii::$app->session->setFlash("success","修改商品成功");
                    //跳转
                    return $this->redirect(['index']);
                }


            }
        }

//        var_dump($model);exit();
        //显示视图
        return $this->render('add',['model'=>$model,'cates'=>$cates,'brand'=>$brand,'photo'=>$photo,'content'=>$content]);
    }

    public function actionDel($id)
    {
        $model=Goods::findOne($id);
        $model->delete();

        //跳转
        return $this->redirect(['goods/index']);
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
        $key = time();
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
    }

    public function actionShow($id)
    {

        $details=GoodsDetails::findOne(['goods_id'=>$id]);


        return $this->render('show',['details'=>$details]);


    }



}
