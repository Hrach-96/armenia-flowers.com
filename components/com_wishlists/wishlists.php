<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
 * components/com_hello/hello.php
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_1#Creating_the_Entry_Point
 * @license    GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die;

// Require the base controller
$controller = JControllerLegacy::getInstance( 'wishlists' );
$controller->execute( JFactory::getApplication()->input->get( 'task' ) );
$controller->redirect();