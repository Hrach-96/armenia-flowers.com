<fieldset class="vm-fieldset-pricelist">
<div class="box-bg basket">
	
<div class="box-bg-indent">	
<table
	class="cart-summary"
	cellspacing="0"
	cellpadding="0"
	border="0"
	width="100%">
<tr class="device">
	<th class="first"><?php echo vmText::_ ('COM_VIRTUEMART_CART_NAME') ?></th>
	<th ><?php echo vmText::_ ('COM_VIRTUEMART_CART_SKU') ?></th>
	<th
		><?php echo vmText::_ ('COM_VIRTUEMART_CART_PRICE') ?></th>
	<th
		><?php echo vmText::_ ('COM_VIRTUEMART_CART_QUANTITY') ?>
	</th>


	<?php if (VmConfig::get ('show_tax')) {
		$tax = vmText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT');
		if(!empty($this->cart->cartData['VatTax'])){
			reset($this->cart->cartData['VatTax']);
			$taxd = current($this->cart->cartData['VatTax']);
			$tax = $taxd['calc_name'].'';
		}
		?>
	<th ><?php echo "<span  class='priceColor2'>" . $tax . '</span>' ?></th>
	<?php } ?>
	<th ><?php echo "<span  class='priceColor2'>" . vmText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT') . '</span>' ?></th>
	<th ><?php echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL') ?></th>
</tr>

<?php
$i = 1;

foreach ($this->cart->products as $pkey => $prow) { ?>

<tr valign="top" class="prod-row sectiontableentry<?php echo $i ?>">
	<input type="hidden" name="cartpos[]" value="<?php echo $pkey ?>">
	<td class="first">
		<span class="divice-name"><?php echo vmText::_ ('COM_VIRTUEMART_CART_NAME') ?></span>
		<?php if ($prow->virtuemart_media_id) { ?>
		<span class="cart-images">
						 <?php
			if (!empty($prow->images[0])) {
				echo $prow->images[0]->displayMediaThumb ('', FALSE);
			}
			?>
						</span>
		<?php } ?>
		<?php echo JHtml::link ($prow->url, $prow->product_name);
			echo $this->customfieldsModel->CustomsFieldCartDisplay ($prow);
		 ?>

	</td>
	<td class="ps"><span class="divice-name"><?php echo vmText::_ ('COM_VIRTUEMART_CART_SKU') ?></span><?php  echo $prow->product_sku ?></td>
	<td>
		<span class="divice-name"><?php echo vmText::_ ('COM_VIRTUEMART_CART_PRICE') ?></span>
		<?php
		if (VmConfig::get ('checkout_show_origprice', 1) && $prow->prices['discountedPriceWithoutTax'] != $prow->prices['priceWithoutTax']) {
			echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $prow->prices, TRUE, FALSE) . '</span><br />';
		}

		if ($prow->prices['discountedPriceWithoutTax']) {
			echo $this->currencyDisplay->createPriceDiv ('discountedPriceWithoutTax', '', $prow->prices, FALSE, FALSE);
		} else {
			echo $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $prow->prices, FALSE, FALSE);
		}
		?>
	</td>
	<td class="qnt">
		<span class="divice-name"><?php echo vmText::_ ('COM_VIRTUEMART_CART_QUANTITY') ?></span>
		<?php

				if ($prow->step_order_level)
					$step=$prow->step_order_level;
				else
					$step=1;
				if($step==0)
					$step=1;
				?>
		   <input type="text"
				   onblur="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED')?>');"
				   onclick="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED')?>');"
				   onchange="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED')?>');"
				   onsubmit="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED')?>');"
				   title="<?php echo  vmText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class="quantity-input js-recalculate" size="3" maxlength="4" name="quantity[<?php echo $pkey; ?>]" value="<?php echo $prow->quantity ?>" />

			<button 
			type="submit" class="vmicon vm2-add_quantity_cart" name="updatecart.<?php echo $pkey ?>" title="<?php echo  vmText::_ ('COM_VIRTUEMART_CART_UPDATE') ?>"><i class="fa fa-check"></i><?php echo JText::_('DR_VIRTUEMART_CART_UPDATE'); ?></button><br>
			<button 
			type="submit" class="vmicon vm2-remove_from_cart" name="delete.<?php echo $pkey ?>" title="<?php echo vmText::_ ('COM_VIRTUEMART_CART_DELETE') ?>"><i class="fa fa-times"></i><?php echo JText::_('DR_VIRTUEMART_CART_DELETE') ?></button>
	</td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td class="tax">
		<span class="divice-name"><?php echo $tax ?></span>
		<?php echo "<span class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('taxAmount', '', $prow->prices, FALSE, FALSE, $prow->quantity) . "</span>" ?></td>
	<?php } ?>
	<td class="disc"><span class="divice-name"><?php echo "<span  class='priceColor2'>" . vmText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT') . '</span>' ?></span><?php echo "<span class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('discountAmount', '', $prow->prices, FALSE, FALSE, $prow->quantity) . "</span>" ?></td>
	<td colspan="1">
		<span class="divice-name"><?php echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL') ?></span>
		<?php
		if (VmConfig::get ('checkout_show_origprice', 1) && !empty($prow->prices['basePriceWithTax']) && $prow->prices['basePriceWithTax'] != $prow->prices['salesPrice']) {
			echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceWithTax', '', $prow->prices, TRUE, FALSE, $prow->quantity) . '</span><br />';
		}
		elseif (VmConfig::get ('checkout_show_origprice', 1) && empty($prow->prices['basePriceWithTax']) && $prow->prices['basePriceVariant'] != $prow->prices['salesPrice']) {
			echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $prow->prices, TRUE, FALSE, $prow->quantity) . '</span><br />';
		}
		echo $this->currencyDisplay->createPriceDiv ('salesPrice', '', $prow->prices, FALSE, FALSE, $prow->quantity) ?></td>
