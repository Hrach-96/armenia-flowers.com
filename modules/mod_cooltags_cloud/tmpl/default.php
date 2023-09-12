<?php
/**
 * @version		$Id: default.php 
 * @package		Joomla.Site
 * @subpackage	mod_cooltags_cloud
 * @copyright	Copyright (C) 2005 - 2012 Nordmograph.com, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$min_font_size 	= $params->get( 'min_font', '10');
$max_font_size 	= $params->get( 'max_font', '25');
$limit 			= $params->get( 'limit', '50');

$cparams 					= JComponentHelper::getParams('com_cooltags');
$mode	 					= $cparams->get('mode','1');
 $items = JFactory::getApplication()->getMenu( 'site' )->getItems( 'component', 'com_cooltags' );
	//print_r($items);
    foreach ( $items as $item ) {
        if($item->query['view'] === 'productslist'){
			//print_r($item->id);
            $itemid= $item->id;
			
        }
    }

$minimum_count = 0;
$maximum_count = 0;
$array = array();
$thelist ='';
if(count($list)>0)
{
	foreach($list as $set_tag)
	{
		$sep_tags = str_replace('product_tags="','',$set_tag->customfield_params);
		$sep_tags = str_replace('"|','',$sep_tags);
		$thelist .= $sep_tags.',';
	}
	$thelist = strtolower($thelist);
	//$thelist = str_replace(' ','',$thelist);
	$thelist = substr($thelist,0,-1);
	$expls = explode(",", $thelist);
	$x = array_count_values($expls);

	foreach ($expls as $expl) //loop through the object and find the highest and lowest values
	{
		if(isset($x[$expl])){
			if ($minimum_count > $x[$expl]) 
				$minimum_count = $x[$expl];
			if ($maximum_count < $x[$expl])
				$maximum_count = $x[$expl];	
		}
	}
	$spread = $maximum_count - $minimum_count; //figure out the difference between the highest and lowest values
	if($spread == 0) 
		$spread = 1;
	$i=0;

	echo '<div class="mod_tagsvm3" >';
	while (list($key, $value) = each($x))
	{
		$i++;
		$size = $min_font_size + ( $value - $minimum_count) * ($max_font_size - $min_font_size) / $spread;
		if ($value>0 && $i <= $limit && $key!=''){
			if($mode==1)
				$tag_url = JRoute::_('index.php?option=com_cooltags&view=productslist&tag='.$key.'&Itemid='.$itemid);
			else
				$tag_url = JRoute::_('index.php?searchword='.$key.'&ordering=newest&searchphrase=exact&option=com_search&Itemid='.$itemid  );
			echo ' <a class="vm_tag" href="'.$tag_url.'"><span style="font-size:'. floor($size) .'px" title="'.$value.'">'.$key.'</span></a>';
		}
	}
	echo '</div>';
}
?>