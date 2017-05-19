<?php
namespace common\payment;

use SimpleXMLElement;
use Yii;
use yii\base\Component;

class WechatPayment extends Component
{

    /*
     * return wechat payment_no or false
     */

    public function payout($openid, $amount, $order_id, $note)
    {
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $params = [
            'mch_appid' => Yii::$app->params['weichat']['appid'],
            'mchid' => Yii::$app->params['wechat_payment.id'],
            'partner_trade_no' => $order_id,
            'nonce_str' => Yii::$app->security->generateRandomString(),
            'openid' => $openid,
            'check_name' => 'NO_CHECK',
            'amount' => intval($amount * 100),
            'desc' => $note,
            'spbill_create_ip' => Yii::$app->params['host_ip'],
        ];
        $ps = [];
        foreach ($params as $key=> $v){
            $ps[] = ($key . '=' . $v);
        }
        sort($ps);
        $s = implode('&', $ps);
        $s .= '&key=' . Yii::$app->params['wechat_payment.key'];
        $params['sign'] = strtoupper(md5($s));

        $xml = new SimpleXMLElement('<xml/>');
        foreach ($params as $key=>$v){
            $xml->addChild($key, $v);
        }
        $xml_str = $xml->asXML();
        $data = $this->curl($url, $xml_str);
        if ($data){
            $rxml = new SimpleXMLElement($data);
            if ($rxml->return_code=='SUCCESS'){
                return $rxml->payment_no;
            } else {
                Yii::error($rxml->return_msg, 'payment');
            }
        }
        return false;
    }

    function curl($url, $vars, $second=30,$aHeader=[])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSLCERT, 
            Yii::getAlias('@common/config/wechat_cert/apiclient_cert.pem'));
        curl_setopt($ch, CURLOPT_SSLKEY,
            Yii::getAlias('@common/config/wechat_cert/apiclient_key.pem'));
        curl_setopt($ch, CURLOPT_CAINFO, 
            Yii::getAlias('@common/config/wechat_cert/rootca.pem'));

        if( count($aHeader) >= 1 ){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        $data = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        if($data){
            Yii::info($data,'payment');
            return $data;
        }
        $error = curl_errno($ch);
        Yii::error("call faild, errorCode:$error\n", 'payment');
        return false;
    }
}
