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
 
jimport('joomla.application.component.controller');
 
$controller = JControllerLegacy::getInstance('Jmsmultiupload');
$task = JRequest::getCmd('task');
$controller->execute($task);
$controller->redirect();