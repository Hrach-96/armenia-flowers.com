<?php
/**
 * sublayout products
 *
 * @package	VirtueMart
 * @author Max Milbers
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2014 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL2, see LICENSE.php
 * @version $Id: cart.php 7682 2014-02-26 17:07:20Z Milbo $
 */

defined('_JEXEC') or die('Restricted access');
$products_per_row = empty($viewData['products_per_row'])? 1:$viewData['products_per_row'] ;
$products_count = $viewData['products_count'];
$count_holder = $viewData['count_holder'];
$isotopevmart = $viewData['isotopevmart'];
$itemHeight = $viewData['itemHeight'];
$itemWidth = $viewData['itemWidth'];
$count_holder_tag = $viewData['count_holder_tag'];
$html = $viewData['html'];
$count_holder_wishlist = $viewData['count_holder_wishlist'];
$remove_wishlist = $viewData['remove_wishlist'];
//print_r($remove_wishlist);
//print_r($products_count);
$currency = $viewData['currency'];
$showRating = $viewData['showRating'];

$verticalseparator = " vertical-separator";
echo shopFunctionsF::renderVmSubLayout('askrecomjs');

$ItemidStr = '';
$Itemid = shopFunctionsF::getLastVisitedItemId();
if(!empty($Itemid)){
	$ItemidStr = '&Itemid='.$Itemid;
}
jimport('joomla.filesystem.file');
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
$showdesc = $templateparams->get('showdesc');
$showdesccount = $templateparams->get('showdesccount');
$category_list_style = $templateparams->get('category_list_style','style_1');
$showcompare = $templateparams->get('showcompare');
$showwishlist = $templateparams->get('showwishlist');
$showquick = $templateparams->get('showquick');



