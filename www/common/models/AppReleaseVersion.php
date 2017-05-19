<?php

namespace common\models;

use Yii;
use common\H5Utils;
use common\Constants;

/**
 * This is the model class for table "{{%app_release_version}}".
 *
 * @property integer $id
 * @property integer $device_type
 * @property string $app_version
 * @property string $html_version
 * @property string $update_url
 * @property string $release_time
 * @property string $h5_map_file
 * @property string $features
 */
class AppReleaseVersion extends \common\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%app_release_version}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['device_type', 'app_version', 'html_version', 'api_version'], 'required'],
            [['device_type'], 'integer'],
            [['release_time'], 'safe'],
            [['app_version', 'html_version', 'api_version'], 'string', 'max' => 45],
            [['update_url', 'h5_map_file'], 'string', 'max' => 1000],
            ['features', 'default', 'value'=>''],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'device_type' => '设备类型',
            'app_version' => '应用版本',
            'api_version' => 'api版本',
            'html_version' => 'html版本',
            'update_url' => '升级链接',
            'release_time' => '发布时间',
            'h5_map_file' => 'H5 地图文件',
            'features' => '更新详情',
        ];
    }

    /**
     * @inheritdoc
     * @return AppReleaseVersionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppReleaseVersionQuery(get_called_class());
    }

    public function getDevice_type_label()
    {
        if ($this->device_type==Constants::DEVICE_ANDROID){
            return "安卓";
        }
        if ($this->device_type==Constants::DEVICE_IOS){
            return "苹果";
        }
        return null;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->h5_map_file = H5Utils::generateUrl($this->html_version);
            return true;
        } else {
            return false;
        }

    }
}
