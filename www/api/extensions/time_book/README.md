考勤api文档
-------------------

考勤的身份验证
======================
同api身份验证
如第三方使用，将需要使用米多多OAuth2.0 登陆方式登陆方可（第三方登陆暂未开通）


考勤api
======================
Baseurl = //api.miduoduo.cn/time-book/

### 获得用户日程
```
    GET /time-book/schedule?date=2015-08-09
    RETURN :
    {
      "items": [
        {
          "id": 24,
          "user_id": "5",
          "task_id": "472",
          "from_datetime": "2015-09-09 07:00:00",
          "to_datetime": "2015-09-09 10:00:00",
          "allowable_distance_offset": 500,
          "date": "2015-09-09",
          "owner_id": "5",
          "on_late": 0,
          "off_early": 0,
          "out_work": 0,
          "note": null,
          "lng": 116.411065,
          "lat": 39.996498,
          "address": "北京 朝阳 加利大厦 ",
          "task_title": " 米多多"
        }
      ],
      "_links": {
        "self": {
          "href": "http://api.liyw.chongdd.cn/time-book/schedule?date=2015-09-09&page=1"
        }
      },
      "_meta": {
        "totalCount": 1,
        "pageCount": 1,
        "currentPage": 1,
        "perPage": 20
      }
    }
```

### 获得用户日程-新接口
```
    GET /time-book/schedule-new?[date=2015-08-09]&access-token=null
    RETURN :
    {
      "success": true,
      "message": "获取成功！",
      "result": [
        {
          "id": 535,
          "user_id": "2006",
          "task_id": "553",
          "from_datetime": "2015-10-12 06:00:00",
          "to_datetime": "2015-10-12 10:00:00",
          "allowable_distance_offset": 500,
          "date": "2015-10-12",
          "owner_id": "2006",
          "on_late": 0,
          "off_early": 0,
          "out_work": 0,
          "note": null,
          "lng": 116.639083,
          "lat": 40.321198,
          "address": "北京 怀柔 京北大世界 ",
          "task_title": "测试多打卡任务-001",
          "out_work_on": 0,
          "out_work_off": 0,
          "event_type": 1,【1为上班，2为下班】
          "time": "2015-10-12 06:00:00",【需要打卡的时间】
          "has_done": 0,【0为待打卡，1为已打卡，-1为未打卡】
          "msg": "待打卡"
        },
        {
          "id": 535,
          "user_id": "2006",
          "task_id": "553",
          "from_datetime": "2015-10-12 06:00:00",
          "to_datetime": "2015-10-12 10:00:00",
          "allowable_distance_offset": 500,
          "date": "2015-10-12",
          "owner_id": "2006",
          "on_late": 0,
          "off_early": 0,
          "out_work": 0,
          "note": null,
          "lng": 116.639083,
          "lat": 40.321198,
          "address": "北京 怀柔 京北大世界 ",
          "task_title": "测试多打卡任务-001",
          "out_work_on": 0,
          "out_work_off": 0,
          "event_type": 2,
          "time": "2015-10-12 10:00:00",
          "has_done": 0,
          "msg": "待打卡"
        },
      ]
    }
```

### 全部打卡记录
```
    GET /time-book/schedule-all?access_token=null
    RETURN :
    {
      "success": true,
      "message": "获取成功！",
      "result": [
        {
          "id": 332,
          "user_id": "2006",
          "task_id": "477",
          "from_datetime": "2015-09-17 17:03:40",
          "to_datetime": "2015-09-09 18:00:00",
          "allowable_distance_offset": 500,
          "date": "2015-09-17",
          "owner_id": "2006",
          "on_late": 0,
          "off_early": 0,
          "out_work": 0,
          "note": null,
          "lng": 116.421508,
          "lat": 39.997099,
          "address": "北京 加利大厦 ",
          "task_title": "2015-08-27-003",
          "out_work_on": 0,
          "out_work_off": 0,
          "count": "22",【总打卡次数】
          "past_count": "22",
          "on_late_count": "1",【迟到次数】
          "off_early_count": "1",【早退次数】
          "out_work_count": "0",【矿工次数】
          "noted_count": "0",
          "is_today_on": "0"
        },
        {
          "id": 356,
          "user_id": "2006",
          "task_id": "481",
          "from_datetime": "2015-09-17 17:03:40",
          "to_datetime": "2015-09-09 23:00:00",
          "allowable_distance_offset": 500,
          "date": "2015-09-17",
          "owner_id": "6951",
          "on_late": 0,
          "off_early": 0,
          "out_work": 0,
          "note": null,
          "lng": 116.452129,
          "lat": 39.981931,
          "address": "北京 东城 北京当代MOMA ",
          "task_title": "etest",
          "out_work_on": 0,
          "out_work_off": 0,
          "count": "14",
          "past_count": "14",
          "on_late_count": "3",
          "off_early_count": "0",
          "out_work_count": "0",
          "noted_count": "0",
          "is_today_on": "0"
        }
      ]
    }
```

### 任务打卡明细
    GET /time-book/schedule?filters=[["=","task_id", "477"]]&access_token=NULL
    return
    ```
    {
      "items": [
        {
          "id": 474,
          "user_id": "2006",
          "task_id": "477",
          "from_datetime": "2015-09-17 17:03:44",
          "to_datetime": "2015-09-30 17:00:00",
          "allowable_distance_offset": 500,
          "date": "2015-09-17",
          "owner_id": "2006",
          "on_late": 0,
          "off_early": 0,
          "out_work": 0,
          "note": null,
          "lng": 116.421508,
          "lat": 39.997099,
          "address": "北京 加利大厦 ",
          "task_title": "2015-08-27-003",
          "out_work_on": 0,
          "out_work_off": 0
        },
        {
          "id": 471,
          "user_id": "2006",
          "task_id": "477",
          "from_datetime": "2015-09-17 17:03:43",
          "to_datetime": "2015-09-29 17:00:00",
          "allowable_distance_offset": 500,
          "date": "2015-09-17",
          "owner_id": "2006",
          "on_late": 0,
          "off_early": 0,
          "out_work": 0,
          "note": null,
          "lng": 116.421508,
          "lat": 39.997099,
          "address": "北京 加利大厦 ",
          "task_title": "2015-08-27-003",
          "out_work_on": 0,
          "out_work_off": 0
        },
    }
    ```

### 考勤打卡
    POST /time-book/record
    params: 
        lat=
        lng=
        schedule_id=
        action=on/off
    return 
    {
        "lat": "39.9829512",
        "lng": "116.452629",
        "schedule_id": "508",
        "user_id": "2006",
        "owner_id": "6951",
        "event_type": 1,
        "id": 147
    }
    OR
    http 400 错误
```

### 考勤打卡 新接口
    POST /time-book/record-new
    params: 
        lat=
        lng=
        schedule_id=
        device_id=
    return 
    {
      "success": true,
      "message": "打卡成功！",
      "result": {
        "lat": "39.934603",
        "lng": "116.214768",
        "schedule_id": "526",
        "device_id": "223344xpxp0",
        "user_id": "2006",
        "owner_id": "6951",
        "event_type": 10,
        "device_date": "2015-09-22",
        "id": 171
      }
    }
    OR
    {
      "success": false,
      "message": ""
    }
```
