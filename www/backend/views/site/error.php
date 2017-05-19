<?php

use common\Utils;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        我们的服务器在响应您的请求时，发现有问题。
    </p>
    <p>
        如果需要帮助，请联系<a style="color:red;" href="mailto:<?=Utils::getApp()->params['adminEmail']?>"> 我们的开发同学</a>
    </p>
</div>
