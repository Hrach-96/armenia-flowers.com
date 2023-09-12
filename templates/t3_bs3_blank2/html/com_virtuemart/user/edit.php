<?php
/**
*
* Modify user form view
*
* @package	VirtueMart
* @subpackage User
* @author Oscar van Eijk
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: edit.php 8768 2015-03-02 12:22:14Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Implement Joomla's form validation
JHtml::_('behavior.formvalidation');
JHtml::stylesheet('vmpanels.css', JURI::root().'components/com_virtuemart/assets/css/'); // VM_THEMEURL
?>
<style type="text/css">
.invalid {
	border-color: #f00;
	background-color: #ffd;
	color: #000;
}
label.invalid {
	background-color: #fff;
	color: #f00;
}
</style>

<?php vmJsApi::vmValidator(); ?>

<div class="box-bg">
<h3 class="module-title"><?php echo vmText::_('COM_VIRTUEMART_LOGIN_FORM'); ?></h3>
<div class="box-bg-indent">
<?php echo shopFunctionsF::getLoginForm(false); ?>
</div>
</div>

<div class="box-bg">
<?php if($this->userDetails->virtuemart_user_id==0) {
	echo '<h4 class="module-title">'.vmText::_('COM_VIRTUEMART_YOUR_ACCOUNT_REG').'</h4>';
}?>
<div class="box-bg-indent">
<form method="post" id="adminForm" name="userForm" action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=user',$this->useXHTML,$this->useSSL) ?>" class="form-validate">

<?php // Loading Templates in Tabs
if($this->userDetails->virtuemart_user_id!=0) {
    $tabarray = array();

    $tabarray['shopper'] = 'COM_VIRTUEMART_SHOPPER_FORM_LBL';

	if($this->userDetails->user_is_vendor){
		if(!empty($this->add_product_link)) {
			//echo $this->manage_link;
			//echo $this->add_product_link;
		}
		//$tabarray['vendor'] = 'COM_VIRTUEMART_VENDOR';
	}

    //$tabarray['user'] = 'COM_VIRTUEMART_USER_FORM_TAB_GENERALINFO';
    if (!empty($this->shipto)) {
	    $tabarray['shipto'] = 'COM_VIRTUEMART_USER_FORM_ADD_SHIPTO_LBL';
    }
    if (($_ordcnt = count($this->orderlist)) > 0) {
	    $tabarray['orderlist'] = 'COM_VIRTUEMART_YOUR_ORDERS';
    }

    shopFunctionsF::buildTabs ( $this, $tabarray);

 } else {
 	echo $this->captcha;
    echo $this->loadTemplate ( 'shopper' );
 }
?>
	<?php if($this->userDetails->user_is_vendor){ ?>
    <div class="buttonBar-right">
		<button class="button" type="submit" onclick="javascript:return myValidator(userForm, true);" ><?php echo $this->button_lbl ?></button>
	&nbsp;
		<button class="button reset" type="reset" onclick="window.location.href='<?php echo JRoute::_('index.php?option=com_virtuemart&view=user&task=cancel', FALSE); ?>'" ><?php echo vmText::_('COM_VIRTUEMART_CANCEL'); ?></button>
	</div>
    <?php } ?>
<input type="hidden" name="option" value="com_virtuemart" />
<input type="hidden" name="controller" value="user" />
<?php echo JHtml::_( 'form.token' ); ?>
</form>
</div>
</div>

