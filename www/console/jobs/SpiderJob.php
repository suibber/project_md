<?php

namespace console\jobs;

use console\BaseJob;
use backend\models\TaskPool;
use backend\models\TaskPoolWhiteList;

class SpiderJob extends BaseJob
{


    public function actionImportTasks($ids)
    {
        $brs = TaskPoolWhiteList::find()->where(['is_white'=>0])->all();
        $ts = TaskPool::find()->where(['id'=>$ids, 'status'=>[
                    TaskPool::STATUS_UNSETTLED,
                    TaskPool::STATUS_EXPORTED]])
            ->all();
        $phonenums = [];
        $tasks = [];
        foreach ($ts as $t){
            $is_zombie = 0;
            foreach ($brs as $b){
                $attr = $br->attr;
                if ($t->$attr==$b->value){
                    $t->status = TaskPool::STATUS_ZOMBIE;
                    $t->save();
                    $is_zombie = 1;
                    break;
                }
            }
            if (!$is_zombie && !empty($t->phonenum)){
                $tasks[$t->phonenum] = ['task'=>$t, 'replaced_task'=>null];
                $phonenums[] = $t->phonenum;
            }
        }
        $ts = TaskPool::find()->where(['phonenum'=>$phonenums])
            ->andWhere(['status'=> [
                    TaskPool::STATUS_UNSETTLED,
                    TaskPool::STATUS_EXPORTED]])
            ->orderBy(['release_date'=>SORT_DESC])->all();
        $queue_tasks = [];
        foreach ($ts as $t) {
            $current = $tasks[$t->phonenum]['task'];
            if ($current->title != $t->title){
                continue;
            }
            $queue_tasks[] = $t;
            if ($current->release_date < $t->release_date){
                $tasks[$t->phonenum]['task'] = $t;
                if ($current->status==TaskPool::STATUS_EXPORTED) {
                    $tasks[$t->phonenum]['replaced_task'] = $current;
                }
            }
        }
        $export_ids = [];
        foreach ($tasks as $phonenum=>$group){
            $t = $group['task'];
            $rt = $group['replaced_task'];
            $task_id = $rt?$rt->task_id:null;
            $t->exportTask($task_id, $self_update=true);
            $export_ids[] = $t->id;
        }
        foreach($queue_tasks as $t){
            if (!in_array($t->id, $export_ids)){
                $t->status = TaskPool::STATUS_DROPPED;
                $t->save();
            }
        }

        return true;
    }
}
