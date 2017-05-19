<?php
/**
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\Exception;
use common\models\Task;
use common\models\TaskApplicant;
use common\models\ConfigRecommend;

/**
 */

class TaskController extends Controller
{
    public function actionOffline(){
        $now = date("Y-m-d H:i:s");
        $tasks = Task::find()->where([
                'status'=>Task::STATUS_OK,
            ])->andWhere(['<', 'to_date', $now])->all();

        $count = Task::updateAll(['status'=>Task::STATUS_OFFLINE],
            'to_date < :to_date and status=:status' , 
            ['to_date' => $now, 'status' => Task::STATUS_OK]
        );
        echo "Task Status:: $count tasks are changed to offline\n";
        Yii::info("Task Status:: $count tasks are changed to offline");

        if ($count>0){
            echo "Change undealed applicant to refused status\n";
            Yii::info("Change undealed applicant to refused status\n");
            $task_ids = [];
            foreach($tasks as $task){
                $task_ids[] = $task->id;
            }
            TaskApplicant::updateAll(['status'=>TaskApplicant::STATUS_APPLY_FAILED],
                ['task_id'=> $task_ids, 'status'=>TaskApplicant::STATUS_WAIT_EXAMINE]
            );
        } else {
            echo "No task offlined today\n";
            Yii::info("No task offlined today\n");
        }
    }

    public function actionRefreshRecommendTask()
    {
        $cons = ConfigRecommend::find()->with('task')
            ->orderBy(['display_order'=>SORT_DESC])->all();
        foreach ($cons as $con){
            $task = $con->task;
            $task->updated_time = date('Y-m-d H:i:s', time());
            if ($task->update()){
                echo $task->gid . ':' . $task->title . "  is updated\n";
                sleep(1);
            }
        }
    }
}

