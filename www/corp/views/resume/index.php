<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
use corp\models\TaskApplicant;

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
        <?= $this->render('../layouts/sidebar', ['active_menu'=> 'resume' . Yii::$app->request->get('status')])?>
      </div>
      <div class="col-sm-10 padding-0 ">
        <div class="right-center">
          <div class="conter-title">简历管理</div>
            <dl class="jianli-lis">
                <dt class="tab-title">
                    <div class="pull-left tab1">应聘人</div>
                    <div class="pull-left tab2">应聘岗位</div>
                    <div class="pull-left tab3">联系方式</div>
                    <div class="pull-left tab4">投递时间</div>
                    <div class="pull-left tab5">操作<span>（2天未操作简历将失效）</span></div>
                </dt>
                <?php foreach ($task_apps as $task_app) { if(isset($task_app->resume->id)){?>
                <?php 
                    // 超过2天未处理，报名失效
                    if( (time()-strtotime($task_app->created_time)) > 60*60*24*TaskApplicant::STATUS_APPLY_OVERDAYS ){
                        if( $task_app->status == TaskApplicant::STATUS_WAIT_EXAMINE ){
                            $task_app->status = 30;
                        }
                    }
                ?>
                <dd>
                    <div class="pull-left tab1">
                        <div class="names" aid="<?=$task_app->resume->id?>"><span style="float: left; display: block; line-height: 20px; padding: 0 10px 0 0;color: #666;">
                            <?php if($task_app->status == $task_app::STATUS_WAIT_EXAMINE || $task_app->status == $task_app::STATUS_APPLY_SUCCEED) {?>
                                <a href="<?=$task_app->resume->common_url?>" target="blank"><?=$task_app->resume->name?></a>
                            <?php }else{ ?>
                                <?=$task_app->resume->name?>
                            <?php } ?>
                        </span></div>
                        <div class="jiben"><span><?=$task_app->resume->age?>岁</span><span><?=$task_app->resume->gender_label?></span><span><?=$task_app->resume->college?></span></div>
                    </div>
                    <div class="pull-left tab2 text-center borser-tab-right borser-tab-leftt"><a href="<?=Yii::$app->params['baseurl.m']?>/task/view?gid=<?=$task_app->task->gid?>" target="blank"><?=$task_app->task->title?></a></div>
                    <div class="pull-left tab3 text-center borser-tab-right">
                        <?php if($task_app->status == $task_app::STATUS_WAIT_EXAMINE || $task_app->status == $task_app::STATUS_APPLY_SUCCEED) {?>
                            <?=$task_app->resume->phonenum?>
                        <?php }else{ ?>
                            <?=substr($task_app->resume->phonenum,0,3)?>********
                        <?php } ?>
                    </div>
                    <div class="pull-left tab4 text-center borser-tab-right"><?=$task_app->created_time?></div>
                    <?php if($task_app->status == $task_app::STATUS_WAIT_EXAMINE) {?>
                    <div class="pull-left tab5"><button class="pull-left jishou" aid="<?=$task_app->id?>" taskid="<?=$task_app->task_id?>">接受报名</button><button class="pull-left jujue" aid="<?=$task_app->id?>">不合适</button></div>
                    <?php  }else{?>
                    <div class="pull-left tab5"><div class="yijishou"><?=$task_app->status_label?></div></div>
                    <?php }?>
                </dd>
                <?php }}?>
                <?=LinkPager::widget(['pagination' => $pagination])?>
<!--
                <div class="pagination pagers pull-right pagination-lg">
                      <a href="#" >&laquo;</a>
                      <a href="#" class="actives">1</a>
                      <a href="#">2</a>
                      <a href="#">3</a>
                      <a href="#">4</a>
                      <a href="#">5</a>
                      <a href="#">&raquo;</a>
                </div>
            -->
            </dl>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- InstanceEndEditable -->
<script src="<?=Yii::$app->params["baseurl.static.corp"]?>/static/js/data/moment.js"></script>
<script src="<?=Yii::$app->params["baseurl.static.corp"]?>/static/js/data/daterangepicker.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=GB9AZpYwfhnkMysnlzwSdRqq"> </script>
<?php
$this->registerJsFile(Yii::$app->params["baseurl.static.corp"] . '/static/js/resume.js');
?>
<!--=======以藏的弹出层======-->
<link href="<?=Yii::$app->params["baseurl.static.corp"]?>/static/css/tankuang.css" type="text/css" rel="stylesheet" />
<div class="cd-popup" role="alert" id="tongzhi-1">
	<div class="cd-popup-container">
		<p>本职位是否需要通知面试/培训时间？</p>
		<ul class="cd-buttons">
			<li><a href="javascript:;" class="need-notice">是</a></li>
			<li><a href="javascript:;" class="unneed-notice">否</a></li>
		</ul>
		<a href="#" class="cd-popup-close img-replace">关闭</a>
	</div> 
</div>
<div class="cd-popup" role="alert" id="tongzhi-2">
    <div class="cd-popup-container">
		<h2 id="task-title"></h2>
        <?php $form = ActiveForm::begin(['action'=>'/resume/pass-with-notice']);?>
        <div class="dx-1">
            <label><input name="type" type="radio" value="1" id="type1">面试</label>
            <label><input name="type" type="radio" value="2" id="type2">培训</label>
        </div>
        <div class="input-tj">
            <input type="text" name="meet_time" id="meet_time" value="" placeholder="约定时间">
            <input type="text" name="place" id="place" value="" placeholder="约定地点">
            <input type="text" name="linkman" id="linkman" value="" placeholder="联系人姓名">
            <input type="text" name="phone" id="phone" value="" placeholder="联系人电话">
            <input type="hidden" name="task_id" id="current-taskid" value="">
            <input type="hidden" name="task_app_id" value="" id="current-aid">
        </div>
		<!--ul class="cd-buttons">
			<li><a href="#">是</a></li>
			<li><a href="#">否</a></li>
		</ul-->
		<a href="#" class="cd-popup-close img-replace">关闭</a>
        <div class="notice_error_msg"></div>
        <button class="fabu-bt" >发送通知</button>
        <?php ActiveForm::end(); ?>
	</div>
</div>
