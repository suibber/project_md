<?php
namespace common\sms_sender;

use Yii;
use yii\base\Component;

class BaifentongSender extends Component
{
    public $account = 'dlcsyj00';
    public $password = 'gUp48QVj';

    public function post($data, $url) {
        $url_info = parse_url($url);
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader .= "Host:" . $url_info['host'] . "\r\n";
        $httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader .= "Content-Length:" . strlen($data) . "\r\n";
        $httpheader .= "Connection:close\r\n\r\n";
        //$httpheader .= "Connection:Keep-Alive\r\n\r\n";
        $httpheader .= $data;

        $fd = fsockopen($url_info['host'], 80);
        fwrite($fd, $httpheader);
        $gets = "";
        while(!feof($fd)) {
            $gets .= fread($fd, 128);
        }
        fclose($fd);
        if($gets != ''){
            $start = strpos($gets, '<?xml');
            if($start > 0) {
                $gets = substr($gets, $start);
            }
        }
        return $gets;
    }

    public function send($phonenum, $content){
        $url = "http://cf.lmobile.cn/submitdata/Service.asmx/g_Submit";
        $posts = [
            'sname' => $this->account,
            'spwd'=> $this->password,
            'scorpid'=>'',
            'sprdid'=>'1012818',
            'sdst'=>$phonenum,
            'smsg'=>$content
        ];
        $post_data = http_build_query($posts);
        $content = $this->post($post_data, $url);
        $r = strpos($content, '<State>0</State>')!==false;
        if (!$r){
            Yii::error("Error::failed sending $phonenum with content: $content");
        }
        return $r;
    }
}
