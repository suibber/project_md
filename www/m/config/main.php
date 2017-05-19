<?php
$param_files = 
    [__DIR__ . '/../../common/config/params.php',
     __DIR__ . '/../../common/config/params-local.php',
     __DIR__ . '/params.php',
     __DIR__ . '/params-local.php'];

foreach ($param_files as $f){
    if (file_exists($f)){
        $params = array_merge($params, require($f));
    }
}

return [
    'id' => 'app-m',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'm\controllers',
    'defaultRoute'=>'site/',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => '/user/login'
        ],
        'request' => [
            'class' => 'm\MRequest',
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
        'formatter' => [
            'class' => 'common\Formatter',
            'dateFormat' => 'php:m-d',
            'datetimeFormat' => 'php:m-d H:i',
            'timeFormat' => 'php:H:i',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'cache' => [
            'class' => 'yii\caching\DbCache',
            'db' => 'db',
            'cacheTable' => 'jz_cache',
            'keyPrefix' => 'm@',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => [
                // 详情 =城市/服务类别/gid
                'change-city' => 'site/change-city',
                '<param_one:[a-z]+>/<param_two:[a-z]+>/<gid:\d{10,40}?>'=>'task/view',
                [
                    'class' => 'm\SeoUrlRule',
                    'pattern'=> '',
                    'route'=>'',
                ]
            ],
        ],
        'view' => [
            'class' => 'm\MView',
        ],
    ],
    'params' => $params,
];
