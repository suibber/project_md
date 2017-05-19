<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\controllers\WeichatPushSetPushsetController;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '微信推送-附近';
$this->params['breadcrumbs'][] = $this->title;
//print_r($ops);exit;
?>
<div class="jz-weichat-push-set-pushset-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('创建推送消息（上午、下午各1条）', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => '推送时间',
                'format' => 'raw',
                'value' => function($model){
                    global $ops;
                    if( !$ops ){
                        $ops    = WeichatPushSetPushsetController::getOps();
                    }
                    return $ops['pushtime'][$model->push_time];
                }
            ],
            [
                'label' => '推送方式',
                'format' => 'raw',
                'value' => function($model){
                    global $ops;
                    return $ops['pushtype'][$model->push_way];
                }
            ],
            [
                'label' => '状态',
                'format' => 'raw',
                'value' => function($model){
                    global $ops;
                    return $ops['status'][$model->status];
                }
            ],
            [
                'label' => '推送模板',
                'format' => 'raw',
                'value' => function($model){
                    global $ops;
                    //return "<a href='/weichat-push-set-template-push-item?template_push_id=" . $model->template_push_id ."'>".$ops['tmp_list'][$model->template_push_id] . "</a>";
                    return $ops['tmp_list'][$model->template_push_id];
                }
            ],
            // 'template_weichat_id',
            // 'created_time',
            // 'update_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
