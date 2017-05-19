<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = "为用户添加角色";
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

<form id="w0" class="form-horizontal kv-form-horizontal" action="#" method="post">
    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
    <div class="form-group required <?= $message?'has-error':'' ?>">
        <label class="control-label col-md-2" for="phonenum">注册手机号</label>
        <div class="col-md-10">
            <input type="text" id="phonenum" class="form-control" name="phonenum" value="<?=$phonenum?>" maxlength="500">
        </div>
        <div class="col-md-offset-2 col-md-10"><div class="help-block"><?=$message?></div></div>
    </div>
    <div class="form-group required">
        <label class="control-label col-md-2" for="role">角色</label>
        <div class="col-md-10">
<select id="role" class="form-control" name="role">
<?php 
foreach (Yii::$app->authManager->getRoles() as $role) { ?>
    <option value="<?=$role->name?>"><?=$role->name?></option>
<?php } ?>
</select>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">设置</button>    </div>
    </form>

</div>
