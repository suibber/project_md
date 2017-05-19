<?php

use yii\helpers\Html;
use yii\grid\GridView;

use common\models\Resume;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ResumeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '简历';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resume-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建简历', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'phonenum',
            ['attribute' => 'gender', 'value'=>
                function ($model){
                    return Resume::$GENDERS[$model->gender];
                },
            'filter'=>Resume::$GENDERS
            ],
            ['attribute' => 'is_student', 'value'=>function ($model){
                    return $model->is_student?'是':'否';
                },
            'filter'=>[true=> '是', false=>'否']
            ],
            'college',
            [
                'attribute' => 'status', 'value'=>
                function ($model){
                    return $model->status_label;
                },
            'filter'=>Resume::$STATUSES
            ],
            'gov_id',
            [
                'attribute' => 'exam_status',
                'value' => function($model){
                    return $model::$EXAM_STATUSES[$model->exam_status];
                },
                'filter' => Resume::$EXAM_STATUSES,
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
