<?php

namespace backend\controllers;

use backend\models\GoodsPhoto;

class GoodsPhotoController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }



}
