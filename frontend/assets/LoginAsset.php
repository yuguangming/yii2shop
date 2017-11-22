<?php
/**
 * Created by PhpStorm.
 * User: Hasee
 * Date: 2017/11/16
 * Time: 15:59
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "style/base.css",
        "style/global.css",
        "style/header.css",
        "style/login.css",
        "style/footer.css",
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}