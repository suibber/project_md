<?php
use yii\widgets\DetailView;
?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'label'=>'概况',
            'format'=> 'raw',
            'value'=> implode(' , ', [$model->id, $model->title, $model->contact,
                $model->contact_phonenum, $model->salary.'/'.$model->salary_unit_label,
                $model->from_date . ' - ' . $model->to_date,
                $model->service_type->name, $model->status_label,
            ]) . '
                <a href="/task/update?id='.$model->id.'" target="_blank" class="pull-right">编辑</a>
            '
        ]
    ],
]) ?>


