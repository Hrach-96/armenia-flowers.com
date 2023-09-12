<?php
/**
 * @version   $Id$
 * @author    JoomlaUX
 * @package   Joomla.Site
 * @subpackage  mod_jux_vm_megamenu
 * @copyright Copyright (C) 2008 - 2013 JoomlaUX. All rights reserved.
 * @license   License GNU General Public License version 2 or later; see LICENSE.txt, see LICENSE.php
 */

defined('_JEXEC') or die('Restricted access'); 



class JFormFieldMegamenu extends JFormField {

  protected $type = 'Megamenu';
  
  protected function loadjQuery(){
    if (!defined('_JUX_JQUERY')){
      define('_JUX_JQUERY', 1);
      $jdoc = JFactory::getDocument();
      $jdoc->addScript(JURI::root(true).'/modules/mod_jux_vm_megamenu/assets/js/jquery.min.js');
      $jdoc->addScript(JURI::root(true).'/modules/mod_jux_vm_megamenu/assets/js/jquery.noconflict.js');
      $jdoc->addScript(JURI::root(true).'/modules/mod_jux_vm_megamenu/assets/bootstrap/js/bootstrap.js');
    }
  }
  
  protected function getInput()
    {

      if (!file_exists(JPATH_SITE.'/'.'components'.'/'.'com_virtuemart')){
      return '<div style="float: left;color:red">This module can not work without the Virtuemart Component</div>';
    }
    
    require_once dirname(dirname(__FILE__)).'/includes/menu/vm_megamenu.php';    
      //check for version compactible
      $japp = JFactory::getApplication();
    $jdoc = JFactory::getDocument();
    
      $jversion  = new JVersion;
    if(!$jversion->isCompatible('3.0')){
      $this->loadjQuery();
      $jdoc->addStyleSheet(JUri::root(true).'/modules/mod_jux_vm_megamenu/elements/assets/css/admin-j25.css');
      $jdoc->addScriptDeclaration('
        jQuery(document).ready(function($){
          $("#jux-admin-megamenu").closest("li").addClass("jux-admin-megamenu-controls");
        });
      ');
      
    }else{
      $jdoc->addStyleSheet(JUri::root(true).'/modules/mod_jux_vm_megamenu/elements/assets/css/admin-j30.css');
    }
    $jdoc->addScript(JURI::root(true).'/modules/mod_jux_vm_megamenu/elements/assets/js/megamenu.js');
    $jdoc->addStyleSheet(JUri::root(true).'/modules/mod_jux_vm_megamenu/elements/assets/css/megamenu.css');
    $jdoc->addScriptDeclaration('
      var ROOT_URL = \'' . JURI::root() . '\';
      var BASE_URL = \'' . JURI::root(true) . '/\';
      var MOD_ACTION =  \'' . JURI::root() . 'modules/mod_jux_vm_megamenu/includes/action.php\';
      var JUXM_CLEAR_CONFIG = \''.JText::_('JUXM_CLEAR_CONFIG').'\';
    ');
    $vmMegamenu = new VMMegamenu();

    $params = new JRegistry();
    $params->loadObject($this->form->getValue('params'));

    list($menu,$mega_order) = $vmMegamenu->render($params); 
    $jdoc->addScriptDeclaration('
      jQuery(document).ready(function(){
          jQuery("#'.$this->getId('','mega_order').'").prop("value",\''.$mega_order.'\');
        });
    '); 

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('id, title, module, position');
$query->from('#__modules');
$query->where('published = 1');
$query->where('client_id = 0');
$query->order('title');
$db->setQuery($query);
$modules = $db->loadObjectList();
 $html ='
<div id="jux-admin-megamenu" class="jux-admin-megamenu ">
  <div class="admin-inline-toolbox clearfix">
    <div class="jux-admin-mm-row clearfix">
      
      <div id="jux-admin-mm-intro" class="pull-left">
        <h3>'.JTexT::_('JUX_NAVIGATION_MM_TOOLBOX') .'</h3>
        <p>'.JTexT::_('JUX_NAVIGATION_MM_TOOLBOX_DESC') .'</p>
      </div>
      
      <div id="jux-admin-mm-tb">
        <div id="jux-admin-mm-toolitem" class="admin-toolbox">
          <h3>'.JTexT::_('JUX_NAVIGATION_MM_ITEM_CONF') .'</h3>
          <ul>
            <li>
              <label class="hasTip" title="'.JTexT::_('JUX_NAVIGATION_MM_DISPLAY'). '::'. JTexT::_('JUX_NAVIGATION_MM_DISPLAY_DESC') .'">'.JTexT::_('JUX_NAVIGATION_MM_DISPLAY') .'</label>
              <fieldset class="radio btn-group toolitem-display">
                <input type="radio" id="toggleDisplay0" class="toolbox-toggle" data-action="toggleDisplay" name="toggleDisplay" value="0"/>
                <label for="toggleDisplay0">'.JTexT::_('JNO') .'</label>
                <input type="radio" id="toggleDisplay1" class="toolbox-toggle" data-action="toggleDisplay" name="toggleDisplay" value="1" checked="checked"/>
                <label for="toggleDisplay1">'.JTexT::_('JYES') .'</label>
              </fieldset>
            </li>
          </ul>
          <ul>
            <li>
              <label class="hasTip" title="'.JTexT::_('JUX_NAVIGATION_MM_SUBMENU'). '::'. JTexT::_('JUX_NAVIGATION_MM_SUBMENU_DESC') .'">'.JTexT::_('JUX_NAVIGATION_MM_SUBMENU') .'</label>
              <fieldset class="radio btn-group toolitem-sub">
                <input type="radio" id="toggleSub0" class="toolbox-toggle" data-action="toggleSub" name="toggleSub" value="0"/>
                <label for="toggleSub0">'.JTexT::_('JNO') .'</label>
                <input type="radio" id="toggleSub1" class="toolbox-toggle" data-action="toggleSub" name="toggleSub" value="1" checked="checked"/>
                <label for="toggleSub1">'.JTexT::_('JYES') .'</label>
              </fieldset>
            </li>
          </ul>
          <ul>
            <li>
              <label class="hasTip" title="'.JTexT::_('JUX_NAVIGATION_MM_GROUP'). '::'. JTexT::_('JUX_NAVIGATION_MM_GROUP_DESC') .'">'.JTexT::_('JUX_NAVIGATION_MM_GROUP') .'</label>
              <fieldset class="radio btn-group toolitem-group">
                <input type="radio" id="toggleGroup0" class="toolbox-toggle" data-action="toggleGroup" name="toggleGroup" value="0"/>
                <label for="toggleGroup0">'.JTexT::_('JNO') .'</label>
                <input type="radio" id="toggleGroup1" class="toolbox-toggle" data-action="toggleGroup" name="toggleGroup" value="1" checked="checked"/>
                <label for="toggleGroup1">'.JTexT::_('JYES') .'</label>
              </fieldset>
            </li>
          </ul>
          <ul>
            <li>
              <label class="hasTip" title="'.JTexT::_('JUX_NAVIGATION_MM_POSITIONS'). '::'.JTexT::_('JUX_NAVIGATION_MM_POSITIONS_DESC') .'">'.JTexT::_('JUX_NAVIGATION_MM_POSITIONS') .'</label>
              <fieldset class="btn-group">
                <a href="" class="btn toolitem-moveleft toolbox-action" data-action="moveItemsLeft" title="'.JTexT::_('JUX_NAVIGATION_MM_MOVE_LEFT') .'"><i class="icon-arrow-left"></i></a>
                <a href="" class="btn toolitem-moveright toolbox-action" data-action="moveItemsRight" title="'.JTexT::_('JUX_NAVIGATION_MM_MOVE_RIGHT') .'"><i class="icon-arrow-right"></i></a>
              </fieldset>
            </li>
          </ul>
          <ul>
            <li>
              <label class="hasTip" title="'.JTexT::_('JUX_NAVIGATION_MM_EX_CLASS'). '::'.JTexT::_('JUX_NAVIGATION_MM_EX_CLASS_DESC') .'">'.JTexT::_('JUX_NAVIGATION_MM_EX_CLASS') .'</label>
              <fieldset class="">
                <input type="text" class="input-medium toolitem-exclass toolbox-input" name="toolitem-exclass" data-name="class" value="" />
              </fieldset>
            </li>
          </ul>
          <ul>
            <li>
              <label class="hasTip" title="'.JTexT::_('JUX_NAVIGATION_MM_ICON'). '::'. JTexT::_('JUX_NAVIGATION_MM_ICON_DESC') .'">
                '.JTexT::_('JUX_NAVIGATION_MM_ICON') .'
              </label>
              <fieldset class="">
                
                <input type="text" class="input-medium toolitem-xicon toolbox-input" name="toolitem-xicon" data-name="xicon" value="" />
              <a style="display: block;" href="http://fortawesome.github.io/Font-Awesome" target="_blank"><i class="icon-search"></i> '.JTexT::_('JUX_NAVIGATION_MM_ICON').'</a>
                    </fieldset>
            </li>
          </ul>
          <ul>
            <li>
              <label class="hasTip" title="'.JTexT::_('JUX_NAVIGATION_MM_CAPTION'). '::'. JTexT::_('JUX_NAVIGATION_MM_CAPTION_DESC') .'">
                '.JTexT::_('JUX_NAVIGATION_MM_CAPTION') .'
              </label>
              <fieldset class="">
                <input type="text" class="input-medium toolitem-caption toolbox-input" name="toolitem-caption" data-name="caption" value="" />
              </fieldset>
            </li>
          </ul>
        </div>

        <div id="jux-admin-mm-toolsub" class="admin-toolbox">
          <h3>'.JTexT::_('JUX_NAVIGATION_MM_SUBMNEU_CONF') .'</h3>
          <ul>
            <li>
              <label class="hasTip" title="'.JTexT::_('JUX_NAVIGATION_MM_SUBMNEU_GRID'). '::'.JTexT::_('JUX_NAVIGATION_MM_SUBMNEU_GRID_DESC') .'">'.JTexT::_('JUX_NAVIGATION_MM_SUBMNEU_GRID') .'</label>
              <fieldset class="btn-group">
                <a href="" class="btn toolsub-addrow toolbox-action" data-action="addRow"><i class="icon-plus"></i></a>
              </fieldset>
            </li>
          </ul>
          <ul>
            <li>
              <label class="hasTip" title="'.JTexT::_('JUX_NAVIGATION_MM_HIDE_COLLAPSE'). '::'. JTexT::_('JUX_NAVIGATION_MM_HIDE_COLLAPSE_DESC') .'">'.JTexT::_('JUX_NAVIGATION_MM_HIDE_COLLAPSE') .'</label>
              <fieldset class="radio btn-group toolsub-hidewhencollapse">
                <input type="radio" id="togglesubHideWhenCollapse0" class="toolbox-toggle" data-action="hideWhenCollapse" name="togglesubHideWhenCollapse" value="0" checked="checked"/>
                <label for="togglesubHideWhenCollapse0">'.JTexT::_('JNO') .'</label>
                <input type="radio" id="togglesubHideWhenCollapse1" class="toolbox-toggle" data-action="hideWhenCollapse" name="togglesubHideWhenCollapse" value="1"/>
                <label for="togglesubHideWhenCollapse1">'.JTexT::_('JYES') .'</label>
              </fieldset>
            </li>
          </ul>                    
          <ul>
            <li>
              <label class="hasTip" title="'.JTexT::_('JUX_NAVIGATION_MM_SUBMNEU_WIDTH_PX'). '::'. JTexT::_('JUX_NAVIGATION_MM_SUBMNEU_WIDTH_PX_DESC') .'">'.JTexT::_('JUX_NAVIGATION_MM_SUBMNEU_WIDTH_PX') .'</label>
              <fieldset class="">
                <input type="text" class="toolsub-width toolbox-input input-small" name="toolsub-width" data-name="width" value="" />
              </fieldset>
            </li>
          </ul>
          <ul>
            <li>
              <label class="hasTip" title="'.JTexT::_('JUX_NAVIGATION_MM_ALIGN'). '::'.JTexT::_('JUX_NAVIGATION_MM_ALIGN_DESC') .'">'.JTexT::_('JUX_NAVIGATION_MM_ALIGN') .'</label>
              <fieldset class="toolsub-alignment">
                <div class="btn-group">
                <a class="btn toolsub-align-left toolbox-action" href="#" data-action="alignment" data-align="left" title="'.JTexT::_('JUX_NAVIGATION_MM_ALIGN_LEFT') .'"><i class="icon-align-left"></i></a>
                <a class="btn toolsub-align-right toolbox-action" href="#" data-action="alignment" data-align="right" title="'.JTexT::_('JUX_NAVIGATION_MM_ALIGN_RIGHT') .'"><i class="icon-align-right"></i></a>
                <a class="btn toolsub-align-center toolbox-action" href="#" data-action="alignment" data-align="center" title="'.JTexT::_('JUX_NAVIGATION_MM_ALIGN_CENTER') .'"><i class="icon-align-center"></i></a>
                <a class="btn toolsub-align-justify toolbox-action" href="#" data-action="alignment" data-align="justify" title="'.JTexT::_('JUX_NAVIGATION_MM_ALIGN_JUSTIFY') .'"><i class="icon-align-justify"></i></a>
                </div>
              </fieldset>
            </li>
          </ul>          
          <ul>
            <li>
              <label class="hasTip" title="'.JTexT::_('JUX_NAVIGATION_MM_EX_CLASS'). '::'.JTexT::_('JUX_NAVIGATION_MM_EX_CLASS_DESC') .'">'.JTexT::_('JUX_NAVIGATION_MM_EX_CLASS') .'</label>
              <fieldset class="">
                <input type="text" class="toolsub-exclass toolbox-input input-medium" name="toolsub-exclass" data-name="class" value="" />
              </fieldset>
            </li>
          </ul>
        </div>

        <div id="jux-admin-mm-toolcol" class="admin-toolbox">
          <h3>'.JTexT::_('JUX_NAVIGATION_MM_COLUMN_CONF') .'</h3>
          <ul>
            <li>
              <label class="hasTip" title="'.JTexT::_('JUX_NAVIGATION_MM_ADD_REMOVE_COLUMN').'::'. JTexT::_('JUX_NAVIGATION_MM_ADD_REMOVE_COLUMN_DESC') .'">'.JTexT::_('JUX_NAVIGATION_MM_ADD_REMOVE_COLUMN') .'</label>
              <fieldset class="btn-group">
                <a href="" class="btn toolcol-addcol toolbox-action" data-action="addColumn"><i class="icon-plus"></i></a>
                <a href="" class="btn toolcol-removecol toolbox-action" data-action="removeColumn"><i class="icon-minus"></i></a>
              </fieldset>
            </li>
          </ul>
          <ul>
            <li>
              <label class="hasTip" title="'.JTexT::_('JUX_NAVIGATION_MM_HIDE_COLLAPSE'). '::'. JTexT::_('JUX_NAVIGATION_MM_HIDE_COLLAPSE_DESC') .'">'.JTexT::_('JUX_NAVIGATION_MM_HIDE_COLLAPSE') .'</label>
              <fieldset class="radio btn-group toolcol-hidewhencollapse">
                <input type="radio" id="toggleHideWhenCollapse0" class="toolbox-toggle" data-action="hideWhenCollapse" name="toggleHideWhenCollapse" value="0" checked="checked"/>
                <label for="toggleHideWhenCollapse0">'.JTexT::_('JNO') .'</label>
                <input type="radio" id="toggleHideWhenCollapse1" class="toolbox-toggle" data-action="hideWhenCollapse" name="toggleHideWhenCollapse" value="1"/>
                <label for="toggleHideWhenCollapse1">'.JTexT::_('JYES') .'</label>
              </fieldset>
            </li>
          </ul>          
          <ul>
            <li>
              <label class="hasTip" title="'.JTexT::_('JUX_NAVIGATION_MM_WIDTH_SPAN').'::'.JTexT::_('JUX_NAVIGATION_MM_WIDTH_SPAN_DESC') .'">'.JTexT::_('JUX_NAVIGATION_MM_WIDTH_SPAN') .'</label>
              <fieldset class="">
                <select class="toolcol-width toolbox-input toolbox-select input-mini" name="toolcol-width" data-name="width">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                </select>
              </fieldset>
            </li>
          </ul>
          <ul>
            <li>
              <label class="hasTip" title="'.JTexT::_('JUX_NAVIGATION_MM_MODULE'). '::'. JTexT::_('JUX_NAVIGATION_MM_MODULE_DESC') .'">'.JTexT::_('JUX_NAVIGATION_MM_MODULE') .'</label>
              <fieldset class="">
                <select class="toolcol-position toolbox-input toolbox-select input-medium" name="toolcol-position" data-name="position" data-placeholder="'.JTexT::_('JUX_NAVIGATION_MM_SELECT_MODULE') .'">
                  <option value=""></option>
                  ';?>
                  <?php 
                  foreach ($modules as $module) {
                    $html .= "<option value=\"{$module->id}\">{$module->title}</option>\n";
                  } ?>
                  <?php 
                  $html .= '
                </select>
              </fieldset>
            </li>
          </ul>
          <ul>
            <li>
              <label class="hasTip" title="'.JTexT::_('JUX_NAVIGATION_MM_EX_CLASS'). '::'. JTexT::_('JUX_NAVIGATION_MM_EX_CLASS_DESC') .'">'.JTexT::_('JUX_NAVIGATION_MM_EX_CLASS') .'</label>
              <fieldset class="">
                <input type="text" class="input-medium toolcol-exclass toolbox-input" name="toolcol-exclass" data-name="class" value="" />
              </fieldset>
            </li>
          </ul>
        </div>    
      </div> 
      
      <div class="toolbox-actions-group">
        <button class="jux-admin-tog-fullscreen toolbox-action toolbox-togglescreen" data-action="toggleScreen" data-iconfull="icon-resize-full" data-iconsmall="icon-resize-small"><i class="icon-resize-full"></i></button>
    <button class="juxm-admin-clear-config" id="JUXMClearConfig" type="button"><i class="icon-remove"></i></button>
        <button class="btn btn-success toolbox-action toolbox-saveConfig hide" data-action="saveConfig"><i class="icon-save"></i>'.JTexT::_('JUX_NAVIGATION_MM_SAVE') .'</button>
      </div>

    </div>
  </div>
  
  <div id="jux-admin-mm-container" class="navbar clearfix">
    '.$menu .'
  </div>
</div>';
      return $html;
    }
}
