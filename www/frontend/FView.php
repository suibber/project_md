<?php

namespace frontend;


class FView extends \yii\web\View
{

    public $nav_left_title = '';
    public $nav_left_link = null;

    public $nav_right_link = null;
    public $nav_right_title = '';
    public $page_title = '';
    public $page_keywords;
    public $page_description;

    public $wechat_apis = [];
}
