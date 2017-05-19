<?php
    $menus = [
        'publish' => [
            'iconfont' => '&#xe609;',
            'title' => '我要发布',
            'children' => [],
            'url' => '/task/publish',
        ],
        'task_management'=> [
            'children' => [
                'task' => ['/task', '全部'],
                'task0'=> ['/task?status=0', '显示中'],
                'task30'=> ['/task?status=30', '审核中'],
                'task40'=> ['/task?status=40', '审核未用过'],
            ],
            'iconfont' => '&#xe609;',
            'title' => '职位管理',
        ],
        'resume_management'  => [
            'children' => [
                'resume' => ['/resume', '全部'],
                'resume10'=> ['/resume?status=10', '已接受'],
                'resume0'=> ['/resume?status=0', '未处理'],
            ],
            'iconfont' => '&#xe60c;',
            'title' => '简历管理',
        ],
        'user' => [
            'children' => [
                'userinfo' => ['/user/info', '我的资料'],
                'change_password' => ['/user/account', '修改密码'],
                'personal_cert' => ['/user/personal-cert', '个人认证'],
                'corp_cert' => ['/user/corp-cert', '企业认证'],
            ],
            'iconfont' => '&#xe60b;',
            'title' => '用户中心'
        ],
        'manpower' => [
            'children' => [
                'time_book' => ['/time-book', '考勤管理']
            ],
            'iconfont' => '&#xe60b;',
            'title' => '人员管理',
        ],
    ];
?>

<div class="qiye-left">
<?php 
    foreach ($menus as $key=>$v){
        $dl = "";
        $is_parent_active = false;
        if ($key==$active_menu){
            $dl .= '<dt class="pitch-on"><i class="iconfont">'
                .$v['iconfont'].'</i><a href="'
                .(isset($v['url'])?$v['url']:'#')
                .'">' . $v['title'].'</a></dt>';
        } else {
            $dl .= '<dt class="default-title"><i class="iconfont">'
                .$v['iconfont'].'</i><a href="'
                .(isset($v['url'])?$v['url']:'#')
                .'">' . $v['title'].'</a></dt>';
        }
        foreach ($v['children'] as $ckey=>$cv){
            if ($ckey==$active_menu){
                $is_parent_active = true;
                $dl .= '<dd class="current"><a href="'.$cv[0].'">'.$cv[1].'</a></dd>';
            } else {
                $dl .= '<dd class="default-lis"><a href="'.$cv[0].'">'.$cv[1].'</a></dd>';
            }
        }
        $dl .= "</dl>";
        if ($is_parent_active){
            $dl = '<dl class="pitch-current">' . $dl;
        } else {
            $dl = '<dl>' . $dl;
        }
        echo $dl;
    }
?>
</div>

