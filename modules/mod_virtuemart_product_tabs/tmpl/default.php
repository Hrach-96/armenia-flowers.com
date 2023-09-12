
<?php
defined('_JEXEC') or die('Restricted access');
 // no direct access
if ($carusel){
JHtml::_('behavior.modal');
$col= 1 ;
$app = JFactory::getApplication();
$templateparams = $app->getTemplate(true)->params;
$politeloading = $templateparams->get('politeloading');
?>
<?php if ($vm_tabs_title) { ?>
<h3 class="module-title"><?php echo $vm_tabs_title ?></h3>
<?php } ?>
<div class="<?php if($script=="standart"){echo 'standart-box';}?> vmgroup<?php echo $params->get( 'moduleclass_sfx' ) ?> productstyle<?php echo $vm_tabs_class ?>">
<?php if ($headerText) { ?>
	<div class="vmheader"><?php echo $headerText ?></div>
<?php }
?>

<?php 
$last = count($products)-1;
?>
<?php
   if (!empty($products)) { ?>
<div class="prod_box">
<ul id="slider<?php echo $vm_tabs_class ?>" class="owl-carousel vmproduct layout">
  
  
   <?php
      if (!class_exists( 'CurrencyDisplay' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'currencydisplay.php');
      $currency = CurrencyDisplay::getInstance( );
      $count_holder = $params->get( 'class_sfx' );
      $prod = array();
      $prod[0] = $products;
      $productsLayout = VmConfig::get ('productsublayout', 'products');
    
     echo shopFunctionsF::renderVmSubLayout($productsLayout,array('products'=>$prod,'currency'=>$currency,'products_per_row'=>$products_per_row,'showRating'=>$showRating, 'count_holder'=>$count_holder));
    ?>
</ul>
<div class="clearfix"></div>
</div>
<?php }else {  echo '<h3 class="module-title no-products"><i class="fa fa-info-circle"></i>'.JText::_('PRODUCTS_FILTER_NO').'</h3>';  } ?>
<script type="text/javascript">
jQuery(document).ready(function() {
	if( (jQuery("#t3-mainbody .row .t3-sidebar-left").hasClass("t3-sidebar")) || (jQuery("#t3-mainbody .row .t3-sidebar-right").hasClass("t3-sidebar")) ) {
			jQuery("#slider<?php echo $vm_tabs_class ?>").loveowlCarousel({
			items : 3,
			autoPlay : 12000,
			 itemsDesktop : [1000,2], //5 items between 1000px and 901px
			itemsDesktopSmall : [900,2], // betweem 900px and 601px
			itemsTablet: [700,2], //2 items between 600 and 0
			itemsMobile : [415,1], // itemsMobile disabled - inherit from itemsTablet option
			stopOnHover : true,
			lazyLoad : false,
			navigation : true,
      pagination : false,
			 navigationText: [
				"<i class='fa fa-caret-left'></i>",
				"<i class='fa fa-caret-right'></i>"
			]
			}); 
	 }else {
		 jQuery("#slider<?php echo $vm_tabs_class ?>").loveowlCarousel({
			items : 4,
			autoPlay : 12000,
			 itemsDesktop : [1000,3], //5 items between 1000px and 901px
			itemsDesktopSmall : [900,3], // betweem 900px and 601px
			itemsTablet: [700,2], //2 items between 600 and 0
			itemsMobile : [415,1], // itemsMobile disabled - inherit from itemsTablet option
			stopOnHover : true,
			lazyLoad : false,
			navigation : true,
       pagination : false,
			 navigationText: [
				"<i class='fa fa-caret-left'></i>",
				"<i class='fa fa-caret-right'></i>"
			]
			}); 
			//jQuery('.slide_box .layout .hasTooltip').tooltip('hide');	
     
	 }
});
</script>
<script type="text/javascript">
 if (notPoliteLoading =='1'){
  jQuery(document).ready(function() {
   // jQuery(".mod_vm2products.new-tabs .prod-row").removeClass("wow");
      jQuery(".new-tabs .productstyle<?php echo $vm_tabs_class ?> .prod_box img.lazy").show().lazyload({
        effect : "fadeIn",
        event : "sporty"
      });
  });
  jQuery(window).bind("load", function() {
      var timeout = setTimeout(function() {
          jQuery(".new-tabs .productstyle<?php echo $vm_tabs_class ?> .prod_box img.lazy").trigger("sporty");
      }, 2000);
  });}
</script>
<?php	if ($footerText) : ?>
	<div class="vmfooter <?php echo $params->get( 'moduleclass_sfx' ) ?>">
		 <?php echo $footerText ?>
	</div>
<?php endif; ?>
</div>
<?php } else {
JHtml::_('behavior.modal');
$col= 1 ;
$app = JFactory::getApplication();
$templateparams = $app->getTemplate(true)->params;
$politeloading = $templateparams->get('politeloading');
//print_r($params->get( 'moduleclass_sfx' ));
?>
<?php if ($vm_tabs_title) { ?>
<h3 class="module-title"><?php echo $vm_tabs_title ?></h3>
<?php } ?>
<div class="<?php if($script=="standart"){echo 'standart-box';}?> vmgroup<?php echo $params->get( 'moduleclass_sfx' ) ?> productstyle<?php echo $vm_tabs_class ?>">
<?php if ($headerText) { ?>
	<div class="vmheader"><?php echo $headerText ?></div>
<?php }
?>
<?php 
$last = count($products)-1;
if(!empty($products)){
?>

<div class="prod_box">
<ul id="box" class="vmproduct layout">
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
<?php }else {  echo '<h3 class="module-title no-products"><i class="fa fa-info-circle"></i>'.JText::_('PRODUCTS_FILTER_NO').'</h3>';  } ?>
<script type="text/javascript">
 if (notPoliteLoading =='1'){
  jQuery(document).ready(function() {
   // jQuery(".mod_vm2products.new-tabs .prod-row").removeClass("wow");
      jQuery(".new-tabs .productstyle<?php echo $vm_tabs_class ?> .prod_box img.lazy").show().lazyload({
        effect : "fadeIn",
        event : "sporty"
      });
  });
    jQuery(window).bind("load", function() {
      var timeout = setTimeout(function() {
          jQuery(".new-tabs .productstyle<?php echo $vm_tabs_class ?> .prod_box img.lazy").trigger("sporty");
      }, 2000);
  
});}
</script>
<?php	if ($footerText) : ?>
	<div class="vmfooter <?php echo $params->get( 'moduleclass_sfx' ) ?>">
		 <?php echo $footerText ?>
	</div>
<?php endif; ?>
</div>
<?php } ?>