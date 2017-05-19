<?php
namespace m\controllers;

use Yii;
use yii\filters\AccessControl;

use common\models\Resume;
use common\models\Freetime;

use m\MBaseController;
use m\models\EditResumeForm;

class ResumeController extends MBaseController
{
     /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['edit', 'freetimes', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ]);
    }

    public function actionEdit()
    {
        $user = Yii::$app->user;
        $model = Resume::findOne(['user_id'=>$user->id]);

        if (!$model){
            $model = new Resume();
            $model->user_id = $user->id;
            $model->phonenum = $user->identity->username;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirectWithSucceedMsg('/task',
                '恭喜您信息提交成功，快去查看兼职职位吧');
        }
        $freetimes = Freetime::findAll(['user_id'=>$user->id]);
        $freetimes_dict = [];
        foreach($freetimes as $freetime){
            $freetimes_dict[$freetime->dayofweek] = $freetime;
        }

        return $this->render('edit', [
            'model' => $model,
            'freetimes'=> $freetimes_dict
        ]);
    }

    public function actionView()
    {
        $user = Yii::$app->user;
        $model = Resume::findOne(['user_id'=>$user->id]);
        if (!$model){
            $this->redirect('/resume/edit');
        }
        $freetimes = Freetime::findAll(['user_id'=>$user->id]);
        $freetimes_dict = [];
        foreach($freetimes as $freetime){
            $freetimes_dict[$freetime->dayofweek] = $freetime;
        }

        return $this->render('view', [
            'model' => $model,
            'freetimes'=> $freetimes_dict
        ]);
       
    }

    public function actionFreetimes()
    {
        if (Yii::$app->request->isPost){
            $dayofweek = intval(Yii::$app->request->post('dayofweek'));
            $when = Yii::$app->request->post('when');
            $is_availiable = filter_var(
                Yii::$app->request->post('is_availiable'),
                FILTER_VALIDATE_BOOLEAN);
            if ($this->setFreetime(Yii::$app->user->id, $dayofweek, $when, $is_availiable)){
                $this->renderJson([
                    'result'=> true,
                    'is_availiable'=> $is_availiable
                ]);
            } else {
                $this->renderJson([
                    'result'=> false,
                ]);
            }
        }
    }

    protected function setFreetime($user_id, $dayofweek, $when, $is_availiable)
    {
        $freetime = Freetime::findOne(['user_id'=>$user_id, 'dayofweek'=>$dayofweek]);
        if (!$freetime){
            $freetime = new Freetime();
            $freetime->dayofweek = $dayofweek;
            $freetime->user_id = $user_id;
            $freetime->$when = $is_availiable;
        } else {
            $freetime->$when = $is_availiable;
        }
        if (!$freetime->hasErrors()){
            return $freetime->save();
        }
        return false;
    }
}
