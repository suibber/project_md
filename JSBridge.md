miduoduo 协议
=====================

##js bridge的url
```
miduoduo 协议：
1、跳转： mdd:// 跳转协议
2、window.MDDNative 获取交互对象，采用 JS 直接通过MDD 对象调用 native 方法
```


回调函数：
在 交互时，回调函数以函数名字符串方式 传递，在双方需要回调时，通过反射方式，将字符串函数名进行调用
回调函数只有一个 String 类型参数

如
function CallBack(str) {
    .....
}

在传递时，'CallBack'

以下 callback 为该类型

* log 调试信息打印
```
    window.MDDNative.log(message)

```

* 请求认证
```
    window.MDDNative.auth(json，callback)
    json: 字符串
    {
        type：2- 微信登录，1- 注册，0 － 登录
        notInit:
            true: 不填写个人资料
            false：填写资料
    }
    
    注：json ＝ null
    默认 登录页面，成功后，不跳转


    业务：
    详情页 －》 登录／注册 (window.MDDNative.auth(...)) 

    if (url) -> 简历填写页 －> 填写完成（window.MDDNative.popWithRefreshAll()）
    else native 逐个 webView 调用 window.MDDWeb.reload()，html 可以自己去刷新页面
```

* 刷新页面
```
    window.MDDNative.refreshAll()
        
    附：
        native 会调用 html 的js：
        window.MDDWeb.reload(), 由 html 自己选择是否正在刷新，减少用户 流量
```

* 确认框
```
    /**
    message: 要显示的内容
    callback：提示选择后的回调，回调为 JS 函数名，用字符串方式传递
    */
    window.MDDNative.confirm(message,callback)

    附：
        callback：回调函数

```

* 提示框
```
    window.MDDNative.alert(message)

```

* push页面
```
    mdd://XXXX.html
```

* pop页面
```
    window.MDDNative.pop()
```

* popWithRefreshForward
```
    // 刷新上一个页面，即 返回后的那个页面
    window.MDDNative.popWithRefreshForward()

    注： 刷新有 webView 重新加载
```

* pop页面,同时刷新所有 webView
```
    window.MDDNative.popWithRefreshAll()

    注：
        native 会调用 html 的js：
        window.MDDWeb.reload(), 由 html 自己选择是否正在刷新，减少用户 流量

```

* 获取地址
```
    window.MDDNative.address(message,callback)

    callback(address)  address: json 字符串
```

* 获取 UserInfo
```
    var user = window.MDDNative.user()

    user: json 字符串
    {
        id/username/access_token ....
    }
```

* 获取Location
```
    window.MDDNative.location(callback)

    callback：回调函数名
```

* 开始持续定位
```
    window.MDDNative.startLocation(callback)

    callback：回调函数名
```

* 停止持续定位
```
    window.MDDNative.stopLocation()
```

* 获取设备 ID
```
    var id = window.MDDNative.deviceId()
```

* 打卡时间段
```
    window.MDDWeb.clock(boolean show)
    
    show: 
    true : 显示打开
    false：不显示打开按钮
```

* 打卡
```
    window.MDDNative.clock(callback)

    callback：回调函数名
    参数     
    {
        success: bool   成功失败
        message: text   提示文案
    }
```

* 获取 baseUrl
```
    var url = window.MDDNative.baseUrl()

    url:  字符串
```
* 加载中
```
    window.MDDNative.startLoading(message)
    
    message: '加载中' 提示内容
```

* 加载完毕
```
    window.MDDNative.stopLoading()

```

* 返回事件
```
    javascript:window.MDDWeb.back()

    html: 收到返回事件，可以自行处理，如果需要返回，调用 window.MDDNative.pop()
```

* 分享
```
    window.MDDNative.share(message)
    
    message: 字符串
    {
        "base":{ "title": "", // 标题
                  "desc": "", // 描述
                   "img": "", // 图片 url
                   "url": ""  // 分享链接
                }，
        "ext":{ "money": "",// 红包金额 
                "title": "", // 标题 
               "detail": "", // 说明 
              }
    }
```
* 个人身份认证
```
    window.MDDNative.idAuth(callback)
```

* 简历修改
```
    window.MDDNative.resume(has_resume)
    has_resume:
        true: 已填写简历
        false：未填写简历
```

* 简历完整度
```
    window.MDDNative.hasBasicInfo(has)
    has_resume:
        true: 已填写简历
        false：未填写简历
```

* 获取版本
```
    var version = window.MDDNative.version()
```

* 获取设备 ID
```
    var deviceId = window.MDDNative.deviceId()
```

* 上传图片
```
    window.MDDNative.fetchImage(type,callback)
    type: 字符串
        'camera': 从摄像头获取照片
        'album': 从相册获取照片
        '': 空字符表示摄像头和相册的选择
    
    callback: 
        result: 服务端返回信息，字符串 json
        image：img 表示的路径
        
例子：

<img id="image" src="" alt="上海鲜花港 - 郁金香" >

function fetchNativeImage() {
	// camera
	// album
	window.MDDNative.fetchImage("","nativeImageCB");
}

function nativeImageCB(data) {
	image.src = data.image;

	alert("nativeImageCallBack: " + data.result)

}
        
```

