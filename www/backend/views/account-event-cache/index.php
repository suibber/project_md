<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\AccountEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AccountEventCacheSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '工资流水-待发工资');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-event-cache-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', '上传流水'), ['upload'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', '发放工资 （'.$money_all.'元）'), ['payoff'], 
            [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', "发放后资金实时到账，不可撤销，是否继续？\n发放过程中请勿进行其他操作！"),
                    'method' => 'post',
                ]
            ]
        ) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            'date',
            'created_time',
            'task_gid',
            [
                'label' => '姓名',
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
            // 'balance',
            [
                'label' => '导入人',
                'value' => function($model){
                    return isset($model->operator->name) ? $model->operator->name : '';
                }
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{delete}'],
        ],
    ]); ?>

</div>
