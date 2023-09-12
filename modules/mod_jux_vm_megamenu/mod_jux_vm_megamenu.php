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

require_once dirname(__FILE__) . '/helper.php';
require_once dirname(__FILE__).'/includes/menu/vm_megamenu.php';

if(!defined('DEMO_MODE')) {
    // Change DEMO_MODE value to 1 to enable the demo mode.
    define('DEMO_MODE', 0);
}

if(DEMO_MODE) {
	$input = JFactory::getApplication()->input;
	$data = $input->post->get('jux_demo_control_form', array(), 'array');

	$properties = $params->toArray();
	foreach($properties as $key => $value) {
		$params->set($key, isset($data[$key]) ? $data[$key] : $value);
	}
}

$hozorver	= $params->get('hozorver', 'horizontal');
$menuStyle	= '';
if($hozorver == 'horizontal') {
	$menuStyle	.= ' horizontal-'.$params->get('horizontal_submenu_direction','down').' ';
    $menuStyle  .= 'jux-'.$params->get('horizontal_menustyle', 'left');
} else {
    $menuStyle	.= ' jux-vertical ';
    if($params->get('vertical_submenu_direction', 'lefttoright') == 'lefttoright') {
        $menuStyle	.= 'jux-left';
    } else {
		$menuStyle	.= 'jux-right';
	}
}


$document = JFactory::getDocument();



if ($params->get('load_font_awesome',0) && !defined('_JUX_MEGAEMENU_FONT_AWESOME')){
	define('_JUX_MEGAEMENU_FONT_AWESOME', 1);
	$document->addStyleSheet('modules/'.$module->module.'/assets/font-awesome/css/font-awesome.css');
}


$document->addStyleSheet('modules/mod_jux_vm_megamenu/assets/css/style.css');
$document->addStyleSheet('modules/mod_jux_vm_megamenu/assets/css/default.css');
//customcss = 'modules/mod_jux_vm_megamenu/assets/css/style/custom-'.$module->id.'.css';
//if (modJUXVMMegamenuHelper::getCssProcessor($params,$customcss,'#juxvm_mm_'.$module->id)){
	//$document->addStyleSheet($customcss);
//}
require (JModuleHelper::getLayoutPath('mod_jux_vm_megamenu'));



