<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_2
 * @license    GNU/GPL
	*/

// No direct access
defined( '_JEXEC' ) or die;


/**
 * HTML View class for the HelloWorld Component
 *
 * @package    HelloWorld
 */

class WishlistsViewWishlists extends JViewLegacy
{
	function display($tpl = null)
	{
		$app = JFactory::getApplication();
		$pathway = $app->getPathway();
		$pathway->addItem(JText::_('COM_WISHLISTS_PRODUCT'),JRoute::_('index.php?option=com_wishlists&view=wishlists'));
		parent::display($tpl);
	}
}