<?php
namespace corp\controllers;

use Yii;
use Exception;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use corp\CBaseController;

use common\Utils;
use common\models\Task;
use common\models\Resume;
use common\models\TaskAddress;
use common\models\TaskApplicant;
use corp\models\time_book\Record;
use corp\models\time_book\Schedule;


/**
 * Site controller
 */
class TimeBookController extends CBaseController
{

    public function beforeAction($action){
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Task::find()
            ->where(['user_id'=>Yii::$app->user->id])
            ->orderBy(['id'=> SORT_DESC]);

        $countQuery = clone $query;
        $pages =  new Pagination(['pageSize'=>Yii::$app->params['pageSize'],
            'totalCount' => $countQuery->count()]);

        $tasks = $query->offset($pages->offset)
            ->andWhere(['status'=>[
                Task::STATUS_OK, Task::STATUS_DELETED, 
                Task::STATUS_OFFLINE, Task::STATUS_OVERDUE
            ]])
            ->limit($pages->limit)->all();

        return $this->render('index', [
            'tasks' => $tasks,
            'pages' => $pages,
        ]);
    }

    public function openTimeBook($task)
    {
        if (!$task->time_book_opened){
            $task->time_book_opened = true;
            $task->save();
        }
    }

    public function actionWorkerSummary($gid, $resume_name=null, $address=null, $excel=false)
    {
        $task = Task::find()
            ->where(['gid'=> $gid, 'user_id'=>Yii::$app->user->id])->one();
        if (!$task){
            throw new HttpException(403, '未知的任务');
        }
        $this->openTimeBook($task);

        $today = date('Y-m-d');

        $query = $task->getApplicants()
            ->andWhere([TaskApplicant::tableName() . '.status'=>TaskApplicant::STATUS_APPLY_SUCCEED])
            ->joinWith('resume', 'address');
        $query->filterWhere([Resume::tableName() . '.name'=> $resume_name]);

        $countQuery = clone $query;
        $worker_count = $countQuery->count();
        $page_size = $excel?99999999:Yii::$app->params['pageSize'];
        $pages =  new Pagination([
            'pageSize'=>$page_size,
            'totalCount' => $worker_count]);

        $applicants = $query->offset($pages->offset)
            ->limit($pages->limit)->all();

        $user_ids = [];

        foreach ($applicants as $a){
            $user_ids[] = $a->user_id;
        }

        $ss = Schedule::find()
            ->select("
                count(1) as count,
                sum(case WHEN date<=CURDATE() THEN 1 ELSE 0 END) as past_count,
                sum(on_late) as on_late_count,
                sum(off_early) as off_early_count,
                sum(out_work) as out_work_count,
                sum(CASE WHEN note is null OR note = '' THEN 0 ELSE 1 END) as noted_count,
                user_id,
                sum(case WHEN date=CURDATE() THEN 1 ELSE 0 END) as is_today_on
            ")
            ->groupBy('user_id')
            ->filterWhere(['like', 'address', $address])
            ->andWhere(['task_id'=>$task->id, 'user_id'=>$user_ids])
            ->all();

        $summaries = [];
        $today_worker_count = 0;
        foreach ($ss as $s){
            $summaries[$s->user_id] = $s;
            $today_worker_count += $s->is_today_on;
        }

        $ss = Schedule::find()
            ->select('address')
            ->distinct()
            ->where(['task_id'=>$task->id])->all();
        $addresses = [];
        foreach ($ss as $add){
            $addresses[] = $add->address;
        }
        $params = [
            'task' => $task,
            'subject' => 'worker',
            'addresses' => $addresses,
            'models' => $applicants,
            'summaries' => $summaries,
            'pages' => $pages,
            'worker_count' => $worker_count,
            'today_worker_count' => $today_worker_count,
        ];
        if (!$excel){
            return $this->render('summary', $params);
        } else {
            header('Content-Disposition: attachment;filename="'.$task->gid.'.xls"');
            header("Cache-Control: max-age=0");
            return $this->renderPartial('worker_summary_excel', $params);
        }
    }

    public function actionAddressSummary($gid)
    {
        $task = Task::find()->with('resumes')
            ->where(['gid'=> $gid, 'user_id'=>Yii::$app->user->id])->one();
        if (!$task){
            throw new HttpException(403, '未知的任务');
        }
        return $this->render('summary', [
            'task' => $task,
            'subject' => 'address',
        ]);
    }

    public function actionDateSummary($gid)
    {
        $task = Task::find()->with('resumes')
            ->where(['gid'=> $gid, 'user_id'=>Yii::$app->user->id])->one();
        if (!$task){
            throw new HttpException(403, '未知的任务');
        }
        return $this->render('summary', [
            'task' => $task,
            'subject' => 'date',
        ]);
    }

    public function actionAdd($gid, $user_id=null, $date=null, $address_id=null)
    {
        $task = Task::find()->with('resumes')->with('addresses')
            ->where(['gid'=> $gid, 'user_id'=>Yii::$app->user->id])->one();
        if (!$task){
            throw new HttpException(403, '未知的任务');
        }
        $req = Yii::$app->request;
        $errors = [];
        if (Yii::$app->request->isPost){
            $user_ids = explode(',', $req->post('user_ids'));
            $address_id = $req->post('address_id');
            $lat = $req->post('lat');
            $lng = $req->post('lng');
            $from_time = $req->post('from_time');
            $to_time = $req->post('to_time');
            $address = null;
            $today = date('Y-m-d');
            foreach($user_ids as $k=>$user_id){
                if (empty($user_id)){
                    unset($user_ids[$k]);
                }
            }
            $date_r = explode(' - ', $req->post('dates'));
            $dates = [];
            try {
                $from_date = strtotime($date_r[0]);
                $to_date = strtotime($date_r[1]);
                while ($from_date<=$to_date){
                    $dates[]  = date('Y-m-d', $from_date);
                    $from_date = strtotime('+1 day', $from_date);
                }

                foreach($dates as $k=>$date){
                    if (empty($date)){
                        unset($dates[$k]);
                    }
                    if ($date<$today){
                        unset($dates[$k]);
                    }
                }
            } catch (Exception $e){
                $errors['dates'] = '请选择日期';
            }

            if (count($dates)==0){
                $errors['dates'] = '请选择日期';
            }
            if (empty($user_ids)){
                $errors['user_ids'] = '用户不可为空';
            }
            if ($address_id){
                $address = TaskAddress::find()
                    ->where(['id'=>$address_id, 'task_id'=>$task->id])
                    ->one();
            }
            if (!$address){
                $errors['address_id'] = '请选择地址';
            }
            if (!$lat || !$lng){
                $errors['lat'] = '请设置精准坐标';
            }
            if (!$req->post('from_time') || !$req->post('to_time')){
                $errors['from_time'] = '请设置工作时间';
            }
            if (count($errors)==0){
                TaskApplicant::updateAll(
                    ['address_id'=>$address->id],
                    ['user_id'=>$user_ids, 'task_id'=> $task->id]);

                Schedule::deleteAll(
                    ['task_id'=>$task->id, 'date'=>$dates, 'user_id'=>$user_ids]);

                if (strval($address->lat) != $lat || strval($address->lng) != $lng) {
                    $address->lat = $lat;
                    $address->lng = $lng;
                    $address->save();
                }

                $rows = [];
                foreach ($dates as $date){
                    foreach($user_ids as $user_id){
                        $schedule = new Schedule;
                        $schedule->user_id = $user_id;
                        $schedule->task_id = $task->id;
                        $schedule->date = $date;
                        $schedule->address = $address->title;
                        $schedule->from_datetime = $date . ' ' . $from_time . ':00'; // 0000-00-00 00:00:00
                        $schedule->to_datetime = $date . ' ' . $to_time . ':00'; // 0000-00-00 00:00:00
                        $schedule->owner_id = $task->user_id;
                        $schedule->lat = $lat;
                        $schedule->lng = $lng;
                        $schedule->task_title = $task->title;
                        $schedule->loadDefaultValues();
                        $rows[] = $schedule->attributes;
                    }
                }
                Yii::$app->db->createCommand()
                    ->batchInsert(Schedule::tableName(), $schedule->attributes(), $rows)
                    ->execute();
                return $this->redirect('/time-book/worker-summary?gid=' . $gid);
            }
        }
        return $this->render('add', [
            'task' => $task,
            'users' => [],
            'address' => null,
            'dates' => [],
            'errors' => $errors,
        ]);
    }

    public function actionDetail($task_id, $user_id, $on_late='', $off_early='', $out_work='')
    {
        $task = Task::findOne(
            ['user_id' => Yii::$app->user->id, 'id'=>$task_id]);
        if(!$task){
            throw new HttpException(403, '未知的任务');
        }
        $resume = Resume::findOne(['user_id'=> $user_id]);
        $query = Schedule::find()
            ->where(['owner_id'=>Yii::$app->user->id,
                'user_id' => $user_id,
                'task_id'=>$task_id])
            ->with('on_record')->with('off_record')
            ->orderBy(['date'=> SORT_DESC]);
        if ($on_late!=''){
            $query->andWhere(['on_late'=> $on_late]);
        }
        if ($off_early!=''){
            $query->andWhere(['off_early'=> $off_early]);
        }
        if ($out_work!=''){
            $query->andWhere(['out_work'=> $out_work]);
        }
        $schedules = $query->all();
        return $this->render('detail', [
            'schedules' => $schedules,
            'task' => $task,
            'resume' => $resume,
        ]);
    }

    public function actionChangeSchedule()
    {
        $req = Yii::$app->request;
        $schedule_id = $req->post('schedule_id');
        $action = $req->post('action');
        $note = $req->post('note');
        $schedule = Schedule::findOne(
            ['owner_id'=> Yii::$app->user->id, 'id'=>$schedule_id]);
        if (!$schedule){
            throw new HttpException(403, '未知的任务');
        }
        if ($action=='delete' && !$schedule->is_past){
            $r = $schedule->delete();
        } else {
            if ($action=='record_note') {
                $schedule->note = $note;
            } else {
                $schedule->{$action} = 1;
            }
            $r = $schedule->save();
        }
        if ($r){
            return $this->renderJson(['success'=> true, 'msg'=>'修改成功']);
        } else {
            return $this->renderJson(['success'=> false, 'msg'=>'修改失败']);
        }
    }
}
