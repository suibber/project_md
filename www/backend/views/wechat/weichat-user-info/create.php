<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WeichatUserInfo */

$this->title = Yii::t('app', 'Create Weichat User Info');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Weichat User Infos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weichat-user-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
