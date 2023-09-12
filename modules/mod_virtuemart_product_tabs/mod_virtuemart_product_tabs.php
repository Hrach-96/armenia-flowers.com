<?php
defined('_JEXEC') or die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/*
* featured/Latest/Topten/Random Products Module
*
* @version $Id: mod_virtuemart_product.php 2789 2011-02-28 12:41:01Z oscar $
* @package VirtueMart
* @subpackage modules
*
* @copyright (C) 2010 - Patrick Kohl
* @copyright (C) 2011 - The VirtueMart Team
* @author Max Milbers, Valerie Isaksen, Alexander Steiner
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* VirtueMart is Free Software.
* VirtueMart comes with absolute no warranty.
*
* www.virtuemart.net
*/


defined('DS') or define('DS', DIRECTORY_SEPARATOR);
if (!class_exists( 'VmConfig' )) require(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');

VmConfig::loadConfig();
VmConfig::loadJLang('mod_virtuemart_product_tabs', true);

// Setting
$app    = JFactory::getApplication();
$templateparams = $app->getTemplate(true)->params;
$lblhotcount = $templateparams->get('lblhotcount');
$headerText = 		$params->get( 'headerText', '' ); // Display a Header Text
$footerText = 		$params->get( 'footerText', ''); // Display a footerText
$mainframe = Jfactory::getApplication();
$virtuemart_currency_id = $mainframe->getUserStateFromRequest( "virtuemart_currency_id", 'virtuemart_currency_id',vRequest::getInt('virtuemart_currency_id',0) );

//vmJsApi::jPrice();
//vmJsApi::cssSite();
//echo vmJsApi::writeJS();
$script = $params->get('script');
?>
<?php  if($script!=="standart"){ ?>
<div class="mod_vm2products <?php echo $params->get( 'moduleclass_sfx' ) ?> new-tabs<?php if($script){echo ' tabs';}else{echo ' accordion';} ?>">
<div class="responsive-tabs">
<?php } else { ?>
<div class="mod_vm2products <?php echo $params->get( 'moduleclass_sfx' ) ?> new-tabs<?php if($script=="standart"){echo ' standart';}?>">

<?php } ?>
	<?php
$fieldname 	 = $params->get('field_name');
//var_dump($fieldname);
// loop your result
foreach( $fieldname as $fieldname_idx => $fieldname_template ) {
   // do something clever for each of the templates
	$cache = $fieldname_template->vmcache;
	$cachetime = $fieldname_template->vmcachetime;
	$vm_tabs_title = $fieldname_template->vm_tabs_title;
	$carusel =  $fieldname_template->carusel;
	$vm_tabs_class = $fieldname_template->vm_tabs_class;
	$max_items = 		$fieldname_template->max_items; //maximum number of items to display
	$display_style = 	$fieldname_template->display_style; // Display Style
	$products_per_row = $fieldname_template->products_per_row; // Display X products per Row
	$stock  = 		(bool)$fieldname_template->stock; // Display the Product stock
	$osrc = $fieldname_template->outsource;
	if (!empty($osrc))
	{
	$oresource = implode(",", $fieldname_template->outsource);
		if($oresource !=="null"){
			$resource = "null";
		}
	} else {
		$oresource = "null";
	}
	$src = $fieldname_template->source;
	if (!empty($src))
	{
	$resource = implode(",", $fieldname_template->source);
		if($resource !=="null"){
			$oresource = "null";
		}
	} else {
		$resource = "null";

	}
	$Product_group = 	$fieldname_template->product_group; // Display a footerText

	if($cache){
		vmdebug('Use cache for mod products tabs');
		$key = 'products'.$max_items.'.'.$filter_category.'.'.$display_style.'.'.$products_per_row.'.'.$Product_group.'.'.$virtuemart_currency_id.'.'.$stock.'.'.$src.'.'.$resource.'.'.$osrc.'.'.$oresource;
		$cache	= JFactory::getCache('mod_virtuemart_product_tabs', 'output');
		$cache->setCaching(1);
		$cache->setLifeTime($cachetime);

		if ($output = $cache->get($key)) {
			echo $output;
			echo vmJsApi::writeJS();
			vmdebug('Use cached mod products');
			return true;
		}
	}
	//var_dump($fieldname_template);

	
	//vmdebug('$params for mod products',$params);
	$vendorId = vRequest::getInt('vendorid', 1);
	$productModel = VmModel::getModel('Product');
	$ratingModel = VmModel::getModel('ratings');
	$db =& JFactory::getDBO();

if($Product_group =='featured'){
$where = 'product_special = 1 AND a.published = 1'; $order = 'ASC ';

if($stock=="1") 
{
	$where = $where.' AND product_in_stock > 0';
}
//echo $resource;
//echo $oresource;

if($resource !=="null")
{
	$where = $where.' AND b.virtuemart_category_id IN ('.$resource.')';
}
if($oresource !== "null" )
{
$where = $where.' AND b.virtuemart_category_id NOT IN ('.$oresource.')';
}

$query = "SELECT DISTINCT CONCAT( p.product_name,' ' ) AS title, product_sales AS sales_count, product_in_stock AS in_stock, a.virtuemart_product_id, b.virtuemart_category_id , media.file_url AS product_full_image, p.product_s_desc AS text, product_special AS featured, a.published AS published, product_in_stock AS stock, b.category_name as section, prices.override AS discount, prices.product_price AS price, prices.product_override_price AS disc_price, 
  		 a.created_on as created, '2' AS browsernav
  		FROM #__virtuemart_products AS a
  		LEFT JOIN #__virtuemart_products_".VMLANG." p ON p.virtuemart_product_id = a.virtuemart_product_id 
		LEFT JOIN #__virtuemart_product_prices AS prices ON a.virtuemart_product_id = prices.virtuemart_product_id
  		LEFT JOIN #__virtuemart_product_categories AS xref ON xref.virtuemart_product_id = a.virtuemart_product_id
  		LEFT JOIN #__virtuemart_categories_".VMLANG." AS b ON b.virtuemart_category_id = xref.virtuemart_category_id 
		LEFT JOIN #__virtuemart_product_medias AS pm ON pm.virtuemart_product_id = (SELECT IF(a.product_parent_id>0, a.product_parent_id, p.virtuemart_product_id))
		LEFT JOIN #__virtuemart_medias AS media ON pm.virtuemart_media_id = media.virtuemart_media_id"

. ' WHERE ' . $where
  .' GROUP BY a.virtuemart_product_id '
	. ' ORDER BY a.virtuemart_product_id ' . $order
	.'LIMIT '.$max_items
	;

$db->setQuery($query, 0);
$rows = $db->loadObjectList();
	if ($rows) {
		$prod = array();
		foreach ($rows as $key => $row) {
		
			$prod[] = $rows[$key]->virtuemart_product_id;
		}

		// $prods_feat = $product_model->getProducts($prod);
		$products = array();
		foreach ($prod as $id) {
			if ($prodin = $productModel->getProduct ((int)$id, TRUE, TRUE, TRUE, 1, FALSE, $virtuemart_shoppergroup_ids)) {
				$products[] = $prodin;
			}
		}
			
			$productModel->addImages($products);
		

	}

}

if($Product_group =='latest'){
$where = 'a.virtuemart_product_id > 0 AND a.published = 1'; $order = 'a.created_on ASC';

if($stock=="1") 
{
	$where = $where.' AND product_in_stock > 0';
}
//echo $resourcenew;
//echo $oresourcenew;

if($resource !=="null")
{
	$where = $where.' AND b.virtuemart_category_id IN ('.$resource.')';
}
if($oresource !== "null" )
{
$where = $where.' AND b.virtuemart_category_id NOT IN ('.$oresource.')';
}

$query = "SELECT DISTINCT CONCAT( p.product_name,' ' ) AS title, product_sales AS sales_count, product_in_stock AS in_stock, a.virtuemart_product_id, b.virtuemart_category_id , media.file_url AS product_full_image, p.product_s_desc AS text, product_special AS featured, product_in_stock AS stock, b.category_name as section, prices.override AS discount, prices.product_price AS price, prices.product_override_price AS disc_price, 
  		 a.created_on as created, '2' AS browsernav
		 
  		FROM #__virtuemart_products AS a
  		LEFT JOIN #__virtuemart_products_".VMLANG." p ON p.virtuemart_product_id = a.virtuemart_product_id 
		LEFT JOIN #__virtuemart_product_prices AS prices ON a.virtuemart_product_id = prices.virtuemart_product_id
  		LEFT JOIN #__virtuemart_product_categories AS xref ON xref.virtuemart_product_id = a.virtuemart_product_id
  		LEFT JOIN #__virtuemart_categories_".VMLANG." AS b ON b.virtuemart_category_id = xref.virtuemart_category_id 
		LEFT JOIN #__virtuemart_product_medias AS pm ON pm.virtuemart_product_id = (SELECT IF(a.product_parent_id>0, a.product_parent_id, p.virtuemart_product_id))
		LEFT JOIN #__virtuemart_medias AS media ON pm.virtuemart_media_id = media.virtuemart_media_id
		"

. ' WHERE ' . $where
  .' GROUP BY a.virtuemart_product_id '
	. ' ORDER BY ' . $order
	.' LIMIT '.$max_items
	;

$db->setQuery($query, 0);
$rows = $db->loadObjectList();
	if ($rows) {
		$prod = array();
		foreach ($rows as $key => $row) {
		
			$prod[] = $rows[$key]->virtuemart_product_id;
		}

		// $prods_feat = $product_model->getProducts($prod);
		$products = array();
		foreach ($prod as $id) {
			if ($prodin = $productModel->getProduct ((int)$id, TRUE, TRUE, TRUE, 1, FALSE, $virtuemart_shoppergroup_ids)) {
				$products[] = $prodin;
			}
		}
			
		$productModel->addImages($products);

	}
}
if($Product_group =='random'){
$where = 'a.virtuemart_product_id > 0 AND a.published = 1'; $order = 'RAND()';
if($stock=="1") 
{
	$where = $where.' AND product_in_stock > 0';
}
//echo $resourcerand;
//echo $oresourcerand;

if($resource !=="null")
{
	$where = $where.' AND b.virtuemart_category_id IN ('.$resource.')';
}
if($oresource !== "null" )
{
$where = $where.' AND b.virtuemart_category_id NOT IN ('.$oresource.')';
}

$query = "SELECT DISTINCT CONCAT( p.product_name,' ' ) AS title, product_sales AS sales_count, product_in_stock AS in_stock, a.virtuemart_product_id, b.virtuemart_category_id , media.file_url AS product_full_image, p.product_s_desc AS text, product_special AS featured, product_in_stock AS stock, b.category_name as section, prices.override AS discount, prices.product_price AS price, prices.product_override_price AS disc_price, 
  		 a.created_on as created, '2' AS browsernav
  		FROM #__virtuemart_products AS a
  		LEFT JOIN #__virtuemart_products_".VMLANG." p ON p.virtuemart_product_id = a.virtuemart_product_id 
		LEFT JOIN #__virtuemart_product_prices AS prices ON a.virtuemart_product_id = prices.virtuemart_product_id
  		LEFT JOIN #__virtuemart_product_categories AS xref ON xref.virtuemart_product_id = a.virtuemart_product_id
  		LEFT JOIN #__virtuemart_categories_".VMLANG." AS b ON b.virtuemart_category_id = xref.virtuemart_category_id 
		LEFT JOIN #__virtuemart_product_medias AS pm ON pm.virtuemart_product_id = (SELECT IF(a.product_parent_id>0, a.product_parent_id, p.virtuemart_product_id))
		LEFT JOIN #__virtuemart_medias AS media ON pm.virtuemart_media_id = media.virtuemart_media_id"

. ' WHERE ' . $where
  .' GROUP BY a.virtuemart_product_id '
	. ' ORDER BY ' . $order
	.' LIMIT '.$max_items
	;

$db->setQuery($query, 0);
$rows = $db->loadObjectList();
//var_dump ($rows);
	if ($rows) {
		$prod = array();
		foreach ($rows as $key => $row) {
		
			$prod[] = $rows[$key]->virtuemart_product_id;
		}

		// $prods_feat = $product_model->getProducts($prod);
		$products = array();
		foreach ($prod as $id) {
			if ($prodin = $productModel->getProduct ((int)$id, TRUE, TRUE, TRUE, 1, FALSE, $virtuemart_shoppergroup_ids)) {
				$products[] = $prodin;
			}
		}
			
		$productModel->addImages($products);

	}
}
if($Product_group =='topten'){
$where = 'a.published = 1 AND  product_sales > '.$lblhotcount; $order = 'product_sales DESC';
if($stock=="1") 
{
	$where = $where.' AND product_in_stock > 0';
}
//echo $resourcehit;
//echo $oresourcehit;

if($resource !=="null")
{
	$where = $where.' AND b.virtuemart_category_id IN ('.$resource.')';
}
if($oresource !== "null" )
{
$where = $where.' AND b.virtuemart_category_id NOT IN ('.$oresource.')';
}


$query = "SELECT DISTINCT CONCAT( p.product_name,' ' ) AS title, product_sales AS sales_count, product_in_stock AS in_stock, a.virtuemart_product_id, b.virtuemart_category_id , media.file_url AS product_full_image, p.product_s_desc AS text, product_special AS featured, product_in_stock AS stock, b.category_name as section, prices.override AS discount, prices.product_price AS price, prices.product_override_price AS disc_price, 
  		 a.created_on as created, '2' AS browsernav
  		FROM #__virtuemart_products AS a
  		LEFT JOIN #__virtuemart_products_".VMLANG." p ON p.virtuemart_product_id = a.virtuemart_product_id 
		LEFT JOIN #__virtuemart_product_prices AS prices ON a.virtuemart_product_id = prices.virtuemart_product_id
  		LEFT JOIN #__virtuemart_product_categories AS xref ON xref.virtuemart_product_id = a.virtuemart_product_id
  		LEFT JOIN #__virtuemart_categories_".VMLANG." AS b ON b.virtuemart_category_id = xref.virtuemart_category_id 
		LEFT JOIN #__virtuemart_product_medias AS pm ON pm.virtuemart_product_id = (SELECT IF(a.product_parent_id>0, a.product_parent_id, p.virtuemart_product_id))
		LEFT JOIN #__virtuemart_medias AS media ON pm.virtuemart_media_id = media.virtuemart_media_id"

. ' WHERE ' . $where
  .' GROUP BY a.virtuemart_product_id '
	. ' ORDER BY ' . $order
	.' LIMIT '.$max_items
	;

$db->setQuery($query, 0);
$rows = $db->loadObjectList();
//var_dump ($rows);
	if ($rows) {
		$prod = array();
		foreach ($rows as $key => $row) {
		
			$prod[] = $rows[$key]->virtuemart_product_id;
		}

		// $prods_feat = $product_model->getProducts($prod);
		$products = array();
		foreach ($prod as $id) {
			if ($prodin = $productModel->getProduct ((int)$id, TRUE, TRUE, TRUE, 1, FALSE, $virtuemart_shoppergroup_ids)) {
				$products[] = $prodin;
			}
		}
			
		$productModel->addImages($products);

	}
}
if($Product_group =='special'){
	$where = 'prices.product_override_price < prices.product_price AND prices.override != 0 AND a.published = 1'; 
	$order = 'RAND()';
if($stock=="1") 
{
	$where = $where.' AND product_in_stock > 0';
}
//echo $resourcedisc;
//echo $oresourcedisc;

if($resource !=="null")
{
	$where = $where.' AND b.virtuemart_category_id IN ('.$resource.')';
}
if($oresource !== "null" )
{
$where = $where.' AND b.virtuemart_category_id NOT IN ('.$oresource.')';
}


$query = "SELECT DISTINCT CONCAT( p.product_name,' ' ) AS title, product_sales AS sales_count, product_in_stock AS in_stock, a.virtuemart_product_id, b.virtuemart_category_id , media.file_url AS product_full_image, p.product_s_desc AS text, product_special AS featured, product_in_stock AS stock, b.category_name as section, prices.override AS discount, prices.product_price AS price, prices.product_override_price AS disc_price, prices.product_discount_id AS discount_id
  		 
  		FROM #__virtuemart_products AS a
  		LEFT JOIN #__virtuemart_products_".VMLANG." p ON p.virtuemart_product_id = a.virtuemart_product_id 
		LEFT JOIN #__virtuemart_product_prices AS prices ON a.virtuemart_product_id = prices.virtuemart_product_id
  		LEFT JOIN #__virtuemart_product_categories AS xref ON xref.virtuemart_product_id = a.virtuemart_product_id
  		LEFT JOIN #__virtuemart_categories_".VMLANG." AS b ON b.virtuemart_category_id = xref.virtuemart_category_id 
		LEFT JOIN #__virtuemart_product_medias AS pm ON pm.virtuemart_product_id = (SELECT IF(a.product_parent_id>0, a.product_parent_id, p.virtuemart_product_id))
		LEFT JOIN #__virtuemart_medias AS media ON pm.virtuemart_media_id = media.virtuemart_media_id"

. ' WHERE ' . $where
  .' GROUP BY a.virtuemart_product_id '
	. ' ORDER BY ' . $order
	.' LIMIT '.$max_items
	;

$db->setQuery($query, 0);
$rows = $db->loadObjectList();
//var_dump ($rows);
	if ($rows) {
		$prod = array();
		foreach ($rows as $key => $row) {
		
			$prod[] = $rows[$key]->virtuemart_product_id;
		}

		// $prods_feat = $product_model->getProducts($prod);
		$products = array();
		foreach ($prod as $id) {
			if ($prodin = $productModel->getProduct ((int)$id, TRUE, TRUE, TRUE, 1, FALSE, $virtuemart_shoppergroup_ids)) {
				$products[] = $prodin;
			}
		}
			
		$productModel->addImages($products);

	}

}
if($Product_group =='rating'){
$db =&JFactory::getDBO();
		$db->setQuery('select rating ,ratingcount, rates, virtuemart_product_id   from #__virtuemart_ratings LIMIT '.$max_items);
		$rows = $db->loadAssocList();
		arsort($rows);
	//var_dump ($rows);
		$prod = array();
		foreach($rows as $product){
			if ($product['rates']==5){
				$prod[] = $product['virtuemart_product_id'];
			}
		}

		// $prods_feat = $product_model->getProducts($prod);
		//var_dump ($prod);
		$products = array();
		foreach ($prod as $id) {
			if ($prodin = $productModel->getProduct ((int)$id, TRUE, TRUE, TRUE, 1, FALSE, $virtuemart_shoppergroup_ids)) {
				$products[] = $prodin;
			}
		}
			
		$productModel->addImages($products);

}
if (!class_exists('shopFunctionsF'))
	require(JPATH_VM_SITE . DS . 'helpers' . DS . 'shopfunctionsf.php');
shopFunctionsF::sortLoadProductCustomsStockInd($products,$productModel);

$totalProd = 		count( $products);
//if(empty($products)) return false;

if (!class_exists('CurrencyDisplay'))
	require(VMPATH_ADMIN . DS . 'helpers' . DS . 'currencydisplay.php');
$currency = CurrencyDisplay::getInstance( );

ob_start();

/* Load tmpl default */
require(JModuleHelper::getLayoutPath('mod_virtuemart_product_tabs',$params->get('layout', 'default')));
$output = ob_get_clean();
echo $output;
}	
echo vmJsApi::writeJS();
?>
<?php  if($script!=="standart"){ ?>
</div>
</div>

<script type="text/javascript" src="modules/mod_virtuemart_product_tabs/assets/responsiveTabs2.min.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function() {
    RESPONSIVEUI.responsiveTabs2();
  });
</script>
<?php }else {
	echo "</div>";
}?>

