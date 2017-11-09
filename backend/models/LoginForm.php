<?php
/**
 * Created by PhpStorm.
 * User: Hasee
 * Date: 2017/11/9
 * Time: 14:17
 */

namespace backend\models;


use yii\base\Model;

class LoginForm extends Model
{

    public $username;
    public $password;
    public $rememberMe;

    public function rules(){
        return[
            [['username','password'],'required'],
            [['rememberMe'],'safe'],
        ];
    }

    public function attributeLabels()
    {
        return[
            'username'=>'用户名',
            'password'=>'密码',
        ];
    }
}