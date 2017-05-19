<?php
 
namespace api\miduoduo\v1\controllers;

use api\common\BaseActiveController;

/**
 * Controller API
 *
 * @author dawei
 */
class ComplaintController extends BaseActiveController
{
    public $modelClass = 'common\models\Complaint';

    public $id_column = 'task_id';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

}
