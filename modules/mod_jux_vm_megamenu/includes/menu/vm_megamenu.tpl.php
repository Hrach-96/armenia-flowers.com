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

class VMMegamenuTpl {
	static function beginmenu ($vars) {
		$menu = $vars['menu'];
		$animation = '';
		if (trim($menu->getParam('navigation_trigger','hover')) == 'hover'){
			$animation = (($menu->getParam('hozorver','') == 'horizontal' && $menu->getParam('horizontal_submenu_direction','down') == 'down') || ($menu->getParam('hozorver','') == 'vertical' && $menu->getParam('vertical_submenu_direction','lefttoright')=='lefttoright') ?  $menu->getParam ('navigation_animation', '') : $menu->getParam ('n_navigation_animation', ''));
		}
		$data = ' data-type="'.$menu->getParam('navigation_trigger','hover').'"';
		$animation_duration = $menu->getParam ('animation_duration', 0);
		$cls = ' class="jux-megamenu vmcollapse'.($animation ? ' animate '.$animation : '').'"';
		$data .= $animation && $animation_duration ? ' data-duration="'.$animation_duration.'"' : '';
		return "<div$cls$data>";
	}

	static function endmenu ($vars) {
		return '</div>';
	}

	static function beginnav ($vars) {
		$item = $vars['item'];
		$menu = $vars['menu'];
		$cls = '';
		if (!$item) {
			// first nav
			$cls = 'nav level0';
			if ($menu->get('_isFrontEnd')){
				$cls .= ' jux-nav';
			}
			if(!$vars['show_items'] && !$menu->get('_isFrontEnd')) {
			 	$cls .= ' hide-items';
			}
		} else {
			$cls .= ' mega-nav';
			$cls .= ' level'.$item->level;
		}
	 	
		if ($cls) $cls = 'class="'.trim($cls).'"';

		return '<ul '.$cls.'>';
	}
	static function endnav ($vars) {
		return '</ul>';
	}

	static function beginmega ($vars) {
		$item = $vars['item'];
		$setting = $item->setting;
		$sub = $setting['sub'];
		$cls = 'jux-nav-child '.($item->dropdown ? 'dropdown-menu mega-dropdown-menu' : 'mega-group-ct');
		$style = '';
		$data = '';
		if (isset($setting['class'])) $data .= " data-class=\"{$setting['class']}\"";
		if (isset($setting['alignsub']) && $setting['alignsub'] == 'justify') {
			$cls .= " span12";
		} else {
			if (isset($sub['width'])) {
				if ($item->dropdown) $style = " style=\"width:{$sub['width']}\"";
				$data .= " data-width=\"{$sub['width']}\"";
			} 			
		}

		if ($cls) $cls = 'class="'.trim($cls).'"';

		return "<div $cls $style $data><div class=\"mega-dropdown-inner\">";
	}
	static function endmega ($vars) {
		return '</div></div>';
	}

	static function beginrow ($vars) {
		return '<div class="row-fluid">';
	}
	static function endrow ($vars) {
		return '</div>';
	}

	static function begincol ($vars) {
		$setting = isset($vars['setting']) ? $vars['setting'] : array();
		$width = isset($setting['width']) ? $setting['width'] : '12';
		$data = "data-width=\"$width\"";
		$cls = "span$width";
		if (isset($setting['position'])) {
			$cls .= " mega-col-module";
			$data .= " data-position=\"{$setting['position']}\"";
		} else {
			$cls .= " mega-col-nav";
		}
		if (isset($setting['class'])) {
			$cls .= " {$setting['class']}";
			$data .= " data-class=\"{$setting['class']}\"";
		}
		if (isset($setting['hidewcol'])) {
			$data .= " data-hidewcol=\"1\"";
			$cls .= " hidden-collapse";
		}

		return "<div class=\"$cls\" $data><div class=\"mega-inner\">";
	}
	static function endcol ($vars) {
		return '</div></div>';
	}

