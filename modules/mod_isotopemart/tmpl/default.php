<?php
/**
 * @author ITechnoDev, LLC
 * @copyright (C) 2014 - ITechnoDev, LLC
 * @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 **/


// no direct access
defined('_JEXEC') or die ;
JHtml::_('behavior.modal');
$app = JFactory::getApplication();
$templateparams = $app->getTemplate(true)->params;
$politeloading = $templateparams->get('politeloading');


$document->addStyleSheet($baseurl.'modules/mod_isotopemart/assets/css/isotope.css');
$document->addCustomTag('<!--[if lt IE 9]>');
$document->addCustomTag('<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>');
$document->addCustomTag('<![endif]-->');
	if ($params->get('loadjQuery', 1)) 
	{
		// Load JQuery only if it's not inside virtuemart
		if (JRequest::getCmd('option')!="com_virtuemart")
		{
			// load jQuery, if not loaded before
			if (!JFactory::getApplication()->get('jquery'))
			{
				//JFactory::getApplication()->set('jquery', true);
        		$document->addScript(JURI::base().'modules/mod_isotopemart/assets/js/jquery-1.7.1.min.js', "text/javascript");
        		$document->addScript(JURI::base().'modules/mod_isotopemart/assets/js/jquery-noConflict.js', "text/javascript");
			}
		}
	}
    $document->addScript(JURI::base().'modules/mod_isotopemart/assets/js/jquery.isotope.min.js', "text/javascript");
    $document->addScript(JURI::base().'modules/mod_isotopemart/assets/js/jquery.infinitescroll.min.js');
    $document->addScript(JURI::base().'modules/mod_isotopemart/assets/js/manual-trigger.js');    
	  $document->addScriptDeclaration($script);
	// manage the visibility of the module in VirtueMart views
	if (JRequest::getCmd('option')=="com_virtuemart")
	{
		$cmds = array(  "category",
						"productdetails",
						"manufacturer",
						"user",
						"vendor",
						"cart",
						"orders");
	
		if ((int)$params->get('hide_views'))
		{
			if ( in_array(JRequest::getCmd('view'), $cmds) || in_array(JRequest::getCmd('task'), $cmds) )
			{
				return ;
			}
		}
	
		if (JRequest::getCmd('view')=="virtuemart")
		{
			if ((int)$params->get('hide_front'))
			{
				// get the document object.
				$doc = JFactory::getDocument();
				// get the buffer
				$buffer = $doc->getBuffer('component');
				// reset the buffer and delete the component content
				$doc->setBuffer('', 'component');
			}
		}
	} // end manage the visibility
	
