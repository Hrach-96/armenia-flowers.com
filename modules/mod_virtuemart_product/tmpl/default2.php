<?php // no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.modal');
$col= 1 ;
$pwidth= ' width'.floor ( 100 / $products_per_row );
if ($products_per_row > 1) { $float= "floatleft";}
else {$float="center";}
?>
<div class="vmgroup<?php echo $params->get( 'moduleclass_sfx' ) ?>">
<?php if ($headerText) { ?>
	<div class="vmheader"><?php echo $headerText ?></div>
<?php }
if ($display_style =="div") {

?>

<?php 
$last = count($products)-1;
?>

<div class="prod_box">
<ul id="box<?php echo $params->get( 'class_sfx' ) ?>" class="vmproduct layout2">
 <li>
  <?php foreach ($products as $product) :
   $discont = $product->prices[discountAmount];
  $discont = abs($discont);
  foreach ($product->categoryItem as $key=>$prod_cat) {
		$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
	}
  ?>
    <div class="prod-row">
        <?php if ($product->prices['override'] == 1 && ($product->prices['product_price_publish_down'] > 0)){
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
				<div class="count_holder_small">
				<div class="count_info"><?php echo JText::_('DR_LIMITED2')?></div>
				<div id="CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_feat' ); ?>" class="count_border">
				 <script type="text/javascript">
				jQuery(function () {    
					jQuery('#CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_feat' ); ?>').countdown({
						until: new Date(<?php echo $year; ?>, <?php echo $month; ?> - 1, <?php echo $data; ?>), 
						labels: ['Years', 'Months', 'Weeks', '<?php echo JText::_('DR_DAYS')?>', '<?php echo JText::_('DR_HOURS')?>', '<?php echo JText::_('DR_MINUTES')?>', '<?php echo JText::_('DR_SECONDS')?>'],
						labels1:['Years','Months','Weeks','<?php echo JText::_('DR_DAYS')?>','<?php echo JText::_('DR_HOURS')?>','<?php echo JText::_('DR_MINUTES')?>','<?php echo JText::_('DR_SECONDS')?>'],
						compact: false});
				});
				 </script>
				 </div>
                 <div class="bzSaleTimerDesc"><?php echo JText::_('DR_HURRY'); ?><div>&nbsp;<strong><?php echo $product->product_in_stock ?></strong>&nbsp;<?php echo JText::_('DR_HURRY_ITEMS'); ?></div></div>
				 </div>
			  <?php } ?>
     <div class="product-box hover back_w spacer <?php if ($discont>0) { echo 'disc';} ?> ">
              <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/> 

 <?php if ($show_img) { ?>
    <div class="browseImage ">
    <div class="lbl-box2">
    <?php
	$stockhandle = VmConfig::get ('stockhandle', 'none');
	if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($product->product_in_stock - $product->product_ordered) < 1) || 
			(($product->product_in_stock - $product->product_ordered) < $product->min_order_level ))  { ?>
    	<div class="soldafter"></div>
        <div class="soldbefore"></div>
        <div class="sold"><?php echo JText::_('DR_SOLD');?></div>
     <?php } ?>   
     </div>
    <div class="lbl-box">
    <?php if ($product->prices['override'] == 1 && ($product->prices['product_price_publish_down'] > 0)){ ?>
    <div class="offafter"></div>
        <div class="offbefore"></div>
    <div class="discount limited"><?php echo JText::_('DR_LIMITED_OFFER');?></div>
      <?php } elseif($discont >0 && $product->product_sales < 20 ) { ?>
       <div class="discafter"></div>
        <div class="discbefore"></div>
    <div class="discount"><?php echo JText::_('DR_SALE');?></div>
		<?php } elseif ($product->product_sales > 20) {?>
        <div class="hitafter"></div>
        <div class="hitbefore"></div>
          <div class="hit"><?php echo JText::_('DR_HOT');?></div>
          <?php } ?>
          </div>
			<div class="img-wrapper">
            <?php 
            $images = $product->images;
			$main_image_title = $images[0]->file_title;
			$main_image_alt = $images[0]->file_meta;
			if (!empty($images[0]->file_url_thumb)){
				$main_image_url1 = JURI::root().''.$images[0]->file_url_thumb;
			}else {
				$main_image_url1 = JURI::root().'images/stories/virtuemart/noimage.gif';
				}
			if (!empty($images[1]->file_url_thumb)){
				$main_image_url2 = JURI::root().''.$images[1]->file_url_thumb;
			}else {
				$main_image_url2 = JURI::root().'images/stories/virtuemart/noimage.gif';
				}
			$image = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_virtuemart_product/js/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
			?>

			   <?php
                       // $image = $product->images[0]->displayMediaThumb('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ; 
                        if(!empty($product->images[1])){
                         $image2 = '<img data-original="'.$main_image_url2 .'"  src="modules/mod_virtuemart_product/js/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                        } else {$image2 = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_virtuemart_product/js/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';}
						
                        echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
                ?>
                </div>
                 <?php if ( VmConfig::get ('display_stock', 1)) { ?>
						<!-- 						if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
						<div class="paddingtop8">
							<span class="vmicon vm2-<?php if ($product->product_in_stock - $product->product_ordered <1){echo 'nostock';} elseif(($product->product_in_stock - $product->product_ordered )<= $product->low_stock_notification){echo 'lowstock';} elseif(($product->product_in_stock - $product->product_ordered )> $product->low_stock_notification){echo 'normalstock';}  ?>"></span>
							<span class="stock-level"><?php echo vmText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
						</div>
					<?php } ?>
	</div>        
    <div class="slide-hover">
    	<div class="wrapper">
			  <?php if ($show_title) { ?>
                    <div class="Title">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
                    </div>
            <?php } ?>	
             <?php if ($show_cat) { ?>
                    <div class="Categories">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->category_name,'40','...'), array('title' => $product->category_name)); ?>
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
			<?php } ?>
            <?php if ($show_price) { ?>	
              <?php if (( !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
        <div class="Price">
        <?php
				 if ($product->prices['basePriceWithTax']>0 && $discont >0) 
                    echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePriceWithTax','',$product->prices,true) . '</span>';
                if ($product->prices['salesPrice']>0)
                    echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$product->prices,true) . '</span>';
               
        ?>			
        </div>
	<?php } ?>
    <?php } ?> 
		</div>
         
		<?php if ($show_desc) { ?>
			<div class="description">
				<?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, $row_desc_feat, '...') ?>
			</div>
		<?php } ?>	
		
            <div class="wrapper-slide">
                       <?php 
		   if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } ?>

			<?php if ($show_addtocart) echo mod_virtuemart_product::addtocart($product);?>
             <?php if(is_file(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php")){  ?>
                 <div class="jClever compare_cat list_compare<?php echo $product->virtuemart_product_id;?>">
                    <?php require(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php"); ?>
                 </div>
               <?php } ?>       


             <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php")){  ?>
                 <div class="wishlist list_wishlists<?php echo $product->virtuemart_product_id;?>">
                    <?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php"); ?>
                 </div>
               <?php } ?>       
                
			<?php if ($show_details) { ?>
			<div class="Details">
				<?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), JText::_('DR_DETAILS')); ?><?php ?> 
			</div>
			<?php } ?>
            <div class="clear"></div>
			</div>
    	</div>
    </div>
	</div>
     
    
    
		<?php
            if ($col == $products_per_row && $products_per_row && $last) {
                echo "</li><li>";
                $col= 1 ;
            } else {
                $col++;
            }
			$last--;
            endforeach; ?>
	</li>
