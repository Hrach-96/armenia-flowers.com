<?php
/**
 * @version		One page checkout for Virtuemart - plugins gallery
 * @copyright	Copyright (C) 2005 - 2011 RuposTel.com
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');


class plgSystemOpctrackingsystem extends JPlugin
{
   static $_storedOrder; 
    public function onAfterInitialise()
	{
		if (!self::_check())  return; 
		
		OPCtrackingHelper::$html = ''; 
		OPCtrackingHelper::$js = ''; 
		OPCtrackingHelper::$html_array = array(); 
		
		
		
	}
	
	
	public function plgVmConfirmedOrder($cart, $order)
	{
	 $this->plgVmConfirmedOrder2($cart, $order); 
	}
	
	public function plgVmConfirmedOrder2($cart, $data)
	{
		

		
	  if (!self::_check()) 
	  {
		  return; 
	  }
	 	
		
	  if (class_exists('plgVmPaymentOpctracking'))
	  if (!empty(plgVmPaymentOpctracking::$_storedOrder)) 
		  self::$_storedOrder = plgVmPaymentOpctracking::$_storedOrder; 
  
  
  
	  if (empty(self::$_storedOrder)) self::$_storedOrder = $data; 
	  
	  
	  
	  if (defined('OPCTRACKINGORDERCREATED')) return; 
	  
	  
	  
	  self::_tyPageMod($data, false);  
	  
	  
	  define('OPCTRACKINGORDERCREATED', 1); 
	 
	  
	  
	  if (!is_object($data))
	  {
	  if (isset($data['details']['BT']))
	  {
	   //self::$delay = true; 
	   $order = $data['details']['BT']; 
	   
	   self::orderCreated($order, 'P');  
	  }
	  }
	  else
	  if (isset($data->virtuemart_order_id))
	  {
		
		   if (isset($data->order_status)) $status = $data->order_status; 
	       else $status = 'P'; 
		  
	       
		   if (class_exists('plgSystemOpctrackingsystem'))
	       if (method_exists('plgSystemOpctrackingsystem', 'orderCreated'))
	       plgSystemOpctrackingsystem::orderCreated($data, $status);  
		   
		  
		  
		  
	  }
	}
	
	
	public static function orderCreated(&$data, $old_order_status)
	{
	  
	 
	  
	  $hash2 = uniqid('opc', true); 
	  if (method_exists('JApplication', 'getHash'))
	  $hashn = JApplication::getHash('opctracking'); 
	  else $hashn = JUtility::getHash('opctracking'); 
	  $hash = JRequest::getVar($hashn, $hash2, 'COOKIE'); 
      if ($hash2 == $hash) 
	  OPCtrackingHelper::setCookie($hash); 
	  
	    
		OPCtrackingHelper::orderCreated($hash, $data, $old_order_status); 
	
		//OPC add-on: if any other plugin updates user data, they should get refreshed: 
			// refresh user data: 
				$user = JFactory::getUser(); 
				$id = $user->id; 
				$user = new JUser($id); 
				$session = JFactory::getSession(); 
				$session->set('user', $user); 
				// end of refresh
			
		 self::_tyPageMod($data, false);  
	}
	
	public $todo = array(); 
    public function onAfterRoute() {
		
		$app = JFactory::getApplication();
		
		if ((!$app->isAdmin()) && (class_exists('OPCtrackingHelper') && (method_exists('OPCtrackingHelper', 'loadAsFirstPageEventAlways'))))
	    {
			
		OPCtrackingHelper::loadAsFirstPageEventAlways(); 
		}
		

		
	     if (!self::_check())  return; 
		 JHTMLOPC::script('opcping.js', 'components/com_onepage/assets/js/', false);
	
		if (empty($this->todo))
		$this->todo = array(); 
	
		//check product view: 
		$option = JRequest::getVar('option', ''); 
		$view = JRequest::getVar('view'); 
		$virtuemart_product_id = JRequest::getVar('virtuemart_product_id', 0); 
		$virtuemart_category_id = JRequest::getVar('virtuemart_category_id', 0); 
		
		$virtuemart_product_id = (int)$virtuemart_product_id; 
		$virtuemart_category_id = (int)$virtuemart_category_id; 
		
		if ($option === 'com_virtuemart')
		{
		if ($view === 'productdetails')
		{
		if (!empty($virtuemart_product_id))
		 {
		    // in case a broken cross version matrix: 
			/*
		    if (method_exists('OPCtrackingHelper', 'productViewEvent'))
		    OPCtrackingHelper::productViewEvent($virtuemart_product_id); 
			*/
			
			if (empty($this->todo['productViewEvent'])) $this->todo['productViewEvent'] = array(); 
			$this->todo['productViewEvent'][$virtuemart_product_id] = $virtuemart_product_id; 
		
		
		 }
		}
		else
		if ($view === 'cart')
		 {
			  /*
			 if (method_exists('OPCtrackingHelper', 'cartViewEvent'))
		     OPCtrackingHelper::cartViewEvent(); 
		     */
			 
		 	 if (empty($this->todo['cartViewEvent'])) $this->todo['cartViewEvent'] = array(); 
			 $this->todo['cartViewEvent'][1] = 1; 

		 
		 }
		else
			if ($view == 'category')
			{
				if (empty($this->todo['categoryViewEvent'])) $this->todo['categoryViewEvent'] = array(); 
			    $this->todo['categoryViewEvent'][1] = 1; 
			}
		}
		
		
		 
		 
		
	
	
	}
