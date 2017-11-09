<?php
/**
 * Created by PhpStorm.
 * User: Hasee
 * Date: 2017/11/7
 * Time: 22:42
 */

namespace backend\controllers;


use crazydb\ueditor\UEditorController;

class EditorController extends UEditorController
{
    public function init(){
        parent::init();
        //do something
        //这里可以对扩展的访问权限进行控制
    }

    public function actionConfig(){
        //do something
        //这里可以对 config 请求进行自定义响应
    }

    // more modify ...
    // 更多的修改
}