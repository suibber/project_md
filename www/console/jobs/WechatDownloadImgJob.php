<?php

namespace console\jobs;

use console\BaseJob;
use common\models\TaskApplicantOnlinejob;
use common\WechatUtils;

class WechatDownloadImgJob extends BaseJob
{

    public function actionDown($id)
    {
        $model = TaskApplicantOnlinejob::findOne([
            'id' => $id,
            'has_sync_wechat_pic' => 0,
        ]);
        $needinfos = unserialize($model->needinfo);
        foreach( $needinfos as $k => $media_id ){
            $needinfos[$k] = WechatUtils::downloadMediaFile($media_id);
        }
        $model->needinfo = serialize($needinfos);
        $model->has_sync_wechat_pic = 1;
        $model->save();
    }
}
