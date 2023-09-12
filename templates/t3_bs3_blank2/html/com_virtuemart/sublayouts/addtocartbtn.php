<?php
/**
 *
 * loads the add to cart button
 *
 * @package    VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2015 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @version $Id: addtocartbtn.php 8024 2014-06-12 15:08:59Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');

if($viewData['orderable']) {
echo'<button name="addtocart" type="submit" title="'.JText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'" value="'.JText::_('COM_VIRTUEMART_CART_ADD_TO').'"  class="hasTooltips addtocart-button cart-click"><i class="fa fa-shopping-cart"></i><span class="action-name">'.JText::_('COM_VIRTUEMART_CART_ADD_TO').'</span></button>';
} else {
	echo '<span name="addtocart" class="hasTooltips addtocart-button addtocart-button-disabled cart-click" title="'.JText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'" ><i class="fa fa-shopping-cart"></i><span class="action-name">'.JText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'</span></span>';
}