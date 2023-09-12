<?php
// no direct access
defined('_JEXEC') or die;

if (!JFactory::getUser()->authorise('core.manage', 'com_cooltags')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

JToolBarHelper::title(   JText::_( 'CoolTags - The tagging solution for Virtuemart2' ), 'cpanel.png' );
JToolBarHelper::preferences('com_cooltags', 600, 860);