	static function beginitem ($vars) {
		$item = $vars['item'];
		$menu = $vars['menu'];
		$setting = $item->setting;
		$cls = $item->class;

		if ($item->dropdown) {
			$cls .= $item->level == 1 ? 'dropdown' : 'dropdown-submenu';
		}
		 
		if ($item->mega) $cls .= ' mega';
		if ($item->group) $cls .= ' mega-group';
		if ($item->display == (-1)) $cls .=' display-toggle';
		if(isset($item->isitem)){
			$type = 'item';
		}else{
			$type = 'category';
		}
		$idArr = explode('_',$item->id);
		$id = !$menu->get('_isFrontEnd') ? $item->id : ($idArr[0]);
		$data = "data-id=\"{$id}\" data-type=\"{$type}\" data-level=\"{$item->level}\"";
		if (!$menu->get('_isFrontEnd')){
			$data .= " data-display=\"{$item->display}\"";

		}
		if ($item->group) $data .= " data-group=\"1\"";
		if (isset($setting['class'])) {
			$data .= " data-class=\"{$setting['class']}\"";
			$cls .= " {$setting['class']}";
		}
		if (isset($setting['alignsub'])) {
			$data .= " data-alignsub=\"{$setting['alignsub']}\"";
			$cls .= " mega-align-{$setting['alignsub']}";
		}
		if (isset($setting['hidesub'])) $data .= " data-hidesub=\"1\"";
		if (isset($setting['xicon'])) $data .= " data-xicon=\"{$setting['xicon']}\"";
		if (isset($setting['caption'])) $data .= " data-caption=\"".htmlspecialchars($setting['caption'])."\"";
		if (isset($setting['hidewcol'])) {
			$data .= " data-hidewcol=\"1\"";
			$cls .= " sub-hidden-collapse";
		}

		if ($cls) $cls = 'class="'.trim($cls).'"';

		return "<li $cls $data>";
	}
	static function enditem ($vars) {
		$item = $vars['item'];
		$setting = $item->setting;
		return '</li>';
	}
	static function item ($vars) {
		$item = $vars['item'];
		$menu = $vars['menu'];
		$setting = $item->setting;

		// Note. It is important to remove spaces between elements.
		$vars['class'] = $item->anchor_css ? $item->anchor_css : '';
		$vars['title'] = $item->anchor_title ? 'title="'.$item->anchor_title.'" ' : '';
		$vars['dropdown'] = '';
		$vars['caret'] = '';
		$vars['icon'] = '';
		$vars['caption'] = '';
		$vars['num_item'] = '';
		if ($item->level > 1){
			$vars['num_item'] = isset($item->isitem) ? '' :  ' <span class="mega-num-item">('.$item->num_item.')</span>' ;
			if ( $menu->get('_isFrontEnd')) {
				$vars['num_item'] = $menu->getParam('show_num_items',1) && !isset($item->isitem) ? ' <span class="mega-num-item">('.$item->num_item.')</span>' : '';
			}
		}
		if($item->dropdown && $item->level < 2){
			$vars['class'] .= ' dropdown-toggle';
			$vars['dropdown'] = ' ';// data-toggle="dropdown"
			if ($menu->getParam('hozorver','') == 'horizontal')
				$vars['caret'] = '<b class="caret"></b>';
		}
		
		if ($item->group) $vars['class'] .= ' mega-group-title';

		if ($item->menu_image) {
			$item->params->get('menu_text', 1 ) ?
			$vars['linktype'] = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
			$vars['linktype'] = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" />';
		} else { 
			$vars['linktype'] = $item->title;
		}

		if (isset($setting['xicon']) && $setting['xicon']) {
			$vars['icon'] = '<i class="'.$setting['xicon'].'"></i>';
		}
		if (isset($setting['caption']) && $setting['caption']) {
			$vars['caption'] = '<span class="mega-caption">'.$setting['caption'].'</span>';
		} else if ($item->level==1 && $vars['menu']->get('top_level_caption')) {
			$vars['caption'] = '<span class="mega-caption mega-caption-empty">&nbsp;</span>';
		}

		$html = '';
		switch ($item->type)
		{
			case 'separator':
				$html = self::item_separator ($vars);
				break;
			case 'component':
				$html = self::item_component ($vars);
				//$html = self::item_url ($vars);
				break;
			case 'url':
			default:
				$html = self::item_url ($vars);
		}

		return $html;
	}

	static function item_url ($vars) {
		$item = $vars['item'];
		$class = $vars['class'];
		$title = $vars['title'];
		$dropdown = $vars['dropdown'];
		$caret = $vars['caret'];
		$linktype = $vars['linktype'];
		$icon = $vars['icon'];
		$caption = $vars['caption'];
		$num_item = $vars['num_item'];
		
		$flink = $item->flink;
		$flink = JFilterOutput::ampReplace(htmlspecialchars($flink));

		$link = "";
		switch ($item->browserNav) :
			default:
			case 0:
				$link = "<a class=\"$class\" href=\"$flink\"  $title $dropdown>$icon$linktype$num_item$caret$caption</a>";
				break;
			case 1:
				// _blank
				$link = "<a class=\"$class\" href=\"$flink\"  target=\"_blank\" $title $dropdown>$icon$linktype$num_item$caret$caption</a>";
				break;
			case 2:
				// window.open
				$options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,'.$params->get('window_open');
				$link = "<a class=\"$class\" href=\"$flink\"  onclick=\"window.open(this.href,'targetWindow','$options');return false;\" $title $dropdown>$icon$linktype$num_item$caret$caption</a>";
				break;
		endswitch;

		return $link;
	}
	static function item_separator ($vars) {
		$item = $vars['item'];
		$class = $vars['class'];
		$title = $vars['title'];
		$dropdown = $vars['dropdown'];
		$caret = $vars['caret'];
		$linktype = $vars['linktype'];
		$icon = $vars['icon'];
		$caption = $vars['caption'];
		// Note. It is important to remove spaces between elements.

		$class .= " separator";

		return "<span class=\"$class\">$icon$title $linktype$caption</span>";
	}
	static function item_component ($vars) {
		$item = $vars['item'];
		$class = $vars['class'];
		$title = $vars['title'];
		$dropdown = $vars['dropdown'];
		$caret = $vars['caret'];
		$linktype = $vars['item']->name;
		$icon = $vars['icon'];
		$caption = $vars['caption'];
		// Note. It is important to remove spaces between elements.
		$num_item = $vars['num_item'];
        $flink = 'index.php?option=com_virtuemart&amp;view=category&amp;virtuemart_category_id='.$vars['item']->id;
		$link = "";
		switch ($item->browserNav) :
			default:
			case 0:
				$link = "<a class=\"$class\"  href=\"$flink\"  $title $dropdown>$icon$linktype $num_item $caret$caption</a>";
				break;
			case 1:
				// _blank
				$link = "<a class=\"$class\"  href=\"$flink\"  target=\"_blank\" $title $dropdown>$icon$linktype $num_item $caret$caption</a>";
				break;
			case 2:
			// window.open
				$link = "<a class=\"$class\"  href=\"$flink\"  onclick=\"window.open(this.href,'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes');return false;\" $title $dropdown>$icon$linktype $num_item $caret$caption</a>";
				break;
		endswitch;

		return $link;
	}
}
