<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \corp\models\PasswordResetRequestForm */

$this->title = '开通招聘服务';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="midd-kong"></div>
<div class="container mima">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 ">
            <div class="miam-coter">
                <h2>开通招聘服务</h2>
                <!--
                <form action="/user/add-contact-info" method="post" id="form">
                -->
                <?php 
                    $errors = $model->getErrors();
                    $form = ActiveForm::begin(['action'=>'/user/add-contact-info', 'options'=>['id'=>'form']]);?>
                    <div class="tx-box">
                        <span class="pull-left text-right">企业名称 </span>
                        <div class="midd-input-group pull-left">
                            <input name="name" value="<?=$model->name?>" type="text" class="input-q"  placeholder="准确填写公司名，提升投递量">
                        </div>
                        <em class="pull-right">*</em>
                        <?php if(isset($errors['name'])){ ?>
                        <p class="cuowu ql title-error" style="display: block;"><?=implode(' ', $errors['name'])?></p>
                        <?php } ?>
                    </div>
                    <div class="tx-box">
                        <span class="pull-left text-right">联系人 </span>
                        <div class="midd-input-group pull-left">
                        <input name="contact_name" value="<?=$model->contact_name?>" type="text" class="input-q"  placeholder="负责招聘的联系人姓名">
                        </div>
                        <em class="pull-right">*</em>
                        <?php if(isset($errors['contact_name'])){ ?>
                        <p class="cuowu ql title-error" style="display: block;"><?=implode(' ', $errors['contact_name'])?></p>
                        <?php } ?>
                    </div>
                    <div class="tx-box">
                        <span class="pull-left text-right">公司联系电话 </span>
                        <div class="midd-input-group pull-left">
                            <input  name="contact_phone" value="<?=$model->contact_phone?>" type="text" class="input-q"  placeholder="请填写真实有效手机/座机号码(带区号)">
                        </div>
                        <em class="pull-right">*</em>
                        <?php if(isset($errors['contact_phone'])){ ?>
                        <p class="cuowu ql title-error" style="display: block;"><?=implode(' ', $errors['contact_phone'])?></p>
                        <?php } ?>
                    </div>
                    <div class="tx-box">
                        <span class="pull-left text-right"> 接收简历邮箱 </span>
                        <div class="midd-input-group pull-left">
                            <input value="<?=$model->contact_email?>" name="contact_email" type="text" class="input-q"  placeholder="请填写公司邮箱，审核通过后不可更改">
                        </div>
                        <em class="pull-right">*</em>
                        <?php if(isset($errors['contact_email'])){ ?>
                        <p class="cuowu ql title-error" style="display: block;"><?=implode(' ', $errors['contact_email'])?></p>
                        <?php } ?>
                    </div>
                    <div class="tx-box">
                        <span class="pull-left text-right"></span>
                        <a href="#" onclick="$('#form').submit();return false;" class="zc-btn pull-right">确定</a>
                    </div>
<!--
                </form>
            -->
            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<!-- InstanceEndEditable -->
