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
        <?= $this->render('../layouts/sidebar', ['active_menu'=> 'time_book'])?>
      </div>
      <div class="col-sm-10 padding-0 ">

        <div class="right-center">
         <div class="conter-title">考勤管理</div>
            <dl class="daka_lis">
                <?php foreach($tasks as $task){ ?>
                <dd>
                    <div class="tab_1">
                        <div class="names"><a target="_blank" href="<?=Yii::$app->params['baseurl.m']?>/task/view?gid=<?=$task->gid?>"><?=$task->title?></a></div>
                        <div class="tab_tag">
                            <span>编号：<?=$task->gid?></span>
                            <span> <em><?=$task->clearance_period_label?></em> | <em><?=intval($task->salary)?>元/<?=$task->salary_unit_label?></em> </span>
                            <span>开工时间：<?=substr($task->from_date, 5)?>－<?=substr($task->to_date, 5)?></span>
                        </div>
                    </div>
                    <div class="tab_2">
                    <div class="tab_text">状态：<?=$task->status_label?></div>
                        <?php if ($task->time_book_opened) { ?>
                            <a href="/time-book/worker-summary?gid=<?=$task->gid?>">管理</a>
                        <?php } else {?>
                            <a href="/time-book/worker-summary?gid=<?=$task->gid?>">打开考勤</a>
                        <?php }?>
                    </div>
                </dd>
                <?php } ?>
                <div class="pagination pagers pull-right pagination-lg">
<?=LinkPager::widget(['pagination' => $pages,
    'maxButtonCount'=>5,
    'lastPageLabel'=>'末页', 'nextPageLabel'=>'>>',
    'prevPageLabel'=>'<<', 'firstPageLabel'=>'首页'])?>
                </div>
            </dl>
        </div>
      </div>
    </div>
  </div>
</div>
