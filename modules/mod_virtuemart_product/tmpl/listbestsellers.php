<?php // no direct access
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
$col= 1 ;
$pwidth= ' width'.floor ( 100 / $products_per_row );
if ($products_per_row > 1) { $float= "floatleft";}
else {$float="center";}
?>
<?php if ($show_tolltips) { ?>
<script type="text/javascript">
this.bestshotPreview = function(){	
	/* CONFIG */
		
		xOffset = <?php echo $xOffset ?>;
		yOffset = <?php echo $yOffset ?>;
		
		// these 2 variable determine popup's distance from the cursor
		// you might want to adjust to get the right result
		
	/* END CONFIG */
	jQuery("#vmproduct.vmproduct_best li a.bestshot").hover(function(e){

		this.t = this.title;
		this.title = "";	
		var c = (this.t != "") ? "<br/>" + this.t : "";
		jQuery("body").append("<p id='bestshot'><span></span><img src='"+ this.rel +"' alt='url preview' />"+ c +"</p>");								 
		jQuery("#bestshot")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("fast");						
    },
	function(){
		this.title = this.t;	
		jQuery("#bestshot").remove();
    });	
	jQuery("#vmproduct.vmproduct_best li a.bestshot").mousemove(function(e){
		jQuery("#bestshot")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});			
};

jQuery(document).ready(function(){
	bestshotPreview(
	);
});
</script>
<?php } ?>
<div class="vmgroup<?php echo $params->get( 'moduleclass_sfx' ) ?>">

<?php if ($headerText) { ?>
	<div class="vmheader"><?php echo $headerText ?></div>
<?php } ?>    
<?php 
$last = count($products)-1;
?>
<ul id="vmproduct" class="vmproduct<?php echo $params->get('moduleclass_sfx'); ?> listbest">
<?php  $count=1; ?>
 <li class="item">
  <?php foreach ($products as $product) :
  	$discont = $product->prices[discountAmount];
	$discont = substr($discont , 1);
  ?>
  <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/> 

 <div class="product-box spacer">
 
 <?php if ($show_img) { ?>
    <div class="browseImage">
	 <div class="new"></div>
			<?php
			if (!empty($product->images[0]) )
					$image = $product->images[0]->displayMediaThumb('class="browseProductImage featuredProductImage" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ;
				else $image = '';
					echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id),$image,'class="img2"');
			?>
		</div>
		<?php } ?>
		<?php  if ($show_category) { ?>
			 <div class="Categories">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$product->virtuemart_category_id), shopFunctionsF::limitStringByWord($product->category_name,'40','...'), array('title' => $product->category_name)); ?>
                    </div>
			<?php } ?>	
			
		<div class="fleft">
        <?php  if ($show_title) { ?>
		<div class="Title">
			<?php 
			$besturl = 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id;
			$bestimg = JURI::base(true).'/'.$product->images[0]->file_url_thumb;
              	echo  '<a class="bestshot"  href="'.$besturl.'" rel="'.$bestimg.'"><span class="count">'.$count++.'.</span>'.shopFunctionsF::limitStringByWord($product->product_name,'35','...').'</a>';  
				?>                       
		</div>
	<?php } ?>	
		<?php if ($show_ratings) { ?>
			 <?php
			  $showRating = $ratingModel->showRating($product->virtuemart_product_id);
			if ($showRating=='true'){
			$rating = $ratingModel->getRatingByProduct($product->virtuemart_product_id);
            if( !empty($rating)) {
				$r = $rating->rating;
			} else {
				$r = 0;
			}
			$maxrating = VmConfig::get('vm_maximum_rating_scale',5);
													$ratingwidth = ( $r * 100 ) / $maxrating;//I don't use round as percetntage with works perfect, as for me
										?>
                                        	
													<span class="vote">
														<span title="" class="vmicon ratingbox" style="display:inline-block;">
															<span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
															</span>
														</span>
													</span>
		<?php } } ?>								
	
	<?php if ($show_desc) { ?>
				<div class="description">
					<?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, $row, '...') ?>
				</div>
			<?php } ?>	
          
		<?php if ($show_price) { ?>	
        	<?php if ((!empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>

			<div class="Price">
			
			<?php
				
				$sale = $currency->createPriceDiv('priceWithoutTax','',$product->prices,true);
				$discount = $currency->createPriceDiv('discountAmount','',$product->prices,true);
			//print_r($product);
								if ($product->prices['basePriceWithTax']>0 && $discont >0) 
						echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePriceWithTax','',$product->prices,true) . '</span>';

					if ($product->prices['salesPrice']>0 )
						echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$product->prices,true) . '</span>';
					?>
					<?php /*?><?php 
					if ((round((substr($discount,1)/substr($sale,1)),2)*100)>0) { ?>
					<span><?php  echo round((substr($discount,1)/substr($sale,1)),2)*100;?>% off</span>
					<?php } ?><?php */?>
						
			</div>
			<?php } else {
									if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call modal"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } } ?>
            <?php } ?>
			<div class="wrapper">  
		
			<?php if ($show_addtocart) echo mod_virtuemart_product::addtocart($product);?>
			<?php if ($show_det) { ?>
			<div class="Details">
			<?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id), JText::_('ART_DETAILS')); ?><?php ?>
			</div>
			<?php } ?>
			</div>
    </div>
	</div>
		<?php
            if ($col == $products_per_row && $products_per_row && $last) {
                echo "</li><li class='items'>";
                $col= 1 ;
            } else {
                $col++;
            }
			$last--;
            endforeach; ?>
	</li>
</ul>

<?php 
$last = count($products)-1;
?>

<?php 
	if ($footerText) : ?>
	<div class="vmfooter <?php echo $params->get( 'moduleclass_sfx' ) ?>">
		 <?php echo $footerText ?>
	</div>
<?php endif; ?>
</div>