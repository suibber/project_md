<?php

namespace common\pusher;

use Yii;

use common\WeichatBase;
use common\models\WeichatPushLog;
use common\models\TaskNotice;

class WechatPusher extends WeichatBase
{
    public function push($user_id, $tpl_name, $params)
    {
        echo 'test';
    }

    /**
     *
     * pushWeichatMsg 使用消息模板给微信关注用户推送消息
     *
     * 使用消息模板给微信关注用户推送消息
     * @author suixb
     * @param string $touser 推送目标用户微信ID(openid)
     * @param string $weichatTempID 微信消息模板ID
     * @param array $params 消息模板数据
                            $params         = array(
                                array('name'=>'first','value'=>'恭喜你购买成功！','color'=>'#444'),   
                                ......
                            );
     * @param str $gotoUrl 点击消息链接目标地址
     * $param str $topcolor 不知道干嘛的
     * @return boolean 发送成功与否
     *
     */
    public function pushWeichatMsg($touser,$weichatTempID,$params,$gotoUrl='http://m.miduoduo.cn',$pushGroup='',$topcolor='#1BBC9B'){
        // access_token,7200秒过期
        $access_token   = $this->getWeichatAccessToken();
        // 推送消息接口地址
        $targetUrl      = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
        
        // 将 $params 够造成消息体 $data
        $data           = '';
        foreach( $params as $k => $v ){
            $data   .= '
                "'.$v['name'].'": {
                   "value":"'.$v['value'].'",
                   "color":"'.$v['color'].'"
                },'
            ;
        }
        $data       = trim($data,',');

        // 根据传入的参数构造消息内容
        $content    = '
            {
               "touser":"'.$touser.'",
               "template_id":"'.$weichatTempID.'",
               "url":"'.$gotoUrl.'",
               "topcolor":"'.$topcolor.'",
               "data":{
                   '.$data.'    
               }
           }
        ';

        // 发送消息动作
        $returnMsg  = $this->postWeichatAPIdata($targetUrl,$content);
        
        // bao cun fa song ri zhi 
        $this->savePushLog($returnMsg,$touser,$pushGroup);

    }

    // 保存推送消息日志
    private function savePushLog($returnMsg,$openid,$pushGroup=''){
        // 解析
        $returnArr  = json_decode($returnMsg);
        $result     = isset($returnArr->errmsg) ? $returnArr->errmsg : 'null';
        $pushGroup  = $pushGroup ? $pushGroup : uniqid();

        // 保存日志
        if( $result != 'ok' ){
            $log        = new WeichatPushLog();
            $log->push_group    = $pushGroup;
            $log->openid        = $openid;
            $log->create_time   = date("Y-m-d H:i:s",time());
            $log->result        = $result;
            $log->return_msg    = $returnMsg;
            $log->save();
        }
    }

    // 报名微信推送消息
    public function toApplicantTaskAppliedDone($task,$touser){
        // 微信推送
        $weichatTempID  = Yii::$app->params['weichat']['tmp_weichat']['applicant'];
        $params         = array(
            array('name'=>'first','value'=>'您好，本岗位您已报名成功','color'=>'#444'), 
            array('name'=>'keyword1','value'=>$task->gid,'color'=>'#444'),
            array('name'=>'keyword2','value'=>$task->title,'color'=>'#0000FE'),
            array('name'=>'keyword3','value'=>$task->from_date.'至'.$task->to_date,'color'=>'#444'),
            array('name'=>'keyword4','value'=>$task->address,'color'=>'#444'),
            array('name'=>'keyword5','value'=>$task->contact.' '.$task->contact_phonenum,'color'=>'#444'),
            array('name'=>'remark','value'=>"联系时，请告知是从米多多投递的。如遇任何招聘问题，请致电米多多：".Yii::$app->params['supportTel']."。也可点此内容进入职位详情投诉。",'color'=>'#999')
        );
        $gotoUrl        = Yii::$app->params['baseurl.wechat'].'/view/job/job-detail.html?task='.$task->id;
        $this->pushWeichatMsg($touser,$weichatTempID,$params,$gotoUrl);
    }

