<?php
namespace m\controllers;

use Yii;
use yii\helpers\Url;
use common\WeichatBase;
use common\WechatUtils;
use common\models\WeichatUserInfo;
use api\common\Utils as AUtils;


class WechatController extends \common\BaseController
{

    public function actionEnv($callback=null)
    {
        $w = new WeichatBase;
        $config = $w->generateConfigParams();
        $env = [
            'wx_config'=> $w->generateConfigParams(
                Yii::$app->request->referrer),
            'baidu_map_key'=> Yii::$app->params['baidu.map.web_key'],
            ];
        $str = json_encode($env);
        if ($callback){
            header('Content-Type: application/javascript');
            echo $callback . "('" . $str . "')";
        } else {
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');
            echo $str;
        }
        exit();
    }

    public function actionAuth($return_page)
    {
        $params = [
            'origin_url' => Yii::$app->request->referrer,
            'callback_url' => $return_page,
        ];
        Yii::$app->session['wechat_state'] = $params;
        $callback = Url::to(['auth-end'], $scheme=true);
        $url = WechatUtils::makeAuthUrl($callback, $state='');
        return $this->redirect($url);
    }

    public function actionAuthEnd()
    {
        $code = Yii::$app->request->get('code');
        $params = Yii::$app->session['wechat_state'];
        if (!$code){
            throw new \yii\web\NotFoundHttpException();
        }

        $key      = "wechat.authcode." . $code;
        $lock_key = "wechat.authcode.lock." . $code;

        // 等待前一个请求写入缓存
        usleep(20000); // 0.2 second
        $locked = Yii::$app->cache->get($lock_key);
        $times  = 0;
        while ( $locked && ($times<10) ){
            $times++;
            usleep(100000); // 0.1 second
            $locked = Yii::$app->cache->get($lock_key);
        }
        $winfo = Yii::$app->cache->get($key);

        if (!$winfo){
            Yii::$app->cache->set($lock_key, 1, 5 * 60);
            $winfo = WechatUtils::getUserTokenByCode($code);
            Yii::$app->cache->delete($lock_key);
            Yii::$app->cache->set($key, $winfo, 5 * 60);
        }

        $openid = $winfo['openid'];
        $unionid= $winfo['unionid'];

        $record = WeichatUserInfo::find()->where(['openid'=>$openid])->one();
        if(!$record){
            $record = WeichatUserInfo::find()->where(['unionid'=>$unionid])->one();
        }
        if (!$record){
            $record = new WeichatUserInfo;

            $record->openid = $openid;
            $record->unionid   = $unionid;
            $record->userid = 0;
            $record->is_receive_nearby_msg = 1; //接受微信推送消息
            $record->save();
        }elseif( !isset($record->unionid) || !($record->unionid) ){
            WeichatUserInfo::updateAll(['unionid'=>$unionid],['openid'=>$openid]);
        }elseif( !isset($record->openid) || !($record->openid) ){
            WeichatUserInfo::updateAll(['openid'=>$openid],['unionid'=>$unionid]);
            
        }
        $to = $params['callback_url'];
        $to .= '?origin_url=' . urlencode($params['origin_url']);
        if ($record->user){
            $user = $record->user;
            if (empty($user->access_token)) {
                $user->generateAccessToken();
                $user->save();
            }
            $userinfo = AUtils::formatProfile($user);
            $to .= '&user=' . urlencode(json_encode($userinfo));
        }
        $wechat = ['openid'=>$record->openid];
        $to .= '&wechat=' . urlencode(json_encode($wechat));
        return $this->redirect($to);
    }

}
