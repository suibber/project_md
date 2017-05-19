<?php
 
namespace api\miduoduo\v1\controllers;
 

use api\common\BaseActiveController;
use yii;
 
/**
 * Controller API
 *
 * @author suibber
 */
class CompanyTaskAddressController extends BaseActiveController
{
    public $modelClass = 'common\models\TaskAddress';

    public $id_column = 'id';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

    public function actions()
    {
        $as = parent::actions();
        return $as;
    }

}
