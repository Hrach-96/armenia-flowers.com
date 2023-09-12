<?php
/**
 * @package		JMS Youtube for Virtuemart plugin
 * @version		1.0
 * @copyright	Copyright (C) 2009 - 2013 Joommasters. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @Website: http://www.joommasters.com
 * @Email: joommasters@gmail.com
 **/
 
defined('_JEXEC') or 	die( 'Direct Access to ' . basename( __FILE__ ) . ' is not allowed.' ) ;

if (!class_exists('vmCustomPlugin')) require(JPATH_VM_PLUGINS . DS . 'vmcustomplugin.php');

class plgVmCustomJmsyoutube extends vmCustomPlugin
{
	
	function __construct(& $subject, $config) {

		parent::__construct($subject, $config);

		$varsToPush = array(
			'width'=>array('300','int'),
			'height'=>array('200','int'),
			'border_width'=>array('0','char'),
			'border_color'=>array('#000000','char'),
			
			'autoplay'=>array('0','char'),
			'relate_video'=>array('1','char'),
			'youtube_title'=>array('1','char'),
			'controlbar'=>array('1','char'),
			'fade_control'=>array('1','char'),
			'progress_color'=>array('red','char'),
			'youtube_theme'=>array('dark','char'), 
			
			'youtube_link'=>array('','varchar'),
			'youtube_desc'=>array('','char'),
			'field_select'=>array('','char'),
			'new_title'=>array('','varchar'),
			'new_desc'=>array('','varchar')
		);
		$this->setConfigParameterable('customfield_params',$varsToPush);

	}
	
	
	function plgVmOnProductEdit($field, $product_id, &$row,&$retValue) {

		if ($field->custom_element != $this->_name) return '';

		//VmConfig::$echoDebug = true;
		//vmdebug('plgVmOnProductEdit',$field);
		$arr = array("1" => 'Show title', "2" => 'Custom title', "3" => 'No title');
		$html ='
			<fieldset>
				<legend>'. JText::_('Custom youtube') .'</legend>
				<table class="admintable">';
		$html .= VmHTML::row('select','Show title','customfield_params['.$row.'][field_select]',$arr,$field->field_select,'','value','text',false);
		$html .= VmHTML::row('input','Custom title','customfield_params['.$row.'][new_title]',$field->new_title);
		$html .= VmHTML::row('textarea','Custom desc','customfield_params['.$row.'][new_desc]',$field->new_desc);
		$html .= VmHTML::row('input','Youtube video ID','customfield_params['.$row.'][youtube_link]',$field->youtube_link);
		$html .= VmHTML::row('input','Width','customfield_params['.$row.'][width]',$field->width);
		$html .= VmHTML::row('input','Height','customfield_params['.$row.'][height]',$field->height);
		$html .= VmHTML::row('booleanlist','Youtube description','customfield_params['.$row.'][youtube_desc]',$field->youtube_desc);
		$html .= VmHTML::row('booleanlist','Auto play','customfield_params['.$row.'][autoplay]',$field->autoplay);

		$html .='</td>
		</tr>
				</table>
			</fieldset>';
		$retValue .= $html;
		$row++;
		return true ;
	}

	function Youlinkupdate(){
		
	}

	function plgVmOnDisplayProductFEVM3(&$product,&$group) {

		if ($group->custom_element != $this->_name) return '';
		$group->display .= $this->renderByLayout('default',array(&$product,&$group) );

		return true;
	}

