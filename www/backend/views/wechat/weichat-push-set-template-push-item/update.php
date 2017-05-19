<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\JzWeichatPushSetTemplatePushItem */

$this->title = '编辑推荐任务: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jz Weichat Push Set Template Push Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jz-weichat-push-set-template-push-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
