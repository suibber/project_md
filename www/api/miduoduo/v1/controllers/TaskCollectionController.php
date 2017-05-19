<?php
 
namespace api\miduoduo\v1\controllers;

use yii\web\HttpException;
use api\common\BaseActiveController;
 
/**
 *  Controller API
 *
 * @author dawei
 */
class TaskCollectionController extends BaseActiveController
{
    public $modelClass = 'common\models\TaskCollection';

    public $id_column = 'task_id';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

}
