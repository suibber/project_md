<?php
 
namespace api\extensions\time_book\controllers;
 
use api\common\BaseActiveController;
 
/**
 * Sys Message Controller API
 *
 * @author dawei
 */
class ScheduleController extends BaseActiveController
{
    public $modelClass = 'api\extensions\time_book\models\Schedule';

    public $id_column = 'id';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

    public function actions()
    {
        $actions = parent::actions();
        return ['index'=> $actions['index'], 'view'=> $actions['view']];
    }

    public function getQueryShortcuts()
    {
        return [
             'date' => [
                 '*' => function($query, $name, $value){
                     $query->andWhere(['date'=>$value]);
                 },
            ],
        ];
    }


}
