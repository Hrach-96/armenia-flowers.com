<?php
defined('_JEXEC') or die('');

/**
*
* Template for the shopping cart
*
* @package	VirtueMart
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
*/
?>
<div class="box-bg finish-cart">
	<?php if (vRequest::getBool('display_title',true)) {?>
	<h3 class="module-title"><span><span><?php echo JText::_('COM_VIRTUEMART_CART_ORDERDONE_THANK_YOU'); ?></span></span></h3>
		<?php }?>
	<div class="box-bg-indent">

	<?php $this->html = vRequest::get('html', vmText::_('COM_VIRTUEMART_ORDER_PROCESSED') );
	echo $this->html;
	//if(!$cuser->guest) echo shopFunctionsF::getLoginForm ();
	?>
	</div>
</div>
