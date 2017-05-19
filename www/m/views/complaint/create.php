<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '我要举报';
$this->page_title = "举报";

$this->nav_left_link = 'javascript:window.history.back()';
?>

<?php $form = ActiveForm::begin(); ?>
<textarea id="<?= Html::getInputId($model, 'content') ?>" name="<?= Html::getInputName($model, 'content') ?>" id="textarea" class="text-area" placeholder="有任何意见和问题，请填入此处，我们会及时联系您"><?=$model->content?></textarea>
<?php if ($model->hasErrors('content')) { ?>
    <p style="padding: 5px 20px 5px 20px;color: red;">
        <?=$model->getFirstError('content') ?>
    </p >
<?php } ?>
    <input value="<?=$model->phonenum?$model->phonenum:$default_phonenum ?>" name="<?=Html::getInputName($model, 'phonenum')?>" id="<?=Html::getInputId($model, 'content')?>" type="text" pattern="\d+" class="input" placeholder="联系方式" />
<?php if ($model->hasErrors('phonenum')) { ?>
    <p style="padding: 20px 20px 5px 20px ;  color: red;">
        <?=$model->getFirstError('phonenum') ?>
    </p >
<?php } ?>
  <button type="submit"  class="btn-anniu"> 提交 </button>
<?php $form = ActiveForm::end(); ?>