</tr>
	<?php
	$i = ($i==1) ? 2 : 1;
} ?>
<!--Begin of SubTotal, Tax, Shipment, Coupon Discount and Total listing -->
<?php if (VmConfig::get ('show_tax')) {
	$colspan = 3;
} else {
	$colspan = 2;
} ?>

<tr class="price-total sectiontableentry1">
	<td class="text-align-right" colspan="4"><?php echo vmText::_ ('COM_VIRTUEMART_ORDER_PRINT_PRODUCT_PRICES_TOTAL'); ?></td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td >
		<span class="divice-name"><?php echo vmText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT') ?></span>
		<?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('taxAmount', '', $this->cart->cartPrices, FALSE) . "</span>" ?></td>
	<?php } ?>
	<td ><span class="divice-name"><?php echo "<span  class='priceColor2'>" . vmText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT') . '</span>' ?></span><?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('discountAmount', '', $this->cart->cartPrices, FALSE) . "</span>" ?></td>
	<td ><span class="divice-name"><?php echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL') ?></span><?php echo $this->currencyDisplay->createPriceDiv ('salesPrice', '', $this->cart->cartPrices, FALSE) ?></td>
</tr>


<?php
foreach ($this->cart->cartData['DBTaxRulesBill'] as $rule) {
	?>
<tr class="sectiontableentry<?php echo $i ?>">
	<td class="text-align-right" colspan="4"><?php echo $rule['calc_name'] ?> </td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td ></td>
	<?php } ?>
	<td ><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?></td>
	<td ><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
</tr>
	<?php
	if ($i) {
		$i = 1;
	} else {
		$i = 0;
	}
} ?>

<?php

foreach ($this->cart->cartData['taxRulesBill'] as $rule) {
	?>
<tr class="sectiontableentry<?php echo $i ?>">
	<td class="text-align-right" colspan="4" ><?php echo $rule['calc_name'] ?> </td>
	<?php if (VmConfig::get ('show_tax')) { ?>
	<td ><span class="divice-name"><?php echo vmText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT') ?></span><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
	<?php } ?>
	<td ><?php ?> </td>
	<td ><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
</tr>
	<?php
	if ($i) {
		$i = 1;
	} else {
		$i = 0;
	}
	
}

foreach ($this->cart->cartData['DATaxRulesBill'] as $rule) {
	?>
<tr class="sectiontableentry<?php echo $i ?>">
	<td class="text-align-right" colspan="4" ><?php echo   $rule['calc_name'] ?> </td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td ></td>

	<?php } ?>
	<td ><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?>  </td>
	<td ><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
</tr>
	<?php
	if ($i) {
		$i = 1;
	} else {
		$i = 0;
	}
	
} ?>





<tr class="shipment-price sectiontableentry2">
	<td class="color text-align-right" colspan="4" ><?php echo vmText::_ ('COM_VIRTUEMART_CART_SHIPPING'); ?>:</td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td><?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('shipmentTax', '', $this->cart->cartPrices['shipmentTax'], FALSE) . "</span>"; ?> </td>
	<?php } ?>
	<td><?php if($this->cart->cartPrices['salesPriceShipment'] < 0) echo $this->currencyDisplay->createPriceDiv ('salesPriceShipment', '', $this->cart->cartPrices['salesPriceShipment'], FALSE); ?></td>
	<td><?php echo $this->currencyDisplay->createPriceDiv ('salesPriceShipment', '', $this->cart->cartPrices['salesPriceShipment'], FALSE); ?> </td>
