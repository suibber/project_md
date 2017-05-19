<?php
 
namespace api\miduoduo\v1\controllers;
 
use Yii;
use api\common\BaseActiveController;
use common\models\UserReadedSysMessage;
 
/**
 * Sys Message Controller API
 *
 * @author dawei
 */
class SysMessageController extends BaseActiveController
{
    public $modelClass = 'common\models\SysMessage';

    public $id_column = 'id';

    public function actions()
    {
        $actions = parent::actions();
        return ['index'=> $actions['index'], 'view'=> $actions['view']];
    }

    public function buildBaseQuery()
    {
        $query = parent::buildBaseQuery();
        $query->andWhere(['>=', 'created_time', \Yii::$app->user->identity->created_time]);
        return $query;
    }

    public function actionUpdate($id)
    {
        $flag = UserReadedSysMessage();
        $flag->sys_message_id = $id;
        $flag->user_id = \Yii::$app->user->id;
        if ($flag->save() === false && !$flag->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }
        return $flag;
    }

    public function actionUpdateAll()
    {
        $model = $this->modelClass;
        $user_id = \Yii::$app->user->id;
        $query = $this->buildBaseQuery();
        $query->andWhere('id not in (select sys_message_id from '
            . UserReadedSysMessage::tableName() .
            ' where user_id = :user_id)', ['user_id'=>$user_id]);
        $msgs = $query->all();
        if (count($msgs)>0){
            $rows = [];
            foreach ($msgs as $msg){
                $rows[] = ['user_id'=> $user_id, 'sys_message_id'=>$msg->id];
            }
            $cmd = Yii::$app->db->createCommand()->batchInsert(
                UserReadedSysMessage::tableName(),
                ['user_id', 'sys_message_id'], $rows);
            $cmd->execute();
        }
        return $this->renderJson([
            "success" => true,
            "message" => '设置成功',
        ]);
    }


}