</ul>
<div class="clearfix"></div>
</div>
<?php
} else { 
?>
<?php 
$last = count($products)-1;
?>

<div class="prod_box">
<ul id="box<?php echo $params->get( 'class_sfx' ) ?>" class="vmproduct layout">
 <li>
  <?php foreach ($products as $product) : 
  $discont = $product->prices[discountAmount];
  $discont = abs($discont);
  ?>
<div class="prod-row">
        <?php if ($product->prices['override'] == 1 && ($product->prices['product_price_publish_down'] > 0)){
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
				<div class="count_holder_small">
				<div class="count_info"><?php echo JText::_('DR_LIMITED2')?></div>
				<div id="CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_feat' ); ?>" class="count_border">
				 <script type="text/javascript">
				jQuery(function () {    
					jQuery('#CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_feat' ); ?>').countdown({
						until: new Date(<?php echo $year; ?>, <?php echo $month; ?> - 1, <?php echo $data; ?>), 
									labels: ['Years', 'Months', 'Weeks', '<?php echo JText::_('DR_DAYS')?>', '<?php echo JText::_('DR_HOURS')?>', '<?php echo JText::_('DR_MINUTES')?>', '<?php echo JText::_('DR_SECONDS')?>'],
									labels1:['Years','Months','Weeks','<?php echo JText::_('DR_DAYS')?>','<?php echo JText::_('DR_HOURS')?>','<?php echo JText::_('DR_MINUTES')?>','<?php echo JText::_('DR_SECONDS')?>'],
						compact: false});
				});
				 </script>
				 </div>
                 <div class="bzSaleTimerDesc"><?php echo JText::_('DR_HURRY'); ?><div>&nbsp;<strong><?php echo $product->product_in_stock ?></strong>&nbsp;<?php echo JText::_('DR_HURRY_ITEMS'); ?></div></div>
				 </div>
			  <?php } ?>
     <div class="product-box hover back_w spacer <?php if ($discont>0) { echo 'disc';} ?> ">
              <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/> 

 <?php if ($show_img) { ?>
    <div class="browseImage ">
    <div class="lbl-box2">
    <?php
	$stockhandle = VmConfig::get ('stockhandle', 'none');
	if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($product->product_in_stock - $product->product_ordered) < 1) || 
			(($product->product_in_stock - $product->product_ordered) < $product->min_order_level ))  { ?>
    	<div class="soldafter"></div>
        <div class="soldbefore"></div>
        <div class="sold"><?php echo JText::_('DR_SOLD');?></div>
     <?php } ?>   
     </div>
    <div class="lbl-box">
    <?php if ($product->prices['override'] == 1 && ($product->prices['product_price_publish_down'] > 0)){ ?>
    <div class="offafter"></div>
        <div class="offbefore"></div>
    <div class="discount limited"><?php echo JText::_('DR_LIMITED_OFFER');?></div>
      <?php } elseif($discont >0 && $product->product_sales < 20 ) { ?>
       <div class="discafter"></div>
        <div class="discbefore"></div>
    <div class="discount"><?php echo JText::_('DR_SALE');?></div>
		<?php } elseif ($product->product_sales > 20) {?>
        <div class="hitafter"></div>
        <div class="hitbefore"></div>
          <div class="hit"><?php echo JText::_('DR_HOT');?></div>
          <?php } ?>
          </div>
			<div class="img-wrapper">
            <?php 
            $images = $product->images;
			$main_image_title = $images[0]->file_title;
			$main_image_alt = $images[0]->file_meta;
			if (!empty($images[0]->file_url_thumb)){
				$main_image_url1 = JURI::root().''.$images[0]->file_url_thumb;
			}else {
				$main_image_url1 = JURI::root().'images/stories/virtuemart/noimage.gif';
				}
			if (!empty($images[1]->file_url_thumb)){
				$main_image_url2 = JURI::root().''.$images[1]->file_url_thumb;
			}else {
				$main_image_url2 = JURI::root().'images/stories/virtuemart/noimage.gif';
				}
			$image = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_virtuemart_product/js/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
			?>

			   <?php
                       // $image = $product->images[0]->displayMediaThumb('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ; 
                        if(!empty($product->images[1])){
                         $image2 = '<img data-original="'.$main_image_url2 .'"  src="modules/mod_virtuemart_product/js/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                        } else {$image2 = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_virtuemart_product/js/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';}
						
                        echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
                ?>
                </div>
                 <?php if ( VmConfig::get ('display_stock', 1)) { ?>
						<!-- 						if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
						<div class="paddingtop8">
							<span class="vmicon vm2-<?php if ($product->product_in_stock - $product->product_ordered <1){echo 'nostock';} elseif(($product->product_in_stock - $product->product_ordered )<= $product->low_stock_notification){echo 'lowstock';} elseif(($product->product_in_stock - $product->product_ordered )> $product->low_stock_notification){echo 'normalstock';}  ?>"></span>
							<span class="stock-level"><?php echo vmText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
						</div>
					<?php } ?>
	</div>        
    <div class="slide-hover">
    	<div class="wrapper">
			  <?php if ($show_title) { ?>
                    <div class="Title">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
                    </div>
            <?php } ?>	
             <?php if ($show_cat) { ?>
                    <div class="Categories">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->category_name,'40','...'), array('title' => $product->category_name)); ?>
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
			<?php } ?>
            <?php if ($show_price) { ?>	
              <?php if (( !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
        <div class="Price">
        <?php
				 if ($product->prices['basePriceWithTax']>0 && $discont >0) 
                    echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePriceWithTax','',$product->prices,true) . '</span>';
                if ($product->prices['salesPrice']>0)
                    echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$product->prices,true) . '</span>';
               
        ?>			
        </div>
	<?php } ?>
    <?php } ?> 
		</div>
         
		<?php if ($show_desc) { ?>
			<div class="description">
				<?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, $row_desc_feat, '...') ?>
			</div>
		<?php } ?>	
		
            <div class="wrapper-slide">
                       <?php 
		   if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } ?>

			<?php if ($show_addtocart) echo mod_virtuemart_product::addtocart($product);?>
             <?php if(is_file(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php")){  ?>
                 <div class="jClever compare_cat list_compare<?php echo $product->virtuemart_product_id;?>">
                    <?php require(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php"); ?>
                 </div>
               <?php } ?>       


             <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php")){  ?>
                 <div class="wishlist list_wishlists<?php echo $product->virtuemart_product_id;?>">
                    <?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php"); ?>
                 </div>
               <?php } ?>       
                
			<?php if ($show_details) { ?>
			<div class="Details">
				<?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), JText::_('DR_DETAILS')); ?><?php ?> 
			</div>
			<?php } ?>
            <div class="clear"></div>
			</div>
    	</div>
    </div>
	</div>    
		<?php
            if ($col == $products_per_row && $products_per_row && $last) {
                echo "</li><li>";
                $col= 1 ;
            } else {
                $col++;
            }
			$last--;
            endforeach; ?>
	</li>
