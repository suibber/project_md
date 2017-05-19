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
          <div class="conter-title">职位管理</div>
            <div class="tishi-cs">
                您今天的发布次数已经用完，请明天再来哟 ~ 
                <?php if($user_task_promission['exam_result'] != 32){ ?>
                    立即认证可增加发布条数，<a href="/user/corp-cert">去认证</a>
                <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- InstanceEndEditable -->
