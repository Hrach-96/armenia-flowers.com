<?php // no direct access
defined('_JEXEC') or die('Restricted access');
//JHTML::stylesheet ( 'menucss.css', 'modules/mod_virtuemart_category/css/', false );


//$cache 				= JFactory::getCache('com_virtuemart','callback');
$vendorId			= !isset($vendorId) || empty($vendorId) ? '1' : abs((int)$vendorId);
/* ID for jQuery dropdown */
$js					= "jQuery(window).load(function() {
						jQuery('#accordion2 li.level0  ul').each(function(index) {jQuery(this).prev().addClass('idCatSubcat')});
						jQuery('#accordion2 li.level0 ul').css('display','none');
						jQuery('#accordion2 li.active').each(function() {
						  jQuery('#accordion2 li.active > span').addClass('expanded');
						});
						jQuery('#accordion2 li.level0.active > ul').css('display','block');
						jQuery('#accordion2 li.level0.active > ul  li.active > ul').css('display','block');
						jQuery('#accordion2 li.level0.active > ul  li.active > ul li.active > ul').css('display','block');
						jQuery('#accordion2 li.level0 ul').each(function(index) {
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
if ($p['enabletolltips'] == 1) { ?>
<script type="text/javascript">
this.screenshotPreview = function(){	
	/* CONFIG */
		
		xOffset = <?php echo $xOffset ?>;
		yOffset = <?php echo $yOffset ?>;
		
	/* END CONFIG */
	jQuery("#accordion2 li a.screenshot").hover(function(e){

		this.t = this.title;
		this.title = "";	
		var c = (this.t != "") ? "<br/>" + this.t : "";
		jQuery("body").append("<p id='screenshot'><span></span><img src='"+ this.rel +"' alt='url preview' />"+ c +"</p>");								 
		jQuery("#screenshot")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("fast");						
    },
	function(){
		this.title = this.t;	
		jQuery("#screenshot").remove();
    });	
	jQuery("#accordion2 li a.screenshot").mousemove(function(e){
		jQuery("#screenshot")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});			
};

jQuery(document).ready(function(){
	screenshotPreview(
	);
});
</script>
<?php } ?>
<?php

/* END MODIFICATION */

if(!function_exists('vm_template_get_tree_recurse')){
	function vm_template_get_tree_recurse($category,$childs,$parentCategories,$vendorId,$class_sfx,$ID,$level = 0){
		//$cache 		= JFactory::getCache('com_virtuemart','callback');
		$content 	= '';
		
		if(is_array($childs) && sizeof($childs)):
			++$level;
			ob_start(); ?>
			
			<ul class="level<?php echo $level; ?>">
					<?php
					foreach ($childs as $child) {
							
						if (!empty($child->images[0]->file_url_thumb)){
							$img2 = JURI::base(true).'/'.$child->images[0]->file_url_thumb;
						}else{
							$img2 = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
							}	
						
						$active_menu = 'VmClose';
						if (in_array( $child->virtuemart_category_id, $parentCategories)) $active_menu = 'active';
			
						
						$caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$child->virtuemart_category_id);
						$cattext = $child->category_name;
						$categoryModel = VmModel::getModel('Category');
						$child->childs = $categoryModel->getChildCategoryList($vendorId, $child->virtuemart_category_id) ;
						$categoryModel->addImages($child->childs);
								
							if (($child->childs) && !($category->childs)) {
								if (!empty($child->images[0]->file_url_thumb)){
								$img3 = JURI::base(true).'/'.$child->childs->images[0]->file_url_thumb;
							}else{
								$img3 = JURI::base(true).'/images/stories/virtuemart/noimage.gif';
								}	
							} else {$img3= '';}
							
						?>
					
						<li class="level<?php echo $level; ?> <?php echo $active_menu ?> <?php if (is_array($child->childs) && sizeof($child->childs)):?> parent<?php endif; ?>">
								<a class="screenshot" href="<?php echo $caturl; ?>" rel="<?php echo $img2.' '.$img3; ?>"><?php echo $cattext ?></a>
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

<ul id="accordion" class="list" >
<?php foreach ($categories as $category) {
		if (!empty($category->images[0]->file_url_thumb)){
		$img = JURI::base(true).'/'.$category->images[0]->file_url_thumb;
	}else{
		$img = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
		}
		$active_menu = 'VmClose';
		$caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$category->virtuemart_category_id);
		$cattext = $category->category_name;
		$category->childs = $categoryModel->getChildCategoryList($vendorId, $category->virtuemart_category_id) ;
		$categoryModel->addImages($category->childs);
		//if ($active_category_id == $category->virtuemart_category_id) $active_menu = 'class="active"';
		if (in_array( $category->virtuemart_category_id, $parentCategories)) $active_menu = 'active';

		?>
	<li class="level0 <?php echo $active_menu ?> <?php if (is_array($category->childs) && sizeof($category->childs)):?> parent<?php endif; ?>">
			<a class="screenshot" rel="<?php echo $img ?>" href="<?php echo $caturl; ?>" ><?php echo $cattext ?></a>
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
