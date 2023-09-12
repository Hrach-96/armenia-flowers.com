<?php
// No direct access
defined('_JEXEC') or die;

function CooltagsBuildRoute(&$query)
{
	$segments = array();
	if(isset($query['view']))
	{
		if(isset($query['Itemid']) && empty($query['Itemid'])) {	
			$segments[] = $query['Itemid'];
		}
		if($query['view'] == 'productslist' ) {
			$segments[] = $query['view'];
		}
		unset($query['view']);
	}
	if(isset($query['tag']))
	{			
		$segments[] = $query['tag'];	
		unset($query['tag']);
	}
	return $segments;
}

function CooltagsParseRoute($segments)
{
	$vars = array();
	$count = count($segments);
	if ($count)
	{
		if($segments[0] == 'productslist') {
			$vars['view'] = 'productslist';
			$vars['tag'] = $segments[1];
			
			
		}
		
	}
	return $vars;
}