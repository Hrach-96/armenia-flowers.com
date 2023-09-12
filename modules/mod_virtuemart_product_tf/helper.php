<?php
defined('_JEXEC') or  die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/*
* Module Helper
*
* @package VirtueMart
* @copyright (C) 2010 - Patrick Kohl
* @ Email: cyber__fr|at|hotmail.com
*
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* VirtueMart is Free Software.
* VirtueMart comes with absolute no warranty.
*
* www.virtuemart.net
*/
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
if (!class_exists( 'VmConfig' )) require(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
VmConfig::loadConfig ();
// Load the language file of com_virtuemart.
JFactory::getLanguage()->load('com_virtuemart');
if (!class_exists( 'calculationHelper' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'calculationh.php');
if (!class_exists( 'CurrencyDisplay' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'currencydisplay.php');
if (!class_exists( 'VirtueMartModelVendor' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'models'.DS.'vendor.php');
if (!class_exists( 'VmImage' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'image.php');
if (!class_exists( 'shopFunctionsF' )) require(JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'shopfunctionsf.php');
if (!class_exists( 'calculationHelper' )) require(JPATH_COMPONENT_SITE.DS.'helpers'.DS.'cart.php');
if (!class_exists( 'VirtueMartModelProduct' )){
   JLoader::import( 'product', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models' );
}
   JLoader::import( 'ratings', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models' );

class mod_virtuemart_product_tf {

	function addtocart($product) {
					$currency = CurrencyDisplay::getInstance( );
		   $show_price = $currency->createPriceDiv('salesPrice', '', $product->prices,true);
			//print_r ($show_price);

if (!empty($show_price)){

          		 if ((!VmConfig::get('use_as_catalog', 0) and !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) {
					  if (isset($product->step_order_level))
							$step=$product->step_order_level;
						else
							$step=1;
						if($step==0)
							$step=1;
						$alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step); ?>

                <div class="addtocart-area2 add-to-cart">
										<?php $stockhandle = VmConfig::get ('stockhandle', 'none');
			if (
				($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($product->product_in_stock - $product->product_ordered) < 1) || 
			(
			 ($product->product_in_stock - $product->product_ordered) < $product->min_order_level ))  { ?>
           						  <span class="addtocart_button2">
											<a class="addtocart-button" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id='.$product->virtuemart_product_id); ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?>"><i class="fa fa-shopping-cart"></i><span class="action-name"><?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?></span></a>
                                            </span>
										<?php } else { ?>
										<form method="post" class="product" action="<?php echo JURI::getInstance()->toString(); ?>" id="addtocartproduct<?php echo $product->virtuemart_product_id ?>">
                                         <input name="quantity" type="hidden" value="<?php echo $step ?>" />
										<div class="addtocart-bar2">
                                        <script type="text/javascript">
												function check(obj) {
												// use the modulus operator '%' to see if there is a remainder
												remainder=obj.value % <?php echo $step?>;
												quantity=obj.value;
												if (remainder  != 0) {
													alert('<?php echo $alert?>!');
													obj.value = quantity-remainder;
													return false;
													}
												return true;
												}
										</script> 
											<?php // Display the quantity box 
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
											<?php echo JHTML::link($product->link, '<i class="fa fa-shopping-cart"></i><span class="action-name">'.JText::_('DR_VIRTUEMART_SELECT_OPTION').'</span>', array('title' =>JText::_('DR_VIRTUEMART_SELECT_OPTION'),'class' => 'addtocart-button')); ?>
                                      	  </div>
										
										<?php } else { ?>
										<?php // Add the button
											$button_lbl = JText::_('COM_VIRTUEMART_CART_ADD_TO');
											$button_cls = 'addtocart-button cart-click'; //$button_cls = 'addtocart_button';
										?>
											<?php // Display the add to cart button ?>
											<div class="clear"></div>
											<div class="addtocart_button2">
												<?php if ($product->orderable) { ?>
                    <button type="submit" value="<?php echo $button_lbl ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_ADD_TO');?>" class="addtocart-button cart-click"><i class="fa fa-shopping-cart"></i><span class="action-name"><?php echo JText::_('COM_VIRTUEMART_CART_ADD_TO'); ?></span></button>
                    <?php }else { ?>
                    <span title="<?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT');?>" class="addtocart-button addtocart-button-disabled cart-click"><i class="fa fa-shopping-cart"></i><span class="action-name"><?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT'); ?></span></span>
                    <?php } ?>
											</div>
                                            
										<input type="hidden" class="pname" value="<?php echo $product->product_name ?>"/>
										<input type="hidden" name="option" value="com_virtuemart" />
										<input type="hidden" name="view" value="cart" />
										<noscript><input type="hidden" name="task" value="add" /></noscript>
										 <input type="hidden" class="item_id" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>"/>
										<input type="hidden" name="virtuemart_category_id[]" value="<?php echo $product->virtuemart_category_id ?>" />	
										<?php }?>
									</div>
									</form>
									<?php } ?>
									</div>
        <?php }
     } }
}
 ?>

