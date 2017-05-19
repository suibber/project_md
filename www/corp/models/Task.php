<?php
namespace corp\models;

class Task extends \common\models\Task
{

    public function getApplicants()
    {
        return $this->hasMany(TaskApplicant::className(), ['task_id'=>'id']);
    }

    public function getOk_applicants()
    {
        return $this->hasMany(TaskApplicant::className(),
            ['task_id'=>'id', 'status'=>TaskApplicant::STATUS_APPLY_SUCCEED]);
    }

}
