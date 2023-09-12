<?php 
//require(JPATH_BASE.DS.'plugins'.DS.'system'.DS.'wishlists'.DS.'wishlists.php');
//var_dump ($results[0]);
$user =& JFactory::getUser();
	if ($user->guest) { ?>
<?php 
$session_whishlist = isset($_SESSION['id']) ? $_SESSION['id'] : array();
?>    
<a class="add_wishlist  <?php if (in_array($this->product2->virtuemart_product_id, $_SESSION['id'])) { echo 'go_to_whishlist active'; }?>" title="<?php echo JText::_('ADD_TO_WHISHLIST');?>"  onclick="addToWishlists('<?php echo $this->product2->virtuemart_product_id; ?>');"><i class="fa fa-heart-o"></i><span class="action-name"><?php echo JText::_("ADD_TO_WHISHLIST"); ?></span></a>
<?php }else {
	JPluginHelper::importPlugin('System');
	$dispatcher =& JDispatcher::getInstance();
	$results = $dispatcher->trigger( 'onBeforeRender');

	if($results[0] == 'true'){
$db =& JFactory::getDBO();
   $q ="SELECT virtuemart_product_id FROM #__wishlists WHERE userid =".$user->id." AND virtuemart_product_id=".$this->product2->virtuemart_product_id;
	$db->setQuery($q);
	$allproducts = $db->loadAssocList();
	foreach($allproducts as $productbd){
		$allprod['id'][] = $productbd['virtuemart_product_id'];
	}
	//var_dump($allproducts);
	}
	$session_whishlistBD = isset($allprod['id']) ? $allprod['id'] : array();
?>
<a class="add_wishlist <?php if (in_array($this->product2->virtuemart_product_id, $allprod['id'])) { echo 'go_to_whishlist active'; }?>" title="<?php echo JText::_('ADD_TO_WHISHLIST');?>"  onclick="addToWishlists('<?php echo $this->product2->virtuemart_product_id; ?>');"><i class="fa fa-heart-o"></i><span class="action-name"><?php echo JText::_("ADD_TO_WHISHLIST"); ?></span></a>

<?php

} ?> 


