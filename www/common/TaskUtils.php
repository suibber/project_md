<?php

namespace common;

use yii;
use common\models\ConfigRecommend;
use common\models\Task;

class TaskUtils
{
    public function getRecommendTaskList( $city_id ){
        $gid_obj    = ConfigRecommend::find()->where(['type'=>1,'city_id'=>$city_id])
            ->limit(15)
            ->addOrderBy(['display_order'=>SORT_DESC])
            ->asArray()->all();

        $gids       = '';
        foreach( $gid_obj as $gid ){
            $gids   .= $gid['task_id'].',';
        }
        $gids   = trim($gids,',');

        if($gids){
            // 查询数据显示
            $task_list  = Task::find()
                ->where(['status'=>Task::STATUS_OK])
                ->where('`gid` in('.$gids.')')
                ->andWhere(['>', 'to_date', date("Y-m-d")])
                ->addOrderBy(['display_order'=>SORT_DESC])
                ->joinWith('recommend')->all();
        }else{
            $task_list  = '';
        }
        return $task_list;
    }

    
}

?>