<?php
/**
 * @package     Joomla.Tutorials
 * @subpackage  Module
 * @copyright   (C) 2012 http://jomla-code.ru
 * @license     License GNU General Public License version 2 or later; see LICENSE.txt
 */ 
// No direct access.
defined('_JEXEC') or  die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');
VmConfig::loadConfig();
// Load the language file of com_virtuemart.
JFactory::getLanguage()->load('com_virtuemart');
if (!class_exists( 'calculationHelper' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'calculationh.php');
if (!class_exists( 'CurrencyDisplay' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'currencydisplay.php');
if (!class_exists( 'VirtueMartModelVendor' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'models'.DS.'vendor.php');
if (!class_exists( 'VmImage' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'image.php');
if (!class_exists( 'shopFunctionsF' )) require(JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'shopfunctionsf.php');
if (!class_exists( 'calculationHelper' )) require(JPATH_COMPONENT_SITE.DS.'helpers'.DS.'cart.php');
if (!class_exists( 'VirtueMartModelProduct' )){
   JLoader::import( 'product', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models' );
}
if (!class_exists( 'VirtueMartModelRatings' )){
 	JLoader::import( 'ratings', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models' );
}


?>
