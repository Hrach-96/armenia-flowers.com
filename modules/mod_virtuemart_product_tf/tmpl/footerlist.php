<?php // no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.modal');
$col= 1 ;
$app = JFactory::getApplication();
$templateparams = $app->getTemplate(true)->params;
$politeloading = $templateparams->get('politeloading');
$lblsale = $templateparams->get('lblsale');
$lblhot = $templateparams->get('lblhot');
$lblhotcount = $templateparams->get('lblhotcount');
$lbloffer = $templateparams->get('lbloffer');
$lblsold = $templateparams->get('lblsold');
$lblnew = $templateparams->get('lblnew');
$latest_products_days = $templateparams->get('lblnewcount');
$showdesc = $templateparams->get('showdesc');
$showdesccount = $templateparams->get('showdesccount');
?>
<div class="vmgroup<?php echo $params->get( 'moduleclass_sfx' ) ?>">
<?php if ($headerText) { ?>
	<div class="vmheader"><?php echo $headerText ?></div>
<?php }
?>

<?php 
$last = count($products)-1;
$odd = 0;
?>

<div class="prod_box">
<ul id="box<?php echo $params->get( 'class_sfx' ) ?>" class="vmproduct layout listproduct">
 <li>
  <?php foreach ($products as $product) :
   $discont = $product->prices[discountAmount];
  $discont = abs($discont);
  foreach ($product->categoryItem as $key=>$prod_cat) {
		$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
	}
	$odd++;
  ?>
    <div class="prod-row">

     <div class="product-box hover back_w spacer <?php if ($discont>0) { echo 'disc';} ?> ">
              <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/> 
    <div class="browseImage2">
    <div class="lbl-box2">
   <?php
    //$dataNew = explode(' ', $product->created_on);
    //$dataNew=$dataNew[0];
    //$dataNewOut = date('Y-m-d', strtotime($dataNew . " + ".$latest_products_days." day"));
    
    $str_date = explode(' ', $product->created_on);
    $dataN = explode("-", $str_date[0]);
    $dataNew =  mktime(0, 0, 0, $dataN[1],$dataN[2], $dataN[0]);
    $dataNewOut = $dataNew + 60*60*24*$latest_products_days;
   // var_dump($product->created_on).'</br>';
   // var_dump($dataNewOut);
    $stockhandle = VmConfig::get ('stockhandle', 'none');
    if ((($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($product->product_in_stock - $product->product_ordered) < 1) || 
            (($product->product_in_stock - $product->product_ordered) < $product->min_order_level ))&& $lblsold)  { ?>
        <div class="sold"><?php echo JText::_('DR_SOLD');?></div>
     <?php }elseif ((time() - $result < $dataNewOut ) && $lblnew ){ ?>
     <div class="new"><?php echo JText::_('DR_NEW');?></div>
     <?php } ?>    
     </div>
    <div class="lbl-box">
  <?php if ($lbloffer && $product->prices['override'] == 1 && ($product->prices['product_price_publish_down'] > 0)){ ?>
    <div class="limited"><?php echo JText::_('DR_LIMITED_OFFER');?></div>
      <?php } elseif($discont >0 && $product->product_sales < $lblhotcount && $lblsale ) { ?>
    <div class="discount"><?php echo JText::_('DR_SALE');?></div>
<?php } elseif ($lblhot && $product->product_sales > $lblhotcount) {?>
          <div class="hit"><?php echo JText::_('DR_HOT');?></div>
          <?php } ?>
          </div>
  <div class="img-wrapper2">
             <?php 
            $images = $product->images;
            $main_image_title = $images[0]->file_title;
            $main_image_alt = $images[0]->file_meta;
            if ($product->images[0]->published){
              $main_image_url1 = JURI::root().''.$product->images[0]->getFileUrlThumb();
              if($politeloading=='1') {
                $main_image_url1_p = 'images/stories/virtuemart/preloader.gif';
              }else {
                $main_image_url1_p = JURI::root().''.$product->images[0]->getFileUrlThumb();
              }
            }else {
              $main_image_url1 = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
            }
            if ($product->images[1]->published){
              $main_image_url2 = JURI::root().''.$product->images[1]->getFileUrlThumb();
              if($politeloading=='1') {
                $main_image_url2_p = 'images/stories/virtuemart/preloader.gif';
              }else {
                $main_image_url2_p = JURI::root().''.$product->images[1]->getFileUrlThumb();
              }
            }else {
              $main_image_url2 = $main_image_url1;
            }
      $image = '<img data-original="'.$main_image_url1 .'"  src="'.$main_image_url1_p.'"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" /></div>';
      //$image2 = '<div class="back"><img data-original="'.$main_image_url2 .'"  src="'.$main_image_url2_p.'"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst"/></div>';
      ?>
         <?php
           echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id),''.$image.'');
        ?>              
                
	</div>        
    <div class="slide-hover">
    	<div class="wrapper">
         
          <div class="Title">
          <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
          </div>
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
           		 <?php }  ?>								
   
		</div>
		
		  <div class="clearfix"></div>
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
<script type="text/javascript">
jQuery(document).ready(function() {
		//jQuery('.prod_box .layout .hasTooltip').tooltip('hide');	
    if (notPoliteLoading =='1'){
		  jQuery(".module.<?php echo $params->get( 'moduleclass_sfx' ) ?> .prod_box img.lazy").show().lazyload({
			   effect : "fadeIn"
	   	});
    }
	});
</script>
<?php	if ($footerText) : ?>
	<div class="vmfooter <?php echo $params->get( 'moduleclass_sfx' ) ?>">
		 <?php echo $footerText ?>
	</div>
<?php endif; ?>
</div>
