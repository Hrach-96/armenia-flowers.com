<?php
/**
 *
 * Show the product details page
 *
 * @package    VirtueMart
 * @subpackage
 * @author Max Milbers
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2015 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_addtocart.php 7833 2014-04-09 15:04:59Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
$product = $viewData['product'];

if(isset($viewData['rowHeights'])){
	$rowHeights = $viewData['rowHeights'];
} else {
	$rowHeights['customfields'] = TRUE;
}

$init = 1;
if(isset($viewData['init'])){
	$init = $viewData['init'];
}

if(!empty($product->min_order_level) and $init<$product->min_order_level){
	$init = $product->min_order_level;
}

$step=1;
if (!empty($product->step_order_level)){
	$step=$product->step_order_level;
	if(!empty($init)){
		if($init<$step){
			$init = $step;
		} else {
			$init = ceil($init/$step) * $step;

		}
	}
	if(empty($product->min_order_level) and !isset($viewData['init'])){
		$init = $step;
	}
}

$maxOrder= '';
if (!empty($product->max_order_level)){
	$maxOrder = ' max="'.$product->max_order_level.'" ';
}

$addtoCartButton = '';
if(!VmConfig::get('use_as_catalog', 0)){
	if(!$product->addToCartButton and $product->addToCartButton!==''){
		$addtoCartButton = shopFunctionsF::getAddToCartButton ($product->orderable);
	} else {
		$addtoCartButton = $product->addToCartButton;
	}

}
$position = 'addtocart';
//if (!empty($product->customfieldsSorted[$position]) or !empty($addtoCartButton)) {


if (!VmConfig::get('use_as_catalog', 0)  ) { ?>

	<div class="addtocart-bar">
	<?php
	// Display the quantity box
	$stockhandle = VmConfig::get ('stockhandle', 'none');
	if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and ($product->product_in_stock - $product->product_ordered) < 1) { ?>
		 <span class="addtocart_button2">
			<a class="hasTooltips addtocart-button" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id='.$product->virtuemart_product_id); ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?>"><i class="fa fa-shopping-cart"></i><span class="action-name"><?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?></span></a>
            </span><?php
	} else {
		 if (!empty($product->customfields)) {
				foreach ($product->customfields as $k => $custom) {
					if (!empty($custom->layout_pos)) {
						$product->customfieldsSorted[$custom->layout_pos][] = $custom;
						unset($product->customfields[$k]);
					}
				}
				$product->customfieldsSorted['normal'] = $product->customfields;
				unset($product->customfields);
			}
		$position = 'addtocart';
		if (!empty($product->customfieldsSorted[$position])) { ?>
	        <div class="addtocart_button2">
			<?php echo JHTML::link($product->link, '<i class="fa fa-shopping-cart"></i><span class="action-name">'.JText::_('DR_VIRTUEMART_SELECT_OPTION').'</span>', array('title' =>JText::_('DR_VIRTUEMART_SELECT_OPTION'),'class' => 'addtocart-button hasTooltips')); ?>
	  	  	</div>
	
		<?php } else {
			$tmpPrice = (float) $product->prices['costPrice'];
			if (!( VmConfig::get('askprice', true) and empty($tmpPrice) ) ) { 
				 if ($product->orderable) { ?>
				<div class="controls hidden" style="display:none;">		
				<label for="quantity<?php echo $product->virtuemart_product_id; ?>" class="quantity_box"><?php echo JText::_ ('COM_VIRTUEMART_CART_QUANTITY'); ?>: </label>
				<span class="box-quantity">
				 
				<span class="quantity-box">
					<input type="text" class="quantity-input js-recalculate" name="quantity[]"
						data-errStr="<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED')?>"
						value="<?php echo $init; ?>" init="<?php echo $init; ?>" step="<?php echo $step; ?>" <?php echo $maxOrder; ?> />
				</span>
				<span class="quantity-controls js-recalculate">
			        <i class="quantity-controls quantity-plus fa fa-caret-up"></i>
			        <i class="quantity-controls quantity-minus fa fa-caret-down"></i>
			   	</span>
				 </span>
				</div> 
			<?php } 
				if(!empty($addtoCartButton)){
					?><span class="addtocart_button2">
					<?php echo $addtoCartButton ?>
					</span> <?php
				} ?>
				<input type="hidden" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>"/>
				<noscript><input type="hidden" name="task" value="add"/></noscript> <?php
			}
		}	
	} ?>

	</div><?php
} ?>
