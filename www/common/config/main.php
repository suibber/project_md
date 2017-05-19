<?php
$root_path = dirname(dirname(__DIR__));

$project_root = dirname($root_path);

$params = [];

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => [
        'log',
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=miduoduo',
            'tablePrefix'=>'jz_',
            'username' => 'root',
            'password' => '123123',
            'charset' => 'utf8',
        ],
        'formatter' => [
            'class' => 'common\Formatter',
            'defaultTimeZone' => 'Asia/Shanghai',
            'timeZone' => 'Asia/Shanghai',
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat' => 'php:Y-m-d H:i',
            'timeFormat' => 'php:H:i:s',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.exmail.qq.com', 
                'username' => 'webmaster@miduoduo.cn',
                'password' => '1q2w3e4r5t67y',
                'port' => '465', 
                'encryption' => 'ssl', 
            ],
        ],
        'sms_sender' => [
            'class' => 'common\sms_sender\GuoduSender',
            'account' => 'bjcayj',
            'password' => 'cayj001',
        ],
        'voice_sender' => [
            'class' => 'common\voice_sender\YuntongxunSender',
            'account' =>'aaf98fda449fa4cc0144b3fe88fa0f5f',
            'app_id' => 'aaf98f894e91da24014e9538f64a027d',
            'account_token' => '160bc8047a564a129b5ca2ef7c51d79d',
        ],
        'app_pusher' => [
            'class' => 'common\pusher\AppPusher',
            'app_key' => 'fcdc25a74fa9d95484276160',
            'master_secret' => 'f9c837cfb26bd97dc8ed2201',
        ],
        'cloud_storage' => [
            'class' => 'common\cloud_storage\AliyunOss',
            'access_id' => 'eLpJwnKe6N5SbdpE',
            'access_key' => 'sJRSuhbrOULev4kv9Pq91EiNzlHssb',
            'hostname' => 'oss-cn-beijing-internal.aliyuncs.com', // 北京内网
            //'hostname' => 'oss-cn-beijing.aliyuncs.com', // 北京外网
        ],
        'global_cache' => [
            'class' => 'yii\caching\DbCache',
            'db' => 'db',
            'cacheTable' => 'jz_cache',
            'keyPrefix' => 'miduoduo@',
        ],
        'wechat_pusher' => [
            'class' => 'common\pusher\WechatPusher',
        ],
        'sms_pusher' => [
            'class' => 'common\pusher\SmsPusher',
        ],
        'job_queue_manager' => [
            'class' => 'common\JobQueueManager',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
       'session' => [
            'class' => 'yii\web\DbSession',
            'db' => 'db',
            'sessionTable' => '{{%session}}',
            'timeout' => 3600 * 24 * 30,
            'name' => 'sid',
       ],
       'message' => [
            'class' => 'common\message\Message',
       ],
       'log' => [
            'traceLevel' =>0,
            'targets' => [
                'main' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@data/logs/miduoduo/app.log',
                    'maxLogFiles' => 30,
                ],
                'mail_log' => [
                    'class' => 'yii\log\EmailTarget',
                    'levels' => ['error'],
                    'mailer' => 'mailer',
                    'enabled' => 0,
                    'message' => [
                        'from' => ['webmaster@miduoduo.cn'],
                        'to' => ['suixb@miduoduo.cn', 'liyw@miduoduo.cn'],
                        'subject' => '【米多多error】',
                    ],
                    'except' => [
                        'yii\web\HttpException:400',
                        'yii\web\HttpException:401',
                        'yii\web\HttpException:404',
                        'yii\web\HttpException:403',
                    ],
                ],
                [

                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'warning', 'error'],
                    'categories' => ['user_location'],
                    'logFile' => '/service/data/logs/user-location/location.log',
                    'logVars'   => [],
                    'exportInterval'  => 0,
                    'maxFileSize' => 1024 * 10,
                    'maxLogFiles' => 20,
                    'enableRotation' => true,
               ],
               [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'warning', 'error'],
                    'categories' => ['payment'],
                    'logFile' => '/service/data/logs/payment/payment.log',
                    'logVars'   => [],
                    'exportInterval'  => 0,
                    'maxFileSize' => 1024 * 10,
                    'maxLogFiles' => 20,
                    'enableRotation' => true,
               ],
            ],
        ],
        'office_phpexcel' => [
            'class' => 'common\phpoffice\PhpExcel',
        ],
    ],
    'aliases' => [
        'api' => $root_path . '/api',
        'm' => $root_path . '/m',
        'corp' => $root_path . '/corp',
        'jobs' => $root_path . '/console/jobs',
        'data' => '/service/data',
        'media' => '/service/data/media',
        'html5_src' => $project_root . '/frontend/dist/customer/webapp',
        'html5_dest' => $root_path . '/html5_dest',
    ],
    'language'=>'zh-CN',
    'sourceLanguage'=>'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'params' => $params,
];
