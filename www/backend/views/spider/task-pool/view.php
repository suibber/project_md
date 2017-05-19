<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TaskPool */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Task Pools', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-pool-view">

    <h1>爬虫记录详情：<?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <a class="btn btn-danger" target="_blank" href="/index.php/task-pool/transfer?id=<?=$model->id?>" title="添加到米多多" data-method="post">
            导出任务
        </a>
    </p>
<?php 
$details = $model->list_detail(); 
?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label'=> '来源',
                'format'=>'raw',
                'value' => '<a target="_blank" href="' . $model->origin_url . '">来源页</a></h2>',
            ],
            [
                'label'=> '联系人',
                'value' => $details['contact'],
            ],
            [
                'label'=> '联系电话',
                'value' => $details['phonenum'],
            ],
            'company_name',
            'release_date',
            [
                'label'=> '任务开始日期',
                'value' => $details['from_date'],
            ],
            'to_date',
            'city',
            'origin_id',
            'origin',
            'lng',
            'lat',
            'has_poi:boolean',
            'created_time',
            [
                'label'=> '需要人数',
                'value' => $details['need_quantity'],
            ],
            [
                'label'=> '结算方式',
                'value' => isset($details['clearance_period'])?$details['clearance_period']:'无',
            ],
            [
                'label'=> '地址',
                'value' => $details['address'],
            ],
            [
                'label'=> '薪酬',
                'value' => $details['salary']. ' / ' .$details['salary_unit'],
            ],
            [
                'label'=> '详情',
                'format' => 'raw',
                'value' => $details['content'],
            ],
        ],
    ]) ?>



</div>
