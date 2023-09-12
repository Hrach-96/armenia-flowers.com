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
 * @version $Id: default_relatedproducts.php 6431 2012-09-12 12:31:31Z alatak $
 */

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );
$app = JFactory::getApplication();
$templateparams = $app->getTemplate(true)->params;
$politeloading = $templateparams->get('politeloading');

	if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

if (!class_exists( 'CurrencyDisplay' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'currencydisplay.php');
?>
<div class="product-related">

<h3 class="module-title"><?php  echo JText::_('COM_VIRTUEMART_RELATED_PRODUCTS'); ?></h3>
 <div class="product-related-products vmgroup_new">
    <?php
		

	if(!isset($releted))
	$releted = array();
	$related = $viewData['related'];
	//$releted = array();
    foreach ($this->product->customfieldsSorted['related_products'] as $field) {
		$releted[] = $field->customfield_value;
	 } 
	 //var_dump($releted);
	 	$productModel = VmModel::getModel('product');
	 	$products_rel = $productModel->getProducts($releted);
		$productModel->addImages($products_rel); 
		$ratingModel = VmModel::getModel('ratings');
		$mainframe = Jfactory::getApplication();
		$virtuemart_currency_id = $mainframe->getUserStateFromRequest( "virtuemart_currency_id", 'virtuemart_currency_id',JRequest::getInt('virtuemart_currency_id',0) );
		//$currency = CurrencyDisplay::getInstance( );
	 ?>
			<div class="list_carousel responsive">
			<div class="slide_box_width">
				<div class="prod_box slide_box">
	
                
                <ul id="sliderrelated" class="vmproduct layout"> 

                 <?php

				   if (!empty($products_rel)) {
				  
				      if (!class_exists( 'CurrencyDisplay' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'currencydisplay.php');
				      $currency = CurrencyDisplay::getInstance( );
				      $count_holder = 'related';
				      $products_per_row = 1;
				      $prod = array();
				      $prod[0] = $products_rel;
				      $productsLayout = VmConfig::get ('productsublayout', 'products');
				    
				     echo shopFunctionsF::renderVmSubLayout($productsLayout,array('products'=>$prod,'currency'=>$currency,'products_per_row'=>$products_per_row,'showRating'=>$showRating, 'count_holder'=>$count_holder));
				    }?>	
                	
                
		
</ul>
   </div></div>             
</div>
</div></div>
