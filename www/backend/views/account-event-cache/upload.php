<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PayoutSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '导入';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payout-index">

    <h1>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <?= Html::a(Yii::t('app', '返回'), ['index'], ['class' => 'btn btn-success']) ?>
            <input style="font-size:14px;margin-top:5px;" type="file"  name="excelfile">
            <input type="submit"  class="btn btn-danger" name="pubmit" value="确认上传，上传过程中请勿进行其他操作">
            <?= Html::a(Yii::t('app', '下载Excel格式模板'), ['downloaddemo'], ['class' => 'btn btn-success','target'=>'_blank']) ?>
        <?php ActiveForm::end(); ?>
    </h1>
    <?php if( isset($import_data['import_data']) && count($import_data['import_data']) ){ ?>
    <table>
        <tr class="excel-head">
            <th>工资流水id</th>
            <th>日期</th>
            <th>上传时间</th>
            <th>职位id</th>
            <th>职位名称</th>
            <th>姓名</th>
            <th>用户id</th>
            <th>手机号</th>
            <th>金额</th>
            <th>金额说明</th>
        </tr>
        <?php foreach($import_data['import_data'] as $k => $v){ ?>
            <tr>
                <td><?=$v['id']?></td>
                <td><?=$v['date']?></td>
                <td><?=$v['created_time']?></td>
                <td><?=$v['task_gid']?></td>
                <td><?=$v['task_title']?></td>
                <td><?=$v['user_name']?></td>
                <td><?=$v['user_id']?></td>
                <td><?=$v['user_pbone']?></td>
                <td><?=$v['value']?></td>
                <td><?=$v['note']?></td>
            </tr>
        <?php } ?>
    </table>
    <?php } ?>
    <?php if( isset($import_data['errmsg']) ){ ?>
        <div><?=$import_data['errmsg']?></div>
    <?php } ?>
</div>

<style>
    table td,table th{
        border:1px solid #999;
    }
    .excel-head{
        background-color:#ccc;
        font-weight:bold;
    }
    .download{
        font-size:14px;
        text-decoration:none;
        color:blue;
    }
</style>