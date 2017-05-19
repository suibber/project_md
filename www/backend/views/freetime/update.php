<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Freetime */

$this->title = 'Update Freetime: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Freetimes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="freetime-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
