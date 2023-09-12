<?php
/**
 *
 * Show the products in a category
 *
 * @package    VirtueMart
 * @subpackage
 * @author RolandD
 * @author Max Milbers
 * @todo add pagination
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 9017 2015-10-14 10:44:34Z Milbo $
 */

defined ('_JEXEC') or die('Restricted access');
if(vRequest::getInt('dynamic')){
	if (!empty($this->products)) {
		if($this->fallback){
			$p = $this->products;
			$this->products = array();
			$this->products[0] = $p;
			vmdebug('Refallback');
		}

		echo shopFunctionsF::renderVmSubLayout($this->productsLayout,array('products'=>$this->products,'currency'=>$this->currency,'products_per_row'=>$this->perRow,'showRating'=>$this->showRating));

	}

	return ;
}
?>
<?php
$js = '
jQuery(document).ready(function () {
	jQuery(".orderlistcontainer").hover(
		function() { 
		jQuery(this).find(".orderlist").has("div").stop().show();
		jQuery(this).find(".activeOrder").addClass("hover");
		},
		function() { 
		jQuery(this).find(".orderlist").has("div").stop().hide();
		jQuery(this).find(".activeOrder").removeClass("hover");
		
		}
	)
	jQuery(".orderlistcontainer .orderlist").each(function(){
	 jQuery(this).parent().find(".activeOrder").addClass("block");             
	})
});
';
//vmJsApi::addJScript('vm.hover',$js);
$document = JFactory::getDocument();
$document->addScriptDeclaration($js);
$app = JFactory::getApplication();
$templateparams = $app->getTemplate(true)->params;
$category_layout = $templateparams->get('category_layout','grid_list');
$category_list_style = $templateparams->get('category_list_style','style_1');
?>
<div id="prodlist-box">
<?php 
if ($this->category->category_name) 
{ ?>
	<h3 class="module-title"><span><span><?php echo $this->category->category_name; ?></span></span></h3>
	
<?php } ?>
<?php if (($this->category->category_description == !null) || (!empty($this->category->images[0])) ){ ?>
<?php if (!empty($this->category->images[0]) || $this->category->images[0]->published !==0){ ?>
<div class="category_description">
	<div class="box-style">
	<?php if ($this->category->images[0]->published !==0){?>	
    <div class="prod_cat">
    	<?php 
    		echo $this->category->images[0]->displayMediaThumb("",false);
		?>
     </div> 
           <?php } ?>
<?php if ($this->category->category_description == !null){?>
     <div class="prod_desc">
		<?php echo $this->category->category_description ; ?>
       </div> 
       <?php } ?>
       <div class="clear"></div>
    </div>
</div>
 <?php } ?>
<?php } ?>
<?php
/* Show child categories */

