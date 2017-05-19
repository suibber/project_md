<?php
use common\models\District;
use common\models\ServiceType;
use yii\widgets\LinkPager;

use yii\helpers\Url;

$this->title = '推荐兼职列表';

$this->nav_left_link = '/';
$this->nav_right_link = '/';
$this->nav_right_title = '首页';
/* @var $this yii\web\View */
?>

<?=
  $this->render('@m/views/task/nearby-list.php', [
        'tasks' => $tasks,
    ]);
?>
<a href="/task" style="color:#ffa005; display:block; padding:10px 0 15px; text-align:center; margin:0 auto;font-size:1.3em;">更多职位&nbsp;>></a>