</tr>

<tr class="paument-price sectiontableentry2">
	<td class="color text-align-right" colspan="4" ><?php echo vmText::_ ('COM_VIRTUEMART_CART_PAYMENT') ?>:</td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td align="right"><?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('paymentTax', '', $this->cart->cartPrices['paymentTax'], FALSE) . "</span>"; ?> </td>
	<?php } ?>
	<td align="right" ><?php if($this->cart->cartPrices['salesPricePayment'] < 0) echo $this->currencyDisplay->createPriceDiv ('salesPricePayment', '', $this->cart->cartPrices['salesPricePayment'], FALSE); ?></td>
	<td align="right" ><?php  echo $this->currencyDisplay->createPriceDiv ('salesPricePayment', '', $this->cart->cartPrices['salesPricePayment'], FALSE); ?> </td>
</tr>


<?php
if (VmConfig::get ('coupons_enable')) {
	?>
<tr class="paument-price sectiontableentry2">
	<td class="color text-align-right" colspan="4" ><?php echo vmText::_ ('COM_VIRTUEMART_CART_COUPON_CODE') ?>:</td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td ></span><?php echo $this->currencyDisplay->createPriceDiv ('couponTax', '', $this->cart->cartPrices['couponTax'], FALSE); ?> </td>
		<?php } ?>
	<td > </td>
	<td class="color"><strong><?php echo $this->currencyDisplay->createPriceDiv ('salesPriceCoupon', '', $this->cart->cartPrices['salesPriceCoupon'], FALSE); ?> </strong></td>
</tr>
<?php } ?>
<tr class="total sectiontableentry2">
	<td class="color text-align-right" colspan="4" ><?php echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL') ?>:</td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td > <span class="divice-name"><?php echo vmText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT') ?></span><?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('billTaxAmount', '', $this->cart->cartPrices['billTaxAmount'], FALSE) . "</span>" ?> </td>
	<?php } ?>
	<td > <span class="divice-name"><?php echo "<span  class='priceColor2'>" . vmText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT') . '</span>' ?></span><?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('billDiscountAmount', '', $this->cart->cartPrices['billDiscountAmount'], FALSE) . "</span>" ?> </td>
	<td class="color"><span class="divice-name"><?php echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL') ?></span><strong><?php echo $this->currencyDisplay->createPriceDiv ('billTotal', '', $this->cart->cartPrices['billTotal'], FALSE); ?></strong></td>
</tr>
<?php
if ($this->totalInPaymentCurrency) {
?>

<tr class="sectiontableentry2">
	<td colspan="4" align="right"><?php echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL_PAYMENT') ?>:</td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td align="right"></td>
	<?php } ?>
	<td align="right"></td>
	<td align="right"><strong><?php echo $this->totalInPaymentCurrency;   ?></strong></td>
</tr>
	<?php
}
?>

</table>
</div>
</div>
<?php
if (VmConfig::get ('coupons_enable')) {
	?>
<div class="row">
<div class="col-xs-12 col-md-12 col-sm-12">
<div class="box-bg">
<h3 class="module-title"><?php echo vmText::_ ('COM_VIRTUEMART_CART_COUPON_CODE'); ?></h3>
<div class="box-bg-indent">
<table	class="cart-coupon" cellspacing="0" cellpadding="0" border="0" width="100%">

	<?php if (VmConfig::get ('show_tax')) {
		$colspan = 3;
	} else {
		$colspan = 2;
	} ?>
<tr class="sectiontableentry2">
	<td colspan="4" align="left">
		<?php if (!empty($this->layoutName) && $this->layoutName == 'default') {
		echo $this->loadTemplate ('coupon');
		} ?>

		<?php if (!empty($this->cart->cartData['couponCode'])) { ?>
		<?php
		echo $this->cart->cartData['couponCode'];
		echo $this->cart->cartData['couponDescr'] ? (' (' . $this->cart->cartData['couponDescr'] . ')') : '';
		?>
	</td>
	<?php } else { ?>

	</td>
	<td colspan="<?php echo $colspan ?>" align="left"></td>
	<?php }	?>
</tr>

</table>
</div>
</div>
</div>
</div>
<?php } ?>
</fieldset>
<?php $cartfieldNames = array();
				foreach( $this->userFieldsCart['fields'] as $fields){
					$cartfieldNames[] = $fields['name'];
				}
				$html = '';
				foreach ($this->cart->BTaddress['fields'] as $item) {
					if(in_array($item['name'],$cartfieldNames)) continue;
					if (!empty($item['value'])) {
						if ($item['name'] === 'agreed') {
							$item['value'] = ($item['value'] === 0) ? vmText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_TOS_NO') : vmText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_TOS_YES');
						}
						$html .= '<p class="values vm2-'.$item['name'].'">'.$item['value'].'</p>';
					}
				}
				if($html != ''){ ?>
<div class="box-bg">
<h3 class="module-title"><span><span><?php echo JText::_('DR_VIRTUEMART_CART_BILLING'); ?></span></span></h3>
	<div class="box-bg-indent">
		<?php echo $this->loadTemplate ('address'); ?>
	</div>
</div>	
<?php } ?>
<div class="container cart-indent-row">
<div class="row">
<div class="col-xs-12 col-md-6 col-sm-6">

