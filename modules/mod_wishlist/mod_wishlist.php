<?php
/**
 * @package     Joomla.Tutorials
 * @subpackage  Module
 * @copyright   (C) 2012 http://jomla-code.ru
 * @license     License GNU General Public License version 2 or later; see LICENSE.txt
 */ 
// No direct access.
defined('_JEXEC') or die('Restricted access');
//error_reporting('E_ALL');
defined('_JEXEC') or  die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
	if (!class_exists( 'mod_wishlist' )) require('helper.php');
$user =& JFactory::getUser();
$ratingModel = VmModel::getModel('ratings');
$product_model = VmModel::getModel('product');
if ($user->guest) {
	if (!empty($_SESSION['id'])){
	$products = $_SESSION['id'];
		//unset($_SESSION['ids']);
	
	$prods = $product_model->getProducts($products);
	$product_model->addImages($prods,1);
	$currency = CurrencyDisplay::getInstance();
	}
}else {
   $db =& JFactory::getDBO();
	   $q ="SELECT virtuemart_product_id FROM #__wishlists WHERE userid =".$user->id;
		$db->setQuery($q);
		$allproducts = $db->loadAssocList();
		foreach($allproducts as $productbd){
			$allprod['id'][] = $productbd['virtuemart_product_id'];
		}
		//var_dump ($allproducts);
	//var_dump (count($allprod['id']));
	$product = $allprod['id'];
	$prods = $product_model->getProducts($product);
	$product_model->addImages($prods,1);
	$currency = CurrencyDisplay::getInstance();
}
require JModuleHelper::getLayoutPath('mod_wishlist', $params->get('layout', 'default'));
?>