/**
	 * Converting the site URL to fit to the HTTP request
	 */
	public function onAfterRender()
	{

		//opc tracking start
		 //if (!empty(self::$delay)) return; 
	   
	   if (!$this->_check()) return; 

	   if (!empty($this->todo))
	   {
		    foreach ($this->todo as $k=>$v)
			{
				  if ($k === 'productViewEvent')
				  {
					   foreach ($v as $n)
					   {
						    if (method_exists('OPCtrackingHelper', 'productViewEvent'))
							OPCtrackingHelper::productViewEvent($n); 
					   }
				  }
				  else
					  if ($k === 'cartViewEvent')
					  {
						  if (method_exists('OPCtrackingHelper', 'cartViewEvent'))
						  OPCtrackingHelper::cartViewEvent(); 
					  }
					  else
						  if ($k === 'categoryViewEvent')
						  {
							  if (method_exists('OPCtrackingHelper', 'categoryViewEvent'))
							  OPCtrackingHelper::categoryViewEvent(); 
						  }
			}
	   }
	   
	   
	   
	   $this->_opcTrackingCheck(); 
	   
	   if (method_exists('OPCtrackingHelper', 'loadAsLastPageEvent'))
	   OPCtrackingHelper::loadAsLastPageEvent(); 
	   
	   
	   $this->_updateHtml(); 
	  
	}
	// this function is triggered from ajax content to update abandoned cart measurement and cart data
	public static function updateAbaData()
	{
	 
	   require_once(JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_onepage'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'aba.php'); 
	   OPCAba::update(); 
	}
	// this function pairs user with an order for abandoned cart measurement
	public static function registerOrderAttempt(&$order)
	{
	   if (!self::_check()) return; 
	   require_once(JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_onepage'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'aba.php'); 
	   OPCAba::orderMade($order); 
	}
	
	public static function registerCart()
	{
	   
	   if (!self::_check()) return; 
	   if (!class_exists('OPCtrackingHelper')) return;
	   $hash2 = uniqid('opc', true); 
	   $hashn = JApplication::getHash('opctracking'); 
	   $hash = JRequest::getVar($hashn, $hash2, 'COOKIE'); 
	   if ($hash2 == $hash)
	   {
	   // create new cookie if not set
	   OPCtrackingHelper::setCookie($hash); 
	   }
	   
	   OPCtrackingHelper::registerCart($hash); 
	}
	
		// this function is triggered on OPC cart display
	public static function registerCartEnter()
	{
	
	   if (!self::_check()) return; 
	   require_once(JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_onepage'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'aba.php'); 
	   OPCAba::cartEnter(); 
	}

	
   private function _opcTrackingCheck()
	{
	   if (self::_check()) 
	   {
	   
	   
	   
	   if (!empty(self::$_storedOrder))
	   {
	     self::_tyPageMod(self::$_storedOrder, true); 
	   }
	   
	   
	   
	   require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_onepage'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'opctracking.php'); 
	   
	   //if (!class_exists('OPCtracking')) return; 
	   
	   
	   if (class_exists('OPCtrackingHelper'))
	   {
	   
	   
	   
	   if (!OPCtrackingHelper::checkStatus()) return; 
	 

	 
	  
	 
	   }
	   }	
	}
	
	private function _updateHtml()
	{
		
		
		
		 if (class_exists('OPCtrackingHelper'))
		 {
		  $html = OPCtrackingHelper::$html; //OPCtrackingHelper::getHTML(); 
		  $buffer = JResponse::getBody();
		  $changed = false; 
	      if (!empty($html)) 
	      {
	      
	      //$bodyp = stripos($buffer, '</body'); 
		  
		  $body1 = stripos($buffer, '<body'); 
		  if ($body1 !== false)
		  {
			  $body2 = stripos($buffer, '>', $body1); 
			  if ($body2 !== false)
			  {
				  $changed = true; 
				   $buffer = substr($buffer, 0, $body2+1).$html.substr($buffer, $body2+1); 
				   
				   
			  }
		  }
		  }
		  
		  $js = OPCtrackingHelper::$js; //OPCtrackingHelper::getHTML(); 
		  
		  
	      if (!empty($js))
	      {
			  
	      
	      $bodyp = stripos($buffer, '</head'); 
		  if ($bodyp !== false)
		  {
			  $changed = true; 
			     $buffer = substr($buffer, 0, $bodyp).$js.substr($buffer, $bodyp); 
		  }
		  

		  }
		  
	      //$buffer = substr($buffer, 0, $bodyp).$html.substr($buffer, $bodyp); 
	   
	      if ($changed)
	      JResponse::setBody($buffer);
		 }
	}
	
   private static function _check($allowAdmin=false)
	{
		if (class_exists('plgVmPaymentOpctracking'))
	    if (!empty(plgVmPaymentOpctracking::$_storedOrder)) 
		self::$_storedOrder = plgVmPaymentOpctracking::$_storedOrder; 
		
		$debug = false; 
		
	    if (defined('OPC_GENERAL_CHECK')) 
		{
			return OPC_GENERAL_CHECK; 
		}
	
		if (!$allowAdmin)
		{
	  	$app = JFactory::getApplication();
		if ($app->getName() != 'site') {
			if ($debug) die('site'); 
			define('OPC_GENERAL_CHECK', false); 
			return false;
		}
		}
		
		
		$format = JRequest::getVar('format', 'html'); 
		if ($format != 'html') 
		{	
		if ($debug) die('format'); 
		return false;
		}
		$doc = JFactory::getDocument(); 
		$class = strtoupper(get_class($doc)); 
		
		$arr = array('JDOCUMENTHTML', 'JDOCUMENTOPCHTML'); 
		if (!in_array($class, $arr)) 
		{
			if ($debug) die('doc'); 
		define('OPC_GENERAL_CHECK', false); 
		return false; 
		}
		
		//virtuemart not installed: 
	    if (!file_exists(JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_virtuemart'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'config.php')) 
		{
			if ($debug) die('VM'); 
		define('OPC_GENERAL_CHECK', false); 
		return false;
		}
		
		// opc component not available
		if (!file_exists(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_onepage'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'plugin.php')) 
		{
			if ($debug) die('opc PLUGIN'); 
		define('OPC_GENERAL_CHECK', false); 
		return false;
		}
		
		JLoader::register('OPCplugin', JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_onepage'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'plugin.php' );
	    //require_once(JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_onepage'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'plugin.php'); 
		
		//load opc compatibility files
		require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_onepage'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'compatibility.php'); 
		
		JLoader::register('OPCconfig', JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_onepage'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'config.php' );
		
		JLoader::register('OPCtrackingHelper', JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_onepage'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'opctracking.php' );
		
		/*
		if (!file_exists(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_onepage'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'opctracking.php')) 
		{
		define('OPC_GENERAL_CHECK', false); 
		return false;
		}
		
		
		require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_onepage'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'opctracking.php'); 
		*/
		
		
		
		define('OPC_GENERAL_CHECK', true); 
		return true; 

	}
	
		//$returnValues = $dispatcher->trigger('plgVmOnCheckoutAdvertise', array( $this->cart, &$checkoutAdvertise));
	static function _tyPageMod(&$data, $afterrender=false, $html='')
	{
		
		if (empty(self::$_storedOrder)) self::$_storedOrder = $data; 
		if (empty($html))
		$html = JRequest::getVar('html', '', 'default', 'STRING', JREQUEST_ALLOWRAW);
		
		
		
		if (!empty($html))
		{
		
		   if (file_exists(JPATH_SITE. DIRECTORY_SEPARATOR .'components'. DIRECTORY_SEPARATOR .'com_onepage'. DIRECTORY_SEPARATOR .'helpers'. DIRECTORY_SEPARATOR .'thankyou.php')) 
		    {
			  require_once(JPATH_SITE. DIRECTORY_SEPARATOR .'components'. DIRECTORY_SEPARATOR .'com_onepage'. DIRECTORY_SEPARATOR .'helpers'. DIRECTORY_SEPARATOR .'thankyou.php'); 
			  return OPCThankYou::updateHtml($html, $data, $afterrender); 
			}
		}
		
				$user = JFactory::getUser(); 
				$id = $user->id; 
				$user = new JUser($id); 
				$session = JFactory::getSession(); 
				$session->set('user', $user); 

		
		return ''; 
	}
	
	
	
	
}