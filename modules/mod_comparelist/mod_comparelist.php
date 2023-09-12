<?php
/**
 * @package     Joomla.Tutorials
 * @subpackage  Module
 * @copyright   (C) 2012 http://jomla-code.ru
 * @license     License GNU General Public License version 2 or later; see LICENSE.txt
 */ 
// No direct access.
defined('_JEXEC') or die('Restricted access');
error_reporting('E_ALL');
defined('_JEXEC') or  die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
	if (!class_exists( 'mod_comparelist' )) require('helper.php');
$ratingModel = VmModel::getModel('ratings');
$product_model = VmModel::getModel('product');

if (isset($_SESSION['ids']));
if (!empty($_SESSION['ids'])){
$products = $_SESSION['ids'];
	//unset($_SESSION['ids']);

$prods = $product_model->getProducts($products);
$product_model->addImages($prods,1);
$currency = CurrencyDisplay::getInstance();
}
require JModuleHelper::getLayoutPath('mod_comparelist', $params->get('layout', 'default'));
?>