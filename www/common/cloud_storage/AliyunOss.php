<?php
namespace common\cloud_storage;

require_once(dirname(__FILE__) . '/aliyun_oss/sdk.class.php');

use yii\base\Component;
use ALIOSS;

class AliyunOss extends Component
{

    public $access_id;
    public $access_key;
    public $hostname;

    private $_oss;


    public function getOSS()
    {
        if (!$this->_oss){
            $this->_oss = new ALIOSS($this->access_id,
                $this->access_key, $this->hostname);
        }
        return $this->_oss;
    }

    public function uploadFile($file, $to_file, $bucket='miduoduo')
    {
        $oss = $this->getOSS();
        $r = $oss->upload_file_by_file($bucket, $to_file, $file);
        return 'http://miduoduo.oss-cn-beijing.aliyuncs.com/' . $to_file;
    }

}
