<?php

namespace backend\controllers;

use backend\models\ArticleTetail;

class ArticleTetailController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //$articleTetail=ArticleTetail::find()->all();
        return $this->render('index');
    }

}
