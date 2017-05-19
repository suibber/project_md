jQuery(document).ready(function($){
	//open popup
	$('.fenxiang-btn').on('click', function(event){
		event.preventDefault();
		$('.cd-popup').addClass('is-visible');
	});
	
	//close popup
	$('.fenxiang-btn').on('click', function(event){
		if( $(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup') ) {
			event.preventDefault();
			$(this).removeClass('is-visible');
		}
	});
	//close popup when clicking the esc keyboard button
	$('.cd-popup').on('click', function(event){
    	$('.cd-popup').removeClass('is-visible');
    });
});