if ( (VmConfig::get('showCategory',1) && $this->search == !null && $this->category->category_name && empty($this->keyword)) || $this->category->category_name) {
	if ($this->category->haschildren) {

		// Category and Columns Counter
		$iCol = 1;
		$iCategory = 1;

		// Calculating Categories Per Row
		$categories_per_row = VmConfig::get ('categories_per_row', 3);
		$category_cellwidth = ' width'.floor ( 100 / $categories_per_row );

		// Separator
		$verticalseparator = " vertical-separator";
		?>

		<div class="category-view pad-bot">
        <div class="marg">

		<?php // Start the Output
		if(!empty($this->category->children)){
		foreach ( $this->category->children as $category ) {

			// Show the horizontal seperator
			if ($category->images[0]->published !==0){
			// this is an indicator wether a row needs to be opened or not
			if ($iCol == 1) { ?>
			<div class="cat_row">
			<?php }

			// Show the vertical seperator
			if ($iCategory == $categories_per_row or $iCategory % $categories_per_row == 0) {
				$show_vertical_separator = ' ';
			} else {
				$show_vertical_separator = $verticalseparator;
			}

			// Category Link
			$caturl = JRoute::_ ( 'index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $category->virtuemart_category_id );

				// Show Category ?>
				<div class="category floatleft<?php echo $show_vertical_separator ?>">
					<div class="spacer">
						<h2>
							<a href="<?php echo $caturl ?>" title="<?php echo $category->category_name ?>">
								
							<div class="category-border">
								
							<?php // if ($category->ids) {

								echo $category->images[0]->displayMediaThumb("",false);
							//} ?>
							
							</div>
							
							<div class="category-title"><?php echo shopFunctionsF::limitStringByWord($category->category_name , '25' , '...'); ?></div>
							</a>
						</h2>
					</div>
				</div>
			<?php
			$iCategory ++;

		// Do we need to close the current row now?
		if ($iCol == $categories_per_row) { ?>
		<div class="clear"></div>
		</div>
        
			<?php
			$iCol = 1;
		} else {
			$iCol ++;
		}
	}
	}
	// Do we need a final closing row tag?
	if ($iCol != 1) { ?>
		<div class="clear"></div>
		
        </div>
	<?php } }  ?>
    <div class="clear"></div>
	</div>
    
    </div>

<?php }
}


if (!empty($this->products) or ($this->showsearch or $this->keyword !== false)) {
	if (!empty($this->products)) { ?>
<div class="browse-view">
<?php

// Show child categories
if (!empty($this->products)) {
	if (!empty($this->keyword)) {
		?>
		<h4 class="search-title"><?php echo $this->keyword; ?></h4>
	<?php }	?>
<?php } ?>
					
 		<?php if ($this->showsearch or $this->keyword !== false) { ?>
		
			<?php if (empty($this->products)) { ?>
				<h3 class="module-title"><?php echo JText::_('COM_VIRTUEMART_NO_RESULT');?></h3>
			<?php } 
			$category_id  = vRequest::getInt ('virtuemart_category_id', 0);
			?>
			
		    <div class="virtuemart_search">
		<form action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&search=true&limitstart=0&virtuemart_category_id='.$category_id ); ?>" method="get">
			<?php if(!empty($this->searchCustomList)) { ?>
			<div class="vm-search-custom-list">
				<?php echo $this->searchCustomList ?>
			</div>
			<?php } ?>

			<?php if(!empty($this->searchCustomValuesAr)) { ?>
			<div class="vm-search-custom-values">
				<?php
                echo ShopFunctionsF::renderVmSubLayoutAsGrid(
                    'searchcustomvalues',
                    array (
                        'searchcustomvalues' => $this->searchCustomValuesAr,
                        'options' => array (
                            'items_per_row' => array (
                                'xs' => 2,
                                'sm' => 2,
                                'md' => 2,
                                'lg' => 2,
                                'xl' => 2,
                            ),
                        ),
                    )
                );
                ?>
			</div>
			<?php } ?>
			<div class="vm-search-custom-search-input">
				<input name="keyword" class="inputbox" type="text" size="40" value="<?php echo $this->keyword ?>"/>
				<input type="submit" value="<?php echo vmText::_ ('COM_VIRTUEMART_SEARCH') ?>" class="button" onclick="this.form.keyword.focus();"/>
				<?php //echo VmHtml::checkbox ('searchAllCats', (int)$this->searchAllCats, 1, 0, 'class="changeSendForm"'); ?>
				<div class="vm-search-descr"> <?php echo vmText::_('COM_VM_SEARCH_DESC') ?></div>
			</div>

			<!-- input type="hidden" name="showsearch" value="true"/ -->
			<!-- <input type="hidden" name="view" value="category"/>
			<input type="hidden" name="option" value="com_virtuemart"/>
			<input type="hidden" name="virtuemart_category_id" value="<?php echo $category_id; ?>"/>-->
			<input type="hidden" name="Itemid" value="<?php echo $this->Itemid; ?>"/>
		</form>
	</div>
	<?php
	/*if($this->keyword !== false){
		?><h3><?php echo vmText::sprintf('COM_VM_SEARCH_KEYWORD_FOR', $this->keyword); ?></h3><?php
	}*/
	$j = 'jQuery(document).ready(function() {

jQuery(".changeSendForm")
	.off("change",Virtuemart.sendCurrForm)
    .on("change",Virtuemart.sendCurrForm);
})';

	vmJsApi::addJScript('sendFormChange',$j);
 ?>
		<!-- End Search Box -->
		<?php } ?>

<?php // Show child categories

	?>
		<div class="orderby-displaynumber z-index">
            <div class="box-style">
				<div class="width100 border_bot">
               		<?php if ($category_layout =='grid' || $category_layout =='list'){ 
				}elseif ($category_layout =='grid_list') { ?>
                	<div id="navigation" class="navigation_grid">
                        <a class="active hasTooltip Cgrid" href="#"  title="<?php echo JText::_('COM_VIRTUEMART_GRID'); ?>"><i class="fa fa-th"></i></a>
                        <a class="hasTooltip Clist" href="#"  title="<?php echo JText::_('COM_VIRTUEMART_LIST'); ?>"><i class="fa fa-th-list"></i></a>
                    </div>	
				<?php }else {?>
               		 <div id="navigation" class="navigation_grid">
                        <a class="active hasTooltip Clist" href="#"  title="<?php echo JText::_('COM_VIRTUEMART_LIST'); ?>"><i class="fa fa-th-list"></i></a>
						 <a class="hasTooltip Cgrid" href="#"  title="<?php echo JText::_('COM_VIRTUEMART_GRID'); ?>"><i class="fa fa-th"></i></a>
                    </div>	
                 <?php } ?>
					<?php echo $this->orderByList['orderby']; ?>
					<?php 
					if (!empty($this->orderByList['manufacturer'])) {
						echo $this->orderByList['manufacturer'];
					} ?>
                </div>
                <div class="clearfix"></div>
                <div class="Results">
                    <div class="floatleft display-number"><span><?php echo $this->vmPagination->getResultsCounter();?></span><span><?php echo JText::_('COM_VIRTUEMART_SHOW'); ?>:&nbsp;&nbsp;<?php echo $this->vmPagination->getLimitBox ($this->category->limit_list_step); ?>&nbsp;&nbsp;<?php echo JText::_('COM_VIRTUEMART_ITEMS_PER_PAGE'); ?></span>
                    </div>
                    <div id="bottom-pagination-top" class="pagination"><?php echo $this->vmPagination->getPagesLinks(); ?></div>
                    <div class="clear"></div>
                </div> 
               </div> 
			</div>
 			<div class="clearfix"></div>
			<!-- end of orderby-displaynumber -->


	<?php
	if (!empty($this->products)) {?>
	<div id="product_list" class="<?php if ($category_layout =='grid'){ 
					echo 'grid';
				}elseif ($category_layout =='list') { 
					echo 'list';
				}elseif ($category_layout =='grid_list') { 
					echo 'grid';
				}else {echo 'list';} ?>"> 
				<ul id="slider" class="vmproduct layout">

					<div class="li">
				<?php
		//revert of the fallback in the view.html.php, will be removed vm3.2
		if($this->fallback){
			$p = $this->products;
			$this->products = array();
			$this->products[0] = $p;
			vmdebug('Refallback');
		}

	echo shopFunctionsF::renderVmSubLayout($this->productsLayout,array('products'=>$this->products,'currency'=>$this->currency,'products_per_row'=>$this->perRow,'showRating'=>$this->showRating));


	?>
	</div>
	</ul>
</div>
<div class="orderby-displaynumber bot">
    <div class="box-style">
        <div class="Results">
            <div class="floatleft display-number"><span><?php echo $this->vmPagination->getResultsCounter();?></span><span><?php echo JText::_('COM_VIRTUEMART_SHOW'); ?>:&nbsp;&nbsp;<?php echo $this->vmPagination->getLimitBox ($this->category->limit_list_step); ?>&nbsp;&nbsp;<?php echo JText::_('COM_VIRTUEMART_ITEMS_PER_PAGE'); ?></span>
            </div>
            <div id="bottom-pagination-top" class="pagination"><?php echo $this->vmPagination->getPagesLinks(); ?></div>
            <div class="clearfix"></div>
        </div>
         <div class="clearfix"></div>
       </div> 
	</div>

	<?php
} elseif (!empty($this->keyword)) {
	echo vmText::_ ('COM_VIRTUEMART_NO_RESULT') . ($this->keyword ? ' : (' . $this->keyword . ')' : '');
}
?>
</div>

