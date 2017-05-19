<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace m\assets;

use yii\web\AssetBundle;

/**
 * @author dawei
 */
class BaiduMapAsset extends AssetBundle
{
    public $js = [
        'https://api.map.baidu.com/api?type=quick&ak=' 
            . Yii::$app->params['baidu.map.web_key'] 
            . '&v=1.0',
    ];
}
