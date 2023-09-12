<?php
/**
 * @version		$Id$
 * @author		JoomlaUX
 * @package		Joomla.Site
 * @subpackage	mod_jux_vm_megamenu
 * @copyright	Copyright (C) 2008 - 2013 JoomlaUX. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 

if (!class_exists('modJUXMegaMenuCss')){
	require_once dirname(__FILE__).'/includes/css.php';
}

class modJUXVMMegamenuHelper {
	
	public static function getCssProcessor(&$params,$filename,$prefix){
		return modJUXMegaMenuCss::process($params,$filename,$prefix);		
	}
}
