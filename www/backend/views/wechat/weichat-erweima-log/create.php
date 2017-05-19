<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WeichatErweimaLog */

$this->title = 'Create Weichat Erweima Log';
$this->params['breadcrumbs'][] = ['label' => 'Weichat Erweima Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weichat-erweima-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
