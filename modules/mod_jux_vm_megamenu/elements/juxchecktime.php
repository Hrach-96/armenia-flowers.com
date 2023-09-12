<?php
/**
 * @version		$Id$
 * @author		JoomlaUX
 * @package		Joomla.Site
 * @subpackage	mod_jux_vm_megamenu
 * @copyright	Copyright (C) 2008 - 2013 JoomlaUX. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');
 
class JFormFieldJUXChecktime extends JFormFieldHidden {
	
	protected $type = 'juxchecktime';
	
	protected function getInput()
	{
		$valueArr = $this->value;
		$html = array();
		$html[] = '<input type="hidden" data-time ='.strtotime(date('Y-m-d H:i:s')).'  name="' . $this->name . '" id="' . $this->id . '" value="'
		. strtotime(date('Y-m-d H:i:s')) .'" />';
		
		return implode($html);
	}
	
	protected function getLabel(){
		return '';
	}
	
}