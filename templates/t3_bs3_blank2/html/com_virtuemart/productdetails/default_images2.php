<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen

 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_images.php 6188 2012-06-29 09:38:30Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
	$app = JFactory::getApplication();
	$doc = JFactory::getDocument();
    $templateparams = $app->getTemplate('site')->params;
	$politeloading = $templateparams->get('politeloading');
    $lblsale = $templateparams->get('lblsale');
    $lblhot = $templateparams->get('lblhot');
    $lblhotcount = $templateparams->get('lblhotcount');
    $lbloffer = $templateparams->get('lbloffer');
    $lblsold = $templateparams->get('lblsold');
    $lblnew = $templateparams->get('lblnew');
    $latest_products_days = $templateparams->get('lblnewcount');
	$template = $app->getTemplate();
	$gpath = $this->baseurl."/templates/".$template ;
	
	$on_off = 'window';
		// $on_off;
		$jsvm='
		var show_img="'.$on_off.'" 
		function Zoom() {
			jQuery("#Img_zoom2").elevateZoom({
			gallery:"gallery_02" , 
			cursor: "crosshair" , 
			zoomType : "inner",
			zoomWindowPosition: 1, 
			zoomWindowOffetx: 10,
			zoomWindowHeight: 360, 
			 zoomWindowWidth:360,
			 zoomWindowFadeIn: 500,
			zoomWindowFadeOut: 500,
			lensFadeIn: 500,
			lensFadeOut: 500,
			showLens:true,
			containLensZoom :false,
			 easing : true, 
			 galleryActiveClass: "zoomThumbActive active", 
			 loadingIcon: "images/preloader.gif"
			 }); 
		jQuery("#Img_zoom2").bind("click", function(e) {  
		  var ez =   jQuery("#Img_zoom2").data("elevateZoom");	
			jQuery.fancybox(ez.getGalleryList());
		  return false;
		});
		 jQuery("#carousel2").loveowlCarousel({
			items : 4,
			 itemsDesktop : [1199,3], //5 items between 1000px and 901px
			itemsDesktopSmall : [991,3], // betweem 900px and 601px
			itemsTablet: [767,3], //2 items between 600 and 0
			itemsMobile : [460,2], // itemsMobile disabled - inherit from itemsTablet option
			stopOnHover : true,
			lazyLoad : false,
			pagination : false,
			navigation : true,
			 navigationText: [
			"<i class=\'fa fa-caret-left\'></i>",
			"<i class=\'fa fa-caret-right\'></i>"
			]
			
			}); 
}

		';
		$doc->addScriptDeclaration($jsvm);
		$doc->addScript($gpath.'/js/prodstyle/more_custom.js');
		$doc->addScript($gpath.'/js/prodstyle/custom_js.js');
		$doc->addStyleSheet($gpath.'/css/prodstyle/jquery.jqzoom.css');
		//$doc = JFactory::getDocument();
		
    ?>
    <div class="image_show">
    <?php   
        $images = $this->product->images;
        $main_image_url = JURI::root().''.$images[0]->file_url;// [file_title][file_description][file_meta]
        $main_image_url2 = JURI::root().''.$images[0]->file_url_thumb;
            if ($images[0]->published){
                $main_image_url = JURI::root(true).'/'.$images[0]->file_url;
            }else {
                $main_image_url = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
                }
                
            if ($images[0]->published){
                $main_image_url2 = JURI::root(true).'/'.$this->product->images[0]->getFileUrlThumb();
            }else {
                $main_image_url2 = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
                }

        $main_image_title = $images[0]->file_title;// [file_title][file_description][file_meta]
        $main_image_description = $images[0]->file_description;// [file_title][file_description][file_meta]
        $main_image_alt = $images[0]->file_meta;// [file_title][file_description][file_meta]
        $vm_id = $this->product->virtuemart_product_id;
        $discont = $this->product->prices['discountAmount'];
        $discont = abs($discont);
        if (!empty($this->product->images[0])) {
    ?>
    <div class="main-image horizont">
    	<div class='zoomlupa photo'></div>
     <div class="lbl-box2">
        <?php
        error_reporting('E_ALL');
        //var_dump($product->created_on);
        //$dataNew = explode(' ', $this->product->created_on);
        //$dataNew=$dataNew[0];
        //$dataNewOut = date('Y-m-d', strtotime($dataNew . " + ".$latest_products_days." day"));
        if($lblnew){
            $str_date = explode(' ', $this->product->created_on);
            $dataN = explode("-", $str_date[0]);
            $dataNew =  mktime(0, 0, 0, $dataN[1],$dataN[2], $dataN[0]);
            $dataNewOut = $dataNew + 60*60*24*$latest_products_days;
        }
        //var_dump($dataNew).'</br>';
        //var_dump($dataNewOut);
        $stockhandle = VmConfig::get ('stockhandle', 'none');
        if ((($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($this->product->product_in_stock - $this->product->product_ordered) < 1) || 
                (($this->product->product_in_stock - $this->product->product_ordered) < $this->product->min_order_level ))&& $lblsold)  { ?>
           
            <div class="sold"><?php echo JText::_('DR_SOLD');?></div>
         <?php }elseif ((time() - $result < $dataNewOut ) && $lblnew ){ ?>
               
             <div class="new"><?php echo JText::_('DR_NEW');?></div>
         <?php } ?>   
             
         </div>
    <div class="lbl-box">
        <?php if ($lbloffer && $this->product->prices['override'] == 1 && ($this->product->prices['product_price_publish_down'] > 0)){ ?>
        <div class="discount limited"><?php echo JText::_('DR_LIMITED_OFFER');?></div>
          <?php } elseif($discont >0 && $this->product->product_sales < $lblhotcount && $lblsale ) { ?>
        <div class="discount"><?php echo JText::_('DR_SALE');?></div>
            <?php } elseif ($lblhot && $this->product->product_sales > $lblhotcount) {?>
              <div class="hit"><?php echo JText::_('DR_HOT');?></div>
              <?php } ?>
              </div>
        <img  src="<?php echo $main_image_url ?>" data-zoom-image="<?php echo $main_image_url ?>"  title="<?php echo $main_image_title ?>"   alt="<?php echo $main_image_alt ?>" class="big_img" id="Img_zoom2"/>
               
    </div>
     <?php 
         $j = count($images);
        //add HTML
        if($j <= 1){ $class='none';}else{$class='';}
		 if($j == 1){ $classimg=' noneimg';}else{$classimg='';}
		if($j >0){ ?>
			<div class="jcarousel-container horizont clearfix <?php echo $class.$classimg ?>">
            <div id="gallery_02" class="jcarousel jcarousel-container  additional-images <?php echo $class; ?>">
                <ul id="carousel2" class="paginat prod">
                <?php 
                    for($i=0; $i<$j; $i++){ 
                if ($this->product->images[$i]->published){
                    $main_image_url = JURI::root(true).'/'.$this->product->images[$i]->file_url;
                }else {
                    $main_image_url = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
                }
                if ($this->product->images[$i]->published){
                    $main_image_url_th = JURI::root(true).'/'. $this->product->images[$i]->getFileUrlThumb();
                }else {
                    $main_image_url_th = JURI::root(true).'/components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
                } ?>
                 <li class="floatleft"><a class="thumb" href="#" data-image="<?php echo $main_image_url; ?>" data-zoom-image="<?php echo $main_image_url; ?>">
                    <img alt="<?php echo $images[$i]->file_meta; ?>" title="<?php echo $images[$i]->file_meta; ?>" src="<?php echo $main_image_url_th; ?>" />
                 </a></li>
                
    <?php       }   
        ?>
        </ul>
        </div>
        </div>
        <?php  } ?>

<?php } // Product Main Image END ?>

        <div class="clear"></div>
    </div>