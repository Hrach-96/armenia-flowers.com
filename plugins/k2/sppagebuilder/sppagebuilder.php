<?php
/**
* @package SP Page Builder
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2016 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('restricted aceess');

$k2_plg_path = JPATH_ADMINISTRATOR.'/components/com_k2/lib/k2plugin.php';
if (!file_exists($k2_plg_path)) {
 return;
}

$sppb_helper_path = JPATH_ADMINISTRATOR . '/components/com_sppagebuilder/helpers/sppagebuilder.php';
if (!file_exists($sppb_helper_path)) {
 return;
}

JLoader::register('K2Plugin', $k2_plg_path);
if(!class_exists('SppagebuilderHelper')) {
	require_once $sppb_helper_path;
}

// Initiate class to hold plugin events
class plgK2Sppagebuilder extends K2Plugin
{
	// Some params
	var $pluginName = 'sppagebuilder';
	var $pluginNameHumanReadable = 'K2 - SP Page Builder';

	function __construct(&$subject, $params) {
		parent::__construct($subject, $params);
	}

	public static function __context() {
		$context = array(
			'option'=>'com_k2',
			'view'=>'item',
			'id_alias'=>'cid'
		);
		return $context;
	}

	function onAfterK2Save($row, $isNew) {

    $isSppagebuilderEnabled = $this->isSppagebuilderEnabled();
    if ( !$isSppagebuilderEnabled ) return;

		$input = JFactory::getApplication()->input;
		$option = $input->get('option', '', 'STRING');
		$view = $input->get('view', '', 'STRING');
		$form = $input->post->get('jform', array(), 'ARRAY');

		$sppagebuilder_active = (isset($form['attribs']['sppagebuilder_active']) && $form['attribs']['sppagebuilder_active']) ? $form['attribs']['sppagebuilder_active'] : 0;
		$sppagebuilder_content = (isset($form['attribs']['sppagebuilder_content']) && $form['attribs']['sppagebuilder_content']) ? $form['attribs']['sppagebuilder_content'] : '[]';

		$values = array(
			'title' => $row->title,
			'text' => $sppagebuilder_content,
			'option' => $option,
			'view' => $view,
			'id' => $row->id,
			'active' => $sppagebuilder_active,
			'created_on' => $row->created,
			'created_by' => $row->created_by,
			'modified' => $row->modified,
			'modified_by' => $row->modified_by,
			'language' => '*'
		);

		SppagebuilderHelper::onAfterIntegrationSave($values);

	}

	function onK2PrepareContent(&$item, &$params, $limitstart) {
		$input = JFactory::getApplication()->input;
		$option = $input->get('option', '', 'STRING');
		$view = $input->get('view', '', 'STRING');

    $isSppagebuilderEnabled = $this->isSppagebuilderEnabled();

    if ( $isSppagebuilderEnabled ) {
      if (SppagebuilderHelper::onIntegrationPrepareContent($item->text, $option, $view, $item->id)) {
  			$item->text = SppagebuilderHelper::onIntegrationPrepareContent($item->text, $option, $view, $item->id);
  		}
    }
	}

  private function isSppagebuilderEnabled(){
    $db = JFactory::getDbo();
    $db->setQuery("SELECT enabled FROM #__extensions WHERE element = 'com_sppagebuilder' AND type = 'component'");
    return $is_enabled = $db->loadResult();
  }

}
