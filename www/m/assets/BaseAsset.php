<?php

namespace m\assets;

use Yii;

/**
 * @author dawei
 */
class BaseAsset extends \yii\web\AssetBundle
{

    public $basePath = '@webroot';

    public function init()
    {
        $this->baseUrl = Yii::$app->params['baseurl.static.m'];
        parent::init();
    }
}
