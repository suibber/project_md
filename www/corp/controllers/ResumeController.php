<?php
namespace corp\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use corp\CBaseController;
use yii\db\Query;
use yii\data\Pagination;

use corp\models\TaskApplicant;
use common\models\Task;
use common\models\TaskNotice;
use common\WeichatBase;
use common\models\Resume;

/**
 * Site controller
 */
class ResumeController extends CBaseController
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex($status=false)
    {
        $tasks = Task::findAll([
            'user_id'=>Yii::$app->user->id
        ]);
        $task_ids = [];
        foreach($tasks as $task){
            $task_ids[] = $task->id;
        }
        $query = TaskApplicant::find()
            ->where(['in', 'task_id', $task_ids])
            ->orderBy(['id' => SORT_DESC]);
        if ($status!==false){
            $query->andWhere(['status'=>$status]);
        }

        $cloneQuery = clone $query;
        $count = $cloneQuery->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $query-> with('resume')->with('task');
        $task_apps = $query->offset($pagination->offset)
                         ->limit($pagination->limit)
                         ->all();

        //print_r($task_apps);exit;

        return $this -> render('index',
            ['task_apps' => $task_apps, 'pagination' => $pagination]);
    }

    public function actionRead($aid)
    {
        $resume = TaskApplicant::findOne(['id' => $aid]);
        if (!$resume){
            throw new BadRequestHttpException;
        }
        $resume->have_read = 1;
        if ($resume->save()) {
            return $this->renderJson(['result' => true]);
        }
        return $this->renderJson(['result' => false, 'error' => $resume->errors]);
    }

    public function actionPass($aid)
    {
        $resume = TaskApplicant::findOne(['id' => $aid]);
        $resume->status = 10;
        if ($resume->save()) {
            $task_applicant = TaskApplicant::findOne(['id'=>$aid]);
            $this->pushResultMsg(
                $resume->task_id,
                $task_applicant->user_id,
                TaskApplicant::STATUS_APPLY_SUCCEED
            );
            return $this->renderJson(['result' => true]);
        }
        return $this->renderJson(['result' => false, 'error' => $resume->errors]);
    }

    public function actionPassWithNotice()
    {
        $post   = Yii::$app->request->post();
        $user_id= Yii::$app->user->id;
        $task   = Task::find()->where(['id'=>$post['task_id'],'user_id'=>$user_id])->one();

        if( $task ){
            if( isset($task->notice->id) ){
                $model  = TaskNotice::find()->where($task->notice->id)->one();
            }else{
                $model  = new TaskNotice();
            }
            $model->type        = $post['type'];
            $model->meet_time   = $post['meet_time'];
            $model->place       = $post['place'];
            $model->linkman     = $post['linkman'];
            $model->phone       = $post['phone'];
            $model->task_id     = $post['task_id'];
            
            $model->save();

            $aid    = $post['task_app_id'];
            $resume = TaskApplicant::findOne(['id' => $aid]);
            $resume->status = 10;
            if ($resume->save()) {
                $task_applicant = TaskApplicant::findOne(['id'=>$aid]);
                $this->pushPassNoticeMsg($task->id,$task_applicant->user_id);
                return $this->redirect('/resume');
            }
        }
    }

    public function actionNoticeInfo($taskid){
        $taskid = is_numeric($taskid) ? $taskid : 0;
        $user_id= Yii::$app->user->id;
        $task   = Task::find()->where(['id'=>$taskid,'user_id'=>$user_id])->with('notice')->one();
        if( $task->notice ){
            $task_notice    = $task->notice->toArray();
            $task_notice['task_title']   = $task->title;
        }else{
            $task_notice    = [
                'id'        => '',
                'task_id'   => '',
                'type'      => '',
                'meet_time' => '',
                'place'     => '',
                'linkman'   => '',
                'phone'     => '',
                'task_title' => $task->title
            ];
        }
        echo json_encode( $task_notice );
    }

    public function actionReject($aid)
    {
        $resume = TaskApplicant::findOne(['id' => $aid]);
        $resume->status = 20;
        if ($resume->save()) {
            $task_applicant = TaskApplicant::findOne(['id'=>$aid]);
            $this->pushResultMsg(
                $resume->task_id,
                $task_applicant->user_id,
                TaskApplicant::STATUS_APPLY_FAILED
            );
            return $this->renderJson(['result' => true]);
        }
        return $this->renderJson(['result' => false, 'error' => $resume->errors]);
    }

    protected function pushPassNoticeMsg($task_id,$user_id){
        $weichat_base   = new WeichatBase();
        $weichat_id     = $weichat_base::getLoggedUserWeichatID($user_id);
        $task   = Task::find()->where(['id'=>$task_id])->with('notice')->one();
        if( $weichat_id ){ 
            Yii::$app->wechat_pusher->toApplicantTaskAppliedPass($task,$weichat_id);
        }else{
            $resume = Resume::find()->where(['user_id'=>$user_id])->one();
            Yii::$app->sms_pusher->push(
                $resume->phonenum,
                ['task'=>$task, 'resume'=>$resume],
                'to-applicant-task-applied-pass'
            );
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
}
