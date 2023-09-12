<?php
/**
 * @version		$Id$
 * @author		JoomlaUX
 * @package		Joomla.Site
 * @subpackage	mod_jux_vm_megamenu
 * @copyright	Copyright (C) 2008 - 2013 JoomlaUX. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

class JFormFieldjuxColor extends JFormField{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.3
	 */
	protected $type = 'juxcolor';

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.3
	 */
	protected function getInput()
	{
		// Control value can be: hue (default), saturation, brightness, wheel or simpel
		$control = (string) $this->element['control'];

		// Position of the panel can be: right (default), left, top or bottom
		$position = $this->element['position'] ? (string) $this->element['position'] : 'right';
		$position = ' data-position="' . $position . '"';

		$onchange = $this->element['onchange'] ? ' onchange="' . (string) $this->element['onchange'] . '"' : '';
		$class = (string) $this->element['class'];

		$color = strtolower($this->value);

		if (!$color || in_array($color, array('none', 'transparent')))
		{
			$color = 'none';
		}
		elseif ($color['0'] != '#')
		{
			$color = '#' . $color;
		}

		
		$class = ' class="' . trim('jux-colorpicker ' . $class) . '"';
		$control = $control ? ' data-control="' . $control . '"' : '';
		$disabled = ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';

		$this->addcolorPicker();

		return '<input type="text" name="' . $this->name . '" id="' . $this->id . '"' . ' value="'
			. htmlspecialchars($color, ENT_COMPAT, 'UTF-8') . '"' . $class . $position . $control . $disabled . $onchange . '/>';
		
	}
	
	protected function loadjQuery(){
		if (!defined('_JUX_JQUERY')){
			define('_JUX_JQUERY', 1);
			$jdoc = JFactory::getDocument();
			$jdoc->addScript(JURI::root(true).'/modules/mod_jux_vm_megamenu/assets/js/jquery.min.js');
			$jdoc->addScript(JURI::root(true).'/modules/mod_jux_vm_megamenu/assets/js/jquery.noconflict.js');
			$jdoc->addScript(JURI::root(true).'/modules/mod_jux_vm_megamenu/assets/bootstrap/js/bootstrap.js');
		}
	}
	
	protected function addcolorPicker(){
		if (!defined("_JUX_COLORPIKER")){
			define("_JUX_COLORPIKER",1);
			// Include jQuery
			$jdoc = JFactory::getDocument();
			
			$jversion  = new JVersion;
			if(!$jversion->isCompatible('3.0')){
				$this->loadjQuery();
			}
			$jdoc->addScript(JURI::root(true).'/modules/mod_jux_vm_megamenu/assets/minicolors/js/jquery.minicolors.min.js');
			$jdoc->addStyleSheet(JURI::root(true).'/modules/mod_jux_vm_megamenu/assets/minicolors/css/jquery.minicolors.css');
			$jdoc->addScriptDeclaration("
				jQuery(document).ready(function (){
					jQuery('.jux-colorpicker').each(function() {
						jQuery(this).minicolors({
							control: jQuery(this).attr('data-control') || 'hue',
							position: jQuery(this).attr('data-position') || 'right',
							opacity: jQuery(this).attr('data-opacity'),
							theme: 'bootstrap'
						});
					});
					 // tooltip 
					jQuery('[data-toggle=tooltip]').tooltip({}); 
				});
			"
			);
			$jdoc->addStyleDeclaration("
				.minicolors-opacity-slider {
				    background-position: -40px 0;
				    display: none;
				    left: 178px !important;
				}
			");
		}
	}
}
