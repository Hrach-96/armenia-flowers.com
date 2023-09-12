<?php 
$session_compare = isset($_SESSION['ids']) ? $_SESSION['ids'] : array();
?>
<a class="compare-label add_compare <?php if (in_array($product->virtuemart_product_id, $session_compare)) { echo 'go_to_compare active'; }?>" title="<?php echo JText::_('DR_ADD_TO_COMPARE');?>"  onclick="addToCompare('<?php echo $product->virtuemart_product_id; ?>');"><i class="fa fa-balance-scale"></i><span class="action-name"><?php echo JText::_("DR_ADD_TO_COMPARE"); ?></span></a>
