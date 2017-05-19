<?php

namespace m\controllers;

use yii;
use m\MBaseController;
use common\models\WeichatUserInfo;
use common\WeichatBase;
use common\models\LoginWithDynamicCodeForm;
use common\models\User;
use common\models\AccountEvent;
use yii\helpers\Json;
use common\models\District;

class RedPacketController extends MBaseController
{
    public function actionIndex($id='2006'){
        $user_id = $id;
        $weichat_user = WeichatUserInfo::find()
            ->where(['userid'=>$id])
            ->with('resume')
            ->one();
        $weichat_base = new WeichatBase();

        if( !$weichat_base->checkErweimaValid($weichat_user->erweima_date) ){
            $erweima_ticket = $weichat_base->createErweimaByUserid($user_id);
        }else{
            $erweima_ticket = $weichat_user->erweima_ticket;
        }

        $this->layout = false;
        return $this->render(
            'index',
            [
                'weichat_user' => $weichat_user,
                'erweima_ticket' => $erweima_ticket,
            ]
        );
    }

    public function actionMy(){
        $user_id = Yii::$app->user->id;
        $inviter_value = Yii::$app->params['weichat']['red_packet']['value'];
        if( $user_id ){
            WeichatBase::sendRedPacketToUserFirstTime($user_id);

            $userinfo = User::find()->where(['id'=>$user_id])->with('resume')->one();
            
            $inviteds = AccountEvent::find()
                ->where([
                    'user_id'=>Yii::$app->user->id,
                    'type'=>AccountEvent::TYPES_WEICHAT_RECOMMEND,
                ])
                ->with('invitee')
                ->limit(10)
                ->all();
            $invited_all = AccountEvent::find()
                ->where([
                    'user_id'=>Yii::$app->user->id,
                    'type'=>AccountEvent::TYPES_WEICHAT_RECOMMEND,
                ]);
            $invited_all_people = $invited_all->count();
            $invited_all_value = $invited_all->sum('value');
               
            $this->layout = false;
            return $this->render(
                'my',
                [
                    'inviteds' => $inviteds,
                    'user_id' => $user_id,
                    'invited_all_people' => $invited_all_people,
                    'invited_all_value' => $invited_all_value,
                    'inviter_value' => $inviter_value,
                    'userinfo' => $userinfo,
                ]
            );
        }else{
            // 城市
            $citys  = District::find()
                ->where(['is_alive'=>1,'level'=>'city'])
                ->orderBy(['seo_pinyin'=>SORT_ASC])
                ->all();
            $citys_json = Json::encode($citys);

            $model = new LoginWithDynamicCodeForm();
            if( Yii::$app->request->ispost ){
                $data = Yii::$app->request->post();
                if( $model->load($data) && $model->login() ){
                    $red_packet_city = $data['red_packet_city'] ? $data['red_packet_city'] : 0;
                    User::updateAll(
                        ['red_packet_city'=>$red_packet_city],
                        ['username'=>$model->phonenum]
                    );
                    $this->redirect("my");
                }
            }
            return $this->render(
                'vlogin',   
                [
                    'model' => $model,
                    'inviter_value' => $inviter_value,
                    'citys_json' => $citys_json,
                ]
            );
        }
        exit;
    }

    public function actionMyRecords(){
        $user_id = Yii::$app->user->id;
        if( $user_id ){
            $inviteds = AccountEvent::find()
                ->where([
                    'user_id'=>Yii::$app->user->id,
                    'type'=>AccountEvent::TYPES_WEICHAT_RECOMMEND,
                ])
                ->with('invitee')
                ->limit(100)
                ->all();
            $invited_all = AccountEvent::find()
                ->where([
                    'user_id'=>Yii::$app->user->id,
                    'type'=>AccountEvent::TYPES_WEICHAT_RECOMMEND,
                ]);
            $invited_all_people = $invited_all->count();
            $invited_all_value = $invited_all->sum('value');
            
            $this->layout = false;
            return $this->render(
                'my-records',
                [
                    'inviteds' => $inviteds,
                    'user_id' => $user_id,
                    'invited_all_people' => $invited_all_people,
                    'invited_all_value' => $invited_all_value,
                ]
            );
        }
    }
}

?>