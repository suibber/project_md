<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use frontend\FBaseController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\LoginWithDynamicCodeForm;

use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

use common\Utils;
use common\Constants;
use common\models\District;
use yii\helpers\Json;

/**
 * Site controller
 */
class SiteController extends FBaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            [
                'class' => 'yii\filters\HttpCache',
                'only' => ['index'],
                /*
                'lastModified' => function ($action, $params) {
                    $file = Yii::getAlias("@frontend/views/site/index.php");
                    return filemtime($file);
                },
                */
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionDownloadApp()
    {
        $device_type = Utils::getDeviceType(Yii::$app->request->getUserAgent());
        if ($device_type==Constants::DEVICE_IOS){
            return $this->redirect(Yii::$app->params['downloadApp.ios']);
        } else if($device_type==Constants::DEVICE_ANDROID) {
            return $this->redirect(Yii::$app->params['downloadApp.android']);
        }
        return $this->renderPartial('download-app');
    }

    public function actionIndex()
    {
        // echo 'ok';die();//可以到这里
        // $this->redirect(\Yii::$app->params['baseurl.m']);
        // $this->layout= false;
        $mobileAgent = array("iphone", "ipod", "ipad", "android", "mobile", "blackberry", "webos", "incognito", "webmate", "bada", "nokia", "lg", "ucweb", "skyfire");
        
        $browser = Yii::$app->request->userAgent;
        $isMobile = false;

        foreach($mobileAgent as $search){
            if(stristr($browser,$search)!=false){
                $isMobile = true;
                header("Location:".\Yii::$app->params['baseurl.m']);
                exit;
            }
        }
        return $this->render('index');
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionAssurance(){
        return $this->render('assurance');
    }

    public function actionTeam(){
        return $this->render('team');
    }

    public function actionChangeCity(){
        // 数据库中记录的城市
        $user_id = Yii::$app->user->id ? Yii::$app->user->id : 0;
        if( $user_id ){
            $db_city = UserHistoricalLocation::find()
                ->where(['user_id'=>$user_id])
                ->orderBy(['id'=>SORT_DESC])
                ->with('city')
                ->one();
            $db_city_pinyin = isset($db_city->city->seo_pinyin) ? $db_city->city->seo_pinyin : '';
        }else{
            $db_city_pinyin = '';
        }
        $session_city_pinyin = Yii::$app->session->get('city_pinyin');
        if( $db_city_pinyin && !$session_city_pinyin ){
            Yii::$app->session->set('city_pinyin', $db_city_pinyin);
            return $this->redirect('/'.$db_city_pinyin.'/');
        }

        // 城市
        $citys  = District::find()
            ->where(['is_alive'=>1,'level'=>'city'])
            ->orderBy(['seo_pinyin'=>SORT_ASC])
            ->all();
        $citys_json = Json::encode($citys);
        
        // 拼音
        $pinyins = [];
        foreach( $citys as $city ){
            $city_first_word = strtoupper(substr($city->seo_pinyin,0,1));
            if( !in_array($city_first_word,$pinyins) ){
                $pinyins[] = $city_first_word;
            }
        }

        return $this->render('citys', [
            'citys' => $citys,
            'pinyins' => $pinyins,
            'citys_json' => $citys_json,
        ]);
    }
}
