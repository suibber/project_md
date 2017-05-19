<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use common\models\District;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $city->short_name . '的报名统计';
$this->params['breadcrumbs'][] = $this->title;
$dates = array_keys($data);
$chart_data = array_values($data);
$unit = '人次';
?>
<div class="data-daily-index">

    <h1><?= Html::encode($this->title) ?></h1>
</div>
<div class="container-fluid" id="chart" style="min-height:600px;">
<?php $this->beginBlock('js') ?>
<script>
$(function () {
    $('#chart').highcharts({
        chart: {
            zoomType: 'x',
        },
        title: {
            text: '<?=$this->title?>',
        },
        xAxis: {
            type: 'datetime'
        },
        yAxis: {
            title: {
                text: '<?=$unit?>'
            },
       },
        tooltip: {
            valueSuffix: '<?=$unit?>'
        },
        series: {
            type: 'area',
            name: '日报名',
            data: <?php echo json_encode($data); ?>
        }
    });
});
</script>
<?php $this->endBlock('js') ?>

