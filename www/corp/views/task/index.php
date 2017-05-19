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
          <div class="conter-title">职位管理<span style="font-size:12px;padding-left:20px;"><?= $user_task_promission['msg'] ?></span></div>
            <ul class="zhiwei-lis qy-zhiwei-lis">
            <?php foreach ($tasks as $task) {?>
                <li>
                   <div class="zhiwei-lis-title">
                        <h2 class="pull-left"><a href="<?=Yii::$app->params['baseurl.m']?>/task/view?gid=<?=$task->gid?>" target="blank"><?=$task->title?></a></h2>
                        <div class="pull-left bt-span">
                            <?php if($task->status == 0){?>
                                <?php if($user_task_promission['result'] !== false){ ?>
                                    <span class="task-refresh" gid="<?=$task->gid?>">刷新</span>
                                    <span class="task-edit" gid="<?=$task->gid?>">编辑</span>
                                <?php }?>
                            <span class="task-down" gid="<?=$task->gid?>">下线</span>
                            <span class="task-delete" gid="<?=$task->gid?>">删除</span>
                            <?php }else if($task->status == 50 || $task->status == 10){?>
                                <?php if($user_task_promission['result'] !== false){ ?>
                                    <span class="task-edit" gid="<?=$task->gid?>">编辑</span>
                                <?php }?>
                            <?php }?>
                        
                        </div>
                   </div>
                   <div>
                   <div class="pull-left zhiwei-lis-left">
                       <div><span><?=sprintf("%.1f", $task->salary).'元/'.$task->getSalary_unit_label()?></span><span><?=$task->getClearance_period_label()?></span>
                           <span><?=$task->gender_requirement?TASK::$GENDER_REQUIREMENT[$task->gender_requirement]:''?></span></div>
                       <div>北京－<?=$task->getAddress_label()?></div>
                       <div class="fb-sj"><?=$task->updated_time?$task->updated_time:$task->created_time?></div>
                   </div>
                   <div class="pull-left zhiwei-lis-right">
                        <div>编号：<?=$task->gid?></div>
                        <?php if($task->status == 0){?>
                        <div class="zhiwei-zt">
                           <div class="pull-left shenqing-zt text-center">已申请：<?=$task->got_quantity?>人</div>
                           <!--<div class="pull-left news text-center">new</div>-->
                        </div>
                        <?php }else{?>
                           <div class="zhiwei-zt">
                               <div class="bg-left pull-left"></div>
                               <div class="bg-text pull-left text-center"><?=$task->getStatus_label()?></div>
                               <div class="bg-right pull-left"></div>
                           </div>
                        <?php }?>
                   </div>
                   </div>
                </li>
              <?php }?>
              <!--
                <div class="pagination pagers pull-right pagination-lg">
                      <a href="#">&laquo;</a>
                      <a href="#">1</a>
                      <a href="#">2</a>
                      <a href="#">3</a>
                      <a href="#">4</a>
                      <a href="#">5</a>
                      <a href="#">&raquo;</a>
                </div>
            -->
            <?=LinkPager::widget(['pagination' => $pagination])?>
            </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- InstanceEndEditable -->
<?php
$this->registerJsFile(Yii::$app->params["baseurl.static.corp"] . '/static/js/task.js');
?>
