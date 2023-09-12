<?php
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class CooltagsViewLegacyswitch extends JViewLegacy
{

	public function display($tpl = null)
	{
		
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
        
		$this->counttobeconverted = get('countToboconverted');
	}   
}