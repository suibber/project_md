
#API
BASE_URL = 'http://api.miduoduo.cn'

##Login 
###通过验证码与手机登陆步骤
- 1
```
    POST /v1/entry/vcode
        参数:    phonenum=手机号
    RETURN:
        { "result": true,
          "message": "验证码已发送" }
        OR:
        { "result": false,
          "message": 错误提示 }
```
- 2
```
    POST /v1/entry/vlogin

        参数:   phonenum=手机号
                code=验证码

    return:
        { "success": false,
            "message": 错误提示 }
        OR
        { "success": true,
            "message": "登陆成功",
            "result": {
                profile 返回值
                }
        }
```
###通过手机号密码登陆
```
    POST /v1/entry/login

        参数:   phonenum=手机号
                password=密码

    return:
        { "success": false,
            "message": 错误提示 }
        OR
        { "success": true,
            "message": "登陆成功",
            "result": {
                profile 返回值
            }
        }
```
###注册
- 1
```
    POST /v1/entry/vcode-for-signup
        参数:    phonenum=手机号
    RETURN:
        { "result": true,
          "message": "验证码已发送" }
        OR:
        { "result": false,
          "message": 错误提示 }
```
- 2
```
    POST /v1/entry/signup

        参数:   phonenum=手机号
                code=验证码
                password=选填
                invited_by＝(int)选填

    return:
        { "success": false,
            "message": 错误提示 }
        OR
        { "success": true,
            "message": "登陆成功",
            "result": {
                "username": "18661775819",
                "password": 密码(直接返回登陆的密码),
                "access_token": "S1AVJulRj22ZwzDAcLB4-zL2Y1kYMZt1_1434246288",
                "resume": {},
                "invited_count": 9,
                }
        }
```
###绑定第三方账号
```
    POST /v1/user/bind-third-party-account
        参数:
            platform=, //wechat等
            params={
                openid: ,
                ....
            }, //  转化为post参数 即: &params[openid]=openid&params[nickname]=nickname&...
    return:
        { "success": false,
            "message": 错误提示 }
        OR
        { "success": true,
            "message": 绑定结果,
        }
```

###第三方账号登陆
```
    POST /v1/entry/t-login
        参数:
            platform=, //wechat等
            params={
                openid: ,
                ....
            }, //  转化为post参数 即: &params[openid]=openid&params[nickname]=nickname&...
    return:
        { "success": false,
            "message": 错误提示 }
        OR
        { "success": true,
            "message": "登陆成功",
            "result": {
                "username": "18661775819",
                "password": 密码(直接返回登陆的密码),
                "access_token": "S1AVJulRj22ZwzDAcLB4-zL2Y1kYMZt1_1434246288"
                "resume": {
                    ...
                },
                "invited_count": 9,
                }
        }
```

###修改密码
```
    POST /v1/user/set-password
    auth required
        参数:   password=修改的密码
                password2=重复确认密码
    return:
        { "success": false,
            "message": 错误提示 }
        OR
        { "success": true,
            "message": 修改成功,
            "result": {
                profile 的返回值
                }
        }
    备注：* 重新设置密码后，之前的access_token将失效
```
### 获取账户信息（查看登陆状态）
```
    GET /v1/user/profile
    return:
        CODE 401, 
        OR
        { "success": true,
            "message": 修改成功,
            "result": {
                "username": "18661775819",
                "password": 密码(直接返回登陆的密码),
                "access_token": "S1AVJulRj22ZwzDAcLB4-zL2Y1kYMZt1_1434246288",
                "resume": {},
                "invited_count": 9,
                "has_resume": boolean,
                "has_wechat": boolean,
                "id_examed": boolean, //认证过
                "is_virgin": boolean,
                "last_city": {   //最后设置的城市 与 user-historical-location 对应数据
                    "id": city_id,
                    "short_name": city_short_name,
                    }

                }
        }
```


##request请求 标识认证信息

