<?php
 
namespace api\miduoduo\v1\controllers;

use Yii;
use api\common\BaseActiveController;
use common\Utils;
use common\models\Task;
 
/**
 * Address Controller API
 *
 * @author dawei
 */
class RecommendTaskGroupController extends BaseActiveController
{
    public $modelClass = 'common\models\WeichatPushSetTemplatePushList';

    public $id_column = 'id';

    public function actions()
    {
        $actions = parent::actions();
        return ['view'=> $actions['view']];
    }



}
