<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

class AppAsset extends BaseAsset
{
    public $basePath = '@webroot';

    public $css = [
        'static/css/miduoduo.css',
        'static/css/task.css',
    ];

    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
