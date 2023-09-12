<?php 
defined( '_JEXEC' ) or die;
$controller = JControllerLegacy::getInstance( 'comparelist' );
$controller->execute( JFactory::getApplication()->input->get( 'task' ) );
$controller->redirect();
?>