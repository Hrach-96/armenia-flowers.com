<?php
defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldCustom_field extends JFormField
{
	protected $type = 'text';

	protected function getInput()
	{
		$html = array();

		return implode($html);
	}
}