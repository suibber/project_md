<?php
 
namespace api\extensions\time_book\controllers;
 
use api\common\BaseActiveController;
 
/**
 * Controller API
 *
 * @author dawei
 */
class RecordNewController extends BaseActiveController
{
    public $modelClass = 'api\extensions\time_book\models\Record';

    public $id_column = 'id';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

    public function actions()
    {
        $actions = parent::actions();
        $as = ['index'=> $actions['index'], 'view'=> $actions['view']];
        $as['create'] = [
            'class' => 'api\extensions\time_book\models\RecordNewAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];
        return $as;
    }
}