?>
<div id="itVMModuleBox<?php echo $module->id; ?>" class="itVMProductBlock<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?> izotopprods">
		<!-- Options -->
        <section id="options" class="options">
			 <?php if($show_filtering==1) {?>			
		   <!-- Filters -->
		   <ul id="filters" class="option-set" data-option-key="filter">
                <li><a class="button reset selected" href="#filter" data-option-value="*" class="selected"><?php echo JText::_('MOD_ISOTOPEMART_SHOW_ALL'); ?></a></li>
                <?php foreach($catNameArray as $catAlias => $catName): 
				//print_r ($catNameArray);
				?>
                <?php 
                	$res = $categoryModel->getCategory($catAlias);
                	if ($root_category)
                	{
                		if (count($res->parents)==1)
                		{
                			?>	
                			<li><a class="button" href="#filter" data-option-value=".categoryid-<?php echo $catAlias; ?>"><?php echo $catName; ?></a></li>
                			<?php 
                		}
                	}
                	else 
					{
                ?>
                    <li><a class="button" href="#filter" data-option-value=".categoryid-<?php echo $catAlias; ?>"><?php echo $catName; ?></a></li>
             <?php } endforeach; ?>
            </ul>
            <?php }?>
            <?php if($show_ordering) {?>  
      <!-- Sort Direction-->
            <ul id="sort-direction" class="option-set" data-option-key="sortAscending">
                <li><a class="button" href="#sortAscending=false" data-option-value="false" class="selected"><i class="fa fa-caret-down"></i></a></li>
                <li><a class="button" href="#sortAscending=true" data-option-value="true" ><i class="fa fa-caret-up"></i></a></li>
            </ul>
            <?php }?>
            <?php if($show_sorting) {?>			
			<!-- Sort by-->
			 <ul id="sort-by" class="option-set" data-option-key="sortBy">
			<!-- 	 <li><a href="#sortBy=original-order"     data-option-value="original-order" class="selected" >original</a></li>  -->
				 <li><a class="button" href="#sortBy=created_on"         data-option-value="created_on" class="selected"><?php echo JText::_('MOD_ISOTOPEMART_SORT_DATE'); ?></a></li>			
				 <li><a class="button" href="#sortBy=product_name"       data-option-value="product_name" ><?php echo JText::_('MOD_ISOTOPEMART_SORT_NAME'); ?></a></li>
				 <li><a class="button" href="#sortBy=product_price"      data-option-value="product_price"><?php echo JText::_('MOD_ISOTOPEMART_SORT_PRICE'); ?></a></li>
				 <li><a class="button" href="#sortBy=product_ordered"    data-option-value="product_ordered"><?php echo JText::_('MOD_ISOTOPEMART_SORT_SALES'); ?></a></li>
			</ul>
			<?php }?>
            
        </section>
 <div style="clear:both;"></div>
 <!-- Container By Style -->
     <?php if($item_style == 0) { // begin Default?>
 	<!-- Begin Container Default -->
    <div class="prod_box">
 	 <ul class="vmproduct layout">
	<div class="li">
    <div id="container" class="clearfix isotope">
       
    <?php
    //$products = array_unique($products);
    //var_dump($product_ids);
    $product_model = VmModel::getModel('product');
    $productsizotop = array();
    foreach ($products as $key=>$product) {
      $productsizotop[] = $product->virtuemart_product_id;
   } 
   $productsizotop=array_unique($productsizotop);
   $products_izotop = $product_model->getProducts($productsizotop);
   $product_model->addImages($products_izotop); 

      if (!empty($products_izotop)) {
        //print_r();
        if (!class_exists( 'CurrencyDisplay' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'currencydisplay.php');
        $currency = CurrencyDisplay::getInstance( );
        $count_holder = $params->get( 'moduleclass_sfx' );
        $products_per_row = 1;
        $isotopevmart = 'isotopevmart';
        $prod = array();
        $prod[0] = $products_izotop;
        $productsLayout = VmConfig::get ('productsublayout', 'products');
      
       echo shopFunctionsF::renderVmSubLayout($productsLayout,array('products'=>$prod,'currency'=>$currency,'products_per_row'=>$products_per_row,'showRating'=>$showRating, 'count_holder'=>$count_holder ,'itemHeight'=>$itemHeight, 'itemWidth'=>$itemWidth, 'isotopevmart'=>$isotopevmart));
      }
      ?>
    </div>
    </div>
        </ul>
        </div>
    <!-- End Container Default -->
    
     <?php } ?> 
 </div>
 <script type="text/javascript">
   (function($){
    var $container = $('#container');
    $container.isotope({
      resizable: false,
      masonry: { columnWidth: $container.width() / 12 },
      itemSelector : '.itemmart',
      filter: '*',
      sortBy: 'created_on',
      sortAscending : false,
      animationOptions: {
      duration: 750,
      easing: 'linear',
      queue: false
      },
       
      getSortData :
      {
        product_name: '[data-pname]',
        created_on: '[data-pcreated]',
        product_price:'[data-pprice]',
        product_ordered:'[data-pordered]'
      }

    });

    

    var $optionSets = $('#options .option-set'),
          $optionLinks = $optionSets.find('a');

      $optionLinks.click(function(){
        var $this = $(this);
        // don't proceed if already selected
        if ( $this.hasClass('selected') ) {
          return false;
        }
        var $optionSet = $this.parents('.option-set');
        $optionSet.find('.selected').removeClass('selected');
        $this.addClass('selected');
  
        // make option object dynamically, i.e. { filter: '.my-filter-class' }
        var options = {},
            key = $optionSet.attr('data-option-key'),
            value = $this.attr('data-option-value');
        // parse 'false' as false boolean
        value = value === 'false' ? false : value;
        options[ key ] = value;
        if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
          // changes in layout modes need extra logic
          changeLayoutMode( $this, options )
        } else {
          // otherwise, apply new options
          $container.isotope( options );
        }
        
        return false;
      });

})(jQuery);
jQuery(document).ready(function() {
		//jQuery('.prod_box .layout .hasTooltip').tooltip('hide');	
    if (notPoliteLoading =='1'){
  		jQuery(".izotopprods .prod_box img.lazy").show().lazyload({
  			effect : "fadeIn",
			event : "sporty"
  		});
    }
	});
jQuery(window).bind("load", function() {
    var timeout = setTimeout(function() {
        jQuery(".itVMProductBlock img.lazy").trigger("sporty");
		
    }, 2000);
});
jQuery(document).ready(function () {
     jQuery(".izotopprods ul.layout .prod-row").each(function(indx, element){
      var my_product_id = jQuery(this).find(".count_ids").val();
      var my_year = jQuery(this).find(".my_year").val();
      var my_month = jQuery(this).find(".my_month").val();
      var my_data = jQuery(this).find(".my_data").val();
      //alert(my_data);
      if(my_product_id){
        jQuery('#CountSmallIzotop'+my_product_id).countdown({
        until: new Date(my_year, my_month - 1, my_data), 
        labels: ['Years', 'Months', 'Weeks', '<?php echo JText::_('DR_DAYS')?>', '<?php echo JText::_('DR_HOURS')?>', '<?php echo JText::_('DR_MINUTES')?>', '<?php echo JText::_('DR_SECONDS')?>'],
        labels1:['Years','Months','Weeks','<?php echo JText::_('DR_DAYS')?>','<?php echo JText::_('DR_HOURS')?>','<?php echo JText::_('DR_MINUTES')?>','<?php echo JText::_('DR_SECONDS')?>'],
        compact: false});
      }
      
    });
  });
</script>
  
 
 