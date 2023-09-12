<?php
/**
 * @package  JMS Multi Image Upload for Virtuemart
 * @version  1.0
 * @copyright Copyright (coffee) 2009 - 2013 Joommasters. All rights reserved.
 * @License  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @Website: http://www.joommasters.com
 **/

//-- No direct access
defined('_JEXEC') || die('=;)');

//jimport('joomla.plugin.plugin');
//jimport( 'joomla.environment.response' );

/**
 * System Plugin.
 *
 * @package    ScrollTop
 * @subpackage Plugin
 */
class plgSystemJmsmultiupload extends JPlugin
{
    /**
     * Constructor
     *
     * @param object $subject The object to observe
     * @param array $config  An array that holds the plugin configuration
     */
    public function __construct(& $subject, $config)
    {
        parent::__construct($subject, $config);
    }

    public function onBeforeRender()
    {    	
        $app 		= JFactory::getApplication();
        $doc 		= JFactory::getDocument();
        $option 	= JRequest::getVar('option');        
        $view		= JRequest::getVar('view');
        $task		= JRequest::getVar('task');     
        if($option == 'com_virtuemart' && $view == 'product' && $task == 'edit'){     
            $doc->addScript(JURI::root(true) . '/plugins/system/jmsmultiupload/assets/js/load-image.all.min.js');
	        $doc->addScript(JURI::root(true) . '/plugins/system/jmsmultiupload/assets/js/jquery.iframe-transport.js');
	        $doc->addScript(JURI::root(true) . '/plugins/system/jmsmultiupload/assets/js/vendor/jquery.ui.widget.js');
	        $doc->addScript(JURI::root(true) . '/plugins/system/jmsmultiupload/assets/js/jquery.fileupload.js');
            $doc->addScript(JURI::root(true) . '/plugins/system/jmsmultiupload/assets/js/jquery.fileupload-process.js');
            $doc->addScript(JURI::root(true) . '/plugins/system/jmsmultiupload/assets/js/jquery.fileupload-image.js');
	        $doc->addScript(JURI::root(true) . '/plugins/system/jmsmultiupload/assets/js/multiupload.js');
	        $doc->addScript(JURI::root(true) . '/plugins/system/jmsmultiupload/assets/js/upload.js');	       
	        //$doc->addStyleSheet(JURI::root(true) . '/plugins/system/jmsmultiupload/assets/css/style.css');                           	
        	$base	= JURI::base(true).'/';        	     	
			$buffer = JResponse::getBody();
			JResponse::setBody($buffer);
			return true;
        }              
    }    
}
