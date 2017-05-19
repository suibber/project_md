<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ServiceTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '任务类型';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-type-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新建任务类型', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            'created_time',
            'updated_time',
            'modified_by',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model::$STATUSES[$model->status];
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
