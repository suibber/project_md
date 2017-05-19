<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TaskCollection */

$this->title = 'Create Task Collection';
$this->params['breadcrumbs'][] = ['label' => 'Task Collections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-collection-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
