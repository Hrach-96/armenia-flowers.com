jQuery(function(){
	jQuery('.productdetails-view .image_loader').addClass('loader');
	jQuery(window).load(function() {
		jQuery('.productdetails-view .image_loader').removeClass('loader'); // remove the loader when window gets loaded.
		jQuery('.productdetails-view .image_show').animate({opacity:1},1000);
	});
});
jQuery(document).ready(function() {
	Zoom();
});
jQuery(window).resize(function() {
	Zoom();
});
