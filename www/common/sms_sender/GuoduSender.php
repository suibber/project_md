<?php
namespace common\sms_sender;

use Yii;
use yii\base\Component;
use Exception;


class GuoduSender extends Component
{
    public $baseUrl = "http://221.179.180.158:9007/QxtSms/QxtFirewall";

    public $appendID = '';
    public $password = '';
    public $account = '';

    private $errors = [
            //"01" => '批量短信提交成功',
            "02" => 'IP限制',
            //"03" => '单条短信提交成功',
            "04" => '用户名错误',
            "05" => '密码错误',
            "07" => '发送时间错误',
            "08" => '信息内容为黑内容',
            "09" => '该用户的该内容受同天内，内容不能重复发限制',
            "10" => '扩展号错误',
            "97" => '短信参数有误',
            "11" => '余额不足',
            "-1" => '程序异常',
            "xx" => '返回异常，需要重新调试api',
        ];

    public function send($phonenums, $content)
    {
        $params = [];
        $params["DesMobile"] = is_array($phonenums)?implode(',', $phonenums):$phonenums;
        $params["OperID"] = $this->account;
        $params["OperPass"] = $this->password;
        $params["AppendID"] = $this->appendID;
        $params["Content"] = iconv("UTF-8", "GBK//TRANSLIT", $content);
        $params["SendTime"] = date('Ymdhis');
        $params["ValidTime"] = date('Ymdhis', strtotime('+1 hour'));
        $params["ContentType"] = 15;

        $url = $this->baseUrl . '?' . http_build_query($params);

        $body = file_get_contents($url);
        //$http_response_header;
        // this param is very tricky, see http://php.net/manual/en/reserved.variables.httpresponseheader.php
        $code = 'xx';
        if (strpos($http_response_header[0], '200')!==false) {
            $body = iconv("GBK", "UTF-8", $body);
            $code = $this->parseCode($body);
            if (!isset($this->errors[$code])){
                return true;
            }
        }
        Yii::error("Error::failed sending ". $params["DesMobile"] ." with content: $content, error msg:" . $this->errors[$code]);
        return false;
    }

    public function parseCode($body)
    {
        $r = preg_match('/<code>(\-?\d+)<\/code>/i', $body, $matches);
        if ($r) {
            return $matches[1];
        }
        return "xx";
    }
}
