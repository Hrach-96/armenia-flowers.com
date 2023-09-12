<?php
// No direct access
defined('_JEXEC') or die;

class CooltagsController extends JController
{
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/cooltags.php';

		CooltagsHelper::addSubmenu(JRequest::getCmd('view', ''));

		$view		= JRequest::getCmd('view', '');
        JRequest::setVar('view', $view);

		parent::display();

		return $this;
	}
}
