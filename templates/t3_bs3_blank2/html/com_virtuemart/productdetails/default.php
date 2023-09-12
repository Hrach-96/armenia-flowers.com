<?php

/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Eugen Stranz
 * @author RolandD,
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 5444 2012-02-15 15:31:35Z Milbo $
 */
// Check to ensure this file is included in Joomla!
//error_reporting('E_ALL');

defined('_JEXEC') or die('Restricted access');
echo shopFunctionsF::renderVmSubLayout('askrecomjs',array('product'=>$this->product));
$app = JFactory::getApplication();
$templateparams	= $app->getTemplate(true)->params;
$politeloading = $templateparams->get('politeloading');
$lblsale = $templateparams->get('lblsale');
$lblhot = $templateparams->get('lblhot');
$lblhotcount = $templateparams->get('lblhotcount');
$lbloffer = $templateparams->get('lbloffer');
$lblsold = $templateparams->get('lblsold');
$lblnew = $templateparams->get('lblnew');
$latest_products_days = $templateparams->get('lblnewcount');
$socialshare = $templateparams->get('socialshare');
$productpage_images_style = $templateparams->get('productpage_images_style','style_1');
$productpage_infoblock_style = $templateparams->get('productpage_infoblock_style','style_1');
$showcompare = $templateparams->get('showcompare');
$showwishlist = $templateparams->get('showwishlist');
$showquick = $templateparams->get('showquick');


$document = JFactory::getDocument();

if(vRequest::getInt('print',false)){
?>
<body onLoad="javascript:print();">
<?php }