<?php } else { echo '<h3 class="module-title no-products"><i class="fa fa-info-circle"></i>'.JText::_('COM_VIRTUEMART_ITEMS_NO_PRODUCTS').'</h3>';} } ?>
</div>

<?php echo $this->loadTemplate('recently'); ?>
<?php 
$app= & JFactory::getApplication();
$template = $app->getTemplate();
$gpath = $this->baseurl."/templates/".$template ;
$show_daytext= JText::_('DR_DAYS');
$show_haurstext= JText::_('DR_HOURS');	
$show_mintext= JText::_('DR_MINUTES');
$show_sectext= JText::_('DR_SECONDS');
$doc = JFactory::getDocument();
$jsf='
  jQuery(document).ready(function () {
		 jQuery("#product_list ul.layout .prod-row").each(function(indx, element){
			var daytext="'.$show_daytext.'";
			var haurstext="'.$show_haurstext.'";
			var mintext="'.$show_mintext.'";
			var sectext="'.$show_mintext.'";
			
			var my_product_id = jQuery(this).find(".count_ids").val();
			var my_year = jQuery(this).find(".my_year").val();
			var my_month = jQuery(this).find(".my_month").val();
			var my_data = jQuery(this).find(".my_data").val();
			//alert(my_data);
			if(my_product_id){
				jQuery("#CountSmallCategLayout"+my_product_id).countdowns({
				until: new Date(my_year, my_month - 1, my_data), 
				labels: ["Years", "Months", "Weeks", daytext, haurstext, mintext, sectext],
				labels1:["Years","Months","Weeks",daytext, haurstext, mintext, sectext],
				compact: false});
			}
			
		});
	});
