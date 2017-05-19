<?php
 
namespace api\miduoduo\v1\controllers;
 
use api\common\BaseActiveController;
 
/**
 * Resume Controller API
 *
 * @author dawei
 */
class ResumeController extends BaseActiveController
{
    public $modelClass = 'api\miduoduo\v1\models\Resume';

    public function actions()
    {
        $as = parent::actions();
        unset($as['delete']);
        return $as;
    }

    public $id_column = 'user_id';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

}
