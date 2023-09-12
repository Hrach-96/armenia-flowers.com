<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Mainbody 2 columns: content - sidebar
 */
$option = JRequest::getString('option', null);
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
		$hide_position 	= false;
		$hide_asides 	= false;
		break;

	default:
		$hide_asides 	= false;
		break;
}
$app = JFactory::getApplication();
$templateparams	= $app->getTemplate(true)->params;

$prodview = $view;

if ($prodview == 'productdetails') {
	$prodcartbtn = $templateparams->get('prodcartbtn');
} else {
	$prodcartbtn = 1;
}

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
		<div id="t3-content" class="t3-content <?php if (!$prodcartbtn){ echo "fullwidth";} ?> <?php if (!$hide_asides) {echo "col-xs-12 col-sm-8 col-md-9";}else {echo "col-xs-12 col-md-12 col-sm-12";} ?>">
			<jdoc:include type="modules" name="<?php $this->_p('content-top') ?>" style="T3Xhtml" />
			<?php if($this->hasMessage()) : ?>
			<jdoc:include type="message" />
			<?php endif ?>
			<jdoc:include type="component" />
            <jdoc:include type="modules" name="<?php $this->_p('content-bottom') ?>" style="T3Xhtml" />
		</div>
		<!-- //MAIN CONTENT -->

		<!-- SIDEBAR RIGHT -->
		<?php
			//print_r($option.'lorem,');
		 if (!$hide_asides) { 
		  if ($prodcartbtn) { ?>
		<div class="t3-sidebar t3-sidebar-right col-xs-12 col-sm-4  col-md-3 <?php $this->_c($vars['sidebar']) ?>">
			<jdoc:include type="modules" name="<?php $this->_p($vars['sidebar']) ?>" style="T3Xhtml" />
		</div>
		<?php } else { ?>
		
		<?php } 
		} ?>
		<!-- //SIDEBAR RIGHT -->

	</div>
</div> 
<?php }
?>