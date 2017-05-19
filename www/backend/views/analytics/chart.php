<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use common\models\District;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '数据';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="data-daily-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div id="w0" class="grid-view">
            <?php $form = ActiveForm::begin(['method'    => 'get']); 
                // 城市选项
                $model  = new District();
                $city   = $model->find()->where(['level'=>'province'])->asArray()->all();
                $cityarr= [0=>'全部'];
                foreach( $city as $k => $v ){
                    $cityarr[$v['id']]    = $v['name'];
                }
            ?>
                
        <div class="row">
            <div class="form-group col-xs-4 required">
                <select id="district-level" class="form-control" name="city_id">
                    <?php foreach($cityarr as $k => $v){ ?>
                        <option value="<?= $k ?>"><?= $v ?></option>
                    <?php } ?>
                </select>
                <div class="help-block"></div>
            </div> 
            <div class=" col-xs-4"> <button class="btn btn-success" type="submit">搜索</button> </div>
        </div>
        <div class="row">
            <a class="btn btn-info" href="./user">用户统计</a> 
            <a class="btn btn-info" href="./wechat">微信统计</a> 
            <a class="btn btn-info" href="./task">任务统计</a>
            |
            <a class="btn btn-primary" href="<?=Url::current(['days'=>7])?>">周统计</a> 
            <a class="btn btn-primary" href="<?=Url::current(['days'=>31])?>">月统计</a> 
            <a class="btn btn-primary" href="<?=Url::current(['days'=>95])?>">季度统计</a>
            <a class="btn btn-primary" href="<?=Url::current(['days'=>370])?>">年度统计</a> 
            <a class="btn btn-danger pull-right"
                data-confirm='如统计数据无误，请勿清空缓存，否则造成服务器压力，是否继续？' data-method="post" href="clearup">清空缓存</a>
        </div>
            <?php ActiveForm::end(); ?>
    </div>
</div>
<div class="container-fluid" id="chart" style="min-height:600px;">
</div>

<?php $this->beginBlock('js') ?>
<script>
$(function () {
    $('#chart').highcharts({
        chart: {
            zoomType: 'x',
        },
        title: {
            text: '<?=$title?>',
            x: -20 //center
        },
        xAxis: {
            categories: <?=json_encode($dates)?>
        },
        yAxis: {
            title: {
                text: '<?=$unit?>'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '<?=$unit?>'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: 
        <?php
         $f_datas = [];
         foreach ($datas as $k => $v) {
            $data = ['name'=> $labels[$k], 'data'=>array_values($v)];
            $f_datas[] = $data;
         }
         echo json_encode($f_datas);
        ?>
    });
});
</script>
<?php $this->endBlock('js') ?>

