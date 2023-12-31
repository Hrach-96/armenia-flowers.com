<?php
/**
* @package SP Page Builder
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2016 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('Restricted access');

SpAddonsConfig::addonConfig(
	array(
		'type'=>'repeatable',
		'addon_name'=>'sp_gallery',
		'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_GALLERY'),
		'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_GALLERY_DESC'),
		'category'=>'Media',
		'attr'=>array(
			'general' => array(

				'admin_label'=>array(
					'type'=>'text',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL_DESC'),
					'std'=> ''
				),

				'title'=>array(
					'type'=>'text',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_DESC'),
					'std'=>  ''
				),

				'heading_selector'=>array(
					'type'=>'select',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_DESC'),
					'values'=>array(
						'h1'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H1'),
						'h2'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H2'),
						'h3'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H3'),
						'h4'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H4'),
						'h5'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H5'),
						'h6'=>JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H6'),
					),
					'std'=>'h3',
					'depends'=>array(array('title', '!=', '')),
				),

				'title_font_family'=>array(
					'type'=>'fonts',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_FAMILY'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_FAMILY_DESC'),
					'depends'=>array(array('title', '!=', '')),
					'selector'=> array(
						'type'=>'font',
						'font'=>'{{ VALUE }}',
						'css'=>'.sppb-addon-title { font-family: {{ VALUE }}; }'
					)
				),

				'title_fontsize'=>array(
					'type'=>'slider',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_SIZE'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_SIZE_DESC'),
					'std'=>'',
					'depends'=>array(array('title', '!=', '')),
					'responsive' => true,
					'max'=> 400,
				),

				'title_lineheight'=>array(
					'type'=>'slider',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_LINE_HEIGHT'),
					'std'=>'',
					'depends'=>array(array('title', '!=', '')),
					'responsive' => true,
					'max'=> 400,
				),

				'title_font_style'=>array(
					'type'=>'fontstyle',
					'title'=> JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_STYLE'),
					'depends'=>array(array('title', '!=', '')),
				),

				'title_letterspace'=>array(
					'type'=>'select',
					'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_LETTER_SPACING'),
					'values'=>array(
						'0'=> 'Default',
						'1px'=> '1px',
						'2px'=> '2px',
						'3px'=> '3px',
						'4px'=> '4px',
						'5px'=> '5px',
						'6px'=>	'6px',
						'7px'=>	'7px',
						'8px'=>	'8px',
						'9px'=>	'9px',
						'10px'=> '10px'
					),
					'std'=>'0',
					'depends'=>array(array('title', '!=', '')),
				),

				'title_text_color'=>array(
					'type'=>'color',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
					'depends'=>array(array('title', '!=', '')),
				),

				'title_margin_top'=>array(
					'type'=>'slider',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_TOP'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_TOP_DESC'),
					'placeholder'=>'10',
					'depends'=>array(array('title', '!=', '')),
					'responsive' => true,
					'max'=> 400,
				),

				'title_margin_bottom'=>array(
					'type'=>'slider',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_BOTTOM'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_BOTTOM_DESC'),
					'placeholder'=>'10',
					'depends'=>array(array('title', '!=', '')),
					'responsive' => true,
					'max'=> 400,
				),

				'class'=>array(
					'type'=>'text',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
					'std'=>''
				),
				'border_radius'=>array(
					'type'=>'slider',
					'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BORDER_RADIUS'),
					'std'=>0,
					'max'=>300
				),

				'margin_items'=>array(
					'type'=>'checkbox',
					'title'=>JText::_('Show Margin'),
					'std'=>1,
				),

				'width'=>array(
					'type'=>'slider',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_GALLERY_IMAGE_WIDTH'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_GALLERY_IMAGE_WIDTH_DESC'),
					'std'=>'',
					'max'=>1000
				),

				'height'=>array(
					'type'=>'slider',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_GALLERY_IMAGE_HEIGHT'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_GALLERY_IMAGE_HEIGHT_DESC'),
					'std'=>'',
					'max'=>1000
				),
				'show_carousel'=>array(
					'type'=>'checkbox',
					'title'=>JText::_('Use Carousel'),
					'desc'=>JText::_('If you use the layaut carousel.php , then when you enable this setting, you can configure some of the parameters of the carousel'),
					'std'=>0,
				),
				'responsive_computer'=>array(
					'type'=>'number',
					'title'=>JText::_('Responsive Computer'),
					'desc'=>JText::_('Object containing responsive options.'),
					'std'=>3,
					'depends'=>array('show_carousel'=>'1')
				),
				'responsive_laptop'=>array(
					'type'=>'number',
					'title'=>JText::_('Responsive Laptop'),
					'desc'=>JText::_('Object containing responsive options.'),
					'std'=>3,
					'depends'=>array('show_carousel'=>'1')
				),
				'responsive_tablet'=>array(
					'type'=>'number',
					'title'=>JText::_('Responsive Tablet'),
					'desc'=>JText::_('Object containing responsive options.'),
					'std'=>2,
					'depends'=>array('show_carousel'=>'1')
				),
				'responsive_mobile'=>array(
					'type'=>'number',
					'title'=>JText::_('Responsive Mobile'),
					'desc'=>JText::_('Object containing responsive options.'),
					'std'=>1,
					'depends'=>array('show_carousel'=>'1')
				),
				// Repeatable Items
				'sp_gallery_item'=>array(
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_GALLERY_ITEMS'),
					'attr'=>array(
						'title'=>array(
							'type'=>'text',
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_GALLERY_ITEM_TITLE'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_GALLERY_ITEM_TITLE_DESC'),
							'std'=>'Gallery Item 1'
						),
						'thumb'=>array(
							'type'=>'media',
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_GALLERY_THUMB'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_GALLERY_THUMB_DESC'),
							'std'=>'https://sppagebuilder.com/addons/gallery/gallery1.jpg'
						),
						'full'=>array(
							'type'=>'media',
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_GALLERY_FULL'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_GALLERY_FULL_DESC'),
							'std'=>'https://sppagebuilder.com/addons/gallery/gallery1.jpg'
						),
					),
				),
			)
		),
	)
);
