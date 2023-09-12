(function($) {
	$(document).ready(function(){
		$("#gallery_02 .thumb").bind("click", function(e) {  
			var dsrc =  $(this).attr('data-src-index');
			 $('.main-image').find('#image2').attr('data-src-index', dsrc);
		  return false;
		});
	   $('.image-gallery').lightGallery();
	   $('.zoomWindow').live('click',function(){ $('.main-image-left .image-gallery a.swipebox').eq( $('#image2').attr('data-src-index')||0).click();return false;});
	   $('#image2').parent().click(function(){ $('.main-image-left .image-gallery a.swipebox').eq( $('#image2').attr('data-src-index')||0).click();return false;});
	});
})(jQuery);