<?php
defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldCreatedby extends JFormField
{

	protected $type = 'createdby';

	protected function getInput()
	{
		$html = array();
        
		$user_id = $this->value;
		if ($user_id) {
			$user = JFactory::getUser($user_id);
		} else {
			$user = JFactory::getUser();
			$html[] = '<input type="hidden" name="'.$this->name.'" value="'.$user->id.'" />';
		}
		$html[] = "<div>".$user->name." (".$user->username.")</div>";
        
		return implode($html);
	}
}