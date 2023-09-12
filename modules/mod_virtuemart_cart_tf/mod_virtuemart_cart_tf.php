<?php
defined('_JEXEC') or  die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/*
*Cart Ajax Module
*
* @version $Id: mod_virtuemart_cart.php 8324 2014-09-24 17:30:33Z Milbo $
* @package VirtueMart
* @subpackage modules
*
* www.virtuemart.net
*/
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
if (!class_exists( 'VmConfig' )) require(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
VmConfig::loadConfig();
vmJsApi::addJScript("/modules/mod_virtuemart_cart_tf/assets/js/update_cart.js",false,false);

$doc = JFactory::getDocument();
$jsVars  = ' jQuery(document).ready(function(){
	jQuery("#vmCartModule").productUpdate();

});' ;
//This is strange we have the whole thing again in controllers/cart.php public function viewJS()
if(!class_exists('VirtueMartCart')) require(JPATH_VM_SITE.DS.'helpers'.DS.'cart.php');
require_once JPATH_ROOT .'/plugins/system/vm2_cart/vm2_cart.php';

$plg=new plgSystemVM2_Cart(JDispatcher::getInstance(),array());
$data=$plg->prepareAjaxData();


VmConfig::loadJLang('mod_virtuemart_cart_tf', true);
VmConfig::loadJLang('com_virtuemart', true);

//$lang = JFactory::getLanguage();
//$extension = 'mod_virtuemart_cart_tf';

if ($data->totalProduct>1) $data->totalProductTxt = JText::sprintf('ART_VIRTUEMART_CART_X_PRODUCTS', $data->totalProduct);
else if ($data->totalProduct == 1) $data->totalProductTxt = JText::_('ART_VIRTUEMART_ITEM');
else $data->totalProductTxt = JText::_('ART_VIRTUEMART_EMPTY_CART');
$data->totalProductTxt = '<span class="cart_num"><span class="art-text">'.JText::_('ART_VIRTUEMART_NOW_IN_YOUR_CART').'</span><a href="' . JRoute::_('#cart-toggle') . '"> <i class="fa fa-shopping-cart"></i>
' . $data->totalProductTxt . '</a></span>';

if (false && $data->dataValidated == true) {
	$taskRoute = '&task=confirm';
	$linkName = JText::_('COM_VIRTUEMART_CART_CONFIRM');
} else {
	$taskRoute = '';
	$linkName = JText::_('COM_VIRTUEMART_CART_SHOW');
}
$useSSL = VmConfig::get('useSSL',0);
$useXHTML = true;

$linkName2 = JText::_('COM_VIRTUEMART_VIEW_CART');
$linkName3 = JText::_('COM_VIRTUEMART_CHECKOUT');

			$data->cart_show = '
			<form id="cart_post" action="'  .JRoute::_("index.php?option=com_virtuemart&view=cart").'" method="post">
			<button type="submit" name="bascket" value="true" class="button reset">'.$linkName2.'<span>&nbsp;</span></button>
			</form>
			<a class="button" href="'  .JRoute::_("index.php?option=com_virtuemart&view=cart".$taskRoute,$useXHTML,$useSSL). '">' . $linkName3 . '</a>';
			$data->billTotal = '' . $data->billTotal . '';
			
			$data->taxTotal = '<div class="total3"><span>'.JText::_('ART_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT').':</span>'.'<strong>' . $data->taxTotal . '</strong></div>';
			$data->discTotal = '<div class="total4"><span>'.JText::_('ART_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT').':</span>'.'<strong>' . $data->discTotal . '</strong></div>';


$URLOriginal = JURI::base();
$module_base = $URLOriginal . 'modules/mod_virtuemart_cart_tf/tmpl/';
vmJsApi::jQuery();
vmJsApi::jPrice();
vmJsApi::cssSite();
$document = JFactory::getDocument();
//$document->addScript(JUri::base().'modules/mod_virtuemart_cart/assets/jquery.mCustomScrollbar.js');
$document->addStyleSheet(JUri::base().'modules/mod_virtuemart_cart_tf/assets/jquery.mCustomScrollbar.css');

//$document->addScriptDeclaration($jsVars);
$moduleclass_sfx 	= $params->get('moduleclass_sfx', '');
$show_product_list 	= (bool)$params->get( 'show_product_list', '1' ); // Display the Product Price?
$widthdropdown		= (float)$params->get( 'widthdropdown', '320' );
$limitcount		= (float)$params->get( 'limitcount', '6' );

$width		= (float)$params->get( 'width', '60px' );
$height		= (float)$params->get( 'height', '60px' );

$show_scrollbar		= (bool)$params->get( 'show_scrollbar', '1' );
$height_scrollbar	= (float)$params->get( 'height_scrollbar', '288' );


$document->addScriptDeclaration('var show_scrollbar="'.$show_scrollbar.'";var height_scrollbar="'.$height_scrollbar.'";var limitcount="'.$limitcount.'";');
if(!$show_scrollbar){
	$height_scrollbar = 'auto';
}else{
	$height_scrollbar = $height_scrollbar.'px';
}
/* Laod tmpl default */
//JHTML::script(JURI::base().'modules/mod_virtuemart_cart/assets/vmprices2.js');
//JHTML::script(JURI::base().'modules/mod_virtuemart_cart/assets/allscripts.js');


$moduleclass_sfx = $params->get('moduleclass_sfx', '');
$show_price = (bool)$params->get( 'show_price', 1 ); // Display the Product Price?
$show_product_list = (bool)$params->get( 'show_product_list', 1 ); // Display the Product Price?
echo vmJsApi::writeJS();
/* Laod tmpl default */
require(JModuleHelper::getLayoutPath('mod_virtuemart_cart_tf', $params->get('layout', 'default')));
 ?>