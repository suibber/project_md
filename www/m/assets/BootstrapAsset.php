<?php
/**
 */

namespace m\assets;


/**
 * @author dawei
 */
class BootstrapAsset extends BaseAsset
{
    public $css = [
        'static/css/bootstrap.min.css',
        'static/css/bootstrap-theme.min.css',
        'static/css/midd.css',
    ];
    public $js = [
        'static/js/bootstrap.min.js',
        'static/js/fastclick.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
