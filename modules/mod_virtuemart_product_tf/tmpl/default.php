<?php // no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.modal');
$col= 1 ;
$app = JFactory::getApplication();
$templateparams = $app->getTemplate(true)->params;
$politeloading = $templateparams->get('politeloading');
//print_r($params->get( 'moduleclass_sfx' ));
?>
<div class="vmgroup<?php echo $params->get( 'moduleclass_sfx' ) ?>">
<?php if ($headerText) { ?>
	<div class="vmheader"><?php echo $headerText ?></div>
<?php }
?>

<?php 
$last = count($products)-1;
?>

<div class="prod_box defaultbox">
<ul id="box<?php echo $params->get( 'class_sfx' ) ?>" class="vmproduct layout">
  <div class="li">
  <?php
  if (!empty($products)) {
    if (!class_exists( 'CurrencyDisplay' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'currencydisplay.php');
    $currency = CurrencyDisplay::getInstance( );
    $count_holder = $params->get( 'class_sfx' );
    $prod = array();
    $prod[0] = $products;
    $productsLayout = VmConfig::get ('productsublayout', 'products');
  
   echo shopFunctionsF::renderVmSubLayout($productsLayout,array('products'=>$prod,'currency'=>$currency,'products_per_row'=>$products_per_row,'showRating'=>$showRating, 'count_holder'=>$count_holder));
  }
  ?>
</div>
</ul>
<div class="clearfix"></div>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
		//jQuery('.prod_box .layout .hasTooltip').tooltip('hide');
    //alert(notPoliteLoading);
    if (notPoliteLoading =='1'){
  		jQuery(".prod_box.defaultbox img.lazy").show().lazyload({
  			effect : "fadeIn"
  		});
    }
	});

</script>
<?php	if ($footerText) : ?>
	<div class="vmfooter <?php echo $params->get( 'moduleclass_sfx' ) ?>">
		 <?php echo $footerText ?>
	</div>
<?php endif; ?>
</div>
