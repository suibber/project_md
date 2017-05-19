$(function() {
      $(".tagBox-add-tag").hide();
});

$('form').on('submit', function(){
    $('.cuowu').hide();
    var form = document.forms[0];
    form.detail.value = $("#editor").html();
    var su = form.salary_unit.value;
    if(su.indexOf('/') >= 0) su = su.substring(2);
    form.salary_unit.value = su;
    if (form.is_longterm.checked) {
        form.is_longterm.value = 1;
    }else {
        form.is_longterm.value = 0;
    }
    if (form.is_allday.checked) {
        form.is_allday.value = 1;
    }else {
        form.is_allday.value = 0;
    }
    var address = '';
    $('#selected-address .p-box').each(function(){
        var addr = $(this).attr('id');
        if(address.length > 0) address = address + ' ';
        address = address + addr;
    });
    form.address_list.value = address;

    var valid = true;
    if (form.title.value.length == 0) {
        $('.title-error').html('请输入兼职标题');
        $('.title-error').show();
        valid = false;
    }
    if (form.service_type_id.value.length == 0) {
        $('.service_type_id-error').html('请选择兼职类别');
        $('.service_type_id-error').show();
        valid = false;
    }

function getNowFormatDate() {
    var date = new Date();
    var seperator1 = "-";
    var seperator2 = ":";
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    var currentdate = year + seperator1 + month + seperator1 + strDate;
    return currentdate;
}

    var today = getNowFormatDate();
    if( form.to_date.value < today ){
        $('.to_time-error').html('您的工作日期需要修改，截止日期应在今天之后');
        $('.to_time-error').show();
        valid = false;
    }
    if ( form.is_allday.checked ==false && (form.from_time.value.length == 0 || form.to_time.value.length == 0)){
        $('.to_time-error').html('请选择上班时间和下班时间');
        $('.to_time-error').show();
        valid = false;
    }
    if (form.address_list.value.length == 0) {
        $('.address_error').html('请输入工作地点');
        $('.address_error').show();
        valid = false;
    }
    if (form.need_quantity.value.length == 0) {
        $('.need_quantity-error').html('请输入人数');
        $('.need_quantity-error').show();
        valid = false;
    }else {
        var value = form.need_quantity.value;
        if (value != value.replace(/[^0-9\.]/g, '')) {
            $('.need_quantity-error').html('人数请输入数字');
            $('.need_quantity-error').show();
            valid = false;
        }
    }
    if (form.salary.value.length == 0) {
        $('.salary-error').html('请输入薪酬');
        $('.salary-error').show();
        valid = false;
    }else {
        var value = form.salary.value;
        if (value != value.replace(/[^0-9\.]/g, '')) {
            $('.salary-error').html('薪酬请输入数字');
            $('.salary-error').show();
            valid = false;
        }
    }
    if (form.salary_unit.value.length == 0) {
        $('.salary-error').html('请选择金额单位');
        $('.salary-error').show();
        valid = false;
    }
    if (form.clearance_period.value.length == 0) {
        $('.salary-error').html('请选择结算方式');
        $('.salary-error').show();
        valid = false;
    }
    if (!form.phone_contact.checked && !form.sms_contact.checked) {
        $('.enroll-error').html('请至少选择一种报名方式');
        $('.enroll-error').show();
        valid = false;
    }
    if (form.phone_contact.checked) {
        if (form.contact.value.length == 0) {
            $('.enroll-error').html('请输入联系人');
            $('.enroll-error').show();
            valid = false;
        }else if(form.contact_phonenum.value.length == 0){
            $('.enroll-error').html('请输入联系电话');
            $('.enroll-error').show();
            valid = false;
        }
    }
    if (form.sms_contact.checked) {
        if (form.sms_phonenum.value.length == 0) {
            $('.enroll-error').html('请输入报名短信');
            $('.enroll-error').show();
            valid = false;
        }else{
            var value = form.sms_phonenum.value;
            if(!value.match(/^1[3|4|5|8][0-9]\d{4,8}$/)){
                $('.enroll-error').html("请输入正确的手机号");
                $('.enroll-error').show();
                valid = false;
            }
        }
    }
    if (!form.protocol.checked) {
        $('.protocol-error').html('请确认米多多发布兼职协议');
        $('.protocol-error').show();
        valid = false;
    }
    if(valid === false){
        $('html,body').scrollTop(0);
    }

    return valid;

});

