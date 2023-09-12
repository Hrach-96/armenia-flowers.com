<?php 
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );

$document =& JFactory::getDocument();
$document->addStyleSheet("modules/mod_virtuemart_countdown/css/bzTimer.css");
if(!function_exists("_get_time_difference")){
	 function _get_time_difference( $start, $end ){
		$uts['start'] = strtotime( $start );
		$uts['end'] = strtotime( $end );
		if( $uts['start']!==-1 && $uts['end']!==-1 ){
			if( $uts['end'] >= $uts['start'] ){
				$diff = $uts['end'] - $uts['start'];
				if( $days=intval((floor($diff/86400))) )$diff = $diff % 86400;
				if( $hours=intval((floor($diff/3600))) )$diff = $diff % 3600;
				if( $minutes=intval((floor($diff/60))) )$diff = $diff % 60;
				$diff = intval( $diff );
				return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
			}
		}else{
			trigger_error( "Invalid date/time data detected", E_USER_WARNING );
		};
	}
}
$lang = & JFactory::getLanguage();
$lang->load('mod_virtuemart_countdown', JPATH_SITE);

if(!isset($timer_format))$timer_format="days";

if(version_compare(JVERSION,'1.6.0','ge')) {
	 $prodVar = (isset($product)) ? $product : $this->product;
     $product_id = $prodVar->virtuemart_product_id;
     if(!isset($isModule) || $isModule==FALSE){
		$ism = $product_id . uniqid() . "c";;
     }else{
        $ism = $product_id .  uniqid() . "m";;
     }
	$discount_id = $prodVar->product_discount_id;
    if($discount_id){
        $product_in_stock = $prodVar->product_in_stock;
        if(!$product_in_stock)return false;
		
		
        $db = JFactory::getDBO();
        $q = 'SELECT publish_down FROM #__virtuemart_calcs WHERE virtuemart_calc_id ='.$prodVar->product_discount_id.' AND published=1';
        $db->setQuery($q);

        $end_date = $db->loadResult();
		$query = "SELECT product_price_publish_down FROM #__virtuemart_product_prices WHERE virtuemart_product_id = ".$product_id;
		$db->setQuery($query);
		$end_date2 = $db->loadResult();
		if(($end_date2 != "0000-00-00 00:00:00") && !is_null($end_date2)){
			$end_date = $end_date2;
		}
        $end_date = strtotime($end_date);
        $end_date = date("m/d/y H:i:s",$end_date);
        $today1 = date("m/d/Y H:i:s");
        $today = explode("/",$today1);

        $remain =  _get_time_difference($today1, $end_date);
        if(!$remain)return false;
		
		$modulesuffix="";
		
		$component_suffix=uniqid()."C1";
		// sale timer starts 
		include("tmpl/timer.php");
		//sale timer ends
    ?>
    <?php } 
