<?php

namespace backend\controllers;

use backend\models\GoodsDetails;
use backend\models\GoodsPhoto;

class GoodsDetailsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }



}
