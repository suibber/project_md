<?php
namespace common;

use Yii;
use yii\web\Controller;


class BaseController extends Controller
{
    public function renderJson($data)
    {
        header('Content-type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        Yii::$app->end();
    }

    public function redirectHtml($to, $msg='')
    {
        echo "
        <!DOCTYPE HTML>
        <html lang='en-US'>
            <head>
                <meta charset='UTF-8'>
                <script type='text/javascript'>
            " . 'setTimeout("window.location.href = \''.$to.'\';", 3000);'
            . " </script>
                <title>跳转</title>
            </head>
            <body>
                <p >
                如果没有跳转，请<a href='$to'>点击这里</a>
                </p>
                <p>". $msg ."</p>
            </body>
        </html>
        ";
        Yii::$app->end();
    }

    public static function timePast($the_time){
        $now_time = date("Y-m-d H:i:s",time()+8*60*60);
        $now_time = strtotime($now_time);
        $show_time = strtotime($the_time);
        $dur = $now_time - $show_time;
        if($dur < 0){
            return $the_time;
        }else{
            if($dur < 60){
                return $dur.'秒前';
            }elseif($dur < 60 * 60){
                return floor($dur/60).'分钟前';
            }elseif($dur < 60 * 60 * 24){
                return floor($dur/3600).'小时前';
            }elseif($dur < 60 * 60 * 24 * 7){
                return floor($dur/86400).'天前';
            }else{
                return substr($the_time,0,10);
            }
        }
    }

}
