<?php
namespace m;

use Yii;
use yii\web\HttpException;
use yii\helpers\Url;
use common\BaseController;
use common\Utils;
use common\models\WeichatUserInfo;
use common\models\User;
use common\WeichatBase;
use common\models\AccountEvent;

// ����Ѿ����Ի�ȡ���û�΢����Ϣ����ִ���κβ����������Ի�ȡ�û�΢����Ϣ
class WeiChatController extends BaseController{
    public $hasFetchWeichatID   = 0;        // �Ƿ��Ѿ���ȡ��΢��ID
    public $weichatState        = '';       // �Ƿ���΢����ת�����ģ������������ state
    public $isWeichatWeb        = 1;        // �Ƿ���΢�������
    public $appid               = '';       // ΢�Ź��ں�ID
    public $secret              = '';       // ΢��secret
    public $scope               = '';       // ��������

    public function __construct(){
        $this->appid   = Yii::$app->params['weichat']['appid'];
        $this->secret  = Yii::$app->params['weichat']['secret'];
        $this->scope   = Yii::$app->params['weichat']['scope1'];
        $this->hasFetchWeichatID    = Yii::$app->session->get('weichat')['hasFetchWeichatID'] ? Yii::$app->session->get('weichat')['hasFetchWeichatID'] : 0;
        $this->weichatState         = Yii::$app->request->get('state') ? Yii::$app->request->get('state') : $this->weichatState;
        $this->isWeichatWeb         = Utils::isInWechat();

        Yii::trace("wechat appid is " . $this->appid);

        if( $this->isWeichatWeb){
            // ��һ�ν��룬�ж��Ƿ��ȡ��΢��ID
            Yii::trace("This request is from wechat");
            if( !$this->hasFetchWeichatID ){
                if( $this->weichatState == 'fromweichatrequest' ){
                    // 2. ��ȡ�û�΢����Ϣ
                    Yii::trace("|||||||||||||||->get wechat info");
                    $this->getWeichatInfoFetch();
                }else{
                    // 1. ��ת��΢����Ȩҳ��
                    Yii::trace("|||||||||||||||->jump wechat info");
                    $this->getWeichatInfoJump();
                }
            // �Ѿ����Ի�ȡ��΢����Ϣ�����ڴ���
            }else{
                // �ж��ѵ�¼�û����Ƿ��Ѿ���΢��
                // ���SESSION������openid�������û���½�ˣ������ȥ��
                $weichat= Yii::$app->session->get('weichat');
                $openid = isset($weichat['openid']) ? $weichat['openid'] : 0;
                $userid = Yii::$app->session->get('__id');
                $unionid= isset($weichat['unionid']) ? $weichat['unionid'] : 0;
                $hasBindWeichatID = isset($weichat['hasBindWeichatID']) ? $weichat['hasBindWeichatID'] : 0;

                // ���������Ϣ
                if( $openid ){
                    Yii::$app->session->set('origin','weichat');
                }

                if( $openid && $userid && !$hasBindWeichatID ){
                    // �󶨣��������ݿ�
                    if( $this->bindWeichatID($openid,$userid,$unionid) ){
                        // ����Ѿ����Թ���
                        $weichatInfo  = Yii::$app->session->get('weichat');
                        $weichatInfo['hasBindWeichatID']  = 1;
                        Yii::$app->session->set('weichat',$weichatInfo);
                    }else{
                        // ��ʧ��
                    }
                }else{
                    // ��������
                }
            }
        } else {
            Yii::trace("This request is not from wechat");
        }
    }

    // 1. ��ת��΢����Ȩҳ��
    public function getWeichatInfoJump(){
        // ͨ��΢�Žӿڻ�ȡ΢����Ϣ
        $appid          = $this->appid;
        $scope          = $this->scope;
        
        // �������ص����ĵ�ַ
        $redirect_uri_real  = Url::current([], $scheme=true);
        $redirect_uri       = urlencode($redirect_uri_real);
        Yii::trace("Go to wechat auth page with rediret uri : " . $redirect_uri);
        $getCodeUrl         = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'&response_type=code&scope='.$scope.'&state=fromweichatrequest#wechat_redirect';

        $this->redirect($getCodeUrl);
    }

