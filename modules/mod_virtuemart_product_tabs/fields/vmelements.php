<?php
defined('_JEXEC') or die;

jimport('joomla.form.formfield');
if (version_compare(JVERSION, '1.6.0', 'ge')) {
	abstract class VmElements extends JFormField {
		abstract function renderElement($name, $value, $xmlElement, $control_name);
		// This line is required to keep Joomla! 1.6/1.7 from complaining
		public function getInput() {
			return $this->renderElement($this->name, $this->value, $this, $this->id);
		}
	}
} else {
	abstract class VmElements extends JElement {
		abstract function renderElement($name, $value, $xmlElement, $control_name);
		public function fetchElement($name, $value, $xmlElement, $control_name){
			return $this->renderElement($name, $value, $xmlElement, $control_name);
		}
	}
}