<?php

use common\Utils;
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Resume;

/* @var $this yii\web\View */
/* @var $model common\models\Resume */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Resumes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="resume-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除?',
                'method' => 'post',
            ],
        ]) ?>
        <?php
            if (!$model->isNewRecord)
                echo "<a class='btn btn-primary' href='/resume/freetimes?user_id=" . $model->user_id . "'>编辑空闲时间</a>";
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute'=> 'user',
                'label'=> '账号',
                'format'=>'raw',
                'value'=>"<a target='_blank' href='/user/view?id=".$model->user_id."'>点击查看</a>"
            ],
            'name',
            'phonenum',
            'gender',
            [
                'attribute'=> 'gender',
                'label'=> '性别',
                'value'=>$model::$GENDERS[$model->gender]
            ],
            [   'attribute' => 'is_student',
                'value'=>$model->is_student?'是':'否',
            ],
            [   'attribute' => 'grade',
                'value'=>$model::$GRADES[$model->grade]
            ],
            'job_wishes',
            'birthdate',
            'degree',
            'nation',
            'height',
            'college',
            'avatar',
            'created_time',
            'updated_time',
            'birthdate',
            'home',
            'workplace',
            [   'attribute' => 'status',
                'value'=>$model::$STATUSES[$model->status]
            ],
            'gov_id',
            [
                'attribute' => 'gov_id_pic_front',
                'format' => 'raw',
                'value' => ($model->gov_id_pic_front?Html::img(Utils::urlOfFile($model->gov_id_pic_front), ['width'=>700, 'onclick'=>"window.open('".Utils::urlOfFile($model->gov_id_pic_front)."')"]):'无') ,
            ],
            [
                'attribute' => 'gov_id_pic_back',
                'format' => 'raw',
                'value' => ($model->gov_id_pic_back?Html::img(Utils::urlOfFile($model->gov_id_pic_back), ['width'=>700, 'onclick'=>"window.open('".Utils::urlOfFile($model->gov_id_pic_back)."')"]):'无') ,
            ],
            [
                'attribute' => 'gov_id_pic_take',
                'format' => 'raw',
                'value' => ($model->gov_id_pic_take?Html::img(Utils::urlOfFile($model->gov_id_pic_take), ['width'=>700, 'onclick'=>"window.open('".Utils::urlOfFile($model->gov_id_pic_take)."')"]):'无') ,
            ],
            [
                'attribute' => 'exam_status',
                'format' => 'raw',
                'value' => $model::$EXAM_STATUSES[$model->exam_status].($model->exam_status==$model::EXAM_NOT_PASSED?'【原因：'.$model->exam_note.'】':''),
            ],
        ],
    ]) ?>

<?php if ($model->exam_status==Resume::EXAM_PROCESSING) { ?>
    <div class="panel panel-default">
      <div class="panel-heading">认证审核 </div>
      <!--div class="panel-body">
        <p >身份证正面：</p>
        <?= Html::img(Utils::urlOfFile($model->gov_id_pic_front), ['width'=>700, 'onclick'=>"window.open('".Utils::urlOfFile($model->gov_id_pic_front)."')"]) ?>
        <p >身份证反面：</p>
        <?= Html::img(Utils::urlOfFile($model->gov_id_pic_back), ['width'=>700, 'onclick'=>"window.open('".Utils::urlOfFile($model->gov_id_pic_back)."')"]) ?>
        <p >身份证手持：</p>
        <?= Html::img(Utils::urlOfFile($model->gov_id_pic_take), ['width'=>700, 'onclick'=>"window.open('".Utils::urlOfFile($model->gov_id_pic_take)."')"]) ?>
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
                <textarea name="note" placeholder="不通过备注，用于提示用户" class="form-control custom-control" rows="3" style="resize:none">原因为：</textarea>
              </form>
            </div>
          </div>
        </div>
    </div>
<?php } ?>

</div>
