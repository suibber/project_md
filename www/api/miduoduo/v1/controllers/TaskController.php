<?php
 
namespace api\miduoduo\v1\controllers;

use Yii;
use api\common\BaseActiveController;
use common\Utils;
use common\models\Task;
 
/**
 * Address Controller API
 *
 * @author dawei
 */
class TaskController extends BaseActiveController
{
    public $modelClass = 'common\models\Task';

    public $id_column = 'id';

    public $defaultOrder = ['order_time'=>SORT_DESC, 'id'=>SORT_DESC];

    public function actions()
    {
        $actions = parent::actions();
        return ['index'=> $actions['index'], 'view'=> $actions['view']];
    }

    public function getQueryShortcuts()
    {
        return [
            'qorder' => [
                'start_date' => function($query, $name, $value){
                    $order_time = $this->getColumn('order_time');
                    $query->addOrderBy("
                        (CASE
                            WHEN " . $order_time . "<='".date("Y-m-d")."' 
                            THEN ". $order_time ."
                            ELSE 0 
                        END) DESC ,
                        " . $from_time = $this->getColumn('from_date') . " ASC,
                        " . $order_time . " DESC,
                        " . $this->getColumn('id') . " DESC ");
                    }
            ],
            'city_id' => [
                '*' => function($query, $name, $value){
                    $query->andWhere([$this->getColumn('city_id')=>$value]);
                }
            ],
            'date_range' => [
                 'weekend_only' => function($query, $name, $value){
                    static::filterWeekendOnly($query);
                 },
                 'next_week' => function($query, $name, $value){
                    static::filterNextWeek($query);
                 },
                 'current_week' => function($query, $name, $value){
                    static::filterCurrentWeek($query);
                 },
                 'is_longterm' => function($query, $name, $value){
                    static::filterIsLongterm($query);
                 },
            ],
        ];
    }

    public function buildBaseQuery()
    {
        $query = parent::buildBaseQuery();

        $action_params = $this->actionParams;
        if( count($action_params) == 1 && $action_params['id'] ){
            
        }else{
            if( !stripos(Yii::$app->request->get('filters'), 'city_id') ){
                $query->andWhere(['city_id'=>3]);
            }
        }

        return $query;
    }

    public function buildFilterQuery(){
        $model = $this->modelClass;
        $query = parent::buildFilterQuery();
        $query->andWhere(['status'=>$model::STATUS_OK]);
        return $query;
    }

    public static function filterNextWeek($query)
    {
        $from_date = Task::tableName() . '.from_date';
        $to_date = Task::tableName() . '.to_date';
        $f_date = strtotime('monday');
        if (date('w', time())==1) {
            $f_date = strtotime('+2 monday');
        }
        $t_date = strtotime('sunday', $f_date);
        $query->andWhere(['and', 
                ['>=', $to_date, date('Y-m-d', $f_date)],
                ['<=', $from_date, date('Y-m-d', $t_date)]]);
        return $query;
    }

    public static function filterCurrentWeek($query)
    {
        $from_date = Task::tableName() . '.from_date';
        $to_date = Task::tableName() . '.to_date';
        $t_date = strtotime('sunday');
        $f_date = strtotime('-1 monday', $t_date);
        $query->andWhere(['and', 
                ['>=', $to_date, date('Y-m-d', $f_date)],
                ['<=', $from_date, date('Y-m-d', $t_date)]]);
        return $query;
    }

    public static function filterWeekendOnly($query)
    {
        $from_date = Task::tableName() . '.from_date';
        $to_date = Task::tableName() . '.to_date';
        $day_batch = [];
        $sat = strtotime('saturday');
        if (date('w', time())==0){
            $sat = strtotime('-1 saturday');
        } else {
            $sat = strtotime('saturday');
        }
        $day_batch = [
            [date('Y-m-d', strtotime('saturday', $sat)),
                date('Y-m-d', strtotime('sunday', $sat))],
            [date('Y-m-d', strtotime('+2 saturday', $sat)),
                date('Y-m-d', strtotime('+2 sunday', $sat))],
            [date('Y-m-d', strtotime('+3 saturday', $sat)),
                date('Y-m-d', strtotime('+3 sunday', $sat))],
            [date('Y-m-d', strtotime('+4 saturday', $sat)),
                date('Y-m-d', strtotime('+4 sunday', $sat))],
        ];
        $where = '1=0 ';

        foreach ($day_batch as $day_range){
            $where .= 
                " or ( $to_date >= '$day_range[0]' 
                       and $to_date <= '$day_range[1]'
                       and $from_date <= '$day_range[1]' 
                       and $from_date >= '$day_range[0]'
                )";
        }
        $query->andWhere($where);
        return $query;
    }

    public static function filterIsLongterm($query){
        $query->andWhere(["is_longterm"=>1]);
        return $query;
    }

}
