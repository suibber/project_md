<?php

namespace frontend\assets;

use Yii;

/**
 * @author dawei
 */
class BaseAsset extends \yii\web\AssetBundle
{

    public $basePath = '@webroot';

    public function init()
    {
        $this->baseUrl = Yii::$app->params['baseurl.static.www'];
        parent::init();
    }
}
