<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AppReleaseVersionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'App Release Versions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-release-version-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create App Release Version', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'device_type',
                'value' => function($model){
                    return $model->device_type_label;
                }
            ] ,
            'app_version',
            'api_version',
            'html_version',
            'update_url:url',
            'release_time',
            'h5_map_file',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
