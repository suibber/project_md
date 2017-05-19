<?php

namespace api\miduoduo\v1\models;
use common\models\TaskAddress;
use common\models\Company;

use Yii;

class CompanyTaskUpdateAction extends \yii\rest\UpdateAction
{
    public function run($id)
    {
        /* @var $model ActiveRecord */
        $model = $this->findModel($id);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }
        $model->scenario = $this->scenario;
        $data = Yii::$app->getRequest()->getBodyParams();
        $model->load($data, '');
        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        Company::updateUseTaskNum();

        $address_ids = isset($data['address_ids']) ? $data['address_ids'] : '';
        if($address_ids){
            $task_id = $model->id;
            $addressList = explode(',', $address_ids);
            foreach($addressList as $item){
                $address = TaskAddress::findOne(['id' => $item]);
                if( isset($address->task_id) ){
                    $address->task_id = $task_id;
                    $address->save();
                }
            }
        }

        return $model;
    }
}