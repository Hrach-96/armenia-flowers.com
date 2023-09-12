<?php
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class CooltagsControllerLegacyswitch extends JControllerLegacy
{	
	function convertTags()
	{	
		header("Content-Type: text/html; charset=utf-8");
		$db = JFactory::getDBO();
		mysql_query("SET NAMES utf8");
		$q = "SELECT  virtuemart_product_id, customfield_params 
		FROM #__virtuemart_product_customfields 
		WHERE customfield_value='cooltags'
		AND SUBSTRING(customfield_params,16)='{\"product_tags\":\"'  ";	
		$db->setQuery($q);
		$products = $db->loadObjectList();
		foreach($products as $product)
		{
			//var_dump($product);
			$tags = str_replace('{"product_tags":"','',$product->customfield_params );
			$tags = str_replace('"}','',$tags );
			
			$customfield_params = 'product_tags="'.$tags.'"|';
			
			$q = "UPDATE  #__virtuemart_product_customfields 
			SET customfield_params='".$customfield_params."' 
			WHERE virtuemart_product_id='".$product->virtuemart_product_id."' 7
			AND customfield_value='cooltags' ";
			$db->setQuery($q);
			if (!$db->query()) die($db->stderr(true));	
		}
	}
}