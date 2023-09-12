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
<div class="vmgroup<?php echo $params->get('moduleclass_sfx') ?>" id="mod_wishlists">

    <div class="not_text wishlists"><?php echo JText::_('YOU_HAVE_NO_PRODUCT_TO_WISHLISTS');?></div>
<div class="vmproduct">
		<?php
		foreach ($prods as $product) {
			?>
			<div id="wishlists_prod_<?php echo $product->virtuemart_product_id; ?>" class="modwishlistsprod clearfix">
                    <div class="image fleft">
                    <a href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id); ?>">
                    <img src="<?php if ($product->images[0]->published){ echo JURI::base().$product->images[0]->getFileUrlThumb();}else {echo JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');} ?>" alt="<?php echo $product->product_name; ?>" title="<?php echo $product->product_name; ?>" /></a>
                    </div>
                    <div class="extra-wrap">
                        <div class="name">
                              <?php echo JHTML::link($product->link, $product->product_name); ?> 
                        </div>
                        <div class="remwishlists"><a class="tooltip-1" title="remove"  onclick="removeWishlists('<?php echo $product->virtuemart_product_id ;?>');"><?php echo JText::_('COM_WHISHLISTS_REMOVE') ?></a></div>
                    </div>
			</div>
            <div class="clear"></div>
	<?php }
?>
	</div>
  <div class="clear"></div>
  <div class="seldcomp" id="butseldwish" > <a class="btn_wishlist button" href="<?php echo JRoute::_('index.php?option=com_wishlists&Itemid='.$itemid.''); ?>"><?php echo JText::_('COM_WISHLISTS_GO'); ?></a></div>
</div>
