<?php 
defined( '_JEXEC' ) or die;
JHtml::_('behavior.modal');
if (!class_exists( 'shopFunctionsF' )) require(JPATH_SITE.'/components/com_virtuemart/helpers/shopfunctionsf.php');

$user =& JFactory::getUser();
$mainframe = Jfactory::getApplication();
$virtuemart_currency_id = $mainframe->getUserStateFromRequest( "virtuemart_currency_id", 'virtuemart_currency_id',JRequest::getInt('virtuemart_currency_id',0) );
error_reporting('E_ALL');
if (!$user->guest) {
					//var_dump ($_SESSION['id']);

				if (isset($_SESSION['id'])) {
					$dbIds = $_SESSION['id'];
					$db =& JFactory::getDBO();
					$q ="SELECT virtuemart_product_id FROM #__wishlists WHERE userid =".$user->id;
					$db->setQuery($q);
					$allproducts = $db->loadAssocList();
					foreach($allproducts as $productbd){
						$allprod['ids'][] = $productbd['virtuemart_product_id'];
					}
					//var_dump ($allproducts);
					$sessionWP = isset($allprod['ids']) ? $allprod['ids'] : array();
					for($r=0; $r<count($dbIds); $r++) {
						if(!in_array($dbIds[$r],$allprod['ids'])) {
					   $q = "";
						$q = "INSERT INTO `#__wishlists`
								(virtuemart_product_id,userid )
								VALUES
								('".$dbIds[$r]."','".$user->id."') ";
								//var_dump ($dbIds[$r]);
						$db->setQuery($q);
						//$db->queryBatch();
						$db->query();
					   }
				   }
				//unset($_SESSION['id']);
			   }
		   }
		   
$document = JFactory::getDocument();
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

$ratingModel = VmModel::getModel('ratings');
$product_model = VmModel::getModel('product');
	if (!$user->guest) {
	 	   $db =& JFactory::getDBO();
		   $q ="SELECT virtuemart_product_id FROM #__wishlists WHERE userid =".$user->id;
		   $db->setQuery($q);
		   $allproducts = $db->loadAssocList();
			foreach($allproducts as $productbd){
				$allprod['id'][] = $productbd['virtuemart_product_id'];
			}
				$products=$allprod['id'];
	   }else {
		   		$products=$_SESSION['id'];
		   }
	   

  $prods = $product_model->getProducts($products);
$product_model->addImages($prods,2);
if ($prods) {
	$currency = CurrencyDisplay::getInstance();
}
//var_dump ($prods);

?>
<div class="wishlist_box">
<div class="wishlist_info">
<h3 class="module-title">
	<?php echo JText::_('COM_WISHLIST_PRODUCT') ?>
	<?php // Back To Category Button
	if ($virtuemart_category_id) {
		$catURL =  JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$virtuemart_category_id);
		$categoryName = $product->category_name ;
	} else {
		$catURL =  JRoute::_('index.php?option=com_virtuemart&view=virtuemart');
		$categoryName = jText::_('COM_VIRTUEMART_SHOP_HOME');
	}
	?>
	
	<div class="back-to-category" >
    	<a href="<?php echo $catURL ?>" class="button_back button reset2" title="<?php echo $categoryName ?>"><i class="fa fa-reply"></i></a>
	</div>
</h3>
</div>

    <div class="clear"></div>
    	<?php
	if (!empty($prods)) { ?>

<div id="product_list" class="list">
					<ul id="slider" class="vmproduct layout">
						<div class="li">
						  <?php
						  if (!empty($prods)) {
						    if (!class_exists( 'CurrencyDisplay' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'currencydisplay.php');
						    $currency = CurrencyDisplay::getInstance( );
						    $count_holder_wishlist = 'count_holder_wishlist';
						    $remove_wishlist = 'remove_wishlist';
						    $products_per_row = '1';
						    $prod = array();
						    $prod[0] = $prods;
						    $productsLayout = VmConfig::get ('productsublayout', 'products');
						  
						   echo shopFunctionsF::renderVmSubLayout($productsLayout,array('products'=>$prod,'currency'=>$currency,'products_per_row'=>$products_per_row,'showRating'=>$showRating, 'count_holder_wishlist'=>$count_holder_wishlist, 'remove_wishlist'=>$remove_wishlist));
						  }
						  ?>
						</div>
					</ul>
</div>
<div class="clear"></div>      
  <?php  

	echo '<h3 class="module-title wishlists no-products" style="display:none;"><i class="fa fa-info-circle"></i>'.JText::_('COM_VIRTUEMART_ITEMS_NO_PRODUCTS_WHISHLIST').'</h3>';
	} else { echo '<h3 class="module-title no-products"><i class="fa fa-info-circle"></i>'.JText::_('COM_VIRTUEMART_ITEMS_NO_PRODUCTS_WHISHLIST').'</h3>';}
?>
</div>

<script type="text/javascript">
function tooltip(){
	jQuery('#product_list.list .hasTooltip').tooltip();
}
 jQuery(document).ready(function($) {
	//tooltip();
	if (notPoliteLoading =='1'){
		$("#product_list .prod-row img.lazy").lazyload({
			effect : "fadeIn"
		});
	}	
});
</script>

