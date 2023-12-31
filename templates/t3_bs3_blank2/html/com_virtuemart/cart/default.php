<?php
/**
 *
 * Layout for the shopping cart
 *
 * @package    VirtueMart
 * @subpackage Cart
 * @author Max Milbers
 *
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: cart.php 2551 2010-09-30 18:52:40Z milbo $
 */

// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');

JHtml::_ ('behavior.formvalidation');
$user = JFactory::getUser();
vmJsApi::addJScript('vm.STisBT',"
	jQuery(document).ready(function($) {

		if ( $('#STsameAsBTjs').is(':checked') ) {
			$('#output-shipto-display').hide();
		} else {
			$('#output-shipto-display').show();
		}
		$('#STsameAsBTjs').click(function(event) {
			if($(this).is(':checked')){
				$('#STsameAsBT').val('1') ;
				$('#output-shipto-display').hide();
			} else {
				$('#STsameAsBT').val('0') ;
				$('#output-shipto-display').show();
			}
			var form = jQuery('#checkoutFormSubmit');
			document.checkoutForm.submit();
		});
	});
");

vmJsApi::addJScript('vm.checkoutFormSubmit','
	jQuery(document).ready(function($) {
		jQuery(this).vm2front("stopVmLoading");
		jQuery("#checkoutFormSubmit").bind("click dblclick", function(e){
			jQuery(this).vm2front("startVmLoading");
			e.preventDefault();
			jQuery(this).attr("disabled", "true");
			jQuery(this).removeClass( "vm-button-correct" );
			jQuery(this).addClass( "vm-button" );
			jQuery(this).fadeIn( 400 );
			var name = jQuery(this).attr("name");
			$("#checkoutForm").append("<input name=\""+name+"\" value=\"1\" type=\"hidden\">");
			$("#checkoutForm").submit();
		});
	});
');

$this->addCheckRequiredJs();
 ?>

<div class="cart-view">
	<div class="vm-cart-header-container">
		
	
		<div class="clear"></div>
	</div>
	<div class="box-bg">
	<h3 class="module-title"><span><span><?php echo JText::_('DR_VIRTUEMART_CART_ORDER'); ?></span></span>
		<span class="back-to-category vm-continue-shopping">
			<?php // Continue Shopping Button
			if (!empty($this->continue_link_html)) {
				echo $this->continue_link_html;
			} ?>
		</span>
	</h3>
		
	<?php 
	if (($this->cart->cartPrices['salesPrice'])>0) {
		if (VmConfig::get ('oncheckout_show_steps', 1)) { ?>
		<ul class="steps">
			<li<?php if($this->checkout_task === 'checkout') { ?> class="current"<?php } ?>><span><?php echo vmText::_ ('TPL_SUMMARY'); ?></span></li>
			<li><span><?php echo vmText::_ ('TPL_BILLING'); ?></span></li>
			<li><span><?php echo vmText::_ ('TPL_SHIPPING'); ?></span></li>
			<li><span><?php echo vmText::_ ('TPL_PAYMENT'); ?></span></li>
			<li<?php if($this->checkout_task === 'confirm') { ?> class="current"<?php } ?>><span><?php echo vmText::_ ('TPL_CONFIRM'); ?></span></li>
		</ul>
	<?php } } ?>
	<div class="box-bg-indent">
<?php
	// This displays the form to change the current shopper
	if ($this->allowChangeShopper){
		//echo $this->loadTemplate ('shopperform');
	}


	$taskRoute = '';
	?>
	</div>
	</div>
	<form method="post" id="checkoutForm" name="checkoutForm" action="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=cart' . $taskRoute, $this->useXHTML, $this->useSSL); ?>">

		<?php
		if(VmConfig::get('multixcart')=='byselection'){
			if (!class_exists('ShopFunctions')) require(VMPATH_ADMIN . DS . 'helpers' . DS . 'shopfunctions.php');
			echo shopFunctions::renderVendorFullVendorList($this->cart->vendorId);
			?><input type="submit" name="updatecart" title="<?php echo vmText::_('COM_VIRTUEMART_SAVE'); ?>" value="<?php echo vmText::_('COM_VIRTUEMART_SAVE'); ?>" class="button"  style="margin-left: 10px;"/><?php
		} ?>
		
		<?php
		if (($this->cart->cartPrices['salesPrice'])>0) {  ?>
			<?php echo $this->loadTemplate ('pricelist'); 
				
			?>

		
		<div class="checkout-form-box">
		<?php if (!empty($this->checkoutAdvertise)) {
			?> <div id="checkout-advertise-box"> <?php
			foreach ($this->checkoutAdvertise as $checkoutAdvertise) {
				?>
				<div class="checkout-advertise">
					<?php echo $checkoutAdvertise; ?>
				</div>
				<?php
			}
			?></div><?php
		}

		echo $this->loadTemplate ('cartfields');

		?> <div class="checkout-button-top"> <?php
			echo $this->checkout_link_html;
		?></div>
		</div>
		<?php } else {echo '<h3 class="module-title no-products"><i class="fa fa-info-circle"></i>'.JText::_('COM_VIRTUEMART_ITEMS_NO_PRODUCTS').'</h3>';} ?>
		<?php // Continue and Checkout Button END ?>
		<input type='hidden' name='order_language' value='<?php echo $this->order_language; ?>'/>
		<input type='hidden' name='task' value='updatecart'/>
		<input type='hidden' name='option' value='com_virtuemart'/>
		<input type='hidden' name='view' value='cart'/>
	</form>
</div>

