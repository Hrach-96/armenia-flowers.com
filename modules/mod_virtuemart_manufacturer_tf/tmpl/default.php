<?php // no direct access
defined('_JEXEC') or die('Restricted access');
$col= 1 ;
$count = 1;
$current_manufacturer_id = JRequest::getInt('virtuemart_manufacturer_id',0);
$app = JFactory::getApplication();
$templateparams	= $app->getTemplate(true)->params;
$politeloading = $templateparams->get('politeloading');
?>
<div class="vmgroup<?php echo $params->get( 'moduleclass_sfx' ) ?>">

<?php if ($headerText) : ?>
	<div class="vmheader"><?php echo $headerText ?></div>
<?php endif;
if ($display_style =="div") { ?>
	<div class="vmmanufacturer<?php echo $params->get('moduleclass_sfx'); ?>">
	<?php foreach ($manufacturers as $manufacturer) {
		if($count<=$manufacturers_per_row){
		$link = JROUTE::_('index.php?option=com_virtuemart&view=manufacturer&virtuemart_manufacturer_id=' . $manufacturer->virtuemart_manufacturer_id);
		if ($manufacturer->virtuemart_manufacturer_id==$current_manufacturer_id) {
			$active_class = ' class="active"';
		} else {
			$active_class = '';
		}
		?>
		<div <?php echo $active_class; ?>>
			<a href="<?php echo $link; ?>">
		<?php
		if ($manufacturer->images && ($show == 'image' or $show == 'all' )) { ?>
			<?php echo $manufacturer->images[0]->displayMediaThumb('',false);?>
		<?php
		}
		if ($show == 'text' or $show == 'all' ) { ?>
		 <div><?php echo $manufacturer->mf_name; ?></div>
		<?php
		} ?>
			</a>
		</div>
		<?php
		$count++;
		}

	} ?>
	</div>
<?php
} else {
	$last = count($manufacturers)-1;
?>
<div class="list_carousel_brand responsive">
<ul id="brand_slider" class="vmmanufacturer<?php echo $params->get('moduleclass_sfx'); ?>">
<?php
foreach ($manufacturers as $manufacturer) {
	$link = JROUTE::_('index.php?option=com_virtuemart&view=category&virtuemart_manufacturer_id=' . $manufacturer->virtuemart_manufacturer_id);
	if ($manufacturer->virtuemart_manufacturer_id==$current_manufacturer_id) {
		$active_class = ' class="active"';
	} else {
		$active_class = '';
	}
	?>
	<li<?php echo $active_class; ?>><a href="<?php echo $link; ?>">
		<?php
		if ($manufacturer->images && ($show == 'image' or $show == 'all' )) { 
		 $images = $manufacturer->images;
			$main_image_title = $images[0]->file_title;
			$main_image_alt = $images[0]->file_meta;
			if (!empty($images[0]->file_url_thumb)){
				$main_image_url1 = JURI::root().''.$images[0]->file_url_thumb;
				if($politeloading=='1') {
		          //$main_image_url1_p = '/images/stories/virtuemart/preloader.gif';
		        }else {
		          $main_image_url1_p = JURI::root().''.$images[0]->file_url_thumb;
		        }
			}else {
				$main_image_url1 = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
				}
			
			$image = '<img data-original="'.$main_image_url1 .'"  src="'.$main_image_url1_p.'"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
		?>
			<?php echo $image;?>
		<?php
		}
		if ($show == 'text' or $show == 'all' ) { ?>
		 <div><?php echo $manufacturer->mf_name; ?></div>
		<?php
		}
		?>
		</a>
	</li>
	<?php
	if ($col == $manufacturers_per_row && $manufacturers_per_row && $last) {
		echo '</li>';
		$col= 1 ;
	} else {
		$col++;
	}
	$last--;
} ?>
</ul>
<div class="clearfix"></div>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
if( (jQuery("#t3-mainbody .row .t3-sidebar-left").hasClass("t3-sidebar")) || (jQuery("#t3-mainbody .row .t3-sidebar-right").hasClass("t3-sidebar")) ) {
		jQuery("#brand_slider").loveowlCarousel({
		items : 5,
		autoPlay : 7000,
		 itemsDesktop : [1000,4], //5 items between 1000px and 901px
		itemsDesktopSmall : [900,3], // betweem 900px and 601px
		itemsTablet: [600,2], //2 items between 600 and 0
		itemsMobile : false, // itemsMobile disabled - inherit from itemsTablet option
		stopOnHover : true,
		lazyLoad : false,
		pagination : false,
		navigation : true,
		 navigationText: [
			"<i class='fa fa-caret-left'></i>",
				"<i class='fa fa-caret-right'></i>"
		]
		}); 
		jQuery("#brand_slider img.lazy").show().lazyload({
			effect : "fadeIn"
		});
}else {
			jQuery("#brand_slider").loveowlCarousel({
		items : 6,
		autoPlay : 5000,
		 itemsDesktop : [1000,4], //5 items between 1000px and 901px
		itemsDesktopSmall : [900,3], // betweem 900px and 601px
		itemsTablet: [600,2], //2 items between 600 and 0
		itemsMobile : false, // itemsMobile disabled - inherit from itemsTablet option
		stopOnHover : true,
		lazyLoad : false,
		pagination : false,
		navigation : true,
		 navigationText: [
			"<i class='fa fa-caret-left'></i>",
				"<i class='fa fa-caret-right'></i>"
		]
		}); 
		jQuery("#brand_slider img.lazy").show().lazyload({
			effect : "fadeIn"
		});
	}
	});
    
    </script>
<?php }
	if ($footerText) : ?>
	<div class="vmfooter<?php echo $params->get( 'moduleclass_sfx' ) ?>">
		 <?php echo $footerText ?>
	</div>
<?php endif; ?>
</div>

