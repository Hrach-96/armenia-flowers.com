<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelitem');
class CooltagsModelproductslist extends JModelItem
{
	public function getPriceformat() 
	{
		$db = JFactory::getDBO();
		$q ="SELECT curr.*  
		FROM `#__virtuemart_currencies` AS curr 
		LEFT JOIN `#__virtuemart_vendors` AS vend ON vend.`vendor_currency` = curr.`virtuemart_currency_id`  
		WHERE vend.`virtuemart_vendor_id` = '1' ";
		$db->setQuery($q);
		$price_format 	= $db->loadRow();
		$this->_price_format = $price_format;
		return $this->_price_format;
	}
	
	static function applytaxes( $pricebefore, $catid ,  $vendor_id){
			$is_shopper = 1;
			
			$db = JFactory::getDBO();
			$q ="SELECT vc.`virtuemart_calc_id` , vc.`calc_name` , vc.`calc_kind` , vc.`calc_value_mathop` , vc.`calc_value` , vc.`calc_currency` ,  vc.`ordering` 
				FROM `#__virtuemart_calcs` vc 
				LEFT JOIN `#__virtuemart_calc_categories` vcc ON vcc.`virtuemart_calc_id` = vc.`virtuemart_calc_id`
				WHERE vc.`published`='1' 
				AND (vc.`shared` ='1' OR vc.`virtuemart_vendor_id` = '".$vendor_id."' )" ;
			if($is_shopper)
				$q .= " AND vc.`calc_shopper_published` = '1' ";
	
			$q .= "AND (vc.`publish_up`='0000-00-00 00:00:00' OR vc.`publish_up` <= NOW() ) ";
			$q .= "AND (vc.`publish_down`='0000-00-00 00:00:00' OR vc.`publish_down` >= NOW() ) 
			AND vcc.`virtuemart_category_id` ='".$catid."' 
				ORDER BY vc.`ordering` ASC";
			$db->setQuery($q);
			$taxes = $db->loadObjectList();
			$price_withtax = $pricebefore;
			if(count($taxes)>0){
				foreach($taxes as $tax){
					$calc_value_mathop = $tax->calc_value_mathop;
					$calc_value = $tax->calc_value;
					switch ($calc_value_mathop){
						case '+':
							$price_withtax = $price_withtax + $calc_value;
						break;
						case '-':
							$price_withtax = $price_withtax - $calc_value;
						break;
						case '+%':
							$price_withtax = $price_withtax + ( ( $price_withtax * $calc_value ) / 100 );
						break;
						case '-%':
							$price_withtax = $price_withtax - ( ( $price_withtax * $calc_value ) / 100 );
						break;
					}	
				}
			}
			return $price_withtax;	
		}
	
	public function getProducts() 
	{

		$db = JFactory::getDBO();
		if (!class_exists( 'VmConfig' ))
			require(JPATH_ADMINISTRATOR .  '/components/com_virtuemart/helpers/config.php');
		VmConfig::loadConfig();
		
		$app 		= JFactory::getApplication();
		// Get the pagination request variables
		$limit 		= $app->getUserStateFromRequest('com_cooltags.limit', 'limit', $app->getCfg('list_limit'), 'int');
		$limitstart = $app->input->get('limitstart', 0, '', 'int');
		$tag		= $app->input->get('tag', null, null);
	//	$json_tag = json_encode($tag);
	//	$json_encoded = str_replace('"', '', $json_tag);
		//$json_encoded = urlencode($json_encoded);
	//	$json_encoded = str_replace('%5C', '%5C%5C%5C%5C' , $json_encoded);
	//	$json_encoded = urldecode($json_encoded);

		$json_encoded = $tag;

		$q = "SELECT DISTINCT(vpl.`virtuemart_product_id`) , vpl.`product_name` , vpl.`product_s_desc` , 
		vp.`virtuemart_vendor_id` ,  
		vcl.`category_name` ,  vcl.`virtuemart_category_id`  ,
		vm.`file_url` , vm.`file_url_thumb` ,
		vpc.`customfield_params` AS stored_tags , 
		vpp.product_price,
		SUBSTRING( vpc.`customfield_params` , 
					LOCATE('product_tags=\"', vpc.`customfield_params` )+14 ,
 					CHAR_LENGTH( vpc.`customfield_params` ) - ( LOCATE('\"|', REVERSE( vpc.`customfield_params` ) ) +2 ) - 14 
				) AS accented_tags 
		FROM `#__virtuemart_products_".VMLANG."` vpl  
		JOIN `#__virtuemart_products` vp ON vpl.`virtuemart_product_id` = vp.`virtuemart_product_id` 
		JOIN `#__virtuemart_product_customfields` vpc ON vpl.`virtuemart_product_id` = vpc.`virtuemart_product_id` 
		JOIN `#__virtuemart_product_categories` vpcat ON vpcat.`virtuemart_product_id` = vp.`virtuemart_product_id` 
		JOIN `#__virtuemart_categories_".VMLANG."` vcl ON vcl.`virtuemart_category_id` = vpcat.`virtuemart_category_id` 
		LEFT JOIN `#__virtuemart_product_medias` vpm ON vpl.`virtuemart_product_id` = vpm.`virtuemart_product_id` AND vpm.ordering='1' 
		LEFT JOIN `#__virtuemart_medias` vm ON vm.`virtuemart_media_id` = vpm.`virtuemart_media_id` AND SUBSTR( vm.file_mimetype , 1 ,6 ) = 'image/' AND vm.published='1'   
		LEFT JOIN #__virtuemart_product_prices vpp ON  vpl.virtuemart_product_id = vpp.virtuemart_product_id 
		WHERE vp.`published`='1'  
		AND vpc.`customfield_value`='cooltags'
		GROUP BY vpl.`virtuemart_product_id` 
		
		HAVING (accented_tags  LIKE '%,".$json_encoded.",%' 
			OR accented_tags  LIKE '".$json_encoded.",%' 
			OR accented_tags  LIKE '%,".$json_encoded."' 
			OR accented_tags  LIKE '".$json_encoded."' )
		
		
		ORDER BY vp.`virtuemart_product_id` DESC  ";
		$db->setQuery($q);
		
		$total = @$this->_getListCount($q);
		$products = $this->_getList($q, $limitstart, $limit);
		return array($products, $total, $limit, $limitstart);
	}
}
?>