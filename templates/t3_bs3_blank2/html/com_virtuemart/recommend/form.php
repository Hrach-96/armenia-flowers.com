<?php
/**
 *TODO Improve the CSS , ADD CATCHA ?
 * Show the form Ask a Question
 *
 * @package	VirtueMart
 * @subpackage
 * @author Kohl Patrick
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
* @version $Id: default.php 2810 2011-03-02 19:08:24Z Milbo $
 */

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );

$min = VmConfig::get('asks_minimum_comment_length', 50);
$max = VmConfig::get('asks_maximum_comment_length', 2000);
vmJsApi::JvalideForm();
$document = JFactory::getDocument();
$document->addScriptDeclaration('
	jQuery(function($){
			$("#askform").validationEngine("attach");
			var counterResult = $("#comment").val().length;
			$("#counter").val( counterResult );
			$("#comment").keyup( function () {
				var result = $(this).val();
					$("#counter").val( result.length );
			});
	});
'); 

$vendorModel = VmModel::getModel ('vendor');
$this->vendor = $vendorModel->getVendor ($this->product->virtuemart_vendor_id);

/* Let's see if we found the product */
if (empty ( $this->product )) {
	echo JText::_ ( 'COM_VIRTUEMART_PRODUCT_NOT_FOUND' );
	echo '<br /><br />  ' . $this->continue_link_html;
} else {
	$session = JFactory::getSession();
	$mailRecommendData = $session->get('mailrecommend', 0, 'vm');
	if(!empty($this->login)){
		echo $this->login;
	}
	if(empty($this->login) or VmConfig::get('recommend_unauth',false)){
		?>

<div class="ask-a-question-view">
	

<div class="product-summary">
    <h3 class="module-title"><?php echo $this->product->product_name ?></h3>
		<div class="width70 floatleft">
			

			<?php // Product Short Description
			if (!empty($this->product->product_s_desc)) { ?>
				<div class="short-description" style="padding-right:20px;">
					<?php echo $this->product->product_s_desc ?>
				</div>
			<?php } // Product Short Description END ?>

		</div>

		<div class="width30 floatleft center">
        <div class="asc-img">
			<?php // Product Image
			echo $this->product->images[0]->displayMediaThumb('class="product-image"',false); ?>
        </div>    
		</div>

	<div class="clear"></div>
	</div>


	<div class="form-field">

		<form method="post" class="form-validate" action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$this->product->virtuemart_product_id.'&virtuemart_category_id='.$this->product->virtuemart_category_id.'&tmpl=component', FALSE) ; ?>" name="askform" id="askform" >
			
            <label><?php echo JText::_('COM_VIRTUEMART_USER_FORM_NAME')  ?> :</br> <input type="text" value="<?php echo $this->user->name ? $this->user->name : $askQuestionData['name'] ?>" name="name" id="name" size="30" class="inputbox validate[required,minSize[3],maxSize[64]]"/>
            </label>
            
            <div class="clear"></div>
            <label><?php echo JText::_('COM_VIRTUEMART_USER_FORM_EMAIL')  ?>  :</br> <input type="text" value="<?php echo $this->user->email ? $this->user->email : $askQuestionData['email'] ?>" name="email" id="email" size="30" class="inputbox validate[required,custom[email]]"/></label>
            <div class="clear"></div>
			<label>
				<?php
				$ask_comment = JText::sprintf('COM_VIRTUEMART_ASK_COMMENT', $min, $max);
				echo $ask_comment;
				?>
				<br />
				<textarea id="Comment" title="<?php echo $ask_comment ?>" class="validate[required,minSize[<?php echo $min ?>],maxSize[<?php echo $max ?>]] field" id="comment" name="comment" rows="8"><?php echo $askQuestionData['comment']; ?></textarea>
			</label>

				<div class="submit">
                <div class="width50 floatright right paddingtop">
						</div>
						<?php // captcha addition
						if(VmConfig::get ('ask_captcha')){
							JHTML::_('behavior.framework');
							JPluginHelper::importPlugin('captcha');
							$dispatcher = JDispatcher::getInstance(); $dispatcher->trigger('onInit','dynamic_recaptcha_1');
							?>
							<div id="dynamic_recaptcha_1"></div>
						<?php 
						}
						// end of captcha addition 
						?>
					 <button type="submit" value="<?php echo JText::_('COM_VIRTUEMART_RECOMMEND_SUBMIT') ?>" class="ask button" ><?php echo JText::_('COM_VIRTUEMART_RECOMMEND_SUBMIT') ?></button>
				</div>

				<input type="hidden" name="virtuemart_product_id" value="<?php echo JRequest::getInt('virtuemart_product_id',0); ?>" />
					<input type="hidden" name="tmpl" value="component" />
					<input type="hidden" name="view" value="productdetails" />
					<input type="hidden" name="option" value="com_virtuemart" />
					<input type="hidden" name="virtuemart_category_id" value="<?php echo JRequest::getInt('virtuemart_category_id'); ?>" />
					<input type="hidden" name="task" value="mailRecommend" />
					<?php echo JHTML::_( 'form.token' ); ?>
			</form>

	</div>
</div>

<?php } }?>