<?php if ( 	VmConfig::get('oncheckout_opc',true) or
	!VmConfig::get('oncheckout_show_steps',false) or
	(!VmConfig::get('oncheckout_opc',true) and VmConfig::get('oncheckout_show_steps',false) and
		!empty($this->cart->virtuemart_shipmentmethod_id) )
) { ?>
<div class="box-bg">
<h3 class="module-title"><?php echo vmText::_ ('COM_VIRTUEMART_CART_SELECTED_SHIPMENT'); ?></h3>
<div class="box-bg-indent">
<table	class="cart-shipment" cellspacing="0" cellpadding="0" border="0" width="100%">
<tr class="sectiontableentry1" style="vertical-align:top;">
	<?php if (!$this->cart->automaticSelectedShipment) { ?>
		<td>
			<?php
				if (!VmConfig::get('oncheckout_opc',true) and VmConfig::get('oncheckout_show_steps',false)){
					echo $this->cart->cartData['shipmentName'].'<br/>';
				}

		if (!empty($this->layoutName) and $this->layoutName == 'default') {
			if (VmConfig::get('oncheckout_opc', 0)) {
				$previouslayout = $this->setLayout('select');
				echo $this->loadTemplate('shipment2');
				$this->setLayout($previouslayout);
			} else {
				echo JHtml::_('link', JRoute::_('index.php?option=com_virtuemart&view=cart&task=edit_shipment', $this->useXHTML, $this->useSSL), $this->select_shipment_text, 'class=""');
			}
		} else {
			echo vmText::_ ('COM_VIRTUEMART_CART_SHIPPING');
		}
		echo '</td>';
	} else {
	?>
	<td>
		<?php echo $this->cart->cartData['shipmentName']; ?>
	</td>
	<?php } ?>
</tr>
</table>
</div>
</div>
<?php } ?>

</div>
<div class="col-xs-12 col-md-6 col-sm-6">

<?php if ($this->cart->pricesUnformatted['salesPrice']>0.0 and
	( 	VmConfig::get('oncheckout_opc',true) or
		!VmConfig::get('oncheckout_show_steps',false) or
		( (!VmConfig::get('oncheckout_opc',true) and VmConfig::get('oncheckout_show_steps',false) ) and !empty($this->cart->virtuemart_paymentmethod_id))
	)
) { ?>
<div class="box-bg">
<h3 class="module-title"><?php echo vmText::_ ('COM_VIRTUEMART_CART_SELECTED_PAYMENT'); ?></h3>
<div class="box-bg-indent cart-payment">
<table	class="cart-payment" cellspacing="0" cellpadding="0" border="0" width="100%">
<tr class="sectiontableentry1" style="vertical-align:top;">
	<?php if (!$this->cart->automaticSelectedPayment) { ?>
		<td colspan="4" style="align:left;vertical-align:top;">
			<?php
				if(!VmConfig::get('oncheckout_opc',true) and VmConfig::get('oncheckout_show_steps',false)){
					echo $this->cart->cartData['paymentName'].'<br/>';
				}

		if (!empty($this->layoutName) && $this->layoutName == 'default') {
			if (VmConfig::get('oncheckout_opc', 0)) {
				$previouslayout = $this->setLayout('select');
				echo $this->loadTemplate('payment2');
				$this->setLayout($previouslayout);
			} else {
				echo JHtml::_('link', JRoute::_('index.php?option=com_virtuemart&view=cart&task=editpayment', $this->useXHTML, $this->useSSL), $this->select_payment_text, 'class=""');
			}
		} else {
		echo vmText::_ ('COM_VIRTUEMART_CART_PAYMENT');
	} ?> </td>

	<?php } else { ?>
			<?php echo $this->cart->cartData['paymentName']; ?> 
	<?php } ?>
</tr>
</table>
</div>
</div>
<?php  } ?>

</div>


</div>
</div>

