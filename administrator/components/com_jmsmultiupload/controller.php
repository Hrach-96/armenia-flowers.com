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
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of HelloWorld component
 */
class JmsmultiuploadController extends JControllerLegacy
{
        /**
         * display task
         *
         * @return void
         */
        function display($cachable = false, $urlparams = false) 
        {                
                $input = JFactory::getApplication()->input;
                $input->set('view', $input->getCmd('view', 'upload'));         
                parent::display($cachable);
        }
}
?>