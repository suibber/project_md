<?php
 
namespace api\miduoduo\v1\controllers;
 

use api\common\BaseActiveController;
 
/**
 *  Controller API
 *
 * @author dawei
 */
class TaskApplicantController extends BaseActiveController
{
    public $modelClass = 'common\models\TaskApplicant';

    public $id_column = 'task_id';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

    public function actions()
    {
        $as = parent::actions();
        $as['create'] = [
            'class' => 'api\miduoduo\v1\models\ApplyTaskAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];
        return $as;
    }

}
