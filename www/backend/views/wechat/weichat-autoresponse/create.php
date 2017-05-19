<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WeichatAutoresponse */

$this->title = '创建自动回复';
$this->params['breadcrumbs'][] = ['label' => 'Weichat Autoresponses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weichat-autoresponse-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
