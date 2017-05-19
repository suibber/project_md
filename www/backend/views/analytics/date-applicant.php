<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use common\models\District;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $date . '的报名统计';
$this->params['breadcrumbs'][] = $this->title;

$cities = [];
foreach (District::findAll(['level'=>'city', 'is_alive'=>1]) as $city){
    $cities[$city->id] = $city->short_name;
}
?>
<div class="data-daily-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div>
      日期： <input type="date" id="date" value="<?=$date?>"/>
<?php $this->beginBlock('js') ?>
<script>
$(function(){
    $("#date").change(function(){
        var date = $(this).val();
        location.search="?date=" + date;
    });
});
</script>
<?php $this->endBlock('js') ?>
    </div>

    <div class="col-xs-4">
    <table class="table table-striped">
        <thead>
        <tr>
            <td>城市名</td> <td> 报名状况</td>
        </tr>
        </thead>
        <tbody>
    <?php foreach ($data as $city_id=>$row) { 
?>
        <tr class="<?=$row['increase']==0?'':($row['increase']>0?'danger':'success')?>">
        <td><a href="/data-user?type_id=2&city_id=<?=$city_id?>"><?=$cities[$city_id]?></a></td>
        <td><?=$row['count']?> <span class="pull-right"><?=$row['increase']?><span class="<?=$row['increase']==0?'glyphicon glyphicon-pause':($row['increase']>0?'glyphicon glyphicon-arrow-up':'glyphicon glyphicon-arrow-down')?>"></span></span></td>
        </tr>
    <?php } ?>
        </tbody>
    </table>
    </div>
</div>
