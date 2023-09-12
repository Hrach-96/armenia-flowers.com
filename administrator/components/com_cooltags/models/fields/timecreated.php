<?php
defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldTimecreated extends JFormField
{

	protected $type = 'timecreated';

	protected function getInput()
	{
		$html = array();
        
		$time_created = $this->value;
		if (!$time_created) {
			$time_created = date("Y-m-d H:i:s");
			$html[] = '<input type="hidden" name="'.$this->name.'" value="'.$time_created.'" />';
		}
		$jdate = new JDate($time_created);
		$pretty_date = $jdate->format(JText::_('DATE_FORMAT_LC2'));
		$html[] = "<div>".$pretty_date."</div>";
        
		return implode($html);
	}
}