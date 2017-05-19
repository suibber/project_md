<?php
namespace common;

use Yii;

class Utils
{

    public static function getApp()
    {
        return Yii::$app;
    }

    public static function isPhonenum($phonenum)
    {
        return preg_match("/^1[345789]\d{9}$/",$phonenum);
    }

    public static function getDeviceType($user_agent)
    {
        $user_agent = strtolower($user_agent);
        $matches = [];
        preg_match("/iphone|android|ipad|ipod/i", $user_agent, $matches);
        $os = current($matches);
        switch ($os){
            case 'android': 
                return Constants::DEVICE_ANDROID;
                break;
            case 'ipod' || 'iphone' || 'ipad' || 'ipod' || 'ios':
                return Constants::DEVICE_IOS;
                break;
        }
        return null;
    }

    public static function getAppVersion($request)
    {
        return $request->headers->get('App-Version');
    }

    public static function getDeviceId($request)
    {
        return $request->headers->get('Device-Id');
    }


    /*
     * 验证码跑龙套
     */

    public static function generateVerifyCode()
    {
        return strval(rand(1000, 9999));
    }

    public static function cacheVerifyCode($phonenum, $code)
    {
        Yii::trace("verify code for $phonenum is $code");
        Yii::$app->cache->set(static::getVcodeCachekey($phonenum), $code, 30*60);
    }

    public static function sendVerifyCode($phonenum)
    {

        $code = Yii::$app->cache->get(Utils::getVcodeCachekey($phonenum));
        if ($code){
            Utils::cacheVerifyCode($phonenum, $code);
            return Yii::$app->voice_sender->voiceVerify($phonenum, $code);
        }
        $code = Utils::generateVerifyCode();
        Utils::cacheVerifyCode($phonenum, $code);
        $msg = "您的验证码为" . $code . ", 请不要告诉其他人【米多多】";
        return Yii::$app->sms_sender->send($phonenum, $msg);
    }

    public static function getVcodeCachekey($phonenum)
    {
        return 'vcode_for_' . $phonenum;
    }

    public static function validateVerifyCode($phonenum, $code)
    {
        if ($code){
            $vcode = Yii::$app->cache->get(Utils::getVcodeCachekey($phonenum));
            return $vcode==$code;
        }
        return false;
    }

    public static function saveUploadFile($uploadFile)
    {
        $hash = Yii::$app->getSecurity()->generateRandomString() . '-' . intval(microtime(true)*10000);
        $ext = pathinfo($uploadFile['name'], PATHINFO_EXTENSION);
        $filename = $hash . '.' . $ext;
        $uploadfile = Yii::getAlias('@media/' . $filename);
        if(move_uploaded_file($uploadFile['tmp_name'], $uploadfile)) {
            return $filename;
        }
        return false;
    }

    public static function savaDownloadFile($download_url, $ext = 'jpg'){
        $hash = Yii::$app->getSecurity()->generateRandomString() . '-' . intval(microtime(true)*10000);
        $filename = $hash . '.' . $ext;
        $uploadfile = Yii::getAlias('@media/' . $filename);
        if( file_put_contents($uploadfile, file_get_contents($download_url)) ){
            return $filename;
        }else{
            return false;
        }
    }

    public static function checkUploadFileIsImage($ext){
        $exts = ['png', 'jpg', 'tif', 'gif'];
        $ext  = strtolower(trim($ext));
        if( in_array($ext,$exts) ){
            return true;
        }else{
            return false;
        }
    }

    public static function urlOfFile($filename)
    {
        return (substr($filename, 0, 4 ) === "http")?$filename:(
            Yii::$app->params['baseurl.media'] . '/' . $filename);
    }

    public static function absolutePathOfFile($filename)
    {
        return (substr($filename, 0, 4 ) === "http")?
            null:Yii::getAlias('@media/' . $filename);
    }

    /**
     * 微信跑龙套
     *
     */
    public static function isInWechat()
    {
        return stripos(Yii::$app->request->getUserAgent(), 'MicroMessenger') !== false;
    }


    public static function rawsql($query)
    {
        $sql = $query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql;
        return $sql;
    }

    /**
     * 坐标距离
     * return 米;
     */
    public static function distance($poi, $poi2)
    {
        $lat = $poi['lat'];
        $lng = $poi['lng'];
        $lat2 = $poi2['lat'];
        $lng2 = $poi2['lng'];

        $rlat1 = $lat * pi()/180.0;
        $rlat2 = $lat2 * pi()/180.0;
        $rt = $rlat1 - $rlat2;
        $rad = pi()/180.0 ;
        $rg = ($rad * $lng2) - ($rad * $lng);
        $s = (2 * asin(sqrt(pow(sin($rt/2), 2))) +
            cos($rlat1)*cos($rlat2) * pow(sin($rg/2),2)) * 6372.797 * 1000;
        return $s;
    }

    public static function distanceStr($poi, $poi2)
    {
        return Yii::$app->formatter->asDistance(static::distance($poi, $poi2));
    }
}
