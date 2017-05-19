<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
$this->title = '米多多兼职平台';
?>
<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="body-box">
<div class="midd-kong"></div>
<div class="container">
  <div class="row">
    <div class="fabu-box padding-0">
      <div class="col-sm-2 padding-0">
        <?= $this->render('../layouts/sidebar', ['active_menu'=>'change_password']) ?>
      </div>
      <div class="col-sm-10 padding-0 ">
        <div class="right-center">
            <div class="conter-title">我的账号</div>
            <?php if(isset($error) && $error){ ?>
                <div class="tishi-cs">
                        <?=$error?>
                </div>
            <?php } ?>
        <?php $form = ActiveForm::begin();?>
          <ul class="tianxie-box" style="border:none">
              <li>
                <div class="pull-left title-left text-center">当前密码</div>
                <div class="pull-left right-box">
                  <input name="old_password" type="password" placeholder="输入当前密码">
                </div>
              </li>
              <li>
                <div class="pull-left title-left text-center">新设密码</div>
                <div class="pull-left right-box">
                  <input name="new_password" type="password" placeholder="输入您的新密码">
                </div>
              </li>
              <li>
                <div class="pull-left title-left text-center">确认密码</div>
                <div class="pull-left right-box">
                  <input name="confirm" type="password" placeholder="再次输入您的新密码">
                </div>
              </li>
                <button class="queding-bt">确定</button>
           </ul>
        <?php ActiveForm::end(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- InstanceEndEditable -->
