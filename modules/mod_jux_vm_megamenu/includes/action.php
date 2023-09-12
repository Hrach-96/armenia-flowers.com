<?php
/**
 * @version		$Id$
 * @author		JoomlaUX
 * @package		Joomla.Site
 * @subpackage	mod_jux_vm_megamenu
 * @copyright	Copyright (C) 2008 - 2013 JoomlaUX. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
 */

if (!defined('_JEXEC')) {
    define('_JEXEC', 1);
    $path = dirname(dirname(dirname(dirname(__FILE__))));
    if (!defined('JPATH_BASE'))
    	define('JPATH_BASE', $path);
    if (!defined('DS'))
    	define('DS',DIRECTORY_SEPARATOR);
    
    require_once JPATH_BASE . '/includes/defines.php';
    require_once JPATH_BASE . '/includes/framework.php';
    
    // Mark afterLoad in the profiler.
	JDEBUG ? $_PROFILER->mark('afterLoad') : null;
	
	// Instantiate the application.
	$app = JFactory::getApplication('site');

	// Initialise the application.
	$app->initialise();
	
	
}
// no direct access
defined('_JEXEC') or die('Restricted access'); 

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.application.module.helper');
jimport( 'joomla.html.parameter' );

//include(PATH.'/index.php');

$task = isset($_REQUEST['task']) ? $_REQUEST['task'] : false ;
if ($task){
	$language = JFactory::getLanguage();
	$adminHelper = new modJUXMegaMenuAction();
	$adminHelper->$task();
	
}

class modJUXMegaMenuAction {
	
	public function module(){
		$app = JFactory::getApplication();
		$input = $app->input;
		$mid = $input->getInt('mid');
		$base_url =  urldecode(trim($input->getString('base_url')));
		$module = null;
		$buffer = '';
		if ($mid){
			// load module
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('m.id, m.title, m.module, m.position, m.content, m.showtitle, m.params');
			$query->from('#__modules AS m');
			$query->where('m.id = '.$mid);
			$query->where('m.published = 1');
			$db->setQuery($query);
			$module = $db->loadObject ();
		}
		if (!empty ($module)) {
			$buffer = JModuleHelper::renderModule($module,array('style'=>'xhtml'));
			// replace relative images url
			$buffer = str_replace(JURI::base(),$base_url,$buffer);
		}

		//remove invisibile content, there are more ... but ...
		$buffer = preg_replace(array( '@<style[^>]*?>.*?</style>@siu', '@<script[^>]*?.*?</script>@siu'), array('', ''), $buffer);

		echo $buffer;
	}
}

