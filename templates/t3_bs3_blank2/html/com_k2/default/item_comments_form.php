<?php
/**
 * @version		$Id: item_comments_form.php 1992 2013-07-04 16:36:38Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

?>

<h2 class="module-title"><?php echo JText::_('K2_LEAVE_A_COMMENT') ?></h2>

<div class="coments-box">
<?php if($this->params->get('commentsFormNotes')): ?>
<span class="itemCommentsForm">
	<?php if($this->params->get('commentsFormNotesText')): ?>
	<?php echo nl2br($this->params->get('commentsFormNotesText')); ?>
	<?php else: ?>
	<?php echo JText::_('K2_COMMENT_FORM_NOTES') ?>
	<?php endif; ?>
</span>
<?php endif; ?>

<form action="<?php echo JURI::root(true); ?>/index.php" method="post" id="comment-form" class="form-validate">
	<div class="group-row">
	<div class="group col-1">
	<label class="formName" for="userName"><?php echo JText::_('K2_NAME'); ?> *</label>
	<input class="inputbox" type="text" name="userName" id="userName" value="<?php echo JText::_('K2_ENTER_YOUR_NAME'); ?>" onblur="if(this.value=='') this.value='<?php echo JText::_('K2_ENTER_YOUR_NAME'); ?>';" onfocus="if(this.value=='<?php echo JText::_('K2_ENTER_YOUR_NAME'); ?>') this.value='';" />
    </div>
	<div class="group col-2">
	<label class="formEmail" for="commentEmail"><?php echo JText::_('K2_EMAIL'); ?> *</label>
	<input class="inputbox" type="text" name="commentEmail" id="commentEmail" value="<?php echo JText::_('K2_ENTER_YOUR_EMAIL_ADDRESS'); ?>" onblur="if(this.value=='') this.value='<?php echo JText::_('K2_ENTER_YOUR_EMAIL_ADDRESS'); ?>';" onfocus="if(this.value=='<?php echo JText::_('K2_ENTER_YOUR_EMAIL_ADDRESS'); ?>') this.value='';" />
	 </div>
	  </div>
	 <div class="group col-3">
	<label class="formUrl" for="commentURL"><?php echo JText::_('K2_WEBSITE_URL'); ?></label>
	<input class="inputbox" type="text" name="commentURL" id="commentURL" value="<?php echo JText::_('K2_ENTER_YOUR_SITE_URL'); ?>"  onblur="if(this.value=='') this.value='<?php echo JText::_('K2_ENTER_YOUR_SITE_URL'); ?>';" onfocus="if(this.value=='<?php echo JText::_('K2_ENTER_YOUR_SITE_URL'); ?>') this.value='';" />
   </div>
   <div class="group">
	<label class="formComment" for="commentText"><?php echo JText::_('K2_MESSAGE'); ?> *</label>
	<textarea rows="20" cols="10" class="inputbox" onblur="if(this.value=='') this.value='<?php echo JText::_('K2_ENTER_YOUR_MESSAGE_HERE'); ?>';" onfocus="if(this.value=='<?php echo JText::_('K2_ENTER_YOUR_MESSAGE_HERE'); ?>') this.value='';" name="commentText" id="commentText"><?php echo JText::_('K2_ENTER_YOUR_MESSAGE_HERE'); ?></textarea>
	</div>
	<?php if($this->params->get('recaptcha') && ($this->user->guest || $this->params->get('recaptchaForRegistered', 1))): ?>
	<label class="formRecaptcha"><?php echo JText::_('K2_ENTER_THE_TWO_WORDS_YOU_SEE_BELOW'); ?></label>
	<div id="recaptcha"></div>
	<?php endif; ?>

	<input type="submit" class="button reset2" id="submitCommentBtn" value="<?php echo JText::_('K2_SUBMIT_COMMENT'); ?>" />

	<span id="formLog"></span>

	<input type="hidden" name="option" value="com_k2" />
	<input type="hidden" name="view" value="item" />
	<input type="hidden" name="task" value="comment" />
	<input type="hidden" name="itemID" value="<?php echo JRequest::getInt('id'); ?>" />
	<?php echo JHTML::_('form.token'); ?>
</form>
</div>