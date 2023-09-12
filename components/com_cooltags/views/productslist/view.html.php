<?php
/*
 * @component Cooltags
 * @copyright Copyright (C) 2008-2012 Adrien Roussel
 * @license : GNU/GPL
 * @Website : http://www.nordmograph.com
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');
 jimport( 'joomla.html.pagination' );
 
class CooltagsViewProductslist extends JViewLegacy
{
	function display($tpl = null)
	{

		$this->productsarray		= $this->get('products');
		$this->products	= $this->productsarray[0];
		$this->total	= $this->productsarray[1];
 		$this->limit	= $this->productsarray[2];
		$this->limitstart	= $this->productsarray[3];
		
		$this->price_format			= $this->get('priceformat');
		
		$pagination = new JPagination( $this->total, $this->limitstart, $this->limit );		
		$this->assignRef('pagination', $pagination );
		
		
		parent::display($tpl);
	}
	
	function get_string_between($string, $start, $end){
		$string = " ".$string;
		$ini = strpos($string,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);
	}
}