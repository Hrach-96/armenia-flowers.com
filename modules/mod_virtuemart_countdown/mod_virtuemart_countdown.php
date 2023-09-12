<?php
/**
* @version		$Id: mod_virtuemart_countdown.php 2011-06-04 14:10:00Cecil Gupta $
* @package		Joomla
* @copyright	Copyright (C) 2011 Cecil Gupta. All rights reserved
* @license		GNU/GPL
*/
defined('_JEXEC') or die('Restricted access');

$document =& JFactory::getDocument();
$document->addStyleSheet("modules/mod_virtuemart_countdown/css/bzTimer.css");
	JHTML::script(JURI::base().'modules/mod_virtuemart_countdown/css/iview.pack.js');
	//$theme = (string)$params->get( 'theme', 1 );
	$opt_content = $app->input->getCmd('view', '');
	$timer_format = $params->get( 'time_format', "hours" );
	$modulesuffix = $params->get('moduleclass_sfx');
	$sale_text = $params->get( 'sale_text', "" );
	$product_id = $params->get( 'product_id', 22 );
	$show_price = (bool)$params->get( 'show_price', 1 );
	$show_addtocart = (bool)$params->get( 'show_addtocart', 1 );
	$debug_mode = (bool)$params->get( 'debug_mode', 0 );
	$component_suffix="";

if ($opt_content !== 'productdetails') {
$productArray = preg_split("/[\s,]+/", $product_id);
?>
<div id="slideShow" class="list">
<ul id="slider2">
<?php 

foreach($productArray as $product_index=>$product_ids){
	//print_r ($product_ids);
		$mainframe = Jfactory::getApplication();
		/* Load  VM function */
		if (!class_exists( 'mod_virtuemart_countdown' )) require('helper.php');
		$ratingModel = VmModel::getModel('ratings');
		$productModel = VmModel::getModel('Product');
		$product = $productModel->getProduct($product_ids);
		$productModel->addImages($product);
		$currency = CurrencyDisplay::getInstance();
		vmJsApi::jQuery();
		if ($show_addtocart) {
			vmJsApi::jPrice();
			vmJsApi::cssSite();
		}
				/* load the template */
		$product_in_stock = $product->product_in_stock;
		if(!empty($product)) {
			if($product_in_stock){
					if ($product->prices['override'] == 1 && ($product->prices['product_price_publish_down'] > 0)){
						require(JModuleHelper::getLayoutPath('mod_virtuemart_countdown'));
					}
			}
		}
}
?>
</ul>
<div class="clear" ></div>
</div>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
			$('#slideShow .hasTooltip').tooltip();
				$("#slideShow #slider2").responsiveSlides({
				  auto: true,             // Boolean: Animate automatically, true or false
				  speed: 800,            // Integer: Speed of the transition, in milliseconds
				  timeout: 12000,          // Integer: Time between slide transitions, in milliseconds
				  pager: true,           // Boolean: Show pager, true or false
				  nav: true,             // Boolean: Show navigation, true or false
				  random: false,          // Boolean: Randomize the order of the slides, true or false
				  pause: true,           // Boolean: Pause on hover, true or false
				  pauseControls: true,    // Boolean: Pause when hovering controls, true or false
				  maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
				  navContainer: "",       // Selector: Where controls should be appended to, default is after the 'ul'
				  manualControls: "",     // Selector: Declare custom pager navigation
				  namespace: "space",   // String: Change the default namespace used
				  before: function(){},   // Function: Before callback
				  after: function(){}     // Function: After callback
				});
				
			});
		</script>
<?php } ?>