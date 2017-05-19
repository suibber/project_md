<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Task;
use common\models\ConfigRecommend;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ConfigRecommendSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '后台配置-推荐兼职';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-recommend-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加推荐兼职', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'city_id',
                'label' => '城市',
                'filter' => ConfigRecommend::getCityList(),
                'value' => function($model){
                    $city_list = $model::getCityList();
                    return $city_list[$model->city_id];
                }
            ],
            'task_id',
            //'type',
            [
                'label' => '类型',
                'format'=> 'raw',
                'value' => function($model){
                    return $model->type.'--'.Yii::$app->params['config']['recommend_type'][$model->type];
                }
            ],
            [
                'label' => '任务名称',
                'format'=> 'raw',
                'value' => function($model){
                    $task_id    = $model->task_id;
                    $task_name  = Task::find()->where(['gid'=>$task_id])->asArray()->one();
                    $name       = isset($task_name['title']) ? $task_name['title'] : '未找到，请修改';
                    return $name;
                }
            ],
            'display_order',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
