<?php
namespace m\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use m\MBaseController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\ConfigBanner;

use common\models\LoginWithDynamicCodeForm;

use m\models\PasswordResetRequestForm;
use m\models\ResetPasswordForm;
use m\models\SignupForm;
use m\models\ContactForm;

use common\models\Task;
use common\models\Resume;
use common\models\District;
use common\models\ConfigRecommend;
use yii\helpers\Json;
use common\models\UserHistoricalLocation;
use common\models\ServiceType;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends MBaseController
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

    public function actionIndex($city_pinyin='beijing', $type_pinyin='', $district_pinyin='')
    {
        $city = District::findOne(
            ['seo_pinyin'=> $city_pinyin, 'level'=>'city', 'is_alive'=> 1]);

        $city_id = $city ? $city->id : '';

        $district = null;
        $stype = ServiceType::findOne(['pinyin'=> $type_pinyin]);
        if ($city && $district_pinyin){
            $district = District::findOne(
                ['seo_pinyin'=>$district_pinyin, 'parent_id'=> $city->id]);
        }
        
        // 登录用户的上次城市
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

        // 切换城市，更新session
        $session_city_pinyin = Yii::$app->session->get('city_pinyin');
        if( !$session_city_pinyin ){
            Yii::$app->session->set('city_pinyin', $db_city_pinyin);
            $session_city_pinyin = $db_city_pinyin;
            if( !$city_pinyin ){
                $city_pinyin = $db_city_pinyin;
            }
        }
        if ($session_city_pinyin!=$city_pinyin){
             Yii::$app->session->set('city_pinyin', $city_pinyin);
        }
        // 切换城市，更新db
        if( $user_id && $db_city_pinyin != $city_pinyin ){
            $user_historical_location = new UserHistoricalLocation();
            $user_historical_location->city_id = $city_id;
            $user_historical_location->user_id = $user_id;
            $user_historical_location->save();
         }

        // 查询出需要展示的 gids
        // type=1 标示查询的是M端的推荐信息
        $gid        = ConfigRecommend::find()->where(['type'=>1,'city_id'=>$city_id])
            ->limit(15)
            ->addOrderBy(['display_order'=>SORT_DESC])
            ->asArray()->all();
        $gids       = '';
        foreach( $gid as $key => $value ){
            $gids   .= $value['task_id'].',';
        }
        $gids   = trim($gids,',');

        // 广告位
        $banners_city = ConfigBanner::find()
            ->where([
                'city_id' => [0,$city_id],
                'status' => ConfigBanner::STATUS_OK,
            ])
            ->andWhere("`offline_date` >= '".date("Y-m-d")."'")
            ->addOrderBy(['display_order'=>SORT_ASC])
            ->with('task')
            ->limit(5)
            ->all();

        $location   = Yii::$app->session->get('location');
        if($gids){
            // 查询数据显示
            $tasks      = Task::find()->where(['status'=>Task::STATUS_OK])
            ->where('`gid` in('.$gids.')')
            ->andWhere(['>', 'to_date', date("Y-m-d")])
            ->addOrderBy(['display_order'=>SORT_DESC])
            ->joinWith('recommend')->all();

            return $this->render('index', 
                ['tasks'=>$tasks,
                 'city'=>$city,
                 'banners_city' => $banners_city,
                 'city_pinyin'=>$city_pinyin,
                 'current_district' => 
                    empty($district)?$city:District::findOne($district),
                 'location' => $location,
                 'current_service_type' => empty($service_type)?null:ServiceType::findOne($service_type),
                ]);

            return $this->render('index');
        }else{
            $query = Task::find()->where(['status'=>Task::STATUS_OK])
                ->with('city')->with('district');
            $query = $query->andWhere(['city_id'=>$city_id])
                ->andWhere(['>', 'to_date', date("Y-m-d")])
                ->addOrderBy(['id'=>SORT_DESC])
                ->limit(5);
                ;
            return $this->render('index', 
                ['tasks'=>$query->all(),
                 'city'=>$city,
                 'banners_city' => $banners_city,
                 'city_pinyin'=>$city_pinyin,
                 'current_district' => 
                    empty($district)?$city:District::findOne($district),
                 'location' => $location,
                 'current_service_type' => empty($service_type)?null:ServiceType::findOne($service_type),
                ]);
        }
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

    public function actionWechat()
    {
        $this->layout = false;
        return $this->render('wechat');
    }

    public function actionDownload()
    {
        $this->layout = false;
        return $this->render('download');
    }
}
