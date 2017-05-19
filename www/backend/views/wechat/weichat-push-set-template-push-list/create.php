<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\JzWeichatPushSetTemplatePushList */

$this->title = '创建推送模板';
$this->params['breadcrumbs'][] = ['label' => 'Jz Weichat Push Set Template Push Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jz-weichat-push-set-template-push-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
