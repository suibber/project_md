<?php
namespace corp\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use corp\CBaseController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;

use common\models\Company;
use common\models\Task;
use common\models\ServiceType;
use common\models\TaskAddress;
use common\models\Tasktime;

use corp\models\TaskPublishModel;

/**
 * Site controller
 */
class TaskController extends CBaseController
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

    public function actionIndex()
    {
        $company = Company::findByCurrentUser();
        if (!$company) {
            return $this->redirect('/user/add-contact-info');
        }
        $user_task_promission   = $this->checkUserTaskPromission();
        $condition = ['user_id'=>Yii::$app->user->id];
        $status = Yii::$app->request->get('status');
        if (array_key_exists('status', $_GET)) {
            $condition['status'] = $status;
        }
        $query = Task::find()
                        ->where($condition)
                        ->addOrderBy(['status'=>SORT_ASC,'updated_time'=>SORT_DESC]);;
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $tasks = $query->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->all();
        return $this -> render('index', ['tasks' => $tasks, 'pagination' => $pagination,'user_task_promission'=>$user_task_promission]);
    }

    public function actionPublish()
    {
        $user_task_promission   = $this->checkUserTaskPromission();

        $model = new Task();
        $company = Company::findByCurrentUser();
        if (Yii::$app->request->isPost) {
            if( $user_task_promission['result'] == false ){
                return $this->render('none_user_task_promission',['user_task_promission'=>$user_task_promission]);
                exit;
            }

            $company_id = $company->id;
            $data = Yii::$app->request->post();

            $data['is_allday']   = isset($data['is_allday']) ? $data['is_allday'] : 0;
            $data['is_longterm'] = isset($data['is_longterm']) ? $data['is_longterm'] : 0;

            if( $data['is_longterm'] ){
                $data['to_date']    = '2115-01-01';
            }
            if( $data['is_allday'] ){
                $data['from_time']  = '00:00:01';
                $data['to_time']    = '23:59:59';
            }

            $data['company_id'] = $company_id;
            $data['user_id'] = Yii::$app->user->id;
            $data['updated_time'] = date("Y-m-d H:i:s");

            $model->setAttributes($data, false);

            $city_id = Yii::$app->request->post('city_id');
            if ($city_id) {
                $model->city_id = $city_id;
            }
            $district_id = Yii::$app->request->post('district_id');
            if ($district_id) {
                $model->district_id = $district_id;
            }
            $clearance_period = Yii::$app->request->post('clearance_period');
            if ($clearance_period) {
                $model->clearance_period = array_search($clearance_period, Task::$CLEARANCE_PERIODS);
            }
            $salary_unit = Yii::$app->request->post('salary_unit');
            if ($salary_unit) {
                $model->salary_unit = array_search($salary_unit, Task::$SALARY_UNITS);
            }
            $gender_requirement = Yii::$app->request->post('gender_requirement');
            if ($gender_requirement) {
                $model->gender_requirement = array_search($gender_requirement, Task::$GENDER_REQUIREMENT);
            }
            $height_requirement = Yii::$app->request->post('height_requirement');
            if ($height_requirement) {
                $model->height_requirement = array_search($height_requirement,Task::$HEIGHT_REQUIREMENT);
            }
            $face_requirement = Yii::$app->request->post('face_requirement');
            if ($face_requirement) {
                $model->face_requirement = array_search($face_requirement,Task::$FACE_REQUIREMENT);
            }
            $talk_requirement = Yii::$app->request->post('talk_requirement');
            if ($talk_requirement) {
                $model->talk_requirement = array_search($talk_requirement,Task::$TALK_REQUIREMENT);
            }
            $health_certificated = Yii::$app->request->post('health_certificated');
            if ($health_certificated) {
                $model->health_certificated = array_search($health_certificated,Task::$HEALTH_CERTIFICATED);
            }
            $degree_requirement = Yii::$app->request->post('degree_requirement');
            if ($degree_requirement) {
                $model->degree_requirement = array_search($degree_requirement,Task::$DEGREE_REQUIREMENT);
            }
            $weight_requirement = Yii::$app->request->post('weight_requirement');
            if ($weight_requirement) {
                $model->weight_requirement = array_search($weight_requirement,Task::$WEIGHT_REQUIREMENT);
            }
            $model->service_type_id = ServiceType::findOne(['name' => Yii::$app->request->post('service_type_id')])->id;
            
            if( $company->status == $company::STATUS_WHITEISTED ){
                $model->status = 0;
            }else{
                $model->status = 30;
            }
            $model->origin = 'corp';

            if ($model->validate() && $model->save()) {
                $task_id = $model->id;
                $addressList = explode(' ', Yii::$app->request->post('address_list'));
                foreach($addressList as $item){
                    $address = TaskAddress::findOne(['id' => $item]);
                    $address->task_id = $task_id;
                    $address->save();
                }
                $this->updateUseTaskNum();
                $this->updateTasktime($task_id, $data['tasktime']);
                return $this->redirect('/task/');
            }
        }

        $services = ServiceType::find()->all();
        return $this -> render('publish',
        ['services'=>$services, 'task'=>$model, 'company'=>$company, 'address'=>[],'user_task_promission'=>$user_task_promission]);
    }

    public function actionEdit($gid)
    {
        $user_task_promission   = $this->checkUserTaskPromission();

        $company = Company::findByCurrentUser();

        $task = Task::findOne(['gid' => $gid]);
        if (!$task) {
            return $this->goHome();
        }
        if (Yii::$app->request->isPost) {
            if( $user_task_promission['result'] == false ){
                return $this->render('none_user_task_promission',['user_task_promission'=>$user_task_promission]);
                exit;
            }

            $data   = Yii::$app->request->post();
            $data['is_allday']   = isset($data['is_allday']) ? $data['is_allday'] : 0;
            $data['is_longterm'] = isset($data['is_longterm']) ? $data['is_longterm'] : 0;
            if( $data['is_longterm'] ){
                $data['to_date']    = '2115-01-01';
            }
            if( $data['is_allday'] ){
                $data['from_time']  = '00:00:01';
                $data['to_time']    = '23:59:59';
            }

            $data['updated_time'] = date("Y-m-d H:i:s");

            $current_city_id     = $task->city_id;
            $current_district_id = $task->district_id;
            
            $task->setAttributes($data, false);

            $city_id = Yii::$app->request->post('city_id');
            if ($city_id) {
                $task->city_id = $city_id;
            }else{
                $task->city_id = $current_city_id;
            }
            $district_id = Yii::$app->request->post('district_id');
            if ($district_id>0) {
                $task->district_id = $district_id;
            }else{
                $task->district_id = $current_district_id;
            }

            $clearance_period = Yii::$app->request->post('clearance_period');
            if ($clearance_period) {
                $task->clearance_period = array_search($clearance_period, Task::$CLEARANCE_PERIODS);
            }
            $salary_unit = Yii::$app->request->post('salary_unit');
            if ($salary_unit) {
                $task->salary_unit = array_search($salary_unit, Task::$SALARY_UNITS);
            }
            $gender_requirement = Yii::$app->request->post('gender_requirement');
            if ($gender_requirement) {
                $task->gender_requirement = array_search($gender_requirement, Task::$GENDER_REQUIREMENT);
            }
            $height_requirement = Yii::$app->request->post('height_requirement');
            if ($height_requirement) {
                $task->height_requirement = array_search($height_requirement,Task::$HEIGHT_REQUIREMENT);
            }
            $face_requirement = Yii::$app->request->post('face_requirement');
            if ($face_requirement) {
                $task->face_requirement = array_search($face_requirement,Task::$FACE_REQUIREMENT);
            }
            $talk_requirement = Yii::$app->request->post('talk_requirement');
            if ($talk_requirement) {
                $task->talk_requirement = array_search($talk_requirement,Task::$TALK_REQUIREMENT);
            }
            $health_certificated = Yii::$app->request->post('health_certificated');
            if ($health_certificated) {
                $task->health_certificated = array_search($health_certificated,Task::$HEALTH_CERTIFICATED);
            }
            $degree_requirement = Yii::$app->request->post('degree_requirement');
            if ($degree_requirement) {
                $task->degree_requirement = array_search($degree_requirement,Task::$DEGREE_REQUIREMENT);
            }
            $weight_requirement = Yii::$app->request->post('weight_requirement');
            if ($weight_requirement) {
                $task->weight_requirement = array_search($weight_requirement,Task::$WEIGHT_REQUIREMENT);
            }
            
            if( $company->status == $company::STATUS_WHITEISTED ){
                
            }else{
                $task->status = Task::STATUS_IS_CHECK;
            }

            $task->service_type_id = ServiceType::findOne(['name' => Yii::$app->request->post('service_type_id')])->id;
            $task->updated_time = date("Y-m-d H:i:s");
            
            if ($task->validate() && $task->save()) {
                $task_id = $task->id;
                $addressList = explode(' ', Yii::$app->request->post('address_list'));
                foreach($addressList as $item){
                    $address = TaskAddress::findOne(['id' => $item]);
                    $address->task_id = $task_id;
                    $address->save();
                }
                $this->updateUseTaskNum();
                $this->updateTasktime($task_id, $data['tasktime']);
                return $this->redirect('/task/');
            }
        }
        $addresses = $task->getAddresses()->all();
        $services = ServiceType::find()->all();
        $task->from_time = substr($task->from_time, 0, -3);
        $task->to_time = substr($task->to_time, 0, -3);
        Yii::$app->session->set('current_task_id', $task->id);
        $tasktimes = $this->getTasktimes($task->id);
        return $this->render('publish',
        [
            'task' => $task, 'services'=>$services, 'company'=>$company, 
            'address'=>$addresses,'user_task_promission'=>$user_task_promission,
            'tasktimes'=>$tasktimes,
        ]);
    }

    public function actionRefresh($gid)
    {
        $user_task_promission   = $this->checkUserTaskPromission();
        if( $user_task_promission['result'] == false ){
            return $this->renderJson(['result' => false, 'error' => $user_task_promission['msg']]);
            exit;
        }

        $task = Task::findOne(['gid' => $gid]);
        $task->updated_time = date("Y-m-d H:i:s");
        $task->from_time = substr($task->from_time, 0, -3);
        $task->to_time = substr($task->to_time, 0, -3);
        if($task->save()){
            $this->updateUseTaskNum();
            return $this->renderJson(['result' => true]);
        }
        return $this->renderJson(['result' => false, 'error' => $task->errors]);
    }

    public function actionDown($gid)
    {
        $task = Task::findOne(['gid' => $gid]);
        $task->updated_time = time();
        $task->status = 10;
        $task->from_time = substr($task->from_time, 0, -3);
        $task->to_time = substr($task->to_time, 0, -3);
        if($task->save()){
            return $this->renderJson(['result' => true]);
        }
        return $this->renderJson(['result' => false, 'error' => $task->errors]);
    }

    public function actionDelete($gid)
    {
        $task = Task::findOne(['gid' => $gid]);
        $task->updated_time = time();
        $task->status = 20;
        $task->from_time = substr($task->from_time, 0, -3);
        $task->to_time = substr($task->to_time, 0, -3);
        if($task->save()){
            return $this->renderJson(['result' => true]);
        }
        return $this->renderJson(['result' => false, 'error' => $task->errors]);
    }

    public function actionSuccess()
    {
        return $this->render('success');
    }

    public function actionAddAddress()
    {
        $model = new TaskAddress();
        $model->setAttributes(Yii::$app->request->post(),false);
        $model->user_id = Yii::$app->user->id;
        $model->task_id = Yii::$app->session->get('current_task_id', 0);
        if($model->validate() && $model->save()){
            return $this->renderJson([
                'success'=> true,
                'msg'=> '创建成功',
                'result'=> $model->toArray()
            ]);
        }
        return $this->renderJson([
            'success'=> false,
            'msg'=> '创建失败',
            'errors'=> $model->getErrors(),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = TaskAddress::findOne($id)) !== null){
            return $model;
        }else{
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDeleteAddress($id)
    {
        $this->findModel($id)->delete();
        return $this->renderJson([
            'success'=> true,
            'msg'=> '删除成功',
        ]);
    }

    protected function updateUseTaskNum(){
        $user_id    = Yii::$app->user->id;
        $company    = Company::find()->where(['user_id'=>$user_id])->one();
        $today      = date("Y-m-d");
        if( $company->use_task_date != $today ){
            $company->use_task_num  = 1;
            $company->use_task_date = $today;
            $company->save();
            var_dump($company);exit;
        }elseif( $company ){
            $company->use_task_num  = $company->use_task_num + 1;
            $company->save();
        }
    }

    protected function checkUseTaskNum($company){
        $today          = date("Y-m-d");
        $use_task_limie = $company->getUseTaskLimit($company->exam_result);
        if( $company->use_task_date != $today ){
            $company->use_task_num  = 0;
            $company->use_task_date = $today;
            $company->save();
            $use_task_num = 0;
            $result       = true;
        }elseif( $company ){
            $use_task_num   = $company->use_task_num;
            if( $company->use_task_num < $use_task_limie ){
                $result = true;
            }else{
                $result = false;
            }
        }else{
            $result = false;
        }
        return [
            'result'=>$result,
            'use_task_num'=>$use_task_num,
            'use_task_limie'=>$use_task_limie,
            'exam_result'=>$company->exam_result,
            'msg'=>'今日可操作<span class="span_red_s">'.$use_task_limie.'</span>条，已操作<span class="span_red_s">'.$use_task_num.'</span>条（操作是指：发布、编辑、刷新职位。申请个人/企业认证后，最多可操作'.$company->getUseTaskLimit(32).'条）',
        ];
    }

    protected function checkCompanyStatus($company){
        $status = $company->status;
        if( $status == 0 || $status == 21 ){
            $result = true;
        }else{
            $result = false;
        }
        return [
            'result'=>$result,
            'use_task_num'=>0,
            'use_task_limie'=>0,
            'exam_result'=>false,
            'msg'=>'您的账户'.$company->getConpanyStatusLabel($status).'，请联系客服：010-84991662',
        ];
    }

    protected function checkUserTaskPromission(){
        $user_id    = Yii::$app->user->id;
        $company    = Company::find()->where(['user_id'=>$user_id])->one();
        $status_info= $this->checkCompanyStatus($company);
        if( !$status_info['result'] ){
            $return       = $status_info;
        }else{
            $return       = $this->checkUseTaskNum($company);
        }
        return $return;
    }

    protected function updateTasktime($task_id, $tasktimes){
        Tasktime::deleteAll(['task_id' => $task_id]);
        for($i=0; $i<=6; $i++){
            $tasktime_m = new Tasktime();
            $tasktime_m->dayofweek = $i;
            $tasktime_m->task_id = $task_id;
            foreach( $tasktimes as $tasktime ){
                list($dayofweek, $timemoment) = explode('_', $tasktime);
                if($dayofweek == $i){
                    $tasktime_m->$timemoment = 1;
                }
            }
            $tasktime_m->save();
        }
    }

    protected function getTasktimes($task_id){
        $tasktimes = Tasktime::findAll(['task_id' => $task_id]);
        return $tasktimes;
    }

}
