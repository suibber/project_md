<?php
namespace common;

use Yii;
use yii\helpers\Url;
use Exception;
use common\models\WeichatAccesstoken;
use common\models\WeichatUserLog;
use common\models\WeichatUserInfo;
use common\models\WeichatAutoresponse;
use common\models\Task;
use common\models\AccountEvent;
use common\models\UserAccount;
use common\models\User;
use common\models\District;

class WeichatBase
{

    static $session = null;

    public static function getSession(){

        if (!static::$session) {
            static::$session = new WeichatBase();
        }
        return static::$session;
    }

    private $_access_token_key = 'wechat_access_token';


    //运行时access_token 有可能在cache释放
    private $_access_token = null;

    /**
     *
     * getWeichatAccessToken 获取当前有效的微信access-token
     *
     * 如果token过期，脚本会自动获取新的token
     *
     * @author suixb
     * @return str access-token
     *
     */


    public function getWeichatAccessToken(){
        return WechatUtils::getAccessToken();
    }

    /**
     * 
     * postWeichatAPIdata 使用post方法，向微信接口发送请求
     *
     * @author suixb
     * @param string $targetUrl 请求的接口地址
     * @param string $postData 发送的数据如： id=123&name=北京 
     * @return str 微信返回的结果
     *
     */
    public function postWeichatAPIdata($targetUrl,$postData){
        // 请求的数据
        $curlobj    = curl_init();
        curl_setopt($curlobj, CURLOPT_URL,$targetUrl);
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlobj, CURLOPT_HEADER, 0);
        curl_setopt($curlobj, CURLOPT_POST,1);
        curl_setopt($curlobj, CURLOPT_POSTFIELDS,$postData);
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYHOST, FALSE);
        $returnstr  = curl_exec($curlobj);
        if( curl_error($curlobj) ){
            $returnstr  = 'haserror';
        }
        curl_close($curlobj);
        
        return $returnstr;
    }

    public function makeAuthUrl($callback)
    {
        $appid   = Yii::$app->params['weichat']['appid'];
        $secret  = Yii::$app->params['weichat']['secret'];
        $scope   = Yii::$app->params['weichat']['scope1'];
        return 'https://open.weixin.qq.com/connect/oauth2/authorize?'
            . 'appid=' . $appid . '&redirect_uri=' . urlencode($callback)
            . '&response_type=code&scope=' . $scope
            . '&state=fromweichatrequest#wechat_redirect';
    }

    /**
     * 
     * getWeichatAPIdata 使用post方法，向微信接口发送请求
     *
     * @author suixb
     * @param string $targetUrl 请求的接口地址
     * @param string $getData 发送的数据如： id=123&name=北京 
     * @return str 微信返回的结果
     *
     */
    public function getWeichatAPIdata($targetUrl,$getData=''){
        // 请求的数据
        $curlobj    = curl_init();
        curl_setopt($curlobj, CURLOPT_URL, $targetUrl);
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlobj, CURLOPT_HEADER, 0);
        curl_setopt($curlobj, CURLOPT_POSTFIELDS, $getData);
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYHOST, FALSE);
        $returnstr  = curl_exec($curlobj);
        if( curl_error($curlobj) ){
            $returnstr  = 'haserror';
        }
        curl_close($curlobj);

        return $returnstr;
    }

    // 保存用户微信行为数据
    public function saveEventLog($openid,$event_type){
        $openid     = (string)$openid;

        $userModel  = new WeichatUserLog();
        $userModel->openid          = $openid;
        $userModel->created_time    = date("Y-m-d H:i:s",time());
        $userModel->event_type      = $event_type;
        $userModel->save();

        $status                 = $event_type==1 ? WeichatUserInfo::STATUS_OK : WeichatUserInfo::STATUS_CANCEL;
        $is_receive_nearby_msg  = $event_type==1 ? WeichatUserInfo::IS_RECEIVE_NEARBY_MSG_YES : WeichatUserInfo::IS_RECEIVE_NEARBY_MSG_NO;
        $this->updateWeichatStatus($openid,$status,$is_receive_nearby_msg);
    }

    private $_ticket_key = '_wechat_jsapi_ticket';

    public function getJsapiTicket()
    {
        $ticket = Yii::$app->global_cache->get($this->_ticket_key);
        if (!$ticket) {
            $baseurl = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token="
                . $this->getWeichatAccessToken()
                ."&type=jsapi";
            $retry = 3;
            while ($retry>0 && !$ticket){
                try {
                    $c = file_get_contents($baseurl);
                    $arr = json_decode($c);
                    if ($arr->errcode==0){
                        $ticket = $arr->ticket;
                        Yii::$app->global_cache->set(
                            $this->_ticket_key, $ticket, 1.8 * 60 * 60);
                    }
                    Yii::info("Wechat jsapi ticket response code is " . $arr->errorcode);
                } catch (Exception $e) {
                    Yii::warning("Get wechat jsapi ticket failed with error: " . $e->getMessage());
                }
                $retry -= 1;
            }
        }
        if (!$ticket) {
            throw new Exception('微信出错');
        }
        return $ticket;
    }

    public function signParams($params){
        ksort($params);
        $s = '';
        foreach ($params as $k=>$v){
            $s .= strtolower($k) . '=' . $v . '&';
        }
        $s = substr($s, 0, -1);
        return sha1($s);
    }

    public function generateConfigParams($url=null)
    {
        $params = [
            'url'=> $url?$url:(Url::current([], $scheme=true)),
            'nonceStr'=> ''. rand(100000, 999999),
            'jsapi_ticket'=> $this->getJsapiTicket(),
            'timestamp'=> time(),
        ];
        $params['signature'] = $this->signParams($params);
        unset($params['url']);
        $params['debug'] = YII_DEBUG;
        $params['appId'] = Yii::$app->params['weichat']['appid'];
        return $params;
    }

    // 获取当前登录用户的微信ID，如果用户未关注、取消关注 则返回false
    public function getLoggedUserWeichatID($user_id=''){
        $user_id    = $user_id ? $user_id : Yii::$app->user->id;
        $openid_obj = WeichatUserInfo::find()
            ->where(['userid'=>$user_id,'status'=>WeichatUserInfo::STATUS_OK])
            ->one();
        $openid     = isset($openid_obj->openid) ? $openid_obj->openid : 0;
        if( $openid ){
            return $openid;
        }else{
            return false;
        }
    }

    public function getUserinfoByOpenid($openid=''){
        $userinfo = WeichatUserInfo::find()
            ->where(['openid'=>$openid])
            ->with('user')
            ->with('resume')
            ->with('user_historical_location')
            ->one();
        return $userinfo;
    }

    public function hasFollowed($openid){
        $openid_obj   = WeichatUserInfo::find()
            ->where(['openid'=>$openid,'status'=>WeichatUserInfo::STATUS_OK])
            ->one();
        $has_followed = isset($openid_obj->id) ? true : false;
        return $has_followed;
    }

    public function updateWeichatStatus($openid,$status,$is_receive_nearby_msg){
        WeichatUserInfo::updateAll(
            ['status'=>$status,'is_receive_nearby_msg'=>$is_receive_nearby_msg],
            ['openid'=>$openid]
        );
    }

    // 自动回复消息-关注
    public function autoResponseByFollowaction(){
        $model  = WeichatAutoresponse::find()->where(['type'=>1,'status'=>1])->One();
        return $model->response_msg;
    } 

    // 自动回复消息-未知关键词
    public function autoResponseByUnknownMsg(){
        $model  = WeichatAutoresponse::find()->where(['type'=>3,'status'=>1])->One();
        return $model->response_msg;
    } 

    // 自动回复消息-关键字
    public function autoResponseByKeyword($openid,$keyword=''){
        if( strtolower(trim($keyword)) == 'tdd' ){
            WeichatUserInfo::SwitchSubscribeDailyPush($openid,0);
            return '你已经成功退订每日兼职推送，如需重新订阅，请回复dyd。';
        }elseif( strtolower(trim($keyword)) == 'dyd' ){
            WeichatUserInfo::SwitchSubscribeDailyPush($openid,1);
            return '订阅每日兼职成功！每日兼职将每天为您推送最新最热的兼职信息。';
        }
        $model  = WeichatAutoresponse::find()
            ->where(['status'=>1])
            ->andWhere(['like','keywords',"%".$keyword."%",false])
            ->One();
        if( !empty($model->response_msg) ){
            return $model->response_msg;
        }else{
            // 未命中关键字，改为搜索任务名称
            // 用户默认城市
            $userinfo = $this->getUserinfoByOpenid($openid);
            $city_id = isset($userinfo->user_historical_location->city_id) ? $userinfo->user_historical_location->city_id : 3 ;

            $task_model = Task::find()
                ->where(['status'=>0, 'city_id' => $city_id])
                ->andWhere(['>', 'to_date', date("Y-m-d")])
                ->andWhere(['like','title',"%".$keyword."%",false])
                ->limit(9)->All();
            if( count($task_model)>0 ){
                return $this->renderTaskLink($task_model, $city_id, $keyword);
            }else{
                return false;
            }
        }
    }

    public function renderTaskLink($task_model, $city_id=3, $keyword=''){
        $city = District::findOne(['id'=>$city_id]);
        $city_name = isset($city->name) ? $city->name : '当前城市';

        $msg_body   = '<ArticleCount>'.count($task_model).'</ArticleCount><Articles>';
        $img         = Yii::$app->params['baseurl.static.m'].'/static/img/wx_list1.jpg';
        $url         = Yii::$app->params['baseurl.wechat']."/view/index.html?from=singlemessageisappinstalled=0";
        $msg_body   .= '
                <item>
                <Title><![CDATA[在'.$city_name.'搜索“'.$keyword.'”结果]]></Title> 
                <Description><![CDATA[在'.$city_name.'搜索“'.$keyword.'”结果]]></Description>
                <PicUrl><![CDATA['.$img.']]></PicUrl>
                <Url><![CDATA['.$url.']]></Url>
                </item>
            ';
        foreach( $task_model as $k => $v ){
            if( $k == 0 ){
                $img         = Yii::$app->params['baseurl.static.m'].'/static/img/wx_list1.jpg';
            }else{
                $img         = Yii::$app->params['baseurl.static.m'].'/static/img/wx_list2.jpg';
            }
            $url         = Yii::$app->params['baseurl.wechat']."/view/job/job-detail.html?task=".$v->id;
            $msg_body   .= '
                <item>
                <Title><![CDATA['.$v->title.']]></Title> 
                <Description><![CDATA['.$v->title.']]></Description>
                <PicUrl><![CDATA['.$img.']]></PicUrl>
                <Url><![CDATA['.$url.']]></Url>
                </item>
            ';
            
        }
        $msg_body .= '</Articles>';
        return $msg_body;
    }

    public static function checkErweimaValid($create_date){
        $today_time  = time();
        $create_time = strtotime($create_date);
        $diff_time   = $today_time - $create_time;
        $valid_time  = 60 * 60 * 24 * 6;
        if( $diff_time >= $valid_time ){
            return false;
        }else{
            return true;
        }
    }

    public function createErweimaByUserid($user_id){
        $scene_id       = $user_id; // 扫描后返回值
        $access_token   = $this->getWeichatAccessToken();

        $targetUrl      = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token="
            .$access_token;
        $postData       = "";

        // 7天的二维码
        $postData       = '{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';

        $ticketJson = $this->postWeichatAPIdata($targetUrl,$postData);
        $ticketArr  = json_decode($ticketJson);

        WeichatUserInfo::updateAll(
            [
                'erweima_date' => date("Y-m-d"),
                'erweima_ticket' => $ticketArr->ticket,
            ],
            ['userid' => $user_id]
        );

        return $ticketArr->ticket;
    }

    public function createErweimaByTaskid($task_id){
        $scene_id       = $task_id; // 扫描后返回值
        $access_token   = $this->getWeichatAccessToken();

        $targetUrl      = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token="
            .$access_token;
        $postData       = "";

        // 7天的二维码
        $postData       = '{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$scene_id.'}}}';

        $ticketJson = $this->postWeichatAPIdata($targetUrl,$postData);
        $ticketArr  = json_decode($ticketJson);

        Task::updateAll(
            [
                'erweima_date' => date("Y-m-d"),
                'erweima_ticket' => $ticketArr->ticket,
            ],
            ['id' => $task_id]
        );

        return $ticketArr->ticket;
    }

    public function putMoneyToAccount($data){
        $model          = new AccountEvent();
        $model->date     = $data['date'];
        $model->user_id  = $data['user_id'];
        $model->value    = $data['value'];
        $model->note     = $data['note'];
        $model->operator_id  = $data['operator_id'];
        $model->created_time = $data['created_time'];
        $model->task_gid     = isset($data['task_gid']) ? $data['task_gid'] : '0';
        $model->red_packet_accept_by = isset($data['red_packet_accept_by']) ? $data['red_packet_accept_by'] : 0;
        $model->related_id   = '';
        $model->balance  = 0;
        $model->type     = isset($data['type']) ? $data['type'] : 0;
        $model->save();

        // update user_account
        $user_account_obj = new UserAccount();
        $user_account_obj->updateUserAccount($model->user_id);

        // send weichat notice
        $weichat_base   = new WeichatBase();
        $pusher_weichat_id       = $weichat_base::getLoggedUserWeichatID($data['user_id']);
        $pusher_date['first']    = '您好，您有一笔收入到账';
        $pusher_date['keyword1'] = $data['note'];
        $pusher_date['keyword2'] = $model->value.'元';
        $pusher_date['keyword3'] = $model->created_time;
        $pusher_date['remark']   = '您可以点击通知查看收入详情。';
        $pusher_task_gid         = $model->task_gid;
        Yii::$app->wechat_pusher->accountEventIn($pusher_date,$pusher_task_gid,$pusher_weichat_id);
        
        return true;
    }

    public static function sendRedPacketToInviter($invitee_userid){
        $invitee = User::findOne(['id'=>$invitee_userid]);
        $inviter_id = isset($invitee->invited_by) ? $invitee->invited_by : 0;
        $inviter = User::findOne(['id'=>$inviter_id]);
        
        $has_send = AccountEvent::findOne([
            'user_id' => $inviter_id,
            'red_packet_accept_by' => $invitee_userid,
        ]);

        if( $inviter_id && !isset($has_send->id) ){
            $note = Yii::$app->params['weichat']['red_packet']['note'];
            $username = substr($invitee->username, 0, 3).'****'.substr($invitee->username, -4);
            $note = str_ireplace( '{username}', $username, $note );

            // 给 $inviter_id 发红包
            $data = [
                'date'      => date("Y-m-d"),
                'user_id'   => $inviter_id,
                'value'     => Yii::$app->params['weichat']['red_packet']['value'],
                'note'      => $note,
                'operator_id'  => 0,
                'created_time' => date("Y-m-d H:i:s"),
                'red_packet_accept_by' => $invitee_userid,
                'type'      => AccountEvent::TYPES_WEICHAT_RECOMMEND,
            ];
            $weichat_base = new WeichatBase();
            $weichat_base->putMoneyToAccount($data);
            User::updateAll(
                ['red_packet_num'=>$inviter->red_packet_num + 1],    
                ['id'=>$inviter->id]
            );
        }
    }

    public static function sendRedPacketToUserFirstTime($userid){
        $user = User::findOne(['id'=>$userid]);

        $has_send = AccountEvent::findOne([
            'user_id' => $userid,
            'red_packet_accept_by' => $userid,
        ]);

        if( isset($user->id) && !isset($has_send->id) ){
            $note = Yii::$app->params['weichat']['red_packet']['note_me'];

            // 给 $inviter_id 发红包
            $data = [
                'date'      => date("Y-m-d"),
                'user_id'   => $user->id,
                'value'     => Yii::$app->params['weichat']['red_packet']['value_me'],
                'note'      => $note,
                'operator_id'  => 0,
                'created_time' => date("Y-m-d H:i:s"),
                'red_packet_accept_by' => $user->id,
                'type'      => AccountEvent::TYPES_WEICHAT_RECOMMEND,
            ];
            $weichat_base = new WeichatBase();
            $weichat_base->putMoneyToAccount($data);
        }
    }
}
