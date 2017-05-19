<?php
namespace api\common;
use common\models\User;
use common\models\Resume;


class Utils
{

    public static function formatProfile($user, $password=''){
        if( !empty($user->resume) 
                && strlen($user->resume->name)  
                && ($user->resume->birthdate > '0000-00-00') 
                && strlen($user->resume->gender) 
                && strlen($user->resume->height) 
                && strlen($user->resume->weight) 
                && strlen($user->resume->degree)){
            $has_basicinfo = true;
        }else{
            $has_basicinfo = false;
        }
        $profile = [
            'id'=> $user->id,
            'username'=> $user->username,
            'password'=> $password,
            'invited_count' => User::find()->where(
                ['invited_by'=>$user->id])->count(),
            'access_token'=> $user->access_token,
            'resume' => $user->resume?['1'=>1]:null,
            'has_resume' => !empty($user->resume),
            'has_wechat' => !empty($user->weichat),
            'has_basicinfo' => $has_basicinfo,
            'id_extam_status' => $user->resume?$user->resume->exam_status:false,
            'is_virgin' => $user->is_virgin && empty($user->resume),
            'last_city' => [],
            'company' => isset($user->company->id) ? $user->company->toArray() : false,
        ];
        if ($user->last_location){
            $city = $user->last_location->city;
            $profile['last_city'] = ['id'=>$city->id, 'short_name'=>$city->short_name];
        }
        return $profile;
    }

}
