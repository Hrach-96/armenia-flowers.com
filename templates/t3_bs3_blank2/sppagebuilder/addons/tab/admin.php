<?php

/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2016 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct accees
defined('_JEXEC') or die('Restricted access');

SpAddonsConfig::addonConfig(
        array(
            'type' => 'repeatable',
            'addon_name' => 'sp_tab',
            'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB'),
            'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_DESC'),
            'category' => 'Content',
            'attr' => array(
                'general' => array(
                    'admin_label' => array(
                        'type' => 'text',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_ADMIN_LABEL_DESC'),
                        'std' => ''
                    ),
                    'title' => array(
                        'type' => 'text',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_DESC'),
                        'std' => ''
                    ),
                    'heading_selector' => array(
                        'type' => 'select',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_DESC'),
                        'values' => array(
                            'h1' => JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H1'),
                            'h2' => JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H2'),
                            'h3' => JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H3'),
                            'h4' => JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H4'),
                            'h5' => JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H5'),
                            'h6' => JText::_('COM_SPPAGEBUILDER_ADDON_HEADINGS_H6'),
                        ),
                        'std' => 'h3',
                        'depends' => array(array('title', '!=', '')),
                    ),
                    'title_font_family' => array(
                        'type' => 'fonts',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_FAMILY'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_FAMILY_DESC'),
                        'depends' => array(array('title', '!=', '')),
                        'selector' => array(
                            'type' => 'font',
                            'font' => '{{ VALUE }}',
                            'css' => '.sppb-addon-title { font-family: {{ VALUE }}; }'
                        )
                    ),
                    'title_fontsize' => array(
                        'type' => 'slider',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_SIZE'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_SIZE_DESC'),
                        'std' => '',
                        'depends' => array(array('title', '!=', '')),
                        'max' => 400,
                        'responsive' => true
                    ),
                    'title_lineheight' => array(
                        'type' => 'slider',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_LINE_HEIGHT'),
                        'std' => '',
                        'depends' => array(array('title', '!=', '')),
                        'max' => 400,
                        'responsive' => true
                    ),
                    'title_font_style' => array(
                        'type' => 'fontstyle',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_FONT_STYLE'),
                        'depends' => array(array('title', '!=', '')),
                    ),
                    'title_letterspace' => array(
                        'type' => 'select',
                        'title' => JText::_('COM_SPPAGEBUILDER_GLOBAL_LETTER_SPACING'),
                        'values' => array(
                            '0' => 'Default',
                            '1px' => '1px',
                            '2px' => '2px',
                            '3px' => '3px',
                            '4px' => '4px',
                            '5px' => '5px',
                            '6px' => '6px',
                            '7px' => '7px',
                            '8px' => '8px',
                            '9px' => '9px',
                            '10px' => '10px'
                        ),
                        'std' => '0',
                        'depends' => array(array('title', '!=', '')),
                    ),
                    'title_text_color' => array(
                        'type' => 'color',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_TEXT_COLOR_DESC'),
                        'depends' => array(array('title', '!=', '')),
                    ),
                    'title_margin_top' => array(
                        'type' => 'slider',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_TOP'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_TOP_DESC'),
                        'placeholder' => '10',
                        'depends' => array(array('title', '!=', '')),
                        'max' => 400,
                        'responsive' => true
                    ),
                    'title_margin_bottom' => array(
                        'type' => 'slider',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_BOTTOM'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TITLE_MARGIN_BOTTOM_DESC'),
                        'placeholder' => '10',
                        'depends' => array(array('title', '!=', '')),
                        'max' => 400,
                        'responsive' => true
                    ),
                    'text_align' => array(
                        'type' => 'select',
                        'title' => JText::_('Nav Block Align'),                       
                        'values' => array(
                            'sppb-text-left' => JText::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
                            'sppb-text-center' => JText::_('COM_SPPAGEBUILDER_GLOBAL_CENTER'),
                            'sppb-text-right' => JText::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
                        ),
                        'std' => 'left',
                    ),
                    'style' => array(
                        'type' => 'select',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_STYLE'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_STYLE_DESC'),
                        'values' => array(
                            'modern' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_STYLE_MODERN'),
                            'tabs' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_STYLE_DEFAULT'),
                            'pills' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_STYLE_PILLS'),
                            'lines' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_STYLE_LINES'),
                        ),
                        'std' => 'custom'
                    ),
                    'active_tab_bg' => array(
                        'type' => 'color',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_ACTIVE_BG'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_ACTIVE_BG_DESC'),
                        'std' => '#e5e5e5',
                        'depends' => array(
                            array('style', '!=', 'tabs'),
                            array('style', '!=', 'modern'),
                        ),
                    ),
                    'active_tab_color' => array(
                        'type' => 'color',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_ACTIVE_COLOR'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_ACTIVE_COLOR_DESC'),
                        'std' => '#333333',
                        'depends' => array(
                            array('style', '!=', 'tabs'),
                            array('style', '!=', 'modern'),
                        ),
                    ),
                    'class' => array(
                        'type' => 'text',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
                        'std' => ''
                    ),
                    // Repeatable Item
                    'sp_tab_item' => array(
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_ITEMS'),
                        'attr' => array(
                            'title' => array(
                                'type' => 'text',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_ITEM_TITLE'),
                                'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_ITEM_TITLE_DESC'),
                                'std' => 'Tab'
                            ),
                            'icon' => array(
                                'type' => 'icon',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_ITEM_ICON'),
                                'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_ITEM_ICON_DESC'),
                                'std' => ''
                            ),
                            'content' => array(
                                'type' => 'builder',
                                'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_ITEM_TEXT'),
                                'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_ITEM_TEXT_DESC'),
                                'std' => 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.'
                            ),
                        ),
                    ),
                    'tab_separator'=>array(
                        'type'=>'separator',
                        'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_TAB_SEPERATOR'),
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                    ),
                    'nav_width' => array(
                        'type' => 'slider',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_NAV_WIDTH'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_NAV_WIDTH_DESC'),
                        'responsive' => true,
                        'max' => 100,
                        'std' => array('md'=>30),
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                    ),
                    'nav_gutter' => array(
                        'type' => 'slider',
                        'title' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_NAV_GUTTER'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_ADDON_TAB_NAV_GUTTER_DESC'),
                        'responsive' => true,
                        'max' => 100,
                        'std' => array('md' => 15),
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                    ),
                    'nav_fontsize' => array(
                        'type' => 'slider',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_NAV_FONT_SIZE'),
                        'responsive' => true,
                        'max' => 400,
                        'std' => array('md'=>16),
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                    ),
                    'nav_color' => array(
                        'type' => 'color',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_NAV_COLOR'),
                        'std' => '#fff',
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                    ),
                    'nav_bg_color' => array(
                        'type' => 'color',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_NAV_BG_COLOR'),
                        'std' => '#000',
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                    ),
                    'nav_border' => array(
                        'type' => 'slider',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_NAV_BORDER'),
                        'std' => 1,
                        'max' => 20,
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                    ),
                    'nav_border_color' => array(
                        'type' => 'color',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_NAV_BORDER_COLOR'),
                        'std' => '#2AB9E7',
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                    ),
                    'nav_border_radius' => array(
                        'type' => 'slider',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_NAV_BORDER_RADIUS'),
                        'std' => '',
                        'max' => 400,
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                    ),
                    'nav_margin' => array(
                        'type' => 'margin',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_NAV_MARGIN'),
                        'responsive' => true,
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                        'std' => '',
                    ),
                    'nav_padding' => array(
                        'type' => 'padding',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_NAV_PADDING'),
                        'responsive' => true,
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                        'std' => '10px',
                    ),
                    'nav_text_align' => array(
                        'type' => 'select',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_TEXT_POSITION'),
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                        'values' => array(
                            'sppb-text-left' => JText::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
                            'sppb-text-center' => JText::_('COM_SPPAGEBUILDER_GLOBAL_CENTER'),
                            'sppb-text-right' => JText::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
                        ),
                        'std' => 'left',
                    ),
                    'nav_icon_postion' => array(
                        'type' => 'select',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_ICON_POSITION'),
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                        'values' => array(
                            'top' => JText::_('COM_SPPAGEBUILDER_GLOBAL_TOP'),
                            'right' => JText::_('COM_SPPAGEBUILDER_GLOBAL_RIGHT'),
                            'bottom' => JText::_('COM_SPPAGEBUILDER_GLOBAL_BOTTOM'),
                            'left' => JText::_('COM_SPPAGEBUILDER_GLOBAL_LEFT'),
                        ),
                        'std' => 'left',
                    ),
                    'show_boxshadow' => array(
                        'type' => 'checkbox',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_BOXSHADOW_SHOW'),
                        'desc' => JText::_('COM_SPPAGEBUILDER_TAB_BOXSHADOW_SHOW_DESC'),
                        'values' => array(
                            0 => 'No',
                            1 => 'Yes'
                        ),
                        'std' => 1,
                    ),
                    'shadow_color' => array(
                        'type' => 'color',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_BOXSHADOW_COLOR'),
                        'std' => '#000',
                        'depends' => array(
                            array('style', '=', 'custom'),
                            array('show_boxshadow', '=', 1),
                        ),
                    ),
                    'shadow_horizontal' => array(
                        'type' => 'slider',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_SHADOW_HORIZONTAL'),
                        'std' => '',
                        'max' => 100,
                        'depends' => array(
                            array('style', '=', 'custom'),
                            array('show_boxshadow', '=', 1),
                        ),
                    ),
                    'shadow_vertical' => array(
                        'type' => 'slider',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_SHADOW_VERTICAL'),
                        'std' => '',
                        'max' => 100,
                        'depends' => array(
                            array('style', '=', 'custom'),
                            array('show_boxshadow', '=', 1),
                        ),
                    ),
                    'shadow_blur' => array(
                        'type' => 'slider',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_SHADOW_BLUR'),
                        'std' => '',
                        'max' => 100,
                        'depends' => array(
                            array('style', '=', 'custom'),
                            array('show_boxshadow', '=', 1),
                        ),
                    ),
                    'shadow_spread' => array(
                        'type' => 'slider',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_SHADOW_SPREAD'),
                        'std' => '',
                        'max' => 100,
                        'depends' => array(
                            array('style', '=', 'custom'),
                            array('show_boxshadow', '=', 1),
                        ),
                    ),
                    'content_color' => array(
                        'type' => 'color',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_CONTENT_COLOR'),
                        'std' => '#000',
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                    ),
                    'content_backround' => array(
                        'type' => 'color',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_CONTENT_BACKGROUND'),
                        'std' => '#e5e5e5',
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                    ),
                    'content_border' => array(
                        'type' => 'slider',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_CONTENT_BORDER'),
                        'std' => 1,
                        'max' => 20,
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                    ),
                    'content_border_radius' => array(
                        'type' => 'slider',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_CONTEN_BORDER_RADIUS'),
                        'std' => '',
                        'max' => 400,
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                    ),
                    'content_border_color' => array(
                        'type' => 'color',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_CONTENT_BORDER_COLOR'),
                        'std' => '#2AB9E7',
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                    ),
                    'content_margin' => array(
                        'type' => 'margin',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_CONTENT_MARGIN'),
                        'responsive' => true,
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                        'std' => '',
                    ),
                    'content_padding' => array(
                        'type' => 'padding',
                        'title' => JText::_('COM_SPPAGEBUILDER_TAB_CONTENT_PADDING'),
                        'responsive' => true,
                        'depends' => array(
                            array('style', '=', 'custom')
                        ),
                        'std' => '10px',
                    ),
                ),
            ),
        )
);
