<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\JzWeichatPushQualityTask */

$this->title = '创建新的优单';
$this->params['breadcrumbs'][] = ['label' => 'Jz Weichat Push Quality Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jz-weichat-push-quality-task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
