<?php
/**
 * Created by PhpStorm.
 * User: Hasee
 * Date: 2017/11/5
 * Time: 20:23
 */

namespace backend\components;


use yii\grid\ActionColumn;

use yii\helpers\Html;
use yii\helpers\Url;
use Yii;

class TreeColumn extends ActionColumn
{
    public $template = '{:update} {:delete}';
    /**
     * 重写了标签渲染方法。
     * @param mixed $model
     * @param mixed $key
     * @param int $index
     * @return mixed
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return preg_replace_callback('/\\{([^}]+)\\}/', function ($matches) use ($model, $key, $index) {
            list($name, $type) = explode(':', $matches[1].':'); // 得到按钮名和类型
//            if($name == 'view'){
//                $url = Yii::$app->request->hostInfo.'/product/'.$model->id.'.html';
//                return call_user_func($this->buttons[$type], $url, $model, $key,$options=['target'=>'_blank']);
//
//            }else{
            if (!isset($this->buttons[$type])) { // 如果类型不存在 默认为view
                $type = 'index';
            }
            if ('' == $name) { // 名称为空，就用类型为名称
                $name = $type;
            }
            $url = $this->createUrl($name, $model, $key, $index);
            return call_user_func($this->buttons[$type], $url, $model, $key);
//            }
        }, $this->template);
    }
    /**
     * 方法重写，让view默认新页面打开
     * @return [type] [description]
     */
    protected function initDefaultButtons(){
//        if (!isset($this->buttons['view'])) {
//            $this->buttons['view'] = function ($url, $model, $key) {
//
//                $options = array_merge([
//                    'title' => Yii::t('yii', 'View'),
//                    'aria-label' => Yii::t('yii', 'View'),
//                    'data-pjax' => '0',
//                    'target'=>'_blank'
//                ], $this->buttonOptions);
//                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '/goodscategory/view?id='.$model->id, $options);
//            };
//        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => Yii::t('yii', 'Update'),
                    'aria-label' => Yii::t('yii', 'Update'),
                    'data-pjax' => '0',
                ], $this->buttonOptions);
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '/goods-category/edit?id='.$model->id, $options);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => Yii::t('yii', 'Delete'),
                    'aria-label' => Yii::t('yii', 'Delete'),
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ], $this->buttonOptions);
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', '/goods-category/del?id='.$model->id, $options);
            };
        }
    }
}