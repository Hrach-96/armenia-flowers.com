<?php
/*======================================================================*\
|| #################################################################### ||
|| # Copyright ©2006-2009 Youjoomla LLC. All Rights Reserved.           ||
|| # ----------------     JOOMLA TEMPLATES CLUB      ----------- #      ||
|| # @license http://www.gnu.org/copyleft/gpl.html GNU/GPL            # ||
|| #################################################################### ||
\*======================================================================*/
defined('_JEXEC') or die('Restricted access'); 
$document = JFactory::getDocument();
?>
<?php if($type == 'logout') : ?>
<div id="logins" class="poping_links">
	
	<span class="admin"><?php if ($params->get('greeting')) : ?>
	<?php echo JText::_('HINAME') ?> <?php 
	if($params->get('name') == 0 ){
		echo $user->get('username')."!!!";
	}else{
		echo $user->get('name')."!!!";
	}
		?>
	<?php endif; ?></span>
    <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form2">
    	<div class="heading">
			<input type="submit" name="Submit" class="logout" value="<?php echo JText::_('DR_LOGOUT'); ?>" />
		</div>
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.logout" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>
</div>
<?php else : ?>

<!-- registration and login -->
<div class="poping_links"> <?php echo $params->get('pretext'); ?>
	<div class="heading" data-target="#myModal" data-toggle="modal">
		<?php echo JText::_('DR_LOG_IN_I') ?>
	</div>
    <div id="myModal" class="modal" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1">
    	<div class="modal-backdrop in" class="close" aria-hidden="true" data-dismiss="modal"></div>
    	<div class="modal-dialog">
    		<div class="modal-content">
    				<div class="modal-header">
    					<span class="close" aria-hidden="true" data-dismiss="modal" type="button"><i class="fa fa-times"></i></span>
    					<div class="clearfix"></div>
    					<span class="title"><?php echo JText::_('DR_LOG_IN_I') ?></span>
    					<div class="create_customer">
					         <?php /* <span><?php echo JText::_('NEW_CUSTOMER_I'); ?></span> */ ?>
							 <?php $usersConfig = &JComponentHelper::getParams( 'com_users' ); if ($usersConfig->get('allowUserRegistration')) : ?>
					                <a class="reg_btn button reset"  href="index.php?option=com_virtuemart&view=user&layout=edit"  ><?php echo JText::_('REGISTER_I'); ?></a> 
					         <?php endif; ?>
				      	</div></div>
					<div class="modal-body">
						<div class="modalbody">
					      	<?php if(JPluginHelper::isEnabled('authentication', 'openid')) : ?>
							<?php JHTML::_('script', 'openid.js'); ?>
					        <?php endif; ?>

					        <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" name="login" id="form-login" >
					     
					    	<div class="log-user">
							<input id="yjpop_username" type="text" name="username" class="inputbox" alt="username"  placeholder="<?php echo JText::_('USERNAME_I') ?>" />
					        </div>
					        <div class="log-pass">
							<input id="yjpop_passwd" type="password" name="password" class="inputbox" alt="password" placeholder="<?php echo JText::_('PASSWORD_I') ?>" />
					        </div>
					        <?php if(JPluginHelper::isEnabled('system', 'remember')) : ?>
							<div class="wrapper_remember">
					        <input id="yjpop_remember" type="checkbox" name="remember" class="inputbox" value="yes" alt="Remember Me" />
							<label for="yjpop_remember"><?php echo JText::_('REMEMBER_I') ?></label>
							</div>
							<?php endif; ?>
					         <div class="wrapper2 log button-log">
					         <button class="button" type="submit"><?php echo JText::_('DR_LOG_IN_I') ?></button>
					             <ul class="Forgot">
					            <li><a href="<?php echo JRoute::_( 'index.php?option=com_users&view=reset' ); ?>"><?php echo JText::_('FORGOT_YOUR_PASSWORD_I') ?></a></li>
					            <li><a href="<?php echo JRoute::_( 'index.php?option=com_users&view=remind' ); ?>"><?php echo JText::_('FORGOT_YOUR_USERNAME_I') ?></a></li>
								</ul>
					         </div>
					         <div class="clear"></div>
							<?php echo $params->get('posttext'); ?>
							<input type="hidden" name="option" value="com_users" />
							<input type="hidden" name="task" value="user.login" />
							<input type="hidden" name="return" value="<?php echo $return; ?>" />
							<?php echo JHtml::_('form.token'); ?>
						</form>
					</div>
					</div>
					<div class="modal-footer"></div>
				</div>
			</div>
		<div>
</div>
</div>
</div>
<!-- login -->

<!-- end registration and login -->
<?php endif; ?>
<script type="text/javascript" >
jQuery(document).ready(function () { 
	jQuery('#myModal').modal({
	  backdrop: false,
	  show:false
	})

});

</script>
