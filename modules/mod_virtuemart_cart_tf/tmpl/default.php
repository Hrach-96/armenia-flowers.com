<?php // no direct access
defined('_JEXEC') or die('Restricted access');
// Ajax is displayed in vm_cart_products
// ALL THE DISPLAY IS Done by Ajax using "hiddencontainer" 

?>
<div class="mod-cart">
<!-- Virtuemart 2 Ajax Card -->
<div class="vmCartModule" id="vmCartModule">
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
    	<div class="total_products"><?php echo  $data->totalProductTxt ?></div>
		<div class="total_2">
			<?php echo  $data->billTotal; ?>
		</div>
	</div>
	<div id="hiddencontainer" style="display:none">
		<div class="container">
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
    <?php if ($show_product_list) { ?>
	<div id="cart_list">
    <i class="fa fa-caret-up"></i>
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
                    <div class="container">
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
        <div class="all">
         <div class="tot3">
          	 <?php if ($data->totalProduct) echo  $data->taxTotal; ?>
		</div>
         <div class="tot4">
         	 <?php if ($data->totalProduct) echo  $data->discTotal; ?>
		</div>
          <div class="total">
			<?php if ($data->totalProduct) echo  $data->billTotal; ?>
		</div>
		<div class="show_cart">
			<?php if ($data->totalProduct) echo  $data->cart_show; ?>
		</div>
        </div>
	</div>
    <?php } ?>
    <script type="text/javascript">
jQuery('.marg-bot.sp .fright .vmicon').live('click',function(){
		jQuery(this).parent().parent().find('.spinner').css({display:'block'});						  
	})

</script>
</div>
</div>