$('#address_count').change(function(){
    var value = $(this).val();
    if (value == '一个') {
        $(".tagBox-add-tag").hide();
        $("#jquery-tagbox-text1-input").attr('placeholder', '请输入工作地址');
        $(".tagBox-input").show();
    }else if (value == '不限') {
        $(".tagBox-add-tag").hide();
        $("#jquery-tagbox-text1").hide();
    }else{
        $(".tagBox-add-tag").hide();
        $("#jquery-tagbox-text1").attr('placeholder', '请输入工作地址,多个地址用逗号分隔');
        $("#jquery-tagbox-text1").show();
    }
});

$(function(){
    var pois={};
    var current_poi = false;
    var added_pois = new Array();
    function remove_address(id){
        $.ajax({
            url: '/task/delete-address?id=' + id,
            method: 'get',
        }).done(function(dstr){
            var data = $.parseJSON(dstr);
            console.log(data);
        })
    }
    window.remove_address = remove_address;
    function pick_poi(poi){
        var address = {
            'lat': poi.point.lat,
            'lng': poi.point.lng,
            'address': poi.address,
            'city': poi.city,
            'province': poi.province,
            'title': poi.title
        };
        $.post('/task/add-address', {
            lat: poi.point.lat,
            lng: poi.point.lng,
            address: poi.address,
            city: poi.city,
            province: poi.province,
            title: poi.title
        }, function(str){
            var data = JSON.parse(str);
            if(data.success === true){
                var content = '<div class="p-box" id="' + data.result.id + '"><span>&times;</span><div class="dz-v">' + current_poi.title +'</div></div>';
                $('#selected-address').html($('#selected-address').html() + content);
                added_pois.push(current_poi);
                current_poi = false;
                $('#jquery-tagbox-text1').val('');
                $('#selected-address div.p-box span').click(function(){
                    var aid = $(this).parent().attr('id');
                    remove_address(aid);
                    var index = $(this).parent().index();
                    $(this).parent().remove();
                });
            }
        });
    }
    window.pick_poi = pick_poi;
    var map = new BMap.Map("map");
    var sr = $("#search-result");
    var kwipt = $("#keyword");
    map.centerAndZoom(new BMap.Point(116.422820,39.996632), 11);
    var options = {
     onSearchComplete: function(results){
       if (local.getStatus() == BMAP_STATUS_SUCCESS){
         // 判断状态是否正确
         var s = [];
         pois = {};
         var lis = '';
         for (var i = 0; i < results.getCurrentNumPois(); i ++){
            var poi = results.getPoi(i);
            pois[i] = poi;
            lis += '<li idx="' + i + '"><h2>' + poi.title + '</h2><p>' + poi.address +'</p></li>';
         }
         sr.html(lis);
         sr.find('li').each(function(){
            $(this).click(function(){
                var title = $(this).find('h2').html();
                $('#jquery-tagbox-text1').val(title+' ');
                $('#jquery-tagbox-text1').focus();
                sr.hide();
                var index = $(this).attr('idx');
                current_poi = pois[index];
            });
         })
         

            var qu_id  = $("#address_qu").val();
            if( qu_id == -1 ){
                // 不限工作地点（区县）
                var index = $(this).attr('idx');
                current_poi = pois[0];

                var sheng       = '';
                var sheng_show  = '';
                var shi     = '北京';
                if( $("#address_sheng").val() > 0 ){
                    sheng      = $("#address_sheng").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
                    sheng_show = sheng;
                    if( sheng == '北京 ' || sheng == '天津 ' || sheng == '上海 ' || sheng == '重庆 ' ){
                        sheng_show = '';
                    }
                }
                if( $("#address_shi").val() > 0 ){
                    shi  = $("#address_shi").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
                }
                var address_info = sheng_show+shi;
                if(address_info.length == 0) return;
                current_poi.city = shi;
                current_poi.province = sheng;
                current_poi.title = address_info;
                pick_poi(current_poi);
            }else{
                sr.show();
            }

       }
     }
    };

    $('.tianj').click(function(){
        var sheng   = '';
        var sheng_show = '';
        var shi     = '北京';
        var qu      = '';
        if( $("#address_sheng").val() > 0 ){
            sheng     = $("#address_sheng").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
            sheng_show= sheng;
            if( sheng == '北京 ' || sheng == '天津 ' || sheng == '上海 ' || sheng == '重庆 ' ){
                sheng_show = '';
            }
        }
        if( $("#address_shi").val() > 0 ){
            shi  = $("#address_shi").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
        }
        if( $("#address_qu").val() > 0 ){
            qu   = $("#address_qu").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
        }
        var address_info = sheng_show+shi+qu;

        if($('#jquery-tagbox-text1').val().length == 0) return;
        if(current_poi === false){
            current_poi = {};
            current_poi.address = '';
            current_poi.city = shi;
            current_poi.province = '';
            current_poi.point = {lat:0, lng:0};
        }
        current_poi.city = shi;
        current_poi.province = sheng;
        current_poi.title = address_info+$('#jquery-tagbox-text1').val();
        if( current_poi.title.length > 0 ){
            pick_poi(current_poi);
        }
    });

    $("body").on("click", function(){
        $("#search-result").hide();
    });
    var local = new BMap.LocalSearch(map, options);
    $('#jquery-tagbox-text1').keyup(function(e){
        var sheng   = '';
        var shi     = '';
        var qu      = '';
        if( $("#address_sheng").val() > 0 ){
            sheng= $("#address_sheng").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
        }
        if( $("#address_shi").val() > 0 ){
            shi  = $("#address_shi").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
        }
        if( $("#address_qu").val() > 0 ){
            qu   = $("#address_qu").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
        }
        var address_info = sheng+shi+qu;
        var keywordlen = $(this).val().length;
        //var code = (e.keyCode ? e.keyCode : e.which);
        //if( code == 13 ) {
        var has_space   = $(this).val().search(' ');
        if( keywordlen >= 2 && has_space < 0 ) {
            local.search(address_info+$(this).val());
            sr.html();
            return false;
        }
    });

    $('#selected-address div.p-box span').click(function(){
        var aid = $(this).parent().attr('id');
        remove_address(aid);
        var index = $(this).parent().index();
        $(this).parent().remove();
    });

    // 选择省份
    $('#address_sheng').on('change',function(){
        $('#jquery-tagbox-text1').removeAttr('readonly');
        $("#address_qu").html('<option value="0">区/县</option><option value="-1">不限工作地点</option>');

        var parent_id  = $(this).val();
        $.ajax({ url: $("#api_url").text()+'/v1/district?filters=[["=","parent_id",'+parent_id+']]', context: document.body, success: function(data){
            var option_obj  = data;
            var option_str  = '';
            for( var i=0;i < option_obj.items.length;i++){
                var shi_selected = '';
                if( parent_id == 20 || parent_id == 2 || parent_id == 795 || parent_id == 2259 ){
                    shi_selected = 'selected="selected"';
                }
                changeShi(option_obj.items[i].id);
                option_str  += '<option '+shi_selected+' value="'+option_obj.items[i].id+'">'+option_obj.items[i].short_name+'</option>';
            }
            option_str  += '';
            $("#address_shi").html(option_str);
        }});
    });
    // 选择市
    $('#address_shi').on('change',function(){
        changeShi(0);
    });
    function changeShi(parent_id){
        $('#jquery-tagbox-text1').removeAttr('readonly');
        $("#address_qu").html('<option value="0">区/县</option');

        var parent_id  = parent_id ? parent_id : $('#address_shi').val();
        if( parent_id == 0 ){
            return false;
        }
        $.ajax({ url: $("#api_url").text()+'/v1/district?filters=[["=","parent_id",'+parent_id+']]', context: document.body, success: function(data){
            var option_obj  = data;
            var option_str  = '<option value="0">区/县</option><option value="-1">不限工作地点</option>';
            for( var i=0;i < option_obj.items.length;i++){
                option_str  += '<option value="'+option_obj.items[i].id+'">'+option_obj.items[i].short_name+'</option>';
            }
            option_str  += '';
            $("#address_qu").html(option_str);
        }});
    }
    // 不限工作地点（区县）
    $('#address_qu').on('change',function(){
        var parent_id  = $(this).val();
        if( parent_id == -1 ){
            $('#jquery-tagbox-text1').attr('readonly','readonly');
            var sheng   = '';
            var shi     = '';
            if( $("#address_sheng").val() > 0 ){
                sheng= $("#address_sheng").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
            }
            if( $("#address_shi").val() > 0 ){
                shi  = $("#address_shi").find("option:selected").text().replace(/(^\s*)|(\s*$)/g, "")+' ';
            }
            var address_info = sheng+shi;
            local.search(address_info);
            sr.html();
            
            return false;
        }else{
            $('#jquery-tagbox-text1').removeAttr('readonly');
        }
    });
});
