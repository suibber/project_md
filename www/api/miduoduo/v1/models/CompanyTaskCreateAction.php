<?php

namespace api\miduoduo\v1\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use common\models\TaskAddress;
use common\models\Company;

class CompanyTaskCreateAction extends \yii\rest\CreateAction
{

    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }
        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);
        $data = Yii::$app->getRequest()->getBodyParams();

        $model->load($data, '');
        if ($model->save()) {
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

            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }

}