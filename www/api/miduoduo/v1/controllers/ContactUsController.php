<?php
 
namespace api\miduoduo\v1\controllers;

use api\common\BaseActiveController;

/**
 * Controller API
 *
 * @author dawei
 */
class ContactUsController extends BaseActiveController
{
    public $modelClass = 'common\models\ContactUs';

    public $id_column = 'id';

    public function actions()
    {
        $actions = parent::actions();
        return ['create'=> $actions['create']];
    }

}
