<?php
/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2016 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('Restricted access');

class SppagebuilderAddonGallery extends SppagebuilderAddons{

	public function render() {

		$class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';

		$title = (isset($this->addon->settings->title) && $this->addon->settings->title) ? $this->addon->settings->title : '';
		$heading_selector = (isset($this->addon->settings->heading_selector) && $this->addon->settings->heading_selector) ? $this->addon->settings->heading_selector : 'h3';
		$margin_items = (isset($this->addon->settings->margin_items) && $this->addon->settings->margin_items) ? $this->addon->settings->margin_items : '';

		//Options
		$width = (isset($this->addon->settings->width) && $this->addon->settings->width) ? $this->addon->settings->width : '';
		$height = (isset($this->addon->settings->height) && $this->addon->settings->height) ? $this->addon->settings->height : '';
		if ($margin_items) {
			$margin_it = 'show_margin';
		}
		$output  = '<div class="sppb-addon sppb-addon-gallery ' . $class . ' '.$margin_it.'">';
		$output .= ($title) ? '<'.$heading_selector.' class="sppb-addon-title">' . $title . '</'.$heading_selector.'>' : '';
		$output .= '<div class="sppb-addon-content">';
		$output .= '<div class="sppb-gallery image-gallery clearfix">';

		if(isset($this->addon->settings->sp_gallery_item) && count((array) $this->addon->settings->sp_gallery_item)){
			foreach ($this->addon->settings->sp_gallery_item as $key => $value) {
				if($value->thumb) {
					$output .= ($value->full) ? '<a data-original="' . $value->full . '" href="' . $value->full . '" class="swipebox sppb-gallery-btn">' : '';
					$output .= '<span><img class="sppb-img-responsive" src="' . $value->thumb . '" width="' . $width . '" height="' . $height . '" alt="' . $value->title . '" style="width:'.$width.'px;"></span>';
					$output .= ($value->full) ? '</a>' : '';
				}
			}
		}

		$output .= '</div>';
		$output	.= '</div>';
		$output .= '</div>';

		return $output;
	}

	public function stylesheets() {
		$document 	= JFactory::getDocument();
		$app =& JFactory::getApplication();
		$template = $app->getTemplate();
		return array(JURI::base() .'templates/'.$template.'/sppagebuilder/addons/gallery/css/default-skin.css',JURI::base() .'templates/'.$template.'/sppagebuilder/addons/gallery/css/slick.css');
	}

	public function scripts() {
		$document 	= JFactory::getDocument();
		$app =& JFactory::getApplication();
		$template = $app->getTemplate();
		return array(JURI::base() .'templates/'.$template.'/sppagebuilder/addons/gallery/js/lightgallery.min.js',JURI::base() .'templates/'.$template.'/sppagebuilder/addons/gallery/js/slick.min.js');
	}
	public function css() {
		$addon_id = '#sppb-addon-' . $this->addon->id;
		$style_img = (isset($this->addon->settings->border_radius) && $this->addon->settings->border_radius) ? 'border-radius: ' . $this->addon->settings->border_radius . 'px;' : '';

		$css = '';
		$css .= $addon_id . ' .sppb-gallery-btn span {' . $style_img . '}';
		$css .= $addon_id . ' .sppb-gallery-btn img {' . $style_img . '}';

		return $css;

	}
	public function js() {
		$show_carousel 		= (isset($this->addon->settings->show_carousel)) ? $this->addon->settings->show_carousel : 1;
		$responsive_computer 		= (isset($this->addon->settings->responsive_computer)) ? $this->addon->settings->responsive_computer : 3;
		$responsive_laptop 		= (isset($this->addon->settings->responsive_laptop)) ? $this->addon->settings->responsive_laptop : 3;
		$responsive_tablet 		= (isset($this->addon->settings->responsive_tablet)) ? $this->addon->settings->responsive_tablet : 2;
		$responsive_mobile 		= (isset($this->addon->settings->responsive_computer)) ? $this->addon->settings->responsive_mobile : 1;

		$addon_id = '#sppb-addon-' . $this->addon->id;
		if($show_carousel){
		$js ='jQuery(function($){
			$("'.$addon_id.' .image-gallery").lightGallery();
			
			$("'.$addon_id.' .image-gallery").slick({
			  infinite: true,
			  slidesToShow: '.$responsive_computer.',
			  slidesToScroll: 1,
			  draggable:false,
			  arrows:true,
			  responsive: [
			    {
			      breakpoint: 1200,
			      settings: {
			        slidesToShow: '.$responsive_laptop.',
			        slidesToScroll: 1,
			        infinite: true,
			        dots: true
			      }
			    },
			    {
			      breakpoint: 768,
			      settings: {
			        slidesToShow: '.$responsive_tablet.',
			        slidesToScroll: 1
			      }
			    },
			    {
			      breakpoint: 480,
			      settings: {
			        slidesToShow: '.$responsive_mobile.',
			        slidesToScroll: 1
			      }
			    }
			    // You can unslick at a given breakpoint now by adding:
			    // settings: "unslick"
			    // instead of a settings object
			  ]
			});
			
		})';
		}else {
		$js ='jQuery(function($){
			$("'.$addon_id.' .image-gallery").lightGallery();
		})';
		}
		return $js;
	}

	public static function getTemplate() {
		$output = '
		<div class="sppb-addon sppb-addon-gallery {{ data.class }}">
			<# if( !_.isEmpty( data.title ) ){ #><{{ data.heading_selector }} class="sppb-addon-title">{{ data.title }}</{{ data.heading_selector }}><# } #>
			<div class="sppb-addon-content">
				<ul class="sppb-gallery clearfix">
				<# _.each(data.sp_gallery_item, function (value, key) { #>
					<# if(value.thumb) { #>
						<li>
						<# if(value.full && value.full.indexOf("http://") == -1 && value.full.indexOf("https://") == -1){ #>
							<a href=\'{{ pagebuilder_base + value.full }}\' class="sppb-gallery-btn">
						<# } else if(value.full){ #>
							<a href=\'{{ value.full }}\' class="sppb-gallery-btn">
						<# } #>
							<# if(value.thumb && value.thumb.indexOf("http://") == -1 && value.thumb.indexOf("https://") == -1){ #>
								<img class="sppb-img-responsive" src=\'{{ pagebuilder_base + value.thumb }}\' width="{{ data.width }}" height="{{ data.height }}" alt="{{ value.title }}" style="width:{{ data.width }}px;">
							<# } else if(value.thumb){ #>
								<img class="sppb-img-responsive" src=\'{{ value.thumb }}\' width="{{ data.width }}" height="{{ data.height }}" alt="{{ value.title }}" style="width:{{ data.width }}px;">
							<# } #>
							
						<# if(value.full){ #>
							</a>
						<# } #>
						</li>
					<# } #>
				<# }); #>
				</ul>
			</div>
		</div>
		';

		return $output;
	}

}
