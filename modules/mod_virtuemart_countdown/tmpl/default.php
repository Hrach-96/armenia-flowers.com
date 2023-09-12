<?php // no direct access
error_reporting('E_ALL');
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
$showdesc = $templateparams->get('showdesc');
$showdesccount = $templateparams->get('showdesccount');
	$pwidth= ' width100';
	$float="center";
	if (isset($product->step_order_level))
						$step=$product->step_order_level;
					else
						$step=1;
					if($step==0)
						$step=1;
					$alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step);
		  $discont = $product->prices['discountAmount'];
  $discont = abs($discont);
    $currency = CurrencyDisplay::getInstance();
  	$show_price = $currency->createPriceDiv('salesPrice', '', $product->prices,true);
  $showcompare = $templateparams->get('showcompare');
  $showwishlist = $templateparams->get('showwishlist');


	?>
<li class="items">
                       <div class="prod-row">
                       <div class="product-box hover hover back_w  spacer item <?php if ($discont>0) { echo 'disc';} ?> ">
                       <div class="left-img">
                            <div class="browseImage ">
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
                            if ((($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($product->product_in_stock - $product->product_ordered) < 1) || 
                                    (($product->product_in_stock - $product->product_ordered) < $product->min_order_level ))&& $lblsold)  { ?>
                                <div class="sold"><?php echo JText::_('DR_SOLD');?></div>
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
                                  <div class="img-wrapper">
                                   <?php
                                            $image = $product->images[0]->displayMediaFull('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ;
											if(!empty($product->images[1])){
											 $image2 = $product->images[1]->displayMediaFull('class="browseProductImage featuredProductImageSecond"  border="0"',false) ;
											} else {$image2= $product->images[0]->displayMediaFull('class="browseProductImage featuredProductImageSecond"  border="0"',false) ;}
                                            echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id),$image);
                                    ?>
                                    </div>
                                    
                            
                            
                            </div>  
                            </div>      
                            <div class="slide-hover">
                                <div class="wrapper">
                                            <div class="Title">
                                            <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'40','...'), array('title' => $product->product_name)); ?>
                                            </div>
                                            <div class="clear"></div>
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
                                 
                                <div class="clear"></div>
                                <?php // Product Short Description
									if(!empty($product->product_s_desc)) { ?>
									<div class="desc1"><?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, 200, '...') ?></div>
								<?php } ?>
                                </div>
                                <div class="time-box">
                                <div class="indent">
                               
                                 <?php if ((!empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
                                    <div class="price">
                                     <div class="product-price" id="productPrice<?php echo $product->virtuemart_product_id ?>">
                                    <?php
                                        if ($product->prices['salesPrice']>0) { ?>
                                    <span class="price-sale">
                                    <span class="text"><?php echo JText::_('DR_SPECIAL_DEAL_PRICE'); ?>:</span>
									<?php echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$product->prices,true) . '</span>';?>
                                    </span>
                                    <?php } ?>
                                    <?php
                                        if ($product->prices['basePrice']>0) { ?>
                                    <span class="price-old">
                                    <span class="text"><?php echo JText::_('DR_OLD_PRICE'); ?>:</span>
									<?php echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePrice','',$product->prices,true) . '</span>';?>
                                    </span>
                                    <?php } ?>
                                    <?php
                                       if ($discont>0)  { ?>
                                    <span class="price_save">
                                     <span class="text"><?php echo JText::_('DR_YOU_ARE_SAVING'); ?>:</span>
									<?php echo '<span class="discount">' . $currency->createPriceDiv('discountAmount','',$product->prices,true) . '</span>'; ?>
                                    </span>
                                    <?php } ?>
                                    <div class="clear" ></div>
                                    </div>
                                    </div>
                                <?php } ?> 
                                <?php
								// sale timer starts 
								include("timer.php");
								//sale timer ends
								?>
                                </div>
                               <div class="bzSaleTimerDesc"><?php echo JText::_('DR_HURRY'); ?><div>&nbsp;&nbsp;<?php echo $product->product_in_stock ?>&nbsp;<?php echo JText::_('DR_HURRY_ITEMS'); ?></div></div>
                                <div class="bzSaleTimerDesc2"><div><?php echo $product->product_ordered ?></div>&nbsp;&nbsp;<?php echo JText::_('DR_BOOKED'); ?> </div>
                                <div class="clear" ></div>
                                </div>
                                      <div class="wrapper-slide product-actions">
                                       <?php 
                       if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) {  
                        $askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id . '&tmpl=component', FALSE);
        ?>
                  <div class="call-a-question add-to-cart">
                                      <a title="<?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?>" class="call askquestion2 addtocart-button"  data-fancybox-type="iframe" href="<?php echo $askquestion_url ?>" rel="nofollow" ><i class="fa fa-shopping-cart"></i><span class="action-name"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></span></a>
                                    </div>
                                  <?php } 
                      if (!empty($show_price)){

               if ((!VmConfig::get('use_as_catalog', 0) and !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) {
            if (isset($product->step_order_level))
              $step=$product->step_order_level;
            else
              $step=1;
            if($step==0)
              $step=1;
            $alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step); ?>
                      <div class="addtocart-area2 add-to-cart">
                    <?php $stockhandle = VmConfig::get ('stockhandle', 'none');
                if (
                  ($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($product->product_in_stock - $product->product_ordered) < 1) || 
                (
                 ($product->product_in_stock - $product->product_ordered) < $product->min_order_level ))  { ?>
                        <span class="addtocart_button2">
                      <a class="addtocart-button" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id='.$product->virtuemart_product_id); ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?>"><i class="fa fa-shopping-cart"></i><span class="action-name"><?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?></span></a>
                                            </span>
                    <?php } else { ?>
                    <form method="post" class="product" action="<?php echo JURI::getInstance()->toString(); ?>" id="addtocartproduct<?php echo $product->virtuemart_product_id ?>">
                                         <input name="quantity" type="hidden" value="<?php echo $step ?>" />
                    <div class="addtocart-bar2">
                                        <script type="text/javascript">
                        function check(obj) {
                        // use the modulus operator '%' to see if there is a remainder
                        remainder=obj.value % <?php echo $step?>;
                        quantity=obj.value;
                        if (remainder  != 0) {
                          alert('<?php echo $alert?>!');
                          obj.value = quantity-remainder;
                          return false;
                          }
                        return true;
                        }
                    </script> 
                      <?php // Display the quantity box 
                       if (!empty($product->customfields)) {
                          foreach ($product->customfields as $k => $custom) {
                            if (!empty($custom->layout_pos)) {
                              $product->customfieldsSorted[$custom->layout_pos][] = $custom;
                              unset($product->customfields[$k]);
                            }
                          }
                          $product->customfieldsSorted['normal'] = $product->customfields;
                          unset($product->customfields);
                        }
                      $position = 'addtocart';
                      if (!empty($product->customfieldsSorted[$position])) { ?>
                                            <div class="addtocart_button2">
                      <?php echo JHTML::link($product->link, '<i class="fa fa-shopping-cart"></i><span class="action-name">'.JText::_('DR_VIRTUEMART_SELECT_OPTION').'</span>', array('title' =>JText::_('DR_VIRTUEMART_SELECT_OPTION'),'class' => 'addtocart-button')); ?>
                                          </div>
                    
                    <?php } else { ?>
                    <?php // Add the button
                      $button_lbl = JText::_('COM_VIRTUEMART_CART_ADD_TO');
                      $button_cls = 'addtocart-button cart-click'; //$button_cls = 'addtocart_button';
                    ?>
                      <?php // Display the add to cart button ?>
                      <div class="clear"></div>
                      <div class="addtocart_button2">
                        <?php if ($product->orderable) { ?>
                    <button type="submit" value="<?php echo $button_lbl ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_ADD_TO');?>" class="addtocart-button cart-click"><i class="fa fa-shopping-cart"></i><span class="action-name"><?php echo JText::_('COM_VIRTUEMART_CART_ADD_TO'); ?></span></button>
                    <?php }else { ?>
                    <span title="<?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT');?>" class="addtocart-button addtocart-button-disabled cart-click"><i class="fa fa-shopping-cart"></i><span class="action-name"><?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT'); ?></span></span>
                    <?php } ?>
                      </div>
                                            
                    <input type="hidden" class="pname" value="<?php echo $product->product_name ?>"/>
                    <input type="hidden" name="option" value="com_virtuemart" />
                    <input type="hidden" name="view" value="cart" />
                    <noscript><input type="hidden" name="task" value="add" /></noscript>
                     <input type="hidden" class="item_id" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>"/>
                    <input type="hidden" name="virtuemart_category_id[]" value="<?php echo $product->virtuemart_category_id ?>" />  
                    <?php }?>
                  </div>
                  </form>
                  <?php } ?>
                  </div>
                  <?php } } ?>
                      <?php if ($showwishlist) {?>
                        <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php")){  ?>
                           <div class="add-to-favorites wishlist list_wishlists<?php echo $product->virtuemart_product_id;?>">
                              <?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php"); ?>
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
                                </div>
                                <div class="clear"></div>
                            </div>
                            </div>
                           <div class="clear"></div>                    
					</li>