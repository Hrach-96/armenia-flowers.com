<?php
/**
 * @vevmion		$Id$
 * @author		JoomlaUX
 * @package		Joomla.Site
 * @subpackage	mod_jux_vm_megamenu
 * @copyright	Copyright (C) 2008 - 2013 JoomlaUX. All rights reserved.
 * @license		License GNU General Public License vevmion 2 or later; see LICENSE.txt, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 
?>
<div id="juxvm_mm_<?php echo $module->id ?>" class="juxvm-megamenu <?php echo $menuStyle?> ">
<button class="button-bar" type="button">
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</button>
<a class="navbar-brand" href="javascript:void(0)"><?php echo JText::_('JUX_VM_MEGAMENU_MENU')?></a>
<?php 
if (!file_exists(JPATH_SITE.DS.'components'.DS.'com_virtuemart')){
			echo  '<div style="float: left;color:red">This module can not work without the Virtuemart Component</div>';
}else{
	$megamenu = new VMMegamenu();
	list($menu,$order) = $megamenu->render($params,true);
	echo $menu;	
}
	
	
?>
</div>