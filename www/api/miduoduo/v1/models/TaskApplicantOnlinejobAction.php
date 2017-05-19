<?php

namespace api\miduoduo\v1\models;

use Yii;

use common\models\TaskApplicantOnlinejob;
use common\models\Task;

class TaskApplicantOnlinejobAction extends \yii\rest\CreateAction
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
        $data = Yii::$app->getRequest()->getBodyParams();

        $needinfo_arr = [];
        foreach( $data as $k => $v ){
            if( is_numeric($k) ){
                $needinfo_arr[$k] = $v;
                unset($data[$k]);
            }
        }
        $data['needinfo'] = serialize($needinfo_arr);

        $model->load($data, '');

        $is_valid = $this->checkValid($model);
        if( $is_valid['success'] == false ){
            return ['success'=>false,"message"=> $is_valid['message']];
        }
        
        if ($model->save()) {
            if( !isset($data['has_sync_wechat_pic']) || $data['has_sync_wechat_pic'] != 1 ){
                Yii::$app->job_queue_manager->add('wechat-download-img/down',
                    ['id'=>$model->id]
                );
            }
            return ['success'=>true,"message"=> "添加成功",'result'=>$model];
        } elseif (!$model->hasErrors()) {
            return ['success'=>false,"message"=> "添加失败"];
        }
    }

    private function checkValid($model){
        $task = Task::find()->where(['id' => $model->task_id])
            ->with('onlinejob')
            ->one();
        
        if( !$task ){
            return ['success'=>false,"message"=> "任务已下架"];
        }

        if( $task->onlinejob->need_phonenum && !$model->need_phonenum ){
            return ['success'=>false,"message"=> "手机号不能为空"];
        }
        if( $task->onlinejob->need_username && !$model->need_username ){
            return ['success'=>false,"message"=> "用户名不能为空"];
        }
        if( $task->onlinejob->need_person_idcard && !$model->need_person_idcard ){
            return ['success'=>false,"message"=> "身份证号不能为空"];
        }

        if( $task->onlinejob->need_phonenum ){
            $used = TaskApplicantOnlinejob::findOne([
                'task_id' => $model->task_id,
                'need_phonenum' => $model->need_phonenum,
            ]);
            if($used){
                return ['success'=>false,"message"=> "手机号已被使用"];
            }
        }
        if( $task->onlinejob->need_username ){
            $used = TaskApplicantOnlinejob::findOne([
                'task_id' => $model->task_id,
                'need_username' => $model->need_username,
            ]);
            if($used){
                return ['success'=>false,"message"=> "用户名已被使用"];
            }
        }
        if( $task->onlinejob->need_person_idcard ){
            $used = TaskApplicantOnlinejob::findOne([
                'task_id' => $model->task_id,
                'need_person_idcard' => $model->need_person_idcard,
            ]);
            if($used){
                return ['success'=>false,"message"=> "身份证号已被使用"];
            }
        }

        return ['success'=>true,"message"=> ""];
    }

}
