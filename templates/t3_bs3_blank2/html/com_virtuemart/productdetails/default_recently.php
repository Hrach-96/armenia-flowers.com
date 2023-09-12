<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );

if(!isset($_SESSION['recent']))
	$_SESSION['recent'] = array();
if(!in_array($this->product->virtuemart_product_id,$_SESSION['recent'])){
	$_SESSION['recent'][] = $this->product->virtuemart_product_id;
	if(count($_SESSION['recent']) > 6){
		array_shift($_SESSION['recent']);
	}
}
//var_dump($_SESSION['recent']);
//print_r(count($_SESSION['recent']));
$product_model = VmModel::getModel('product');
$products = $product_model->getProducts($_SESSION['recent']);
$product_model->addImages($products);
//print_r(count($products));
$ratingModel = VmModel::getModel('ratings');
$mainframe = Jfactory::getApplication();
$virtuemart_currency_id = $mainframe->getUserStateFromRequest( "virtuemart_currency_id", 'virtuemart_currency_id',JRequest::getInt('virtuemart_currency_id',0) );
$currency = CurrencyDisplay::getInstance( );
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
$category_list_style = $templateparams->get('category_list_style','style_1');
if(count($products) > 1){
	echo '<h3 class="module-title item recent'.$i.'">'.JText::_('RECENTLY_VIEWED_PRODUCTS').'</h3>';
		echo '<div class="prod_box"><ul id="sliderrecent" class="recentproducts vmproduct layout">';
		$i=1;
		foreach($products as $prod){
			 $discont = $prod->prices[discountAmount];
			  $discont = abs($discont);
			  foreach ($prod->categoryItem as $key=>$prod_cat) {
					$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
				}
			
			
				
				if ($prod->virtuemart_product_id >0){?>
					
					<li>
						<div class="prod-row">
    <div class="product-box hover back_w spacer <?php if ($discont>0) { echo 'disc';} if ($category_list_style == 'style_1'){echo ' style_1';}elseif ($category_list_style == 'style_2'){echo ' style_2';}else {echo ' style_3';} ?> ">
    		<?php if ($showquick) {?>
              <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $prod->virtuemart_product_id ?>"/> 
          	<?php } ?> 
			<div class="browseImage ">

				 <?php if ($prod->prices['override'] == 1 && ($prod->prices['product_price_publish_down'] > 0)){
			       $data = $prod->prices['product_price_publish_down'];
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
			        <div id="CountSmallrecent<?php echo $prod->virtuemart_product_id; ?>" class="count_border">
			         <script type="text/javascript">
			        jQuery(function () {    
			          jQuery('#CountSmallrecent<?php echo $prod->virtuemart_product_id; ?>').countdowns({
			            until: new Date(<?php echo $year; ?>, <?php echo $month; ?> - 1, <?php echo $data; ?>), 
			            labels: ['Years', 'Months', 'Weeks', '<?php echo JText::_('DR_DAYS')?>', '<?php echo JText::_('DR_HOURS')?>', '<?php echo JText::_('DR_MINUTES')?>', '<?php echo JText::_('DR_SECONDS')?>'],
			            labels1:['Years','Months','Weeks','<?php echo JText::_('DR_DAYS')?>','<?php echo JText::_('DR_HOURS')?>','<?php echo JText::_('DR_MINUTES')?>','<?php echo JText::_('DR_SECONDS')?>'],
			            compact: false});
			        });
			         </script>
			         </div>
			                 <div class="bzSaleTimerDesc"><?php echo JText::_('DR_HURRY'); ?><div>&nbsp;<strong><?php echo $prod->product_in_stock ?></strong>&nbsp;<?php echo JText::_('DR_HURRY_ITEMS'); ?></div></div>
			         </div>
			        <?php } ?>

    <div class="lbl-box2">
		   <?php
		    //$dataNew = explode(' ', $product->created_on);
		    //$dataNew=$dataNew[0];
		    //$dataNewOut = date('Y-m-d', strtotime($dataNew . " + ".$latest_products_days." day"));
		    
		    $str_date = explode(' ', $prod->created_on);
		    $dataN = explode("-", $str_date[0]);
		    $dataNew =  mktime(0, 0, 0, $dataN[1],$dataN[2], $dataN[0]);
		    $dataNewOut = $dataNew + 60*60*24*$latest_products_days;
		   // var_dump($product->created_on).'</br>';
		   // var_dump($dataNewOut);
		    $stockhandle = VmConfig::get ('stockhandle', 'none');
		    if ((($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($prod->product_in_stock - $prod->product_ordered) < 1) || 
		            (($prod->product_in_stock - $prod->product_ordered) < $prod->min_order_level ))&& $lblsold)  { ?>
		        <div class="sold"><?php echo JText::_('DR_SOLD');?></div>
		     <?php }elseif ((time() - $result < $dataNewOut ) && $lblnew ){ ?>
		     <div class="new"><?php echo JText::_('DR_NEW');?></div>
		     <?php } ?>    
		     </div>
		    <div class="lbl-box">
		  <?php if ($lbloffer && $prod->prices['override'] == 1 && ($prod->prices['product_price_publish_down'] > 0)){ ?>
		    <div class="limited"><?php echo JText::_('DR_LIMITED_OFFER');?></div>
		      <?php } elseif($discont >0 && $prod->product_sales < $lblhotcount && $lblsale ) { ?>
		    <div class="discount"><?php echo JText::_('DR_SALE');?></div>
		<?php } elseif ($lblhot && $prod->product_sales > $lblhotcount) {?>
          <div class="hit"><?php echo JText::_('DR_HOT');?></div>
          <?php } ?>
          </div>
          <?php if ($category_list_style == 'style_1' || $category_list_style == 'style_2'){ ?>
  <div class="img-wrapper big second">
             <?php 
             //print_r($product->images[0]->getFileUrlThumb());
            $images = $prod->images;
            $main_image_title = $images[0]->file_title;
            $main_image_alt = $images[0]->file_meta;
            $notimages = $prod->images[0]->getFileUrlThumb();
      if ($images[0]->published){
        $main_image_url1 = JURI::root().''.$prod->images[0]->getFileUrlThumb();
        if($politeloading=='1') {
          $main_image_url1_p = 'images/stories/virtuemart/preloader.gif';
        }else {
          $main_image_url1_p = JURI::root().''.$prod->images[0]->getFileUrlThumb();
        }
      }else {
        $main_image_url1 = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
        }
       
       if ($images[1]->published){
        $main_image_url2 = JURI::root().''.$prod->images[1]->getFileUrlThumb();
        if($politeloading=='1') {
          $main_image_url2_p = 'images/stories/virtuemart/preloader.gif';
        }else {
          $main_image_url2_p = JURI::root().''.$prod->images[1]->getFileUrlThumb();
        }
      }else {
        $main_image_url2 = $main_image_url1;
        }
      $image = '<div class="front"><img data-original="'.$main_image_url1 .'"  src="'.$main_image_url1_p.'"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" /></div>';
      $image2 = '<div class="back"><img data-original="'.$main_image_url2 .'"  src="'.$main_image_url2_p.'"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst"/></div>';
      ?>

         <?php
                      
            
           echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$prod->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id),''.$image.''.$image2.'');
        ?>
                </div>
<?php } ?>
        <?php if ($category_list_style == 'style_3'){ ?>

              <div id="fancybox<?php echo $prod->virtuemart_product_id ?>" class="img-wrapper">

                  <a  class="fancybox-style fancybox-thumb" rel="fancybox-thumb" title="<?php echo $prod->images[0]->file_title ?>" href="<?php echo $prod->images[0]->file_url ;?>">
                    <?php
                      echo $prod->images[0]->displayMediaThumb('class="lazy browseProductImage"', false);
                    ?>
                    </a>
                    <div class="second">
                    <?php 
                      $j = count($prod->images);
                      for($i = 1; $i<$j; $i++){ ?>
                      <a class="fancybox-thumb" rel="fancybox-thumb" title="<?php echo $prod->images[$i]->file_title ?>" href="<?php echo $prod->images[$i]->file_url ;?>">
                         <?php  //echo $product->images[$i]->displayMediaThumb('class="lazy"', false); ?>
                      </a>    
                     <?php }
                    ?>
                    </div>
              </div>
        <?php } ?>  
			</div>



			 <div class="slide-hover">
    	<div class="wrapper">
         <?php if ( VmConfig::get ('display_stock', 1)) { ?>
            <!--            if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
            <div class="paddingtop8">
              <span class="vmicon vm2-<?php if ($prod->product_in_stock - $prod->product_ordered <1){echo 'nostock';} elseif(($prod->product_in_stock - $prod->product_ordered )<= $prod->low_stock_notification){echo 'lowstock';} elseif(($prod->product_in_stock - $prod->product_ordered )> $prod->low_stock_notification){echo 'normalstock';}  ?>"></span>
              <span class="stock-level"><?php echo vmText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
            </div>
          <?php } ?>
                    <div class="Title">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$prod->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($prod->product_name,'30','...'), array('title' => $prod->product_name)); ?>
                    </div>
                    <?php if ($showdesc) {?>
	                   	<?php // Product Short Description
                            if(!empty($prod->product_s_desc)) { ?>
                            	<div class="description"><?php echo shopFunctionsF::limitStringByWord($prod->product_s_desc, $showdesccount, '...') ?></div>
                       	<?php } ?>
	                    <?php }?>  
	                     <?php if (( !empty($prod->prices['salesPrice'])) && !$prod->images[0]->file_is_downloadable) { ?>
			        <div class="Price">
			        <?php
							 if ($prod->prices['basePrice']>0 && $discont >0) 
			                    echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePrice','',$prod->prices,true) . '</span>';
			                if ($prod->prices['salesPrice']>0)
			                    echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$prod->prices,true) . '</span>';
			               
			        ?>			
			        </div>
				<?php } ?>
				 <?php
				  $showRating = $ratingModel->showRating($this->product2->virtuemart_product_id);
										 if ($showRating=='true'){
                $rating = $ratingModel->getRatingByProduct($this->product2->virtuemart_product_id);
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
        


	</div></div></li>
				<?php	 		
				$i++;
				}
				
			
		}
		echo '</ul></div>';

} ?>
<script type="text/javascript">
function fancyboxthumbrecently(){							 
	 jQuery(".layout .product-box.style_3").each(function(indx, element){
		var my_product_id = jQuery(this).find(".img-wrapper").attr('id');
		//alert(my_product_id);
		if(my_product_id){
			jQuery("#"+my_product_id+" .fancybox-thumb").fancybox({
				wrapCSS : 'categories-list',
				helpers	: {
					thumbs	: {
						width	: 70,
						height	: 70
					}
				}
			});
		}
	});
}
jQuery(document).ready(function($) {
	fancyboxthumbrecently();
});	
</script>