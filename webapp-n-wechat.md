#webapp 运行在微信中

## 获取设置
```
GET http://m.miduoduo.cn/wechat/env -> application/json
RETURN:
{
  "wx_config": {
    "nonceStr": "475044",
    "jsapi_ticket": "sM4AOVdWfPE4DxkXGEs8VHdv6jGhQ3KiG1RN2nY6tLck55NoezmR-2QPDWvlMCNERhRDk0UHU4AA7oHmKL5lnw",
    "timestamp": 1437599034,
    "signature": "9a36c91a3801ce2db6b71645593d7b73b55cfbdf",
    "debug": true,
    "appId": "wxf18755b4d95797ac"
  },
  "baidu_map_key": "GB9AZpYwfhnkMysnlzwSdRqq"
}


GET http://m.miduoduo.cn/wechat/env?callback=function_name -> application/javascript
RETURN:
function_name('{"wx_config":{"nonceStr":"475044","jsapi_ticket":"sM4AOVdWfPE4DxkXGEs8VHdv6jGhQ3KiG1RN2nY6tLck55NoezmR-2QPDWvlMCNERhRDk0UHU4AA7oHmKL5lnw","timestamp":1437599034,"signature":"9a36c91a3801ce2db6b71645593d7b73b55cfbdf","debug":true,"appId":"wxf18755b4d95797ac"},"baidu_map_key":"GB9AZpYwfhnkMysnlzwSdRqq"}')
 
```

通过微信获取认证
------------------------

### webapp端不需要关心具体的操作,只需要在打开页面的时候判断cookie中是否设置过openid。
        如果未设置就跳转到http://m.miduoduo.cn/wechat/auth?return_url=设置cookie的页面
###在return_page会接受到get形式的参数，参数格式如下:
    * origin_url: 请求认证传入的参数(一般为请求时页面的链接，在设置完成cookie后，location.href=origin_url便可跳回到请求认证的页面)。
    * user: json format, 用户的相关信息结构同api登陆的返回格式
```
        {
            "id": 4,
            "username": "18661775819",
            "password": "",
            "access_token": "Pd6A4eNq3F7OBEIqXwWIFEFpJNEJvBOz_1438122204",
            "resume": {
                "id": 3,
                "name": "李艳伟",
                "phonenum": "18661775819",
                "gender": 1,
                "birthdate": "2015-06-10",
                "degree": null,
                "nation": null,
                "height": null,
                "is_student": 1,
                "college": "",
                "avatar": null,
                "gov_id": null,
                "grade": 1,
                "created_time": "2015-05-28 03:10:57",
                "updated_time": "2015-06-18 06:20:36",
                "status": 0,
                "user_id": 4,
                "home": 0,
                "workplace": 0,
                "origin": "self",
                "major": "",
                "job_wishes": "",
                "gender_label": "女",
                "age": 0
            }
          }
```
    * wechat: json format ,用户的相关资料
```
        {
            "openid": "",
            ...
        }
```

## 绑定
在通过微信获取认证后，如果用户未绑定账号，则需要用户绑定账号，绑定的流程如下：
* 在登录页、注册页获取miduoduo的认证，拿到access_token
* 使用拿到的access_token 调用api绑定账号，详情见[api：绑定第三方账号](/www/api/README.md)
