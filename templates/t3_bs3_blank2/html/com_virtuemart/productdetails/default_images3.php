<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen

 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_images.php 6188 2012-06-29 09:38:30Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
	$app = JFactory::getApplication();
	$doc = JFactory::getDocument();
    $templateparams = $app->getTemplate('site')->params;
	$politeloading = $templateparams->get('politeloading');
    $lblsale = $templateparams->get('lblsale');
    $lblhot = $templateparams->get('lblhot');
    $lblhotcount = $templateparams->get('lblhotcount');
    $lbloffer = $templateparams->get('lbloffer');
    $lblsold = $templateparams->get('lblsold');
    $lblnew = $templateparams->get('lblnew');
    $latest_products_days = $templateparams->get('lblnewcount');
	$template = $app->getTemplate();
	$gpath = $this->baseurl."/templates/".$template ;
		
    ?>
    <?php   
        $images = $this->product->images;
        $main_image_url = JURI::root().''.$images[0]->file_url;// [file_title][file_description][file_meta]
        $main_image_url2 = JURI::root().''.$images[0]->file_url_thumb;
            if ($images[0]->published){
                $main_image_url = JURI::root(true).'/'.$images[0]->file_url;
            }else {
                $main_image_url = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
                }
                
            if ($images[0]->published){
                $main_image_url2 = JURI::root(true).'/'.$this->product->images[0]->getFileUrlThumb();
            }else {
                $main_image_url2 = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
                }

        $main_image_title = $images[0]->file_title;// [file_title][file_description][file_meta]
        $main_image_description = $images[0]->file_description;// [file_title][file_description][file_meta]
        $main_image_alt = $images[0]->file_meta;// [file_title][file_description][file_meta]
        $vm_id = $this->product->virtuemart_product_id;
        $discont = $this->product->prices['discountAmount'];
        $discont = abs($discont);
        if (!empty($this->product->images[0])) { ?>
 
<div class="image_show_lightgallery">  
    <div class="demo-gallery">
        <ul id="lightgallery" class="list-unstyled">
            <li class="main-image light" data-responsive="<?php echo $main_image_url; ?>" data-src="<?php echo $main_image_url; ?>">
            <div class='zoomlupa photo'></div>
                 <div class="lbl-box2">
                    <?php
                    error_reporting('E_ALL');
                    //var_dump($product->created_on);
                    //$dataNew = explode(' ', $this->product->created_on);
                    //$dataNew=$dataNew[0];
                    //$dataNewOut = date('Y-m-d', strtotime($dataNew . " + ".$latest_products_days." day"));
                    if($lblnew){
                        $str_date = explode(' ', $this->product->created_on);
                        $dataN = explode("-", $str_date[0]);
                        $dataNew =  mktime(0, 0, 0, $dataN[1],$dataN[2], $dataN[0]);
                        $dataNewOut = $dataNew + 60*60*24*$latest_products_days;
                    }
                    //var_dump($dataNew).'</br>';
                    //var_dump($dataNewOut);
                    $stockhandle = VmConfig::get ('stockhandle', 'none');
                    if ((($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($this->product->product_in_stock - $this->product->product_ordered) < 1) || 
                            (($this->product->product_in_stock - $this->product->product_ordered) < $this->product->min_order_level ))&& $lblsold)  { ?>
                       
                        <div class="sold"><?php echo JText::_('DR_SOLD');?></div>
                     <?php }elseif ((time() - $result < $dataNewOut ) && $lblnew ){ ?>
                           
                         <div class="new"><?php echo JText::_('DR_NEW');?></div>
                     <?php } ?>   
                         
                     </div>
                <div class="lbl-box">
                    <?php if ($lbloffer && $this->product->prices['override'] == 1 && ($this->product->prices['product_price_publish_down'] > 0)){ ?>
                    <div class="discount limited"><?php echo JText::_('DR_LIMITED_OFFER');?></div>
                      <?php } elseif($discont >0 && $this->product->product_sales < $lblhotcount && $lblsale ) { ?>
                    <div class="discount"><?php echo JText::_('DR_SALE');?></div>
                        <?php } elseif ($lblhot && $this->product->product_sales > $lblhotcount) {?>
                          <div class="hit"><?php echo JText::_('DR_HOT');?></div>
                          <?php } ?>
                          </div>
                    <a class="jg-entry" href="">
                        <img class="img-responsive"  src="<?php echo $main_image_url ?>"  title="<?php echo $main_image_title ?>"   alt="<?php echo $main_image_alt ?>"/>
                    </a>        
                </li>    
               <?php 
                 $j = count($images);
                //add HTML
                if($j >0){ ?>
                    <?php 
                    for($i=1; $i<$j; $i++){ 
                        if ($this->product->images[$i]->published){
                            $main_image_url = JURI::root(true).'/'.$this->product->images[$i]->file_url;
                        }else {
                            $main_image_url = JURI::root().'components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
                        }
                        if ($this->product->images[$i]->published){
                            $main_image_url_th = JURI::root(true).'/'. $this->product->images[$i]->getFileUrlThumb();
                        }else {
                            $main_image_url_th = JURI::root(true).'/components/com_virtuemart/assets/images/vmgeneral/'.VmConfig::get('no_image_set');
                        } ?>
                        <li class="small" data-responsive="<?php echo $main_image_url; ?>" data-src="<?php echo $main_image_url; ?>" >
                          <a class="jg-entry" href="">
                              <img class="img-responsive" src="<?php echo $main_image_url_th; ?>"  alt="<?php echo $images[$i]->file_meta; ?>" />
                          </a>
                        </li>
                <?php } ?>
            <?php  } ?>
        </ul>
    </div>
</div>
<?php  } ?>
<link rel='stylesheet prefetch' href='<?php echo $gpath ?>/css/prodstyle/default-skin.css'>
<script type="text/javascript" src="<?php echo $gpath ?>/js/prodstyle/lightgallery.min.js"></script>
<script type="text/javascript" src="<?php echo $gpath ?>/js/prodstyle/lightgalleryinit.js"></script>


