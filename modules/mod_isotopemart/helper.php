<?php
/**
 * @author ITechnoDev, LLC
 * @copyright (C) 2014 - ITechnoDev, LLC
 * @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 **/

	defined ('_JEXEC') or  die('Direct Access to ' . basename (__FILE__) . ' is not allowed.');

	if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

	if (!class_exists ('VmConfig')) {
		require(JPATH_ADMINISTRATOR  .'/components/com_virtuemart/helpers/config.php');
	}
	VmConfig::loadConfig ();
	// Load the language file of com_virtuemart.
	JFactory::getLanguage ()->load ('com_virtuemart');
	if (!class_exists ('calculationHelper')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'calculationh.php');
	}
	if (!class_exists ('CurrencyDisplay')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'currencydisplay.php');
	}
	if (!class_exists ('VirtueMartModelVendor')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models' . DS . 'vendor.php');
	}
	if (!class_exists ('VmImage')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'image.php');
	}
	if (!class_exists ('shopFunctionsF')) {
		require(JPATH_SITE . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'shopfunctionsf.php');
	}
	if (!class_exists ('calculationHelper')) {
		require(JPATH_COMPONENT_SITE . DS . 'helpers' . DS . 'cart.php');
	}
	if (!class_exists ('VirtueMartModelProduct')) {
		JLoader::import ('product', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models');
	}

class ModIsotopeMartHelper 
{
	
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
    } 
 }
	
	function addtocartajax ($product, $modparams)
	{
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
    } 
		}
		
	
	public static function getScript(&$params,$moduleId)
	{
		$baseurl = JURI::base();

		$imgpath = $baseurl.'modules/mod_isotopemart/assets/img/load.gif' ;		
		$perpage = (int) $params->get('per_page',6) ;
		
		
		

		//return $script ;

	}

	
	function addtocartstyle ($product, $params)
	{
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

                <div class="addtocart-area2">
										<?php $stockhandle = VmConfig::get ('stockhandle', 'none');
			if (
				($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($product->product_in_stock - $product->product_ordered) < 1) || 
			(
			 ($product->product_in_stock - $product->product_ordered) < $product->min_order_level ))  { 
					  $url_not = JRoute::_('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id='.$product->virtuemart_product_id);
			  $url2_not = str_replace('modules/mod_isotopemart/assets/ajax/', '', $url_not);

			?>
           						  <span class="addtocart_button2">
											<a class="addtocart-button" href="<?php echo $url2_not; ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?>"><?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?><span>&nbsp;</span></a>
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
											if (!empty($product->customfieldsSorted[$position])) { 
											 $url_select = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id);
												$url2_select = str_replace('modules/mod_isotopemart/assets/ajax/', '', $url_select);
											?>
											<span class="attributes"><b>*</b> Product has attributes</span>
                                            <div class="addtocart_button2">
											<?php echo JHTML::link($url2_select, JText::_('DR_VIRTUEMART_SELECT_OPTION').'<span>&nbsp;</span>', array('title' =>JText::_('DR_VIRTUEMART_SELECT_OPTION'),'class' => 'addtocart-button')); ?>
                                      	  </div>
										
										<?php } else { ?>
										<span class="quantity-box">
											<input type="text" class="quantity-input js-recalculate" name="quantity[]" onblur="check(this);" value="<?php if (isset($product->step_order_level) && (int)$product->step_order_level > 0) {
			echo $product->step_order_level;
		} else if(!empty($product->min_order_level)){
			echo $product->min_order_level;
		}else {
			echo '1';
		} ?>"/>
										</span>
										<span class="quantity-controls">
											<input type="button" class="quantity-controls quantity-plus" />
											<input type="button" class="quantity-controls quantity-minus" />
										</span>
										<?php // Add the button
											$button_lbl = JText::_('COM_VIRTUEMART_CART_ADD_TO');
											$button_cls = 'addtocart-button cart-click'; //$button_cls = 'addtocart_button';
										?>
											<?php // Display the add to cart button ?>
											<div class="clear"></div>
											<span class="addtocart_button2">
												<?php if ($product->orderable) { ?>
                    <button type="submit" value="<?php echo $button_lbl ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_ADD_TO');?>" class="addtocart-button cart-click"><?php echo JText::_('COM_VIRTUEMART_CART_ADD_TO'); ?><span>&nbsp;</span></button>
                    <?php }else { ?>
                    <span title="<?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT');?>" class="addtocart-button addtocart-button-disabled cart-click"><?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT'); ?></span>
                    <?php } ?>
											</span>
                                            
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
     } 

		}
	
		
	function addtocartstyleajax ($product, $modparams)
	{
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

                <div class="addtocart-area2">
										<?php $stockhandle = VmConfig::get ('stockhandle', 'none');
			if (
				($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($product->product_in_stock - $product->product_ordered) < 1) || 
			(
			 ($product->product_in_stock - $product->product_ordered) < $product->min_order_level ))  { 
			$url_not = JRoute::_('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id='.$product->virtuemart_product_id);
			  $url2_not = str_replace('modules/mod_isotopemart/assets/ajax/', '', $url_not);
			?>
           						  <span class="addtocart_button2">
											<a class="addtocart-button" href="<?php echo $url2_not; ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?>"><?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?><span>&nbsp;</span></a>
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
											if (!empty($product->customfieldsSorted[$position])) { 
											$url_select = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id);
												$url2_select = str_replace('modules/mod_isotopemart/assets/ajax/', '', $url_select);
												//print_r($url2_select);
											?>
											<span class="attributes"><b>*</b> Product has attributes</span>
                                            <div class="addtocart_button2">
											<?php echo JHTML::link($url2_select, JText::_('DR_VIRTUEMART_SELECT_OPTION').'<span>&nbsp;</span>', array('title' =>JText::_('DR_VIRTUEMART_SELECT_OPTION'),'class' => 'addtocart-button')); ?>
                                      	  </div>
										
										<?php } else { ?>
										<span class="quantity-box">
											<input type="text" class="quantity-input js-recalculate" name="quantity[]" onblur="check(this);" value="<?php if (isset($product->step_order_level) && (int)$product->step_order_level > 0) {
			echo $product->step_order_level;
		} else if(!empty($product->min_order_level)){
			echo $product->min_order_level;
		}else {
			echo '1';
		} ?>"/>
										</span>
										<span class="quantity-controls">
											<input type="button" class="quantity-controls quantity-plus" />
											<input type="button" class="quantity-controls quantity-minus" />
										</span>
										<?php // Add the button
											$button_lbl = JText::_('COM_VIRTUEMART_CART_ADD_TO');
											$button_cls = 'addtocart-button cart-click'; //$button_cls = 'addtocart_button';
										?>
											<?php // Display the add to cart button ?>
											<div class="clear"></div>
											<span class="addtocart_button2">
												<?php if ($product->orderable) { ?>
                    <button type="submit" value="<?php echo $button_lbl ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_ADD_TO');?>" class="addtocart-button cart-click"><?php echo JText::_('COM_VIRTUEMART_CART_ADD_TO'); ?><span>&nbsp;</span></button>
                    <?php }else { ?>
                    <span title="<?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT');?>" class="addtocart-button addtocart-button-disabled cart-click"><?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT'); ?></span>
                    <?php } ?>
											</span>
                                            
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
     } 

	}
				

	public static function getProductList ($group = FALSE, $nbrReturnProducts = FALSE, $withCalc = TRUE, $onlyPublished = TRUE, $single = FALSE, $filterCategory = TRUE, $category_id = 0, $start = 0, $limit = 6)
	{
		$productModel  = VmModel::getModel('Product');
		
		$app = JFactory::getApplication ();
		if ($app->isSite ()) {
			$front = TRUE;

			$user = JFactory::getUser();
			if (!($user->authorise('core.admin','com_virtuemart') or $user->authorise('core.manage','com_virtuemart'))) {
				$onlyPublished = TRUE;
				if ($show_prices = VmConfig::get ('show_prices', 1) == '0') {
					$withCalc = FALSE;
				}
			}
		}
		else {
			$front = FALSE;
		}
		
			$productModel->setFilter ();
		
			if ($filterCategory === TRUE)
			{
				if ($category_id)
				{
					$productModel->virtuemart_category_id = $category_id;
				}
			}
			else
			{
				$productModel->virtuemart_category_id = FALSE;
			}
		
			$ids = ModIsotopeMartHelper::sortSearchListQuery ($onlyPublished, $productModel->virtuemart_category_id, $group, $nbrReturnProducts, $start, $limit);
			$products = $productModel->getProducts ($ids, $front, $withCalc, $onlyPublished, $single);
			//print_r($products);
			return $products;
		}
 
 
	public static function sortSearchListQuery ($onlyPublished = TRUE, $virtuemart_category_id = FALSE, $group = FALSE, $nbrReturnProducts = FALSE, $start = 0, $limit = 6) 
	{			
		    $productModel  = VmModel::getModel('Product');
			$app = JFactory::getApplication ();

			$groupBy = ' group by p.`virtuemart_product_id` ';

			$joinCategory = FALSE;
			$joinMf = FALSE;
			$joinPrice = FALSE;
			$joinCustom = FALSE;
			$joinShopper = FALSE;
			$joinChildren = FALSE;
			$joinLang = TRUE;
			$orderBy = ' ';
		
			$where = array();
			$useCore = TRUE;
			
			if ($productModel->searchplugin !== 0) 
			{
				JPluginHelper::importPlugin ('vmcustom');
				$dispatcher = JDispatcher::getInstance ();
				$PluginJoinTables = array();
				$ret = $dispatcher->trigger ('plgVmAddToSearch', array(&$where, &$PluginJoinTables, $productModel->searchplugin));
				
				foreach ($ret as $r) 
				{
					if (!$r) 
					{
						$useCore = FALSE;
					}
				}
			}
		
			if ($useCore) 
			{
				$isSite = $app->isSite ();
	 
				if (!empty($productModel->searchcustoms)) 
				{
					$joinCustom = TRUE;
					foreach ($productModel->searchcustoms as $key => $searchcustom) 
					{
						$custom_search[] = '(pf.`virtuemart_custom_id`="' . (int)$key . '" and pf.`custom_value` like "%' . $productModel->_db->getEscaped ($searchcustom, TRUE) . '%")';
					}
					$where[] = " ( " . implode (' OR ', $custom_search) . " ) ";
				}
		
				if ($onlyPublished) 
				{
					$where[] = ' p.`published`="1" ';
				}
		
				if($isSite and !VmConfig::get('use_as_catalog',0)) 
				{
					if (VmConfig::get('stockhandle','none')=='disableit_children') 
					{
						$where[] = ' (p.`product_in_stock` - p.`product_ordered` >"0" OR children.`product_in_stock` - children.`product_ordered` > "0") ';
						$joinChildren = TRUE;
					} 
					else if (VmConfig::get('stockhandle','none')=='disableit') 
					{
						$where[] = ' p.`product_in_stock` - p.`product_ordered` >"0" ';
					}
				}
		
				if ($virtuemart_category_id > 0) 
				{
					$joinCategory = TRUE;
					$where[] = ' `pc`.`virtuemart_category_id` = ' . $virtuemart_category_id;
				}
		
				if ($isSite and !VmConfig::get('show_uncat_child_products',TRUE)) 
				{
					$joinCategory = TRUE;
					$where[] = ' `pc`.`virtuemart_category_id` > 0 ';
				}
		
				if ($productModel->product_parent_id) 
				{
					$where[] = ' p.`product_parent_id` = ' . $productModel->product_parent_id;
				}
		
				if ($isSite) 
				{
					$usermodel = VmModel::getModel ('user');
					$currentVMuser = $usermodel->getUser ();
					$virtuemart_shoppergroup_ids = (array)$currentVMuser->shopper_groups;
		
					if (is_array ($virtuemart_shoppergroup_ids)) 
					{
						$sgrgroups = array();
						foreach ($virtuemart_shoppergroup_ids as $key => $virtuemart_shoppergroup_id) 
						{
							$sgrgroups[] = 's.`virtuemart_shoppergroup_id`= "' . (int)$virtuemart_shoppergroup_id . '" ';
						}
						$sgrgroups[] = 's.`virtuemart_shoppergroup_id` IS NULL ';
						$where[] = " ( " . implode (' OR ', $sgrgroups) . " ) ";
		
						$joinShopper = TRUE;
					}
				}
		
				if ($productModel->virtuemart_manufacturer_id) 
				{
					$joinMf = TRUE;
					$where[] = ' `#__virtuemart_product_manufacturers`.`virtuemart_manufacturer_id` = ' . $productModel->virtuemart_manufacturer_id;
				}
		

				if ($productModel->search_type != '') 
				{
					$search_order = $productModel->_db->getEscaped (JRequest::getWord ('search_order') == 'bf' ? '<' : '>');
					switch ($productModel->search_type) 
					{
						case 'parent':
							$where[] = 'p.`product_parent_id` = "0"';
							break;
						case 'product':
							$where[] = 'p.`modified_on` ' . $search_order . ' "' . $productModel->_db->getEscaped (JRequest::getVar ('search_date')) . '"';
							break;
						case 'price':
							$joinPrice = TRUE;
							$where[] = 'pp.`modified_on` ' . $search_order . ' "' . $productModel->_db->getEscaped (JRequest::getVar ('search_date')) . '"';
							break;
						case 'withoutprice':
							$joinPrice = TRUE;
							$where[] = 'pp.`product_price` IS NULL';
							break;
						case 'stockout':
							$where[] = ' p.`product_in_stock`- p.`product_ordered` < 1';
							break;
						case 'stocklow':
							$where[] = 'p.`product_in_stock`- p.`product_ordered` < p.`low_stock_notification`';
							break;
					}
				}

				switch ($productModel->filter_order) 
				{
					case 'product_special':
						if($isSite){
							$where[] = ' p.`product_special`="1" '; 
							$orderBy = 'ORDER BY p.`created_on` ';
						} else {
							$orderBy = 'ORDER BY `product_special`';
						}
		
						break;
					case 'category_name':
						$orderBy = ' ORDER BY `category_name` ';
						$joinCategory = TRUE;
						break;
					case 'category_description':
						$orderBy = ' ORDER BY `category_description` ';
						$joinCategory = TRUE;
						break;
					case 'mf_name':
						$orderBy = ' ORDER BY `mf_name` ';
						$joinMf = TRUE;
						break;
					case 'pc.ordering':
						$orderBy = ' ORDER BY `pc`.`ordering` ';
						$joinCategory = TRUE;
						break;
					case 'product_price':
						$orderBy = ' ORDER BY `product_price` ';
						$joinPrice = TRUE;
						break;
					case 'created_on':
						$orderBy = ' ORDER BY p.`created_on` ';
						break;
					default;
					if (!empty($productModel->filter_order)) {
						$orderBy = ' ORDER BY ' . $productModel->filter_order . ' ';
					}
					else {
						$productModel->filter_order_Dir = '';
					}
					break;
				}
		

				if ($group) 
				{
					$latest_products_days = VmConfig::get ('latest_products_days', 7);
					$latest_products_orderBy = VmConfig::get ('latest_products_orderBy','created_on');
					$groupBy = 'group by p.`virtuemart_product_id` ';
					switch ($group) {
						case 'featured':
							$where[] = 'p.`product_special`="1" ';
							$orderBy = 'ORDER BY p.`created_on` ';
							break;
						case 'latest':
							$date = JFactory::getDate (time () - (60 * 60 * 24 * $latest_products_days));
							$dateSql = $date->toMySQL ();
							$where[] = 'p.`' . $latest_products_orderBy . '` > "' . $dateSql . '" ';
							$orderBy = 'ORDER BY p.`' . $latest_products_orderBy . '`';
							$productModel->filter_order_Dir = 'DESC';
							break;
						case 'random':
							$orderBy = ' ORDER BY p.`created_on` ';  
							break;
						case 'topten':
							$orderBy = ' ORDER BY p.`product_sales` '; 
							$where[] = 'pp.`product_price`>"0.0" ';
							$productModel->filter_order_Dir = 'DESC';
							break;
						case 'recent':
							$rSession = JFactory::getSession();
							$rIds = $rSession->get('vmlastvisitedproductids', array(), 'vm');  
							return $rIds;
					}
					$joinPrice = TRUE;
					$productModel->searchplugin = FALSE;
				}
			}

			if ($joinLang) 
			{
				$select = ' l.`virtuemart_product_id` FROM `#__virtuemart_products_' . VMLANG . '` as l';
				$joinedTables[] = ' JOIN `#__virtuemart_products` AS p using (`virtuemart_product_id`)';
			}
			else 
			{
				$select = ' p.`virtuemart_product_id` FROM `#__virtuemart_products` as p';
				$joinedTables[] = '';
			}
		
			if ($joinCategory == TRUE) 
			{
				$joinedTables[] = ' LEFT JOIN `#__virtuemart_product_categories` as pc ON p.`virtuemart_product_id` = `pc`.`virtuemart_product_id`
			 LEFT JOIN `#__virtuemart_categories_' . VMLANG . '` as c ON c.`virtuemart_category_id` = `pc`.`virtuemart_category_id`';
			}
			if ($joinMf == TRUE) 
			{
				$joinedTables[] = ' LEFT JOIN `#__virtuemart_product_manufacturers` ON p.`virtuemart_product_id` = `#__virtuemart_product_manufacturers`.`virtuemart_product_id`
			 LEFT JOIN `#__virtuemart_manufacturers_' . VMLANG . '` as m ON m.`virtuemart_manufacturer_id` = `#__virtuemart_product_manufacturers`.`virtuemart_manufacturer_id` ';
			}
		
			if ($joinPrice == TRUE) 
			{
				$joinedTables[] = ' LEFT JOIN `#__virtuemart_product_prices` as pp ON p.`virtuemart_product_id` = pp.`virtuemart_product_id` ';
			}
			if ($productModel->searchcustoms) 
			{
				$joinedTables[] = ' LEFT JOIN `#__virtuemart_product_customfields` as pf ON p.`virtuemart_product_id` = pf.`virtuemart_product_id` ';
			}
			if ($productModel->searchplugin !== 0) 
			{
				if (!empty($PluginJoinTables)) 
				{
					$plgName = $PluginJoinTables[0];
					$joinedTables[] = ' LEFT JOIN `#__virtuemart_product_custom_plg_' . $plgName . '` as ' . $plgName . ' ON ' . $plgName . '.`virtuemart_product_id` = p.`virtuemart_product_id` ';
				}
			}
			if ($joinShopper == TRUE) 
			{
				$joinedTables[] = ' LEFT JOIN `#__virtuemart_product_shoppergroups` ON p.`virtuemart_product_id` = `#__virtuemart_product_shoppergroups`.`virtuemart_product_id`
			 LEFT  OUTER JOIN `#__virtuemart_shoppergroups` as s ON s.`virtuemart_shoppergroup_id` = `#__virtuemart_product_shoppergroups`.`virtuemart_shoppergroup_id`';
			}
		
			if ($joinChildren) 
			{
				$joinedTables[] = ' LEFT OUTER JOIN `#__virtuemart_products` children ON p.`virtuemart_product_id` = children.`product_parent_id` ';
			}
		
			if (count ($where) > 0) 
			{
				$whereString = ' WHERE (' . implode (' AND ', $where) . ') ';
			}
			else 
			{
				$whereString = '';
			}
			
			//$productModel->orderByString = $orderBy;
			
			 //var_dump($productModel->filter_order_Dir);
			 //die();
			
			
			$productModel->filter_order_Dir = 'DESC';
			
			/*
			if($productModel->_onlyQuery)
			{
				return (array($select,$joinedTables,$where,$orderBy));
			}
			*/
			
			$joinedTables = implode('',$joinedTables);
			$product_ids  = ModIsotopeMartHelper::exeSortSearchListQuery (2, $select, $joinedTables, $whereString, $groupBy, $orderBy, $productModel->filter_order_Dir, $nbrReturnProducts, $start, $limit);

			//var_dump($product_ids);
			//$product_ids = array_unique($product_ids);
			//print_r($product_ids);
			return $product_ids;
		
		}
		
		
	public static function exeSortSearchListQuery($object, $select, $joinedTables, $whereString = '', $groupBy = '', $orderBy = '', $filter_order_Dir = '', $nbrReturnProducts = false, $start = 0, $limit = 6)
	{
			    $productModel  = VmModel::getModel('Product');
			    $db			   =&  JFactory::getDBO();
				$joinedTables .= $whereString .$groupBy .$orderBy .$filter_order_Dir ;
 
			
				$productModel->_withCount = false;
			 
 
				$q = 'SELECT '.$select.$joinedTables;
			 
		 		//echo ($q);
		 		//die();
				
				$db->setQuery($q,$start,$limit);

				
				
				
			if($object == 2)
			{
				foreach($db->loadAssocList() as $productbd){
					$productModel->ids[] = $productbd['virtuemart_product_id'];
				}
				//var_dump ($productModel->ids);
			} 
		
 
			if(empty($productModel->ids))
			{
				$errors = $db->getErrorMsg();
				if( !empty( $errors))
				{
					vmdebug('exeSortSearchListQuery error in class '.get_class($productModel).' sql:',$db->getErrorMsg());
				}
				if($object == 2 or $object == 1)
				{
					$productModel->ids = array();
				}
			}
		
			return $productModel->ids;	
		}

}






