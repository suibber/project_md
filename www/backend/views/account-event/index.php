<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\AccountEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AccountEventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '工资流水-已发工资（'.$money_all.' 元）');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-event-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'date',
            'created_time',
            'task_gid',
            [
                'label' => '姓名',
                'attribute' => 'user_name',
                'format'=>'raw',
                'value' => function($model){
                    return isset($model->userinfo->name) ? $model->userinfo->name : '';
                }
            ],
            'user_id',
            [
                'label' => '手机号',
                'value' => function($model){
                    return isset($model->userinfo->phonenum) ? $model->userinfo->phonenum : '';
                }
            ],
            'value',
            'note',
            [
                'label' => '类型',
                'format'=> 'raw',
                'value' => function($model){
                    return AccountEvent::$TYPES[$model->type];
                },
                'attribute' => 'type',
                'filter'    => AccountEvent::$TYPES
            ],
            'related_id',
            [
                'label' => '锁住',
                'attribute' => 'locked',
                'value' => function($model){
                    return AccountEvent::$LOCKEDS[$model->locked];
                },
                'filter'    => AccountEvent::$LOCKEDS
            ],
            [
                'label' => '导入人',
                'value' => function($model){
                    return isset($model->operator->name) ? $model->operator->name : '';
                }
            ],
            // 'balance',
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
