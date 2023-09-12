<?php

defined('_JEXEC') or die;

include_once 'vmelements.php';

class VmProductCategories extends VmElements{
	public function renderElement($name, $value, $xmlElement, $control_name){
		$options = array();
		
		$params = JComponentHelper::getParams('com_languages');
		$lang = $params->get('site', 'ru-RU'); //use default joomla
		$lang = strtolower(strtr($lang,'-','_'));
		
		$db =& JFactory::getDBO();
		$query = "
			SELECT
				c.virtuemart_category_id AS id,
				vmlang.category_name AS title,
				cx.category_parent_id AS parent
			FROM #__virtuemart_categories_$lang AS vmlang
				JOIN #__virtuemart_categories AS c USING (virtuemart_category_id)
				LEFT JOIN #__virtuemart_category_categories AS cx ON cx.category_child_id=vmlang.virtuemart_category_id
			ORDER BY c.ordering
		";
		$db->setQuery($query);
		$categories = $db->loadObjectList();

		$list = array();
		$select_all = isset($this->element['selectall']) && $this->element['selectall']=='true';
		$is_multiple = isset($this->element['multiple']) && $this->element['multiple']=='multiple';
		if (!$is_multiple && $select_all){
			$root = new stdClass();
			$root->id = 0;
			$root->title = JText::_('All Categories');
			$root->parent = -1;
			$list[0] = $root;
		}
		
		// render category tree for selection
		foreach ($categories as $c) {
			$list[$c->id] = $c;
		}
		
		foreach ($list as $cid => $c){
			if (isset($list[$c->parent])){
				if (!isset($list[$c->parent]->child)){
					$list[$c->parent]->child = array();
				}
				$list[$c->parent]->child[] =& $list[$cid];
			}
		}
		foreach($list as $cid => $c){
			if (!isset($list[$c->parent])){
				$list[$cid]->level=1;
				$stack = array($list[$cid]);
				while( count($stack)>0 ){
					$opt = array_pop($stack);
					$option = array(
				    	'label' => ($opt->level>1 ? str_repeat('- ', $opt->level-1) : '') . $opt->title,
				    	'value' => $opt->id
					);
					array_push($options, $option);
					if (isset($opt->child) && count($opt->child)){
						foreach($opt->child as $child){
							$child->level = $opt->level + 1;
							array_push($stack, $child);
						}
					}
				}
			}
		}

		$html = "";
		if (count($options)>0){
			if (!is_array($value)){
				$value = array($value);
			}
			$select_attr = "";						
			if (isset($this->element['multiple'])){
				$select_attr .= " multiple=\"multiple\"";
				$size = min(count($options), 15);
				$select_attr .= " size=\"$size\"";
			}
			if (isset($this->element['css'])){
				$select_attr .= ' class="' . trim($this->element['css']) . '"';
			} else {
				$select_attr .= ' class="inputbox advancedSelect"';
			}
			$html = "<select $select_attr  style=\"min-width: 180px;\" id=\"$control_name\" name=\"$name\">";
			foreach ($options as $opt){
				$selected = in_array($opt['value'], $value) ? 'selected="selected"' : '';
				$html .= '<option value="' . $opt['value'] . '" ' . $selected . '>' . $opt['label'] . '</option>';
			}
			$html .= '<select>';
		}
		return $html;
	}
}

class JFormFieldVmProductCategories extends VmProductCategories{
}
class JElementVmProductCategories extends VmProductCategories{
}