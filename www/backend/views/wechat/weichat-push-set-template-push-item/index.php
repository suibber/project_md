<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Task;
use common\models\WeichatPushSetTemplatePushList;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$template_push = WeichatPushSetTemplatePushList::find()->where(['id'=>$template_push_id])->one();

$this->title = $template_push->id.'--'.$template_push->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jz-weichat-push-set-template-push-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('返回', ['/weichat-push-set-template-push-list'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('增加推荐任务', ['create','template_push_id'=>$template_push_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'task_id',
            [
                'label' => '任务名称',
                'format' => 'raw',
                'value' => function($model){
                    $modelTask = Task::find()->where(['gid'=>$model->task_id])->one();
                    if($modelTask){
                        return "<a target='_blank' href='" . \Yii::$app->params['baseurl.m'] . "/task/view/?gid=" . $modelTask->gid ."'>" . $modelTask->title . "</a>";
                    }else{
                        return "未找到相关任务，请修改！";
                    }
                }
            ],
            'display_order',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
