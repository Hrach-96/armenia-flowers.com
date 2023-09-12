
<?php defined('_JEXEC') or die('Restricted access');
JHTML::_( 'behavior.modal' );
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
$show_prices = VmConfig::get ('show_prices', 1);
		if ($show_prices == '1') {
			if (!class_exists ('calculationHelper')) {
				require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'calculationh.php');
			}
		}

		$doc = JFactory::getDocument ();
// Separator
if (!class_exists( 'CurrencyDisplay' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'currencydisplay.php');

$verticalseparator = " vertical-separator";
$ratingModel = VmModel::getModel('ratings');
$productModel = VmModel::getModel('product');


$products['latest']= $productModel->getProducts('latest', $latest_products_count);
$productModel->addImages($products['latest'],2);

$products['topten']= $productModel->getProducts('topten', $topTen_products_count);
$productModel->addImages($products['topten'],2);

$recent_products = $productModel->getProducts('recent');
$productModel->addImages($products['recent'],2);

$products['featured'] = $productModel->getProducts('featured', $featured_products_count);
$productModel->addImages($products['featured'],2);

$customfieldsModel = VmModel::getModel ('Customfields');
	if (!class_exists ('vmCustomPlugin')) {
		require(JPATH_VM_PLUGINS . DS . 'vmcustomplugin.php');
	}
foreach ($this->products as $type => $productList ) {
// Calculating Products Per Row
$products_per_row = VmConfig::get ( $type.'_products_per_row', 1 ) ;

// Category and Columns Counter
$col = 1;
$nb = 1;

$productTitle = JText::_('COM_VIRTUEMART_'.$type.'_PRODUCT');

?>

<div class="<?php echo $type ?>-view">
	<h3 class="module-title"><?php echo $productTitle ?></h3>
<div id="product_list" class="grid ">
					<?php // Category and Columns Counter
					$counter = 0;
					$iBrowseCol = 1;
					$iBrowseProduct = 1;
					
					// Calculating Products Per Row
					$BrowseProducts_per_row = 1;
					$Browsecellwidth = ' width'.floor ( 100 / $BrowseProducts_per_row );
					
					// Separator
					$verticalseparator = " vertical-separator";
					?>
					<ul id="slider<?php echo $type ?>" class="owl-carousel vmproduct layout">
					
					<?php // Start the Output
   if (!empty($productList)) {
  
   
      if (!class_exists( 'CurrencyDisplay' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'currencydisplay.php');
      $currency = CurrencyDisplay::getInstance( );
      $count_holder = $type;
      $prod = array();
      $prod[0] = $productList;
      $productsLayout = VmConfig::get ('productsublayout', 'products');
    
     echo shopFunctionsF::renderVmSubLayout($productsLayout,array('products'=>$prod,'currency'=>$currency,'products_per_row'=>$products_per_row,'showRating'=>$showRating, 'count_holder'=>$count_holder));
    }?>
					</ul>
          <div class="clear"></div> 
</div>

</div>
<script type="text/javascript">
jQuery(document).ready(function() {

  
  if( (jQuery("#t3-mainbody .row .t3-sidebar-left").hasClass("t3-sidebar")) || (jQuery("#t3-mainbody .row .t3-sidebar-right").hasClass("t3-sidebar")) ) {
      jQuery("#slider<?php echo $type ?>").loveowlCarousel({
      items : 3,
      autoPlay : 12000,
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
        jQuery("#slider<?php echo $type ?> .product-box img.lazy").show().lazyload({
          effect : "fadeIn",
          event : "sporty"
       });
      jQuery(window).bind("load", function() {
        var timeout = setTimeout(function() {
            jQuery("#slider<?php echo $type ?> .product-box img.lazy").trigger("sporty");
        }, 3500);
      });
      }
   }else {
     jQuery("#slider<?php echo $type ?>").loveowlCarousel({
      items : 4,
      autoPlay : 12000,
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
          jQuery("#slider<?php echo $type ?> .product-box img.lazy").show().lazyload({
          effect : "fadeIn",
          event : "sporty"
       });
      jQuery(window).bind("load", function() {
        var timeout = setTimeout(function() {
            jQuery("#slider<?php echo $type ?> .product-box img.lazy").trigger("sporty");
        }, 3500);
      });
       }
    
   }
});
</script>
<?php } ?>
