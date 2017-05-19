<?php

namespace api\miduoduo\v1\models;

use Yii;

use common\Utils;
use common\models\Resume;
use common\models\Task;
use common\models\TaskApplicant;


class ApplyTaskAction extends \yii\rest\CreateAction
{

    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }
        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));

            $model->origin = 'App:' . Utils::getDeviceType(
                Yii::$app->request->getUserAgent()) 
                . '-' . Utils::getAppVersion(Yii::$app->request);

            $task = $model->task;
            $resume = $model->resume;

            if (empty($resume->phonenum)) {
                $resume->phonenum = Yii::$app->user->identity->username;
            }
            $wechat_profile = Yii::$app->user->identity->weichat;
            if (Utils::isPhonenum($task->contact_phonenum)){
                if ($wechat_profile) {
                    Yii::$app->wechat_pusher
                        ->toApplicantTaskAppliedDone($task, $wechat_profile->openid);
                } else {
                    Yii::$app->sms_pusher->push(
                        $resume->phonenum,
                        ['task'=>$task, 'resume'=>$resume],
                        'to-applicant-task-applied-done'
                    );
                }
                Yii::$app->sms_pusher->push(
                    $task->contact_phonenum,
                    ['task'=>$task, 'resume'=>$resume],
                    'to-company-get-new-application'
                );
                $model->applicant_alerted = true;
                $model->company_alerted = true;
            } else {
                if ($wechat_profile) {
                    Yii::$app->wechat_pusher
                        ->toApplicantTaskAppliedDone($task, $wechat_profile->openid);
                } else {
                    Yii::$app->sms_pusher->push(
                        $resume->phonenum,
                        ['task'=>$task, 'resume'=>$resume],
                        'to-applicant-task-need-touch-actively'
                    );
                }
                $model->company_alerted = false;
                $model->applicant_alerted = true;
            }

            $model->save();
            $task->got_quantity += 1;
            $task->save();

        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }

}
