<?php

if(isset($sale_text)){
	if($sale_text)echo "<p class='bzSaleTimerPretext'>{$sale_text}</p>";
}
?>
<?php if ($product->prices['override'] == 1 && ($product->prices['product_price_publish_down'] > 0)){?>
<div  class="bzSaleTimer item<?php echo $product_id;?>M format<?php echo ucfirst($timer_format); ?> <?php echo $modulesuffix; ?>">
		<?php
		 $data = $product->prices['product_price_publish_down'];
		$data = explode(' ', $data);
		$time = explode(':', $data[1]);
		$data = explode('-', $data[0]);
		//var_dump($data);
		 $year = $data[0];
		 $month = $data[1];
		 $data = $data[2];
		//var_dump($time);
			?>
			<div class="count_holder">
			 <div class="count_info"><?php echo JText::_('DR_LIMITED2')?></div>
			<div id="CountSmallMod<?php echo $product->virtuemart_product_id ?>" class="count_border">
			 <script type="text/javascript">
			jQuery(function () {    
				jQuery('#slider2 #CountSmallMod<?php echo $product->virtuemart_product_id ?>').countdowns({
				until: new Date(<?php echo $year; ?>, <?php echo $month; ?> - 1, <?php echo $data; ?>),
				labels: ['Years', 'Months', 'Weeks', '<?php echo JText::_('DR_DAYS')?>', '<?php echo JText::_('DR_HOURS')?>', '<?php echo JText::_('DR_MINUTES')?>', '<?php echo JText::_('DR_SECONDS')?>'],
				labels1:['Years','Months','Weeks','<?php echo JText::_('DR_DAYS')?>','<?php echo JText::_('DR_HOURS')?>','<?php echo JText::_('DR_MINUTES')?>','<?php echo JText::_('DR_SECONDS')?>'],
				compact: false});
			});
			 </script>
			 </div>
			 </div>
          </div>   
		  <?php } ?>
