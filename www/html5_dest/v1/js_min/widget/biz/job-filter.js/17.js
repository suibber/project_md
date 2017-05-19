define(function(require,exports){function district($this){$this.toggleClass("filter-btn-act").siblings().removeClass("filter-btn-act");var $obj=$(".district-list");$obj.siblings(".js-top-filter-btn").hide(),filterToggle($obj)}function jobType($this){$(".shade-biz").show(),$this.toggleClass("filter-btn-act").siblings().removeClass("filter-btn-act");var $obj=$(".job-type-list-container");$obj.siblings(".js-top-filter-btn").hide(),filterToggle($obj)}function jobSort($this){$this.toggleClass("filter-btn-act").siblings().removeClass("filter-btn-act");var $obj=$(".sort-list");$obj.siblings(".js-top-filter-btn").hide(),filterToggle($obj)}function buildJobList(act,_url,_apiParam){function handleFiltersObj(obj){var tempArr=[];for(var i in obj)"service-type"==i&&url.indexOf("/nearby")>-1?obj[i][1]="task.service_type_id":obj[i][1]="service_type_id",tempArr.push(obj[i]);return JSON.stringify(tempArr)}$(".no-data").text("没有数据"),$(".no-data").hide(),"distance"!=act&&$(".user-location").hide(),$jobsContainer.empty(),_url&&(url=_url);var apiParam;_apiParam?apiParam=_apiParam:(apiParam={page:1,expand:expandStr,filters:handleFiltersObj(filtersObj),orders:JSON.stringify(ordersObj)},apiParam=$.extend(apiParam,filterParam)),urlParam.frame&&(apiParam["per-page"]=urlParam.frame*perPage,delete urlParam.frame),url.indexOf("/nearby")>-1&&(apiParam=$.extend(apiParam,userLocation)),searchStateForBack.url=url,searchStateForBack.urlParam=apiParam,miduoduo.os.wx&&(localStorage[window.location.pathname]=JSON.stringify(searchStateForBack)),sLoad.startWatch(api.gen(url),apiParam,function(data){apiParam["per-page"]!=perPage&&(apiParam.page=apiParam["per-page"]/perPage+1,apiParam["per-page"]=perPage),$jobsContainer.append(tpl.parse("job-list-tpl",{jobs:data.items})),setTimeout(function(){urlParam.pos&&(window.scrollTo(0,urlParam.pos),delete urlParam.pos),0==$jobsContainer.find("a").length&&(url.indexOf("/nearby")>-1&&($(".no-data").html("据你20km内没有其他兼职职位！<span style='color:#00b966' class='find-by-city'>查看全城 ></span>"),$(".user-location").fadeIn()),$(".no-data").fadeIn())},200)})}function filterToggle($obj){"none"==$obj.css("display")?($obj.show(),$shadeBiz.show(),$(window).on("touchmove",function(e){e.preventDefault()})):($obj.hide(),$shadeBiz.hide(),$(window).off("touchmove"))}function getUserLocation(isBuildJob,showTag){navigator.geolocation.getCurrentPosition(function(p){var longitude=p.coords.longitude,latitude=p.coords.latitude;util.coordTran({lng:longitude,lat:latitude},function(data){userLocation=data;var point=new BMap.Point(data.lng,data.lat),gc=new BMap.Geocoder;gc.getLocation(point,function(res){userLocationAddress=res.address,$(".user-location").text(userLocationAddress),showTag&&$(".user-location").show(),isBuildJob&&(url="task-address/nearby",ordersObj.length=0,$(".user-location").show(),buildJobList("distance"))})})},function(e){e.code+"\n"+e.message;1==e.code&&duang.toast("禁用定位将不能查看附近的职位")})}require("zepto-ext");var sLoad=require("../scroll-load"),api=require("../api"),tpl=require("../tpl-engine"),util=require("../util"),duang=require("../duang"),urlHandle=require("../url-handle"),urlParam=urlHandle.getParams(window.location.search),perPage=50,searchStateForBack={"js-job-type-tf":null,"js-mix-tf":null,"js-work-time-tf":null,jobTypeItem:{ids:[],"class":"job-type-list-item-act"},url:"",urlParam:""},$shadeBiz=$(".shade-biz"),filtersObj={},expandStr="",ordersObj=[],filterParam={},userLocation={},userLocationAddress="",$jobsContainer=$(".jobs-container"),url="task";if($.pageInitGet(api.gen("service-type"),function(data){if(data&&data.items.length>0){if($(".job-filter-list").append(tpl.parse("job-type-list-tpl",{list:data.items})),urlParam.type&&!urlParam.restoreFilter){var title=$("#type-"+urlParam.type).text();$(".js-job-type-btn").text(title)}searchStateForBack.jobTypeItem.ids.forEach(function(e){$("#type-"+e).addClass(searchStateForBack.jobTypeItem["class"])})}},"json"),$(".job-filter-list").append(tpl.parse("district-list-tpl")),urlParam.district&&$(".js-district-btn").text($("#district-"+urlParam.district).text()),$(".job-filter-list").append(tpl.parse("sort-list-tpl",null)),$(".js-district-btn").on("click",function(){district($(this))}),$(".js-job-type-btn").on("click",function(){jobType($(this))}),$(".js-sort-btn").on("click",function(){jobSort($(this))}),$("body").on("click",".district-list li",function(){$(".job-filter>a").removeClass("filter-btn-act"),$(this).parent().hide();var title=$(this).text().substring(0,4);$(".js-mix-tf").text(title),searchStateForBack["js-mix-tf"]=title;var act;switch($(this).data("sort")){case"default":url="task",ordersObj.length=0;break;case"distance":url="task-address/nearby",ordersObj.length=0,act="distance",$(".user-location").show();break;case"time":url="task",expandStr=expandStr.replace("task,","").concat("task,"),ordersObj.push("task.from_date")}buildJobList(act),$shadeBiz.hide(),$(window).off("touchmove")}).on("click",".job-type-list li",function(){$(this).toggleClass("job-type-list-item-act")}).on("click",".job-type-list-col-sure",function(){$(".job-filter>a").removeClass("filter-btn-act"),$(this).parent().parent().hide(),expandStr=expandStr.replace("service-type,","").concat("service-type,");var $items=$(".job-type-list-item-act"),typeIds=[],typeNames=[];$items.each(function(){typeIds.push($(this).data("uid")),typeNames.push($(this).text())});var title=typeNames.join(",").substring(0,4)||"兼职类型";$(".js-job-type-tf").text(title),searchStateForBack["js-job-type-tf"]=title,searchStateForBack.jobTypeItem.ids=typeIds,filtersObj["service-type"]=["in","service_type_id",typeIds],buildJobList(),$shadeBiz.hide(),$(window).off("touchmove")}).on("click",".job-type-list-col-cancel",function(){$(".job-type-list li").removeClass("job-type-list-item-act");var title="兼职类型";$(".js-job-type-tf").text(title),searchStateForBack["js-job-type-tf"]=title,searchStateForBack.jobTypeItem.ids=[],$(".job-filter>a").removeClass("filter-btn-act"),$(this).parent().parent().hide(),delete filtersObj["service-type"],buildJobList(),$shadeBiz.hide(),$(window).off("touchmove")}).on("click",".sort-list li",function(){$(".job-filter>a").removeClass("filter-btn-act");var title=$(this).text().substring(0,4);switch($(".js-work-time-tf").text(title),searchStateForBack["js-work-time-tf"]=title,$(this).parent().hide(),$(this).data("sort")){case"all":delete filterParam.date_range;break;case"weekend":filterParam.date_range="weekend_only";break;case"week":filterParam.date_range="current_week"}buildJobList(),$shadeBiz.hide(),$(window).off("touchmove")}),$(".user-location").on("click",function(){getUserLocation(!0)}),$("body").on("click",".find-by-city",function(){url="task",ordersObj.length=0,expandStr="",filtersObj={},filterParam={},$(".js-district-btn").text("综合排序"),$(".js-job-type-btn").text("兼职类型"),$(".js-sort-btn").text("全部"),$(".job-type-list li").removeClass("job-type-list-item-act"),buildJobList()}),$(".shade-biz").on("click",function(){$(".job-filter-list").children().hide(),$(this).hide(),$(window).off("touchmove")}),miduoduo.os.wx)var restoreFilter=localStorage[window.location.pathname];if(miduoduo.os.wx&&"restoreFilter"==history.state&&restoreFilter){var restoreFilter=JSON.parse(restoreFilter);searchStateForBack=restoreFilter,restoreFilter["js-job-type-tf"]&&$(".js-job-type-tf").text(restoreFilter["js-job-type-tf"]),restoreFilter["js-mix-tf"]&&$(".js-mix-tf").text(restoreFilter["js-mix-tf"]),restoreFilter["js-work-time-tf"]&&$(".js-work-time-tf").text(restoreFilter["js-work-time-tf"]);var act=null;restoreFilter.url.indexOf("/nearby")>-1?(act="distance",getUserLocation(null,!0)):getUserLocation(),buildJobList(act,restoreFilter.url,restoreFilter.urlParam)}else{if(urlParam.type){filtersObj["service-type"]=["=","service_type_id",urlParam.type],expandStr+="service-type,";var title;switch(urlParam.type){case 12:title="促销";break;case 5:title="临时工";break;case 1:title="传单"}searchStateForBack["js-job-type-tf"]=title,searchStateForBack.jobTypeItem.ids.push(urlParam.type)}if(urlParam.nearby){var title="按距离由近到远".substring(0,4);$(".js-district-btn").text(title),searchStateForBack["js-mix-tf"]=title,getUserLocation(!0)}else getUserLocation(),buildJobList()}miduoduo.os.wx&&$(".jobs-container").on("click","a",function(e){history.replaceState("restoreFilter","页面内容",util.addUrlParam(window.location.href.replace(/[&]?restoreFilter=1.*$/,""),"restoreFilter=1&pos="+document.body.scrollTop+"&frame="+Math.ceil(($(this).index()+1)/perPage)))}),exports.district=district,exports.jobType=jobType,exports.jobSort=jobSort,exports.getUserLocation=getUserLocation,exports.buildJobList=buildJobList,exports.filtersObj=filtersObj,exports.expandStr=expandStr});