<?php
/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2016 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('restricted aceess');

class SppagebuilderAddonTestimonialpro extends SppagebuilderAddons {

	public function render() {

		$class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';
		$style = (isset($this->addon->settings->style) && $this->addon->settings->style) ? $this->addon->settings->style : '';

		
		$style_testi = (isset($this->addon->settings->style_testi) && $this->addon->settings->style_testi) ? $this->addon->settings->style_testi : 'style-box';

		//Options
		$autoplay = (isset($this->addon->settings->autoplay) && $this->addon->settings->autoplay) ? ' data-sppb-ride="sppb-carousel"' : '';
		$arrows = (isset($this->addon->settings->arrows) && $this->addon->settings->arrows) ? $this->addon->settings->arrows : 0;
		//$controls = true;
		$controls = (isset($this->addon->settings->controls) && $this->addon->settings->controls) ? $this->addon->settings->controls : 0;
		$interval = (isset($this->addon->settings->interval) && $this->addon->settings->interval) ? ((int) $this->addon->settings->interval * 1000) : 5000;
		$avatar_size = (isset($this->addon->settings->avatar_size) && $this->addon->settings->avatar_size) ? $this->addon->settings->avatar_size : '32';
		$avatar_shape = (isset($this->addon->settings->avatar_shape) && $this->addon->settings->avatar_shape) ? $this->addon->settings->avatar_shape : 'sppb-avatar-circle';

		//Output
		$output  = '<div id="sppb-testimonial-pro-'. $this->addon->id .'" data-interval="'.$interval.'" class="sppb-carousel sppb-testimonial-pro sppb-slide sppb-text-center ' . $class. ' ' .$style_testi. '"'. $autoplay .'>';

		if($controls) {
			$output .= '<ol class="sppb-carousel-indicators">';
			foreach ($this->addon->settings->sp_testimonialpro_item as $key1 => $value) {
				$output .= '<li data-sppb-target="#sppb-carousel-'. $this->addon->id .'" '. (($key1 == 0) ? ' class="active"': '' ) .'  data-sppb-slide-to="'. $key1 .'"></li>' . "\n";
			}
			$output .= '</ol>';
		}
		if($arrows) {
			$output	.= '<a href="#sppb-carousel-'. $this->addon->id .'" class="sppb-carousel-arrows left sppb-carousel-control" data-slide="prev"><i class="fa linearicons-chevron-left"></i></a>';
			$output	.= '<a href="#sppb-carousel-'. $this->addon->id .'" class="sppb-carousel-arrows right sppb-carousel-control" data-slide="next"><i class="fa linearicons-chevron-right"></i></a>';
		}

		$output  .= '<span class="fa fa-quote-left"></span>';
		$output .= '<div class="sppb-carousel-inner">';

		foreach ($this->addon->settings->sp_testimonialpro_item as $key => $value) {
			$output   .= '<div class="sppb-item ' . (($key == 0) ? ' active' : '') .'">';
			$name = (isset($value->title) && $value->title) ? $value->title : '';
			$subname = (isset($value->sub_title) && $value->sub_title) ? $value->sub_title : '';
			$avatar_size = (isset($this->addon->settings->avatar_width) && $this->addon->settings->avatar_width) ? $this->addon->settings->avatar_width : '32';

			
			$output  .= '<div class="sppb-testimonial-message">' . $value->message . '</div>';
			$output .= '<div class="sppb-addon-testimonial-pro-footer">';
			$output .= (isset($value->avatar) && $value->avatar) ? '<div class="img"><img src="'.$value->avatar.'" height="' . $avatar_size . '" width="' . $avatar_size . '" class="'. $avatar_shape .'" alt="'.$name.'"></div>' : '';
			$output .= $name ? '<strong>' . $name . '</strong>' : '';
			$output .= $subname ? '<span>' . $subname . '</span>' : '';
			$output .= (isset($value->url) && $value->url) ? '&nbsp;<span class="sppb-addon-testimonial-pro-client-url">' . $value->url . '</span>' : '';
			$output .= '</div>';

			$output  .= '</div>';
		}
		$output	.= '</div>';

		$output .= '</div>';

		return $output;

	}

