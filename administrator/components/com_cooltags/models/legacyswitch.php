<?php
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

class CooltagsModelLegacyswitch extends JModelList {
	static function countToboconverted()
	{
		header("Content-Type: text/html; charset=utf-8");
		$db = JFactory::getDBO();
		mysql_query("SET NAMES utf8");
		$q ="SELECT COUNT( DISTINCT(virtuemart_product_id 	) ) 
		FROM #__virtuemart_product_customfields 
		WHERE customfield_value='cooltags' AND SUBSTRING(customfield_params,16)='{\"product_tags\":\"'
		GROUP BYvirtuemart_product_id ";
		$db->setQuery($q);
		$count = $db->loadResult();
		return $count;	
	}

}
