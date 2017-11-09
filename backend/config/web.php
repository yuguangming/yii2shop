<?php
$config = [
    'id' => 'my-app',
    'components' => [
    ],
    'controllerMap' => [
        'ueditor' => [
            'class' => 'crazydb\ueditor\UEditorController',
        ]
    ],
];
Yii::$container->set('leandrogehlen\treegrid\TreeGridAsset',[
    'js' => [
        'js/jquery.cookie.js',
        'js/jquery.treegrid.min.js',
    ],

]);
return $config;