<?php
/**
*
* Order detail view
*
* @package	VirtueMart
* @subpackage Orders
* @author Oscar van Eijk, Valerie Isaksen
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: details.php 6246 2012-07-09 19:00:20Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JHtml::stylesheet('vmpanels.css', JURI::root().'components/com_virtuemart/assets/css/');
if($this->print){
	?>

		<body onload="javascript:print();">
		<div class="vm-orders-vendor-image"><img src="<?php  echo JURI::root() . $this-> vendor->images[0]->file_url ?>"></div>
		<h2><?php  echo $this->vendor->vendor_store_name; ?></h2>
		<?php  echo $this->vendor->vendor_name .' - '.$this->vendor->vendor_phone ?>
		<h1><?php echo JText::_('COM_VIRTUEMART_ACC_ORDER_INFO'); ?></h1>
		<div class='spaceStyle vm-orders-order print'>
		<?php
		echo $this->loadTemplate('order');
		?>
		</div>

		<div class='spaceStyle vm-orders-items print'>
		<?php
		echo $this->loadTemplate('items');
		?>
		</div>
		<?php if(!class_exists('VirtuemartViewInvoice')) require_once(VMPATH_SITE .DS. 'views'.DS.'invoice'.DS.'view.html.php');
		echo VirtuemartViewInvoice::replaceVendorFields($this->vendor->vendor_letter_footer_html, $this->vendor); ?>
		</body>
		<?php
} else {

	?>
    <div class="cart-view">

	<h3 class="module-title"><?php echo JText::_('COM_VIRTUEMART_ACC_ORDER_INFO'); ?>

	<?php

	/* Print view URL */
	$details_link = "<a class=\"print-orders\" href=\"javascript:void window.open('$this->details_url', 'win2', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');\"  >";
	//$details_link .= '<span class="hasTip print_32" title="' . JText::_('COM_VIRTUEMART_PRINT') . '">&nbsp;</span></a>';
	$button = (JVM_VERSION==1) ? '/images/M_images/printButton.png' : 'system/printButton.png';
	//$details_link .= JHtml::_('',$button, JText::_('COM_VIRTUEMART_PRINT'), NULL, true);
	$details_link  .=  '<i class="fa fa-print"></i>
</a>';
	echo $details_link;
	$this->orderdetails['details']['BT']->invoiceNumber = VmModel::getModel('orders')->getInvoiceNumber($this->orderdetails['details']['BT']->virtuemart_order_id);
	echo shopFunctionsF::getInvoiceDownloadButton($this->orderdetails['details']['BT']); ?>
</h3>
<?php if($this->order_list_link){ ?>
	<div class='spaceStyle first'>
	   	<div class="back-to-category" >
		<a class="button_back button reset2" href="<?php echo $this->order_list_link ?>"><i class="fa fa-reply"></i></a>
	    </div>
	    <div class="clear"></div>
	</div>
<?php }?>
<div class='spaceStyle second'>
	<?php
	echo $this->loadTemplate('order');
	?>
	</div>

	<div class='spaceStylebot shoper'>
	<?php

	$tabarray = array();

	$tabarray['items'] = 'COM_VIRTUEMART_ORDER_ITEM';
	$tabarray['history'] = 'COM_VIRTUEMART_ORDER_HISTORY';

	shopFunctionsF::buildTabs ( $this, $tabarray); ?>
	 </div>
        </div>
	<?php
}

?>






