<?php
/**
 * Created by PhpStorm.
 * User: Hasee
 * Date: 2017/11/16
 * Time: 11:41
 */

namespace frontend\controllers;


use Mrgoon\AliSms\AliSms;
use yii\base\Controller;
use yii\db\ActiveRecord;

class TestController extends Controller
{public function actionTest(){
    $config = [
        'access_key' => 'LTAIgeZvfRhLnuSM',
        'access_secret' => 'Y7YaLd6zl6ShUrV4XQilyyaZE4g0f5',
        'sign_name' => '余光明商城',
    ];

    $aliSms = new AliSms();
    $code=rand(9999,999999);
    $response = $aliSms->sendSms('18423082305', 'SMS_110885002', ['code'=> $code], $config);
    //var_dump($response);
}

}