<?php
 
namespace api\miduoduo\v1\controllers;
 
use api\common\BaseActiveController;
 
/**
 * Resume Controller API
 *
 * @author dawei
 */
class UserServiceTypeController extends BaseActiveController
{
    public $modelClass = 'common\models\UserHasServiceType';

    public $id_column = 'service_type_id';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

    public $page_size = 10000;

    public function actions()
    {
        $acts = parent::actions();
        unset($acts['update']);
        return $acts;
    }
}
