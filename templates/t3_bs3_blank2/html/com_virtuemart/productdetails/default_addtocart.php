<?php
/**
 *
 * Show the product details page
 *
 * @package    VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_addtocart.php 6433 2012-09-12 15:08:50Z openglobal $
 */
// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');
if (isset($this->product->step_order_level))
	$step=$this->product->step_order_level;
else
	$step=1;
if($step==0)
	$step=1;
$alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step);
$show_price = $this->currency->createPriceDiv ('salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $this->product->prices);
if (!empty($show_price)){
if ((!VmConfig::get('use_as_catalog', 0) and !empty($this->product->prices['salesPrice'])) || $this->product->prices['salesPrice']<0) {
?>
<div class="addtocart-area2 proddet">

	<form method="post" class="product js-recalculate" action="<?php echo JRoute::_ ('index.php'); ?>">
    <input name="quantity" type="hidden" value="<?php echo $step ?>" />
    
    <?php
	$this->position = 'addtocart';
	//print_r($this->product);
	?>
		<div class="product-custom">
	<?php // Product custom_fields
	if (!empty($this->product->customfieldsSorted[$this->position])) { ?>
    	<div class="product-fields">
		<?php foreach ($this->product->customfieldsSorted[$this->position] as $field) {		?>
		    <div class="product-field product-field-type-<?php echo $field->field_type ?>">
            <div class="wrapper">
			<span class="product-fields-title" ><b><?php echo JText::_($field->custom_title) ?></b></span>
			<span class="product-field-display"><?php echo $field->display ?></span>
            </div>
			<span class="product-field-desc"><?php echo $field->custom_field_desc ?></span>
             <div class="clear"></div>
		    </div>
		    <?php
		}
		?>
    	</div>
         
	<?php } ?>
	 <div class="clear"></div>
    </div>
	<?php
        /* Product custom Childs
         * to display a simple link use $field->virtuemart_product_id as link to child product_id
         * custom_value is relation value to child
         */
    
        if (!empty($this->product->customsChilds)) {
            ?>
            <div class="product-fields">
        <?php foreach ($this->product->customsChilds as $field) {  ?>
                <div class="product-field product-field-type-<?php echo $field->field->field_type ?>">
                <span class="product-fields-title" ><b><?php echo JText::_($field->field->custom_title) ?></b></span>
                <span class="product-field-desc"><?php echo JText::_($field->field->custom_value) ?></span>
                <span class="product-field-display"><?php echo $field->display ?></span>
                </div><br />
            <?php } ?>
            </div>
    <?php } ?>

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

 					
<?php 
if (!empty($this->product->customfieldsSorted[$this->position])) { ?>
<div class="wrapper">
   						 <div class="controls">		

				<label for="quantity<?php echo $this->product->virtuemart_product_id; ?>" class="quantity_box"><?php echo JText::_ ('COM_VIRTUEMART_CART_QUANTITY'); ?>: </label> 
				 <span class="box-quantity">
            <span class="quantity-box">
		<input type="text" class="quantity-input js-recalculate" name="quantity[]" value="<?php if (isset($this->product->step_order_level) && (int)$this->product->step_order_level > 0) {
			echo $this->product->step_order_level;
		} else if(!empty($this->product->min_order_level)){
			echo $this->product->min_order_level;
		}else {
			echo '1';
		} ?>"/>
	    </span>
            <span class="quantity-controls js-recalculate">
        <i class="quantity-controls quantity-plus fa fa-caret-up"></i>
        <i class="quantity-controls quantity-minus fa fa-caret-down"></i>
	   </span>
            </span>
				<?php // Display the quantity box END ?>
		</div>
				<?php
				// Display the add to cart button
				?>
				<span class="addtocart_button2">
                <?php if ($this->product->orderable) { ?>
                    <button type="submit" value="<?php echo $button_lbl ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_ADD_TO');?>" class="addtocart-button cart-click"><i class="fa fa-shopping-cart"></i><?php echo JText::_('COM_VIRTUEMART_CART_ADD_TO'); ?><span>&nbsp;</span></button>
                    <?php }else { ?>
                    <span title="<?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT');?>" class="addtocart-button addtocart-button-disabled cart-click"><?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT'); ?></span>
                    <?php } ?>
                </span>
                <div class="clearfix"></div>
                <div class="product-actions">
              <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl3.php")){  ?>
             <div class="proddetb wishlist list_wishlists<?php echo $this->product->virtuemart_product_id;?>">
                <?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl3.php"); ?>
             </div>
           <?php } ?>       
             <?php if(is_file(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl3.php")){  ?>
             <div class="proddetb jClever compare_cat list_compare<?php echo $this->product->virtuemart_product_id;?>">
                <?php require(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl3.php"); ?>
             </div>
           <?php } ?>       
  			<?php
		// Ask a question about this product
			if (VmConfig::get('ask_question', 1) == '1') { 
			$askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component', FALSE);
			?>
			   <div class="ask-a-question">
					 <a class="ask-a-question askquestion2" data-fancybox-type="iframe" href="<?php echo $askquestion_url ?>" rel="nofollow" title="<?php echo JText::_('VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?>" >
                     <i class="fa fa-question-circle"></i>
					 <span class="action-name"><?php echo JText::_('VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></span>
                     </a>
					</div>
			<?php } ?>      
        		</div>
            </div>
				<?php } else { 
                	$stockhandle = VmConfig::get ('stockhandle', 'none');
			if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and ($this->product->product_in_stock - $this->product->product_ordered) < 1) { ?>
            <span class="addtocart_button2">
				<a class="addtocart-button hasTooltip" title="<?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?>" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id='.$this->product->virtuemart_product_id); ?>"><i class="fa fa-shopping-cart"></i><?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?><span></span></a>
                  </span>
                   <div class="clearfix"></div>
                   <div class="product-actions">
              <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl3.php")){  ?>
             <div class="wishlist list_wishlists<?php echo $this->product->virtuemart_product_id;?>">
                <?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl3.php"); ?>
             </div>
           <?php } ?>       
             <?php if(is_file(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl3.php")){  ?>
             <div class="jClever compare_cat list_compare<?php echo $this->product->virtuemart_product_id;?>">
                <?php require(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl3.php"); ?>
             </div>
           <?php } ?>       
  			<?php
		// Ask a question about this product
			if (VmConfig::get('ask_question', 1) == '1') { 
				$askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component', FALSE);
			?>
			   <div class="ask-a-question">
					 <a class="ask-a-question askquestion2" href="<?php echo $askquestion_url ?>" data-fancybox-type="iframe"  rel="nofollow" title="<?php echo JText::_('VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?>" >
                     <i class="fa fa-question-circle"></i>
					 <span class="action-name"><?php echo JText::_('VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></span>
                     </a>
					</div>
			<?php } ?>      
                </div>	

				<?php }else { ?>
					<div class="wrapper">
   						 <div class="controls">		

				<label for="quantity<?php echo $this->product->virtuemart_product_id; ?>" class="quantity_box"><?php echo JText::_ ('COM_VIRTUEMART_CART_QUANTITY'); ?>: </label> 
				 <span class="box-quantity">
            <span class="quantity-box">
		<input type="text" class="quantity-input js-recalculate" name="quantity[]" value="<?php if (isset($this->product->step_order_level) && (int)$this->product->step_order_level > 0) {
			echo $this->product->step_order_level;
		} else if(!empty($this->product->min_order_level)){
			echo $this->product->min_order_level;
		}else {
			echo '1';
		} ?>"/>
	    </span>
            <span class="quantity-controls js-recalculate">
		 <i class="quantity-controls quantity-plus fa fa-caret-up"></i>
        <i class="quantity-controls quantity-minus fa fa-caret-down"></i>
	   </span>
            </span>
				<?php // Display the quantity box END ?>
		</div>
				<?php
				// Display the add to cart button
				?>
				<span class="addtocart_button2">
                    <?php if ($this->product->orderable) { ?>
                    <button type="submit" value="<?php echo $button_lbl ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_ADD_TO');?>" class="addtocart-button cart-click"><i class="fa fa-shopping-cart"></i><?php echo JText::_('COM_VIRTUEMART_CART_ADD_TO'); ?><span>&nbsp;</span></button>
                    <?php }else { ?>
                    <span title="<?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT');?>" class="addtocart-button addtocart-button-disabled cart-click"><?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT'); ?></span>
                    <?php } ?>
                </span>
                 <div class="clearfix"></div>
                 <div class="product-actions">
                         <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl3.php")){  ?>
             <div class="wishlist list_wishlists<?php echo $this->product->virtuemart_product_id;?>">
                <?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl3.php"); ?>
             </div>
           <?php } ?>       
             <?php if(is_file(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl3.php")){  ?>
             <div class="jClever compare_cat list_compare<?php echo $this->product->virtuemart_product_id;?>">
                <?php require(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl3.php"); ?>
             </div>
           <?php } ?> 
            <?php
		// Ask a question about this product
			if (VmConfig::get('ask_question', 0) == 1) { 
		$askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component', FALSE);
		?>
			   <div class="ask-a-question">
					 <a class="ask-a-question askquestion2" data-fancybox-type="iframe" href="<?php echo $askquestion_url ?>" rel="nofollow" title="<?php echo JText::_('VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?>" >
                     <i class="fa fa-question-circle"></i>
					 <span class="action-name"><?php echo JText::_('VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></span>
                     </a>
					</div>
			<?php } ?> 
            </div>    
  
                		</div>
				<?php	} } ?>

			<div class="clear"></div>
		<input type="hidden" class="pname" value="<?php echo htmlentities($this->product->product_name, ENT_QUOTES, 'utf-8') ?>"/>
		<input type="hidden" name="option" value="com_virtuemart"/>
		<input type="hidden" name="view" value="cart"/>
		<noscript><input type="hidden" name="task" value="add"/></noscript>
        <input type="hidden" class="item_id" name="virtuemart_product_id[]" value="<?php echo $this->product->virtuemart_product_id ?>"/>
        <input type="hidden" name="virtuemart_category_id[]" value="<?php echo $this->product->virtuemart_category_id ?>" />
         </div>
	</form>

	<div class="clear"></div>
</div>
		<?php }  }?>
