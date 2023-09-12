function tooltipstyle3(){
	jQuery('.product-box.style_3 .hasTooltips').tooltip();
}
function fancyboxthumb(){              
	jQuery(".layout .product-box.style_3").each(function(indx, element){
		var my_product_id = jQuery(this).find(".img-wrapper").attr('id');
		//alert(my_product_id);
		if(my_product_id){
			jQuery("#"+my_product_id+" .fancybox-thumb").fancybox({
			wrapCSS : 'prod-list',
			openEffect	: 'none',
			closeEffect	: 'none',
			helpers : {
				thumbs  : {
					width : 70,
					height  : 70
				}
			}
			});
		}
	});
}
 jQuery(document).ready(function($) {
  fancyboxthumb();
  tooltipstyle3();
  
  jQuery(".sp-vmsearch-categorybox").find('.chzn-container').remove();
  jQuery("#com-form-login").find('.default[type=submit]').addClass('button');
  jQuery("#com-form-login").find('.default[type=submit]').wrap( "<div class='com-form-login-btn'></div>" );
 });  
jQuery(document).ready(function(){
	//jQuery("#t3-mainnav .dropdown .nav-child .dropdown-submenu span.separator").append('<em class="caret"></em>');
	jQuery(".askquestion2, .ask-recomend").fancybox({
	    maxWidth  : 390,
	    maxHeight : 500,
	    fitToView : false,
	    width   : '70%',
	    height    : 500,
	    autoSize  : false,
	    closeClick  : false,
	    openEffect  : 'no',
	    title:false,
	    scrolling:'none',
	    iframe:{
	    	scrolling:'no'
	    },
	    closeEffect : 'none'
  	});
	if (notAnimate =='1'){		
		jQuery('.t3-footnavtop >div:nth-child(1), .list-banners >li:nth-child(1) , .list-banners >li:nth-child(3) , .custom_html .text1 , .custom_html .text2 , .custom_html .text3 , .custom_html .text4 , .bannet-top-fullwidth .row  >div:nth-child(1), .bannet-top-fullwidth  .row >div:nth-child(3), #t3footnav-top .row >div:nth-child(1) , #t3footnav-top .row >div:nth-child(3), #t3footnav .row >div:nth-child(1) , #t3footnav .row >div:nth-child(3) ,#Customblock2 .row >div:nth-child(1) , #Customblock2 .row >div:nth-child(3)').addClass('wow zoomIn');
		jQuery('.t3-footnavtop >div:nth-child(2) , .list-banners >li:nth-child(2),.bannet-top-fullwidth .row >div:nth-child(2),#t3footnav-top .row >div:nth-child(2) , #t3footnav-top .row >div:nth-child(4),#t3footnav .row >div:nth-child(2) , #t3footnav .row >div:nth-child(4) , #Customblock2 .row >div:nth-child(2) , #Customblock2 .row >div:nth-child(4)').addClass('wow zoomIn')
		jQuery('.module.brands, #Customblock-brand .t3-module, #CustomblockVideo , .module.homeblog , .Customblock .t3-customblock').addClass('wow zoomIn');
		jQuery('#slider .prod-row , .category-border , .prod_cat').addClass('wow zoomIn');
		
	}
		

		 jQuery('#facebox .continue , #facebox div.close , #fancybox-close , #fancybox-overlay , #fancybox-wrap .reset.button').live('click',function (e) {
			e.preventDefault();
			jQuery('#facebox , #fancybox-wrap').hide();
			jQuery('#facebox_overlay').remove();
			jQuery('#system_view_overlay, #fancybox-overlay').hide();
			return false;
		});	
		jQuery('#newsletter-popup div.close').live('click',function (e) {
			e.preventDefault();
			jQuery('div.fancybox-overlay').remove();
			jQuery("html").removeClass('fancybox-lock');
			jQuery("html").removeClass('fancybox-margin');
			return false;
		});
		jQuery('.cart-shipment input,.cart-payment input, .step-payment-shipment .vm-payment-plugin-single > input , .step-payment-shipment .vm-shipment-plugin-single > input').styler().trigger('refresh');	
	    jQuery('.social .hasTooltip').tooltip();

		jQuery('li:last-child').addClass('lastItem');
		jQuery('li:first-child').addClass('firstItem');
		jQuery('.prod-row:last-child').addClass('lastItem');
		jQuery('.prod-row:first-child').addClass('firstItem'); 
		jQuery('.itemList > div:last-child').addClass('lastItem');
		jQuery('.itemList > div:first-child').addClass('firstItem'); 
		
		if (notstickynavigation =='1'){

		jQuery(document).ready(function() {
			if (jQuery('.t3-megamenu ul').length > 0) {
				var stickMenu = true;
				var docWidth= jQuery('body').find('#t3-menu-box').width();

				//if (stickMenu && docWidth > 780) {
					jQuery('body').find('#t3-menu-box').wrapInner('<div class="stickUp">');
					jQuery('.stickUp').addClass('animated');
					jQuery('.stickUp').StickUp();
				//} 
			}
		});
		}	
		jQuery('.sp-vmsearch-categories').styler().trigger('refresh');
		jQuery(document).ready(function() {
		var o = jQuery('input[type=checkbox]');
	    if (o.length && !jQuery('body').hasClass('.com_config')) {
	        o.each(function (i) {
	            if (jQuery(this).parent().not('span.checkbox')) {
	                if (!jQuery(this).attr("id")) {
	                   jQuery(this).attr({id: 'checkbox' + i}).wrap('<span class="checkbox"/>').after('<label class="checkbox_inner" for="checkbox' + i + '" />')
	                } else {
	                    jQuery(this).wrap('<span class="checkbox"/>').after('<label class="checkbox_inner" for="' + jQuery(this).attr("id") + '" />')
	                }
	            }
	        })
	    }
	    radioBox();	  
	     });
 		function radioBox() { 
			 var o = jQuery('.sppb-addon-form-builder input[type=radio], #searchForm .radio-inline input[type=radio], .output-shipto input[type=radio] , .product-fields input[type=radio] , .opg-list input[type=radio]');
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
 		}
			jQuery(document).ready(function($){
			$('.topbanner .close-banner').click(function(){
	      		$('.topbanner').addClass('close')
	    	});
	      	$(document).on('click touchmove',function(e) {
	          var container = $(".topbanner");
	          if (!container.is(e.target)
	              && container.has(e.target).length === 0 && container.hasClass('close'))
	          	{
	              $('.topbanner').addClass('close')
	      		}
	      	});
	
			$('#cur-lang.header-button-currency .heading').click(function(){
	      		$('#cur-lang.header-button-currency').toggleClass('open')
	    	});
	      	$(document).on('click touchmove',function(e) {
	          var container = $("#cur-lang.header-button-currency");
	          if (!container.is(e.target)
	              && container.has(e.target).length === 0 && container.hasClass('open'))
	          	{
	              $('#cur-lang.header-button-currency').toggleClass('open')
	      		}
	      	});

	      	$('#cur-lang.header-button-languages .heading').click(function(){
	      		$('#cur-lang.header-button-languages').toggleClass('open')
	    	});
	      	$(document).on('click touchmove',function(e) {
	          var container = $("#cur-lang.header-button-languages");
	          if (!container.is(e.target)
	              && container.has(e.target).length === 0 && container.hasClass('open'))
	          	{
	              $('#cur-lang.header-button-languages').toggleClass('open')
	      		}
	      	});
		});
	jQuery(document).ready(function () {
	 jQuery('.btn-icon').toggle(
        function() {
            jQuery('.poping_links').addClass('opens');
        },
        function() {
            jQuery('.poping_links').removeClass('opens');
        }
    );

		jQuery('.orderlistcontainer .orderlist').each(function(){
	 	jQuery(this).parent().find('.activeOrder').addClass('block');            
	})

});

	// hide #back-top first
	jQuery("#back-top").hide();
	
	// fade in #back-top
	jQuery(function () {
		jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() > 550) {
				jQuery('#back-top').fadeIn();
			} else {
				jQuery('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		jQuery('#back-top a').click(function () {
			jQuery('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

}); 

  jQuery(document).ready(function(){
  	checkPosition();
	jQuery('.sropen').on('click', function(){
		jQuery("#t3-mainnav").addClass('srcbg');
		jQuery("#t3-mainnav").removeClass('srend');
	});	
	jQuery('.srclose').on('click', function(){
		jQuery("#t3-mainnav").removeClass('srcbg');
		jQuery("#t3-mainnav").addClass('srend');
		jQuery("#t3-mainnav .res_a_s.shop").css('display', 'none'); 
	});	
	 jQuery(document).on('click touchmove',function(e) {
	          var container = jQuery("#t3-mainnav");
	          if (!container.is(e.target)
	              && container.has(e.target).length === 0 && container.hasClass('srcbg'))
	          	{
	              jQuery('#t3-mainnav').removeClass('srcbg');
	      		}
	      	});
	 jQuery('body').append('<div id="system_view_overlay" style="display:none"></div><div class="AjaxPreloaderC" style="display:none"></div><div id="system_view"></div>');
		if( jQuery("#mod_compare .vmproduct .clearfix").hasClass("modcompareprod")) {
          jQuery("#mod_compare .not_text").addClass('displayNone');
    	 }
		 if( jQuery("#mod_compare .vmproduct .clearfix").hasClass("modcompareprod")) {
			 jQuery("#mod_compare #butseldcomp").removeClass('displayNone');
		 }else { jQuery("#mod_compare #butseldcomp").addClass('displayNone');}
		 
		 if( jQuery("#mod_wishlists .vmproduct .clearfix").hasClass("modwishlistsprod")) {
          jQuery("#mod_wishlists .not_text").addClass('displayNone');
    	 }
		 if( jQuery("#mod_wishlists .vmproduct .clearfix").hasClass("modwishlistsprod")) {
			 jQuery("#mod_wishlists #butseldwish").removeClass('displayNone');
		 }else { jQuery("#mod_wishlists #butseldwish").addClass('displayNone');}
	});

 function centerBox() {
      var boxWidth = 430;
    var winWidth = jQuery(window).width();
    var winHeight = jQuery(document).height();
    var scrollPos = jQuery(window).scrollTop();
     
     
    var disWidth = (winWidth - boxWidth) / 2
    var disHeight = scrollPos + 250;
     
    jQuery('#system_view').css({'width' : boxWidth+'px', 'left' : disWidth+'px', 'top' : disHeight+'px'});
     
    return false;       
} 
//jQuery(window).resize(centerBox);
//jQuery(window).scroll(centerBox);
//centerBox();  


  function addToCompare(product_id) { 
  jQuery('#system_view_overlay').show();
	  jQuery('.AjaxPreloaderC').show();
	jQuery.ajax({
		url: '?option=com_comparelist&task=add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json){
			 jQuery('.AjaxPreloaderC').hide();
			  // jQuery('#system_view_overlay').hide();
			if(json){
				jQuery('#system_view').show().html('<div class="success"><div class="wrapper successprod_'+product_id+'"><div class="success_compare_img">' + json.img_prod2 + '</div><div class="success_compare_left">' + json.title + json.btnrem + '</div></div><div class="success_compare">' + json.message + '</div><div class="wrapper2">'+ json.btncompareback + json.btncompare +'</div></div><div class="system_view_close"><i class="fa fa-times"></i></div>');
				jQuery('.success').fadeIn('slow');
				//jQuery('html, body').animate({ scrollTop: 0 }, 'slow'); 
				}
				jQuery('.list_compare'+product_id+' a').addClass('go_to_compare active');
				if(json.totalcompare>4){
					jQuery('.list_compare'+product_id+' a').removeClass('go_to_compare active');
				}
				
				 if(json.totalcompare>0){
					 jQuery("#mod_compare #butseldcomp").removeClass('displayNone');
				}
				if(json.totalcompare){
					jQuery('#compare_total .compare_total span').html(json.totalcompare);
				}
				if(json.prod_name){
					jQuery('#mod_compare .vmproduct').append('<div id="compare_prod_'+product_id+'" class="modcompareprod clearfix">'+json.img_prod+json.prod_name+'</div>');
				}
				if( jQuery("#mod_compare .vmproduct .clearfix").hasClass("modcompareprod")) {
         			 jQuery("#mod_compare .not_text").addClass('displayNone');
    			 }

				 jQuery('#system_view_overlay, .system_view_close , #compare_continue').click(function () {
					jQuery('#system_view').hide();
					jQuery('#system_view_overlay').hide();
					//jQuery('.AjaxPreloader').hide();
                 });
			//alert(json.message);
				
			}
			
	});
}

 function removeCompare(remove_id) { 
	jQuery('#compare_cat'+remove_id+' a').removeClass('go_to_compare active');
	jQuery.ajax({
		url: '?option=com_comparelist&task=removed',
		type: 'post',
		data: 'remove_id=' + remove_id,
		dataType: 'json',
		success: function(json){
					 jQuery('.compare_prod_'+remove_id).remove();
					  jQuery('#compare_prod_'+remove_id).remove();
					  jQuery('.success .successprod_'+remove_id).remove();
					   jQuery('.success_compare span').remove();
					   jQuery('#system_view .success .success_compare').append('<span class="warning">'+json.rem+'</span>');
					 	jQuery('.list_compare'+remove_id+' a').removeClass('go_to_compare active');
					 if(json.totalrem<1){
						jQuery("#mod_compare .not_text").removeClass('displayNone');
						jQuery("#butseldcomp").addClass('displayNone');
						jQuery(".module-title.compare.no-products").addClass('displayBlock');
						jQuery(".browscompare_list").remove();
						
					}
					if(json.totalrem){
						jQuery('#compare_total .compare_total span').html(json.totalrem);
				}
				if(json.totalrem <1){
						jQuery('#compare_total .compare_total span').html('0');
				}
			}
	});
}


  function addToWishlists(product_id) { 
  jQuery('#system_view_overlay').show();
	  jQuery('.AjaxPreloaderC').show();
	jQuery.ajax({
		url: '?option=com_wishlists&task=add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json){
			
			 jQuery('.AjaxPreloaderC').hide();
			  // jQuery('#system_view_overlay').hide();
			  jQuery('.list_wishlists'+product_id+' a').addClass('go_to_compare active');
			if(json){
				jQuery('#system_view').show().html('<div class="success"><div class="wrapper successprod_'+product_id+'"><div class="success_wishlists_img">' + json.img_prod2 + '</div><div class="success_wishlists_left">' + json.title + json.btnrem + '</div></div><div class="success_wishlists">' + json.message + '</div><div class="wrapper2">'+ json.btnwishlistsback + json.btnwishlists +'</div></div><div class="system_view_close"><i class="fa fa-times"></i></div>');
				jQuery('.success').fadeIn('slow');
				//jQuery('html, body').animate({ scrollTop: 0 }, 'slow'); 
					
				}
			
				 
				 if(json.totalwishlists>0){
					 jQuery("#mod_wishlists #butseldwish").removeClass('displayNone');
				}
				if(json.totalwishlists){
					jQuery('#wishlist_total .wishlist_total span').html(json.totalwishlists);
				}
				if(json.prod_name){
					jQuery('#mod_wishlists .vmproduct').append('<div id="wishlists_prod_'+product_id+'" class="modwishlistsprod clearfix">'+json.img_prod+json.prod_name+'</div>');
				}
				if( jQuery("#mod_wishlists .vmproduct .clearfix").hasClass("modwishlistsprod")) {
         			 jQuery("#mod_wishlists .not_text").addClass('displayNone');
    				 }
				 jQuery('#system_view_overlay, .system_view_close , #wishlists_continue').click(function () {
					jQuery('#system_view').hide();
					jQuery('#system_view_overlay').hide();
					//jQuery('.AjaxPreloader').hide();
                 });
			//alert(json.message);
			}
	});
}

 function removeWishlists(remove_id) { 
	jQuery.ajax({
		url: '?option=com_wishlists&task=removed',
		type: 'post',
		data: 'remove_id=' + remove_id,
		dataType: 'json',
		success: function(json){
						jQuery('.wishlists_prods_'+remove_id).remove();	
					   jQuery('.count_holder_small').remove();
					   jQuery('#wishlists_prod_'+remove_id).remove();
					   //jQuery('.wishlists_prods_'+remove_id).remove();					  
					  jQuery('.success .successprod_'+remove_id).remove();
					   jQuery('.success_wishlists span').remove();
					   jQuery('#system_view .success .success_wishlists').append('<span class="warning">'+json.rem+'</span>');
					 	jQuery('.list_wishlists'+remove_id+' a').removeClass('go_to_compare active');
					 if(json.totalrem<1){
						jQuery("#mod_wishlists .not_text").removeClass('displayNone');
						jQuery("#butseldwish").addClass('displayNone');
						jQuery(".module-title.wishlists.no-products").addClass('displayBlock');
						jQuery(".category-wishlist").remove();
						
					}
					if(json.totalrem){
					jQuery('#wishlist_total .wishlist_total span').html(json.totalrem);
				}
				if(json.totalrem<1){
					jQuery('#wishlist_total .wishlist_total span').html('0');
				}
			}
	});
}
if (preloader == '1'){
	window.addEventListener('DOMContentLoaded', function() {
	    "use strict";
	    var ql = new QueryLoader2(document.querySelector("body"), {
	        barColor: "#efefef",
	        backgroundColor: preloaderbg,
	        percentage: true,
	        barHeight: 1,
	        minimumTime: 200,
	        fadeOutTime: 1000
	    });
	});
}
jQuery(document).load(jQuery(window).bind("resize", checkPosition));

function checkPosition()
{
    if(jQuery(window).width() < 1200)
    {
        jQuery('#vmCartModule .miniart').click(function(){
      		jQuery('#vmCartModule').toggleClass('open')
    	});
      	jQuery(document).on('click touchmove',function(e) {
          var container = jQuery("#vmCartModule");
          if (!container.is(e.target)
              && container.has(e.target).length === 0 && container.hasClass('open'))
          	{
              jQuery('#vmCartModule').toggleClass('open')
      		}
      	});
    } else {
    	jQuery('#vmCartModule').hover(
    		function() {
			    jQuery(this).addClass('open');
		    }, function() {
		    	jQuery(this).removeClass('open');
		    }
    	);
    }
}