define(function(require,exports){require("zepto-ext");var api=require("../widget/api"),url=(require("../widget/util"),require("../widget/url-handle")),duang=require("../widget/duang"),jobID=url.getParams(window.location.search)["job-gid"];$(".btn-submit").on("click",function(){$.post(api.gen("complaint"),{task_id:jobID,content:$(".content").val(),phonenum:$(".tel").val()},function(data){var msg="";422==arguments[2].status?(data.forEach(function(e){msg+=e.message+"</br>"}),duang.toast(msg)):(msg="提交成功！",duang.toast(msg,function(){miduoduo.os.app?window.MDDNative.pop():window.location.replace(document.referrer)}))})})});