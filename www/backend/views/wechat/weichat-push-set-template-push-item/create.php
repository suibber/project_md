<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\JzWeichatPushSetTemplatePushItem */

$this->title = '增加推荐任务';
$this->params['breadcrumbs'][] = ['label' => 'Jz Weichat Push Set Template Push Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jz-weichat-push-set-template-push-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
