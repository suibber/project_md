<?php

use common\models\Company;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '企业库';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Company', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'label' => '渠道来源',
                'filter' => Company::$ORIGINS,
                'attribute' => 'origin',
                'value' => function($model){
                    return Company::$ORIGINS[$model->origin];
                }
            ],
            'user_id',
            [
                'label' => '企业名称',
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model){
                    return '<a href="/task?TaskSearch[company_id]='.$model->id.'" target="_blank">'.$model->name.'</a>';
                }
            ],
            'created_time',
            'contact_name',
            'contact_phone',
            'contact_email',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status_label;
                },
                'filter' => Company::$STATUSES,
            ],
            [
                'attribute' => 'exam_status',
                'value' => function($model){
                    return $model->exam_status_label;
                },
                'filter' => Company::$EXAM_STATUSES,
            ],
            [
                'attribute' => 'exam_result',
                'value' => function($model){
                    return $model->exam_result_label;
                },
                'filter' => Company::$EXAM_RESULTS,
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
