<?php
/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2016 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('restricted aceess');

class SppagebuilderAddonPricing extends SppagebuilderAddons {

	public function render() {

		$class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';
		$title = (isset($this->addon->settings->title) && $this->addon->settings->title) ? $this->addon->settings->title : '';
		$icon = (isset($this->addon->settings->icon) && $this->addon->settings->icon) ? $this->addon->settings->icon : '';

		$heading_selector = (isset($this->addon->settings->heading_selector) && $this->addon->settings->heading_selector) ? $this->addon->settings->heading_selector : 'div';

		//Options
		$price_position = (isset($this->addon->settings->price_position) && $this->addon->settings->price_position) ? $this->addon->settings->price_position : 'before';
		$price = (isset($this->addon->settings->price) && $this->addon->settings->price) ? $this->addon->settings->price : '';
		$price_symbol = (isset($this->addon->settings->price_symbol) && $this->addon->settings->price_symbol) ? $this->addon->settings->price_symbol : '';
		$duration = (isset($this->addon->settings->duration) && $this->addon->settings->duration) ? $this->addon->settings->duration : '';
		$pricing_content = (isset($this->addon->settings->pricing_content) && $this->addon->settings->pricing_content) ? $this->addon->settings->pricing_content : '';
		$button_text = (isset($this->addon->settings->button_text) && $this->addon->settings->button_text) ? $this->addon->settings->button_text : '';
		$button_url = (isset($this->addon->settings->button_url) && $this->addon->settings->button_url) ? $this->addon->settings->button_url : '';
		$button_classes = (isset($this->addon->settings->button_size) && $this->addon->settings->button_size) ? ' sppb-btn-' . $this->addon->settings->button_size : '';
		$button_classes .= (isset($this->addon->settings->button_type) && $this->addon->settings->button_type) ? ' sppb-btn-' . $this->addon->settings->button_type : '';
		$button_classes .= (isset($this->addon->settings->button_shape) && $this->addon->settings->button_shape) ? ' sppb-btn-' . $this->addon->settings->button_shape: ' sppb-btn-rounded';
		$button_classes .= (isset($this->addon->settings->button_appearance) && $this->addon->settings->button_appearance) ? ' sppb-btn-' . $this->addon->settings->button_appearance : '';
		$button_classes .= (isset($this->addon->settings->button_block) && $this->addon->settings->button_block) ? ' ' . $this->addon->settings->button_block : '';
		$button_icon = (isset($this->addon->settings->button_icon) && $this->addon->settings->button_icon) ? $this->addon->settings->button_icon : '';
		$button_icon_position = (isset($this->addon->settings->button_icon_position) && $this->addon->settings->button_icon_position) ? $this->addon->settings->button_icon_position: 'left';
		$button_position = (isset($this->addon->settings->button_position) && $this->addon->settings->button_position) ? $this->addon->settings->button_position : '';
		$button_attribs = (isset($this->addon->settings->button_target) && $this->addon->settings->button_target) ? ' target="' . $this->addon->settings->button_target . '"' : '';
		$button_attribs .= (isset($this->addon->settings->button_url) && $this->addon->settings->button_url) ? ' href="' . $this->addon->settings->button_url . '"' : '';
		$alignment = (isset($this->addon->settings->alignment) && $this->addon->settings->alignment) ? $this->addon->settings->alignment : '';
		$featured = (isset($this->addon->settings->featured) && $this->addon->settings->featured) ? $this->addon->settings->featured : 'yes';

		if($button_icon_position == 'left') {
			$button_text = ($button_icon) ? '<i class="fa ' . $button_icon . '"></i> ' . $button_text : $button_text;
		} else {
			$button_text = ($button_icon) ? $button_text . ' <i class="fa ' . $button_icon . '"></i>' : $button_text;
		}

		$button_output = ($button_text) ? '<a' . $button_attribs . ' id="btn-'. $this->addon->id .'" class="sppb-btn' . $button_classes . '">' . $button_text . '</a>' : '';

		$pricesymbol = ($price_symbol) ? '<div class="sppb-after-title-desc">' . $price_symbol . '</div>' : '';

		//Output
		$output  = '<div class="sppb-addon '. $featured .' sppb-addon-pricing-table ' . $alignment . ' ' . $class . '">';
		$output .= '<div class="sppb-pricing-box">';
		$output .= '<div class="sppb-pricing-header">';
		$output .= '<div class="sppb-pricing-icon">';
		$output .= '<span class="sppb-inner-icon">';
		$output .= ($icon) ?'<i class="fa ' . $icon . '"></i>' : '';
		$output .= '</span>';
		$output .= '</div>';

		$output .= ($title) ? '<'.$heading_selector.' class="sppb-addon-title sppb-pricing-title">' . $title . '</'.$heading_selector.'>' : '';
		if($price_position == 'after' ){
			$output .= '<div class="sppb-pricing-price-container">';
			$output .= ($pricesymbol) ?''.$pricesymbol.'' : '';
			$output .= ($price) ? '<span class="sppb-pricing-price">' . $price . '</span>' : '';
			$output .= ($duration) ? '<span class="sppb-pricing-duration">' . $duration . '</span>' : '';
			$output .= '</div>';
		}
		$output .= '</div>';

		if($pricing_content) {
			$output .= '<div class="sppb-pricing-features">';
			$output .= '<ul>';

			$features = explode("\n", $pricing_content);

			foreach ($features as $feature) {
				$output .= '<li>' . $feature . '</li>';
			}

			$output .= '</ul>';
			$output .= '</div>';
		}

		if($price_position == 'before' ){
			$output .= '<div class="sppb-pricing-price-container">';
			$output .= ($price) ? '<span class="sppb-pricing-price after">' . $pricesymbol . $price . '</span>' : '';
			$output .= ($duration) ? '<span class="sppb-pricing-duration">' . $duration . '</span>' : '';
			$output .= '</div>';
		}

		$output .= '<div class="sppb-pricing-footer">';
		$output .= $button_output;
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';

		return $output;
	}
	public function js() { 
		$featured = (isset($this->addon->settings->featured) && $this->addon->settings->featured) ? $this->addon->settings->featured : '';
		$addon_id = '#sppb-addon-' . $this->addon->id;
		if($featured == "sppb-pricing-featured"){
		$featured_class = ' 
			jQuery(document).ready(function($) { 
				$("'.$addon_id.'").addClass("featured");
			});
		';
		}
		return $featured_class;
	}
	public function css() {
		$addon_id = '#sppb-addon-' . $this->addon->id;
		$css = '';
		$style = (isset($this->addon->settings->global_background_color) && $this->addon->settings->global_background_color) ? 'border: 0; background-color: '. $this->addon->settings->global_background_color .';' : '';

		$price_symbol_style = '';
		$price_symbol_style_sm = '';
		$price_symbol_style_xs = '';

		$price_style = '';
		$price_style_sm = '';
		$price_style_xs = '';

		$duration_style = '';
		$duration_style_sm = '';
		$duration_style_xs = '';

		$pricing_content_style = '';
		$pricing_content_style_sm = '';
		$pricing_content_style_xs = '';

		$price_style .= (isset($this->addon->settings->price_color) && $this->addon->settings->price_color) ? 'color: '. $this->addon->settings->price_color .';' : '';

		$price_style .= (isset($this->addon->settings->price_font_size) && $this->addon->settings->price_font_size) ? 'font-size: '. $this->addon->settings->price_font_size .'px; line-height: '. $this->addon->settings->price_font_size .'px;' : '';
		$price_style_sm .= (isset($this->addon->settings->price_font_size_sm) && $this->addon->settings->price_font_size_sm) ? 'font-size: '. $this->addon->settings->price_font_size_sm .'px; line-height: '. $this->addon->settings->price_font_size_sm .'px;' : '';
		$price_style_xs .= (isset($this->addon->settings->price_font_size_xs) && $this->addon->settings->price_font_size_xs) ? 'font-size: '. $this->addon->settings->price_font_size_xs .'px; line-height: '. $this->addon->settings->price_font_size_xs .'px;' : '';

		$price_symbol_style .= (isset($this->addon->settings->price_symbol_color) && $this->addon->settings->price_symbol_color) ? 'color: '. $this->addon->settings->price_symbol_color .'px;' : '';
		$price_symbol_style .= (isset($this->addon->settings->price_symbol_alignment) && $this->addon->settings->price_symbol_alignment) ? 'vertical-align: '. $this->addon->settings->price_symbol_alignment .';' : '';

		$price_symbol_style .= (isset($this->addon->settings->price_symbol_font_size) && $this->addon->settings->price_symbol_font_size) ? 'font-size: '. $this->addon->settings->price_symbol_font_size .'px;' : '';
		$price_symbol_style_sm .= (isset($this->addon->settings->price_symbol_font_size_sm) && $this->addon->settings->price_symbol_font_size_sm) ? 'font-size: '. $this->addon->settings->price_symbol_font_size_sm .'px;' : '';
		$price_symbol_style_xs .= (isset($this->addon->settings->price_symbol_font_size_xs) && $this->addon->settings->price_symbol_font_size_xs) ? 'font-size: '. $this->addon->settings->price_symbol_font_size_xs .'px;' : '';

		$duration_style .= (isset($this->addon->settings->duration_color) && $this->addon->settings->duration_color) ? 'color: '. $this->addon->settings->duration_color .';' : '';

		$duration_style .= (isset($this->addon->settings->duration_font_size) && $this->addon->settings->duration_font_size) ? 'font-size: '. $this->addon->settings->duration_font_size .'px;' : '';
		$duration_style_sm .= (isset($this->addon->settings->duration_font_size_sm) && $this->addon->settings->duration_font_size_sm) ? 'font-size: '. $this->addon->settings->duration_font_size_sm .'px;' : '';
		$duration_style_xs .= (isset($this->addon->settings->duration_font_size_xs) && $this->addon->settings->duration_font_size_xs) ? 'font-size: '. $this->addon->settings->duration_font_size_xs .'px;' : '';

		$pricing_content_style .= (isset($this->addon->settings->pricing_content_color) && $this->addon->settings->pricing_content_color) ? 'color: '. $this->addon->settings->pricing_content_color .';' : '';

		$pricing_content_style .= (isset($this->addon->settings->pricing_content_font_size) && $this->addon->settings->pricing_content_font_size) ? 'font-size: '. $this->addon->settings->pricing_content_font_size .'px; line-height: '. $this->addon->settings->pricing_content_font_size .'px;' : '';
		$pricing_content_style_sm .= (isset($this->addon->settings->pricing_content_font_size_sm) && $this->addon->settings->pricing_content_font_size_sm) ? 'font-size: '. $this->addon->settings->pricing_content_font_size_sm .'px; line-height: '. $this->addon->settings->pricing_content_font_size_sm .'px;' : '';
		$pricing_content_style_xs .= (isset($this->addon->settings->pricing_content_font_size_xs) && $this->addon->settings->pricing_content_font_size_xs) ? 'font-size: '. $this->addon->settings->pricing_content_font_size_xs .'px; line-height: '. $this->addon->settings->pricing_content_font_size_xs .'px;' : '';

		$pricing_content_style .= (isset($this->addon->settings->pricing_content_gap) && $this->addon->settings->pricing_content_gap) ? 'margin-bottom: '. $this->addon->settings->pricing_content_gap .'px;' : '';
		$pricing_content_style_sm .= (isset($this->addon->settings->pricing_content_gap_sm) && $this->addon->settings->pricing_content_gap_sm) ? 'margin-bottom: '. $this->addon->settings->pricing_content_gap_sm .'px;' : '';
		$pricing_content_style_xs .= (isset($this->addon->settings->pricing_content_gap_xs) && $this->addon->settings->pricing_content_gap_xs) ? 'margin-bottom: '. $this->addon->settings->pricing_content_gap_xs .'px;' : '';

		$price_container_style = (isset($this->addon->settings->price_margin_bottom) && $this->addon->settings->price_margin_bottom) ? 'margin-bottom: '. $this->addon->settings->price_margin_bottom .'px;' : '';
		$price_container_style_sm = (isset($this->addon->settings->price_margin_bottom_sm) && $this->addon->settings->price_margin_bottom_sm) ? 'margin-bottom: '. $this->addon->settings->price_margin_bottom_sm .'px;' : '';
		$price_container_style_xs = (isset($this->addon->settings->price_margin_bottom_xs) && $this->addon->settings->price_margin_bottom_xs) ? 'margin-bottom: '. $this->addon->settings->price_margin_bottom_xs .'px;' : '';

		$pricing_content_margin_bottom = (isset($this->addon->settings->pricing_content_margin_bottom) && $this->addon->settings->pricing_content_margin_bottom) ? 'margin-bottom: '. $this->addon->settings->pricing_content_margin_bottom .'px;' : '';
		$pricing_content_margin_bottom_sm = (isset($this->addon->settings->pricing_content_margin_bottom_sm) && $this->addon->settings->pricing_content_margin_bottom_sm) ? 'margin-bottom: '. $this->addon->settings->pricing_content_margin_bottom_sm .'px;' : '';
		$pricing_content_margin_bottom_xs = (isset($this->addon->settings->pricing_content_margin_bottom_xs) && $this->addon->settings->pricing_content_margin_bottom_xs) ? 'margin-bottom: '. $this->addon->settings->pricing_content_margin_bottom_sm .'px;' : '';

		if($style) {
			$css .= $addon_id . ' .sppb-pricing-box {';
			$css .= $style;
			$css .= '}';
		}

		if($price_style){
			$css .= $addon_id . ' .sppb-pricing-price {';
			$css .= $price_style;
			$css .= '}';
		}
		if($price_symbol_style){
			$css .= $addon_id . ' .sppb-pricing-price-symbol {';
			$css .= $price_symbol_style;
			$css .= '}';
		}
		if($duration_style){
			$css .= $addon_id . ' .sppb-pricing-duration {';
			$css .= $duration_style;
			$css .= '}';
		}

		if($pricing_content_margin_bottom){
			$css .= $addon_id . ' .sppb-pricing-features {';
			$css .= $pricing_content_margin_bottom;
			$css .= '}';
		}

		if($pricing_content_style) {
			$css .= $addon_id . ' .sppb-pricing-features ul li {';
			$css .= $pricing_content_style;
			$css .= '}';
		}

		if($price_container_style) {
			$css .= $addon_id . ' .sppb-pricing-price-container {';
			$css .= $price_container_style;
			$css .= '}';
		}
$icon_style  = '';
		$icon_style_sm  = '';
		$icon_style_xs  = '';

		$font_size = '';
		$font_size_sm = '';
		$font_size_xs = '';

		if(isset($this->addon->settings->margin) && trim($this->addon->settings->margin) != ""){
			$margin_md = '';
			$margins = explode(' ', $this->addon->settings->margin);
			foreach($margins as $margin){
				if(empty(trim($margin))){
					$margin_md .= ' 0';
				} else {
					$margin_md .= ' '.$margin;
				}

			}
			$icon_style .= "margin: " . $margin_md . ";\n";
		}

		if(isset($this->addon->settings->margin_sm) && trim($this->addon->settings->margin_sm) != ""){
			$margin_sm_full = '';
			$margins_sm = explode(' ', $this->addon->settings->margin_sm);
			foreach($margins_sm as $margin_sm){
				if(empty(trim($margin_sm))){
					$margin_sm_full .= ' 0';
				} else {
					$margin_sm_full .= ' '.$margin_sm;
				}

			}
			$icon_style_sm .= "margin: " . $margin_sm_full . ";\n";
		}

		if(isset($this->addon->settings->margin_xs) && trim($this->addon->settings->margin_xs) != ""){
			$margin_xs_full = '';
			$margins_xs = explode(' ', $this->addon->settings->margin_xs);
			foreach($margins_xs as $margin_xs){
				if(empty(trim($margin_xs))){
					$margin_xs_full .= ' 0';
				} else {
					$margin_xs_full .= ' '.$margin_xs;
				}

			}
			$icon_style_xs .= "margin: " . $margin_xs_full . ";\n";
		}

		$icon_style .= (isset($this->addon->settings->height) && $this->addon->settings->height) ? 'height: ' . (int) $this->addon->settings->height . 'px;' : '';
		$icon_style_sm .= (isset($this->addon->settings->height_sm) && $this->addon->settings->height_sm) ? 'height: ' . (int) $this->addon->settings->height_sm . 'px;' : '';
		$icon_style_xs .= (isset($this->addon->settings->height_xs) && $this->addon->settings->height_xs) ? 'height: ' . (int) $this->addon->settings->height_xs . 'px;' : '';

		$font_size .= (isset($this->addon->settings->height) && $this->addon->settings->height) ? 'line-height: ' . (int) $this->addon->settings->height . 'px;' : '';
		$font_size_sm .= (isset($this->addon->settings->height_sm) && $this->addon->settings->height_sm) ? 'line-height: ' . (int) $this->addon->settings->height_sm . 'px;' : '';
		$font_size_xs .= (isset($this->addon->settings->height_xs) && $this->addon->settings->height_xs) ? 'line-height: ' . (int) $this->addon->settings->height_xs . 'px;' : '';

		$icon_style .= (isset($this->addon->settings->width) && $this->addon->settings->width) ? 'width: ' . (int) $this->addon->settings->width . 'px;' : '';
		$icon_style_sm .= (isset($this->addon->settings->width_sm) && $this->addon->settings->width_sm) ? 'width: ' . (int) $this->addon->settings->width_sm . 'px;' : '';
		$icon_style_xs .= (isset($this->addon->settings->width_xs) && $this->addon->settings->width_xs) ? 'width: ' . (int) $this->addon->settings->width_xs . 'px;' : '';

		$icon_style .= (isset($this->addon->settings->color) && $this->addon->settings->color) ? 'color: ' . $this->addon->settings->color . ';' : '';
		$icon_style .= (isset($this->addon->settings->background) && $this->addon->settings->background) ? 'background-color: ' . $this->addon->settings->background . ';' : '';
		$icon_style .= (isset($this->addon->settings->border_color) && $this->addon->settings->border_color) ? 'border-style: solid; border-color: ' . $this->addon->settings->border_color . ';' : '';

		$icon_style .= (isset($this->addon->settings->border_width) && $this->addon->settings->border_width) ? 'border-width: ' . (int) $this->addon->settings->border_width . 'px;' : '';
		$icon_style_sm .= (isset($this->addon->settings->border_width_sm) && $this->addon->settings->border_width_sm) ? 'border-width: ' . (int) $this->addon->settings->border_width_sm . 'px;' : '';
		$icon_style_xs .= (isset($this->addon->settings->border_width_xs) && $this->addon->settings->border_width_xs) ? 'border-width: ' . (int) $this->addon->settings->border_width_xs . 'px;' : '';

		$icon_style .= (isset($this->addon->settings->border_radius) && $this->addon->settings->border_radius) ? 'border-radius: ' . (int) $this->addon->settings->border_radius . 'px;' : '';
		$icon_style_sm .= (isset($this->addon->settings->border_radius_sm) && $this->addon->settings->border_radius_sm) ? 'border-radius: ' . (int) $this->addon->settings->border_radius_sm . 'px;' : '';
		$icon_style_xs .= (isset($this->addon->settings->border_radius_xs) && $this->addon->settings->border_radius_xs) ? 'border-radius: ' . (int) $this->addon->settings->border_radius_xs . 'px;' : '';

		$font_size .= (isset($this->addon->settings->size) && $this->addon->settings->size) ? 'font-size: ' . (int) $this->addon->settings->size . 'px;' : '';
		$font_size_sm .= (isset($this->addon->settings->size_sm) && $this->addon->settings->size_sm) ? 'font-size: ' . (int) $this->addon->settings->size_sm . 'px;' : '';
		$font_size_xs .= (isset($this->addon->settings->size_xs) && $this->addon->settings->size_xs) ? 'font-size: ' . (int) $this->addon->settings->size_xs . 'px;' : '';

		$font_size .= (isset($this->addon->settings->border_width) && $this->addon->settings->border_width) ? 'margin-top: -' . (int) $this->addon->settings->border_width . 'px;' : '';
		$font_size_sm .= (isset($this->addon->settings->border_width_sm) && $this->addon->settings->border_width_sm) ? 'margin-top: -' . (int) $this->addon->settings->border_width_sm . 'px;' : '';
		$font_size_xs .= (isset($this->addon->settings->border_width_xs) && $this->addon->settings->border_width_xs) ? 'margin-top: -' . (int) $this->addon->settings->border_width_xs . 'px;' : '';
		if($icon_style) {
			$css .= $addon_id . ' .sppb-inner-icon {';
			$css .= $icon_style;
			$css .= "\n" . '}' . "\n"	;
		}

		if($font_size) {
			$css .= $addon_id . ' .sppb-inner-icon i {';
			$css .= $font_size;
			$css .= "\n" . '}' . "\n"	;
		}

		$css .= '@media (min-width: 768px) and (max-width: 991px) {';
			if($price_style_sm){
				$css .= $addon_id . ' .sppb-pricing-price {';
				$css .= $price_style_sm;
				$css .= '}';
			}
			if($price_symbol_style_sm){
				$css .= $addon_id . ' .sppb-pricing-price-symbol {';
				$css .= $price_symbol_style_sm;
				$css .= '}';
			}
			if($duration_style_sm){
				$css .= $addon_id . ' .sppb-pricing-duration {';
				$css .= $duration_style_sm;
				$css .= '}';
			}

			if($pricing_content_margin_bottom_sm){
				$css .= $addon_id . ' .sppb-pricing-features {';
				$css .= $pricing_content_margin_bottom_sm;
				$css .= '}';
			}

			if($pricing_content_style_sm){
				$css .= $addon_id . ' .sppb-pricing-features ul li {';
				$css .= $pricing_content_style_sm;
				$css .= '}';
			}

			if($price_container_style_sm){
				$css .= $addon_id . ' .sppb-pricing-price-container {';
				$css .= $price_container_style_sm;
				$css .= '}';
			}
		$css .= '}';

		$css .= '@media (max-width: 767px) {';
			if($price_style_xs){
				$css .= $addon_id . ' .sppb-pricing-price {';
				$css .= $price_style_xs;
				$css .= '}';
			}
			if($price_symbol_style_xs){
				$css .= $addon_id . ' .sppb-pricing-price-symbol {';
				$css .= $price_symbol_style_xs;
				$css .= '}';
			}
			if($duration_style_xs){
				$css .= $addon_id . ' .sppb-pricing-duration {';
				$css .= $duration_style_xs;
				$css .= '}';
			}

			if($pricing_content_margin_bottom_xs){
				$css .= $addon_id . ' .sppb-pricing-features {';
				$css .= $pricing_content_margin_bottom_xs;
				$css .= '}';
			}

			if($pricing_content_style_xs){
				$css .= $addon_id . ' .sppb-pricing-features ul li {';
				$css .= $pricing_content_style_xs;
				$css .= '}';
			}

			if($price_container_style_xs){
				$css .= $addon_id . ' .sppb-pricing-price-container {';
				$css .= $price_container_style_xs;
				$css .= '}';
			}
		$css .= '}';

		// Button css
		$layout_path = JPATH_ROOT . '/components/com_sppagebuilder/layouts';
		$css_path = new JLayoutFile('addon.css.button', $layout_path);
		$css .= $css_path->render(array('addon_id' => $addon_id, 'options' => $this->addon->settings, 'id' => 'btn-' . $this->addon->id));

		return $css;
	}

