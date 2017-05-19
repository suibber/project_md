<?php
 
namespace api\miduoduo\v1\controllers;
 

use api\common\BaseActiveController;
 
/**
 *  Controller API
 *
 * @author suibber
 */
class TaskApplicantOnlinejobController extends BaseActiveController
{
    public $modelClass = 'common\models\TaskApplicantOnlinejob';

    public $id_column = 'id';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

    public function actions()
    {
        $as = parent::actions();
        $as['create'] = [
            'class' => 'api\miduoduo\v1\models\TaskApplicantOnlinejobAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];
        $as['update'] = [
            'class' => 'api\miduoduo\v1\models\TaskApplicantOnlinejobUpdateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];
        $as['view'] = [
            'class' => 'api\miduoduo\v1\models\TaskApplicantOnlinejobViewAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];
        return $as;
    }

}
