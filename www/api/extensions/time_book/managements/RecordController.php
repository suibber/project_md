<?php
 
namespace api\extensions\time_book\managements;
 
use api\common\BaseActiveController;
 
/**
 * Controller API
 *
 * @author dawei
 */
class RecordController extends BaseActiveController
{
    public $modelClass = 'common\models\extensions\time_book\Record';

    public $id_column = 'id';
    public $auto_filter_user = true;
    public $user_identifier_column = 'owner_id';

    public function actions()
    {
        $actions = parent::actions();
        return ['index'=> $actions['index'], 'view'=> $actions['view'], 'create'=> $actions['create']];
    }
}