	public static function getTemplate(){

		$output ='
		<#
			let price_position = data.price_position || "before";

			var heading_selector = data.heading_selector || "div";

			let price_symbol = "";
			if(data.price_symbol){
				price_symbol = \'<span class="sppb-pricing-price-symbol">\'+data.price_symbol+\'</span>\';
			}

			let buttonText = "";
			let buttonAttribs = (data.button_target)? " target=\""+ data.button_target +"\"":"";
			buttonAttribs += (data.button_url)? " href=\""+ data.button_url +"\"":""

			let buttonClasses = (data.button_size)? " sppb-btn-"+ data.button_size : "";
			buttonClasses += (data.button_type)? " sppb-btn-"+ data.button_type : ""
			buttonClasses += (data.button_shape)? " sppb-btn-"+ data.button_shape : ""
			buttonClasses += (data.button_appearance)? " sppb-btn-"+ data.button_appearance : ""
			buttonClasses += (data.button_block)? " "+ data.button_block : ""

			if ( data.button_icon_position == "left" ) {
				buttonText = ( data.button_icon )? "<i class=\"fa " + data.button_icon +"\"></i> " + data.button_text : data.button_text
			} else {
				buttonText = ( data.button_icon )? data.button_text + " <i class=\"fa " + data.button_icon +"\"></i> " : data.button_text
			}

			let buttonOutput = (buttonText)? "<a" + buttonAttribs + " id=\"btn-" + data.id + "\" class=\"sppb-btn"+ buttonClasses + "\">"+ buttonText +"</a>":""

			var modern_font_style = false;
			var button_fontstyle = data.button_fontstyle || "";
			var button_font_style = data.button_font_style || "";

			var button_padding = "";
			var button_padding_sm = "";
			var button_padding_xs = "";
			if(data.button_padding){
				if(_.isObject(data.button_padding)){
					if(data.button_padding.md.trim() !== ""){
						button_padding = data.button_padding.md.split(" ").map(item => {
							if(_.isEmpty(item)){
								return "0";
							}
							return item;
						}).join(" ")
					}

					if(data.button_padding.sm.trim() !== ""){
						button_padding_sm = data.button_padding.sm.split(" ").map(item => {
							if(_.isEmpty(item)){
								return "0";
							}
							return item;
						}).join(" ")
					}

					if(data.button_padding.xs.trim() !== ""){
						button_padding_xs = data.button_padding.xs.split(" ").map(item => {
							if(_.isEmpty(item)){
								return "0";
							}
							return item;
						}).join(" ")
					}
				} else {
					if(data.button_padding.trim() !== ""){
						button_padding = data.button_padding.split(" ").map(item => {
							if(_.isEmpty(item)){
								return "0";
							}
							return item;
						}).join(" ")
					}
				}

			}
		#>

		<style type="text/css">
			<# if( _.isObject(data.price_margin_bottom) ) { #>
				#sppb-addon-{{ data.id }} .sppb-pricing-price-container {
					margin-bottom: {{data.price_margin_bottom.md}}px;
				}
			<# } else { #>
				#sppb-addon-{{ data.id }} .sppb-pricing-price-container {
					margin-bottom: {{data.price_margin_bottom}}px;
				}
			<# } #>

			<# if( data.price_color ) { #>
				#sppb-addon-{{ data.id }} .sppb-pricing-price {
					color: {{data.price_color}};
				}
			<# } #>

			<# if( _.isObject(data.price_font_size) ) { #>
				#sppb-addon-{{ data.id }} .sppb-pricing-price {
					font-size: {{data.price_font_size.md}}px;
					line-height: {{data.price_font_size.md}}px;
				}
			<# } else { #>
				#sppb-addon-{{ data.id }} .sppb-pricing-price {
					font-size: {{data.price_font_size}}px;
					line-height: {{data.price_font_size}}px;
				}
			<# } #>

			<# if( data.price_symbol_color ) { #>
				#sppb-addon-{{ data.id }} .sppb-pricing-price-symbol {
					color: {{data.price_symbol_color}};
				}
			<# } #>

			<# if( data.price_symbol_alignment ) { #>
				#sppb-addon-{{ data.id }} .sppb-pricing-price-symbol {
					vertical-align: {{data.price_symbol_alignment}};
				}
			<# } #>

			<# if( _.isObject(data.price_symbol_font_size) ) { #>
				#sppb-addon-{{ data.id }} .sppb-pricing-price-symbol {
					font-size: {{data.price_symbol_font_size.md}}px;
					line-height: {{data.price_symbol_font_size.md}}px;
				}
			<# } #>
			@media (min-width: 768px) and (max-width: 991px) {
				<# if( _.isObject(data.price_symbol_font_size) ) { #>
					#sppb-addon-{{ data.id }} .sppb-pricing-price-symbol {
						font-size: {{data.price_symbol_font_size.sm}}px;
						line-height: {{data.price_symbol_font_size.sm}}px;
					}
				<# } #>
			}
			@media (max-width: 767px) {
				<# if( _.isObject(data.price_symbol_font_size) ) { #>
					#sppb-addon-{{ data.id }} .sppb-pricing-price-symbol {
						font-size: {{data.price_symbol_font_size.xs}}px;
						line-height: {{data.price_symbol_font_size.xs}}px;
					}
				<# } #>
			}

			<# if( data.duration_color ) { #>
				#sppb-addon-{{ data.id }} .sppb-pricing-duration {
					color: {{data.duration_color}};
				}
			<# } #>
			<# if( _.isObject(data.duration_font_size) ) { #>
				#sppb-addon-{{ data.id }} .sppb-pricing-duration {
					font-size: {{data.duration_font_size.md}}px;
					line-height: {{data.duration_font_size.md}}px;
				}
			<# } #>
			@media (min-width: 768px) and (max-width: 991px) {
				<# if( _.isObject(data.duration_font_size) ) { #>
					#sppb-addon-{{ data.id }} .sppb-pricing-duration {
						font-size: {{data.duration_font_size.sm}}px;
						line-height: {{data.duration_font_size.sm}}px;
					}
				<# } #>
			}
			@media (max-width: 767px) {
				<# if( _.isObject(data.duration_font_size) ) { #>
					#sppb-addon-{{ data.id }} .sppb-pricing-duration {
						font-size: {{data.duration_font_size.xs}}px;
						line-height: {{data.duration_font_size.xs}}px;
					}
				<# } #>
			}

			<# if(_.isObject(data.pricing_content_gap)){ #>
				#sppb-addon-{{ data.id }} .sppb-pricing-features ul li {
					margin-bottom: {{data.pricing_content_gap.md}}px;
				}
			<# } #>
			@media (min-width: 768px) and (max-width: 991px) {
				<# if(_.isObject(data.pricing_content_gap)){ #>
					#sppb-addon-{{ data.id }} .sppb-pricing-features ul li {
						margin-bottom: {{data.pricing_content_gap.sm}}px;
					}
				<# } #>
			}
			@media (max-width: 767px) {
				<# if(_.isObject(data.pricing_content_gap)){ #>
					#sppb-addon-{{ data.id }} .sppb-pricing-features ul li {
						margin-bottom: {{data.pricing_content_gap.xs}}px;
					}
				<# } #>
			}

			<# if( _.isObject(data.pricing_content_font_size) ) { #>
				#sppb-addon-{{ data.id }} .sppb-pricing-features ul li {
					font-size: {{data.pricing_content_font_size.md}}px;
					line-height: {{data.pricing_content_font_size.md}}px;
				}
			<# } #>
			@media (min-width: 768px) and (max-width: 991px) {
				<# if(_.isObject(data.pricing_content_font_size)){ #>
					#sppb-addon-{{ data.id }} .sppb-pricing-features ul li {
						font-size: {{data.pricing_content_font_size.sm}}px;
						line-height: {{data.pricing_content_font_size.sm}}px;
					}
				<# } #>
			}
			@media (max-width: 767px) {
				<# if(_.isObject(data.pricing_content_font_size)){ #>
					#sppb-addon-{{ data.id }} .sppb-pricing-features ul li {
						font-size: {{data.pricing_content_font_size.xs}}px;
						line-height: {{data.pricing_content_font_size.xs}}px;
					}
				<# } #>
			}

			<# if(_.isObject(data.pricing_content_margin_bottom)){ #>
				#sppb-addon-{{ data.id }} .sppb-pricing-features {
					margin-bottom: {{data.pricing_content_margin_bottom.md}}px;
				}
			<# } #>
			@media (min-width: 768px) and (max-width: 991px) {
				<# if(_.isObject(data.pricing_content_margin_bottom)){ #>
					#sppb-addon-{{ data.id }} .sppb-pricing-features {
						margin-bottom: {{data.pricing_content_margin_bottom.sm}}px;
					}
				<# } #>
			}
			@media (max-width: 767px) {
				<# if(_.isObject(data.pricing_content_margin_bottom)){ #>
					#sppb-addon-{{ data.id }} .sppb-pricing-features {
						margin-bottom: {{data.pricing_content_margin_bottom.xs}}px;
					}
				<# } #>
			}

			#sppb-addon-{{ data.id }} #btn-{{ data.id }}.sppb-btn-{{ data.button_type }}{
				letter-spacing: {{ data.button_letterspace }};
				<# if(_.isObject(button_font_style) && button_font_style.underline) { #>
					text-decoration: underline;
					<# modern_font_style = true #>
				<# } #>

				<# if(_.isObject(button_font_style) && button_font_style.italic) { #>
					font-style: italic;
					<# modern_font_style = true #>
				<# } #>

				<# if(_.isObject(button_font_style) && button_font_style.uppercase) { #>
					text-transform: uppercase;
					<# modern_font_style = true #>
				<# } #>

				<# if(_.isObject(button_font_style) && button_font_style.weight) { #>
					font-weight: {{ button_font_style.weight }};
					<# modern_font_style = true #>
				<# } #>

				<# if(!modern_font_style) { #>
					<# if(_.isArray(button_fontstyle)) { #>
						<# if(button_fontstyle.indexOf("underline") !== -1){ #>
							text-decoration: underline;
						<# } #>
						<# if(button_fontstyle.indexOf("uppercase") !== -1){ #>
							text-transform: uppercase;
						<# } #>
						<# if(button_fontstyle.indexOf("italic") !== -1){ #>
							font-style: italic;
						<# } #>
						<# if(button_fontstyle.indexOf("lighter") !== -1){ #>
							font-weight: lighter;
						<# } else if(button_fontstyle.indexOf("normal") !== -1){#>
							font-weight: normal;
						<# } else if(button_fontstyle.indexOf("bold") !== -1){#>
							font-weight: bold;
						<# } else if(button_fontstyle.indexOf("bolder") !== -1){#>
							font-weight: bolder;
						<# } #>
					<# } #>
				<# } #>
			}

			<# if(data.button_type == "custom"){ #>
				#sppb-addon-{{ data.id }} #btn-{{ data.id }}.sppb-btn-custom{
					color: {{ data.button_color }};
					padding: {{ button_padding }};
					<# if(data.button_appearance == "outline"){ #>
						border-color: {{ data.button_background_color }}
					<# } else if(data.button_appearance == "3d"){ #>
						border-bottom-color: {{ data.button_background_color_hover }};
						background-color: {{ data.button_background_color }};
					<# } else { #>
						background-color: {{ data.button_background_color }};
					<# } #>
				}

				#sppb-addon-{{ data.id }} #btn-{{ data.id }}.sppb-btn-custom:hover{
					color: {{ data.button_color_hover }};
					background-color: {{ data.button_background_color_hover }};
					<# if(data.button_appearance == "outline"){ #>
						border-color: {{ data.button_background_color_hover }}
					<# } #>
				}
				@media (min-width: 768px) and (max-width: 991px) {
					#sppb-addon-{{ data.id }} #btn-{{ data.id }}.sppb-btn-custom{
						padding: {{ button_padding_sm }};
					}
				}
				@media (max-width: 767px) {
					#sppb-addon-{{ data.id }} #btn-{{ data.id }}.sppb-btn-custom{
						padding: {{ button_padding_xs }};
					}
				}
			<# } #>
		</style>

		<div class="sppb-addon sppb-addon-pricing-table {{ data.alignment }} {{ data.class }}">
			<div class="sppb-pricing-box {{ data.featured }}">
				<div class="sppb-pricing-header">
					<# if( data.title ) { #>
						<{{ heading_selector }} class="sppb-addon-title sppb-pricing-title">{{ data.title }}</{{ heading_selector }}>
					<# } #>
					<# if( price_position == "after" ) { #>
						<div class="sppb-pricing-price-container">
							<# if( data.price ) { #>
								<span class="sppb-pricing-price">{{{ price_symbol }}}{{ data.price }}</span>
							<# } #>
							<# if( data.duration ) { #>
								<span class="sppb-pricing-duration">{{ data.duration }}</span>
							<# } #>
						</div>
					<# } #>
				</div>

				<# if(data.pricing_content) { #>
					<div class="sppb-pricing-features">
						<ul>
							<# let pContentArray = data.pricing_content.split("\n") #>
							<# _.each(pContentArray,function(item,index){ #>
								<# if(item) { #> <li>{{{ item }}}</li><# } #>
							<# }) #>
						</ul>
					</div>
				<# } #>
				<# if( price_position == "before" ) { #>
					<div class="sppb-pricing-price-container">
						<# if( data.price ) { #>
							<span class="sppb-pricing-price">{{{ price_symbol }}}{{ data.price }}</span>
						<# } #>
						<# if( data.duration ) { #>
							<span class="sppb-pricing-duration">{{ data.duration }}</span>
						<# } #>
					</div>
				<# } #>
				<div class="sppb-pricing-footer">{{{ buttonOutput }}}</div>
			</div>
		</div>
		';

		return $output;
	}

}
