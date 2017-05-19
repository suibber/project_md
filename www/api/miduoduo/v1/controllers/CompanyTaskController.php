<?php
 
namespace api\miduoduo\v1\controllers;

use Yii;
use api\common\BaseActiveController;
use common\Utils;
use common\models\Task;
 
/**
 * Address Controller API
 *
 * @author suibber
 */
class CompanyTaskController extends BaseActiveController
{
    public $modelClass = 'common\models\Task';
    public $id_column = 'id';
    public $defaultOrder = ['order_time'=>SORT_DESC, 'id'=>SORT_DESC];
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

    public function actions()
    {
        $actions = parent::actions();
        $actions['create'] = [
            'class' => 'api\miduoduo\v1\models\CompanyTaskCreateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];
        $actions['update'] = [
            'class' => 'api\miduoduo\v1\models\CompanyTaskUpdateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];
        return $actions;
    }
}
