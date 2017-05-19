<?php

namespace api\miduoduo\v1\models;

use Yii;

use common\Utils;
use common\models\Resume;
use common\models\Task;
use common\models\TaskApplicant;
use common\models\TaskNotice;
use common\WeichatBase;

class CompanyEditApplicantAction extends \yii\rest\UpdateAction
{

    public function run($id)
    {
        /* @var $model ActiveRecord */
        $model = $this->findModel($id);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }
        $model->scenario = $this->scenario;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if( $this->checkAppTask($model->user_id, $model->task_id) ){
            if ($model->save() === false && !$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
            }else{
                $params = Yii::$app->getRequest()->getBodyParams();
                $status = isset($params['status']) ? $params['status'] : '';
                if( $status == TaskApplicant::STATUS_APPLY_SUCCEED ){
                    // send success msg to user
                    $this->pushResultMsg(
                        $model->task_id,
                        $model->user_id,
                        TaskApplicant::STATUS_APPLY_SUCCEED
                    );
                }elseif( $status == TaskApplicant::STATUS_APPLY_FAILED ){
                    // send failed msg to user
                    $this->pushResultMsg(
                        $model->task_id,
                        $model->user_id,
                        TaskApplicant::STATUS_APPLY_FAILED
                    );
                }
            }
            return $model;
        }else{
            return false;
        }
    }

    public function pushResultMsg($task_id,$user_id,$status){
        $weichat_base   = new WeichatBase();
        $weichat_id     = $weichat_base::getLoggedUserWeichatID($user_id);
        $task   = Task::find()
            ->where(['id'=>$task_id])
            ->with('company')
            ->with('service_type')
            ->one();
        if( $status == TaskApplicant::STATUS_APPLY_SUCCEED ){
            if( $weichat_id ){
                Yii::$app->wechat_pusher->toApplicantTaskAppliedDonePassYes($task,$weichat_id);
            }else{
                $resume = Resume::find()->where(['user_id'=>$user_id])->one();
                Yii::$app->sms_pusher->push(
                    $resume->phonenum,
                    ['task'=>$task,'resume'=>$resume],
                    'to-applicant-task-applied-pass-yes'
                );
            }
        }else{
            if( $weichat_id ){
                Yii::$app->wechat_pusher->toApplicantTaskAppliedDonePassNo($task,$weichat_id);
            }else{
                $resume = Resume::find()->where(['user_id'=>$user_id])->one();
                Yii::$app->sms_pusher->push(
                    $resume->phonenum,
                    ['task'=>$task,'resume'=>$resume],
                    'to-applicant-task-applied-pass-no'
                );
            }
        }
    }

    public function checkAppTask($user_id, $task_id){
        $applicant = TaskApplicant::findOne(['user_id' => $user_id, 'task_id' => $task_id]);
        if( $applicant ){
            $task = Task::findOne(['id'=>$task_id, 'user_id'=>YII::$app->user->id]);
            if($task){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

}