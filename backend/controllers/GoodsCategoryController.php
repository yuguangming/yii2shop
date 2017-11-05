<?php
namespace backend\controllers;
use backend\models\ArticleDetail;
use backend\models\GoodsCategory;
use backend\models\GoodsDel;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
class GoodsCategoryController extends \yii\web\Controller
{
    /*
     * 查看列表
     */
    public function actionIndex()
    {
        $cates=GoodsCategory::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $cates,
        ]);
        return $this->render('index',['dataProvider'=>$dataProvider]);
    }
    /*
     * 添加分类
     */
    public function actionAdd()
    {
        $model=new GoodsCategory();
        $request=\Yii::$app->request;
        if($request->isPost){
            //数据绑定
            if($model->load($request->post())){
                //数据验证
                if($model->validate()){
                    //判断是不是父节点ID
                    if($model->parent_id=="0"){
                        //保存父节点
                        $model->MakeRoot();
                        \Yii::$app->session->setFlash('success','添加成功');
                    }else{
                        //保存子节点
                        $parent=GoodsCategory::findOne(['id'=>$model->parent_id]);
                        $model->prependTo($parent);
                        \Yii::$app->session->setFlash('success','添加成功');
                        return $this->redirect(['index']);
                    }
                }
            }
        }
        $cates=GoodsCategory::find()->asArray()->all();
        $cates[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        $cates=Json::encode($cates);
        return $this->render('add',['model'=>$model,'cates'=>$cates]);
    }
    /*
     * 修改分类
     */
    /*
 * 添加分类
 */
    public function actionEdit($id)
    {
        $model=GoodsCategory::findOne($id);
        $request=\Yii::$app->request;
        if($request->isPost){
            //数据绑定
            if($model->load($request->post())){
                //数据验证
                if($model->validate()){
                    //判断是不是父节点ID
                    if($model->parent_id=="0"){
                        //保存父节点
                        $model->MakeRoot();
                        \Yii::$app->session->setFlash('success','添加成功');
                    }else{
                        //保存子节点
                        $parent=GoodsCategory::findOne(['id'=>$model->parent_id]);
                        $model->prependTo($parent);
                        \Yii::$app->session->setFlash('success','添加成功');
                        return $this->redirect(['index']);
                    }
                }
            }
        }
        $cates=GoodsCategory::find()->asArray()->all();
        $cates[]=['id'=>0,'parent_id'=>0,'name'=>'顶级分类'];
        $cates=Json::encode($cates);
        return $this->render('add',['model'=>$model,'cates'=>$cates]);
    }
    /*
     * 删除分类
     */
    public function actionDel($id)
    {
        $cate=GoodsCategory::findOne(['parent_id'=>$id]);
        if($cate!=null){
            \Yii::$app->session->setFlash('success',"文件内含文件，不能删除！请先删除子文件");
            return $this->redirect(['index']);
        }else{
            $cate=GoodsCategory::findOne($id);
            if($cate->depth==0){
                GoodsDel::findOne($id)->delete();
            }else{
                GoodsCategory::findOne($id)->delete();
            }
            \Yii::$app->session->setFlash('success',"删除成功");
            return $this->redirect(['index']);
        }
    }
}