$view_cat = JRequest::getString('view', null);
$option_cat = JRequest::getString('option', null);
if ($view_cat=='category' && $option_cat=='com_virtuemart'){
  $moduleParams = 'view_category';
} else {
$randnumber = mt_rand(2,2000); 
$moduleParams = 'mod_prod'.$count_holder.$randnumber;
}
//print_r($module);
//$param = $moduleParams->get('moduleclass_sfx','');
$dynamic = false;
if (vRequest::getInt('dynamic',false)) {
  $dynamic = true;
}
if(isset($viewData['products']['featured'])) {
  unset($viewData['products']['featured']);
}
if(isset($viewData['products']['discontinued'])) {
  unset($viewData['products']['discontinued']);
}
if(isset($viewData['products']['latest'])) {
  unset($viewData['products']['latest']);
}
if(isset($viewData['products']['topten'])) {
  unset($viewData['products']['topten']);
}
if(isset($viewData['products']['recent'])) {
  unset($viewData['products']['recent']);
}
foreach ($viewData['products'] as $type => $products ) {

	$rowsHeight = shopFunctionsF::calculateProductRowsHeights($products,$currency,$products_per_row);



	// Calculating Products Per Row
  $cellwidth = ' width'.floor ( 100 / $products_per_row );

  $BrowseTotalProducts = count($products);

  $col = 1;
  $nb = 1;
  $row = 1;

	foreach ( $products as $product ) {
     $discont = $product->prices[discountAmount];
  $discont = abs($discont);
  foreach ($product->categoryItem as $key=>$prod_cat) {
    $virtuemart_category_id=$prod_cat['virtuemart_category_id'];
  }
	$ratingModel = VmModel::getModel('ratings');
	$productModel = VmModel::getModel('product');
  $categoryModel = VmModel::getModel('category');
	$productModel->addImages($product);
   $catTag=" ";
   $currentCat = $categoryModel->getCategory($virtuemart_category_id);
  foreach($currentCat->parents as $catParent)
  {
    $catTag .= "categoryid-".$catParent->virtuemart_category_id . " ";
  }
  // sortby  data tag 
  $price = $product->prices['salesPrice'];
  $dataSort= " data-pname=\"$product->product_name\" data-pprice=\"$price\" data-pordered=\"$product->product_ordered\" data-pcreated=\"$product->created_on\"";
    // this is an indicator wether a row needs to be opened or not
    if ($col == 1) { 
      if ($isotopevmart == 'isotopevmart'){ ?>
        <li class="itemmart <?php echo $catTag ?>" data-category="<?php echo $catTag;?>" style="width:<?php echo $itemWidth; ?>px;height:<?php echo $itemHeight; ?>px;"  <?php echo $dataSort;?>>
      <?php }else { ?>
        <li>
      <?php
      }
      ?>

    
    <?php }

    // Show the vertical seperator
    if ($nb == $products_per_row or $nb % $products_per_row == 0) {
      $show_vertical_separator = ' ';
    } else {
      $show_vertical_separator = $verticalseparator;
    } ?>

    <div class="prod-row <?php if($remove_wishlist) { echo "wishlists_prods_".$product->virtuemart_product_id;} ?>">
     <div class="product-box hover back_w spacer <?php if ($discont>0) { echo 'disc';} if ($category_list_style == 'style_1'){echo ' style_1';}elseif ($category_list_style == 'style_2'){echo ' style_2';}else {echo ' style_3';} ?> ">
      <?php if ($showquick) {?>
      <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/> 
      <?php } ?>
      <div class="browseImage ">
      <?php 
      if ($product->prices['override'] == 1 && ($product->prices['product_price_publish_down'] > 0)){
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
        <div class="count_holder_small">
        <div class="count_info"><?php echo JText::_('DR_LIMITED2')?></div>
        <div id="CountSmall<?php echo $moduleParams.$count_holder_tag.$count_holder_wishlist; ?><?php echo $product->virtuemart_product_id ?>" class="count_border">
         <script type="text/javascript">
        jQuery(function () {    
          jQuery('#CountSmall<?php echo $moduleParams.$count_holder_tag.$count_holder_wishlist ?><?php echo $product->virtuemart_product_id; ?>').countdowns({
            until: new Date(<?php echo $year; ?>, <?php echo $month; ?> - 1, <?php echo $data; ?>), 
            labels: ['Years', 'Months', 'Weeks', '<?php echo JText::_('DR_DAYS')?>', '<?php echo JText::_('DR_HOURS')?>', '<?php echo JText::_('DR_MINUTES')?>', '<?php echo JText::_('DR_SECONDS')?>'],
            labels1:['Years','Months','Weeks','<?php echo JText::_('DR_DAYS')?>','<?php echo JText::_('DR_HOURS')?>','<?php echo JText::_('DR_MINUTES')?>','<?php echo JText::_('DR_SECONDS')?>'],
            compact: false});
        });
         </script>
         </div>
                 <div class="bzSaleTimerDesc"><?php echo JText::_('DR_HURRY'); ?><div>&nbsp;<strong><?php echo $product->product_in_stock ?></strong>&nbsp;<?php echo JText::_('DR_HURRY_ITEMS'); ?></div></div>
         </div>
        <?php } ?>
    <div class="lbl-box2">
   <?php
    //$dataNew = explode(' ', $product->created_on);
    //$dataNew=$dataNew[0];
    //$dataNewOut = date('Y-m-d', strtotime($dataNew . " + ".$latest_products_days." day"));
    
    $str_date = explode(' ', $product->created_on);
    $dataN = explode("-", $str_date[0]);
    $dataNew =  mktime(0, 0, 0, $dataN[1],$dataN[2], $dataN[0]);
    $dataNewOut = $dataNew + 60*60*24*$latest_products_days;
   // var_dump($product->created_on).'</br>';
   // var_dump($dataNewOut);
    $stockhandle = VmConfig::get ('stockhandle', 'none');
    //var_dump($lblsold);
    if ((($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($product->product_in_stock - $product->product_ordered) < 1) || 
            (($product->product_in_stock - $product->product_ordered) < $product->min_order_level ))&& $lblsold)  { ?>
        <div class="sold"><?php echo JText::_('DR_SOL');?></div>
     <?php }elseif ((time() - $result < $dataNewOut ) && $lblnew ){ ?>
     <div class="new"><?php echo JText::_('DR_NEW');?></div>
     <?php } ?>    
     </div>
    <div class="lbl-box">
  <?php if ($lbloffer && $product->prices['override'] == 1 && ($product->prices['product_price_publish_down'] > 0)){ ?>
    <div class="limited"><?php echo JText::_('DR_LIMITED_OFFER');?></div>
      <?php } elseif($discont >0 && $product->product_sales < $lblhotcount && $lblsale ) { ?>
    <div class="discount"><?php echo JText::_('DR_SALE');?></div>
<?php } elseif ($lblhot && $product->product_sales > $lblhotcount) {?>
          <div class="hit"><?php echo JText::_('DR_HOT');?></div>
          <?php } ?>
          </div>
          <?php if ($category_list_style == 'style_1' || $category_list_style == 'style_2'){ ?>
      <div class="img-wrapper big <?php if ($product->images[1]->published){ echo 'second';}else{echo 'first';} ?>">
             <?php 
            $images = $product->images;
            $main_image_title = $images[0]->file_title;
            $main_image_alt = $images[0]->file_meta;
            if ($product->images[0]->published){
              $main_image_url1 = JURI::root().''.$product->images[0]->getFileUrlThumb();
              if($politeloading=='1') {
                $main_image_url1_p = 'images/stories/virtuemart/preloader.gif';
              }else {
                $main_image_url1_p = JURI::root().''.$product->images[0]->getFileUrlThumb();
              }
            }else {
              $main_image_url1 = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
            }
            if ($product->images[1]->published){
              $main_image_url2 = JURI::root().''.$product->images[1]->getFileUrlThumb();
              if($politeloading=='1') {
                $main_image_url2_p = 'images/stories/virtuemart/preloader.gif';
              }else {
                $main_image_url2_p = JURI::root().''.$product->images[1]->getFileUrlThumb();
              }
            }else {
              $main_image_url2 = $main_image_url1;
            }
      $image = '<div class="front"><img data-original="'.$main_image_url1 .'"  src="'.$main_image_url1_p.'"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" /></div>';
      $image2 = '<div class="back"><img data-original="'.$main_image_url2 .'"  src="'.$main_image_url2_p.'"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst"/></div>';
      ?>

         <?php
                      
            
           echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id),''.$image.''.$image2.'');
        ?>
                </div>
                <?php } ?>
        <?php if ($category_list_style == 'style_3'){ ?>
                <div id="fancylist<?php echo $moduleParams.$count_holder_tag.$count_holder_wishlist; ?><?php echo $product->virtuemart_product_id ?>" class="img-wrapper">

                  <a class="fancybox-style fancybox-thumb" rel="fancybox-thumb" title="<?php echo $product->images[0]->file_title ?>" href="<?php echo $product->images[0]->file_url ;?>">
                    <?php
                      echo $product->images[0]->displayMediaThumb('class="lazy browseProductImage"', false);
                    ?>
                    </a>
                    <div class="second">
                    <?php 
                      $j = count($product->images);
                      for($i = 1; $i<$j; $i++){ ?>
                      <a class="fancybox-thumb" rel="fancybox-thumb" title="<?php echo $product->images[$i]->file_title ?>" href="<?php echo $product->images[$i]->file_url ;?>">
                         <?php  //echo $product->images[$i]->displayMediaThumb('class="lazy"', false); ?>
                      </a>    
                     <?php }
                    ?>
                    </div>
                  

              </div>
        <?php } ?>      
                
  </div>  
    <div class="slide-hover">
    	<div class="wrapper">
         <?php if ( VmConfig::get ('display_stock', 1)) { ?>
            <!--            if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
            <div class="paddingtop8">
              <span class="vmicon vm2-<?php if ($product->product_in_stock - $product->product_ordered <1){echo 'nostock';} elseif(($product->product_in_stock - $product->product_ordered )<= $product->low_stock_notification){echo 'lowstock';} elseif(($product->product_in_stock - $product->product_ordered )> $product->low_stock_notification){echo 'normalstock';}  ?>"></span>
              <span class="stock-level"><?php echo vmText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
            </div>
          <?php } ?>
            <div class="Title">
            <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
            </div>
            <?php // Product Short Description
              if(!empty($product->product_s_desc)) { ?>
                    <div class="description-list"><?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, $showdesccount, '...') ?></div>
              <?php }?>  
             <?php if ($showdesc) {?>
              <?php // Product Short Description
              if(!empty($product->product_s_desc)) { ?>
                    <div class="description"><?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, $showdesccount, '...') ?></div>
              <?php }?>  
              <?php }?>           
				 <?php
          if (( !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
        <div class="Price">
          <?php
                    echo shopFunctionsF::renderVmSubLayout('pricescategory',array('product'=>$product,'currency'=>$currency)); ?>
        <?php
      if ($product->prices['basePriceWithTax']>0 && $discont >0) 
            //echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePrice','',$product->prices,true) . '</span>';

          if ($product->prices['salesPrice']>0)
            //echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$product->prices,true) . '</span>';
        ?>      
        </div>
  <?php } 
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
                                                
                <span class="vote">
                    <span title="" class="vmicon ratingbox" style="display:inline-block;">
                        <span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
                        </span>
                    </span>
                </span>
       		 <?php }  ?>								
              
		</div>
         
			<?php 
          if($html)  {  
            foreach($html as $prods){
              if ($product->virtuemart_product_id == $prods->virtuemart_product_id){
      
                       echo '<div class="product_tags" >';
                $sep_tags = explode(',',$prods->accented_tags);
                  echo '<i class="icon-tags" title="'.JText::_('COM_COOLTAGS_TAGS').'"  class="hasTooltip" ></i> ';
                  for($i=0; $i< count($sep_tags);$i++){
                    if($sep_tags[$i] !='' && $sep_tags[$i]!=' ')
                      echo '<a class="vm_tags" href="'.JRoute::_('index.php?option=com_cooltags&view=productslist&tag='.$sep_tags[$i].'&Itemid='.$cooltags_itemid).'">'.$sep_tags[$i].'</a>&nbsp; ';
                  }
                echo '</div>';  
              }
            } 
          }
              ?>
		  <div class="clearfix"></div>
    
       <?php //echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product)); ?>

    	
        <div class="wrapper-slide product-actions">
                       <?php 
       if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) {  $askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id . '&tmpl=component', FALSE);
        ?>
                  <div class="call-a-question add-to-cart">
                                      <a title="<?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?>" class="hasTooltips call askquestion2 addtocart-button"  data-fancybox-type="iframe" href="<?php echo $askquestion_url ?>" rel="nofollow" ><i class="fa fa-shopping-cart"></i><span class="action-name"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></span></a>
                                    </div>
                  <?php } else {
                    echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product));
                  } ?>
              <?php if ($showwishlist) {?>
              <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php")){  ?>
                 <div class="add-to-favorites wishlist list_wishlists<?php echo $product->virtuemart_product_id;?>">
                    <?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php"); ?>
                 </div>
               <?php } ?>    
               <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php")){  ?>
                   <div class="hidden add-to-favorites remwishlists  list_wishlists<?php echo $product->virtuemart_product_id;?>">
                        <a class="wishlist_del add_wishlist " title="remove"  onclick="removeWishlists('<?php echo $product->virtuemart_product_id ;?>');"><i class="fa fa-times"></i><span class="action-name"><?php echo JText::_('REMOVE'); ?></span></a>
                   </div>
                 <?php } ?>
            <?php } ?>      
            <?php if ($showcompare) {?>            
              <?php if(is_file(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php")){  ?>
                <div class="add-to-compare jClever compare_cat list_compare<?php echo $product->virtuemart_product_id;?>">
                  <?php require(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php"); ?>
                </div>
              <?php } ?>
            <?php } ?>              
      </div>
      <?php if(vRequest::getInt('dynamic')){
        echo vmJsApi::writeJS();
      } ?>
      </div>
    </div>
	</div>
  <?php
    $nb ++;

      // Do we need to close the current row now?
      if ($col == $products_per_row || $nb>$BrowseTotalProducts) { ?>
        </li>
      <?php
        $col = 1;
        $row++;
    } else {
      $col ++;
    }
    
    // }
    }
  } ?>
  