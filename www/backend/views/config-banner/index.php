<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\ConfigBanner;
use common\Utils;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ConfigBannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '城市广告位');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-banner-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', '创建广告位'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'status',
            [
                'attribute' => 'city_id',
                'label' => '城市',
                'filter' => ConfigBanner::getCityList(),
                'value' => function($model){
                    $city_list = $model::getCityList();
                    return $city_list[$model->city_id];
                }
            ],
            'title',
            //'pic',
            [
                'attribute' => 'pic',
                'label' => '图片',
                'format' => 'raw',
                'value' => function($model){
                    return '<img style="width:160px;height:60px;border:1px solid #999;" src="'.Utils::urlOfFile($model->pic).'" />';
                }
            ],
            'url',
            [
                'attribute' => 'status',
                'filter'=> ConfigBanner::$STATUS,
                'label' => '状态',
                'value' => function($model){
                    return $model::$STATUS[$model->status];
                }
            ],
            //'city_id',
            
            //'type',
            [
                'attribute' => 'display_order',
                'filter'=> ConfigBanner::$DISPLAY_ORDER,
                'value' => function($model){
                    return $model::$DISPLAY_ORDER[$model->display_order];
                }
            ],
            [
                'attribute' => 'task_id',
                'label'=> '任务id',
                'value' => function($model){
                    return $model->task_id;
                }
            ],
            //'display_order',
            // 'title',
            // 'pic',
            // 'url:url',
            // 'offline_date',
            // 'created_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
