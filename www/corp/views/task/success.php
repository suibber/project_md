<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use common\models\Task;
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
        <?= $this->render('../layouts/sidebar', ['active_menu'=> 'task' . Yii::$app->request->get('status')])?>
      </div>
      <div class="col-sm-10 padding-0 ">
        <div class="right-center">
            <div class="conter-title">发布兼职职位</div>
            <div class="fb-ts-tex"><img src="<?=Yii::$app->params["baseurl.static.corp"]?>/static/img/xialian.png" width="80" height="80">您的信息已经提交审核，审核通过后将自动发布</div>
            <div class="fb-ts-qrz">您还未通过身份审核，每天只能发布一条<a href="#">&nbsp;&nbsp;去认证&nbsp;&gt;</a></div>
            <!--<div class="btnn"><button class="fabu-btn1">再发一条</button><button class="fabu-btn1">预览</button></div>-->
            <div class="btnn"><span>再发一条</span>
              <button class="fabu-btn1">预览</button>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
