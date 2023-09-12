<?php
/**
 * @package  JMS Multi Image Upload for Virtuemart
 * @version  1.0
 * @copyright Copyright (coffee) 2009 - 2013 Joommasters. All rights reserved.
 * @License  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @Website: http://www.joommasters.com
 **/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HelloWorlds View
 */
class JmsmultiuploadViewUpload extends JViewLegacy
{
        /**
         * HelloWorlds view display method
         * @return void
         */
        function display($tpl = null) 
        {
        	$type = JRequest::getVar('type');
        	if($type == 'ajax'){
            	require_once JPATH_COMPONENT.'/helpers/UploadHandler.php';
				$upload	= new UploadHandler();	
				exit;
        	}
        	else{        				
        		parent::display($tpl);
        		$this->addToolbar();
        	}			
        }
	protected function addToolbar()
	{	
		JToolBarHelper::title(JText::_('JMS Multiupload'), 'menumgr.png');
		JToolBarHelper::divider();
	}
}
?>