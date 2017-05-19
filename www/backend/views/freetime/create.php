<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Freetime */

$this->title = 'Create Freetime';
$this->params['breadcrumbs'][] = ['label' => 'Freetimes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="freetime-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
