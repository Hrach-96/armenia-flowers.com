<?php defined('_JEXEC') or die('Restricted access'); error_reporting('E_ALL'); 
JFactory::getLanguage()->load('com_wishlists');
    $items = JFactory::getApplication()->getMenu( 'site' )->getItems( 'component', 'com_wishlists' );
	//print_r($items);
    foreach ( $items as $item ) {
        if($item->query['view'] === 'wishlists'){
			//print_r($item->id);
            $itemid= $item->id;
        }
    }
?>
<div class="mod-wishlist">
    <div id="cur-lang" class="header-button-wishlist">
           <div id="wishlist_total"><a class="wishlist_total heading" href="<?php echo JRoute::_('index.php?option=com_wishlists&Itemid='.$itemid.''); ?>">
            <i class="fa fa-heart-o"></i>
            <span>
		   <?php
		   if ($user->guest) {
		   		echo count($_SESSION['id']);
		   }else {
				echo count($allprod['id']);
			}
		   ?></span><b>&nbsp;<?php echo JText::_('ITEMS');?></b></a></div>
    </div>
 </div>