' ;
$doc->addScriptDeclaration($jsf);
?> 
<!-- end browse-view -->
<script type="text/javascript" src="<?php echo $gpath ?>/html/com_virtuemart/category/Cookie.js"></script>
<script type="text/javascript">
function tooltip(){
	jQuery('.navigation_grid .hasTooltip , #product_list .hasTooltip').tooltip();
}
 jQuery(document).ready(function($) {
 	if (notPoliteLoading =='1'){
		$("#product_list img.lazy").lazyload({
			effect : "fadeIn",
			skip_invisible : false,
			threshold : 100
		});
	}		
	tooltip();
	 $('.Results select').styler();
		 var VmCatUrl = "index.php"+window.vmLang; 

	  <?php if ($category_layout =='grid' || $category_layout =='list'){ 
	  
		}elseif ($category_layout =='grid_list') { ?>
              var cc = $.cookie('list_grid');
			if (cc == 'g') {
				$('#product_list').addClass('list');
				$('#product_list').removeClass('grid');
				$('.Cgrid').removeClass('active');
				$('.Clist').addClass('active');
			} else {
				$('#product_list').addClass('grid');
				$('#product_list').removeClass('list');
				$('.Clist').removeClass('active');
				$('.Cgrid').addClass('active');		
			}
			$('.Cgrid').click(function() {
				$('.Cgrid').addClass('active');
				$('.Clist').removeClass('active');
				$('#product_list').fadeOut(300, function() {
					$(this).addClass('grid').removeClass('list').fadeIn(300);
				});
				$.cookie('list_grid', '1' , { expires: 7, path: VmCatUrl });
				return false;
			});
			$('.Clist').click(function() {
				$('.Clist').addClass('active');
				$('.Cgrid').removeClass('active');						  
				$('#product_list').fadeOut(300, function() {
					$(this).removeClass('grid').addClass('list').fadeIn(300);
				});
				$.cookie('list_grid','g', { expires: 7, path: VmCatUrl });
				return false;
				});
  	
		<?php }else {?>
             var cc = $.cookie('list_grid');
				if (cc == 'g') {
					$('#product_list').addClass('grid');
					$('#product_list').removeClass('list');
					$('.Cgrid').addClass('active');
					$('.Clist').removeClass('active');
				} else {
					$('#product_list').removeClass('grid');
					$('#product_list').addClass('list');
					$('.Clist').addClass('active');
					$('.Cgrid').removeClass('active');		
				}
			
				$('.Cgrid').click(function() {
					$('.Cgrid').addClass('active');
					$('.Clist').removeClass('active');
					$('#product_list').fadeOut(300, function() {
						$(this).addClass('grid').removeClass('list').fadeIn(300);
					});
					$.cookie('list_grid', 'g' , { expires: 7, path: vmSiteurl });
					return false;
				});
				
				$('.Clist').click(function() {
					$('.Clist').addClass('active');
					$('.Cgrid').removeClass('active');						  
					$('#product_list').fadeOut(300, function() {
						$(this).removeClass('grid').addClass('list').fadeIn(300);
					});
					$.cookie('list_grid','l', { expires: 7, path: vmSiteurl });
					return false;
				});  		 
        <?php } ?>


});
</script>
<?php
if(VmConfig::get ('jdynupdate', TRUE)){
	$j = "Virtuemart.container = jQuery('.category-view');
	Virtuemart.containerSelector = '.category-view';";

	//vmJsApi::addJScript('ajaxContent',$j);
}
?>
