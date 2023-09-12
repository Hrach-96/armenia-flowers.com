<?php
/**
 * @author ITechnoDev, LLC
 * @copyright (C) 2014 - ITechnoDev, LLC
 * @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 **/


defined('_JEXEC') or die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );

if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');

if (!class_exists( 'ModIsotopeMartHelper' )) require('helper.php');


$document = JFactory::getDocument();
$baseurl = JURI::base();
 
// Setting

$category_id = 		$params->get( 'virtuemart_category_id', null ); // Display products from this category only
$item_style = 	(int)$params->get( 'item_style', 1 ); // Display Style
$show_price = 		(bool)$params->get( 'show_price', 1 ); // Display the Product Price?
$show_discounted_price = (bool)$params->get( 'show_discounted_price', 1 );
$show_addtocart = 	(bool)$params->get( 'show_addtocart', 1 ); // Display the "Add-to-Cart" Link?
$show_addtocart_custom_fields = (bool)$params->get('show_addtocart_custom_fields',1); //Display the Add-to-Cart Custom Fields?
$product_group = 	$params->get( 'product_group', 'featured'); // Display a footerText
$itemWidth  	 = $params->get('itemWidth', 282);
$itemHeight      = $params->get('itemHeight', 427);
$imgHeight      = $params->get('imgHeight', 400);
$show_rating_stars = (bool)$params->get( 'show_rating_stars', 1 );
$show_new_badge = (bool)$params->get( 'show_new_badge', 1 );
$new_product_from = $params->get('new_product_from', 3);
$root_category = (bool)$params->get( 'root_category', 1 ); // show only root catgory
$max_items = 		$params->get( 'max_items', 20 ); //maximum number of items to display
$same_img_size = 	(bool)	$params->get( 'same_img_size', 1 ); //same image size
$theme_style = $params->get( 'theme_style', 'blue');
$show_filtering =(bool)	$params->get( 'show_filtering', 1 );
$show_sorting =(bool)	$params->get( 'show_sorting', 1 );
$show_ordering =(bool)	$params->get( 'show_ordering', 1 );
$show_sales_badge =(bool)	$params->get( 'show_sales_badge', 1 );
$enable_pagination = (bool)	$params->get( 'enable_pagination', 0 );
$per_page = (int) $params->get( 'per_page', 6 );
$filter_category = 	(bool)$params->get( 'filter_category', 0 ); // Filter the category

$mainframe = Jfactory::getApplication();
$virtuemart_currency_id = $mainframe->getUserStateFromRequest( "virtuemart_currency_id", 'virtuemart_currency_id',JRequest::getInt('virtuemart_currency_id',0) );
 
	/* Load  VM fonction */
 
	$vendorId = JRequest::getInt('vendorid', 1);

	$productModel  = VmModel::getModel('Product');
	$categoryModel = VmModel::getModel('Category');
	$products = $productModel->getProductListing($product_group, $max_items, true, true, false, true, $category_id);
	$cats_id = $categoryModel->getCategory();
	//$catNameArray = $catNameArray;
	
    if (count($products))
    {
            $catAliasArray = array();
            $catNameArray = array();
            foreach ($products as $product)
            {    
                if (!in_array($product->virtuemart_category_id, $catAliasArray))
                {
                    $catAliasArray[] = $product->virtuemart_category_id;
                    $catNameArray[$product->virtuemart_category_id] = $product->category_name;
                }
            }
    }
	
	
	$productModel->addImages($products);

	$totalProd = 		count( $products);
	if(empty($products)) return false;
	$currency = CurrencyDisplay::getInstance( );
 
	if ($show_addtocart) 
	{
		vmJsApi::jPrice();
		vmJsApi::cssSite();
	}

	$script	 = ModIsotopeMartHelper::getScript($params,$module->id);
 
	/* Load tmpl default */
    require(JModuleHelper::getLayoutPath('mod_isotopemart','default'));

?>
