var mQuickCart = jQuery.noConflict();

mQuickCart(document).ready(function($){
        customScrollbar();
});

function customScrollbar(){
    if( jQuery("#vmCartModule").hasClass("vmCartModule")) {
        var module_height_top = mQuickCart('#vmCartModule #cart_list').outerHeight() ;
        var module_length = mQuickCart("#cart_list .vmcontainer").length;
        var module_height_all = mQuickCart('#vmCartModule .all').outerHeight();
        var module_height_text = mQuickCart('#vmCartModule .text-art').outerHeight();
        var module_height = parseInt(height_scrollbar) + parseInt(module_height_all) + parseInt(module_height_text);
        //alert(module_height_top);
        //alert(module_height_all);
        //alert(module_height);
        //alert(height_scrollbar);
        if( show_scrollbar ){
            if( module_height_top > module_height || module_length > 3){
                mQuickCart("#cart_list div.vm_cart_products").css('height',height_scrollbar+'px');
                mQuickCart("#cart_list div.vm_cart_products").mCustomScrollbar({
                    scrollButtons:{
                        enable:true
                    }
                });
            }else{
                mQuickCart("#cart_list div.vm_cart_products").css('height','auto');
            }
        }
    }
}
if (typeof Virtuemart === "undefined")
    Virtuemart = {};
delete Virtuemart['cartEffect'];
Virtuemart.cartEffect = function(form) {
    var dat = form.serialize();

    //jQuery.fancybox().showActivity();

    jQuery.ajax({
        type: "POST",
        cache: false,
        dataType: "json",
        timeout: "20000",
        url: Virtuemart.vmSiteurl + "index.php?option=com_virtuemart&nosef=1&view=cart&task=addJS&format=json"+Virtuemart.vmLang+window.Itemid,
        data: dat
    }).done(

    function(datas, textStatus) {

        if(datas.stat ==1){
            var txt = datas.msg;
        } else if(datas.stat ==2){
            var txt = datas.msg +"<H4>"+form.find(".pname").val()+"</H4>";
        } else {
            var txt = "<H4>"+vmCartError+"</H4>"+datas.msg;
        }
        if(usefancy){
            jQuery.fancybox({
                    "titlePosition" :   "inside",
                    "transitionIn"  :   "fade",
                    "transitionOut" :   "fade",
                    "changeFade"    :   "fast",
                    "type"          :   "html",
                    "autoCenter"    :   true,
                    "closeBtn"      :   true,
                    "closeClick"    :   true,
                    "content"       :   txt,
                    "wrapCSS"    : "fancybox-cart"
                }
            );
        } else {
            jQuery.facebox( txt , 'my-groovy-style');
        }

        jQuery('body').trigger('updateVirtueMartCartModule');
    });

}
jQuery(function($) {
    Virtuemart.customUpdateVirtueMartCartModule = function(el, options){
        var base    = this;
        var $this   = $(this);
        base.$el    = $(".vmCartModule_ajax");

        base.options    = $.extend({}, Virtuemart.customUpdateVirtueMartCartModule.defaults, options);
            
        base.init = function(){
            $.ajaxSetup({ cache: false })
            $.getJSON('?action=cart',
                function (datas, textStatus) {
                // if(datas.billTotal.match(/<strong>(.*)<\/strong>/)[1]) datas.billTotal = datas.billTotal.match(/<strong>(.*)<\/strong>/)[1];
                    $this.find(".vm_cart_products").html("");
                    //$this.find(".show_cart").html("");
                    //$this.find(".total").html("");
                    base.$el.each(function( index ,  module ) {
                        if (datas.totalProduct > 0) {
                            i = 0;
                            datas.products.reverse();
                            $this.find("#cart_list").removeClass('empty');
                            $this.find(".vm_cart_products").html("");
                            $.each(datas.products, function (key, val) {
                            if (key<12){ 
                                //jQuery("#hiddencontainer .vmcontainer").clone().appendTo(".vmcontainer .vm_cart_products");
                                $this.find(".hiddencontainer .vmcontainer").clone().appendTo( $this.find(".vm_cart_products") );
                                $this.find(".vmcontainer:last").find('.product_cart_id').addClass('product_remove_id'+key);
                                $this.find(".vmcontainer:last").find('.product_cart_id').html(key);
                             //$this.find(".product_row:last").find('.product_cart_id').addClass('product_remove_id'+key);
                                $.each(val, function (key, val) {
                                    $this.find(".vm_cart_products ." + key).last().html(val);
                                });
                            } 
                            });
                             $this.find(".text-art").html(datas.cart_recent_text);
                             //alert(datas.billTotals);
                            $this.find(".total").html(datas.billTotals);
                            $this.find(".tot3").html(datas.taxTotals);
                            $this.find(".tot4").html(datas.discTotals);
                            $this.find(".show_cart").html(datas.cart_shows);
                            $this.find("#cart_list .vmicon i").html(datas.cart_remove);
                            //$this.find(".all").addClass("block");
                            $this.find(".all").show();
                            $this.find(".all").removeClass("empty");
                            $this.find(".text-art").removeClass("empty");
                            $this.find("#vm_cart_products").addClass("block");
                            $this.find("#vm_cart_products").show();
                            $this.find("#vm_cart_products").removeClass("none");
                            $this.find(".total_products").find('.total_items').html(datas.totalProduct);
                            $this.find(".total_products .total").show();

                        }
                         else{
                            $this.find(".text-art").html(datas.cart_empty_text);
                            $this.find(".all").hide();
                            $this.find(".total_products .total").hide();
                            $this.find("#vm_cart_products").hide();
                            $this.find(".total_products").find('.total_items').html(datas.totalProduct);
                            $this.find("#cart_list").addClass('empty');
                            $this.find(".text-art").addClass("empty");
                            $this.find("#vmCartModule").removeClass("open");
                        }
                        customScrollbar();
                    });
                }
            );          
        };
        base.init();
    };
    // Definition Of Defaults
    Virtuemart.customUpdateVirtueMartCartModule.defaults = {
        name1: 'value1'
    };

});

jQuery(document).ready(function( $ ) {
    jQuery(document).off("updateVirtueMartCartModule","body",Virtuemart.customUpdateVirtueMartCartModule);
    jQuery(document).on("updateVirtueMartCartModule","body",Virtuemart.customUpdateVirtueMartCartModule);
});