    public function toApplicantTaskAppliedDonePassYes($task,$touser){
        // 微信推送
        $weichatTempID  = Yii::$app->params['weichat']['tmp_weichat']['appmsg'];
        $company_name   = isset($task->company->name)?$task->company->name:$task->company_name;
        $params         = array(
            array('name'=>'first','value'=>'您好！很高兴，招聘单位已经接受您的报名！','color'=>'#000080'), 
            array('name'=>'keyword1','value'=>$company_name,'color'=>'#000080'),
            array('name'=>'keyword2','value'=>$task->title,'color'=>'#000080'),
            array('name'=>'keyword3','value'=>$task->service_type->name,'color'=>'#000080'),
            array('name'=>'keyword4','value'=>$task->address,'color'=>'#000080'),
            array('name'=>'keyword5','value'=>$task->contact.' '.$task->contact_phonenum,'color'=>'#000080'),
            array('name'=>'remark','value'=>"联系时，请告知是从米多多投递的。如遇任何招聘问题，请致电米多多：".Yii::$app->params['supportTel']."。也可点此内容进入职位详情投诉。",'color'=>'#999')
        );
        $gotoUrl        = Yii::$app->params['baseurl.wechat'].'/view/job/job-detail.html?task='.$task->id;
        $this->pushWeichatMsg($touser,$weichatTempID,$params,$gotoUrl);
    }

    public function toApplicantTaskAppliedDonePassNo($task,$touser){
        // 微信推送
        $weichatTempID  = Yii::$app->params['weichat']['tmp_weichat']['appmsg'];
        $company_name   = isset($task->company->name)?$task->company->name:$task->company_name;
        $params         = array(
            array('name'=>'first',
                'value'=>'您好！很遗憾，您的报名失败了！','color'=>'#000080'), 
            array('name'=>'keyword1','value'=>$company_name,'color'=>'#000080'),
            array('name'=>'keyword2','value'=>$task->title,'color'=>'#000080'),
            array('name'=>'keyword3','value'=>$task->service_type->name,'color'=>'#000080'),
            array('name'=>'keyword4','value'=>$task->address,'color'=>'#000080'),
            array('name'=>'keyword5','value'=>$task->contact.' '.$task->contact_phonenum,'color'=>'#000080'),
            array('name'=>'remark','value'=>"别灰心，你可以查看更多优质的职位去投递。如遇任何招聘问题，请致电米多多：".Yii::$app->params['supportTel']."。也可点此内容进入职位详情投诉。",'color'=>'#999')
        );
        $gotoUrl        = Yii::$app->params['baseurl.wechat'].'/view/index.html';
        $this->pushWeichatMsg($touser,$weichatTempID,$params,$gotoUrl);
    }

    // 企业接受报名推送消息
    public function toApplicantTaskAppliedPass($task,$touser){
        // 微信推送
        $weichatTempID  = Yii::$app->params['weichat']['tmp_weichat']['applicant'];
        $params         = array(
            array('name'=>'first','value'=>'您好，请按约定时间参加'.TaskNotice::$TYPE[$task->notice->type],'color'=>'#444'), 
            array('name'=>'keyword1','value'=>$task->gid,'color'=>'#444'),
            array('name'=>'keyword2','value'=>$task->title,'color'=>'#0000FE'),
            array('name'=>'keyword3','value'=>$task->notice->meet_time,'color'=>'#444'),
            array('name'=>'keyword4','value'=>$task->notice->place,'color'=>'#444'),
            array('name'=>'keyword5','value'=>$task->notice->linkman.','.$task->notice->phone,'color'=>'#444'),
            array('name'=>'remark','value'=>"请您准时参加。如遇问题，请联系米多多：".Yii::$app->params['supportTel']." ",'color'=>'#999')
        );
        $gotoUrl        = Yii::$app->params['baseurl.wechat'].'/view/job/job-detail.html?task='.$task->id;
        $this->pushWeichatMsg($touser,$weichatTempID,$params,$gotoUrl);
    }

    // 资金入账通知
    public function accountEventIn($date,$task_gid,$touser){
        $weichatTempID  = Yii::$app->params['weichat']['tmp_weichat']['accountin'];
        $gotoUrl        = Yii::$app->params['baseurl.wechat'].'/view/pay/cash-account.html?from=singlemessage&isappinstalled=0';
        $params         = array(
            array('name'=>'first','value'=>$date['first'],'color'=>'#000080'), 
            array('name'=>'keyword1','value'=>$date['keyword1'],'color'=>'#000080'),
            array('name'=>'keyword2','value'=>$date['keyword2'],'color'=>'#000080'),
            array('name'=>'keyword3','value'=>$date['keyword3'],'color'=>'#000080'),
            array('name'=>'remark','value'=>$date['remark'],'color'=>'#000080')
        );
        $this->pushWeichatMsg($touser,$weichatTempID,$params,$gotoUrl);
    }
}
