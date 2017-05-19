<?php 
use yii\widgets\LinkPager;

?>

<!-- 微信推荐任务 -->
<?php foreach ($tasks as $task){ ?>
<a href="/task/view?gid=<?=$task->gid?>" class="list-group-item">
  <div class="panel panel-default zhiwei-list"> 
    <div class="border-bt">
        <div class="panel-heading">
            <h3 class="panel-title"><?=$task->title ?></h3>
        </div>
      <div class="panel-body list-bt">
        <p> <span class="label label-default">
            ￥<?=floor($task->salary) ?>/<?= $task::$SALARY_UNITS[$task->salary_unit] ?>
           </span> </p>
      </div>
    </div>
    <div class="border-bt">
      <div class="panel-body lnk">
        <p><span class="glyphicon glyphicon-time" aria-hidden="true"></span>
            <?=\Yii::$app->formatter->asDate($task->from_date);?>至<?=\Yii::$app->formatter->asDate($task->to_date)?>
        </p>
        <div class="te-x">
          <p><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
            <?php
            if ($task->city) {
                echo $task->city->name . '-';
            }
            if ($task->district) {
                echo $task->district->name . '-';
            } ?>
            <?=$task->address?>
          </p>
        </div>
      </div>
    </div>
  </div>
</a>
<?php } ?>
