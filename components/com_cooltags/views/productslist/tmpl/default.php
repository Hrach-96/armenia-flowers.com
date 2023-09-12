<?php
error_reporting('E_ALL');

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$app = JFactory::getApplication();
$templateparams = $app->getTemplate(true)->params;
$politeloading = $templateparams->get('politeloading');
$lblsale = $templateparams->get('lblsale');
$lblhot = $templateparams->get('lblhot');
$lblhotcount = $templateparams->get('lblhotcount');
$lbloffer = $templateparams->get('lbloffer');
$lblsold = $templateparams->get('lblsold');
$lblnew = $templateparams->get('lblnew');
$latest_products_days = $templateparams->get('lblnewcount');


$lang = JFactory::getLanguage();
$extension = 'com_virtuemart';
$lang->load($extension);

$tag						= JRequest::getVar('tag');
$products 					= $this->products;
$juri 						= JURI::base();
$doc 						= &JFactory::getDocument();
//$doc->addStylesheet($juri.'components/com_cooltags/assets/css/style.css');

$cparams          = JComponentHelper::getParams('com_cooltags');
$vm_itemid          = $cparams->get('vm_itemid');
//$cooltags_itemid      = $cparams->get('cooltags_itemid');
$items = JFactory::getApplication()->getMenu( 'site' )->getItems( 'component', 'com_cooltags' );
  //print_r($items);
    foreach ( $items as $item ) {
        if($item->query['view'] === 'productslist'){
      //print_r($item->id);
            $cooltags_itemid= $item->id;
      
        }
    }
$show_price           = $cparams->get('show_price','1');
$credits          = $cparams->get('credits','0');
echo '<h3 class="module-title"><span><span>'.JText::_('COM_COOLTAGS_TAGGED_AS').': '.$tag.'</h3></span></span>';
echo '<div class="pagination2" >';
echo $this->pagination->getResultsCounter();
echo '</div></br>';

function jsonRemoveUnicodeSequences($struct) {
   return preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($struct));
}
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
if (!class_exists( 'CurrencyDisplay' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'currencydisplay.php');
if (!class_exists( 'shopFunctionsF' )) require(JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'shopfunctionsf.php');

if (!class_exists( 'VmConfig' ))
	require(JPATH_ADMINISTRATOR . '/components/com_virtuemart/helpers/config.php');
VmConfig::loadConfig();

?>
<?php
$product_model = VmModel::getModel('product');
$ratingModel = VmModel::getModel('ratings');
$mainframe = Jfactory::getApplication();
$virtuemart_currency_id = $mainframe->getUserStateFromRequest( "virtuemart_currency_id", 'virtuemart_currency_id',JRequest::getInt('virtuemart_currency_id',0) );
$tags = array();
$html = $products;
foreach($products as $product){

	$tags[] = $product->virtuemart_product_id;
 } 
 $prods_tags = $product_model->getProducts($tags);
		$product_model->addImages($prods_tags);
		$currency = CurrencyDisplay::getInstance( );
 ?>
 <div id="product_list" class="list tags">
					<ul id="slider" class="vmproduct layout">
            <div class="li">
                      
              <?php
              if (!empty($prods_tags)) {
                if (!class_exists( 'CurrencyDisplay' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'currencydisplay.php');
                $currency = CurrencyDisplay::getInstance( );
                $products_per_row = '1';
                $count_holder_tag = 'com_tags';
                $components_tags = 'components_tags';

                $prod = array();
                $prod[0] = $prods_tags;
                $productsLayout = VmConfig::get ('productsublayout', 'products');
              
               echo shopFunctionsF::renderVmSubLayout($productsLayout,array('products'=>$prod,'currency'=>$currency,'products_per_row'=>$products_per_row,'showRating'=>$showRating, 'count_holder_tag'=>$count_holder,'components_tags'=>$components_tags,'html'=>$html));
              }
              ?>
            </div>
				
					
					</ul>
</div>
<?php                    
echo '<div class="pagination2" >';
echo $this->pagination->getResultsCounter();
echo $this->pagination->getPagesLinks();
echo $this->pagination->getPagesCounter();
echo '</div>';
?>
<br>
<script type="text/javascript">
function tooltip(){
	jQuery('#product_list.list .hasTooltip').tooltip();
}
 jQuery(document).ready(function($) {
	//tooltip();
  if (notPoliteLoading =='1'){
		$("#product_list.tags img.lazy").lazyload({
			effect : "fadeIn"
		});
  } 
});
</script>
