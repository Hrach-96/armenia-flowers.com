<?php
/*------------------------------------------------------------------------
# copyright Copyright (C) 2010 virtuemart. All Rights Reserved.
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

// no direct access
error_reporting('E_ALL');
error_reporting( 'E_ERROR');

jimport( 'joomla.plugin.plugin' );

class plgSystemVm_Search_Ac extends JPlugin
{
	var $isVM1 = false;

	function __construct(& $subject, $config){
		parent::__construct( $subject, $config );

		$lang	=& JFactory::getLanguage();
		$lang->load('vm_search_ac',JPATH_ADMINISTRATOR);

		//Load only in front end
		$app = JFactory::getApplication();
		if ($app->isAdmin()) {
			return false;
		}

	}

	function onAfterInitialise() {
		
		jimport('joomla.filesystem.file');
		$application = JFactory::getApplication();
		$option		= JRequest::getCmd('option');
		$ac	= JRequest::getVar('ac',0);
		$searchsku	= JRequest::getVar('searchsku',1);
		$searchchilds	= JRequest::getVar('searchchilds',1);
		$loadmj	= JRequest::getVar('loadmj',0);
		if (defined("_MJ") && !$loadmj) {
			return false;
		}
		
		$mcf_id = JRequest::getInt('mcf_id',0);
		if($option != 'com_virtuemart' || !$ac || !empty($mcf_id))	{
			return;
		}
		$q	= JRequest::getVar('q');
		$params = $this->params;
		$limit = $params->get( 'limit', 10 );
		$generate_sef = $params->get( 'generate_sef', 1 );
		

			if(!isset($_GET['type_script'])){
				
				//Virtuemart 2.0
				if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');
				VmConfig::loadConfig();
	
				if (!class_exists( 'VirtueMartModelProduct' )){
				   JLoader::import( 'product', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models' );
				}
				$productModel = new VirtueMartModelProduct();
				$productModel->setKeyWord($q);
				$valid_search_fields = array('product_name');
				if ($searchsku) {
					$valid_search_fields[] = 'product_sku';
				}
				$productModel->valid_search_fields 	= $valid_search_fields;
				$products = $productModel->getProductListing(false, $limit, false, false, false,false);
				$productModel->addImages($products);
	
				$result = array();
				foreach ($products as $product) {
					if (!$searchchilds && $product->product_parent_id > 0) {
						continue;
					}
					$link=JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id);
					//var_dump($link);
					$item = new stdClass;
					$item->product_name = $product->product_name;
					$item->product_sku = $product->product_sku;
					$item->product_thumb = $product->images[0];
					if (!empty($item->product_thumb)) {
						$item->product_thumb_image = $product->images[0]->getFileUrlThumb();
					} else {
						$item->product_thumb_image = '/images/stories/virtuemart/noimage.gif';
					}
					$item->product_thumb_path = JURI::root();
					$item->link = $link;
					//var_dump($item->link);
					$result[] = $item;
				}
			}


		@ob_end_clean(); // clear output buffer
		if ($result) {
			echo json_encode($result);
		}
		else return "";
		die();

	}
		

	/**
	 * Do something onAfterDispatch 
	 */
	function onAfterDispatch() {
		$loadmj	= JRequest::getVar('loadmj',0);
		if (defined("_MJ") && !$loadmj) {
			return false;
		}
		$this->_implementJavascript();
	}
	
	function _implementJavascript() {
		// if Admin side, just exit
		$application = JFactory::getApplication();
		if ($application->isAdmin()) { 
			return;
		}
		
		if(version_compare(JVERSION,'1.6.0','ge')) {
			$assets_path = 'plugins/system/vm_search_ac/vm_search_ac/';
		// Joomla! 1.6 and later code here
		} else {
			$assets_path = 'plugins/system/vm_search_ac/';
		// Joomla! 1.5 code here
		}
			
		if($this->isVM1) {
			require_once( JPATH_SITE.'/components/com_virtuemart/virtuemart_parser.php' );
		}

		//$plugin =& JPluginHelper::getPlugin( 'system', 'vm_search_ac' );
		$params = $this->params;
		$limit = $params->get( 'limit', 10 );
		
		if ($params->get( 'loadjquery', 1 )) {
			JHTML::script( 'jquery-1.7.1.min.js', $assets_path );
		}
		
		if ($cssfile = $params->get( 'cssfile', 'jquery.ac.css' )) {
			JHTML::stylesheet( $cssfile, $assets_path );
		}
		
		$js = "
		jQuery().ready(function() {
			var options = {
				dataType: 'json',
				parse: function(data) {return jQuery.map(data, function(row) {return {data: row,value: row.product_name,result: row.product_name}});},
				minChars:".$params->get( 'minChars', 3 ).",
				delay:".$params->get( 'delay', 400 ).",
				selectFirst:false,
				max: ".$params->get( 'max', 5 ).",
				resultsClass: 'ac_result',
				width:".$params->get( 'width', '200' ).",
				scrollHeight:false,
				formatItem: function(row) {var item='';";
					if ($params->get( 'showimg', 1 )) {
						$js.=" item+='<span class=\"product_img\"><img src=\"'+ row.product_thumb_path + row.product_thumb_image + '\"/></span> ';";
					}
					$js.="item+=row.product_name;";
					if ($params->get( 'showsku', 1 )) {
						$js.="item+='<br/><span class=\"product_sku\">'+row.product_sku+'</span>';";
					}
					$js.="return item;},
				extraParams:{ac:1,option:'com_virtuemart',view:'virtuemart',searchcat:".$params->get( 'searchcat', 1 ).",searchmanuf:".$params->get( 'searchmanuf', 1 ).",searchsku:".$params->get( 'searchsku', 1 ).",searchchilds:".$params->get( 'searchchilds', 1 )."}
			};
			fresult = function(event, data, formatted){if (data.link) {document.location.href = data.link;}}
			jQuery('.ac_vm[name=\"keyword\"],.ac_vm[type=\"text\"]').autocomplete('index.php',options).result(fresult);

		});";

		$document = &JFactory::getDocument();
		$document->addScriptDeclaration($js );

	}
}
