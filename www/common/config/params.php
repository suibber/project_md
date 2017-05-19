<?php
return [
    'adminEmail' => 'webmaster@miduoduo.cn',
    'supportName' => '米多多运营中心',
    'supportEmail' => 'contact@miduoduo.cn',
    'supportTel' => '010-84991662',
    'bugEmail' => '1bbd853df30a46a695cd7d350bee6caa+lukps3jjzxxxx3gr1rzd@boards.trello.com',

    'baidu.map.server_key' => 'oUVOlwx2f8Ok7iGt30CcB2aQ',
    'baidu.map.web_key' => 'GB9AZpYwfhnkMysnlzwSdRqq',

    'user.passwordResetTokenExpire' => 3600,

    'baseurl' => 'miduoduo.cn',
    'baseurl.api' => 'http://api.miduoduo.cn',
    'baseurl.m' => 'http://m.miduoduo.cn',
    'baseurl.backend' => 'http://dashboard.miduoduo.cn',
    'baseurl.corp' => 'http://corp.miduoduo.cn',
    'baseurl.frontend' => 'http://www.miduoduo.cn',
    'baseurl.h5_origin' => 'http://origin.miduoduo.cn',
    'baseurl.media' => 'http://media.miduoduo.cn',
    'baseurl.wechat' => 'http://wechat.miduoduo.cn',
    'baseurl.model' => 'http://model.miduoduo.cn',

    'baseurl.static.m' => 'http://static.miduoduo.cn/m',
    'baseurl.static.www' => 'http://static.miduoduo.cn/www',
    'baseurl.static.corp' => 'http://static.miduoduo.cn/corp',
    'baseurl.static.dashboard' => '',

    'nearby_search.max_distance' => 10000, // 单位米
    'host_ip' => '',

    'time_book.valid_distance' => 500, // 单位米

    'downloadApp.android' => 'http://a.app.qq.com/o/simple.jsp?pkgname=cn.miduoduo.android',
    'downloadApp.ios' => 'https://itunes.apple.com/zh/app/mi-duo-duo-jian-zhi/id1016364056',

    'wechat_payment.id' => '',
    'wechat_payment.key' => '',

    'weichat'=>[
        'appid'     => 'wxc940e677d43db45d',                // 微信公众号ID
        'secret'    => '284769fa88c6ba0496cc2aa06ef1d7c4',  // 微信secret
        'scope1'    => 'snsapi_base',                       // 获取基本信息
        'scope2'    => 'snsapi_userinfo',                   // 获取详细信息
        'pushset'   => [
            'pushtime'      => [1=>'12:00',2=>'19:30'],     // 推送时间
            'pushtype'      => [1=>'固定内容',2=>'用户偏好'],   // 推送类型
            'status'        => [1=>'启用',2=>'停用'],           // 状态
            'tmp_weichat'   => [1=>'兼职',2=>'通知'],           // 微信模板
        ],
        'tmp_weichat'  => [
            'quality'   => '-gglDuUE4SjcfP69Vj2Y_7yho-9Ox1vrW_2GAdcd9aA',  // 优单模板
            'nearby'    => 'qwENcjpEuIBn53LHyFh4-PmmpVaSmL04WpylDX1JkaE',  // 附近模板
            'applicant' => 'srIf6HPINf-I-BmlPJSqxfJ_E-ZUFlrp_D4MUUvQFOc',  // 报名成功
            'accountin' => 'Bo7ZbPipKywJ2kBdwCcJnF75fbhpRW4cvGoYHdLW8CY',  // 收入提醒
            'appmsg'    => '-gglDuUE4SjcfP69Vj2Y_7yho-9Ox1vrW_2GAdcd9aA',  // 职位消息通知
        ],
        'preview_user'  => '13699273824,18611299991,18210135925,13240055520',// 定时推送预览人员
        'url'   => [
            'erweima_show' => 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=', // 二维码显示
        ],
        'red_packet' => [
            'value' => 2, // 被邀请人注册，邀请人获得金额
            'note' => '成功邀请好友{username}注册', // 微信提示消息
            'value_me' => 1, // 被邀请人注册，邀请人获得金额
            'note_me' => '参与米多多红包活动', // 微信提示消息
        ],
    ],

    'seo'   => [
        'title' => [
            'index' => '【米多多兼职 miduoduo.cn】网上兼职_兼职网_学生兼职',
            'city'  => '【[city]兼职|[city]兼职网|[city]兼职招聘】——[city]',
            'block' => '【[block]兼职|[block]兼职网|[block]兼职招聘】——[block]米多多兼职',
            'type'  => '【[city][type]兼职|[city][type]招聘|[city][type]日结】——[city]米多多兼职',
            'clearance_type'    => '【[city][clearance_type]兼职|[city][clearance_type]招聘|[city]日结】——[city]米多多兼职',
            'detail'=> '【[task_title]_[company]】-[city]米多多兼职',
        ],
        'keywords'  => [
            'index' => '【米多多兼职 miduoduo.cn】网上兼职_兼职网_学生兼职',
            'city'  => '【[city]兼职|[city]兼职网|[city]兼职招聘】——[city]米多多兼职',
            'block' => '【[block]兼职|[block]兼职网|[block]兼职招聘】——[block]米多多兼职',
            'type'  => '【[city][type]兼职|[city][type]招聘|[city][type]日结】——[city]米多多兼职',
            'clearance_type'    => '【[city][clearance_type]兼职|[city][clearance_type]招聘|[city]日结】——[city]米多多兼职',
            'detail'=> '[city][type]，[city][block]兼职，[company]最新兼职',
        ],
        'description'  => [
            'index' => '米多多兼职平台提供最新更全的兼职、兼职招聘信息，您可以免费查询大学生兼职、兼职打字员、周末兼职、网络兼职、兼职家教等兼职信息，兼职简历，兼职工作选择米多多兼职平台。',
            'city'  => '米多多[city]兼职招聘是[city]最专业的兼职网站，为用户提供最全面的兼职信息，包括发传单、家教、服务员、促销、礼仪等热门[city]兼职招聘信息，免费为企业提供招聘服务，[city]找兼职首选米多多[city]兼职招聘',
            'block' => '米多多[block]兼职招聘是最专业的[block]兼职网站，为用户提供最全面的兼职信息，包括发传单、家教、服务员、促销、礼仪、日结兼职等热门[block]兼职招聘信息，免费为企业提供招聘服务，[block]找兼职首选米多多[block]兼职招聘',
            'type'  => '米多多[city][type]招聘频道是[city]最专业的[type]兼职网站，每天免费为[city]找[type]高薪兼职工作、临时工、暑期工的求职者提供最新最全的招聘兼职信息，免费为企业提供[type]人才招聘服务，[city]找[type]兼职首选米多多[city][type]兼职招聘',
            'clearance_type'    => '米多多[city][clearance_type]招聘频道是[city]最专业的[clearance_type]兼职网站，每天免费为[city]找[clearance_type]高薪兼职工作、临时工、暑期工的求职者提供最新最全的招聘兼职信息，免费为企业提供[clearance_type]人才招聘服务，[city]找[clearance_type]兼职首选米多多[city][clearance_type]兼职招聘',
            'detail'=> '[company]最新招聘信息,诚聘[task_title][need_quantity]人，工作地点位于[address]，薪资待遇[salary]，[detail]',
        ],
    ],

    'config'=>[
        'recommend_type' => [       // 推荐信息分类
            1 => 'M端-首页推荐',
        ],
    ],

    'file_log' =>[
        'max_size'      => 20000,
        'log_base_url'  => '/var/miduoduo/miduoduo/www/user_logs/',
    ],

    // 需要在`jz_task_onlinejob`和`jz_task_applicant_onlinejob`增加字段,model也要改
    'onlinejob.evidence' => [
        'need_phonenum' => '注册手机号',
        'need_username' => '注册用户名',
        'need_person_idcard' => '身份证号',
    ],

    /*
    开发账号 settings ，如果使用，请copy注释的部分到 params-local.php
        'weichat'=>[
            'appid'     => 'wxf18755b4d95797ac',                // 微信公众号ID
            'secret'    => '42e2440d817f1c4d2889790e2a3369e4',  // 微信secret
            'scope1'    => 'snsapi_base',                       // 获取基本信息
            'scope2'    => 'snsapi_userinfo',                   // 获取详细信息
            'pushset'   => [
                'pushtime'      => [1=>'12:00',2=>'19:30'],     // 推送时间
                'pushtype'      => [1=>'固定内容',2=>'用户偏好'],   // 推送类型
                'status'        => [1=>'启用',2=>'停用'],           // 状态
                'tmp_weichat'   => [1=>'兼职',2=>'通知'],           // 微信模板
            ],
            'tmp_weichat'  => [
                'quality'   => '3_dIRci_3IDpL3E1D69Vm17w_LB_4AM6ATB7f4Qw3H8',     // 优单模板
                'nearby'    => 'cMI9HFLDvuHJrhakSszPCre8oWaUA6nSVv74pCpoN3c',     // 附近模板
            ],
        ],
    */
];
