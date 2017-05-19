<?php

use yii\widgets\LinkPager;
use yii\helpers\Url;

?>
<div class="gl_title_top">
    <div class="yuangong"><span>员工总数</span><span class="span_t"><?=$worker_count?></span></div>
    <div class="zaigang"><span>今日该上工</span><span class="span_t"><?=$today_worker_count?></span></div>
    <div class="lizhi"><span>今日该离线</span><span class="span_t"><?=$worker_count-$today_worker_count?></span></div>
</div>
 <ul class="tianxie-box1" style="border:none">
    <li>
      <form action="#" method="GET">
          <input type="hidden" name="gid" value="<?=$task->gid?>">
          <input type="text" name="resume_name" value="<?=Yii::$app->request->get('resume_name')?>" class="in_put" placeholder="兼职人姓名">
          <div class="time-xz">
            <div class="nice-select times" name="nice-select">
              <input type="text" name="address" placeholder="工作地点" value="<?=Yii::$app->request->get('address')?>">
              <ul style="display: none;">
                <li></li>
                <?php foreach($addresses as $address) { ?>
                <li><?=$address?></li>
                <?php } ?>
              </ul>
            </div>
          </div>
          <button class="sech_1" style="background: #fff; ">搜索</button>
      </form>
    </li>
  </ul>

  <dl class="jz_tab">
    <dt>
      <div class="jz_tab_1">兼职人员</div>
      <div class="jz_tab_2">当前工作地点</div>
      <div class="jz_tab_3">已上岗天数</div>
      <div class="jz_tab_4">工作记录</div>
      <div class="jz_tab_5">操作</div>
    </dt>
<?php foreach ($models as $applicant) {
    $resume = $applicant->resume;
    $address = $applicant->address;
    $s = null;
    $user_id = strval($applicant->user_id);
    if (isset($summaries[$user_id])){
        $s = $summaries[$user_id];
    }
?>
    <dd>
      <div class="jz_tab_1"><a href="#"><?=$resume->name?></a></div>
      <div class="jz_tab_2"><?=$address?$address->title:'无'?></div>
      <div class="jz_tab_3"><?=$s?$s->past_count:0?>天(总<?=$s?($s->count):0?>天)</div>
      <div class="jz_tab_4">
        <?php if($s){ ?>
            <span>迟到<em><?=$s->on_late_count?></em></span>
            <span>早退<em><?=$s->off_early_count?></em></span>
            <span>旷工<em class="red"><?=$s->out_work_count?></em></span>
            <span>记录<em><?=$s->noted_count?></em></span>
        <?php } else { ?>
            <span>无记录</span>
        <?php }?>
      </div>
      <div class="jz_tab_5">
        <div class="box_t">
            <span style="display: none;"><a target="_blank" href="/time-book/settings?user_id=<?=$resume->user_id?>&task_id=<?=$task->id?>">工作内容设置</a></span>
            <span><a target="_blank" href="/time-book/detail?user_id=<?=$resume->user_id?>&task_id=<?=$task->id?>">工作明细</a></span>
        </div>
      </div>
    </dd>
<?php } ?>
  </dl>
<div class="daka_foot">
<?=LinkPager::widget(['pagination' => $pages,
    'maxButtonCount'=>5,
    'lastPageLabel'=>'末页', 'nextPageLabel'=>'>>',
    'prevPageLabel'=>'<<', 'firstPageLabel'=>'首页'])?>

    <div class="daka_r">
      <a target="_blank" href="<?=Url::current(['excel'=>1])?>" class="xiazai">下载考勤表</a>
      <a href="/time-book/add?gid=<?=$task->gid?>">添加考勤日程</a>
    </div>
</div>

