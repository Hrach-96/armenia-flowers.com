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

class JFormFieldLabelspacer extends JFormField {
	
	protected $type= "labelspacer";
	
	protected function getLabel(){
		return '<span class="label label-info jux-label">'.parent::getTitle().'</span>';
	}
	
	protected function getInput(){
		return '';
	}
}