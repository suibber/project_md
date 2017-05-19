//点击显示以藏
$(function(){
   $(".add-xs").click(function(){ $(".add-ons").toggle(); 
   });
});
//下拉筛选
$(function xiala(){
$('[name="nice-select"]').click(function(e){
	$('[name="nice-select"]').find('ul').hide();
	$(this).find('ul').show();
	e.stopPropagation();
});
$('[name="nice-select"] li').hover(function(e){
	$(this).toggleClass('on');
	e.stopPropagation();
});
$('[name="nice-select"] li').click(function(e){
	var val = $(this).text();
	var dataVal = $(this).attr("data-value");
	$(this).parents('[name="nice-select"]').find('input').val(val);
	$('[name="nice-select"] ul').hide();
	e.stopPropagation();
	//alert("中文值是："+val);
	//alert("数字值是："+dataVal);
	//alert($(this).parents('[name="nice-select"]').find('input').val());
});
$(document).click(function(){
	$('[name="nice-select"] ul').hide();
});
})


//日期选择
 $(document).ready(function() {
      $('.reservation').daterangepicker(null, function(start, end, label) {
                    console.log(start.toISOString(), end.toISOString(), label);
          });            
 });
  $(document).ready(function() {
                  $('#birthday').daterangepicker({ singleDatePicker: true }, function(start, end, label) {
                    console.log(start.toISOString(), end.toISOString(), label);
                  });
               });



//富文本编辑器
  $(function(){
    function initToolbarBootstrapBindings() {
     /* var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
      $.each(fonts, function (idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
      });
      $('a[title]').tooltip({container:'body'});
    	$('.dropdown-menu input').click(function() {return false;})
		    .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
        .keydown('esc', function () {this.value='';$(this).change();});

      $('[data-role=magic-overlay]').each(function () { 
        var overlay = $(this), target = $(overlay.data('target')); 
        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
      });
      if ("onwebkitspeechchange"  in document.createElement("input")) {
        var editorOffset = $('#editor').offset();
        $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
      } else {
        $('#voiceBtn').hide();
      }*/
	};
	function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	};
    initToolbarBootstrapBindings(); 
	$('#editor').wysiwyg({ fileUploadError: showErrorAlert} );
  });
  
  
  
  jQuery(function() {
      jQuery("#jquery-tagbox-text").tagBox();
      jQuery("#jquery-tagbox-select").tagBox({ 
        enableDropdown: true, 
        dropdownSource: function() {
          return jQuery("#jquery-tagbox-select-options");
        }
      });
    });
  
  


	