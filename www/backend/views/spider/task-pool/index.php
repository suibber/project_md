<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\models\TaskPool;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TaskPoolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Task Pools';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-pool-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
        $cities = (new Query)->select('city')->from(TaskPool::tableName())->distinct()->all();
        $city_filter = [];
        foreach($cities as $row){
            $city_filter[$row['city']] = $row['city'];
        }

    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'company_name',
                'value' => function($model){
                    return '<a href='. 
                            Url::current(["TaskPoolSearch[company_name]"=>$model->company_name]) 
                       .'>'.$model->company_name.'</a>';
                },
                'format' => 'raw',
            ],
 
            'title',
            'contact',
            'release_date',
            'to_date',
            [
                'attribute' => 'phonenum',
                'value' => function($model){
                    return '<a href='. 
                            Url::current(["TaskPoolSearch[phonenum]"=>$model->phonenum]) 
                       .'>'.$model->phonenum.'</a>';
                },
                'format' => 'raw',
 
            ],
            [
                'attribute' => 'city',
                'filter' => $city_filter,
            ],
            [
                'label' => '来源',
                'attribute' => 'origin',
                'format' => 'raw',
                'value' => function($model){
                    return $model->origin.'<br /> <a href="' . $model->origin_url . '" title="查看愿帖子" target="_blank">
                            <span class="glyphicon glyphicon-eye-open"></span> </a> ';
                },
                'filter' =>[
                    'xiaolianbang'=>'校联邦',
                    'jianzhimao'=>'兼职猫',
                    'internal'=>'内部',
                    '58',
                ],
            ] ,

            // 'lng',
            // 'lat',
            // 'details:ntext',
            [
                'attribute' => 'has_poi',
                'format'=> 'boolean',
                'filter' => [true=>'是', false=>'否']
            ],
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status_label;
                },
                'filter' =>TaskPool::getStatus_options(),
            ],
            [
                'label' => '操作',
                'format'=>'raw',
                'value'=> function($model){
                    if ($model->status==$model::STATUS_ZOMBIE){
                        return '';
                    }
                    return '
                      <div style="width: 100px;">
                        <a href="/task-pool/view?id=' . $model->id . '" title="查看" target="_blank">
                             <span class="glyphicon glyphicon-eye-open"></span> 
                        </a>
                        <a target="_blank" href="/index.php/task-pool/transfer?id='.$model->id.'" title="添加到米多多" data-method="post">
                             <span class="glyphicon glyphicon-export"></span>
                        </a>
                        <a target="_blank" style="color: red;" href="/index.php/task-pool/transfer?company_name='. $model->company_name .'&origin='.$model->origin.'" title="将公司加入白名单" data-confirm="您确定要列该公司入<白名单>吗？"  >
                            <span class="glyphicon glyphicon-export"></span>
                        </a>
                        <a href="/index.php/task-pool/delete?id='. $model->id .'" title="删除记录" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post"  >
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                        <a style="color: red;"  href="/index.php/task-pool/delete?company_name='. $model->company_name .'&origin='.$model->origin.'" aria-label="删除" data-confirm="您确定要把此公司加入<黑名单>吗？" data-method="post" title="删除公司并列入<黑名单>">
                            <span class="glyphicon glyphicon-lock"></span>
                        </a>
                      <div>
                        ';
                }
            ],
        ],
    ]); ?>

</div>