	public function css() {
		$addon_id = '#sppb-addon-' . $this->addon->id;
		$css = '';

		$speed = (isset($this->addon->settings->speed) && $this->addon->settings->speed) ? $this->addon->settings->speed : 600;
		$css .= $addon_id.' .sppb-carousel-inner > .sppb-item{-webkit-transition-duration: '.$speed.'ms; transition-duration: '.$speed.'ms;}';

		return $css;
	}

	public static function getTemplate() {

        $output = '
            <#
                let interval = (data.interval)? (data.interval*1000):5000
                let autoplay = (data.autoplay)? \'data-sppb-ride="sppb-carousel"\':""
                let avatar_size = data.avatar_width || 32
                let avatar_shape = data.avatar_shape || "sppb-avatar-circle"
                let arrow_icon = (!_.isEmpty(data.arrow_icon)) ? data.arrow_icon : "chevron";
                let left_arrow ="";
                let right_arrow = "";
                if(arrow_icon=="angle_dubble"){
                    left_arrow ="fa-angle-double-left";
                    right_arrow = "fa-angle-double-right";
                } else if(arrow_icon=="arrow"){
                    left_arrow ="fa-arrow-left";
                    right_arrow = "fa-arrow-right";
                } else if(arrow_icon=="arrow_circle"){
                    left_arrow ="fa-arrow-circle-o-left";
                    right_arrow = "fa-arrow-circle-o-right";
                } else if(arrow_icon=="long_arrow"){
                    left_arrow ="fa-long-arrow-left";
                    right_arrow = "fa-long-arrow-right";
                } else if(arrow_icon=="angle"){
                    left_arrow ="fa-angle-left";
                    right_arrow = "fa-angle-right";
                } else{
                    left_arrow ="fa-chevron-left";
                    right_arrow = "fa-chevron-right";
                }
            #>
            <style type="text/css">
                #sppb-addon-{{ data.id }} .sppb-testimonial-pro .sppb-carousel-control{
                    width: {{data.arrow_width}}px;
                    height: {{data.arrow_height}}px;
                    background-color: {{data.arrow_background}};
                    color: {{data.arrow_color}};
                    <# if(_.isObject(data.arrow_margin)){ #>
                        margin: {{data.arrow_margin.md}};
                    <# } #>
                    font-size: {{data.arrow_font_size}}px;
                    <# if(data.arrow_height){ #>
                        line-height: {{data.arrow_height-data.arrow_border_width}}px;
                    <# } #>
                    border-width: {{data.arrow_border_width}}px;
                    border-color: {{data.arrow_border_color}};
                    border-radius: {{data.arrow_border_radius}}px;
                }
                #sppb-addon-{{ data.id }} .sppb-testimonial-pro .sppb-carousel-control:hover{
                    background-color: {{data.arrow_hover_background}};
                    color: {{data.arrow_hover_color}};
                    border-color: {{data.arrow_hover_border_color}};
                }
                #sppb-addon-{{ data.id }} .sppb-item > img,
                #sppb-addon-{{ data.id }} .sppb-addon-testimonial-pro-footer img{
                    <# if(_.isObject(avatar_size)){ #>
                        width: {{avatar_size.md}}px;
                        height: {{avatar_size.md}}px;
                    <# } else { #>
                        width: {{avatar_size}}px;
                        height: {{avatar_size}}px;
                    <# } #>
                }
                <# if(data.show_quote){ #>
                    #sppb-addon-{{ data.id }} .sppb-testimonial-pro .fa-quote-left{
                        <# if(_.isObject(data.icon_size)){ #>
                            font-size: {{ data.icon_size.md }}px;
                        <# } #>
                        color: {{ data.icon_color }};
                    }
                <# } #>
                #sppb-addon-{{ data.id }} .sppb-addon-testimonial-pro-footer .sppb-addon-testimonial-pro-client-name {
                    <# if(data.name_color){ #>
                        color: {{data.name_color}};
                    <# }
                    if(_.isEmpty(data.name_font_style) && !data.name_font_style){ #>
                        font-weight:700;
                    <# }
                    if(data.name_letterspace){ #>
                        letter-spacing: {{data.name_letterspace}};
                    <# }
                    if(_.isObject(data.name_font_size)) { #>
                        font-size: {{data.name_font_size.md}}px;
                    <# } else { #>
                        font-size: {{data.name_font_size}}px;
                    <# }
                    if(_.isObject(data.name_line_height)) { #>
                        line-height: {{data.name_line_height.md}}px;
                    <# } else { #>
                        line-height: {{data.name_line_height}}px;
                    <# }
                    if(_.isObject(data.name_font_style)){ #>
                        <# if(data.name_font_style.underline){ #>
                            text-decoration:underline;
                        <# }
                        if(data.name_font_style.italic){
                        #>
                            font-style:italic;
                        <# }
                        if(data.name_font_style.uppercase){
                        #>
                            text-transform:uppercase;
                        <# }
                        if(data.name_font_style.weight){
                        #>
                            font-weight:{{data.name_font_style.weight}};
                        <# } #>
                    <# } #>
                }
                #sppb-addon-{{ data.id }} .sppb-addon-testimonial-pro-footer .sppb-addon-testimonial-pro-client-designation {
                    <# if(data.designation_color){ #>
                        color: {{data.designation_color}};
                    <# }
                    if(data.designation_block){ #>
                        display:block;
                    <# }
                    if(data.designation_letterspace){ #>
                        letter-spacing: {{data.designation_letterspace}};
                    <# }
                    if(_.isObject(data.designation_font_size)){ #>
                        font-size: {{data.designation_font_size.md}}px;
                    <# } else { #>
                        font-size: {{data.designation_font_size}}px;
                    <# }
                    if(_.isObject(data.designation_line_height)){ #>
                        line-height: {{data.designation_line_height.md}}px;
                    <# }
                    if(_.isObject(data.designation_margin)){ #>
                        margin: {{data.designation_margin.md}};
                    <# } else { #>
                        margin: {{data.designation_margin}};
                    <# }
                    if(_.isObject(data.designation_font_style)){ #>
                        <# if(data.designation_font_style.underline){ #>
                            text-decoration:underline;
                        <# }
                        if(data.designation_font_style.italic){
                        #>
                            font-style:italic;
                        <# }
                        if(data.designation_font_style.uppercase){
                        #>
                            text-transform:uppercase;
                        <# }
                        if(data.designation_font_style.weight){
                        #>
                            font-weight:{{data.designation_font_style.weight}};
                        <# } #>
                    <# } #>
                }
                
               <# if(data.bullet_border_color){ #>
                    #sppb-addon-{{ data.id }} .sppb-carousel-indicators li {
                        border-color:{{data.bullet_border_color}};
                    }
                <# }
                if(data.bullet_active_bg_color){
                #>
                    #sppb-addon-{{ data.id }} .sppb-carousel-indicators li.active {
                        background:{{data.bullet_active_bg_color}};
                        border-color:{{data.bullet_active_bg_color}};
                    }
                <# } #>
                #sppb-addon-{{ data.id }} .sppb-testimonial-message {
                    color:{{data.content_color}};
                    <# if(_.isObject(data.content_margin)){ #>
                        margin:{{data.content_margin.md}};
                    <# }
                    if(_.isObject(data.content_fontsize)){ #>
                        font-size: {{data.content_fontsize.md}}px;
                    <# }
                    if(_.isObject(data.content_lineheight)){ #>
                        line-height: {{data.content_lineheight.md}}px;
                    <# } #>
                    font-weight: {{data.content_fontweight}};
                }
                @media (min-width: 768px) and (max-width: 991px) {
                    <# if(data.show_quote){ #>
                        #sppb-addon-{{ data.id }} .sppb-testimonial-pro .fa-quote-left{
                            <# if(_.isObject(data.icon_size)){ #>
                                font-size: {{ data.icon_size.sm }}px;
                            <# } #>
                        }
                    <# }
                    if(_.isObject(data.content_fontsize) || _.isObject(data.content_margin)){ #>
                        #sppb-addon-{{ data.id }} .sppb-testimonial-message {
                            <# if(_.isObject(data.content_fontsize)){ #>
                                font-size: {{data.content_fontsize.sm}}px;
                            <# }
                            if(_.isObject(data.content_margin)){ #>
                                margin:{{data.content_margin.sm}};
                            <# }
                            if(_.isObject(data.content_lineheight)){ #>
                                line-height: {{data.content_lineheight.sm}}px;
                            <# } #>
                        }
                        <# if(_.isObject(data.arrow_margin)){ #>
                            #sppb-addon-{{ data.id }} .sppb-testimonial-pro .sppb-carousel-control{
                                margin: {{data.arrow_margin.sm}};
                            }
                        <# }
                        if(!_.isEmpty(data.name_font_size) || !_.isEmpty(data.name_line_height)){
                        #>
                            #sppb-addon-{{ data.id }} .sppb-addon-testimonial-pro-footer .sppb-addon-testimonial-pro-client-name {
                                <# if(_.isObject(data.name_font_size)) { #>
                                    font-size: {{data.name_font_size.sm}}px;
                                <# }
                                if(_.isObject(data.name_line_height)) {
                                #>
                                    line-height: {{data.name_line_height.sm}}px;
                                <# } #>
                            }
                        <# }
                    } #>
                    #sppb-addon-{{ data.id }} .sppb-item > img,
                    #sppb-addon-{{ data.id }} .sppb-addon-testimonial-pro-footer img{
                        <# if(_.isObject(avatar_size)){ #>
                            width: {{avatar_size.sm}}px;
                            height: {{avatar_size.sm}}px;
                        <# } #>
                    }
                    #sppb-addon-{{ data.id }} .sppb-addon-testimonial-pro-footer .sppb-addon-testimonial-pro-client-designation {
                        <# if(_.isObject(data.designation_font_size)){ #>
                            font-size: {{data.designation_font_size.sm}}px;
                        <# }
                        if(_.isObject(data.designation_line_height)){ #>
                            line-height: {{data.designation_line_height.sm}}px;
                        <# }
                        if(_.isObject(data.designation_margin)){ #>
                            margin: {{data.designation_margin.sm}};
                        <# } #>
                    }
                }
                @media (max-width: 767px) {
                    <# if(data.show_quote){ #>
                        #sppb-addon-{{ data.id }} .sppb-testimonial-pro .fa-quote-left{
                            <# if(_.isObject(data.icon_size)){ #>
                                font-size: {{ data.icon_size.xs }}px;
                            <# } #>
                        }
                    <# }
                    if(_.isObject(data.content_fontsize) || _.isObject(data.content_margin)){ #>
                        #sppb-addon-{{ data.id }} .sppb-testimonial-message {
                            <# if(_.isObject(data.content_fontsize)){ #>
                                font-size: {{data.content_fontsize.xs}}px;
                            <# }
                            if(_.isObject(data.content_margin)){ #>
                                margin:{{data.content_margin.xs}};
                            <# }
                            if(_.isObject(data.content_lineheight)){ #>
                                line-height: {{data.content_lineheight.xs}}px;
                            <# } #>
                        }
                    <# }
                    if(_.isObject(data.arrow_margin)){ #>
                        #sppb-addon-{{ data.id }} .sppb-testimonial-pro .sppb-carousel-control{
                            margin: {{data.arrow_margin.xs}};
                        }
                    <# }
                    if(!_.isEmpty(data.name_font_size) || !_.isEmpty(data.name_line_height)){
                    #>
                        #sppb-addon-{{ data.id }} .sppb-addon-testimonial-pro-footer .sppb-addon-testimonial-pro-client-name {
                            <# if(_.isObject(data.name_font_size)) { #>
                                font-size: {{data.name_font_size.xs}}px;
                            <# }
                            if(_.isObject(data.name_line_height)) {
                            #>
                                line-height: {{data.name_line_height.xs}}px;
                            <# } #>
                        }
                    <# } #>
                    #sppb-addon-{{ data.id }} .sppb-item > img,
                    #sppb-addon-{{ data.id }} .sppb-addon-testimonial-pro-footer img{
                        <# if(_.isObject(avatar_size)){ #>
                            width: {{avatar_size.xs}}px;
                            height: {{avatar_size.xs}}px;
                        <# } #>
                    }
                    #sppb-addon-{{ data.id }} .sppb-addon-testimonial-pro-footer .sppb-addon-testimonial-pro-client-designation {
                        <# if(_.isObject(data.designation_font_size)){ #>
                            font-size: {{data.designation_font_size.xs}}px;
                        <# }
                        if(_.isObject(data.designation_line_height)){ #>
                            line-height: {{data.designation_line_height.xs}}px;
                        <# }
                        if(_.isObject(data.designation_margin)){ #>
                            margin: {{data.designation_margin.xs}};
                        <# } #>
                    }
                }
            </style>
            <div id="sppb-testimonial-pro-{{ data.id }}" data-interval="{{ interval }}" class="sppb-carousel sppb-testimonial-pro sppb-slide {{data.content_alignment}} {{ data.class }}" {{{ autoplay }}}>

                <# if(data.controls) { #>
                    <ol class="sppb-carousel-indicators">
                    <#
                    _.each(data.sp_testimonialpro_item, function(item,key){
                        let activeClass
                        if (key == 0) {
                            activeClass = "class=active"
                        }else{
                            activeClass = ""
                        }
                    #>
                        <li data-sppb-target="#sppb-testimonial-pro-{{ data.id }}" {{ activeClass }} data-sppb-slide-to="{{ key }}"></li>
                    <# }) #>
                    </ol>
                <# } #>

                <# if(data.show_quote){ #>
                    <span class="fa fa-quote-left"></span>
                <# } #>
                <div class="sppb-carousel-inner">
                    <#
                    _.each(data.sp_testimonialpro_item, function(itemSlide, index) {
                        let slideActClass = ""
                        if (index == 0) {
                            slideActClass = " active"
                        } else {
                            slideActClass = ""
                        }
                    #>

                        <div class="sppb-item{{ slideActClass }}">
                            <# if (data.avatar_on_top == 1) { 
                            if (!_.isEmpty(itemSlide.avatar)) { #>
                                <# if(itemSlide.avatar.indexOf("https://") == -1 && itemSlide.avatar.indexOf("http://") == -1){ #>
                                    <img class="{{ avatar_shape }}" src=\'{{ pagebuilder_base + itemSlide.avatar }}\' alt="">
                                <# } else { #>
                                    <img class="{{ avatar_shape }}" src=\'{{ itemSlide.avatar }}\' alt="">
                                <# } #>
                            <# }
                            } #>
                            <div class="sppb-testimonial-message sp-editable-content" id="addon-message-{{data.id}}-{{index}}" data-id={{data.id}} data-fieldName="sp_testimonialpro_item-{{index}}-message">{{{ itemSlide.message }}}</div>

                            <div class="sppb-addon-testimonial-pro-footer">
                            <# if (data.avatar_on_top !== 1) { 
                            if (!_.isEmpty(itemSlide.avatar)) { #>
                                <# if(itemSlide.avatar.indexOf("https://") == -1 && itemSlide.avatar.indexOf("http://") == -1){ #>
                                    <img class="{{ avatar_shape }}" src=\'{{ pagebuilder_base + itemSlide.avatar }}\' alt="">
                                <# } else { #>
                                    <img class="{{ avatar_shape }}" src=\'{{ itemSlide.avatar }}\' alt="">
                                <# } #>
                            <# }
                            } #>
                            <div class="testimonial-pro-client-name-wrap">
                            <# if( !_.isEmpty(itemSlide.title) ) { #>
                            <span class="sppb-addon-testimonial-pro-client-name">{{{ itemSlide.title }}}</span>
                            <# if( !_.isEmpty(itemSlide.url) ) { #>
                                &nbsp;<span class="sppb-addon-testimonial-pro-client-url">{{ itemSlide.url }}</span>
                            <# }
                            if( !_.isEmpty(itemSlide.designation) ) { #>
                                &nbsp;<span class="sppb-addon-testimonial-pro-client-designation">{{{ itemSlide.designation }}}</span>
                            <# }
                            } #>
                            </div>
                            </div>
                        </div>

                    <# }) #>
                </div>
                <# if(data.arrow_controls) { #>
                    <a href="#sppb-testimonial-pro-{{ data.id }}" class="left sppb-carousel-control" data-slide="prev"><i class="fa {{left_arrow}}"></i></a>
                    <a href="#sppb-testimonial-pro-{{ data.id }}" class="right sppb-carousel-control" data-slide="next"><i class="fa {{right_arrow}}"></i></a>
                <# } #>
            </div>
            ';

        return $output;
    }
}
