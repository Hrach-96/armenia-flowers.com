<?php
/**
 * @version		$Id$
 * @author		JoomlaUX
 * @package		Joomla.Site
 * @subpackage	mod_jux_k2_megamenu
 * @copyright	Copyright (C) 2008 - 2013 JoomlaUX. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.folder');
jimport('joomla.form.formfield');

class JFormFieldjuxPreset extends JFormField
{

	protected $type = 'juxPreset';

	/**
	 * fetch Element
	 */
	protected function getInput(){
		$db = JFactory::getDBO();
		$document = JFactory::getDocument();

		$presetArr = $this->getPresetXml();
		$html = '';
		foreach ($presetArr as $key=>$preset){
			$preset['type'] =  isset($preset['type']) ? $preset['type'] : '';
			$preset['gradient_start'] = isset( $preset['gradient_start']) ? $preset['gradient_start']: '';
			$preset['gradient_end'] = isset($preset['gradient_end']) ? $preset['gradient_end'] : '';
			$gradient_start['gs_color_1'] = isset($gradient_start['gs_color_1']) ? $gradient_start['gs_color_1'] : '';
			$gradient_start['gs_color_2'] = isset($gradient_start['gs_color_2']) ? $gradient_start['gs_color_2'] : '';
			$gradient_end['ge_color_1'] = isset($gradient_end['ge_color_1']) ? $gradient_end['ge_color_1'] : '';
			$gradient_end['ge_color_2'] = isset($gradient_end['ge_color_2']) ? $gradient_end['ge_color_2'] : '';
			$gradient_start = $preset['gradient_start'];
			$gradient_end = $preset['gradient_end'];
			if ($preset['type'] == 'linear'){
				$style = '
				.jux_style_'.$key.' i{
					background: '.$gradient_start['gs_color_1'].';
					background: -moz-linear-gradient(top, '.$gradient_start['gs_color_1'].', '.$gradient_end['ge_color_1'].' 100%);
					background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,'.$gradient_start['gs_color_1'].'), color-stop(100%,'.$gradient_end['ge_color_1'].'));
					background: -webkit-linear-gradient(top, '.$gradient_start['gs_color_1'].' 0%,'.$gradient_end['ge_color_1'].' 100%);
					background: -o-linear-gradient(top, '.$gradient_start['gs_color_1'].' 0%,'.$gradient_end['ge_color_1'].' 100%);
					background: linear-gradient(to bottom,  '.$gradient_start['gs_color_1'].' 0%,'.$gradient_end['ge_color_1'].' 100%);
					background-repeat: repeat-x;
					filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\''.$gradient_start['gs_color_1'].'\', endColorstr=\''.$gradient_end['ge_color_1'].'\', GradientType=0);
					filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
				}
				';
			}elseif ($preset['type'] == 'glass'){
				$style = '
				.jux_style_'.$key.' i{
					background: '.$gradient_start['gs_color_1'].';
					background: -moz-linear-gradient(top, '.$gradient_start['gs_color_1'].' 0%, '.$gradient_start['gs_color_2'].' 50%, '.$gradient_end['ge_color_1'].' 50%,'.$gradient_end['ge_color_2'].' 100%);
					background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,'.$gradient_start['gs_color_1'].'), color-stop(50%,'.$gradient_start['gs_color_2'].'), color-stop(50%,'.$gradient_end['ge_color_1'].'), color-stop(100%,'.$gradient_end['ge_color_2'].'));
					background: -webkit-linear-gradient(top, '.$gradient_start['gs_color_1'].' 0%,'.$gradient_start['gs_color_2'].' 50%,'.$gradient_end['ge_color_1'].' 50%,'.$gradient_end['ge_color_2'].' 100%);
					background: -o-linear-gradient(top,  '.$gradient_start['gs_color_1'].' 0%,'.$gradient_start['gs_color_2'].' 50%,'.$gradient_end['ge_color_1'].' 50%,'.$gradient_end['ge_color_2'].' 100%); 
					background: -ms-linear-gradient(top,  '.$gradient_start['gs_color_1'].' 0%,'.$gradient_start['gs_color_2'].' 50%,'.$gradient_end['ge_color_1'].' 50%,'.$gradient_end['ge_color_2'].' 100%); 
					background: linear-gradient(to bottom,  '.$gradient_start['gs_color_1'].' 0%,'.$gradient_start['gs_color_2'].' 50%,'.$gradient_end['ge_color_1'].' 50%,'.$gradient_end['ge_color_2'].' 100%);
					filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\''.$gradient_start['gs_color_1'].'\', endColorstr=\''.$gradient_end['ge_color_2'].'\',GradientType=0 );
				}
				';
			}
			$document->addStyleDeclaration($style);
			$html .='<a id="juxpreset'.$key.'" onclick="preSet(this);" href="javascript:void(0)" data-type="'.$preset['type'].'" data-gradient-start = "'.htmlspecialchars(json_encode($gradient_start)).'" data-gradient-end = "'.htmlspecialchars(json_encode($gradient_end)).'" class="jux_style_btn '.($this->value == "juxpreset".$key ? 'jux-selected' : '').' jux_style_'.$key.'"><i></i></a>';
		}
		$selected = $this->value == "" ? "" : "preSet(jQuery('#".$this->value."'));";
		$document->addScriptDeclaration('
			jQuery(document).ready(function(){
				//'.$selected.'
				jQuery(".gradient_type").find("input[type=radio]").each(function(){
					if(jQuery(this).prop("checked")){
						juxTogger(jQuery(this));
					}
				});
			});
			function preSet(element){
				var gradient_start = jQuery(element).data("gradient-start"),
					gradient_end = jQuery(element).data("gradient-end"),
					type = jQuery(element).data("type"),
					gs_color_1 = jQuery("#jform_params_gs_color_1"),
					gs_color_2 = jQuery("#jform_params_gs_color_2"),
					ge_color_1 = jQuery("#jform_params_ge_color_1"),
					ge_color_2 = jQuery("#jform_params_ge_color_2"),
					gradient_type = null;
				jQuery(".gradient_type").find("input[type=radio]").each(function(){
					if(jQuery(this).prop("checked")){
						gradient_type = jQuery(this);
					}
				});

				jQuery(".jux_style_btn").removeClass("jux-selected");
				jQuery(element).addClass("jux-selected");
				jQuery("#juxpreset").prop("value",jQuery(element).attr("id"));
				
				gs_color_1.minicolors(\'value\', gradient_start.gs_color_1 || "");
				gs_color_2.minicolors(\'value\', gradient_start.gs_color_2 || gradient_start.gs_color_1);
				ge_color_1.minicolors(\'value\', gradient_end.ge_color_1 || "");
				ge_color_2.minicolors(\'value\', gradient_end.ge_color_2 || gradient_end.ge_color_1);
			}
			
			function juxTogger(element){
				var gs_color_2 = jQuery("#jform_params_gs_color_2"),
					ge_color_2 = jQuery("#jform_params_ge_color_2");
				if(jQuery(element).val() == "linear"){
					gs_color_2.closest(".control-group,li").addClass("jux-hide");
					ge_color_2.closest(".control-group,li").addClass("jux-hide");
				}else{
					gs_color_2.closest(".control-group,li").removeClass("jux-hide");
					ge_color_2.closest(".control-group,li").removeClass("jux-hide");
				}
			}
		');
		$document->addStyleDeclaration('
			.minicolors-swatch span{
				box-shadow: 0 0 0 transparent;
				-o-box-shadow: 0 0 0 transparent;
				-moz-box-shadow: 0 0 0 transparent;
				-webkit-box-shadow: 0 0 0 transparent;
			}
		');
		return $html. '<input type="hidden" name="' . $this->name . '" id="juxpreset" value="'
			. htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '" />';;
	}
	
	
	protected function getPresetXml(){
		$presetArr = array();
		$presetXml = simplexml_load_file(dirname(__FILE__).'/juxpreset.xml');
		$presets = $presetXml->preset;
		foreach ($presets as $preset){
			$key = (string) $preset->attributes()->id;
			
			$presetValue = array();
			$presetValue['type'] = (string) $preset->attributes()->type;
			$presetValue['gradient_start'] = array();
			$presetValue['gradient_end'] = array();
			$i = 1;
			foreach ($preset->gradient_start->color as $k=>$color){
				$presetValue['gradient_start']['gs_color_'.$i++] = (string)$color;
			}
			$j=1;
			foreach ($preset->gradient_end->color as $k=>$color){
				$presetValue['gradient_end']['ge_color_'.$j++] = (string)$color;
			}
			$presetArr[$key] = $presetValue;
		}
		return $presetArr;
	}
}