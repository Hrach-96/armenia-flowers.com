<?php
defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldTimeupdated extends JFormField
{
	protected $type = 'timeupdated';

	protected function getInput()
	{
		$html = array();
        
        
		$old_time_updated = $this->value;
        if (!$old_time_updated) {
            $html[] = '-';
        } else {
            $jdate = new JDate($old_time_updated);
            $pretty_date = $jdate->format(JText::_('DATE_FORMAT_LC2'));
            $html[] = "<div>".$pretty_date."</div>";
        }
        $time_updated = date("Y-m-d H:i:s");
        $html[] = '<input type="hidden" name="'.$this->name.'" value="'.$time_updated.'" />';
        
		return implode($html);
	}
}