</ul>
<div class="clearfix"></div>
</div>
<?php } ?>
<script type="text/javascript">
jQuery(document).ready(function() {
		jQuery('.prod_box .layout .hasTooltip').tooltip('hide');	
		jQuery(".prod_box img.lazy").show().lazyload({
			effect : "fadeIn"
		});
	});
	jQuery(document).ready(function($) {
		 $(function() {
    	$('ul.layout div.prod-row, ul.layout2 div.prod-row').each(function() {        
        var tip = $(this).find('div.count_holder_small');
        $(this).hover(
            function() { tip.appendTo('body'); },
            function() { tip.appendTo(this); }
        ).mousemove(function(e) {
            var x = e.pageX + 60,
                y = e.pageY - 50,
                w = tip.width(),
                h = tip.height(),
                dx = $(window).width() - (x + w),
                dy = $(window).height() - (y + h);

            if ( dx < 50 ) x = e.pageX - w - 60;
            if ( dy < 50 ) y = e.pageY - h + 130;

            tip.css({ left: x, top: y });
        	});         
    	});

		});

	});
</script>
<?php	if ($footerText) : ?>
	<div class="vmfooter <?php echo $params->get( 'moduleclass_sfx' ) ?>">
		 <?php echo $footerText ?>
	</div>
<?php endif; ?>
</div>
