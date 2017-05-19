<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\JzWeichatPushSetTemplatePushList */

$this->title = '编辑推送模板: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Jz Weichat Push Set Template Push Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jz-weichat-push-set-template-push-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
