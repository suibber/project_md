<?php
$param_files = 
    [__DIR__ . '/../../common/config/params.php',
     __DIR__ . '/../../common/config/params-local.php',
     __DIR__ . '/params.php',
     __DIR__ . '/params-local.php'];

$params = [];

foreach ($param_files as $f){
    if (file_exists($f)){
        $params = array_merge($params, require($f));
    }
}

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/login']
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'cache' => [
            'class' => 'yii\caching\DbCache',
            'db' => 'db',
            'cacheTable' => 'jz_cache',
            'keyPrefix' => 'frontend@'
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => [
                'download-app' => 'site/download-app',
                'resume-<user_id:\d+>-<name:.*?>'=>'resume/detail',

                // 详情 =城市/服务类别/gid
                'change-city' => 'site/change-city',
                '<param_one:[a-z]+>/<param_two:[a-z]+>/<gid:\d{10,40}?>'=>'task/view',
                [
                    'class' => 'frontend\SeoUrlRule',
                    'pattern'=> '',
                    'route'=>'',
                ]
            ],
        ],
        'view' => [
            'class' => 'frontend\FView',
        ],
    ],
    'params' => $params,
];
