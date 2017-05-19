<?php
 
namespace api\miduoduo\v1\controllers;
 
use Yii;
use api\common\BaseActiveController;
 
/**
 * Resume Controller API
 *
 * @author dawei
 */
class FreetimeController extends BaseActiveController
{
    public $modelClass = 'common\models\Freetime';

    public $id_column = 'dayofweek';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

    public $page_size = 10000;

    public function actions()
    {
        $as = parent::actions();
        unset($as['create']);
        return $as;
    }

    public function beforeAction($action) {
        $query = $this->buildBaseQuery();
        if ($query->count()<7) {
            $m = $this->modelClass;
            $m::createForUser(Yii::$app->user->id);
        }
        return parent::beforeAction($action);
    }

    public function actionFreeAll(){
        $m = $this->modelClass;
        $m::updateAll(['morning'=>1, 'afternoon'=>1, 'evening'=>1], 'user_id='.Yii::$app->user->id);
        return $this->renderJson([
            "success" => true,
            "message" => '设置成功',
        ]);
    }
}
