<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Resume;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '扫描次数:'.$scan_count.' 扫描人数:'.$scanuser_count.' 扫描注册排重:'.$user_count.' 注册简历排重:'.$resume_count;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weichat-erweima-log-index">

    <h1 style='font-size:18px;'><?= Html::encode($this->title) ?></h1>

    <!--p>
        <?= Html::a('Create Weichat Erweima Log', ['create'], ['class' => 'btn btn-success']) ?>
    </p-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'erweima_id',
            'openid',
            'create_time',
            // 'has_bind',
            [
                'label' => '扫描关注',
                'value' => function($model){
                    return $model::$FOLLOW_BY_SCANS[$model->follow_by_scan];
                },
                'attribute' => 'follow_by_scan',
            ],
            [
                'label' => '注册账号',
                'value' => function($model){
                    return isset($model->user->user->username) ? $model->user->user->username : '未注册';
                },
            ],
            [
                'label' => '简历姓名',
                'value' => function($model){
                    return isset($model->user->resume->name) ? $model->user->resume->name : '';
                },
            ],
            [
                'label' => '性别',
                'value' => function($model){
                    return isset($model->user->resume->gender) ? Resume::$GENDERS[$model->user->resume->gender] : '';
                },
            ],
            [
                'label' => '学生',
                'value' => function($model){
                    return isset($model->user->resume->is_student) ? Resume::$STUDENTS[$model->user->resume->is_student] : '';
                },
            ],
            [
                'label' => '学校',
                'value' => function($model){
                    return isset($model->user->resume->college) ? $model->user->resume->college : '';
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
