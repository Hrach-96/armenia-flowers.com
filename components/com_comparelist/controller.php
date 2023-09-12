<?php
defined( '_JEXEC' ) or die;
error_reporting(E_ERROR);
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
if (!class_exists( 'VmConfig' )) require(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
VmConfig::loadConfig();

JFactory::getLanguage()->load('com_comparelist');

class ComparelistController extends JControllerLegacy
{
			
	public function add() {
	error_reporting('E_ALL');
	$items = JFactory::getApplication()->getMenu( 'site' )->getItems( 'component', 'com_comparelist' );
	//print_r($items);
	foreach ( $items as $item ) {
		if($item->query['view'] === 'comparelist'){
			//print_r($item->id);
			$itemid= $item->id;
		}
	}
	$product_model = VmModel::getModel('product');
	if (isset($_POST['product_id']));
	if (isset($_SESSION['ids']));
	
	//$_SESSION['ids'][] = $_POST['product_id'];
	$prods_ses = isset($_SESSION['ids']) ? $_SESSION['ids'] : array();
	if ((!in_array($_POST['product_id'], $prods_ses)) && (count($_SESSION['ids'])<= 3) )
		{
			$product = array($_POST['product_id']);
			$prods = $product_model->getProducts($product);
			$product_model->addImages($prods,1);
			//var_dump($product);
				$_SESSION['ids'][] = $_POST['product_id'];
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

				$prod_name = '<div class="extra-wrap"><div class="name">'.JHTML::link($product->link, $product->product_name).'</div><div class="remcompare"><a class="tooltip-1" title="remove"  onclick="removeCompare('.$product->virtuemart_product_id.');">'.JText::_('COM_COMPARE_REMOVE').'</a></div></div>';
				$link = JRoute::_('index.php?option=com_comparelist&Itemid='.$itemid.'');
				$btncompare='<a id="compare_go" class="button" rel="nofollow" href="'.$link.'">'.JText::_('GO_TO_COMPARE').'</a>';
				$btncompareback='<a id="compare_continue" class="continue button reset2" rel="nofollow" href="javascript:;">'.JText::_('CONTINUE_SHOPPING').'</a>';
				$btnrem='<div class="remcompare"><a class="tooltip-1" title="remove"  onclick="removeCompare('.$product->virtuemart_product_id.');"><i class="fa fa-times"></i>'.JText::_('COM_COMPARE_REMOVE').'</a></div>';
				$product_ids = $product->virtuemart_product_id;
				if (!empty($_SESSION['ids'])){
							   $totalcompare = count($_SESSION['ids']); 
							}
			}
			$this->showJSON('<span class="successfully">'.JText::_('COM_COMPARE_MASSEDGE_ADDED_NOTREG').'</span>' ,$title,$img_prod2,$btnrem,$btncompare, $btncompareback, $totalcompare,$recent, $img_prod,  $prod_name, $product_ids);

		} else {
			if (!in_array($_POST['product_id'], $_SESSION['ids'])) {
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
					$link = JRoute::_('index.php?option=com_comparelist&Itemid='.$itemid.'');
					$btncompare='<a id="compare_go" class="button" rel="nofollow" href="'.$link.'">'.JText::_('GO_TO_COMPARE').'</a>';
					$btncompareback='<a id="compare_continue" class="continue button reset2" rel="nofollow" href="javascript:;">'.JText::_('CONTINUE_SHOPPING').'</a>';
					 $btnrem='<div class="remcompare"><a class="tooltip-1" title="remove"  onclick="removeCompare('.$product->virtuemart_product_id.');"><i class="fa fa-times"></i>'.JText::_('COM_COMPARE_REMOVE').'</a></div>';  
					 if (!empty($_SESSION['ids'])){
							   $totalcompare = count($_SESSION['ids']); 
							}
						}
					$this->showJSON('<span class="warning">'.JText::_('COM_COMPARE_MASSEDGE_MORE').'</span>' ,'', '','', $btncompare, $btncompareback,$totalcompare);
				}else {
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
					$link = JRoute::_('index.php?option=com_comparelist&Itemid='.$itemid.'');
					$btncompare='<a id="compare_go" class="button" rel="nofollow" href="'.$link.'">'.JText::_('GO_TO_COMPARE').'</a>';
					$btncompareback='<a id="compare_continue" class="continue button reset2" rel="nofollow" href="javascript:;">'.JText::_('CONTINUE_SHOPPING').'</a>';
					  $btnrem='<div class="remcompare"><a class="tooltip-1" title="remove"  onclick="removeCompare('.$product->virtuemart_product_id.');"><i class="fa fa-times"></i>'.JText::_('COM_COMPARE_REMOVE').'</a></div>'; 
					  		if (!empty($_SESSION['ids'])){
							   $totalcompare = count($_SESSION['ids']); 
							}
						}
					$this->showJSON('<span class="notification">'.JText::_('COM_COMPARE_MASSEDGE_ALLREADY_NOTREG').'</span>' ,$title, $img_prod2,$btnrem, $btncompare, $btncompareback, $totalcompare);
					
				}
		}
		
	}
	public function showJSON($message='', $title='', $img_prod2='', $btnrem='', $btncompare='', $btncompareback='', $totalcompare='', $recent='' , $img_prod='',  $prod_name='', $product_ids=''){
		echo json_encode(array('message'=>$message, 'title'=>$title, 'totalcompare'=>$totalcompare, 'recent'=>$recent, 'img_prod'=>$img_prod, 'img_prod2'=>$img_prod2, 'btnrem'=>$btnrem, 'prod_name'=>$prod_name, 'product_ids'=>$product_ids , 'btncompare'=>$btncompare, 'btncompareback'=>$btncompareback));
		exit;
	}
	
	public function removed() {
		error_reporting('E_ALL');

		if (isset($_SESSION['ids']));
		$product_model = VmModel::getModel('product');
		if (isset($_POST['remove_id'])); 
		//var_dump($_SESSION['ids']);
		if ($_POST['remove_id'] )
			{
				foreach($_SESSION['ids'] as $k => $v) 
				{
					if($_POST['remove_id']==$v){
						unset($_SESSION['ids'][$k]);
						}
			   
				}
				$prod = array($_POST['remove_id']);
				$prods = $product_model->getProducts($prod);
				foreach ($prods as $product) 
				{
					$title =  '<span>'.JHTML::link($product->link, $product->product_name).'</span>'; 
				}
				   $totalrem = count($_SESSION['ids']); 
			}
				$this->removeJSON(''.JText::_('COM_COMPARE_MASSEDGE_REM').' '.$title.' '.JText::_('COM_COMPARE_MASSEDGE_REM2').'', $totalrem,$recentrem);
		}
	
		
		public function removeJSON($rem='', $totalrem='', $recentrem=''){
			echo json_encode(array('rem'=>$rem, 'totalrem'=>$totalrem, 'recentrem'=>$recentrem));
			exit;
		}
}