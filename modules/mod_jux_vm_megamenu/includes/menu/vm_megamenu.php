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

defined('JPATH_VM_ADMINISTRATOR') or define('JPATH_VM_ADMINISTRATOR', JPATH_ROOT.'/'.'administrator'.'/'.'components'.'/'.'com_virtuemart');

require_once dirname(__FILE__).'/vm_megamenu.tpl.php';



class VMMegamenu {
	
	protected $children = array();
	protected $children_order = array();
	protected $_items = array();
	protected $menuHtml = '';
	protected $params = null;
	protected $settings = null;
	protected $top_level_caption =  false;
	protected $_vmCategoryId = array();
	protected $_isFrontEnd = false;
	
	protected $_active = null;
	
	protected $vmLag;
	
	public function __construct(){
		if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR.'/'.'components'.'/'.'com_virtuemart'.'/'.'helpers'.'/'.'config.php');
		
		VmConfig::loadConfig();
		$this->vmLag = str_replace('-','_',VMLANG);
		
	}
	
	function fectchVMCategoryMenu(){
		$app = JFactory::getApplication();
		$menu = $app->getMenu('site');
		$vmComponent = JComponentHelper::getComponent('com_virtuemart');
		$vmMenu = $menu->getItems('component_id',$vmComponent->id);
		return $vmMenu;
	}
	
	function fetchVMItemByCategory(&$params = array()){
		$vmitems = array();
		if (count($this->_vmCategoryId)){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$lang = JFactory::getLanguage();
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$date = JFactory::getDate();
			$now =  $date->toSql();
			
			$nullDate = $db->getNullDate();
			$rows = array();
			foreach($this->_vmCategoryId as $catId){
				$query = $db->getQuery(true);
				$query->select(' `l`.`virtuemart_product_id` AS id, `p`.`product_url`, `l`.`product_name`,`pc`.`virtuemart_category_id` AS catid')
					->from('#__virtuemart_products AS p')
					->innerJoin(' `#__virtuemart_products_' .$this->vmLag. '` AS `l` USING (`virtuemart_product_id`)')
					->innerJoin('`#__virtuemart_product_categories` AS `pc` USING (`virtuemart_product_id`)')
					->where('`p`.`published` = 1')
					->where('`pc`.`virtuemart_category_id` = '.(int)$catId);
				$query->order('p.pordering DESC');
				$db->setQuery($query);
					
				if($data = $db->loadObjectList()){
					foreach($data as $d){
						$rows[$d->id.'_'.$d->catid] = $d;
					}
				}
			}
			if (count($rows))
	        {
	            foreach ($rows as $row){
	            	$row->categories = $this->getProductCategories ($row->id, FALSE);
		            if(!empty($row->product_url)){
						$row->canonCatLink = $row->product_url;
					}
					else if(!empty($row->categories)){
						$categories = $this->getProductCategories ($row->id, TRUE);   //only published
						if($categories){
							if(!is_array($categories)) $categories = (array)$categories;
							$row->canonCatLink = $categories[0];
						}
					}
		            if(!empty($row->canonCatLink)) {
						// Add the product link  for canonical
						$row->canonical = 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $row->id . '&virtuemart_category_id=' . $row->canonCatLink;
					} else {
						$row->canonical = 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $row->id;
					}
					$row->canonical = JRoute::_ ($row->canonical,FALSE);
					if(!empty($row->catid)) {
						$row->link = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $row->id . '&virtuemart_category_id=' . $row->catid, FALSE);
					} else {
						$row->link = $row->canonical;
					}
	          
	            	$row->id = $row->id.'_'.$row->catid/* $row->id.'_0'*/;
	            	$row->name = $row->product_name;
					$row->parent = $row->catid;
					$row->level = 0;
					$row->isitem = true;
	            	$vmitems[$row->id] = $row;
	            }
	        }
		}
       return $vmitems;
	}
	
	function getProductCategories ($virtuemart_product_id = 0, $front = FALSE) {
		$db = JFactory::getDbo();
		$categories = array();
		if ($virtuemart_product_id > 0) {
			$q = 'SELECT pc.`virtuemart_category_id` FROM `#__virtuemart_product_categories` as pc';
			if ($front) {
				$q .= ' LEFT JOIN `#__virtuemart_categories` as c ON c.`virtuemart_category_id` = pc.`virtuemart_category_id`';
			}
			$q .= ' WHERE pc.`virtuemart_product_id` = ' . (int)$virtuemart_product_id;
			if ($front) {
				$q .= ' AND `published`=1 ORDER BY `c`.`ordering` ASC';
			}
			//$q .= ' ORDER BY `pc`.`ordering` DESC ';
			$db->setQuery ($q);
			$categories = $db->loadResultArray ();

		}

		return $categories;
	}
	
	
	function fetchVMCategory(&$params = array()){
		$lang = JFactory::getLanguage();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(' c.`virtuemart_category_id` AS id, l.`category_description`, l.`category_name` as name, c.`ordering`, c.`published`, cx.`category_child_id`, cx.`category_parent_id` AS parent , c.`shared` ')
			->from('`#__virtuemart_categories_'.$this->vmLag.'` l')
			->innerJoin('`#__virtuemart_categories` AS c using (`virtuemart_category_id`)')
			->leftJoin('`#__virtuemart_category_categories` AS cx ON l.`virtuemart_category_id` = cx.`category_child_id` ')
			->where('c.`published` = 1')
			->order('ordering');
		$db->setQuery($query);
		$items = array();
	 	$vmcategories = $db->loadObjectList('id');
	 	
	 	$vmitems = array();
		/*
	 	if ($this->_isFrontEnd){
		*/
	 		if ($params->get('show_items',1)){
			 	$this->_vmCategoryId  = array_keys($vmcategories);
			 	$vmitems = $this->fetchVMItemByCategory($params);
	 		}
	 	/*
		}else{
	 		$this->_vmCategoryId  = array_keys($vmcategories);
		 	$vmitems = $this->fetchVMItemByCategory($params);
	 	}
		*/
		
	 	$mitems = array_merge($vmcategories,$vmitems);
        
	 	$children = array();
        if ($mitems)
        {
            foreach ($mitems as $v)
            {
            	$v->tree = $v->id;
                $v->title = $v->name;
                $v->parent_id = $v->parent;
                $v->level = 0;
                $pt = $v->parent;
                $list = @$children[$pt] ? $children[$pt] : array();
                array_push($list, $v);
                $children[$pt] = $list;
            }
        }
        $lists = $this->treerecurse(0,array(), $children, 9999, 0);
        return $lists;
	}
	
	function treerecurse($id,$list, &$children, $maxlevel = 9999, $level = 0){
		if (@$children[$id] && $level <= $maxlevel)
		{
			foreach ($children[$id] as $v)
			{
				$id = $v->id;
				$list[$id] = $v;
				$list[$id]->children = count(@$children[$id]);
				$list[$id]->level = $level;
				$list = $this->treerecurse($id,$list, $children, $maxlevel, $level + 1);
			}
		}
		return $list;
	}
	
	function getCountItem($categoryId){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('count(#__virtuemart_products.virtuemart_product_id) AS total')
			->from('`#__virtuemart_products`, `#__virtuemart_product_categories`')
			->where('`#__virtuemart_products`.`virtuemart_vendor_id` = 1')
			->where(' `#__virtuemart_product_categories`.`virtuemart_category_id` = '.(int)$categoryId)
			->where('`#__virtuemart_products`.`virtuemart_product_id` = `#__virtuemart_product_categories`.`virtuemart_product_id`')
			->where('`#__virtuemart_products`.`published` = "1" ');
		$db->setQuery($query);
		return (int)$db->loadResult();
	}
	
	function parseMenu($params = array()){
		
		$router = JRouter::getInstance('site');
		$vars = $router->getVars();
		
		$_VMMenus = array();
		$VMMenu = $this->fectchVMCategoryMenu();
		
		foreach ($VMMenu as $mitem){
			if (isset($mitem->query['view'])){
				$view = strtolower($mitem->query['view']);
				if($view == 'categories' || $view == 'category' || $view == 'productdetails') {
					$key = '';
					if ( isset($mitem->query['virtuemart_product_id']) && ($pid = $mitem->query['virtuemart_product_id']) != ''){
						$key = $pid.'_0';
					}elseif ( isset($mitem->query['virtuemart_category_id']) && ($cid = $mitem->query['virtuemart_category_id']) != ''){
						$key = $cid;
					}
					if ($key != ''){
						$_VMMenus[$key] = $mitem;
					}
				}
			}
		}
		$items = array();
		$items = $this->fetchVMCategory($params);

		$this->params = $params;
		
		$this->settings =json_decode($params->get('mega_config',''),true);

		$mega_order = json_decode($params->get('mega_order',''),true);

		foreach ($items as &$item){
			$parent_tree = array();
			if (isset($items[$item->parent_id]))
			{
				$parent_tree  = $items[$item->parent_id]->tree;
			}
			$parent_tree[] = $item->id;
			$item->tree = $parent_tree;
			if (!isset($item->link))
				$item->link = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$item->id,FALSE);
			$item->anchor_css = '';
			$item->anchor_title = '';
			$item->menu_image = '';
			$item->type = '';
			$item->browserNav  = 0;
			$item->level = $item->level + 1;
			
			$active = $this->getActive($vars, $item);
			$active_id = $active ? $active->id : 0 ;
			$active_tree = $active ? $active->tree : array();
			
			$itemId = $item->id;
			if (isset($item->isitem)){
				$idArr = explode('_',$itemId);
				$itemId = $idArr[0].'_0';
			}
			
			if (array_key_exists($itemId,$_VMMenus)){
				$item->type = $_VMMenus[$itemId]->type;
				$item->link = $_VMMenus[$itemId]->link.'&Itemid='.$_VMMenus[$itemId]->id;;
				$item->params = $_VMMenus[$itemId]->params;
				$item->title = $_VMMenus[$itemId]->title;
				$item->browserNav = $_VMMenus[$itemId]->browserNav;			
				$item->anchor_css   = htmlspecialchars($item->params->get('menu-anchor_css', ''), ENT_COMPAT, 'UTF-8', false);
				$item->anchor_title = htmlspecialchars($item->params->get('menu-anchor_title', ''), ENT_COMPAT, 'UTF-8', false);
				$item->menu_image   = $item->params->get('menu_image', '') ? htmlspecialchars($item->params->get('menu_image', ''), ENT_COMPAT, 'UTF-8', false) : '';
					
			}
			
			$item->title        = htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8', false);
			$item->num_item = $this->getCountItem($item->id);
			
			$parent = isset($this->children[$item->parent_id]) ? $this->children[$item->parent_id] : array();
			$parent[] = $item;
			
			$this->children[$item->parent_id] = $parent;
			$this->_items[$item->id] = $item;
		}
		foreach ($items as &$item){
			// bind setting for this item
			$key = 'item-'.$item->id;
			$setting = isset($this->settings[$key]) ? $this->settings[$key] : array();
			
			// decode html tag
			if (isset($setting['caption']) && $setting['caption']) $setting['caption'] = str_replace(array('[lt]','[gt]'), array('<','>'), $setting['caption']);
			if ($item->level == 1 && isset($setting['caption']) && $setting['caption']) $this->top_level_caption = true;
			
			//active and current
			$class = '';		
			if ($item->id == $active_id){
				$class .= ' current ';
			}
			if (in_array($item->id,$active_tree)){
				$class .= ' active ';
			}
			
			$item->class = $class;
			$item->mega = 0;
			$item->group = 0;
			$item->dropdown = 0;
			$item->display = 1;
			
			if (isset($setting['display'])){
				$item->display = $setting['display'];
			}

			if (isset($setting['group'])) {
					$item->group = 1;
			} else {
				if ($this->_isFrontEnd){
					if ((isset($this->children[$item->id]) && (!isset($setting['hidesub']))) || isset($setting['sub'])) {
						$item->dropdown = 1;
					}
				}else{
					if ((isset($this->children[$item->id]) ) || isset($setting['sub'])) {
							$item->dropdown = 1;
					}
				}
			}
		
			
			$item->mega = $item->group || $item->dropdown;
			
			if ($item->mega) {
			 	if (!isset($setting['sub'])) $setting['sub'] = array();
			 	if (isset($this->children[$item->id]) && (!isset($setting['sub']['rows']) || !count($setting['sub']['rows']))) {
					$c = $this->children[$item->id][0]->id;
					$setting['sub'] = array('rows'=>array(array(array('width'=>12, 'item'=>$c))));
				}
			}
			
			$oldOrder = isset($mega_order[$item->id]) ? $mega_order[$item->id] : array();
			$newOrder = isset($this->children_order[$item->id]) ? $this->children_order[$item->id] : array();
			
			if (!$this->compareOrder($oldOrder,$newOrder)){
				$setting['sub'] = array('rows'=>array(array(array('width'=>12, 'item'=>-1))));
			}
			
			$item->setting = $setting;
			
			$item->flink  = JRoute::_($item->link);
		}
	}
	
	function render(/*$return = false, */$params = array(),$isFrontEnd = false){
		$this->_isFrontEnd = $isFrontEnd;
		$this->parseMenu($params);

		
		$this->menuHtml = '';
		$this->menuHtml .= $this->__('beginmenu');
		$keys = array_keys($this->_items);

		if(count($keys)){	
			$this->menuHtml .= $this->nav(null, $keys[0]);
		}
		$this->menuHtml .= $this->__('endmenu');

//		
//		if ($return) {
//			return $this->menuHtml;
//		} else {
//			echo $this->menuHtml;			
//		}
		return array($this->menuHtml,json_encode($this->children_order));
	}
	
	function nav ($pitem, $start = 0, $end = 0) {
		if ($start > 0) {
			if (!isset($this->_items[$start]))
				return;
			$pid     = $this->_items[$start]->parent_id;
			$items   = array();
			$started = false;
			foreach ($this->children[$pid] as $item) {
				if ($started) {
					if ($item->id == $end)
						break;
					$items[] = $item;
				} else {
					if ($item->id == $start) {
						$started = true;
						$items[] = $item;
					}
				}
			}
			if (!count($items))
				return;
		} else if ($start === 0) {
			$pid = $pitem->id;
			if (!isset($this->children[$pid]))
				return;
			$items = $this->children[$pid];
		} else {
			//empty menu
			return;
		}
		
		$beginnav = $this->__('beginnav', array(
			'item' => $pitem,
			'show_items'=>$this->getParam('show_items',1)
		));
		$itemHtml = '';
		foreach ($items as $item) {
			$setting = $item->setting;
			if($this->_isFrontEnd && isset($setting['display']) && $setting['display'] == -1){
				continue;
			}
			$itemHtml .= $this->item($item);
		}
		
		$endnav = $this->__('endnav', array(
			'item' => $pitem
		));
		if ($itemHtml == ''){
			return '';
		}
		return $beginnav.$itemHtml.$endnav;
	}

	function item ($item) {
		// item content
		$setting = $item->setting;
		
		
		$megaHtml = '';
		if ($item->mega) {
			$megaHtml .= $this->mega($item);
		}
		if ($megaHtml == ''){
			$item->group = 0;
			$item->dropdown = 0;	
			$item->mega = 0;
		}
		
		$html = $this->__('beginitem', array ('item'=>$item, 'setting'=>$setting));		
		
		$itemHtml = $this->__('item', array ('item'=>$item, 'setting'=>$setting));
		$html .= $itemHtml;
		if ($megaHtml != ''){
			$html .= $megaHtml;
		}
		$html .= $this->__('enditem', array ('item'=>$item));
		return $html;
	}

	protected function mega ($item) {
		
		$key       = 'item-' . $item->id;
		$setting   = $item->setting;
		$sub       = $setting['sub'];
		$items     = isset($this->children[$item->id]) ? $this->children[$item->id] : array();
		$firstitem = count($items) ? $items[0]->id : 0;
		
		
		$endItems = array();
		$k1       = $k2 = 0;
		

		$sub['rows'] = isset($sub['rows']) && is_array($sub['rows']) ? $sub['rows'] : array();
		
		foreach ($sub['rows'] as $row) {
			foreach ($row as $col) {
				if (!isset($col['position'])) {
					if ($k1) {
						$k2 = $col['item'];
						if (!isset($this->_items[$k2]) || $this->_items[$k2]->parent_id != $item->id)
							break;
						$endItems[$k1] = $k2;
					}
					$k1 = $col['item'];
				}
			}
		}

		$html = '';
		$endItems[$k1] = 0;
		$beginmega = $this->__('beginmega', array(
			'item' => $item
		));
		$firstitemscol = true;
		$rowHtml = '';
		foreach ($sub['rows'] as $row) {
			$beginrow = $this->__('beginrow');
			$colHtml = '';
			foreach ($row as $col) {
				if (isset($col['position'])) {
					$colHtml .= $this->__('begincol', array(
						'setting' => $col
					));
					$colHtml .= $this->module($col['position']);
					$colHtml .= $this->__('endcol');
				} else {
					if (!isset($endItems[$col['item']])){
						continue;
					}
					
					$begincol = $this->__('begincol', array(
						'setting' => $col
					));
					$toitem    = $endItems[$col['item']];
					$startitem = $firstitemscol ? $firstitem : $col['item'];
					$subNav = $this->nav($item, $startitem, $toitem);
					$firstitemscol = false;
					$endcol = $this->__('endcol');
					if ($subNav != ''){
						$colHtml .= $begincol.$subNav.$endcol;
					}
				}
				
			}
			$endrow = $this->__('endrow');
			if ($colHtml != ''){
				$rowHtml .= $beginrow.$colHtml.$endrow;
			}
		}
		$endmega =$this->__('endmega');
		if ($rowHtml == ''){
			return '';
		}
		return $beginmega.$rowHtml.$endmega;
	}
	
	
	function _ ($tmpl, $vars = array()) {
		$vars ['menu'] = $this;
		if (method_exists('VMMegamenuTpl', $tmpl)) {			
			$this->menuHtml .= VMMegamenuTpl::$tmpl($vars)."\n";
		} else {
			$this->menuHtml .= "$tmpl\n";			
		}
	}
	
	function __($tmpl, $vars = array()) {
		$vars ['menu'] = $this;
		if (method_exists('VMMegamenuTpl', $tmpl)) {			
			return VMMegamenuTpl::$tmpl($vars)."\n";
		} else {
			return "$tmpl\n";			
		}
	}
	
	function module($position) {
		
		if ($this->_isFrontEnd){
			$id = intval($position);
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('m.id, m.title, m.module, m.position, m.content, m.showtitle, m.params');
			$query->from('#__modules AS m');
			$query->where('m.id = '.$id);
			$query->where('m.published = 1');
			$db->setQuery($query);
			$module = $db->loadObject ();
			if($module && $module->id){
				$content = JModuleHelper::renderModule($module,array('style'=>'xhtml'));
				return $content."\n";
			}
		}
		return '';
	}
	
	function get ($prop) {
		if (isset($this->$prop)) return $this->$prop;
		return null;
	}
	
	function getParam ($name, $default=null) {
		if (!$this->params) return $default;
		return $this->params->get($name, $default);
	}
	
	function compareOrder($old,$new){
		foreach ($old as $k=>$v){
			if ((!isset($new[$k])) || (isset($new[$k]) && $new[$k] != $v)){
				return false;
			}
		}
		return true;
	}
	
	function getActive($vars,$item){
		if(is_null($this->_active)){
			if (@$vars['option'] == 'com_virtuemart'){
				switch (@$vars['view']){
					case 'productdetails':
						$idArr = explode('_',$item->id);
						if (isset($item->isitem) && @intval($vars['virtuemart_product_id']) == $idArr[0]){
							$this->_active =  $item;
						}
					break;
					default:
					case 'category':
						if (!isset($item->isitem) && ((@intval($vars['virtuemart_category_id']) == $item->id) or (@intval($vars['id']) == $item->id)) ){
							
							$this->_active=  $item;
						}
					break;
				}
			}
		}
		return $this->_active;
	}
}
