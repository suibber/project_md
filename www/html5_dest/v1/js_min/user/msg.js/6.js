define(function(require,exports){require("zepto-ext");var util=require("../widget/util"),api=require("../widget/api");$(".js-btn").on("click",function(){$(".job-tips").hide(),util.href("view/user/msg-detail.html?msg-type="+$(this).data("type"))}),$.pageInitGet(api.gen('message?filters=[["=", "read_flag", 0]]&per-page=1'),function(data){data._meta.totalCount>0&&$(".job-tips").css("display","inline-block")})});