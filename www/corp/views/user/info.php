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
        <?= $this->render('../layouts/sidebar', ['active_menu'=>'userinfo']) ?>
      </div>
      <div class="col-sm-10 padding-0 ">
        <div class="right-center">
            <div class="conter-title">我的资料</div>
            <?php if(isset($error)){ ?>
                <div class="tishi-cs">
                        <?=$error?>
                </div>
            <?php } ?>
        <?php $form = ActiveForm::begin();?>
          <ul class="tianxie-box" style="border:none">
              <li>
                <div class="pull-left title-left text-center">公司名称</div>
                <div class="pull-left right-box">
                  <input name="name" type="text" placeholder="输入公司名称" value="<?=$company->name?>">
                </div>
              </li>
              <li>
                  <div class="pull-left title-left text-center">所属行业</div>
                  <div class="pull-left right-box zhiweileibie">
                    <div class="nice-select" name="nice-select">
                      <input name="service" type="text" placeholder="选择行业" value="<?=$company->service?>" >
                      
                      <ul>
                        <?php foreach($services as $service) {?>
                        <li><?=$service->name?></li>
                        <?php }?>
                      </ul>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="pull-left title-left text-center">招聘性质</div>
                  <div class="pull-left right-box zhiweileibie">
                    <div class="nice-select" name="nice-select">
                      <input name="corp_type" type="text" placeholder="选择公司性质" value="<?=$company->corp_type?>">
                      
                      <ul>
                        <li data-value="1">企业直聘</li>
                        <li data-value="2">人力资源</li>
                        <li data-value="3">领队</li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="pull-left title-left text-center">企业规模</div>
                  <div class="pull-left right-box zhiweileibie">
                    <div class="nice-select" name="nice-select">
                      <input name="corp_size" type="text" placeholder="选择公司规模" value="<?=$company->corp_size?>">
                      
                      <ul>
                        <li>0-20人</li>
                        <li>20-100人</li>
                        <li>100人以上</li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="pull-left title-left text-center">公司简介</div>
                  <div class="pull-left right-box zhiweileibie">
                    <textarea name="intro" id="textarea" class="text-area" onblur="if(this.innerHTML==''){this.innerHTML='请填写您的公司简介';this.style.color='#999'}" style="COLOR: #999" onfocus="if(this.innerHTML=='请填写您的公司简介'){this.innerHTML='';this.style.color='#999'}"><?=$company->intro?></textarea>
                  </div>
                </li>
                <button class="queding-bt" onclick="$(this).closest('form').submit();">确定</button>
           </ul>
        <?php ActiveForm::end(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- InstanceEndEditable -->

<?php
$this->registerJsFile(Yii::$app->params["baseurl.static.corp"] . '/static/js/miduoduo.js');
?>
