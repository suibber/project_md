<?php
namespace common;

use Yii;
use yii\base\Exception;


class WechatUtils
{

    private static $_access_token_key = 'wechat_access_token';
    private static $_access_token_lock_key = 'wechat_access_token_lock';

    public static function makeAuthUrl($callback, $state='')
    {
        $appid   = Yii::$app->params['weichat']['appid'];
        $secret  = Yii::$app->params['weichat']['secret'];
        $scope   = Yii::$app->params['weichat']['scope1'];

        return 'https://open.weixin.qq.com/connect/oauth2/authorize?'
            . 'appid=' . $appid . '&redirect_uri=' . urlencode($callback)
            . '&response_type=code&scope=' . $scope
            . '&state=' . urlencode($state) . '#wechat_redirect';
    }

    public static function getAccessToken()
    {
        $appid = Yii::$app->params['weichat']['appid'];
        $secret = Yii::$app->params['weichat']['secret'];
        $cache = Yii::$app->global_cache;
        $access_token = null;
        if (!$access_token){
            $access_token =
                $cache->get(static::$_access_token_key);
            if(!$access_token){
                $ac_lock = $cache->get(static::$_access_token_lock_key);
                if (!$ac_lock){
                    $ac_lock = ['locked'=>0, 'tmp_access_token'=> ''];
                    $cache->set(static::$_access_token_lock_key, $ac_lock, 0);
                }
                if ($ac_lock['locked']){
                    $access_token = $ac_lock['tmp_access_token'];
                } else {
                    $ac_lock['locked'] = 1;
                    $cache->set(static::$_access_token_lock_key, $ac_lock, 0);

                    $getTokenUrl =
                        'https://api.weixin.qq.com/cgi-bin/token'
                        . '?grant_type=client_credential'
                        . '&appid='.$appid.'&secret='.$secret;

                    $arr = static::getUrlJson($getTokenUrl);
                    $access_token = $arr['access_token'];
                    $cache->set(static::$_access_token_key,
                        $access_token, 1.8 * 60 * 60);

                    $ac_lock['locked'] = 0;
                    $ac_lock['tmp_access_token'] = $access_token;
                    $cache->set(static::$_access_token_lock_key, $ac_lock, 0);
                }
            }
        }
        return $access_token;
    }

    public static function getUrlJson($targetUrl, $postData=''){
        // 请求的数据
        $error = false;
        $data = [];
        $retry = 3;
        while ($retry>0 && empty($data))
        {
            $curlobj    = curl_init();
            curl_setopt($curlobj, CURLOPT_URL, $targetUrl);
            curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlobj, CURLOPT_HEADER, 0);
            curl_setopt($curlobj, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curlobj, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curlobj, CURLOPT_TIMEOUT, 1000);
            $returnstr  = curl_exec($curlobj);
            if(!curl_error($curlobj) ){
                $err = 0;
                $data = json_decode($returnstr, true);
                if (isset($data['errcode'])){
                    if (intval($data['errcode'])>0){
                        $has_wechat_errcode = Yii::$app->session->get('has_wechat_errcode');
                        if( $has_wechat_errcode ){
                            $callback_url = Yii::$app->session['wechat_state']['callback_url'];
                            Yii::error("wechat:打开微信出错, error code:" . $data['errcode'] . " url is:" . $targetUrl . "callback_url is:".$callback_url);
                            $err = 1;
                            throw new Exception("系统正在调整，请稍后再试");
                        }else{
                            Yii::$app->session->set('has_wechat_errcode', true);
                            header("Location:".Yii::$app->params['baseurl.wechat']."/view/index.html");
                            exit;
                        }
                    }
                    if (intval($data['errcode'])<0){
                        Yii::warning("wechat:打开微信出错, url is:" . $targetUrl);
                        $err = 1;
                    }
                }
                if ($err){
                    $data = [];
                }
            }
            curl_close($curlobj);
            $retry -= 1;
        }
        if (!$data){
            throw new Exception("微信系统异常，请稍后再试");
        }
        return $data;
    }

    public static function getUserTokenByCode($code)
    {
        $appid   = Yii::$app->params['weichat']['appid'];
        $secret  = Yii::$app->params['weichat']['secret'];
        $scope   = Yii::$app->params['weichat']['scope1'];
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token'
            .'?appid=' . $appid . '&secret=' . $secret
            . '&code=' . $code . '&grant_type=authorization_code';
        return static::getUrlJson($url);
    }

    public static function downloadMediaFile($media_id){
        $fileurl   = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token="
            .WechatUtils::getAccessToken()
            ."&media_id=".$media_id;
        $localfile = Utils::savaDownloadFile($fileurl, 'jpg');
        return $localfile;
    }

}
