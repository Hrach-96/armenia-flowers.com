<?php // no direct access

defined('_JEXEC') or die('Restricted access');

$app    = JFactory::getApplication(); 
$template = $app->getTemplate();
$option = $app->input->getCmd('option', '');
$view = $app->input->getCmd('view', '');

 ?>
<!-- Virtuemart 2 Ajax Card -->
<div class="mod-cart">
<div class="vmCartModule_ajax vmCartModule" id="vmCartModule">
	<?php echo '<style>
			#cart_list {
				width:'.$widthdropdown.'px!important;
			}
			
			 #vm_cart_products img {
				width:'.$width.'px!important;
				height:'.$height.'px!important;
			}
	</style>';
 ?>
<div class="miniart">
    	<div class="total_products">
    		<span class="cart_num"><?php echo vmText::sprintf('ART_CART_MOD', $data->totalProduct); ?></span>
    	</div>
	</div>
	<div class="hiddencontainer" style=" display: none; ">
		<div class="vmcontainer container">
			<div class="wrapper marg-bot sp">
				<div class="spinner"></div>
			<!-- Image line -->
				<div class="image">
				</div>
				<div class="fleft">
					<div class="product_row">
						<span class="product_name"></span><div class="clear"></div>
						<div class="product_attributes"></div>
                    </div>
				</div>
                <div class="fright">
                	<div class="wrap-cart">
                   <span class="quantity"></span><div class="prices" style="display:inline;"></div>
                   	</div>
                    <a class="vmicon vmicon vm2-remove_from_cart" onclick="remove_product_cart(this);"><i></i><span class="product_cart_id"></span></a>
                </div>
			</div>
		</div>
	</div>
	<div id="cart_list"<?php if(!count($data->products)) echo ' class="empty"'; ?>>
		<div class="text-art">
			<?php 
				$data->cart_empty_text  = JText::_('ART_VIRTUEMART_CART_EMPTY');
				$data->cart_recent_text  = JText::_('ART_VIRTUEMART_CART_ADD_RECENTLY');
				if (empty($data->products)) {
					echo $data->cart_empty_text;
				} else {
					echo $data->cart_recent_text;
				}
				
			?>
		</div> 
		<div class="vm_cart_products" id="vm_cart_products">
        
				<?php
				$i = 0;
				$data->products = array_reverse($data->products);
				foreach($data->products as $product) {
					if ( $i++ == $limitcount ) break;
					?>
                    <div class="container vmcontainer">
						<div class="wrapper marg-bot sp">
					<div class="spinner"></div>
					<!-- Image line -->
					<div class="image">
					<?php echo $product["image"]; ?>
                    </div>
                    <div class="fleft">
                        <div class="product_row">
                            <span class="product_name"><?php echo $product["product_name"]; ?></span><div class="clear"></div>
                         <?php
                        if(!empty($product["product_attributes"])) {
                            ?>
                            <div class="product_attributes"><?php echo $product["product_attributes"]; ?></div>
                            <?php
                        }
                        ?>
                        
                        </div>
                    </div>
                    <div class="fright">
                    	<div class="wrap-cart">
                    	<span class="quantity"><?php echo $product["quantity"]; ?></span><div class="prices" style="display:inline;"><?php echo $product["prices"]; ?></div>
                        </div>
                            <a class="vmicon vmicon vm2-remove_from_cart" onclick="remove_product_cart(this);">
                            <i><?php 
							$data->cart_remove  = JText::_('ART_VIRTUEMART_CART_REMOVE');
							echo $data->cart_remove;
				
			?></i>
                            <span class="product_cart_id"><?php echo $product["product_cart_id"]; ?></span></a>
                  		  </div>
						</div>
					</div>
                    
					<?php
				}
				?>
				
		</div>
		<div class="all<?php if(!count($data->products)) echo ' empty'; ?>">
	         <div class="tot3">
	          	 <?php if ($data->totalProduct) echo  $data->taxTotals; ?>
			</div>
	         <div class="tot4">
	         	 <?php if ($data->totalProduct) echo  $data->discTotals; ?>
			</div>
	          <div class="total">
				<?php if ($data->totalProduct) echo  $data->billTotals; ?>
			</div>
			<div class="show_cart">
				<?php if ($data->totalProduct) echo  $data->cart_shows; ?>
			</div>
	    </div>
		<noscript>
		<?php echo vmText::_('MOD_VIRTUEMART_CART_AJAX_CART_PLZ_JAVASCRIPT') ?>
		</noscript>
	</div>
</div></div>
<script>
	jQuery(function(){
		jQuery('.marg-bot.sp .fright .vmicon').live('click',function(){
			jQuery(this).parent().parent().find('.spinner').css({display:'block'});						  
		});
	});
function remove_product_cart(elm) {
	var cart_id = jQuery(elm).children("span.product_cart_id").text();
	jQuery.ajax({
		url: 'index.php?option=com_virtuemart&view=cart&task=delete&removeProductCart=cart_virtuemart_product_id='+cart_id,
		type: 'post',
		data: 'cart_virtuemart_product_id='+cart_id,
		dataType: 'html',
		beforeSend: function(){
                //jQuery('.product_remove_id'+cart_id).closest('.vmcontainer').addClass('removing');
                jQuery('#vmCartModule').addClass('open');
            },
		success: function(html){
			<?php if (($view == 'cart') && ($option == 'com_virtuemart')){?>
				location.reload();
			<?php } ?>

			jQuery('body').trigger('updateVirtueMartCartModule');
			customScrollbar();
		}
}); 
}


</script>
