<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Mainbody 3 columns, content in center: sidebar1 - content - sidebar2
 */
$view = JRequest::getString('view', null);
// disable position conditions

switch ($view) {
	case 'user':
	case 'orders':
	case 'cart':
	case 'contact':
	case 'wrapper':
	case 'comparelist':
	case 'registration':
	case 'profile':
		$hide_asides 	= true;
		break;

	case 'category':
	case 'manufacturer':
	case 'vendor':
	case 'article':
	case 'archive':
	case 'categories':
	case 'featured':
	case 'login':
	
	case 'reset':
	
	case 'remind':
	case 'search':
		$hide_asides 	= false;
		break;

	case 'virtuemart':
		$hide_asides 	= false;
		break;

	default:
		$hide_asides 	= false;
		break;
}

$option = JRequest::getString('option', null);
if($option == 'com_sppagebuilder') {?>
	<div id="t3-mainbody" class="container t3-mainbody" style="padding:0px;">
		<div class="row">
			<!-- MAIN CONTENT -->
			<div id="t3-content" class="t3-content col-xs-12">
				<?php if($this->hasMessage()) : ?>
				<jdoc:include type="message" />
				<?php endif ?>
			</div>
			<!-- //MAIN CONTENT -->

		</div>
	</div> 
	<jdoc:include type="component" />

<?php }else { ?>
<div id="t3-mainbody" class="container t3-mainbody">
	<div class="row">

		<!-- MAIN CONTENT -->
		<div id="t3-content" class="t3-content <?php if (!$hide_asides) {echo "col-xs-12 col-md-6  col-md-push-3";}else {echo "col-xs-12 col-md-12";} ?>">
			<jdoc:include type="modules" name="<?php $this->_p('content-top') ?>" style="T3Xhtml" />
			<?php if($this->hasMessage()) : ?>
			<jdoc:include type="message" />
			<?php endif ?>
			<jdoc:include type="component" />
             <jdoc:include type="modules" name="<?php $this->_p('content-bottom') ?>" style="T3Xhtml" />
		</div>
		<!-- //MAIN CONTENT -->

		<!-- SIDEBAR 1 -->
		<?php
			//print_r($option.'lorem,');
		 if ($option!="com_comparelist") { ?>
		<div class="t3-sidebar t3-sidebar-1 col-xs-6  col-md-3  col-md-pull-6 <?php $this->_c($vars['sidebar1']) ?>">
			<jdoc:include type="modules" name="<?php $this->_p($vars['sidebar1']) ?>" style="T3Xhtml" />
		</div>
		<?php } ?>
		<!-- //SIDEBAR 1 -->
	
		<!-- SIDEBAR 2 -->
		<?php
			//print_r($option.'lorem,');
		 if (!$hide_asides) { ?>
		<div class="t3-sidebar t3-sidebar-2 col-xs-6  col-md-3 <?php $this->_c($vars['sidebar2']) ?>">
			<jdoc:include type="modules" name="<?php $this->_p($vars['sidebar2']) ?>" style="T3Xhtml" />
		</div>
		<?php } ?>
		<!-- //SIDEBAR 2 -->
	
	</div>
</div> 
<?php }
?>