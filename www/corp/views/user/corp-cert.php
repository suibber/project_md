<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\Utils;

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
        <?= $this->render('../layouts/sidebar', ['active_menu'=>'corp_cert']) ?>
      </div>
      <div class="col-sm-10 padding-0 ">
        <div class="right-center">
            <div class="conter-title">企业认证</div>
            <div class="tishi-cs">
                <?php if($error){ ?>
                    <?=$error?>
                <?php }else{ ?>
                    <?=$company::$EXAM_STATUSES_MSG[$company->exam_status]?>
                    <?=$company->exam_note?>
                    （当前审核状态为：<?=$company::$EXAM_RESULTS[$company->exam_result]?>）
                <?php } ?>
            </div>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>
          <ul class="tianxie-box" style="border:none">
              <li>
                <div class="pull-left title-left text-center">企业名称</div>
                <div class="pull-left right-box">
                  <input name="name" value="<?=$company->name?>" type="text" placeholder="输入企业名称">
                </div>
              </li>
              <li>
                <div class="pull-left title-left text-center">企业营业执照号</div>
                <div class="pull-left right-box">
                  <input name="corp_idcard" value="<?=$company->corp_idcard?>" type="text" placeholder="输入企业营业执照号">
                </div>
              </li>
              <li>
                <div class="pull-left title-left text-center">发布人姓名</div>
                <div class="pull-left right-box">
                  <input name="person_name" value="<?=$company->person_name?>" type="text" placeholder="输入发布人姓名">
                </div>
              </li>
              <li>
                <div class="pull-left title-left text-center">发布人身份证</div>
                <div class="pull-left right-box">
                  <input name="person_idcard" value="<?=$company->person_idcard?>" type="text" placeholder="输入发布人身份证">
                </div>
              </li>
              <li>
                <div class="pull-left title-left text-center">上传身份证照片</div>
                <div class="pull-left right-box">
                  <div class="form-group">
                      <label class="shangchuan" for="file0">上传图片</label>
                      <input name="person_idcard_pic" type="file" id="file0" style="display:none;"><span class="pull-rigth"><em class="em-rad">*</em>提交照片需要注意以下几点</span>
                   </div>
                  <div class="tishi">
                        <p>1、在拍摄证件时，确保图片清晰（证件底纹、字体、人物照片、头像清晰），无模糊，无白光点等。</p>
                        <P>2、确保身份证边角显示完整。</P>
                        <P>3、图片格式为bmp、jpg、jpeg、png，大小必须在3MB以内。建议使用500W像素以上相机拍摄。</P>
                        <P>4、身份证需要在有效期内。</P>
                        <P>5、申请人所填写的真实姓名、身份证号码必须与提交的证件信息一致。</P>
                   </div>
                   <div class="id-img">
                   <img src="<?php if($company->person_idcard_pic){ ?><?=Utils::urlOfFile($company->person_idcard_pic)?><?php }else{ ?><?=Yii::$app->params["baseurl.static.corp"]?>/static/img/yulan.jpg<?php } ?>" id="img0"><img src="<?=Yii::$app->params["baseurl.static.corp"]?>/static/img/shenfenzheng.jpg"></div>
                </div>
              </li>
              <li>
                <div class="pull-left title-left text-center">上传营业执照照片</div>
                <div class="pull-left right-box">
                  <div class="form-group">
                      <label class="shangchuan" for="file1">上传图片</label>
                      <input type="file" id="file1" style="display:none;" name="corp_idcard_pic"><span class="pull-rigth"><em class="em-rad">*</em>提交照片需要注意以下几点</span>
                   </div>
                  <div class="tishi">
                        <p>1、加盖公章的企业营业执照副本扫描件</p>
                        <p>2、图片格式为bmp、jpg、jpeg、png，大小必须在3MB以内。建议使用500W像素以上相机拍摄。</p>
                   </div>
                   <div class="id-img">
                   <img src="<?php if($company->corp_idcard_pic){ ?><?=Utils::urlOfFile($company->corp_idcard_pic)?><?php }else{ ?><?=Yii::$app->params["baseurl.static.corp"]?>/static/img/yulan.jpg<?php } ?>" id="img1"><img src="<?=Yii::$app->params["baseurl.static.corp"]?>/static/img/zhizhao.jpg"></div>
                </div>
              </li>
              <?php if($company->exam_result!=$company::EXAM_LICENSE_PASSED && $company->exam_result!=$company::EXAM_ALL_PASSED){ ?>
                <button class="queding-bt">确定</button>
              <?php } ?>
           </ul>
        <?php ActiveForm::end(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- InstanceEndEditable -->

<script>
$("#file0").change(function(){
    var objUrl = getObjectURL(this.files[0]) ;
    console.log("objUrl = "+objUrl) ;
    if (objUrl) {
        $("#img0").attr("src", objUrl) ;
    }
}) ;
$("#file1").change(function(){
    var objUrl = getObjectURL(this.files[0]) ;
    console.log("objUrl = "+objUrl) ;
    if (objUrl) {
        $("#img1").attr("src", objUrl) ;
    }
}) ;
function getObjectURL(file) {
    var url = null ;
    if (window.createObjectURL!=undefined) { // basic
        url = window.createObjectURL(file) ;
    } else if (window.URL!=undefined) { // mozilla(firefox)
        url = window.URL.createObjectURL(file) ;
    } else if (window.webkitURL!=undefined) { // webkit or chrome
        url = window.webkitURL.createObjectURL(file) ;
    }
    return url ;
}
</script>
