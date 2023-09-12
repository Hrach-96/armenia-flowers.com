
jQuery(function($) {
if($("html").hasClass("com_virtuemart")){
    // Add to cart and other scripts may check this variable and return while
    // the content is being updated.
    Virtuemart.isUpdatingContent = false;
	Virtuemart.recalculate = false;
	Virtuemart.recalculate = false;
	Virtuemart.setBrowserState = true;

    Virtuemart.updateContent = function(url, callback) {

        if(Virtuemart.isUpdatingContent) return false;
        Virtuemart.isUpdatingContent = true;
        urlSuf='tmpl=component&format=html&dynamic=1';
        var glue = '&';
        if(url.indexOf('&') == -1 && url.indexOf('?') == -1){
			glue = '?';
        }
        url += glue+urlSuf;

        $.ajax({
            url: url,
            dataType: 'html',
            success: function(data) {
               var title = $(data).filter('title').text();
				$('title').text(title);
				var el = $(data).find(Virtuemart.containerSelector);
				if (! el.length) el = $(data).filter(Virtuemart.containerSelector);
				if (el.length) {
					Virtuemart.container.html(el.html());
					Virtuemart.updateCartListener();
					Virtuemart.updateDynamicUpdateListeners();

					if (Virtuemart.updateImageEventListeners) Virtuemart.updateImageEventListeners();
					if (Virtuemart.updateChosenDropdownLayout) Virtuemart.updateChosenDropdownLayout();
					//Virtuemart.product($("form.product"));

					if(Virtuemart.recalculate) {
						$("form.js-recalculate").each(function(){
							if ($(this).find(".product-fields").length && !$(this).find(".no-vm-bind").length) {
								var id= $(this).find('input[name="virtuemart_product_id[]"]').val();
								Virtuemart.setproducttype($(this),id);
							}
						});
					}

				}
				Virtuemart.isUpdatingContent = false;
				 // $('.product-custom select').styler().trigger('refresh');
				  $(function(){
				  $('.productdetails-view #accordion2').show().animate({opacity:1},800);
				  $('.productdetails-view .image_show').animate({opacity:1},1000);
				  $('.productdetails-view .example2').removeClass('loader'); // remove the loader when window gets loaded.
					$('.tabs_show').show().animate({opacity:1},1000);
					if( jQuery(".main-image").hasClass("horizont")) {	
					  Zoom();
					}
					 var o = jQuery('.output-shipto input[type=radio] , .product-fields input[type=radio]');
				     if (o.length && !jQuery('body').hasClass('.com_config')) {
				        o.each(function () {
				            if (jQuery(this).parent().not('span.radio')) {
				                if (!jQuery(this).attr("id")) {
				                    jQuery(this).attr({id: 'radio' + i}).wrap('<span class="radio"/>').after('<label class="radio_inner" for="radio' + i + '" />')
				                } else {
				                    jQuery(this).wrap('<span class="radio"/>').after('<label class="radio_inner" for="' + jQuery(this).attr("id") + '" />')
				                }
				            }
				        });
				    }	
				  	if($('.list_carousel').hasClass('responsive') || $('#sliderrecent').hasClass('recentproducts')){
					$('.list_carousel').removeClass('loader');
			 		$('.product-related #slider').show();
						sliderInit6();
					}

				  //check_reviewform();
				   if($('#reviewform').length){
					refresh_counter();
					}	
				   if($('.quick_btn').length){
					quick_ap();
					}
				   if($('#jc').length){
					JCommentsInitializeForm();
				}	
		
				  $('a.ask-a-question, a.printModal, a.recommened-to-friend, a.manuModal').click(function(event){
				  event.preventDefault();
				  $.facebox({
					iframe: $(this).attr('href'),
					rev: 'iframe|550|550'
					});
				  });
				});
			  $('.list_carousel').removeClass('loader');
			  $('.product-related #slider').show();
			  //$('.productdetails-view.layout2 .hasTooltip').tooltip();
			  $('.productdetails-view.layout2 .product-box2 .hasTooltip').tooltip();
			  //shortcodes
				var tabs = $('ul.nav-tabs');
				tabs.each(function(i) {
				var tab = $(this).find('> li > a');
				tab.click(function(e) {
				var contentLocation = $(this).attr('href');
				if(contentLocation.charAt(0)=="#") {
				e.preventDefault();
				tab.removeClass('active');
				$(this).addClass('active');
				$(contentLocation).show().addClass('active').siblings().hide().removeClass('active');
				}
				});
				});
				//end shortcodes
				if($('#reviewform').length){
					$(function() {
						var steps = 5;
						var parentPos= $('.write-reviews .ratingbox').position();
						var boxWidth = $('.write-reviews .ratingbox').width();// nbr of total pixels
						var starSize = (boxWidth/steps);
						var ratingboxPos= $('.write-reviews .ratingbox').offset();
						var ratingbox=$('.write-reviews .ratingbox')
							$('.write-reviews .ratingbox').mousemove( function(e){
								var span = $(this).children();
								var dif = Math.floor(e.pageX-ratingbox.offset().left); 
								difRatio = Math.floor(dif/boxWidth* steps )+1; //step
								span.width(difRatio*starSize);
								$('#vote').val(difRatio);
								//console.log('note = ', difRatio);
								
							});
							$('.write-reviews .ratingbox').click(function(){
						    $('.button_vote').click();});
					});
				}
			 
				SqueezeBox.initialize({});
				if($('.example2').length){
					Tabsresp();
				}
				if (callback && typeof(callback) === "function") {
					callback();
				}
            }
        });
        Virtuemart.isUpdatingContent = false;
    }
}
});


