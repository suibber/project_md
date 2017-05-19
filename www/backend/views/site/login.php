<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\assets\AppAsset;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="/css/dashboard.css" rel="stylesheet">
    <?php echo isset($this->blocks['css'])?$this->blocks['css']:''; ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
<div class="container">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username')->label("手机号") ?>
                <?= $form->field($model, 'password')->passwordInput()->label("密码") ?>
                <?= $form->field($model, 'rememberMe')->checkbox()->label("记住我") ?>
                <div class="form-group">
                    <?= Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
