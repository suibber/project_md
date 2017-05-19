<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UserAccount */

$this->title = Yii::t('app', 'Create User Account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-account-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
