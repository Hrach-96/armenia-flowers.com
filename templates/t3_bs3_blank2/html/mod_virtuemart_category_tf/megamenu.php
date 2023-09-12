<?php // no direct access
defined('_JEXEC') or die('Restricted access');
$categoryModel->addImages($categories);
//JHTML::stylesheet ( 'menucss.css', 'modules/mod_virtuemart_category/css/', false );
$ID = str_replace('.', '_', substr(microtime(true), -8, 8));

//$cache 				= JFactory::getCache('com_virtuemart','callback');
$vendorId			= !isset($vendorId) || empty($vendorId) ? '1' : abs((int)$vendorId);
/* ID for jQuery dropdown */

$document 			= JFactory::getDocument();

/* END MODIFICATION */
global $enableimg2;
$enableimg	= $params->get('enable_images', 0);
$enableimg2 =  $enableimg;
//print_r($GLOBALS);
if(!function_exists('vm_megamenu_get_tree_recurse')){

	function vm_megamenu_get_tree_recurse($category,$childs,$parentCategories,$vendorId,$class_sfx,$ID,$level = 0){
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
								$img2 = '<span class="megascreenshot">'.$child->images[0]->displayMediaThumb('class="vm-categories-img"',false).'</span>';
							}
						}
						$active_menu = 'VmClose';
						if (in_array( $child->virtuemart_category_id, $parentCategories)) $active_menu = 'active current';
			
						
						$caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$child->virtuemart_category_id);
						$cattext = $child->category_name;
						$categoryModel = VmModel::getModel('Category');
						//$child->childs = $cache->call( array( 'VirtueMartModelCategory', 'getChildCategoryList' ),$vendorId, $child->virtuemart_category_id );
						$child->childs = $categoryModel->getChildCategoryList($vendorId, $child->virtuemart_category_id) ;
						$categoryModel->addImages($child->childs);
						?>
					
						<li class="level<?php echo $level; ?> <?php echo $active_menu ?> <?php if (is_array($child->childs) && sizeof($child->childs)):?> parent<?php endif; ?>">
								<a href="<?php echo $caturl; ?>"><?php echo $img2.$cattext ?></a>
								
                                
							<?php if (is_array($child->childs) && sizeof($child->childs)) { ?>					
								<?php echo vm_megamenu_get_tree_recurse($child,$child->childs,$parentCategories,$vendorId,$class_sfx,$ID,$level); ?>
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

<ul id="megamenu<?php echo $ID ?>" class="list mega-nav <?php if ($enableimg) { echo 'img'; } ?>" >
<?php foreach ($categories as $category) {

		if ($enableimg) {
			if ($category->images[0]->published !==0) { 	
				$img = '<span class="megascreenshot">'.$category->images[0]->displayMediaThumb('class="vm-categories-img"',false).'</span>';
			}
		}	
		$active_menu = 'VmClose';
		$caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$category->virtuemart_category_id);
		$cattext = $category->category_name;
		//$category->childs = $cache->call( array( 'VirtueMartModelCategory', 'getChildCategoryList' ),$vendorId, $category->virtuemart_category_id );
		$category->childs = $categoryModel->getChildCategoryList($vendorId, $category->virtuemart_category_id) ;
		$categoryModel->addImages($category->childs);
		//if ($active_category_id == $category->virtuemart_category_id) $active_menu = 'class="active"';
		if (in_array( $category->virtuemart_category_id, $parentCategories)) $active_menu = 'active current';

		?>
	<li class="level0 <?php echo $active_menu ?> <?php if (is_array($category->childs) && sizeof($category->childs)):?> dropdown-submenu parent<?php endif; ?>">
			<a href="<?php echo $caturl; ?>" ><?php echo $img.$cattext ?></a>
            
		<?php if(is_array($category->childs) && sizeof($category->childs)){
 ?>
					<?php echo vm_megamenu_get_tree_recurse($category,$category->childs,$parentCategories,$vendorId,$class_sfx,$ID); ?>
		<?php };?>
	</li>
<?php
	} ?>
</ul>