	function plgVmDeclarePluginParamsCustom($psType,$name,$id, &$data){
		return $this->declarePluginParams('custom', $name, $id, $data);
	}

	
	function getVideoID($url)
   {
	  // make sure url has http on it
//	  if(substr($url, 0, 4) != "http") {
//		 $url = "http://".$url;
//	  }
//	  
//	  // make sure it has the www on it
//	  if(substr($url, 7, 4) != "www.") {
//		$url = str_replace('http://', 'http://www.', $url);
//	  }
//
//	  // extract the youtube ID from the url
//	  if(substr($url, 0, 31) == "http://www.youtube.com/watch?v=") {
//		 $id = substr($url, 31, 11);
//	  }
		 
	  return $url;	  
   }
   function getVideoTitle($id)
   {
		 $json_output = file_get_contents("http://gdata.youtube.com/feeds/api/videos/".$id."?v=2&alt=json");
		 $json = json_decode($json_output, true);
		 $video_title = $json['entry']['title']['$t'];

		return $video_title;
   }
   function getVideoDescription($id)
   {
		$json_output = file_get_contents("http://gdata.youtube.com/feeds/api/videos/".$id."?v=2&alt=json");
		$json = json_decode($json_output, true);
		
		//This gives you the video description
		$video_description = $json['entry']['media$group']['media$description']['$t'];
		
		//This gives you the video views count
		$view_count = $json['entry']['yt$statistics']['viewCount'];
		
		//This gives you the video title
		$video_title = $json['entry']['title']['$t'];

	  return $video_description;
   }
	
	
	public function plgVmDisplayInOrderCustom(&$html,$item, $param,$productCustom, $row ,$view='FE'){
		$this->plgVmDisplayInOrderCustom($html,$item, $param,$productCustom, $row ,$view);
	}

	public function plgVmCreateOrderLinesCustom(&$html,$item,$productCustom, $row ){
// 		$this->createOrderLinesCustom($html,$item,$productCustom, $row );
	}
	function plgVmOnSelfCallFE($type,$name,&$render) {
		$render->html = '';
	}
	/**
	 * Declares the Parameters of a plugin
	 * @param $data
	 * @return bool
	 */
	function plgVmDeclarePluginParamsCustomVM3(&$data){

		return $this->declarePluginParams('custom', $data);
	}

	function plgVmGetTablePluginParams($psType, $name, $id, &$xParams, &$varsToPush){
		return $this->getTablePluginParams($psType, $name, $id, $xParams, $varsToPush);
	}

	function plgVmSetOnTablePluginParamsCustom($name, $id, &$table,$xParams){
		return $this->setOnTablePluginParams($name, $id, $table,$xParams);
	}

	/**
	 * Custom triggers note by Max Milbers
	 */
	function plgVmOnDisplayEdit($virtuemart_custom_id,&$customPlugin){
		return $this->onDisplayEditBECustom($virtuemart_custom_id,$customPlugin);
	}
function plgVmOnViewCartVM3(&$product, &$productCustom, &$html) {
		if (empty($productCustom->custom_element) or $productCustom->custom_element != $this->_name) return false;

		if(empty($product->customProductData[$productCustom->virtuemart_custom_id][$productCustom->virtuemart_customfield_id])) return false;
		foreach( $product->customProductData[$productCustom->virtuemart_custom_id] as $k =>$item ) {
			if($productCustom->virtuemart_customfield_id == $k) {
				if(isset($item['comment'])){
					$html .='<span>'.vmText::_($productCustom->custom_title).' '.$item['comment'].'</span>';
				}
			}
		}
		return true;
	}
		function plgVmOnViewCartModuleVM3( &$product, &$productCustom, &$html) {
		return $this->plgVmOnViewCartVM3($product,$productCustom,$html);
	}


	function plgVmDisplayInOrderBEVM3( &$product, &$productCustom, &$html) {
		$this->plgVmOnViewCartVM3($product,$productCustom,$html);
	}

	function plgVmDisplayInOrderFEVM3( &$product, &$productCustom, &$html) {
		$this->plgVmOnViewCartVM3($product,$productCustom,$html);
	}


	/**
	 *
	 * vendor order display BE
	 */
	function plgVmDisplayInOrderBE(&$item, $productCustom, &$html) {
		if(!empty($productCustom)){
			$item->productCustom = $productCustom;
		}
		if (empty($item->productCustom->custom_element) or $item->productCustom->custom_element != $this->_name) return '';
		$this->plgVmOnViewCart($item,$productCustom,$html); //same render as cart
    }


	/**
	 *
	 * shopper order display FE
	 */
	function plgVmDisplayInOrderFE(&$item, $productCustom, &$html) {
		if(!empty($productCustom)){
			$item->productCustom = $productCustom;
		}
		if (empty($item->productCustom->custom_element) or $item->productCustom->custom_element != $this->_name) return '';
		$this->plgVmOnViewCart($item,$productCustom,$html); //same render as cart
    }
}