<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = '创建任务订单';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'title') ?>
                <?= $form->field($model, 'description')->textArea(['rows'=>8]) ?>
                <div class="form-group">
                    <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>


</div>
