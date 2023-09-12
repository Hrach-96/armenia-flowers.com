<?php
/**
* @package SP Page Builder
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2016 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('restricted access');

SpAddonsConfig::addonConfig(
	array(
		'type'=>'repeatable',
		'addon_name'=>'sp_carouselpro',
		'category'=>'Slider',
		'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ADVANCED'),
		'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ADVANCED_DESC'),
		'attr'=>array(
			'general' => array(

				'admin_label'=>array(
					'type'=>'text',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL_DESC'),
					'std'=> ''
				),
				'style_pro'=>array(
					'type'=>'select',
					'title'=>JText::_('Style Controls'),
					'values'=>array(
						'style_1'=>JText::_('Style 1'),
						'style_2'=>JText::_('Style 2'),
					),
					'std'=>'style_1',
				),
				'limit'=>array(
				'type'=>'number',
				'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_ARTICLES_LIMIT'),
				'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_ARTICLES_LIMIT_DESC'),
					'std'=>'3'
				),

				'columns'=>array(
					'type'=>'number',
					'title'=>JText::_('Ropw(s)'),
					'desc'=>JText::_('Set the number of items for row.'),
					'std'=>'3',
				),
				'loop'=>array(
					'type'=>'checkbox',
					'title'=>JText::_('Loop'),
					'desc'=>JText::_('Infinity loop. Duplicate last and first items to get loop illusion.'),
					'std'=>0
				),
				
				'controller'=>array(
					'type'=>'checkbox',
					'title'=>JText::_('Nav'),
					'desc'=>JText::_('Show pagination'),
					'std'=>0
				),
				'arrow'=>array(
					'type'=>'checkbox',
					'title'=>JText::_('Controllers'),
					'desc'=>JText::_('Show next/prev buttons'),
					'std'=>0
				),

				'autoplay'=>array(
					'type'=>'checkbox',
					'title'=>JText::_('Autoplay'),
					'desc'=>JText::_('Use Autoplay'),
					'std'=>0
				),
				'autoplayTimeout'=>array(
					'type'=>'number',
					'title'=>JText::_('AutoplayTimeout'),
					'desc'=>JText::_('Autoplay interval timeout'),
					'std'=>12000
				),
				'rewind'=>array(
					'type'=>'checkbox',
					'title'=>JText::_('Rewind'),
					'desc'=>JText::_('Go backwards when the boundary has reached.'),
					'std'=>0
				),
				'responsive_computer'=>array(
					'type'=>'number',
					'title'=>JText::_('Responsive Computer'),
					'desc'=>JText::_('Object containing responsive options.'),
					'std'=>3
				),
				'responsive_laptop'=>array(
					'type'=>'number',
					'title'=>JText::_('Responsive Laptop'),
					'desc'=>JText::_('Object containing responsive options.'),
					'std'=>3
				),
				'responsive_tablet'=>array(
					'type'=>'number',
					'title'=>JText::_('Responsive Tablet'),
					'desc'=>JText::_('Object containing responsive options.'),
					'std'=>2
				),
				'responsive_mobile'=>array(
					'type'=>'number',
					'title'=>JText::_('Responsive Mobile'),
					'desc'=>JText::_('Object containing responsive options.'),
					'std'=>1
				),

				'class'=>array(
					'type'=>'text',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
					'std'=>''
				),

				// Repeatable Items
				'sp_carouselpro_item'=>array(
					'title'=> JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEMS'),
					'attr'=>  array(
						'content_width_pro'=>array(
							'type'=>'slider',
							'title'=>JText::_('Caption Width'),
							'max'=>100
						),
						'content_position_pro'=>array(
							'type'=>'select',
							'title'=>JText::_('Content Position(left,right)'),
							'values'=>array(
								'text-left'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
								'text-right'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
								'text-center'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_CENTER'),
							),
							'std'=>'text-left',
						),
						'title'=>array(
							'type'=>'text',
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_TITLE'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_TITLE_DESC'),
							'std'=>'Carousel Item Title',

						),

						'title_font_family'=>array(
							'type'=>'fonts',
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_TITLE_FONT_FAMILY'),
							'depends'=>array(array('title', '!=', '')),
							'selector'=> array(
								'type'=>'font',
								'font'=>'{{ VALUE }}',
								'css'=>' h2 { font-family: {{ VALUE }}; }'
							)
						),

						'title_fontsize'=>array(
							'type'=>'slider',
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_TITLE_FONTSIZE'),
							'max'=>100,
							'depends'=>array(array('title', '!=', '')),
							'std'=>array('md'=>46, 'sm'=>36, 'xs'=>16),
							'responsive' => true
						),

						'title_lineheight'=>array(
							'type'=>'slider',
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_TITLE_LINEHEIGHT'),
							'max'=>100,
							'depends'=>array(array('title', '!=', '')),
							'std'=>array('md'=>56, 'sm'=>46, 'xs'=>20),
							'responsive' => true
						),				
						'title_font_style'=>array(
							'type'=>'select',
							'title'=> JText::_('Title Font Weight'),
							'values'=>array(
								'100'=> 'Thin',
								'200'=> 'Extra Light',
								'300'=> 'Light',
								'400'=> 'Normal',
								'500'=> 'Medium',
								'600'=> 'Semi Bold',
								'700'=>	'Bold',
								'800'=>	'Extra Bold',
								'900'=>	'Black'
							),
							'std'=>'0',
							'depends'=>array(array('title', '!=', '')),
						),
						'title_color'=>array(
							'type'=>'color',
							'depends'=>array(array('title', '!=', '')),
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_TITLE_COLOR'),
							'std'=>'#fff',
						),

						'title_margin'=>array(
							'type'=>'margin',
							'depends'=>array(array('title', '!=', '')),
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_TITLE_MARGIN'),
							'std'=>array('md'=>'0px 0px 0px 0px', 'sm'=>'0px 0px 0px 0px', 'xs'=>'0px 0px 0px 0px'),
							'responsive' => true
						),

						'content'=>array(
							'type'=>'editor',
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_CONTENT'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_CONTENT_DESC'),
							'std'=> 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.',
						),

						'content_font_family'=>array(
							'type'=>'fonts',
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_CONTENT_FONT_FAMILY'),
							'depends'=>array(array('content', '!=', '')),
							'selector'=> array(
								'type'=>'font',
								'font'=>'{{ VALUE }}',
								'css'=>' .sppb-carousel-pro-text .sppb-carousel-content { font-family: {{ VALUE }}; }'
							)
						),

						'content_fontsize'=>array(
							'type'=>'slider',
							'depends'=>array(array('content', '!=', '')),
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_CONTENT_FONTSIZE'),
							'max'=>100,
							'std'=>array('md'=>16, 'sm'=>14, 'xs'=>12),
							'responsive' => true
						),

						'content_lineheight'=>array(
							'type'=>'slider',
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_CONTENT_LINEHEIGHT'),
							'max'=>100,
							'std'=>array('md'=>24, 'sm'=>22, 'xs'=>16),
							'depends'=>array(array('content', '!=', '')),
							'responsive' => true
						),
						'content_font_style'=>array(
							'type'=>'select',
							'title'=> JText::_('Content Font Weight'),
							'values'=>array(
								'100'=> 'Thin',
								'200'=> 'Extra Light',
								'300'=> 'Light',
								'400'=> 'Normal',
								'500'=> 'Medium',
								'600'=> 'Semi Bold',
								'700'=>	'Bold',
								'800'=>	'Extra Bold',
								'900'=>	'Black'
							),
							'std'=>'0',
							'depends'=>array(array('content', '!=', '')),
						),
						'content_color'=>array(
							'type'=>'color',
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_CONTENT_COLOR'),
							'depends'=>array(array('content', '!=', '')),
							'std'=>'#fff',
						),

						'content_padding'=>array(
							'type'=>'padding',
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_CONTENT_PADDING'),
							'std'=>array('md'=>'20px 0px 30px 0px', 'sm'=>'15px 0px 20px 0px', 'xs'=>'10px 0px 10px 0px'),
							'depends'=>array(array('content', '!=', '')),
							'responsive' => true
						),
						'content_margin'=>array(
							'type'=>'margin',
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ITEM_CONTENT_MARGIN'),
							'std'=>array('md'=>'0px 0px 0px 0px', 'sm'=>'0px 0px 0px 0px', 'xs'=>'0px 0px 0px 0px'),
							'depends'=>array(array('content', '!=', '')),
							'responsive' => true
						),

						'bg'=>array(
							'type'=>'media',
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ADVANCED_ITEM_BACKGROUND_IMAGE'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ADVANCED_ITEM_BACKGROUND_IMAGE_DESC'),
						),
						'bg_url'=>array(
							'type'=>'media',
							'format'=>'attachment',
							'title'=>JText::_('Images URL'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_URL_DESC'),
							'placeholder'=>'http://',
							'hide_preview'=>true,
						),

						'image'=>array(
							'type'=>'media',
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ADVANCED_ITEM_IMAGE'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ADVANCED_ITEM_IMAGE_DESC'),
						),

						'video'=>array(
							'type'=>'text',
							'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ADVANCED_ITEM_VIDEO'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_CAROUSEL_ADVANCED_ITEM_VIDEO_DESC'),
						),

						//Button
						'button_text'=>array(
							'type'=>'text',
							'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_TEXT'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_TEXT_DESC'),
							'std'=>'Button Text',
						),

						'button_font_style'=>array(
							'type'=>'fontstyle',
							'title'=> JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_FONT_STYLE'),
							'depends'=> array(
								array('button_text', '!=', ''),
							)
						),

						'button_letterspace'=>array(
							'type'=>'select',
							'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_LETTER_SPACING'),
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
							'depends'=> array(
								array('button_text', '!=', ''),
							)
						),

						'button_url'=>array(
							'type'=>'media',
							'format'=>'attachment',
							'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_URL'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_URL_DESC'),
							'placeholder'=>'http://',
							'hide_preview'=>true,
							'depends'=> array(
								array('button_text', '!=', ''),
							)
						),

						'button_target'=>array(
							'type'=>'select',
							'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_LINK_NEWTAB'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_LINK_NEWTAB_DESC'),
							'values'=>array(
								''=>JText::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_SAME_WINDOW'),
								'_blank'=>JText::_('COM_SPPAGEBUILDER_ADDON_GLOBAL_TARGET_NEW_WINDOW'),
							),
							'depends'=> array(
								array('button_text', '!=', ''),
							)
						),

						'button_type'=>array(
							'type'=>'select',
							'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_STYLE'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_STYLE_DESC'),
							'values'=>array(
								'default'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_DEFAULT'),
								'primary'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_PRIMARY'),
								'success'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_SUCCESS'),
								'info'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_INFO'),
								'warning'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_WARNING'),
								'danger'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_DANGER'),
								'link'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_LINK'),
								'custom'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_CUSTOM'),
							),
							'std'=>'default',
							'depends'=> array(
								array('button_text', '!=', ''),
							)
						),

						'button_appearance'=>array(
							'type'=>'select',
							'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_DESC'),
							'values'=>array(
								''=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_FLAT'),
								'gradient'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_GRADIENT'),
								'outline'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_OUTLINE'),
								'3d'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_APPEARANCE_3D'),
							),
							'std'=>'flat',
							'depends'=> array(
								array('button_text', '!=', ''),
							)
						),

						'button_status'=>array(
							'type'=>'buttons',
							'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_ENABLE_BACKGROUND_OPTIONS'),
							'std'=>'normal',
							'values'=>array(
								array(
									'label' => 'Normal',
									'value' => 'normal'
								),
								array(
									'label' => 'Hover',
									'value' => 'hover'
								),
							),
							'tabs' => true,
							'depends'=>array(
								array('button_type', '=', 'custom'),
								array('button_text', '!=', ''),
							)
						),

						'button_background_color'=>array(
							'type'=>'color',
							'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BACKGROUND_COLOR'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BACKGROUND_COLOR_DESC'),
							'std' => '#444444',
							'depends'=> array(
								array('button_appearance', '!=', 'gradient'),
								array('button_type', '=', 'custom'),
								array('button_status', '=', 'normal'),
								array('button_text', '!=', ''),
							)
						),

						'button_background_gradient'=>array(
							'type'=>'gradient',
							'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_GRADIENT'),
							'std'=> array(
								"color" => "#B4EC51",
								"color2" => "#429321",
								"deg" => "45",
								"type" => "linear"
							),
							'depends'=>array(
								array('button_appearance', '=', 'gradient'),
								array('button_type', '=', 'custom'),
								array('button_status', '=', 'normal'),
								array('button_text', '!=', ''),
							)
						),

						'button_color'=>array(
							'type'=>'color',
							'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_COLOR'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_COLOR_DESC'),
							'std' => '#fff',
							'depends'=> array(
								array('button_type', '=', 'custom'),
								array('button_status', '=', 'normal'),
								array('button_text', '!=', ''),
							)
						),

						'button_background_color_hover'=>array(
							'type'=>'color',
							'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BACKGROUND_COLOR_HOVER'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BACKGROUND_COLOR_HOVER_DESC'),
							'std' => '#222',
							'depends'=> array(
								array('button_appearance', '!=', 'gradient'),
								array('button_type', '=', 'custom'),
								array('button_status', '=', 'hover'),
								array('button_text', '!=', ''),
							)
						),

						'button_background_gradient_hover'=>array(
							'type'=>'gradient',
							'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BACKGROUND_GRADIENT'),
							'std'=> array(
								"color" => "#429321",
								"color2" => "#B4EC51",
								"deg" => "45",
								"type" => "linear"
							),
							'depends'=>array(
								array('button_appearance', '=', 'gradient'),
								array('button_type', '=', 'custom'),
								array('button_status', '=', 'hover'),
								array('button_text', '!=', ''),
							)
						),

						'button_color_hover'=>array(
							'type'=>'color',
							'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_COLOR_HOVER'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_COLOR_HOVER_DESC'),
							'std' => '#fff',
							'depends'=> array(
								array('button_type', '=', 'custom'),
								array('button_status', '=', 'hover'),
								array('button_text', '!=', ''),
							)
						),

						'button_size'=>array(
							'type'=>'select',
							'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_DESC'),
							'values'=>array(
								''=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_DEFAULT'),
								'lg'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_LARGE'),
								'xlg'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_XLARGE'),
								'sm'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_SMALL'),
								'xs'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SIZE_EXTRA_SAMLL'),
							),
							'depends'=> array(
								array('button_text', '!=', ''),
							)
						),

						'button_shape'=>array(
							'type'=>'select',
							'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_DESC'),
							'values'=>array(
								'rounded'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_ROUNDED'),
								'square'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_SQUARE'),
								'round'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_SHAPE_ROUND'),
							),
							'depends'=> array(
								array('button_text', '!=', ''),
							)
						),

						'button_block'=>array(
							'type'=>'select',
							'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BLOCK'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_BLOCK_DESC'),
							'values'=>array(
								''=>JText::_('JNO'),
								'sppb-btn-block'=>JText::_('JYES'),
							),
							'depends'=> array(
								array('button_text', '!=', ''),
							)
						),

						'button_icon'=>array(
							'type'=>'icon',
							'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON'),
							'desc'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON_DESC'),
							'depends'=> array(
								array('button_text', '!=', ''),
							)
						),

						'button_icon_position'=>array(
							'type'=>'select',
							'title'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_BUTTON_ICON_POSITION'),
							'values'=>array(
								'left'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
								'right'=>JText::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
							),
							'depends'=> array(
								array('button_text', '!=', ''),
							)
						),

					),
				),
			),
		),
	)
);
