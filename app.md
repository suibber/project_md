app开发协议
============================

全局规则
----------------------------
* app内，所有非webview调用的Request
    * 所有请求头须带User-Agent, 用以标识设备的类型
    * 所有请求头须带Device-Id, Device-Id为设备全球唯一号，根据不同的设备，或生成，或获取。
    * 所有请求头须带App-Version, 用来表示当前应用版本


* app装机后
    * 获取或生成Device-Id
    * POST/GET /entry/report-device 请求后，服务器会记录该设备相关信息
        * RETURN 
        ```
        {
            'success'=> true,
            'message'=> '记录成功'
            }
        OR
        {
            'success'=> false,
            'message'=> '错误信息'
            }
        ```
    * POST /entry/report-push-id 获取极光推送的reg_id后，告知服务器推送信息
        * params: push_id=极光推送reg_id
        * RETURN 
        ```
        {
            'success'=> true,
            'message'=> '记录成功'
            }
        OR
        {
            'success'=> false,
            'message'=> '错误信息'
            }
        ```

* app更新过程
    * GET,POST /entry/check-update
        * 该操作服务器会返回最新发布的版本，以供app升级使用
            * 所有请求头须带Html5-Version, 用来表示使用Html5版本
            返回值
            ```
         { "result": true,
          "message": 成功信息,
          result: {
              current_app : {
                  app_version: 当前手机的app版本,
                  api_version: api版本
                  html_version: 当前手机可使用的最新html版本,
                  update_url: 更新的链接( android 会是APK的链接，ios会是itunes链接),
                  release_time: 发布时间,
                  h5_map_file: 文件map的url,
                },
              newest_app : {
                  app_version: 最新app版本,
                  api_version: api版本
                  html_version: 最新app版本须使用的最新html版本,
                  update_url: 更新的链接( android 会是APK的链接，ios会是itunes链接),
                  release_time: 发布时间,
                  h5_map_file: 文件map的url,
                  }
              }
          }
            ```
    * GET h5_map_file
    ```
    {
        baseUrl: 'http://origin.miduoduo.cn',
        maps: {
            file : linked_file,
            file : linked_file,
            file : linked_file,
            file : linked_file,
            },
        }
    ```

* app 认证流程
    * 参见 [API文档](./www/api/README.md)


* app Native调用api
    * 参见 [API文档](./www/api/README.md)

* [app 与Html5 互通协议 参见文档](./www/api/JSBridge.md)
    * miduoduo://jsbridge/

### 视图的控制

![alt tag](http://7xjyyt.com1.z0.glb.clouddn.com/米多多顶 app view Flowchart - New Page.png)



