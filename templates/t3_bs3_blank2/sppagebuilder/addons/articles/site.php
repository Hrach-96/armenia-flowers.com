<?php
/**
* @package SP Page Builder
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2016 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

class SppagebuilderAddonArticles extends SppagebuilderAddons{

	public function render(){
		$class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';
		$style = (isset($this->addon->settings->style) && $this->addon->settings->style) ? $this->addon->settings->style : 'panel-default';
		$title = (isset($this->addon->settings->title) && $this->addon->settings->title) ? $this->addon->settings->title : '';
		$heading_selector = (isset($this->addon->settings->heading_selector) && $this->addon->settings->heading_selector) ? $this->addon->settings->heading_selector : 'h3';

		// Addon options
		$resource 			= (isset($this->addon->settings->resource) && $this->addon->settings->resource) ? $this->addon->settings->resource : 'article';
		$bloglayout = (isset($this->addon->settings->blog_layout) && $this->addon->settings->blog_layout) ? $this->addon->settings->blog_layout : 'blog.php';
		$catid 					= (isset($this->addon->settings->catid) && $this->addon->settings->catid) ? $this->addon->settings->catid : 0;
		$k2catid 				= (isset($this->addon->settings->k2catid) && $this->addon->settings->k2catid) ? $this->addon->settings->k2catid : 0;
		$include_subcat = (isset($this->addon->settings->include_subcat)) ? $this->addon->settings->include_subcat : 1;
		$ordering 			= (isset($this->addon->settings->ordering) && $this->addon->settings->ordering) ? $this->addon->settings->ordering : 'latest';
		$limit 					= (isset($this->addon->settings->limit) && $this->addon->settings->limit) ? $this->addon->settings->limit : 3;
		$columns 				= (isset($this->addon->settings->columns) && $this->addon->settings->columns) ? $this->addon->settings->columns : 0;
		$show_intro 		= (isset($this->addon->settings->show_intro)) ? $this->addon->settings->show_intro : 1;
		$intro_limit 		= (isset($this->addon->settings->intro_limit) && $this->addon->settings->intro_limit) ? $this->addon->settings->intro_limit : 200;


		$show_carousel 		= (isset($this->addon->settings->show_carousel)) ? $this->addon->settings->show_carousel : 1;
		$margin_items = (isset($this->addon->settings->margin_items) && $this->addon->settings->margin_items) ? $this->addon->settings->margin_items : '';
		$position_nav = (isset($this->addon->settings->position_nav) && $this->addon->settings->position_nav) ? $this->addon->settings->position_nav : '';

		$loop 		= (isset($this->addon->settings->loop)) ? $this->addon->settings->loop : 0;
		$nav 		= (isset($this->addon->settings->nav)) ? $this->addon->settings->nav : 0;
		$autoplay 		= (isset($this->addon->settings->autoplay)) ? $this->addon->settings->autoplay: 0;
		$autoplayTimeout	= (isset($this->addon->settings->autoplayTimeout)) ? $this->addon->settings->autoplayTimeout : 1200;
		$rewind 		= (isset($this->addon->settings->rewind)) ? $this->addon->settings->rewind : 0;
		$responsive_computer 		= (isset($this->addon->settings->responsive_computer)) ? $this->addon->settings->responsive_computer : 3;
		$responsive_laptop 		= (isset($this->addon->settings->responsive_laptop)) ? $this->addon->settings->responsive_laptop : 3;
		$responsive_tablet 		= (isset($this->addon->settings->responsive_tablet)) ? $this->addon->settings->responsive_tablet : 2;
		$responsive_mobile 		= (isset($this->addon->settings->responsive_computer)) ? $this->addon->settings->responsive_mobile : 1;

		$used_masonry = (isset($this->addon->settings->used_masonry)) ? $this->addon->settings->used_masonry : 0;
		$fancybox_icon = (isset($this->addon->settings->fancybox_icon)) ? $this->addon->settings->fancybox_icon : 0;
		$hide_thumbnail = (isset($this->addon->settings->hide_thumbnail)) ? $this->addon->settings->hide_thumbnail : 0;
		$show_author 		= (isset($this->addon->settings->show_author)) ? $this->addon->settings->show_author : 1;
		$show_category 	= (isset($this->addon->settings->show_category)) ? $this->addon->settings->show_category : 1;
		$show_date 			= (isset($this->addon->settings->show_date)) ? $this->addon->settings->show_date : 1;
		$show_tags 			= (isset($this->addon->settings->show_tags)) ? $this->addon->settings->show_tags : 1;

		$show_readmore 	= (isset($this->addon->settings->show_readmore)) ? $this->addon->settings->show_readmore : 1;
		$readmore_text 	= (isset($this->addon->settings->readmore_text) && $this->addon->settings->readmore_text) ? $this->addon->settings->readmore_text : 'Read More';
		$link_articles 	= (isset($this->addon->settings->link_articles)) ? $this->addon->settings->link_articles : 0;

		$all_articles_btn_text = (isset($this->addon->settings->all_articles_btn_text) && $this->addon->settings->all_articles_btn_text) ? $this->addon->settings->all_articles_btn_text : 'See all posts';
		$all_articles_btn_class .= (isset($this->addon->settings->all_articles_btn_type) && $this->addon->settings->all_articles_btn_type) ? ' sppb-btn-' . $this->addon->settings->all_articles_btn_type : ' sppb-btn-default';
		$all_articles_btn_class .= (isset($this->addon->settings->all_articles_btn_appearance) && $this->addon->settings->all_articles_btn_appearance) ? ' sppb-btn-' . $this->addon->settings->all_articles_btn_appearance : ' sppb-btn-flat';
		$all_articles_btn_class .= (isset($this->addon->settings->all_articles_btn_shape) && $this->addon->settings->all_articles_btn_shape) ? ' sppb-btn-' . $this->addon->settings->all_articles_btn_shape : ' sppb-btn-flat';


		$all_articles_btn_icon = (isset($this->addon->settings->all_articles_btn_icon) && $this->addon->settings->all_articles_btn_icon) ? $this->addon->settings->all_articles_btn_icon : '';
		$all_articles_btn_icon_position = (isset($this->addon->settings->all_articles_btn_icon_position) && $this->addon->settings->all_articles_btn_icon_position) ? $this->addon->settings->all_articles_btn_icon_position: 'left';
		if ($margin_items) {
			$margin_it = 'show_margin';
		}
		if ($position_nav) {
			$position_nav = 'position_nav';
		}
		
		$output   = '';
		//include k2 helper
		$k2helper 			= JPATH_ROOT . '/components/com_sppagebuilder/helpers/k2.php';
		$article_helper = JPATH_ROOT . '/components/com_sppagebuilder/helpers/articles.php';
		jimport( 'joomla.application.component.view' );
		jimport( 'joomla.filter.filteroutput' );

		$isk2installed  = self::isComponentInstalled('com_k2');

		$document 	= JFactory::getDocument();
		$app =& JFactory::getApplication();
		$template = $app->getTemplate();
		if ($show_carousel) {
			$owlpath = JURI::base() .'templates/'.$template.'/sppagebuilder/addons/articles/js/owl.carousel.min.js';
			$document->addScript($owlpath);
		}

		if($used_masonry){
			$path = JURI::base() .'templates/'.$template.'/sppagebuilder/addons/articles/js/masonry.pkgd.min.js';
		  	$document->addScript($path);
		  	$js = ' 
 				 jQuery(window).load(function(){
				    jQuery("#sppb-addon-'.$this->addon->id.' .grid").masonry({
					  itemSelector: ".grid-item",
					  percentPosition: true,
					  gutter: 0,
					  columnWidth: 0
					});
			});
		  	';
			$document->addScriptdeclaration($js);
		}
		if($fancybox_icon){
			$path2 = JURI::base() .'templates/'.$template.'/sppagebuilder/addons/articles/js/custom.js';
			$document->addStyleSheet(JURI::base() .'templates/'.$template.'/sppagebuilder/addons/articles/css/jquery.fancybox.css');
			$document->addStyleSheet(JURI::base() .'templates/'.$template.'/sppagebuilder/addons/articles/css/jquery.fancybox-buttons.css');
			$document->addStyleSheet(JURI::base() .'templates/'.$template.'/sppagebuilder/addons/articles/css/jquery.fancybox-thumbs.css');
			$document->addScript($path2);
			$js2 = '
				jQuery(document).ready(function($) {
				    $(window).load(function(){
				      $("#sppb-addon-'.$this->addon->id.' .blog-custom .image-box .fancybox-thumb , #sppb-addon-'.$this->addon->id.' .grid .image-box .fancybox-thumb , #sppb-addon-'.$this->addon->id.' .portfolio .image-box .fancybox-thumb").fancybox({
				      padding: 0,
				      margin: 0,
				      loop: true,
				      openSpeed:500,
				      closeSpeed:500,
				      nextSpeed:500,
				      prevSpeed:500,
				      afterLoad : function (){
				      },
				      beforeShow: function() {
				      },
				      afterClose : function() {
				      },
				      wrapCSS :"custom",
				      helpers: {
				        title : null,
				        thumbs: {
				          height: 50,
				          width: 80
				        }
				      }
				    });
				  });
				}); 
			';
			$document->addScriptdeclaration($js2);
		}
		if ($resource == 'k2') {
			if ($isk2installed == 0) {
				$output .= '<p class="alert alert-danger">' . JText::_('COM_SPPAGEBUILDER_ADDON_ARTICLE_ERORR_K2_NOTINSTALLED') . '</p>';
				return $output;
			} elseif(!file_exists($k2helper)) {
				$output .= '<p class="alert alert-danger">' . JText::_('COM_SPPAGEBUILDER_ADDON_K2_HELPER_FILE_MISSING') . '</p>';
				return $output;
			} else {
				require_once $k2helper;
			}
			$items = SppagebuilderHelperK2::getItems($limit, $ordering, $k2catid, $include_subcat);
		} else {
			require_once $article_helper;
			$items = SppagebuilderHelperArticles::getArticles($limit, $ordering, $catid, $include_subcat);
			
		}

		if(count($items)) {
			//print_r($bloglayout);
			require 'tmpl/'.$bloglayout.'';
		}

		return $output;
	}

	public function css() {
		$addon_id = '#sppb-addon-' .$this->addon->id;
		$layout_path = JPATH_ROOT . '/components/com_sppagebuilder/layouts';
		$css_path = new JLayoutFile('addon.css.button', $layout_path);

		$options = new stdClass;
		$options->button_type = (isset($this->addon->settings->all_articles_btn_type) && $this->addon->settings->all_articles_btn_type) ? $this->addon->settings->all_articles_btn_type : '';
		return $css_path->render(array('addon_id' => $addon_id, 'options' => $options, 'id' => 'btn-' . $this->addon->id));
	}
	public function js() {
		$show_carousel 		= (isset($this->addon->settings->show_carousel)) ? $this->addon->settings->show_carousel : 1;
		$loop 		= (isset($this->addon->settings->loop)) ? $this->addon->settings->loop : 0;
		$nav 		= (isset($this->addon->settings->nav)) ? $this->addon->settings->nav : 0;
		$autoplay 		= (isset($this->addon->settings->autoplay)) ? $this->addon->settings->autoplay: 0;
		$autoplayTimeout	= (isset($this->addon->settings->autoplayTimeout)) ? $this->addon->settings->autoplayTimeout : 1200;
		$rewind 		= (isset($this->addon->settings->rewind)) ? $this->addon->settings->rewind : 0;
		$responsive_computer 		= (isset($this->addon->settings->responsive_computer)) ? $this->addon->settings->responsive_computer : 3;
		$responsive_laptop 		= (isset($this->addon->settings->responsive_laptop)) ? $this->addon->settings->responsive_laptop : 3;
		$responsive_tablet 		= (isset($this->addon->settings->responsive_tablet)) ? $this->addon->settings->responsive_tablet : 2;
		$responsive_mobile 		= (isset($this->addon->settings->responsive_computer)) ? $this->addon->settings->responsive_mobile : 1;
		$jcorusel = '
      	jQuery(document).ready(function($) {
      		if($("#sppb-addon-'.$this->addon->id.' .team .image-box >a ").hasClass("iframe")){
			    $("#sppb-addon-'.$this->addon->id.' .team  .iframe").fancybox({
			      padding: 0,
			      margin: 0,
			      loop: true,
			      openSpeed:500,
			      closeSpeed:500,
			      nextSpeed:500,
			      prevSpeed:500,
			      afterLoad : function (){
			      },
			      beforeShow: function() {
			      },
			      afterClose : function() {
			      },
			      width		: "90%",
			      autoSize	: false,
				  height		: "90%",
				  maxWidth:"1199",
				  maxHeight:"530",
			      wrapCSS :"team",
			      helpers: {
			      	media : {},
			        title : null
			      }
			    });
			}
		});
		';		 
		if($show_carousel){
		if($loop){
            $jloop = 'loop:true';
          }else {
            $jloop = 'loop:false';
          }
          if($nav){
            $jnav = 'nav:true';
          }else {
            $jnav = 'nav:false';
          } 
          if($autoplay){
            $jautoplay = 'autoplay:true';
          }else {
           $jautoplay = 'autoplay:false';
          } 
          if($rewind){
            $jrewind = 'rewind:true';
          }else {
           $jrewind = 'rewind:false';
          } 
     
		$jcorusel .= '

        jQuery(document).ready(function($) {
        var $owl = $("#sppb-addon-'.$this->addon->id.' .owl-carousel");
        $owl.owlCarousel({
      	margin:0,
        autoplayTimeout:'.$autoplayTimeout.',
        '.$jloop.',
        '.$jnav.',
        '.$jautoplay.',
        '.$jrewind.',
	      dots:false,
	      onInitialized: callback,
	       navText: [ "", "" ],
	      responsive:{
	        0:{
	            items:'.$responsive_mobile.'
	        },
	        480:{
	            items:'.$responsive_tablet.'
	        },
	        768:{
	            items:'.$responsive_laptop.'
	        },
	        1200:{
	            items:'.$responsive_computer.'
	        }
	      }
        });
        function callback(event) {
          if($("#sppb-addon-'.$this->addon->id.' .image-box >a ").hasClass("fancybox-thumb")){
          $("#sppb-addon-'.$this->addon->id.' .owl-carousel .image-box .fancybox-thumb").fancybox({
            padding: 0,
            margin: 0,
            loop: true,
            openSpeed:500,
            closeSpeed:500,
            nextSpeed:500,
            prevSpeed:500,
            afterLoad : function (){
            },
            beforeShow: function() {
            },
            afterClose : function() {
            },
            wrapCSS :"custom",
            helpers: {
              title : null,
              thumbs: {
                height: 50,
                width: 80
              },
              overlay : {
                css : {
                  "background" : "#191919"
                }
              }
            }
          });
        }
        } 
      });';
	}else {
		$jcorusel .= '';
	} 
	$jcorusel .= '  
	jQuery(document).ready(function($) {
		var $grid = $("#sppb-addon-'.$this->addon->id.' .izotop");
		if($("#sppb-addon-'.$this->addon->id.' #isotopeContainer").hasClass("izotop")){

        $("#sort").on( "click", ".sort", function() {
          var sortByValue = $(this).attr("data-sort-by");
          if($(this).data("order") == "asc"){
            $(this).removeClass("block").addClass("none");
            $(this).next().removeClass("none").addClass("block");
          $grid.isotope({ 
          	layoutMode: "fitRows",
            sortBy: sortByValue ,
            sortAscending : true
          });
          }else if($(this).data("order") == "desc"){
             $(this).removeClass("block").addClass("none");
            $(this).prev().removeClass("none").addClass("block");
            $grid.isotope({ 
            	layoutMode: "fitRows",
              sortBy: sortByValue ,
              sortAscending : false
            });
          }

        });
		}

         $("#filters .filter").click(function(){
          var $this = $(this);
              if (!$this.hasClass("is-checked") ) {
                $this.parents("#options").find(".is-checked").removeClass("is-checked");
                $this.addClass("is-checked");
              }
            var selector = $this.attr("data-filter");
            $grid.isotope({ layoutMode: "fitRows", itemSelector: ".gallery-item", filter: selector });
            return false;
          });   
        $(window).load(function(){
			if($("#sppb-addon-'.$this->addon->id.' #isotopeContainer").hasClass("izotop")){
	          	$grid.isotope({
		            layoutMode: "fitRows",
		            itemSelector: ".gallery-item",
		            getSortData: {
		              name: ".name",
		              number: ".data parseInt",
		              popularity: ".popularity parseInt"
		            },
		              sortBy: "original-order"
		            });
				}
        	});
        });
	';

      return $jcorusel;
    }
	static function isComponentInstalled($component_name){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( 'a.enabled' );
		$query->from($db->quoteName('#__extensions', 'a'));
		$query->where($db->quoteName('a.name')." = ".$db->quote($component_name));
		$db->setQuery($query);
		$is_enabled = $db->loadResult();
		return $is_enabled;
	}

}
