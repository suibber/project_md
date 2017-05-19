<?php

use common\Utils;
use common\models\Company;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Company */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['change-status', 'id' => $model->id, 'status'=>Company::STATUS_DELETED], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除?',
                'method' => 'post',
            ],
        ]) ?>
        -
<?php 
if ($model->status!=Company::STATUS_DELETED) {
        if ($model->status!=Company::STATUS_FREEZED) { 
            echo Html::a('冻结', ['change-status', 'id' => $model->id, 'status'=>Company::STATUS_FREEZED], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '确定冻结?',
                    'method' => 'post',
                ],
            ]);
        } else {
            echo Html::a('解除冻结', ['change-status', 'id' => $model->id, 'status'=>Company::STATUS_OK], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => '确定解冻?',
                    'method' => 'post',
                ],
            ]);
        }
}
?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'contact_name',
            'contact_phone',
            'contact_email',
            'person_idcard',
            [
                'attribute' => 'person_idcard_pic',
                'format' => 'raw',
                'value' => ($model->person_idcard_pic?Html::img(Utils::urlOfFile($model->person_idcard_pic), ['width'=>700, 'onclick'=>"window.open('".Utils::urlOfFile($model->person_idcard_pic)."')"]):'无') ,
            ],
            'corp_idcard',
            [
                'attribute' => 'corp_idcard_pic',
                'format' => 'raw',
                'value' => $model->corp_idcard_pic?Html::img(Utils::urlOfFile($model->corp_idcard_pic), ['width'=>700, 'onclick'=>"window.open('".Utils::urlOfFile($model->corp_idcard_pic)."')"]):'无',
            ],
            'exam_result_label',
            'exam_status_label',
            'status_label',
        ],
    ]) ?>
<?php if ($model->exam_status==Company::EXAM_PROCESSING) { ?>
    <div class="panel panel-default">
      <div class="panel-heading">认证审核 </div>
      <!--div class="panel-body">
        <p >身份证:</p>
        <?= Html::img(Utils::urlOfFile($model->person_idcard_pic), ['width'=>700, 'onclick'=>"window.open('".Utils::urlOfFile($model->person_idcard_pic)."')"]) ?>
        <?php if ($model->corp_idcard_pic) { ?>
        <p >营业执照:</p>
        <?= Html::img(Utils::urlOfFile($model->corp_idcard_pic), ['width'=>700, 'onclick'=>"window.open('".Utils::urlOfFile($model->corp_idcard_pic)."')"]) ?>
        <?php } ?>
      </div-->
        <div class="panel-footer">
          <div class="row">
            <div class="col-xs-3">
            <?=Html::a('通过审核', ['examine', 'id' => $model->id, 'passed'=>1], [
                'class' => 'btn btn-success',
                'data' => [
                    'method' => 'post',
                ],
            ])?>
            </div>
            <div class="col-xs-9">
              <form action="examine?id=<?=$model->id?>&passed=0" method="post">
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                <input type="hidden" name="id" value="<?=$model->id?>">
                <input type="hidden" name="passed" value="0">
                <button class="btn btn-danger" type="submit">审核不通过</button>
                <br />
                <textarea name="note" placeholder="不通过备注，用于提示企业" class="form-control custom-control" rows="3" style="resize:none"></textarea>
              </form>
            </div>
          </div>
        </div>
    </div>
<?php } ?>
</div>
