<?php
 
namespace api\miduoduo\v1\controllers;
 
use yii;
use api\common\BaseActiveController;
use common\Utils;
use common\models\Resume;
use common\JobUtils;
 
/**
 * Resume Controller API
 *
 * @author dawei
 */
class UploadImageController extends BaseActiveController
{
    public $modelClass = '';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

    public function actionUpload(){
        return $this->uploadImage($_FILES, Yii::$app->request->post('is_resume'));
    }

    private function uploadImage($files, $is_resume=0){
        $image_key = '';
        foreach( $files as $k => $v ){
            $image_key  = $k;
            $ext = pathinfo($v['name'], PATHINFO_EXTENSION);
            $is_image = Utils::checkUploadFileIsImage($ext);

            if( $is_image ){
                $filename = Utils::saveUploadFile($files[$image_key]);

                if( $is_resume ){
                    $user_id  = Yii::$app->user->id;
                    $resume_model = Resume::findOne(['user_id' => $user_id]);
                    JobUtils::addSyncFileJob($resume_model, $image_key);
                }

                return ['success' => true, 'filename' => $filename, 'name' => $image_key, 'msg' => '图片上传成功'];
            }else{
                return ['success' => false, 'filename' => '', 'name' => $image_key, 'msg' => '文件格式错误'];
            }
        }
    }

}
