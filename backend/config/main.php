<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => \backend\models\Admin::className(),
            'loginUrl' => 'admin/login',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],

    ],
    'controllerMap' => [
        'ueditor' => [
            'class' => 'crazydb\ueditor\UEditorController',
            'thumbnail' => false,//如果将'thumbnail'设置为空，将不生成缩略图。
            'watermark' => [    //默认不生存水印
                'path' => '', //水印图片路径
                'position' => 9 //position in [1, 9]，表示从左上到右下的 9 个位置，即如1表示左上，5表示中间，9表示右下。
            ],
            'zoom' => ['height' => 500, 'width' => 500], //缩放，默认不缩放
            'config' => [
                //server config @see http://fex-team.github.io/ueditor/#server-config
                'imagePathFormat' => '/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}',
                'scrawlPathFormat' => '/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}',
                'snapscreenPathFormat' => '/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}',
                'catcherPathFormat' => '/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}',
                'videoPathFormat' => '/upload/video/{yyyy}{mm}{dd}/{time}{rand:6}',
                'filePathFormat' => '/upload/file/{yyyy}{mm}{dd}/{rand:4}_{filename}',
                'imageManagerListPath' => '/upload/image/',
                'fileManagerListPath' => '/upload/file/',
            ]
        ]
    ],
    'params' => $params,
];
