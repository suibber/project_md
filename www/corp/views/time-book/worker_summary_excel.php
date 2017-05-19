<?php

use yii\widgets\LinkPager;

?>
<table border='1'>
    <tr>
      <td>兼职人员</td>
      <td>当前工作地点</td>
      <td>应上岗天数</td>
      <td>已上岗天数</td>
      <td>迟到次数</td>
      <td>早退次数</td>
      <td>旷工次数</td>
      <td>记录数</td>
    </tr>

<?php foreach ($models as $applicant) {
    $resume = $applicant->resume;
    $address = $applicant->address;
    $s = null;
    $user_id = strval($applicant->user_id);
    if (isset($summaries[$user_id])){
        $s = $summaries[$user_id];
    }
?>
    <tr>
      <td><?=$resume->name?></td>
      <td><?=$address?$address->title:'无'?></td>
      <td><?=$s?($s->count):0?></td>
      <td><?=$s?$s->past_count:0?></td>
    <?php if($s){ ?>
      <td> <?=$s->on_late_count?> </td>
      <td><?=$s->off_early_count?> </td>
      <td><?=$s->out_work_count?> </td>
      <td><?=$s->noted_count?></td>
    <?php } else { ?>
      <td colspan='4'>无记录</td>
    <?php }?>
    </tr>
<?php } ?>
  </table>

