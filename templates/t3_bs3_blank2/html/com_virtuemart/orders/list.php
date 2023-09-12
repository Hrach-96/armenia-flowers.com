<?php
/**
*
* Orderlist
* NOTE: This is a copy of the edit_orderlist template from the user-view (which in turn is a slighly
*       modified copy from the backend)
*
* @package	VirtueMart
* @subpackage Orders
* @author Oscar van Eijk
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: list.php 5434 2012-02-14 07:59:10Z electrocity $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>
<?php
if (count($this->orderlist) == 0) { ?>

<div class="box-bg login-box2 cart-view">
    <h3 class="module-title"><?php echo vmText::_('COM_VIRTUEMART_ORDER_ANONYMOUS') ?></h3>
	<div class="box-bg-indent">
		<?php  echo shopFunctionsF::getLoginForm(false,true); ?>
	</div>
</div>	 
<?php } else {
 ?>
<div id="editcell" class="order-list">
<h3 class="module-title"><?php echo JText::_('COM_VIRTUEMART_ORDERS_VIEW_DEFAULT_TITLE'); ?></h3>
<div class="orders-box">
	<table class="adminlist" width="100%">
	<thead>
	<tr class="divece">
		<th>
			<?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_ORDER_NUMBER'); ?>
		</th>
		<th>
			<?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_CDATE'); ?>
		</th>
		<!--th>
			<?php //echo JText::_('COM_VIRTUEMART_ORDER_LIST_MDATE'); ?>
		</th -->
		<th>
			<?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_STATUS'); ?>
		</th>
		<th>
			<?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_TOTAL'); ?>
		</th>
	</thead>
	<?php
		$k = 0;
		foreach ($this->orderlist as $row) {
			$editlink = JRoute::_('index.php?option=com_virtuemart&view=orders&layout=details&order_number=' . $row->order_number, FALSE);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td class="num" align="left">
					<span class="divice-name"><?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_ORDER_NUMBER'); ?></span>
					<a href="<?php echo $editlink; ?>"><?php echo $row->order_number; ?></a>
					<?php echo shopFunctionsF::getInvoiceDownloadButton($row) ?>
				</td>
				<td  align="left">
					<span class="divice-name"><?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_CDATE'); ?></span>
					<?php echo vmJsApi::date($row->created_on,'LC4',true); ?>
				</td>
				<!--td align="left">
					<?php //echo vmJsApi::date($row->modified_on,'LC3',true); ?>
				</td -->
				<td align="left">
					<span class="divice-name"><?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_STATUS'); ?></span>
					<?php echo ShopFunctions::getOrderStatusName($row->order_status); ?>
				</td>
				<td class="total" align="left">
					<span class="divice-name"><?php echo JText::_('COM_VIRTUEMART_ORDER_LIST_TOTAL'); ?></span>
					<?php echo $this->currency->priceDisplay($row->order_total, $row->currency); ?>
				</td>
			</tr>
	<?php
			$k = 1 - $k;
		}
	?>
	</table>
    </div>
</div>
<?php } ?>