//JHtml::_('behavior.modal');
error_reporting('E_ALL');
// addon for joomla modal Box
// JHTML::_('behavior.tooltip');
$document = JFactory::getDocument();
$document->addScriptDeclaration("
	jQuery(document).ready(function($) {
	/*	$('.additional-images a').mouseover(function() {
			var himg = this.href ;
			var extension=himg.substring(himg.lastIndexOf('.')+1);
			if (extension =='png' || extension =='jpg' || extension =='gif') {
				$('.main-image img').attr('src',himg );
			}
			console.log(extension)
		});*/
	});
");
/* Let's see if we found the product */
if (empty($this->product)) {
    echo JText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
    echo '<br /><br />  ' . $this->continue_link_html;
    return;
}
$this->row = 0;
?>
<div id="productdetailsview" class="product-container productdetails-view productdetails">

	<?php
    // PDF - Print - Email Icon
    if (VmConfig::get('show_emailfriend') || VmConfig::get('show_printicon') || VmConfig::get('pdf_button_enable')) {
	?>
        <div class="icons">
	    <?php
	    //$link = (JVM_VERSION===1) ? 'index2.php' : 'index.php';
	    $link = 'index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id;
	    $MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component';

	    if (VmConfig::get('pdf_icon', 1) == '1') {
		echo '<div class="icons-pdf">'.$this->linkIcon($link . '&format=pdf', 'COM_VIRTUEMART_PDF', 'pdf_button', 'pdf_button_enable', false).'</div>';
	    }
	    echo '<div class="icons-print">'.$this->linkIcon($link . '&print=1', 'COM_VIRTUEMART_PRINT', 'printButton', 'show_printicon').'</div>';
	   // echo '<div class="icons-recomend">'.$this->linkIcon($MailLink, 'COM_VIRTUEMART_EMAIL', 'emailButton', 'show_emailfriend').'</div>';
		 	if (VmConfig::get('show_emailfriend', 1) == '1') { 
			$MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component';
			?>
			   <div class="icons-recomend">
					 <a class="ask-recomend" data-fancybox-type="iframe" href="<?php echo $MailLink ?>" rel="nofollow" title="<?php echo JText::_('COM_VIRTUEMART_EMAIL') ?>" >
                     </a>
					</div>
			<?php }
			echo '<div class="icons-edit">'.$this->edit_link.'</div>';
			 ?>      
	   
        </div>
    <?php } // PDF - Print - Email Icon END
    ?>
<div class="wrapper2">
	 
	<div class="fleft image_loader">
    <div class="image_show">
		<?php
		if($productpage_images_style == 'style_1'){
			echo $this->loadTemplate('images');
		}
		if($productpage_images_style == 'style_2'){
			echo $this->loadTemplate('images2');
		}
		if($productpage_images_style == 'style_3'){
			echo $this->loadTemplate('images3');
		}
		?>
		
		<?php 
		if ($socialshare){
		$app= & JFactory::getApplication();
		$template = $app->getTemplate();
		$gpath2 = $this->baseurl."/templates/".$template ;
		?>  
		<script type="text/javascript" src="<?php echo $gpath2 ?>/js/prodstyle/social-likes.min.js"></script>
	</br>
        <div class="share_box">
        <div class="share">
        	<?php
        	$link2 = JURI::base() .'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id; 
			    //$og_price_amount = $this->$product_price;
				$og_url = $link2;
				$og_desc = $this->product->product_s_desc;
				$og_image =  JRoute::_(JURI::base().$this->product->images[0]->getFileUrlThumb());
				$og_title = $this->product->product_name;
				//$app =& JFactory::getApplication();

				$doc = JFactory::getDocument();
				$doc->addCustomTag('<meta property="og:type" content="product"/>');
				$doc->addCustomTag('<meta property="og:title" content="'.$og_title.'"/>');
				//$doc->addCustomTag('<meta property="og:price:amount" content="'.$og_price_amount.'"/>');
				//$document->addCustomTag('<meta property="og:price:currency" content="'CDN'"/>');
				//$document->addCustomTag('<meta property="og:site_name" content="'SITENAME'"/>');
				$doc->addCustomTag('<meta property="og:url" content="'.$og_url.'"/>');
				$doc->addCustomTag('<meta property="og:description" content="'.$og_desc.'"/>');
				$doc->addCustomTag('<meta property="og:image" content="'.$og_image.'"/>'); 
			        	?>
		    <div class="social-likes">
			<div class="facebook" title="Facebook"><i class="fa fa-facebook"></i></div>
			<div class="twitter" title="Twitter"><i class="fa fa-twitter"></i></div>
			<div class="plusone" title="Google+"><i class="fa fa-google-plus"></i></div>
			<div class="pinterest" title="Pinterest" data-media="<?php echo $og_image; ?>"><i class="fa fa-pinterest-p"></i></div>
		</div>
		           
            </div>
             <div class="clear"></div>
            </div>
            <?php } ?>
          
        </div>    
	</div>
    <div class="fright">
    	
		 <?php // Product Title  ?>
			<h1 class="title"><?php echo $this->product->product_name ?></h1>
		<?php // Product Title END  ?>
		<div class="rating">
			<?php
			$ratingModel = VmModel::getModel('ratings');

			 $showRating = $ratingModel->showRating($this->product->virtuemart_product_id);
			 if ($showRating=='true'){
					$rating = $ratingModel->getRatingByProduct($this->product->virtuemart_product_id);
					if( !empty($rating)) {
						$r = $rating->rating;
					} else {
						$r = 0;
					}
					$maxrating = VmConfig::get('vm_maximum_rating_scale',5);
									$ratingwidth = ( $r * 100 ) / $maxrating;//I don't use round as percetntage with works perfect, as for me
						?>
													
							<?php  if( !empty($rating)) {  ?>                        
					<span class="vote">
						<span title="" class="vmicon ratingbox" style="display:inline-block;">
							<span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
							</span>
						</span>
						<span class="rating-title"><?php echo JText::_('COM_VIRTUEMART_RATING').' '.round($rating->rating, 2) . '/'. $maxrating; ?></span>
					</span>
			   <?php } else { ?>
				  <span class="vote">
						<span title="" class="vmicon ratingbox" style="display:inline-block;">
							<span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
							</span>
						</span>
						<span class="rating-title"><?php echo JText::_('COM_VIRTUEMART_RATING').' '.JText::_('COM_VIRTUEMART_UNRATED') ?></span>
				   </span>
					 <?php } } ?>	
			</div>
            
            <?php
				// Manufacturer of the Product
				if (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id)) {
				  echo  $this->loadTemplate('manufacturer');
				}
				if ($this->product->product_in_stock >=1) {
				echo '<div class="stock"><span class="bold">'.JText::_('DR_AVAILABILITY_NEW').':</span><i class="green">'.JText::_('DR_IN_STOCK_NEW').'</i>&nbsp;<b>'.$this->product->product_in_stock.'&nbsp;'.JText::_('DR_ITEMS_NEW').'</b></div>';
				}else {
				echo '<div class="stock"><span class="bold">'.JText::_('DR_AVAILABILITY_NEW').':</span><i class="red">'.JText::_('DR_OUT_STOCK_NEW').'</i>&nbsp;<b>'.$this->product->product_in_stock.'&nbsp;'.JText::_('DR_ITEMS_NEW').'</b></div>';
				}
				echo '<div class="code"><span class="bold">'.JText::_('DR_PRODUCT_CODE_NEW').':</span>'.$this->product->product_sku.'</div>';
			?>
           <?php if (($this->product->product_length > 0) || ($this->product->product_width > 0) || ($this->product->product_height > 0) || ($this->product->product_weight > 0) || ($this->product->product_packaging > 0)) { ?>
            <div class="Dimensions">
				
                <h4><?php echo JText::_('COM_VIRTUEMART_PRODUCT_DIMENSIONS_AND_WEIGHT') ?></h4>
                
                <?php
                if ($this->product->product_length > 0) {
                echo '<div>'.JText::_('COM_VIRTUEMART_PRODUCT_LENGTH').': ' .$this->product->product_length.$this->product->product_lwh_uom.'</div>';
                }
                if ($this->product->product_width > 0) {
                echo '<div>'.JText::_('COM_VIRTUEMART_PRODUCT_WIDTH').': ' .$this->product->product_width.$this->product->product_lwh_uom.'</div>';
                }
                if ($this->product->product_height > 0) {
                echo '<div>'.JText::_('COM_VIRTUEMART_PRODUCT_HEIGHT').': ' .$this->product->product_height.$this->product->product_lwh_uom.'</div>';
                }
                if ($this->product->product_weight > 0) {
                echo '<div>'.JText::_('COM_VIRTUEMART_PRODUCT_WEIGHT').': ' .$this->product->product_weight.$this->product->product_weight_uom.'</div>';
                }
                if ($this->product->product_packaging > 0) {
                echo '<div>'.JText::_('COM_VIRTUEMART_PRODUCT_PACKAGING').': ' .$this->product->product_packaging.$this->product->product_unit.'</div>';
                }
                
                if ($this->product->product_box) {
                ?>
                    <div class="product-box">
                    
                    <?php
                        echo JText::_('COM_VIRTUEMART_PRODUCT_UNITS_IN_BOX').$this->product->product_box;
                    ?>
                    </div>
               <?php } // Product Packaging END
                ?>
            </div>
             <?php } // Product Packaging END
                ?>
            <?php
			//print_r($this->product->product_price_publish_down);
			if (!($this->product->prices['product_price_publish_down'] > 0)){?>
            <div class="price">
				<?php
					echo $this->loadTemplate('showprices');
				?>
             </div> 
              <?php } // Product Packaging END
                ?>
                <?php if ($this->product->prices['override']  == 1 && ($this->product->prices['product_price_publish_down'] > 0)){
					//print_r($this->product->prices['product_price_publish_down']);
					?>
                <div class="time-box">
                                <div class="indent">
                              
                               
                                      
                                <?php if (( !empty($this->product->prices['salesPrice'])) && !$this->product->images[0]->file_is_downloadable) { ?>
                                <div class="price">
                                    <div class="product-price" id="productPrice<?php echo $this->product->virtuemart_product_id ?>">
                                     
                                    <?php
                                        if ($this->product->prices['salesPrice']>0) { ?>
                                    <span class="price-sale">
                                    <span class="text"><?php echo JText::_('DR_SPECIAL_DEAL_PRICE'); ?>:</span>
									<?php echo '<span class="sales">' . $this->currency->createPriceDiv('salesPrice','',$this->product->prices) . '</span>';?>
                                    </span>
                                    <?php } ?>
                                    <?php
                                        if ($this->product->prices['basePrice']>0) { ?>
                                    <span class="price-old">
                                    <span class="text"><?php echo JText::_('DR_OLD_PRICE'); ?>:</span>
									<?php echo '<span class="WithoutTax">' . $this->currency->createPriceDiv('basePrice','',$this->product->prices) . '</span>';?>
                                    </span>
                                    <?php } ?>
                                       
                                    <span class="price_save">
                                     <span class="text"><?php echo JText::_('DR_YOU_ARE_SAVING'); ?>:</span>
									<?php echo '<span class="discount">' . $this->currency->createPriceDiv('discountAmount','',$this->product->prices) . '</span>'; ?>
                                    </span>
                                   
                                    <div class="clear" ></div>
                                    </div>
                                    </div>
                                <?php } ?> 
                                <div  class="bzSaleTimer">
                                    <?php
                                     $data = $this->product->prices['product_price_publish_down'];
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
                                        <div id="CountSmallDet<?php echo $this->product->virtuemart_product_id ?>" class="count_border">
                                         <script type="text/javascript">
                                        jQuery(function () {    
                                            jQuery('#CountSmallDet<?php echo $this->product->virtuemart_product_id ?>').countdowns({
                                                until: new Date(<?php echo $year; ?>, <?php echo $month; ?> - 1, <?php echo $data; ?>),
												labels: ['Years', 'Months', 'Weeks', '<?php echo JText::_('DR_DAYS')?>', '<?php echo JText::_('DR_HOURS')?>', '<?php echo JText::_('DR_MINUTES')?>', '<?php echo JText::_('DR_SECONDS')?>'],
												labels1:['Years','Months','Weeks','<?php echo JText::_('DR_DAYS')?>','<?php echo JText::_('DR_HOURS')?>','<?php echo JText::_('DR_MINUTES')?>','<?php echo JText::_('DR_SECONDS')?>'],
												compact: false});
                                        });
                                         </script>
                                         </div>
                                         </div>
                                      </div>
                                </div>
                                <div class="bzSaleTimerDesc"><?php echo JText::_('DR_HURRY'); ?><div>&nbsp;&nbsp;<?php echo $this->product->product_in_stock ?>&nbsp;<?php echo JText::_('DR_HURRY_ITEMS'); ?></div></div>
                                <div class="bzSaleTimerDesc2"><div><?php echo $this->product->product_ordered ?></div>&nbsp;&nbsp;<?php echo JText::_('DR_BOOKED'); ?> </div>
                                <div class="clear" ></div>
                                </div>
            <?php } ?>
            
          	<?php  if ($this->product->product_s_desc) { ?>
                <div class="short_desc">
                 <?php echo $this->product->product_s_desc; ?>
                </div>
			<?php } ?>   
		<div class="product-box2">
				
		<?php
		    //echo $this->loadTemplate('addtocart');
		    //echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'ontop'));
		    echo shopFunctionsF::renderVmSubLayout('addtocartprod',array('product'=>$this->product));
		    echo'<p></p>';
		    echo shopFunctionsF::renderVmSubLayout('stockhandle',array('product'=>$this->product));
			
		// Availability Image
		
		?>
   <div class="clear"></div>
    	
		</div>
		 <?php if ($this->product->customfieldsSorted['related_categories']) { ?>
         <div class="related_categories">
	
			<span class="module-title-categories"><?php echo  JText::_('COM_VIRTUEMART_RELATED_CATEGORIES') ; ?>:</span>
			<div>
				 <?php 	echo $this->loadTemplate('relatedcategories');?>
			</div>
            </div>
      <?php } ?> 
		
	</div><div class="clear"></div>
   
  
	  
    
    <?php
    // Product Files
    // foreach ($this->product->images as $fkey => $file) {
    // Todo add downloadable files again
    // if( $file->filesize > 0.5) $filesize_display = ' ('. number_format($file->filesize, 2,',','.')." MB)";
    // else $filesize_display = ' ('. number_format($file->filesize*1024, 2,',','.')." KB)";

    /* Show pdf in a new Window, other file types will be offered as download */
    // $target = stristr($file->file_mimetype, "pdf") ? "_blank" : "_self";
    // $link = JRoute::_('index.php?view=productdetails&task=getfile&virtuemart_media_id='.$file->virtuemart_media_id.'&virtuemart_product_id='.$this->product->virtuemart_product_id);
    // echo JHTMl::_('link', $link, $file->file_title.$filesize_display, array('target' => $target));
    // }

   		

		if($productpage_infoblock_style == 'style_1'){
			echo $this->loadTemplate('tabs');
		}
		if($productpage_infoblock_style == 'style_2'){
			echo $this->loadTemplate('accordion');
		}
		if($productpage_infoblock_style == 'style_3'){
			echo $this->loadTemplate('block');
		}
    ?>

 <div class="clear"></div>
 <?php
 if ($this->product->customfieldsSorted['related_products']) {
	echo $this->loadTemplate('relatedproducts');
 }
	echo $this->loadTemplate('recently');