    // 2. ��ȡ�û�΢����Ϣ
    public function getWeichatInfoFetch(){
        // �õ�΢�ŷ��صĲ���
        $code           = Yii::$app->request->get('code');
            
        // ��ȡaccess token
        $appid          = $this->appid;
        $secret         = $this->secret;
        $getTokenUrl    = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
        // ����ӿ�
        $getTokenJson   = $this->getWeichatAPIdata($getTokenUrl);
        if( $getTokenJson != 'haserror' ){
            $getTokenArr    = json_decode($getTokenJson);

            // ��token ��ȡ�û���΢��id
            $token          = $getTokenArr->access_token;
            $openid         = $getTokenArr->openid;

            $weichatInfo    = array();
            if( $openid ){
                $this->loginByWeichatID($openid);
                $weichatInfo['openid']  = $openid;
                $weichatInfo['unionid']  = $getTokenArr->unionid;
            }
        }

        // ����Ѿ���ȡ��΢����Ϣ
        $weichatInfo['hasFetchWeichatID'] = true;
        // ����ȡ����΢����Ϣ���浽SESSION
        Yii::$app->session->set('weichat',$weichatInfo);
    }

  // ����΢�ŵĽӿ�����
    private function getWeichatAPIdata($targetUrl){
        // ���������
        $curlobj    = curl_init();
        curl_setopt($curlobj, CURLOPT_URL,$targetUrl);
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlobj, CURLOPT_HEADER, 0);
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curlobj, CURLOPT_TIMEOUT, 1000);
        $returnstr  = curl_exec($curlobj);
        if( curl_error($curlobj) ){
            $returnstr  = 'haserror';
        }
        curl_close($curlobj);
        
        return $returnstr;
    }

    // ͨ��΢��idʵ�ֵ�¼
    private function loginByWeichatID($openid){
        // ��ѯ�û�����Ϣ������У����Զ���¼
        $weichat_result = WeichatUserInfo::find()->where(['openid'=>$openid])->one();
        if( $weichat_result ){
            // �û�����ɱ����ɾ���󶨹�ϵ
            $user_result    = User::find()->where(['id'=>$weichat_result->userid])->one();
            if( !$user_result ){
                // $weichat_result->delete(); ��ɱ�������ﴦ��Ӧ������ɱ�ĵط�
            }else{
                Yii::$app->session->set('__id',$weichat_result->userid);
                // ���µ�¼ʱ��
                $datetime       = date("Y-m-d H:i:s",time());
                $weichat_result->updated_time = $datetime;
                $weichat_result->save();
            }
        }
        // ��΢��id���浽session,�û���½���Զ���
        $weichatInfo['openid']    = $openid;
    }
    
    // ��ȡ��΢���˺š���¼��--��΢���˺�
    private function bindWeichatID($openid,$userid,$unionid){
        // �ж��Ƿ��Ѿ���
        $weichat_result = WeichatUserInfo::find()->where(['userid'=>$userid])->one();
        if( !$weichat_result ){
            // �ж��Ƿ���ڰ󶨹�ϵ��¼
            $weichat_user = WeichatUserInfo::findOne(['openid'=>$openid]);
            if( isset($weichat_user->openid) ){
                WeichatUserInfo::updateAll(['userid'=> $userid,'unionid'=>$unionid],['openid'=>$openid]);
                if( $weichat_user->origin_type == WeichatUserInfo::ORIGIN_TYPES_REDPACKET ){
                    User::updateAll(
                        ['invited_by'=> $weichat_user->origin_detail],
                        ['id'=>$userid]
                    );
                }
            }else{
                $datetime       = date("Y-m-d H:i:s",time());
                // �������ݣ���ɰ�
                $weichat    = new WeichatUserInfo();
                $weichat->openid    = $openid;
                $weichat->unionid   = $unionid;
                $weichat->userid    = $userid;
                $weichat->created_time    = $datetime;
                $weichat->updated_time    = $datetime;
                $weichat->is_receive_nearby_msg = 1;    // �°󶨵��û���Ĭ�Ͻ���΢��������Ϣ
                $weichat->save();
            }

            // ��������ע�ᣬ�������˷����
            $invitee_userid = $userid;
            WeichatBase::sendRedPacketToInviter($invitee_userid);
        }
        return true;
    }

    // �ж��Ƿ���΢�������
    // ���������IOS����ʹ��
    private function isWeichatWeb(){ 
      Yii::trace("request User agent is " . Yii::$app->request->userAgent);
      if ( stripos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
          Yii::trace("judged request is from wechat");
          return 1;
      }
      Yii::trace("judged request is not from wechat");
      return 0;
    }
}
