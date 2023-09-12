<?php
// No direct access
defined( '_JEXEC' ) or die;
error_reporting('E_ALL');
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
/**
 *
 * @package     Joomla.Plugin
 * @subpackage  System.Vmvendor
 * @since       2.5+
 * @author        velikorodnov
 */
 ///jimport('joomla.plugin.plugin');
class plgSystemQuick extends JPlugin
{
    /**
     * Class Constructor
     * @param object $subject
     * @param array $config
     */
    public function __construct( & $subject, $config )
    {
        parent::__construct( $subject, $config );
        $this->loadLanguage();
        $jlang =JFactory::getLanguage();
        $jlang->load('com_virtuemart', JPATH_SITE, $jlang->getDefault(), true);
        $jlang->load('com_virtuemart', JPATH_SITE, null, true);
    }
    public function onBeforeRender() {
        //echo "1";
        $app = JFactory::getApplication();
        $doc = JFactory::getDocument();
        if (!($app->isAdmin())){
            $show_quicktext =  JText::_('COM_VIRTUEMART_QUICK'); 
                $jsq='
                var show_quicktext="'.$show_quicktext.'";
                jQuery(document).ready(function () {
                    quick_ap();

                });
                function quick_ap(){                             
                     jQuery("ul.layout .product-box , ul.layout2 .product-box").each(function(indx, element){
                        var my_product_id = jQuery(this).find(".quick_ids").val();
                        //alert(my_product_id);
                        if(my_product_id){
                            if (jQuery(this).hasClass("style_1")){
                                jQuery(this).find(".browseImage").append("<div class=\'quick_btn\' onClick =\'quick_btn("+my_product_id+")\'><i class=\'icon-eye-open\'></i>"+show_quicktext+"</div>");
                            }
                            if (jQuery(this).hasClass("style_2")){
                                jQuery(this).find(".browseImage").append("<div class=\'quick_btn\' onClick =\'quick_btn("+my_product_id+")\'><i class=\'icon-eye-open\'></i>"+show_quicktext+"</div>");
                            }
                            if (jQuery(this).hasClass("style_3")){
                                jQuery(this).find(".product-actions").append("<div class=\'quick_btn hasTooltips\' title=\'"+show_quicktext+"\' onClick =\'quick_btn("+my_product_id+")\'><i class=\'icon-eye-open\'></i><span>"+show_quicktext+"</span></div>");
                            }
                        }
                        jQuery(this).find(".quick_id").remove();
                    });
                }
                ' ;
            $doc->addScriptDeclaration($jsq);
            $doc->addScript(JURI::root(true).'/plugins/system/quick/quick/custom.js');
            //$doc->addScript(JURI::root(true).'/plugins/system/quick/quick/shortcodes.js');
            $doc->addStyleSheet(JURI::root(true).'/plugins/system/quick/quick/more_custom.css');
        }

    }
    public function onAfterRender(){ 
        $app = JFactory::getApplication();
        $templateparams = $app->getTemplate('site')->params;
        $politeloading = $templateparams->get('politeloading');
        $lblsale = $templateparams->get('lblsale');
        $lblhot = $templateparams->get('lblhot');
        $lblhotcount = $templateparams->get('lblhotcount');
        $lbloffer = $templateparams->get('lbloffer');
        $lblsold = $templateparams->get('lblsold');
        $lblnew = $templateparams->get('lblnew');
        $latest_products_days = $templateparams->get('lblnewcount');

        $input = JFactory::getApplication()->input;
        if($input->getCmd('action') !== 'test'){
            return;
        }
        $region = $input->getInt('product_id', 0);
        if ($region) {
            if (!class_exists( 'VmConfig' )) require(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
            VmConfig::loadConfig();
            if (!class_exists( 'shopFunctionsF' )) require(JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'shopfunctionsf.php');

            $product_model = VmModel::getModel('product');
            $prods = array($_GET['product_id']);
            //$prods = $product_model->getProducts($product);
            
             $product = $product_model->getProduct($prods);
            $product_model->addImages($product);
            $ratingModel = VmModel::getModel('ratings');
                $customfieldsModel = VmModel::getModel ('Customfields');
                $product->customfields = $customfieldsModel->getCustomEmbeddedProductCustomFields ($product->allIds);
                if ($product->customfields){
            
                    if (!class_exists ('vmCustomPlugin')) {
                        require(JPATH_VM_PLUGINS . DS . 'vmcustomplugin.php');
                    }
                    $customfieldsModel -> displayProductCustomfieldFE ($product, $product->customfields);
                }


        $mainframe = Jfactory::getApplication();
        $pathway = $mainframe->getPathway();
        $task = JRequest::getCmd('task');
        $virtuemart_currency_id = $mainframe->getUserStateFromRequest( "virtuemart_currency_id", 'virtuemart_currency_id',JRequest::getInt('virtuemart_currency_id',0) );
        $currency = CurrencyDisplay::getInstance( );
            $product->event = new stdClass();
            $product->event->afterDisplayTitle = '';
            $product->event->beforeDisplayContent = '';
            $product->event->afterDisplayContent = '';
            if (VmConfig::get('enable_content_plugin', 0)) {
                shopFunctionsF::triggerContentPlugin($product, 'productdetails','product_desc');
    }


        ?>

            <div id="quick-view" ><div id="quick_view_close"><i class="fa fa-times"></i></div>
            
            <?php

                $discont = $product->prices['discountAmount'];
                    $discont = abs($discont);
                    $show_price = $currency->createPriceDiv('salesPrice','',$product->prices);
                ?>
                            <div id="quick-view-scroll">

                <div id="productdetailsview" class="productdetails-view quick">
        <script type="text/javascript" src="<?php echo JUri::base(); ?>plugins/system/quick/quick/more_custom.js"></script>
        <script type="text/javascript" src="<?php echo JUri::base(); ?>plugins/system/quick/quick/shortcodes.js"></script>
       
        
<div class="wrapper2">
     <div class="fleft">
    <div class="image_show_quick">
    <?php   
        $images = $product->images;
        $main_image_url = JURI::root().''.$images[0]->file_url;// [file_title][file_description][file_meta]
        $main_image_url2 = JURI::root().''.$images[0]->file_url_thumb;
            if ($images[0]->published){
                $main_image_url = JURI::root(true).'/'.$images[0]->file_url;
            }else {
                $main_image_url = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
                }
                
            if ($images[0]->published){
                $main_image_url2 = JURI::root(true).'/'.$product->images[0]->getFileUrlThumb();
            }else {
                $main_image_url2 = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
                }

        $main_image_title = $images[0]->file_title;// [file_title][file_description][file_meta]
        $main_image_description = $images[0]->file_description;// [file_title][file_description][file_meta]
        $main_image_alt = $images[0]->file_meta;// [file_title][file_description][file_meta]
        $vm_id = $product->virtuemart_product_id;
        $discont = $product->prices['discountAmount'];
        $discont = abs($discont);
        if (!empty($product->images[0])) {
    ?>
    <img style="display:none!important;"  src="<?php echo $main_image_url ?>"  class="big_img" id="Img_to_Js_<?php echo $vm_id ?>"/>
    <div class="main-image-quick">
     <div class="lbl-box2">
        <?php
        error_reporting('E_ALL');
        //var_dump($product->created_on);
        //$dataNew = explode(' ', $product->created_on);
        //$dataNew=$dataNew[0];
        //$dataNewOut = date('Y-m-d', strtotime($dataNew . " + ".$latest_products_days." day"));
        if($lblnew){
            $str_date = explode(' ', $product->created_on);
            $dataN = explode("-", $str_date[0]);
            $dataNew =  mktime(0, 0, 0, $dataN[1],$dataN[2], $dataN[0]);
            $dataNewOut = $dataNew + 60*60*24*$latest_products_days;
        }
        //var_dump($dataNew).'</br>';
        //var_dump($dataNewOut);
        $stockhandle = VmConfig::get ('stockhandle', 'none');
        if ((($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($product->product_in_stock - $product->product_ordered) < 1) || 
                (($product->product_in_stock - $product->product_ordered) < $product->min_order_level ))&& $lblsold)  { ?>
           
            <div class="sold"><?php echo JText::_('DR_SOLD');?></div>
         <?php }elseif ((time() - $result < $dataNewOut ) && $lblnew ){ ?>
               
             <div class="new"><?php echo JText::_('DR_NEW');?></div>
         <?php } ?>   
             
         </div>
    <div class="lbl-box">
        <?php if ($lbloffer && $product->prices['override'] == 1 && ($product->prices['product_price_publish_down'] > 0)){ ?>
        <div class="discount limited"><?php echo JText::_('DR_LIMITED_OFFER');?></div>
          <?php } elseif($discont >0 && $product->product_sales < $lblhotcount && $lblsale ) { ?>
        <div class="discount"><?php echo JText::_('DR_SALE');?></div>
            <?php } elseif ($lblhot && $product->product_sales > $lblhotcount) {?>
              <div class="hit"><?php echo JText::_('DR_HOT');?></div>
              <?php } ?>
              </div>
        <img  src="<?php echo $main_image_url ?>" data-zoom-image="<?php echo $main_image_url ?>"  title="<?php echo $main_image_title ?>"   alt="<?php echo $main_image_alt ?>" class="big_img" id="Img_zoom"/>
               
    </div>
     <?php 
         $j = count($images);
        //add HTML
        if($j <= 1){ $class='none';}else{$class='';}
        if($j >1){ ?>
            <div id="gallery_02" class="jcarousel jcarousel-container  additional-images <?php echo $class; ?>">
                <ul id="#carousel2" class="paginat">
                <?php 
                    for($i=0; $i<$j; $i++){ 
                if ($product->images[$i]->published){
                    $main_image_url = JURI::root(true).'/'.$product->images[$i]->file_url;
                }else {
                    $main_image_url = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
                }
                if ($product->images[$i]->published){
                    $main_image_url_th = JURI::root(true).'/'. $product->images[$i]->getFileUrlThumb();
                }else {
                    $main_image_url_th = JURI::root(true).'/components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
                } ?>
                 <li class="floatleft"><a class="thumb" href="#" data-image="<?php echo $main_image_url; ?>" data-zoom-image="<?php echo $main_image_url; ?>">
                    <img  src="<?php echo $main_image_url_th; ?>" />
                 </a></li>
                
    <?php       }   
        ?>
        </ul>
        </div>
        <?php  } ?>

<?php } // Product Main Image END ?>

        <div class="clear"></div>
    </div>


       </div> 
    <div class="fright">
         <?php // Product Title  ?>
            <h1 class="title"><?php echo $product->product_name ?></h1>
        <?php // Product Title END  ?>
        <div class="rating">
            <?php
            $showRating = $ratingModel->showRating($product->virtuemart_product_id);
                 if ($showRating=='true'){
                $rating = $ratingModel->getRatingByProduct($product->virtuemart_product_id);
                                        if( !empty($rating)) {
                                            $r = $rating->rating;
                                        } else {
                                            $r = 0;
                                        }
                                        $maxrating = VmConfig::get('vm_maximum_rating_scale',5);
                                                        $ratingwidth = ( $r * 100 ) / $maxrating;//I don't use round as percetntage with works perfect, as for me
                                            ?>
                                          <?php  if( !empty($rating)) {  ?>                        
                                                <span class="vote">
                                                    <span title="" class="vmicon ratingbox" style="display:inline-block;">
                                                        <span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
                                                        </span>
                                                    </span>
                                                    <span class="rating-title"><?php echo JText::_('COM_VIRTUEMART_RATING').' '.round($rating->rating, 2) . '/'. $maxrating; ?></span>
                                                </span>
                                           <?php } else { ?>
                                              <span class="vote">
                                                    <span title="" class="vmicon ratingbox" style="display:inline-block;">
                                                        <span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
                                                        </span>
                                                    </span>
                                                    <span class="rating-title"><?php echo JText::_('COM_VIRTUEMART_RATING').' '.JText::_('COM_VIRTUEMART_UNRATED') ?></span>
                                               </span>
                                               <?php } } ?>
            </div>
            <?php
                // Manufacturer of the Product
                if (!empty($product->virtuemart_manufacturer_id)) { ?>
                 <div class="manufacturer">
                    <?php
                    $text = $product->mf_name;
                    ?>
                     <span class="bold"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_DETAILS_MANUFACTURER_LBL') ?></span><?php echo $text ?>
                  
                </div>
                 <?php } ?>
                <?php
                if ($product->product_in_stock >=1) {
                echo '<div class="stock"><span class="bold">'.JText::_('DR_AVAILABILITY_NEW').':</span><i class="green">'.JText::_('DR_IN_STOCK_NEW').'</i>&nbsp;<b>'.$product->product_in_stock.'&nbsp;'.JText::_('DR_ITEMS_NEW').'</b></div>';
                }else {
                echo '<div class="stock"><span class="bold">'.JText::_('DR_AVAILABILITY_NEW').':</span><i class="red">'.JText::_('DR_OUT_STOCK_NEW').'</i>&nbsp;<b>'.$product->product_in_stock.'&nbsp;'.JText::_('DR_ITEMS_NEW').'</b></div>';
                }
                echo '<div class="code"><span class="bold">'.JText::_('DR_PRODUCT_CODE_NEW').':</span>'.$product->product_sku.'</div>';
            ?>
                        <?php if (!($product->prices['product_price_publish_down'] > 0)){?>
            <?php if ((!empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>               
                                <div class="Price">
                                        <div class="product-price" id="productPrice<?php echo $product->virtuemart_product_id ?>">
                                            <?php
                                            
                                                if( $product->product_unit && VmConfig::get('vm_price_show_packaging_pricelabel')) {
                                                    echo "<strong>". JText::_('COM_VIRTUEMART_CART_PRICE_PER_UNIT').' ('.$product->product_unit."):</strong>";
                                                }
                                                //print_r($discont);

                                                if (round($product->prices['basePrice'],$currency->_priceConfig['salesPrice'][1]) != round($product->prices['salesPrice'],$currency->_priceConfig['salesPrice'][1]) && (round($product->prices['basePrice'] >= $product->prices['salesPrice']))) {
                                                    echo '<span class="PricebasePriceWithTax WithoutTax">' .$currency->createPriceDiv ('basePrice', '', $product->prices ,true).'</span>';
                                                }
                                                echo '<span class="PricesalesPrice sales">' .$currency->createPriceDiv ('salesPrice', '', $product->prices,true).'</span>';
                                                
                                             ?>
                                        </div>
                                        
                                </div><?php } else {
                                    if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { 
                                        $askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id . '&tmpl=component', FALSE);
                                        ?>
                                    <div class="call-a-question">
                                        <a class="addtocart-button call askquestion2"  data-fancybox-type="iframe" href="<?php echo $askquestion_url ?>" rel="nofollow" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
                                    <?php } } ?> 
              <?php } // Product Packaging END
                ?>

            
            <?php if ($product->prices['override'] == 1 && ($product->prices['product_price_publish_down'] > 0)){?>
                          <div class="time-box">
                                <div class="indent">
                              <?php if ((!empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
                                <div class="price">
                                    <div class="product-price" id="productPrice<?php echo $product->virtuemart_product_id ?>">
                                     <?php
                                        if ($product->prices['salesPrice']>0) { ?>
                                    <span class="price-sale">
                                    <span class="text"><?php echo JText::_('DR_SPECIAL_DEAL_PRICE'); ?>:</span>
                                    <?php echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$product->prices) . '</span>';?>
                                    </span>
                                    <?php } ?>
                                     <?php
                                        if ($product->prices['basePriceWithTax']>0) { ?>
                                    <span class="price-old">
                                    <span class="text"><?php echo JText::_('DR_OLD_PRICE'); ?>:</span>
                                    <?php echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePriceWithTax','',$product->prices) . '</span>';?>
                                    </span>
                                    <?php } ?>
                                    <span class="price_save">
                                     <span class="text"><?php echo JText::_('DR_YOU_ARE_SAVING'); ?>:</span>
                                    <?php echo '<span class="discount">' .$currency->createPriceDiv('discountAmount','',$product->prices) . '</span>'; ?>
                                    </span>
                                   
                                    <div class="clear" ></div>
                                    </div>
                                    </div>
                                <?php } ?> 
                            <div  class="bzSaleTimer">
                                    <?php
                                     $data = $product->prices['product_price_publish_down'];
                                    $data = explode(' ', $data);
                                    $time = explode(':', $data[1]);
                                    $data = explode('-', $data[0]);
                                    //var_dump($data);
                                     $year = $data[0];
                                     $month = $data[1];
                                     $data = $data[2];
                                    //var_dump($time);
                                        ?>
                                        <div class="count_holder">
                                        <div class="count_info"><?php echo JText::_('DR_LIMITED2')?></div>
                                        <div id="CountSmall<?php echo $product->virtuemart_product_id ?>" class="count_border">
                                         <script type="text/javascript">
                                    jQuery(function () {    
                                        jQuery('.count_border').countdown({
                                                until: new Date(<?php echo $year; ?>, <?php echo $month; ?> - 1, <?php echo $data; ?>),
                                                labels: ['Years', 'Months', 'Weeks', '<?php echo JText::_('DR_DAYS')?>', '<?php echo JText::_('DR_HOURS')?>', '<?php echo JText::_('DR_MINUTES')?>', '<?php echo JText::_('DR_SECONDS')?>'],
                                                labels1:['Years','Months','Weeks','<?php echo JText::_('DR_DAYS')?>','<?php echo JText::_('DR_HOURS')?>','<?php echo JText::_('DR_MINUTES')?>','<?php echo JText::_('DR_SECONDS')?>'],
                                                compact: false});

                                    });
                                     </script>
                                         </div>
                                         </div>
                                      </div>   
                                      
                                
                                </div>
                               <div class="bzSaleTimerDesc"><?php echo JText::_('DR_HURRY'); ?><div>&nbsp;&nbsp;<?php echo $product->product_in_stock ?>&nbsp;<?php echo JText::_('DR_HURRY_ITEMS'); ?></div></div>
                                <div class="bzSaleTimerDesc2"><div><?php echo $product->product_ordered ?></div>&nbsp;&nbsp;<?php echo JText::_('DR_BOOKED'); ?> </div>
                                <div class="clear" ></div>
                                </div>
            <?php } ?>
            <div class="product-box2">
            <div class="addtocart-area2 proddet">

                <form method="post" class="product js-recalculate" action="<?php echo JURI::getInstance()->toString(); ?>">
                    <input name="quantity" type="hidden" value="<?php echo $step ?>" />
                        <div class="product-custom<?php if (empty($product->customfields)) { echo ' none';}?>">
        <?php
        
        foreach ($product->customfields as $field) { 
        //print_r ($field->layout_pos);
        if ($field->layout_pos == 'addtocart') {
        ?>
            <div class="product-fields">
                <div class="product-field product-field-type-<?php echo $field->field_type ?>">
                <div class="wrapper2">
                    <span class="product-fields-title" ><b><?php echo JText::_($field->custom_title) ?></b></span>
                    <span class="product-field-display">
                    <?php
                        if($field->field_type == 'C') { ?>
                        <a href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id.''); ?>" ><?php echo JText::_('MULTI_VARIANT') ?></a>
                    <?php }else {
                        echo $field->display;
                    }
                    ?></span>
                </div>
                 <span class="product-field-desc"><?php echo $field->custom_field_desc ?></span>
                 <div class="clear"></div>
                </div>
            </div>
            <?php
            }
        }
        ?>
    </div>
                        <?php   
                        if($field->field_type !== 'C') {
                            echo shopFunctionsF::renderVmSubLayout('addtocartprodquick',array('product'=>$product)); 
                        }?>
                        <input type="hidden" name="option" value="com_virtuemart"/>
                        <input type="hidden" name="view" value="cart"/>
                        <input type="hidden" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>"/>
                        <input type="hidden" name="pname" value="<?php echo $product->product_name ?>"/>
                        <input type="hidden" name="pid" value="<?php echo $product->virtuemart_product_id ?>"/>
                        <input type="hidden" class="item_id" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>"/>
                        <?php
                        $itemId=vRequest::getInt('Itemid',false);
                        if($itemId){
                            echo '<input type="hidden" name="Itemid" value="'.$itemId.'"/>';
                        } ?>
                    </form>

            </div>  
            </div>  

          </div>
          <div class="clear"></div>
        </div>

 <div class="example2_quick">
 <div class="tabs_show">
 <div class="responsive-tabs2">
      <?php
     $product_desc= str_replace('src="images/', 'src="'.JURI::root().'/images/', $product->product_desc);
     if ($product->product_desc) { ?>
        <h2> <?php echo JText::_('COM_VIRTUEMART_PRODUCT_DESC_TITLE'); ?></h2>
        <div>
         <?php echo '<div class="desc">' .$product_desc.'</div>'; ?>
        </div>
    <?php } ?>
    
     <?php if (!empty($product->customfields)) {
                    foreach ($product->customfields as $k => $custom) {
                        if (!empty($custom->layout_pos)) {
                            $product->customfieldsSorted[$custom->layout_pos][] = $custom;
                            unset($product->customfields[$k]);
                        }
                    }
                    $product->customfieldsSorted['normal'] = $product->customfields;
                    unset($product->customfields);
                }
            $position = 'custom';
    if (!empty($product->customfieldsSorted[$position])) {  ?>
         <h2> <?php echo  JText::_ ('COM_VIRTUEMART_CUSTOM_TAB'); ?></h2>
           <div class="custom_tab">
                   <div class="product-fields">
                           <?php
                            foreach ($product->customfieldsSorted[$position] as $field) {
                           if($field->layout_pos == 'custom'){ ?>
                           <div class="product-field product-field-type-S">
                                   <?php if ($field->custom_title != $custom_title && $field->show_title) { ?>
                                   <span class="product-fields-title"><?php echo JText::_($field->custom_title); ?>:</span>
                                   <?php }
                                   ?>
                                   <span class="product-field-display"><?php 
                                    $field->display = str_replace('src="images/', 'src="'.JURI::root().'images/', $field->display);
                                   //var_dump($field->display);
                                   echo $field->display ?></span></div>
                                   <?php }
                           }
                           ?>
                   </div>
           </div> 
    <?php  }
        ?>
          
        <?php if (!empty($product->customfields)) {
                    foreach ($product->customfields as $k => $custom) {
                        if (!empty($custom->layout_pos)) {
                            $product->customfieldsSorted[$custom->layout_pos][] = $custom;
                            unset($product->customfields[$k]);
                        }
                    }
                    $product->customfieldsSorted['normal'] = $product->customfields;
                    unset($product->customfields);
                }
            $position = 'filter';
            $position2 = 'normal';
    if (!empty($product->customfieldsSorted[$position])) {  ?>
        <h2> <?php echo  JText::_ ('COM_VIRTUEMART_PRODUCT_SPECIFICATIONS'); ?></h2>
          <div class="filter">
                   <div class="product-fields">
                           <?php
                          foreach ($product->customfieldsSorted[$position] as $field) {
                           if($field->layout_pos == 'filter' || $field->layout_pos == 'normal'){ ?>
                           <div class="product-field product-field-type-S">
                                   <?php if ($field->custom_title != $custom_title && $field->show_title) { ?>
                                   <span class="product-fields-title"><?php echo JText::_($field->custom_title); ?>:</span>
                                   <?php }
                                   ?>
                                   <span class="product-field-display"><?php echo $field->display ?></span></div>
                                   <?php }
                           }
                           ?>
                   </div>
           </div>  <?php
      }
        ?>
     
        </div>
  </div>
      </div>
</div>
            </div>

            <?php 
            die(); 
            ?>
           
             </div>

         <?php 
        }
    }

}    