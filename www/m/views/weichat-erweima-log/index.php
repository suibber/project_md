<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\WeichatErweimaLog;

/* @var $this yii\web\View */
/* @var $searchModel common\models\WeichatErweimaLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '二维码扫描记录');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    body{
        font-size: 16px;
    }
    .summary{
        padding:5px 0;
        color:#666;
    }
    .grid-view{
        padding:5px;
    }
    .pagination li > a, .pagination li > span{
        padding:0 8px;
        margin:3px 5px;
    }
    .pagination{
        margin: 15px auto;
        float: right;
    }
    .table th,.table td{
        padding:4px !important;
    }
    .data-count{
        background-color:#ccc;
        padding:6px;
    }
</style>
<div class="data-count"><?='扫描次数:'.$scan_count.' 扫描人数:'.$scanuser_count.' 扫描注册排重:'.$user_count.' 注册简历排重:'.$resume_count;?></div>
<div class="weichat-erweima-log-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => ['maxButtonCount'=>5,],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'erweima_id',
            //'openid',
            //'create_time',
            [
                'attribute'=>'create_time',
                'label' => '扫描时间',
                'filter' => $date_options,
                'value' => function($model){
                return $model->create_time;
            },
            ],
            [
            'label' => '扫描关注',
            'attribute' => 'follow_by_scan',
            'filter' => '',
            'value' => function($model){
                return $model::$FOLLOW_BY_SCANS[$model->follow_by_scan];
            }
            ],
            [
            'label' => '用户手机',
            'attribute' => 'username',
            'value' => function($model){
                return isset($model->user->user->username) ? '13*****'.substr($model->user->user->username,7) : '未注册';
            }
            ],
            //'has_bind',
            // 'follow_by_scan',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