?>	

<?php // Back To Category Button
	if ($this->product->virtuemart_category_id) {
		$catURL =  JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->product->virtuemart_category_id);
		$categoryName = $this->product->category_name ;
	} else {
		$catURL =  JRoute::_('index.php?option=com_virtuemart');
		$categoryName = jText::_('COM_VIRTUEMART_SHOP_HOME');
	}
	?>
	
	<div class="back-to-category left" style="padding-top:30px;">
    	<a style="display:inline-block;" href="<?php echo $catURL ?>" class="button_back button reset2" title="<?php echo $categoryName ?>"><i class="fa fa-reply"></i><?php echo JText::sprintf('COM_VIRTUEMART_CATEGORY_BACK_TO',$categoryName) ?></a>
           <?php     // Product Navigation
    if (VmConfig::get('product_navigation', 1)) { ?>
	 <div class="product-neighbour">
     	<ul class="pagers">
	    <?php
	$product_models = VmModel::getModel('product');

		$next = JText::_('VIRTUEMART_NEXTPRODUCT').'<i class="fa fa-caret-right"></i>';
		$prev = ' <i class="fa fa-caret-left"></i>'.JText::_('VIRTUEMART_PREVPRODUCT');


	    if (!empty($this->product->neighbours ['next'][0])) {
		$next_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['next'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id);
		$neighbours_id_next = $this->product->neighbours ['next'][0] ['virtuemart_product_id'];
		$neighbours_id_n = array();
		$neighbours_id_n[] = $neighbours_id_next;
		
		$prods_neighbours_n = $product_models->getProducts($neighbours_id_n);
		$product_models->addImages($prods_neighbours_n); 
		//print_r($product_model->file_url_thumb);
		//print_r($neighbours_id_prev);
		
		
		echo '<li class="next button reset2">';
		 foreach($prods_neighbours_n as $product) { 
			if ($this->product->images[0]->published){
			 $neig_next=$this->_baseurl.$product->images[0]->getFileUrlThumb();
		 }else{
			 $neig_next=JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
			 }
			echo '<div class="img_n"><img src="'.$neig_next.'" /></div>';
		 }
			echo JHTML::_('link', $next_link, $next, array('rel'=>'next','class' => 'next-page','data-dynamic-update' => '1'));
		echo '</li>';

	    }
	    	    if (!empty($this->product->neighbours ['previous'][0])) {
		$prev_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['previous'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id);
		$neighbours_id_prev = $this->product->neighbours ['previous'][0] ['virtuemart_product_id'];
		$neighbours_id_p = array();
		$neighbours_id_p[] = $neighbours_id_prev;
		
		$prods_neighbours_p = $product_models->getProducts($neighbours_id_p);
		$product_models->addImages($prods_neighbours_p); 
		//print_r($product_model->file_url_thumb);
		//print_r($neighbours_id_prev);
		
		
		echo '<li class="previous button reset2">';
		 foreach($prods_neighbours_p as $product) { 
			if ($this->product->images[0]->published){
			 $neig_prev=$this->_baseurl.$product->images[0]->getFileUrlThumb();
		 }else{
			 $neig_prev=JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
			 }
			echo '<div class="img_n"><img src="'.$neig_prev.'" /></div>';
		 }
				echo JHTML::_('link', $prev_link, $prev,array('rel'=>'prev', 'class' => 'previous-page','data-dynamic-update' => '1'));

		echo '</li>';
	    }
	    ?>
        </ul>
    	<div class="clear"></div>

        </div>
        <div class="clearfix"></div>
    <?php
    	
     } // Product Navigation END
			$j = 'jQuery(document).ready(function($) {
			Virtuemart.product(jQuery("form.product"));
		
			$("form.js-recalculate").each(function(){
				if ($(this).find(".product-fields").length && !$(this).find(".no-vm-bind").length) {
					var id= $(this).find(\'input[name="virtuemart_product_id[]"]\').val();
					Virtuemart.setproducttype($(this),id);
		
				}
			});
		});';
		//vmJsApi::addJScript('recalcReady',$j);
		
		/** GALT
			 * Notice for Template Developers!
			 * Templates must set a Virtuemart.container variable as it takes part in
			 * dynamic content update.
			 * This variable points to a topmost element that holds other content.
			 */
		$j = "Virtuemart.container = jQuery('.productdetails-view');
		Virtuemart.containerSelector = '.productdetails-view';";
		
		vmJsApi::addJScript('ajaxContent',$j);
			vmJsApi::addJScript('chosen.jquery.min');
	
	
	$selectText = 'COM_VIRTUEMART_DRDOWN_AVA2ALL';
	$vm2string = "editImage: 'edit image',select_all_text: '".vmText::_('COM_VIRTUEMART_DRDOWN_SELALL')."',select_some_options_text: '".vmText::_($selectText)."'" ;
	$selector = 'jQuery(".vm-chzn-select")';
	$script =
	'Virtuemart.updateChosenDropdownLayout = function() {
		var vm2string = {'.$vm2string.'};
		jQuery(function($) {
			'.$selector.'.chosen({enable_select_all: true,select_all_text : vm2string.select_all_text,select_some_options_text:vm2string.select_some_options_text,disable_search_threshold: 5});
		});
	}
	Virtuemart.updateChosenDropdownLayout();';
	vmJsApi::addJScript('updateChosen',$script);
	vmJsApi::css('chosen');

		echo vmJsApi::writeJS();
    ?>

	</div>
	<div class="clearfix"></div>
     </div>

    	<div class="clear"></div>

 <?php 
