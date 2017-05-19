<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \corp\models\PasswordResetRequestForm */

$this->title = 'Register Success';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>注册成功！</p>

    <div class="row">
        <div class="col-lg-5">
            <a href="/user/add-contact-info">开通招聘服务</a>
        </div>
    </div>
</div>
