$('.names').on('click', function(){
    $.get('/resume/read', {aid : $(this).attr('aid')})
    .done(function(data){
        // location.reload();
    });
});

$('.jishou').on('click', function(){
    $('#current-aid').val( $(this).attr('aid') );
    $('#current-taskid').val( $(this).attr('taskid') );
    $('#tongzhi-1').addClass('is-visible');
});

$('.need-notice').on('click', function(){
    $.get('/resume/notice-info',{taskid:$("#current-taskid").val()})
    .done(function(data){
        var notice_info = eval('('+data+')');
        $('#meet_time').val( notice_info.meet_time );
        $('#place').val( notice_info.place );
        $('#linkman').val( notice_info.linkman );
        $('#phone').val( notice_info.phone );
        $('#task_id').val( notice_info.task_id );
        $('#task-title').html( notice_info.task_title );
        if( notice_info.type == 2 ){
            $('#type2').attr('checked','checked');
        }else{
            $('#type1').attr('checked','checked');
        }
        /* 插件不好用，稍后更改
        $('#meet_time').daterangepicker({
            "singleDatePicker": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerIncrement": 30,
            "opens": "left",
            "timePickerIncrement": 1,
            "drops": "down",
            "buttonClasses": "btn btn-sm",
            "applyClass": "btn-success",
            "cancelClass": "btn-default",
        }, function(start, end, label) {
            $('#meet_time').val(start.format('YYYY-MM-DD HH:mm'));
        });*/
       
    });

    $('#tongzhi-1').removeClass('is-visible');
    $('#tongzhi-2').addClass('is-visible');
});

$('.unneed-notice').on('click', function(){
    $.get('/resume/pass', {aid : $("#current-aid").val()})
    .done(function(data){
        location.reload();
    });
    $('#tongzhi-1').removeClass('is-visible');
});

$('.jujue').on('click', function(){
    $.get('/resume/reject', {aid : $(this).attr('aid')})
    .done(function(data){
        location.reload();
    });
});

$('.fabu-bt').on('click',function(){
    if( $('#meet_time').val() == '' || $('#place').val() == '' || $('#linkman').val() == '' || $('#phone').val() == '' ){
        $('.notice_error_msg').html('请将内容填写完整');
        return false;
    }
});

jQuery(document).ready(function($){
	//open popup
	$('.cd-popup-trigger').on('click', function(event){
		event.preventDefault();
		$('.cd-popup').addClass('is-visible');
	});
	
	//close popup
	$('.cd-popup').on('click', function(event){
		if( $(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup') ) {
			event.preventDefault();
			$(this).removeClass('is-visible');
		}
	});
	//close popup when clicking the esc keyboard button
	$(document).keyup(function(event){
    	if(event.which=='27'){
    		$('.cd-popup').removeClass('is-visible');
	    }
    });
});