$app= & JFactory::getApplication();
$template = $app->getTemplate();
$gpath = $this->baseurl."/templates/".$template ;
?>  
<script type="text/javascript">
<?php
$input = JFactory::getApplication()->input;
if($input->getCmd( 'dynamic', '' ) === '1' ){ 
?>
(function ($) {
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
			if (notPoliteLoading =='1'){
				setTimeout(function() {
					$("#sliderrelated img.lazy, #sliderrecent img.lazy").show().lazyload({
						effect : "fadeIn"
					});
				}, 2000);
			}
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
		if($('.example2').length){
			Tabsresp();
		}
		$('a.ask-a-question, a.printModal, a.recommened-to-friend, a.manuModal').click(function(event){
			event.preventDefault();
			$.facebox({
				iframe: $(this).attr('href'),
				rev: 'iframe|550|550'
			});
		});
		$('.list_carousel').removeClass('loader');
		$('.product-related #slider').show();
		//$('.productdetails-view.layout2 .hasTooltip').tooltip();
		$('.productdetails-view.layout2 .product-box2 .hasTooltip').tooltip();
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
	});
})(jQuery);
<?php } ?>
</script> 
<script type="text/javascript" src="<?php echo $gpath ?>/js/prodstyle/responsiveTabs.min.js"></script>
<script type="text/javascript" src="<?php echo $gpath ?>/js/prodstyle/jquery.quick.pagination.min.js"></script>
<script type="text/javascript" src="<?php echo $gpath ?>/js/prodstyle/social-likes.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function()
	{
		Tabsresp();
		//jQuery('.productdetails-view.layout2 .hasTooltip').tooltip();
	});
	function Tabsresp(){
		RESPONSIVEUI.responsiveTabs();
	}
