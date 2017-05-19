<?php
 
namespace api\extensions\time_book\controllers;
 
use api\common\BaseActiveController;
 
/**
 * Sys Message Controller API
 *
 * @author dawei
 */
class ScheduleAllController extends BaseActiveController
{
    public $modelClass = 'api\extensions\time_book\models\Schedule';

    public $id_column = 'id';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index'] = [
            'class' => 'api\extensions\time_book\models\ScheduleAllAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $actions;
    }
}