我们有两种方式标识出登录后的认证信息
- [Http Basic](https://zh.wikipedia.org/zh-sg/HTTP%E5%9F%BA%E6%9C%AC%E8%AE%A4%E8%AF%81)
- access_token
    * 在所有url后 + ?access_token=登陆成功返回的access_token

##使用api
###api遵循rest api协议

* Path构成
    * /version/model(/:id)
* 请求
    * 分页 见列表内 "_link"
    * 列表 
        * GET /version/model?page=1&per-page=2&expand=company,service_type (*注，不用复数格式)
            * expand 为连表查询的关系字段
            * page 为要获取的页, default=1
            * per-page 为每页数据条数, default=20
            * filters 为筛选条件, 语法如下
                * filters 为数组
                * filters 格式 [[operation, field_name, value], ...]
                * filters 中允许的 operation如下
                    * "=",
                    * "!=",
                    * "<>",
                    * ">=",
                    * "<=",
                    * "LIKE",
                    * "ILIKE",
                    * "IN",
                    * "NOT IN",
            * orders 为排序条件, 语法如下:
                * [order_rule1, order_rule2, ...]
                * order 规则如下：
                ```
                    -id:        按id降序排列
                    id:         按id升序排列
                    -task.id:   按task的id 降序排序
                ```
            * http://api.test.chongdd.cn/v1/task?expand=service_type&filters=[["=", "service_type_id", "10"]]
        * 返回格式:
        ```
    {
        "items": [
                {}, {}, {}, {}, {}
        ],
        "_links": {
            "self": {
              "href": "baseurl/v1/task?page=1&per-page=100"
            },
            "next": {
              "href": "baseurl/v1/task?page=2&per-page=100"
            },
            "last": {
              "href": "baseurl/v1/task?page=2&per-page=100"
            }
        },
        "_meta": {
            "totalCount": 104,
            "pageCount": 2,
            "currentPage": 1,
            "perPage": 100
        }
    }
        ```
    * 详情
        * GET /version/model/id
    * 创建
        * POST /version/model
        * post params = {}
        * 返回值
        ```
        ```
    * 删除
        * DELETE /version/model/id

### 执行失败全局返回说明
* http请求返回的status,[参见http协议](https://zh.wikipedia.org/wiki/HTTP%E7%8A%B6%E6%80%81%E7%A0%81)

具体api
=============================

### 区域

* 获取城市列表
    * GET /version/district?filters=[["=", "level", "city"]]

* 获取城市的区域
    * GET /version/district?filters=[["=", "parent_id", city_id]]
* 区域
```
    {
      "id": 4,
      "parent_id": 3,
      "name": "东城区",
      "level": "district",
      "citycode": "010",
      "postcode": "110101",
      "center": "116.418757,39.917544",
      "full_name": "北京市-北京市市辖区-东城区",
      "is_alive": 0
    },
```
* 搜索城市
```
GET /version/district?filters=[["=", "level", "city"], ["like", "name", city_name]]
```

### 城市首页BANNER

* 获取城市首页BANNER
    * GET /version/city-banner?filters=[["=", "city_id", "3"]]

### 任务类型
* 任务类型列表
    * GET /version/service-type
* 类型详情(几乎无用)
    * GET /version/service-type/id

### 任务（职位）
* 任务列表
    * GET /version/task?expand=company,service_type,city,district,user,addresses&date_range=(weekend_only|current_week|next_week|is_longterm)
    * date_range
        * weekend_only = 查询周末（周六、周日）任务（一个月内的周末任务）
        * current_week = 查询本周任务
        * next_week = 下周任务
	* is_longterm = 长期兼职

* 任务详情
    * GET /version/task/gid

### 附近任务
    *GET /version/task-address/nearby?lat=39.995723&lng=116.423313&distance=5000&service_id&expand=task,company,service_type&date_range=


###任务报名
* 获取已报名的任务列表 
    * GET /version/task-applicant?expand=task
* 报名某任务
    * POST /version/task-applicant
    * params: user_id, task_id
* 取消报名某任务
    * DELETE /version/task-applicant/task_id
* 获取某任务报名情况
    * GET /version/task-applicant/task_id
    *  如果未报名 return 404

### 在线任务
* 任务详情
    * GET /version/task/id
    * 返回格式
    ```
    {
      "id": 502,
      "service_type_id": 17,
      "onlinejob": {
        "id": 40,
        "task_id": 502,
        "name": "米多多app",
        "intro": "米多多找兼职",
        "download_android": "http://download.miduoduo.cn/android",
        "download_ios": "http://download.miduoduo.cn/ios",
        "audit_cycle": 1,
        "need_phonenum": 1,
        "need_username": 1,
        "need_person_idcard": 0
      },
      "onlinejob_needinfo": [
        {
          "id": 16,
          "status": 0,
          "task_id": 502,
          "group_id": 0,
          "type": 1,
          "display_order": 0,
          "intro": "首先打开，下载",
          "intro_pic": "nSBlEnyqj7Kk3ijy_5J235vuPfWgus7J-14423894256193.jpg",
          "is_required": 0,
          "is_must": 0,
          "intro_pic_url": "http://media.test.chongdd.cn/nSBlEnyqj7Kk3ijy_5J235vuPfWgus7J-14423894256193.jpg"
        },
        {
          "id": 17,
          "status": 0,
          "task_id": 502,
          "group_id": 0,
          "type": 1,
          "display_order": 0,
          "intro": "然后填写个人信息注册，要上传",
          "intro_pic": "CIzbd5D9ToUiQYMub1W1k8EwYhYWyD5f-14423894256712.jpg",
          "is_required": 1,
          "is_must": 0,
          "intro_pic_url": "http://media.test.chongdd.cn/CIzbd5D9ToUiQYMub1W1k8EwYhYWyD5f-14423894256712.jpg"
        }
      ]
    }
    ```
    * 参数说明
    ```
    service_type_id = 17：表示任务类型为线上任务
    onlinejob：在线任务特殊字段描述（app名称、app介绍、下载链接、审核周期、是否需要填写账号手机号等）
    onlinejob_needinfo：操作步骤（type 1为图片2为文本、intro为该字段介绍、intro_pic_url为图片介绍、is_required 0表示无需用户填写 1表示需要用户上传或填写）
    ```
* 提交任务
    * POST http://api.suixb.chongdd.cn/v1/task-applicant-onlinejob?access_token=null
    * 参数
    ```
    task_id：任务id
    need_phonenum：app注册手机号
    need_username：app注册账号
    need_person_idcard：app注册身份证号
    onlinejob_needinfo = jietu.jpg  (onlinejob_needinfo为onlinejob_needinfo的id，有多个，如注册截图对应的id为5，那么格式为 5 = 注册截图.jpg)
    ```
    * 返回信息
    ```
    {
      "task_id": "492",
      "app_id": "123",
      "user_id": "2006",
      "needinfo": "a:5:{i:2;s:5:\"2.pic\";i:3;s:5:\"3.pic\";i:6;s:5:\"6.pic\";i:4;s:7:\"suibber\";i:5;s:11:\"13699273824\";}",
      "id": 6
    }
    失败不回返回id
    ```
* 我提交的任务列表
    * GET http://api.suixb.chongdd.cn/v1/task-applicant-onlinejob? filters=[["=","task_id","492"]]&access_token=null
    * 返回信息
    ```
    {
      "items": [
        {
          "id": 2,
          "status": 20,
          "reason": "图片不符",
          "app_id": 0,
          "user_id": 2006,
          "task_id": 492,
          "needinfo": null,
          "has_sync_wechat_pic": 0,
          "need_phonenum": null,
          "need_username": null,
          "need_person_idcard": null,
          "created_time": "2015-09-16 15:19:55",
          "updated_time": null,
          "status_msg": "审核不通过"
        },
        {
          "id": 1,
          "status": 0,
          "reason": null,
          "app_id": 1234,
          "user_id": 2006,
          "task_id": 492,
          "needinfo": "a:5:{i:2;s:5:\"2.pic\";i:3;s:5:\"3.pic\";i:6;s:5:\"6.pic\";i:4;s:7:\"suibber\";i:5;s:11:\"13699273824\";}",
          "has_sync_wechat_pic": 0,
          "need_phonenum": null,
          "need_username": null,
          "need_person_idcard": null,
          "created_time": "2015-09-16 15:19:55",
          "updated_time": null,
          "status_msg": "等待审核"
        }
      ],
      "_links": {
        "self": {
          "href": "/version/task-applicant-onlinejob?filters=[["=","task_id","492"]]&access_token=null"
        }
      },
      "_meta": {
        "totalCount": 2,
        "pageCount": 1,
        "currentPage": 1,
        "perPage": 20
      }
    }
    ```
    * 参数说明
    ```
    status：0等待审核，10审核通过，20审核不通过
    reason：审核未通过原因
    ```
* 我提交的任务详情
    * GET /version/task-applicant-onlinejob/1?access_token=null
    * 返回信息
    ```
    {
      "id": 1,
      "status": 0,
      "reason": null,
      "app_id": 1234,
      "user_id": 2006,
      "task_id": 492,
      "needinfo": {
        "2": "2.pic",
        "3": "3.pic",
        "4": "suibber",
        "5": "13699273824",
        "6": "6.pic"
      },
      "has_sync_wechat_pic": 0,
      "need_phonenum": null,
      "need_username": null,
      "need_person_idcard": null,
      "created_time": "2015-09-16 15:19:55",
      "updated_time": null,
      "status_msg": "等待审核"
    }
    ```
* 修改我提交的任务
    * PUT /version/task-applicant-onlinejob/1?access_token=null

###简历 Resume

* 获取自己简历(使用须取列表中第一个)
    * GET /version/resume?expand=service_types,free_times,home_address,workplace_address
* 获取自己的简历
    * GET /version/resume/user_id?expand=service_types,free_times,home_address,workplace_address
* 更新自己简历
    * PUT /version/resume/user_id
* 创建自己简历
    * POST /vesion/resume

### 简版简历 PreResume
* url :  /version/pre-resume  其他使用同Resume

###图片上传 UploadImage

* 上传一张图片，返回图像地址
    * POST /version/upload-image/upload?access-token params={is_resume:true|false,图片name和数据库字段对应（如：gov_id_pic_front）}

###时间表 Freetime(获取简历时可直接获取)

* 获取自己一周的时间表
    * GET /version/freetime
* 获取某天的时间表
    * GET /version/freetime/day_of_week
    * day_of_week ＝ range(1-7)
* 更新某天的时间表
    * PUT /version/freetime/day_of_week
* 更改所有时间为free
    * POST /version/freetime/free-all

###设置我可做的服务

* 获取可做的服务列表(获取简历时直接获取)
    * GET /version/user-service-type
* 添加可做服务
    * POST /version/user-service-type
        * params: {service_type_id: 10}
* 删除可做服务
    * DELETE /version/user-service-type/service_type_id

###Address 地址
* 获取自己的地址列表
    * GET /version/address
* 查看某地址
    * GET /version/address/id
* 添加新地址
    * POST /version/address
    * params: province,city,district,address,lat,lng
* 修改已有地址
    * PUT /version/address/id
    * params: province,city,district,address,lat,lng
* 删除已有地址
    * DELETE /version/address/id

### 历史城市记录
* 切换城市上传记录
    * POST /version/user-historical-location
    * params: city_id=,lat=选填,lng=选填

###收藏

* 获取收藏的任务列表 
    * GET /version/task-collection?expand=task
* 收藏某任务
    * PUT /version/task-collection
    * params: user_id, task_id
* 取消收藏某任务
    * DELETE /version/task-collection/task_id
* 获取收藏某任务的细节
    * GET /version/task-collection/task_id
    * 如果未收藏return 404

### Message 普通消息
* 获取消息列表
    * GET /version/message
* 获取消息详情(用不到)
    * GET /version/message/id
* 标记信息为read
    * PUT /version/message/id
      params = 随便
* 标记所有信息为read
    * POST /version/message/update-all

### System Message 系统消息
* 获取消息列表
    * GET /version/sys-message?expand=read_flag
* 获取消息详情(用不到)
    * GET /version/sys-message/id
* 标记信息为read
    * PUT /version/sys-message/id
      params = 随便
* 标记所有信息为read
    * POST /version/sys-message/update-all

### 投诉举报
* 获取我举报过的任务列表
    * GET /version/complain
* 获取消息详情(用不到)
    * GET /version/complain/task_id
* 举报
    * POST /version/complain
      params = {title: ,content:, task_id:, phonenum:, }

### 联系我们
    * POST /version/contact-us
      params = {title: optional,content: required, phonenum: required, }
      
### 微信推荐任务分组
    *GET /version/recommend-task-group/9?expand=tasks

### 可提现接口
    *GET /version/pay-account-event?status=0

### 待提现接口
    *GET /version/pay-account-event?status=2

### 已提现接口
    *GET /version/pay-account-event?status=3

### 提现接口
    *GET /version/pay-withdraw?type=10

### 上报信息接口
* 上报push_id和user_id
    * POST /version/report/push-id?access_token=null
    * 提交参数
    ```
    push_id = 极光推送id
    ```

## 企业相关接口

### 企业信息相关
* 获取当前的企业信息
```
    GET /version/company?access_token=null
        参数：null
    RETURN
        成功：
        {
          "success": true,
          "message": "已经开通企业账号",
          "result": {
            "id": 432,
            "name": "测试自主注册",
            "avatar": null,
            "examined_time": null,
            "status": 0,
            "examined_by": 0,
            "user_id": 2006,
            "contact_email": "suixb@miduoduo.cn",
            "intro": "",
            "contact_name": "隋小波",
            "service": null,
            "corp_type": null,
            "corp_size": null,
            "person_name": null,
            "person_idcard": null,
            "person_idcard_pic": null,
            "corp_name": null,
            "corp_idcard": null,
            "corp_idcard_pic": null,
            "exam_result": 48,
            "exam_status": 2,
            "exam_note": null,
            "use_task_date": "2015-10-21",
            "use_task_num": 0, # 今天已操作任务数量
            "allow_task_num": 5, # 今日可操作任务数量
            "created_time": "2015-09-07 17:37:09",
            "origin": 1,
            "status_label": "正常",
            "exam_status_label": "审核完成",
            "exam_result_label": " 身份证验证通过 营业执照验证通过"
          }
        }
        失败：
        {
          "success": false,
          "message": "未开通企业账号"
        }
```
* 创建企业信息
```
    POST /version/company?access_token=null
    参数：
        name = 企业名称
        corp_type = 招聘性质（1 = '企业直聘',2 = '人力资源',3 = '领队'）
        corp_size = 企业规模（0-20人，20-100人，100人以上）
        intro = 公司介绍
        corp_name = 招聘方名称
        city_id = 城市ID，所在地区
        contact_name = 联系人名称
        contact_phone = 联系人电话
        contact_email = 招聘邮箱
        origin = 3（固定，表示注册渠道是移动端）
    RETURN
        成功：
        {
          "name": "name",
          "contact_name": "联系人不能为空",
          "contact_phone": "13901234567",
          "user_id": "2006",
          "id": 2045
        }
        失败：
        [
          {
            "field": "user_id",
            "message": "企业经存在，请勿重新创建!"
          }
        ]
```
* 修改企业信息
```
    PUT /version/company/{企业ID}?access_token=null
    参数：如下
    RETURN 修改后的信息
        成功：
        {
          "id": 432,
          "name": "隋小波的测试企业",
          "avatar": null,
          "examined_time": null,
          "status": 0,
          "examined_by": 0,
          "user_id": 2006,
          "contact_email": "suixb@miduoduo.cn",
          "intro": "",
          "contact_name": "隋小波",
          "service": null,
          "corp_type": null,
          "corp_size": null,
          "person_name": null,
          "person_idcard": null,
          "person_idcard_pic": null,
          "corp_name": null,
          "corp_idcard": null,
          "corp_idcard_pic": null,
          "exam_result": 48,
          "exam_status": 2,
          "exam_note": null,
          "use_task_date": "2015-10-21",
          "use_task_num": 0,
          "created_time": "2015-09-07 17:37:09",
          "origin": 1,
          "status_label": "正常",
          "exam_status_label": "审核完成",
          "exam_result_label": " 身份证验证通过 营业执照验证通过",
          "task_infos": {
              "all": "25",   
              "online": "14",  # 在线任务
              "overtime": "1", # 过期任务
              "offline": "0" # 下线任务
          }
        }
        失败：
        false
```

### 企业任务相关
* 我的任务列表
```
    GET /version/company-task?access_token=null
    参数：
        filters=[["=","status","0"]] 显示中
        filters=[["!=","status","0"]] 未显示
    RETURN：
        {
            "items": [{
              {
              "id": 572,
              "title": "职位名称",
              "clearance_period": 0,
              "salary": "10.00",
              "salary_unit": 2,
              "salary_note": null,
              "from_date": "2015-10-21", # 工作开始日期
              "to_date": "2015-12-21",  # 工作结束日期
              "from_time": null, # 工作开始时间
              "to_time": null,  # 工作结束时间
              "need_quantity": 20, # 需要人数
              "got_quantity": 4,  # 已获得人数
              "created_time": "2015-10-21 15:36:44",
              "updated_time": "0000-00-00 00:00:00",
              "detail": "详细介绍",
              "requirement": null,
              "user_id": 2006,
              "service_type_id": 12,
              "gender_requirement": null,
              "degree_requirement": null,
              "age_requirement": null,
              "height_requirement": null,
              "status": 0,
              "city_id": 3,
              "gid": "14454130049102006",
              "district_id": null,
              "company_id": null,
              "address": "",
              "company_name": "",
              "company_introduction": null,
              "contact": "张三那",
              "contact_phonenum": "13901234567",
              "labels_str": null,
              "origin": "internal",
              "face_requirement": 0,
              "talk_requirement": 0,
              "health_certificated": 0,
              "weight_requirement": 0,
              "sms_phonenum": null,
              "is_longterm": 0, # 是否为长期招聘
              "order_time": "2015-11-05 08:55:12",
              "recommend": 0,
              "is_allday": 0, # 工作时间是否全天
              "time_book_opened": 0,
              "erweima_ticket": "gQHm8DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xLzNVT084TkhtYUxNUjM4dU12VzNUAAIEbM0nVgMEgDoJAA==",
              "erweima_date": "2015-10-22",
              "clearance_period_label": "月结",
              "salary_unit_label": "周",
              "labels": [
                "月结",
                "10-21至12-21"
              ],
              "label_options": [],
              "status_label": "正常",
              "requirements": "",
              "is_overflow": false,
              "xcompany_name": "",
              "onlinejob": null,
              "onlinejob_needinfo": [],
              "service_type": {  # 职位类别
                "id": 12,
                "name": "促销",
                "created_time": null,
                "updated_time": null,
                "modified_by": null,
                "status": 0,
                "pinyin": "cuxiao",
                "status_label": "正常"
              },
              "tasktime": [],
              "undo_applicant_num": "0", # 未处理简历数量
              "addresses": [
                {
                  "id": 267,
                  "province": "河北 ",
                  "city": "秦皇岛 ",
                  "district": null,
                  "lat": 39.824923,
                  "lng": 119.497805,
                  "task_id": 572,
                  "user_id": 2006,
                  "title": "河北 秦皇岛 吉程宾馆 ",
                  "address": "秦皇岛北戴河区北戴河区安一路8号(老虎石海上公园)",
                  "distance": 0,
                  "distance_label": "0m"
                },
                {
                  "id": 268,
                  "province": "河北 ",
                  "city": "秦皇岛 ",
                  "district": null,
                  "lat": 39.941259,
                  "lng": 119.606184,
                  "task_id": 572,
                  "user_id": 2006,
                  "title": "河北 秦皇岛 ",
                  "address": "秦皇岛市",
                  "distance": 0,
                  "distance_label": "0m"
                }
              ]
            },
            {},
            {}
            ]
            "_links": {
                "self": {
                  "href": "http://api.suixb.chongdd.cn/v1/company-task?access_token=NhvBihyN9R-Rovux-eA1klpmX-v1TRgu_1445403967&page=1"
                },
                "next": {
                  "href": "http://api.suixb.chongdd.cn/v1/company-task?access_token=NhvBihyN9R-Rovux-eA1klpmX-v1TRgu_1445403967&page=2"
                },
                "last": {
                  "href": "http://api.suixb.chongdd.cn/v1/company-task?access_token=NhvBihyN9R-Rovux-eA1klpmX-v1TRgu_1445403967&page=5"
                }
              },
              "_meta": {
                "totalCount": 97,
                "pageCount": 5,
                "currentPage": 1,
                "perPage": 20
              }
        }
```

* 查看任务详情
```
    GET /version/company-task/{任务ID}?access_token=null
    参数：
        无
    RETURN：
        任务详情信息
```

* 刷新任务
```
    PUT /version/company-task/{任务ID}?access_token=null
    参数：
        updated_time = 2015-10-27 15:02:27 # 最新时间
    RETURN：
        任务修改后的详情信息
```

* 下架任务
```
    PUT /version/company-task/{任务ID}?access_token=null
    参数：
        status = 10
    RETURN：
        任务修改后的详情信息
```

* 编辑任务
```
    PUT /version/company-task/{任务ID}?access_token=null
    参数：
        
    RETURN：
        任务修改后的详情信息
```

* 发布任务
```
    POST /version/company-task?access_token=null
    参数：
        title = 职位名称
        service_type_id = 服务类别 # 通过接口获取：/version/service-type
        is_longterm = 长期招聘 0,1
        from_date = 任务开始日期
        to_date = 任务结束日期
        is_allday = 工作时间是否为全天  0,1
        from_time = 工作开始时间
        to_time = 工作结束时间
        city_id = 第一个工作地点的城市ID
        address_ids = 工作地点列表ID，如 234,235,236,237 # 地理位置接口：/version/company-task-address?access_token=null
        detail = 详情描述
        need_quantity = 人员要求-人数
        gender_requirement = 人员要求-性别 0 不限，1 男，2 女
        height_requirement = 人员要求-身高 0=>'身高无要求',1=>'155cm以上',2=>'165cm以上',3=>'170cm以上',3=>'175cm以上'
        salary = 薪酬
        salary_unit = 薪酬单位 0=>'小时',1=>'天',2=>'周',3=>'月',4=>'次',5=>'单',6=>'个'
        clearance_period = 结算方式 0=>'月结',1=>'周结',2=>'日结',3=>'完工结',4=>'按单结算',
        contact = 联系人姓名
        contact_phonenum = 联系人手机
        origin = app # 发布信息来源
    RETURN：
        任务发布后的详情信息
```

* 添加地理位置接口
```
    POST /version/company-task-address?access_token=null
    参数：
        province = 省直辖市名
        city = 城市名
        district = 区域名
        lat = 坐标
        lng = 坐标
        task_id = 0
        user_id = 用户ID
        title = 用户搜索的区域名称（北京 融科资讯中心C座 北楼12层）
        address = 百度返回的地理位置名称（北京市海淀区科学院南路2号）
    RETURN：
        成功：
        {
          "lat": "11",
          "lng": "22",
          "task_id": "0",
          "user_id": "2006",
          "id": 400,
          "distance": 0,
          "distance_label": "0m"
        }
        失败：
        false
```

### 企业受到的简历相关操作

* 全部简历
```
    GET version/company-applicant?access_token=null
    参数：
        filters=[["=","task_id","572"]] # 查看某个任务的报名情况
        page=1
    RETURN：
        {
            "items": [
            {
              "id": 11467,
              "created_time": "2015-10-21 16:03:10",
              "user_id": 2006,
              "task_id": 572,
              "company_alerted": 1,
              "applicant_alerted": 1,
              "status": 0,
              "origin": "App:2-",
              "have_read": 0,
              "supposed_salary": null,
              "got_salary": null,
              "account_event_id": null,
              "address_id": null,
              "status_label": "已报名",
              "status_options": {
                "0": "已报名",
                "10": "报名成功",
                "20": "报名失败",
                "30": "已结算"
              },
              "contact_phonenum": "13901234567"
            },
          ],
          "_meta": {
            "totalCount": "36",
            "pageCount": 2,
            "currentPage": "1",
            "perPage": 20
          }
        }
```

* 接受、拒绝简历
```
    PUT /version/company-applicant/{简历投递的ID号}?task_id={任务ID}&access_token=null
    参数：
        status={10录用、20不合适}
    RETURN：
        成功：
            报名详情信息
        失败：
            false
```

* 查看用户简历详情
```
    GET /version/company-resume/{user_id}?task_id={task_id}access_token=null
    参数：
        无
    RETURN：
        成功：
            用户简历信息
        失败：
            false
```

## 关于性能上的优化
    * TODO

## 关于跨域
[Http access control - CORS](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing)
原理：
* 浏览器发送http request 带着 origin
* 服务器http response 带着 Access-Control-Allow-Origin
    * 例 Access-Control-Allow-Origin: http://m.miduoduo.cn
欲知详情请深挖[Wiki](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing)
