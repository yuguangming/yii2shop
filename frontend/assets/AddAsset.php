<?php
/**
 * Created by PhpStorm.
 * User: Hasee
 * Date: 2017/11/17
 * Time: 14:40
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class AddAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "style/base.css",
        "style/global.css",
        "style/header.css",
        "style/home.css",
        "style/address.css",
        "style/bottomnav.css",
        "style/footer.css",
    ];
    public $js = [
        "js/header.js",
        "js/home.js",
        "js/sanji.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}