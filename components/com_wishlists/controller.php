<?php
defined( '_JEXEC' ) or die;
error_reporting(E_ERROR);
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
if (!class_exists( 'VmConfig' )) require(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
VmConfig::loadConfig();

JFactory::getLanguage()->load('com_wishlists');
class WishlistsController extends JControllerLegacy
{
			
	public function add() {
	//error_reporting('E_ALL');
	$items = JFactory::getApplication()->getMenu( 'site' )->getItems( 'component', 'com_wishlists' );
	//print_r($items);
	foreach ( $items as $item ) {
		if($item->query['view'] === 'wishlists'){
			//print_r($item->id);
			$itemid= $item->id;
		}
	}
	$product_model = VmModel::getModel('product');
	if (isset($_POST['product_id']));
	if (isset($_SESSION['id']));
	$sessionW = isset($_SESSION['id']) ? $_SESSION['id'] : array();
	$user =& JFactory::getUser();
	if ($user->guest) {
		if ((!in_array($_POST['product_id'], $sessionW)) )
		{
			$product = array($_POST['product_id']);
			$prods = $product_model->getProducts($product);
			$product_model->addImages($prods,1);
			//var_dump($prods);
			$_SESSION['id'][] = $_POST['product_id'];
			foreach ($prods as $product) 
			{
				//var_dump($product);
				$title =  '<div class="title">'.JHTML::link($product->link, $product->product_name).'</div>'; 
				$prod_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id);
				if ($product->images[0]->published){
					$img_url = $product->images[0]->getFileUrlThumb();
				} else {
					$img_url = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
					}
				$prod_id = $product->virtuemart_product_id;
				$img_prod =  '<div class="image fleft"><a href="'.$prod_url.'"><img src="'.JURI::base().$img_url.'" alt="'.$product->product_name.'" title="'.$product->product_name.'" /></a></div>';
				$img_prod2 =  '<div class="image fleft"><a href="'.$prod_url.'"><img src="'.JURI::base().$img_url.'" alt="'.$product->product_name.'" title="'.$product->product_name.'" /></a></div>';

				$prod_name = '<div class="extra-wrap"><div class="name">'.JHTML::link($product->link, $product->product_name).'</div><div class="remwishlists"><a class="tooltip-1" title="remove"  onclick="removeWishlists('.$product->virtuemart_product_id.');">'.JText::_('COM_WHISHLISTS_REMOVE').'</a></div></div>';
				$link = JRoute::_('index.php?option=com_wishlists&Itemid='.$itemid.'');
				$btnwishlists='<a id="wishlists_go" class="button" rel="nofollow" href="'.$link.'">'.JText::_('GO_TO_WISHLISTS').'</a>';
				$btnwishlistsback='<a id="wishlists_continue" class="continue button reset2" rel="nofollow" href="javascript:;">'.JText::_('CONTINUE_SHOPPING').'</a>';
				$btnrem='<div class="remwishlists"><a class="tooltip-1" title="remove"  onclick="removeWishlists('.$product->virtuemart_product_id.');"><i class="fa fa-times"></i>'.JText::_('COM_WHISHLISTS_REMOVE').'</a></div>';
				$product_ids = $product->virtuemart_product_id;
			   $totalwishlists = count($_SESSION['id']); 
			}
			$this->showJSON('<span class="successfully">'.JText::_('COM_WHISHLISTS_MASSEDGE_ADDED_NOTREG').'</span>' ,$title,$img_prod2,$btnrem,$btnwishlists, $btnwishlistsback, $totalwishlists,$recent, $img_prod,  $prod_name, $product_ids);

		} else {
			if (in_array($_POST['product_id'], $_SESSION['id'])) {
					$product = array($_POST['product_id']);
					$prods = $product_model->getProducts($product);
					$product_model->addImages($prods,1);
					//var_dump($prods);
					foreach ($prods as $product) 
					{
					//var_dump($product);
					$title =  '<div class="title">'.JHTML::link($product->link, $product->product_name).'</div>'; 
					$prod_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id);
					if ($product->images[0]->published){
						$img_url = $product->images[0]->getFileUrlThumb();
					} else {
						$img_url = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
					}
					$img_prod2 =  '<div class="image fleft"><a href="'.$prod_url.'"><img src="'.JURI::base().$img_url.'" alt="'.$product->product_name.'" title="'.$product->product_name.'" /></a></div>';
					$link = JRoute::_('index.php?option=com_wishlists&Itemid='.$itemid.'');
					$btnwishlists='<a id="wishlists_go" class="button" rel="nofollow" href="'.$link.'">'.JText::_('GO_TO_WISHLISTS').'</a>';
					$btnwishlistsback='<a id="wishlists_continue" class="continue button reset2" rel="nofollow" href="javascript:;">'.JText::_('CONTINUE_SHOPPING').'</a>';
					  $btnrem='<div class="remwishlists"><a class="tooltip-1" title="remove"  onclick="removeWishlists('.$product->virtuemart_product_id.');"><i class="fa fa-times"></i>'.JText::_('COM_WHISHLISTS_REMOVE').'</a></div>'; 
						}
					$this->showJSON('<span class="notification">'.JText::_('COM_WHISHLISTS_MASSEDGE_ALLREADY_NOTREG').'</span>' ,$title, $img_prod2,$btnrem, $btnwishlists, $btnwishlistsback);
					
				}
			}
		
		}else {
			   
			$db =& JFactory::getDBO();
		    $q ="SELECT virtuemart_product_id FROM #__wishlists WHERE userid =".$user->id;
			$db->setQuery($q);
			$allproducts = $db->loadAssocList();
			foreach($allproducts as $productbd){
				$allprod['ids'][] = $productbd['virtuemart_product_id'];
			}
			$sessionWD = isset($allprod['ids']) ? $allprod['ids'] : array();
				//var_dump ($allproducts);
			if ((!in_array($_POST['product_id'], $sessionWD)))
			{
			$q = "";
			$q = "INSERT INTO `#__wishlists`
					(virtuemart_product_id,userid )
					VALUES
					('".$_POST['product_id']."','".$user->id."') ";
			
			$db->setQuery($q);
			//$db->queryBatch();
			$db->query();
			//var_dump ($db);
			$sessionWDB = isset($allprod['id']) ? $allprod['id'] : array();
			if ((!in_array($_POST['product_id'], $sessionWDB)))
			{
			$db =& JFactory::getDBO();
			   $q ="SELECT virtuemart_product_id FROM #__wishlists WHERE userid =".$user->id;
				$db->setQuery($q);
				$allproducts = $db->loadAssocList();
				foreach($allproducts as $productbd){
					$allprod['id'][] = $productbd['virtuemart_product_id'];
				}
				//var_dump ($allproducts);
			//var_dump (count($allprod['id']));
			$product = array($_POST['product_id']);
			$prods = $product_model->getProducts($product);
			$product_model->addImages($prods,1);
			//var_dump($prods);
			foreach ($prods as $product) 
			{
				//var_dump($product);
				$title =  '<div class="title">'.JHTML::link($product->link, $product->product_name).'</div>'; 
				$prod_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id);
				if ($product->images[0]->published){
					$img_url = $product->images[0]->getFileUrlThumb();
				} else {
					$img_url = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
					}
				$prod_id = $product->virtuemart_product_id;
				$img_prod =  '<div class="image fleft"><a href="'.$prod_url.'"><img src="'.JURI::base().$img_url.'" alt="'.$product->product_name.'" title="'.$product->product_name.'" /></a></div>';
				$img_prod2 =  '<div class="image fleft"><a href="'.$prod_url.'"><img src="'.JURI::base().$img_url.'" alt="'.$product->product_name.'" title="'.$product->product_name.'" /></a></div>';

				$prod_name = '<div class="extra-wrap"><div class="name">'.JHTML::link($product->link, $product->product_name).'</div><div class="remwishlists"><a class="tooltip-1" title="remove"  onclick="removeWishlists('.$product->virtuemart_product_id.');">'.JText::_('COM_WHISHLISTS_REMOVE').'</a></div></div>';
				$link = JRoute::_('index.php?option=com_wishlists&Itemid='.$itemid.'');
				$btnwishlists='<a id="wishlists_go" class="button" rel="nofollow" href="'.$link.'">'.JText::_('GO_TO_WISHLISTS').'</a>';
				$btnwishlistsback='<a id="wishlists_continue" class="continue button reset2" rel="nofollow" href="javascript:;">'.JText::_('CONTINUE_SHOPPING').'</a>';
				$btnrem='<div class="remwishlists"><a class="tooltip-1" title="remove"  onclick="removeWishlists('.$product->virtuemart_product_id.');"><i class="fa fa-times"></i>'.JText::_('COM_WHISHLISTS_REMOVE').'</a></div>';
				$product_ids = $product->virtuemart_product_id;
				  $totalwishlists = count($allprod['id']); 
				
			}
						$this->showJSON('<span class="successfully">'.JText::_('COM_WHISHLISTS_MASSEDGE_ADDED_REG').'</span>' ,$title,$img_prod2,$btnrem,$btnwishlists, $btnwishlistsback, $totalwishlists,$recent, $img_prod,  $prod_name, $product_ids);

		}

			
		} else {
			$product = array($_POST['product_id']);
					$prods = $product_model->getProducts($product);
					$product_model->addImages($prods,1);
					//var_dump($prods);
					foreach ($prods as $product) 
					{
					//var_dump($product);
					$title =  '<div class="title">'.JHTML::link($product->link, $product->product_name).'</div>'; 
					$prod_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id);
					if ($product->images[0]->published){
					$img_url = $product->images[0]->getFileUrlThumb();
				} else {
					$img_url = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
					}
					$img_prod2 =  '<div class="image fleft"><a href="'.$prod_url.'"><img src="'.JURI::base().$img_url.'" alt="'.$product->product_name.'" title="'.$product->product_name.'" /></a></div>';
					$link = JRoute::_('index.php?option=com_wishlists&Itemid='.$itemid.'');
					$btnwishlists='<a id="wishlists_go" class="button" rel="nofollow" href="'.$link.'">'.JText::_('GO_TO_WISHLISTS').'</a>';
					$btnwishlistsback='<a id="wishlists_continue" class="continue button reset2" rel="nofollow" href="javascript:;">'.JText::_('CONTINUE_SHOPPING').'</a>';
					  $btnrem='<div class="remwishlists"><a class="tooltip-1" title="remove"  onclick="removeWishlists('.$product->virtuemart_product_id.');"><i class="fa fa-times"></i>'.JText::_('COM_WHISHLISTS_REMOVE').'</a></div>'; 
						}
					$this->showJSON('<span class="notification">'.JText::_('COM_WHISHLISTS_MASSEDGE_ALLREADY_REG').'</span>' ,$title, $img_prod2,$btnrem, $btnwishlists, $btnwishlistsback);
			
			}
	}
	}
	public function showJSON($message='', $title='', $img_prod2='', $btnrem='', $btnwishlists='', $btnwishlistsback='', $totalwishlists='', $recent='' , $img_prod='',  $prod_name='', $product_ids=''){
		echo json_encode(array('message'=>$message, 'title'=>$title, 'totalwishlists'=>$totalwishlists, 'recent'=>$recent, 'img_prod'=>$img_prod, 'img_prod2'=>$img_prod2, 'btnrem'=>$btnrem, 'prod_name'=>$prod_name, 'product_ids'=>$product_ids , 'btnwishlists'=>$btnwishlists, 'btnwishlistsback'=>$btnwishlistsback));
		exit;
	}
	
	public function removed() {
		error_reporting('E_ALL');

		if (isset($_SESSION['id']));
		$product_model = VmModel::getModel('product');
		if (isset($_POST['remove_id'])); 
		//var_dump($_SESSION['ids']);
	$user =& JFactory::getUser();
	if ($user->guest) {

		if ($_POST['remove_id'] )
			{
				foreach($_SESSION['id'] as $k => $v) 
				{
					if($_POST['remove_id']==$v){
						unset($_SESSION['id'][$k]);
						}
			   
				}
				$prod = array($_POST['remove_id']);
				$prods = $product_model->getProducts($prod);
				foreach ($prods as $product) 
				{
					$title =  '<span>'.JHTML::link($product->link, $product->product_name).'</span>'; 
				}
				   $totalrem = count($_SESSION['id']); 
			}
				$this->removeJSON(''.JText::_('COM_WHISHLISTS_MASSEDGE_REM').' '.$title.' '.JText::_('COM_WHISHLISTS_MASSEDGE_REM2').'', $totalrem);
			
	} else {
			$db =& JFactory::getDBO();
			   $q = "DELETE  FROM `#__wishlists` WHERE virtuemart_product_id=".$_POST['remove_id']." AND  userid =".$user->id;
			   $db->setQuery($q);
			   $db->query();
			  $q ="SELECT virtuemart_product_id FROM #__wishlists WHERE userid =".$user->id;
				$db->setQuery($q);
				$allproducts = $db->loadAssocList();
				foreach($allproducts as $productbd){
					$allprod['ids'][] = $productbd['virtuemart_product_id'];
				}
			//var_dump($allprod['ids']);
				$prod = array($_POST['remove_id']);
				$prods = $product_model->getProducts($prod);
				foreach ($prods as $product) 
				{
					$title =  '<span>'.JHTML::link($product->link, $product->product_name).'</span>'; 
				}
			 $totalrem = count($allprod['ids']); 
			
			$this->removeJSON(''.JText::_('COM_WHISHLISTS_MASSEDGE_REM').' '.$title.' '.JText::_('COM_WHISHLISTS_MASSEDGE_REM2').'', $totalrem);
		}
}
		public function removeJSON($rem='', $totalrem=''){
			echo json_encode(array('rem'=>$rem, 'totalrem'=>$totalrem));
			exit;
		}
}