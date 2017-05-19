<?php
namespace common;

use common\models\JobQueue;


class JobQueueManager
{
    public $batch_size = 100;

    /*
     * TODO 这里如果并发，会有重复取job的可能。
     *
     */
    public function get($count=null)
    {
        $count = $count?$count:$this->batch_size;

        $jobs = JobQueue::find()
            ->where(['status'=>JobQueue::STATUS_IN_QUEUE])
            ->andWhere(['<', 'start_time', date(DATE_ATOM)])
            ->orderBy(['priority'=>SORT_DESC, 'id'=>SORT_DESC])
            ->limit($count)->all();
        $ids = [];
        foreach($jobs as $job){
            $ids[] = $job->id;
        }
        JobQueue::updateAll(
            ['status'=>JobQueue::STATUS_PROCESSING],
            ['id'=> $ids]);
        return $jobs;
    }

    public function add($task_name, $params, 
        $start_time=null, $priority=null, $retry_times = 3)
    {

        $start_time = $start_time?$start_time:time();
        $priority = $priority?$priority:JobQueue::PRIORITY_MEDIUM;

        $job = new JobQueue;
        $job->task_name = $task_name;
        $job->setParams($params);
        $job->start_time = $start_time;
        $job->priority = $priority;
        $job->retry_times = $retry_times;
        $job->save();
    }

    public function retry($job)
    {
        return $job->retryIfCan();
    }

}
