<?php
/**
 * Created by PhpStorm.
 * User: Hasee
 * Date: 2017/11/17
 * Time: 22:47
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class IndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "style/base.css",
    "style/global.css",
    "style/header.css",
    "style/index.css",
    "style/bottomnav.css",
    "style/footer.css",
    ];
    public $js = [
        "js/header.js",
    "js/index.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];

}