</script>
<script type="text/javascript">
	jQuery(document).ready(function() {
		sliderInit6();
	});
	function sliderInit6(){
		jQuery("ul.reviews-pagination").quickPagination({pagerLocation:"before",pageSize:"4"});
			if( (jQuery("#t3-mainbody .row .t3-sidebar-left").hasClass("t3-sidebar")) || (jQuery("#t3-mainbody .row .t3-sidebar-right").hasClass("t3-sidebar")) ) {
			jQuery(".product-related #sliderrelated , #sliderrecent").loveowlCarousel({
			items : 3,
			autoPlay : 7000,
			 itemsDesktop : [1000,2], //5 items between 1000px and 901px
			itemsDesktopSmall : [900,2], // betweem 900px and 601px
			itemsTablet: [700,2], //2 items between 600 and 0
			itemsMobile : [415,1], // itemsMobile disabled - inherit from itemsTablet option
			stopOnHover : true,
			lazyLoad : false,
			navigation : true,
			 pagination : false,
			 navigationText: [
				"<i class='fa fa-caret-left'></i>",
				"<i class='fa fa-caret-right'></i>"
			]
			}); 
			//jQuery('.slide_box .layout .hasTooltip').tooltip('hide');	
			if (notPoliteLoading =='1'){
				jQuery("#sliderrelated img.lazy, #sliderrecent img.lazy").show().lazyload({
					effect : "fadeIn",
					event : "sporty"
				});
				jQuery(window).bind("load", function() {
				    var timeout = setTimeout(function() {
				        jQuery("#sliderrelated img.lazy, #sliderrecent img.lazy").trigger("sporty");
				    }, 2000);
				});
			}	
	 }else {
		 jQuery(".product-related #sliderrelated , #sliderrecent").loveowlCarousel({
			items : 4,
			autoPlay : 7000,
			 itemsDesktop : [1000,3], //5 items between 1000px and 901px
			itemsDesktopSmall : [900,3], // betweem 900px and 601px
			itemsTablet: [700,2], //2 items between 600 and 0
			itemsMobile : [415,1], // itemsMobile disabled - inherit from itemsTablet option
			stopOnHover : true,
			lazyLoad : false,
			navigation : true,
			 pagination : false,
			 navigationText: [
				"<i class='fa fa-caret-left'></i>",
				"<i class='fa fa-caret-right'></i>"
			]
			}); 
			//jQuery('.slide_box .layout .hasTooltip').tooltip('hide');	
			if (notPoliteLoading =='1'){
				jQuery("#sliderrelated img.lazy, #sliderrecent img.lazy").show().lazyload({
				  effect : "fadeIn",
					event : "sporty"
				});
				jQuery(window).bind("load", function() {
				    var timeout = setTimeout(function() {
				        jQuery("#sliderrelated img.lazy, #sliderrecent img.lazy").trigger("sporty");
				    }, 2000);
				});
			}	
	 	}
	}
</script>
</div>

