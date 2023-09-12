<?php // no direct access
defined('_JEXEC') or die('Restricted access');
$categoryModel->addImages($categories);
//JHTML::stylesheet ( 'menucss.css', 'modules/mod_virtuemart_category/css/', false );
$ID = str_replace('.', '_', substr(microtime(true), -8, 8));

//$cache 				= JFactory::getCache('com_virtuemart','callback');
$vendorId			= !isset($vendorId) || empty($vendorId) ? '1' : abs((int)$vendorId);
/* ID for jQuery dropdown */
$js					= "jQuery(window).load(function() {
						jQuery('#accordion".$ID." li.level0  ul').each(function(index) {jQuery(this).prev().addClass('idCatSubcat')});
						jQuery('#accordion".$ID." li.level0 ul').css('display','none');
						jQuery('#accordion".$ID." li.active').each(function() {
						  jQuery('#accordion".$ID." li.active > span').addClass('expanded');
						});
						jQuery('#accordion".$ID." li.level0.active > ul').css('display','block');
						jQuery('#accordion".$ID." li.level0.active > ul  li.active > ul').css('display','block');
						jQuery('#accordion".$ID." li.level0.active > ul  li.active > ul li.active > ul').css('display','block');
						jQuery('#accordion".$ID." li.level0 ul').each(function(index) {
						  jQuery(this).prev().addClass('close').click(function() {
							if (jQuery(this).next().css('display') == 'none') {
							 jQuery(this).next().slideDown(200, function () {
								jQuery(this).prev().removeClass('collapsed').addClass('expanded');
							  });
							}else {
							  jQuery(this).next().slideUp(200, function () {
								jQuery(this).prev().removeClass('expanded').addClass('collapsed');
								jQuery(this).find('ul').each(function() {
								  jQuery(this).hide().prev().removeClass('expanded').addClass('collapsed');
								});
							  });
							}
							return false;
						  });
					});
					});" ;

$document 			= JFactory::getDocument();
$document->addScriptDeclaration($js);
if ($enable) { ?>
<script type="text/javascript">
jQuery(document).ready(function(){
	var xOffset = <?php echo $xOffset ?>;
	var yOffset = <?php echo $yOffset ?>;
	//screenshotPreview();
	jQuery(function() {
    	jQuery('#accordion<?php echo $ID ;?> li a').each(function() {        
        var tip = jQuery(this).find('.screenshot');

        jQuery(this).hover(
            function() { tip.appendTo('body'); },
            function() { tip.appendTo(this); }
        ).mousemove(function(e) {
            var x = e.pageX + xOffset,
                y = e.pageY - yOffset,
                w = tip.width(),
                h = tip.height(),
                dx = jQuery(window).width() - (x + w),
                dy = jQuery(window).height() - (y + h);

            if ( dx < 50 ) x = e.pageX - w + 10;
            if ( dy < 50 ) y = e.pageY - h + 90;

            tip.css({ left: x, top: y });
        	});         
    	});
		});
});
</script>
<?php } ?>
<?php

/* END MODIFICATION */
global $enableimg2;
$enableimg	= $params->get('enable_images', 0);
$enableimg2 =  $enableimg;
//print_r($GLOBALS);
if(!function_exists('vm_template_get_tree_recurse')){

	function vm_template_get_tree_recurse($category,$childs,$parentCategories,$vendorId,$class_sfx,$ID,$level = 0){
		//$cache 		= JFactory::getCache('com_virtuemart','callback');
		$content 	= '';
		global $enableimg2;
		
		if(is_array($childs) && sizeof($childs)):
			++$level;
			ob_start(); ?>
			
			<ul class="level<?php echo $level; ?>">
					<?php
					foreach ($category->childs as $child) {
						

		//enableimg2 = $params->get('enable_images');
						if ($enableimg2) {
							if ($child->images[0]->published !==0) { 	
								$img = $child->images[0]->displayMediaThumb('class="vm-categories-wall-img"',false);
							}
						}
						$active_menu = 'VmClose';
						if (in_array( $child->virtuemart_category_id, $parentCategories)) $active_menu = 'active';
			
						
						$caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$child->virtuemart_category_id);
						$cattext = $child->category_name;
						$categoryModel = VmModel::getModel('Category');
						//$child->childs = $cache->call( array( 'VirtueMartModelCategory', 'getChildCategoryList' ),$vendorId, $child->virtuemart_category_id );
						$child->childs = $categoryModel->getChildCategoryList($vendorId, $child->virtuemart_category_id) ;
						$categoryModel->addImages($child->childs);
						?>
					
						<li class="level<?php echo $level; ?> <?php echo $active_menu ?> <?php if (is_array($child->childs) && sizeof($child->childs)):?> parent<?php endif; ?>">
								<a href="<?php echo $caturl; ?>"><?php echo $cattext.'<span class="screenshot">'.$img.'</span>' ?></a>
								<?php 
								if (is_array($child->childs) && sizeof($child->childs)) {
									?>
									<span class="VmArrowdown"><i class="plus fa fa-caret-down"></i><i class="minus fa fa-caret-up"></i></span>
									<?php
								}
								?>
                                
							<?php if (is_array($child->childs) && sizeof($child->childs)) { ?>					
								<?php echo vm_template_get_tree_recurse($child,$child->childs,$parentCategories,$vendorId,$class_sfx,$ID,$level); ?>
							<?php } ?>
						</li>
			<?php 	} ?>
			</ul>
			<?php 
		$content 	= ob_get_contents();
		ob_end_clean();
		endif;
		return $content;

	}
} 

?>

<ul id="accordion<?php echo $ID ?>" class="list accordion" >
<?php foreach ($categories as $category) {

		if ($enableimg) {
			if ($category->images[0]->published !==0) { 	
				$img = $category->images[0]->displayMediaThumb('class="vm-categories-wall-img"',false);
			}
		}	
		$active_menu = 'VmClose';
		$caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$category->virtuemart_category_id);
		$cattext = $category->category_name;
		//$category->childs = $cache->call( array( 'VirtueMartModelCategory', 'getChildCategoryList' ),$vendorId, $category->virtuemart_category_id );
		$category->childs = $categoryModel->getChildCategoryList($vendorId, $category->virtuemart_category_id) ;
		$categoryModel->addImages($category->childs);
		//if ($active_category_id == $category->virtuemart_category_id) $active_menu = 'class="active"';
		if (in_array( $category->virtuemart_category_id, $parentCategories)) $active_menu = 'active';

		?>
	<li class="level0 <?php echo $active_menu ?> <?php if (is_array($category->childs) && sizeof($category->childs)):?> parent<?php endif; ?>">
			<a href="<?php echo $caturl; ?>" ><?php echo $cattext.'<span class="screenshot">'.$img.'</span>' ?></a>
            <?php
			if (is_array($category->childs) && sizeof($category->childs)) {
				?>
				<span class="VmArrowdown"><i class="plus fa fa-caret-down"></i><i class="minus fa fa-caret-up"></i></span>
				<?php
			}
			?>
		<?php if(is_array($category->childs) && sizeof($category->childs)){
 ?>
					<?php echo vm_template_get_tree_recurse($category,$category->childs,$parentCategories,$vendorId,$class_sfx,$ID); ?>
		<?php };?>
	</li>
<?php
	} ?>
</ul>
