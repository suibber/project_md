<?php
namespace m\controllers;

use m\MBaseController;
use Yii;
use common\models\WeichatErweima;
use common\models\WeichatErweimaLog;
use common\WeichatBase;
use common\models\WeichatUserInfo;
use common\models\Task;
use yii\web\BadRequestHttpException;

class WeichatController extends MBaseController{

    public function actionIndex(){
        // 第一次接入微信，做验证
        if( Yii::$app->request->get("echostr") ){
            echo Yii::$app->request->get("echostr");
            exit;
        }
        Yii::trace("Get message from wechat.");
        $this->responseMsg();
    }

    private function responseMsg(){
        // get post data, May be due to the different environments
        $postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : '';
        if( !$postStr ){
            throw new BadRequestHttpException('无权限访问该页面！');
            exit;
        }

          // extract post data
        if (!empty($postStr)){
                libxml_disable_entity_loader(true);
                  $postObj        = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername   = $postObj->FromUserName;   // 微信用户ID
                $toUsername     = $postObj->ToUserName;     // 开发者账号
                $keyword        = trim($postObj->Content);  // 用户输入信息
                $time           = $postObj->CreateTime;     // 请求时间
                $msgtype        = $postObj->MsgType;        // 请求类型
                $event          = $postObj->Event ? $postObj->Event : '';   // 事件类型

                $re_contentStr  = '';                       // 返回消息
                $re_time        = time();                   // 返回时间
                $re_msgType     = "text";                   // 返回消息类型
                // 返回消息模板
                $re_textTpl     = "
                                <xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content>
                                <FuncFlag>0</FuncFlag>
                                </xml>
                "; 

                // 创建对象：用户微信行为
                $WeichatErweimaLog  = new WeichatBase();

                // 如果是消息类型
                if( $msgtype == 'text' ){
                    $re_contentStr  = $WeichatErweimaLog->autoResponseByKeyword($fromUsername,$keyword);
                    // 1.任务搜索结果 返回图文消息
                    if( strpos($re_contentStr,'>') ){
                        $re_msgType     = 'news';
                        $re_textTpl     = "
                            <xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            
                                %s
                            
                            </xml>        
                        ";
                    // 2.无结果
                    }elseif(!$re_contentStr){
                        $re_contentStr  = $WeichatErweimaLog->autoResponseByUnknownMsg();
                    // 3.命中关键字
                    }else{
                        $re_contentStr;
                    }
                // 如果是事件类型
                }else{
                    // 如果是扫描二维码，之前用户已关注
                    if( $event == 'SCAN' ){
                        // 获取二维码的返回值
                        $Ticket   = $postObj->Ticket ? $postObj->Ticket : '';
                        $re_contentStr  = $this->getReturnMsgByTicket($Ticket,$fromUsername,0);
                    // 如果是扫描二维码，之前用户未关注
                    }elseif( $event == 'subscribe' ){
                        // 获取二维码的返回值
                        $Ticket   = $postObj->Ticket ? $postObj->Ticket : '';
                        if( $Ticket ){
                            $re_contentStr  = $this->getReturnMsgByTicket($Ticket,$fromUsername,1);
                            // 扫描关注
                            $has_followed   = $WeichatErweimaLog->hasFollowed($fromUsername);
                            if( !$has_followed ){
                                if($fromUsername){
                                    $WeichatErweimaLog->saveEventLog($fromUsername,1);  // 1表示关注事件
                                }
                            }
                        }else{
                           // 单纯的关注事件
                           $re_contentStr  = $WeichatErweimaLog->autoResponseByFollowaction(); 
                            // 保存数据
                            if($fromUsername){
                                $WeichatErweimaLog->saveEventLog($fromUsername,1);  // 1表示关注事件
                            }
                        }
                    // 取消关注事件
                    }elseif( $event == 'unsubscribe' ){
                        // 保存数据
                        if($fromUsername){
                            $WeichatErweimaLog->saveEventLog($fromUsername,2);  // 2表示取消关注事件
                        }
                    }else{
                        $re_contentStr  = $WeichatErweimaLog->autoResponseByKeyword($fromUsername,$keyword);
                    }
                }
                $resultStr = sprintf($re_textTpl, $fromUsername, $toUsername, $re_time, $re_msgType, $re_contentStr);
                echo $resultStr;
        }else {
            // 没有POST参数过来
            echo "access denied";
            exit;
        }
        
    }

    // 通过扫描二维码返回的ticket，找到需要返回的内容，并记录扫描日志
    public function getReturnMsgByTicket($ticket,$openid,$isNew=0){
        // 用户推广红包
        $weichat_user = WeichatUserInfo::findOne(['erweima_ticket'=>$ticket]);
        if( isset($weichat_user->userid) ){
            $reMsg  = "您好，欢迎关注米多多优职！领现金红包点这里 \n<a href='".Yii::$app->params['baseurl.m']."/red-packet/my'>红包链接</a>";
            $current_user = WeichatUserInfo::findOne(['openid'=>$openid]);
            if( !isset($current_user->openid) ){
                $model = new WeichatUserInfo();
                $model->openid = (string)$openid;
                $model->is_receive_nearby_msg = WeichatUserInfo::IS_RECEIVE_NEARBY_MSG_NO;
                $model->origin_type = WeichatUserInfo::ORIGIN_TYPES_REDPACKET;
                $model->origin_detail = (string)$weichat_user->userid;
                $model->save();
            }
        }else{
            // 任务地址
            $task_info = Task::findOne(['erweima_ticket'=>$ticket]);
            if( isset($task_info->id) ){
                $reMsg  = "您好，欢迎关注米多多优职！报名“".$task_info->title."”点这里>><a href='".Yii::$app->params['baseurl.wechat']."/view/job/job-detail.html?task=".$task_info->id."'>立即报名</a>";
                $current_user = WeichatUserInfo::findOne(['openid'=>$openid]);
                if( !isset($current_user->openid) ){
                    $model = new WeichatUserInfo();
                    $model->openid = (string)$openid;
                    $model->is_receive_nearby_msg = WeichatUserInfo::IS_RECEIVE_NEARBY_MSG_NO;
                    $model->origin_type = WeichatUserInfo::ORIGIN_TYPES_PC_TASK;
                    $model->origin_detail = (string)$task_info->id;
                    $model->save();
                }
            }else{
        
                // 通过ticket查找返回信息
                $erweima    = WeichatErweima::find()->where(['ticket'=>$ticket])->one();
                $reMsg      = isset($erweima->after_msg) ? $erweima->after_msg : "点击底部菜单进入相关专题。 \n其他问题在输入框直接填写，米小多会即时回复您。找不到想找的兼职，也回复给我们吧";
                $erweima_id = $erweima['id'];

                // 保存用户扫描记录
                if( isset($erweima['id']) ){
                    $erweilog   = new WeichatErweimaLog();
                    $erweilog->erweima_id       = $erweima_id;
                    $erweilog->openid           = (string)$openid;
                    $erweilog->create_time      = date("Y-m-d H:i:s",time());
                    $erweilog->has_bind         = 0;
                    $erweilog->follow_by_scan   = $isNew;
                    $erweilogsave               = $erweilog->save();
                    // 更新总扫描数量
                    $erweima->scan_num  = $erweima->scan_num+1;
                    $erweima->update();
                }
            }
        }

        return $reMsg;
    }


}
