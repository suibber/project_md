<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\Utils;
use common\WechatUtils;

/* @var $this yii\web\View */
/* @var $model common\models\TaskApplicantOnlinejob */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Task Applicant Onlinejobs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-applicant-onlinejob-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [   'attribute' => 'status',
                'value'=>$model::$STATUS[$model->status]
            ],
            'reason',
            'app_id',
            'user_id',
            'task_id',
            'needinfo:ntext',
            'has_sync_wechat_pic',
            'need_phonenum',
            'need_username',
            'need_person_idcard',
            'created_time',
            'updated_time',
        ],
    ]) ?>
<?php if($model->status == $model::STATUS_UNKNOWN){ ?>
    <div class="panel panel-default">
      <div class="panel-heading">认证审核 </div>
      <div class="panel-body">
      <?php foreach($needinfos as $needinfo){ ?>
        <b><?=$needinfo->is_required?'<span style="color:red">(*)</span>':''?><?=$needinfo->intro?>：</b><br />
        <?php foreach(unserialize($model->needinfo) as $k => $info){ ?>
            <?php if($needinfo->id == $k){ ?>
                <?php if($model->has_sync_wechat_pic){ ?>
                    <img src='<?= Utils::urlOfFile($info) ?>' width="400" />
                <?php }else{ ?>
                    <img src='<?= "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".WechatUtils::getAccessToken()."&media_id=".$info ?>' width="400" />
                <?php } ?>
            <?php } ?>
        <?php } ?>
        <hr />
      <?php } ?>
      </div>
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
                <textarea name="note" placeholder="不通过备注，用于提示用户" class="form-control custom-control" rows="3" style="resize:none"></textarea>
              </form>
            </div>
          </div>
        </div>
    </div>
<?php } ?>
</div>
