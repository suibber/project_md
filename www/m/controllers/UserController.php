<?php
namespace m\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\data\Pagination;

use common\Utils;
use common\models\LoginWithDynamicCodeForm;
use common\models\LoginForm;
use common\models\User;
use common\models\TaskApplicant;
use common\models\Resume;

use m\MBaseController;
use m\models\ResetPasswordForm;
use m\models\SignupForm;

/**
 * Site controller
 */
class UserController extends MBaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['signup', 'vcode', 'vsignup', 'vlogin', 'login', 'vcode-for-signup'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'tasks', 'set-password', 'reset-password', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
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


    public function actionIndex()
    {
        return $this->render('index', [
            'resume' => Resume::find()->where(['user_id'=>Yii::$app->user->id])->one(),
                'invited_count' => User::find()->where(
                    ['invited_by'=>Yii::$app->user->id])->count(),
        ]);
    }

    public function actionTasks()
    {
        $query = TaskApplicant::find()
            ->with('task')
            ->where(['user_id'=>Yii::$app->user->id]);

        $query->addOrderBy(['id'=>SORT_DESC]);
        $countQuery = clone $query;
        $pages =  new Pagination(['pageSize'=>10, 'totalCount' => $countQuery->count()]);

        $task_applicants = $query->offset($pages->offset)
            ->limit($pages->limit)->all();

        $tasks = [];

        foreach($task_applicants as $task_applicant){
            $tasks[] = $task_applicant->task;
        }

        return $this->render('tasks', [
            'tasks' => $tasks,
            'pages' => $pages
        ]);

    }

    public function actionVcodeForSignup()
    {
        $phonenum = Yii::$app->request->post('phonenum');
        if (Utils::isPhonenum($phonenum) && User::findByUsername($phonenum)){
            return $this->renderJson([
                'result'=> false,
                'msg'=> "该手机号已注册，您可以直接登录."
            ]);
        }
        return $this->actionVcode();
    }


    public function actionVcode()
    {
        $phonenum = Yii::$app->request->post('phonenum');
        if (!Utils::isPhonenum($phonenum)){
            return $this->renderJson([
                'result'=> false,
                'msg'=> "手机号码不正确"
            ]);
        }
        if (Utils::sendVerifyCode($phonenum)){
            return $this->renderJson([
                    'result'=> true,
                    'msg'=> "验证码已发送"
            ]);
        }
        return $this->renderJson([
                'result'=> false,
                'msg'=> "验证码发送失败, 请稍后重试。"
        ]);
    }

    public function actionVlogin($signuping=false)
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginWithDynamicCodeForm([
            'signup_only' => $signuping
        ]);//this model is ready for insert into db 
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if ($signuping){

                // 如果是注册，记录渠道
                $origin = Yii::$app->session->get('origin') ? Yii::$app->session->get('origin') : '';
                if( $origin ){
                    // 更新用户渠道来源信息
                    $userid     = Yii::$app->user->id;
                    $userModel  = User::findOne($userid);
                    $userModel->origin  = $origin;
                    $userModel->update();
                }

                $url = Url::to([
                        '/user/reset-password',
                        'next' => '/resume/edit'
                    ]);
                return $this->redirect($url);
            } else {
                return $this->redirect('/user/reset-password');
            }
        } else {
            return $this->render('vlogin', [
                'model' => $model,
                'signuping' => $signuping,
            ]);
        }
    }

    public function actionVsignup()
    {
        return $this->actionVlogin($signuping=true);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }


    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        // 微信-标记已退出，本次会话，不在自动登录
        $weichatInfo['hasLogout']	= 1;
        Yii::$app->session->set('weichat',$weichatInfo);

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword()
    {
        $user = Yii::$app->user->identity;
        $model = new ResetPasswordForm($user);
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            $next = Yii::$app->request->get('next');
            if (!empty($next)){
                return $this->redirect($next);
            }
            return $this->goBack();
        }
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


}
