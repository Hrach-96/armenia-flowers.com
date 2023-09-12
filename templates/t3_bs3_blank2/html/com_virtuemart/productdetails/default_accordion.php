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
 * @version $Id: default_customfields.php 5699 2012-03-22 08:26:48Z ondrejspilka $
 */

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );
?>
 <div class="bs-docs-example2">
              <div class="accordion" id="accordion2">
             <?php  if ($this->product->product_desc || !empty($this->product->customfieldsSorted['tags']) ) { ?>
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    <?php echo JText::_('COM_VIRTUEMART_PRODUCT_DESC_TITLE'); ?>
                    <span class="VmArrowdown"><i class="plus">+</i><i class="minus">-</i></span>
                    </a>
                  </div>
                  <div id="collapseOne" class="accordion-body collapse in">
                    <div class="accordion-inner">
                      <?php echo '<div class="desc">' .$this->product->product_desc.'</div>'; ?>
                         <?php
					  		 if (!empty($this->product->customfieldsSorted['tags'])) {
							$this->position = 'tags';
							echo '<div class="tags">' .$this->loadTemplate('tags').'</div>';
							 }
						// Product custom ?>
                    </div>
                  </div>
                </div>
                <?php } ?>
                
    <?php  if (!empty($this->product->customfieldsSorted['filter']) || !empty($this->product->customfieldsSorted['normal']) ) { ?>
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
                    <?php echo JText::_('COM_VIRTUEMART_PRODUCT_SPECIFICATIONS'); ?>
                     <span class="VmArrowdown"><i class="plus">+</i><i class="minus">-</i></span>
                    </a>
                  </div>
                  <div id="collapseSeven" class="accordion-body collapse">
                    <div class="accordion-inner">
                     <?php
					   if (!empty($this->product->customfieldsSorted['filter']) || !empty($this->product->customfieldsSorted['normal'])) { ?>
                       <div class="filter">
						   <?php
						 if (!empty($this->product->customfieldsSorted['filter'])) {
							 $this->position = 'filter';
							 echo $this->loadTemplate('filter');
							 echo '</br>';
						 }
						 if (!empty($this->product->customfieldsSorted['normal'])) {
							 $this->position = 'normal';
							 echo $this->loadTemplate('customfields');
						 } ?>
							</div>
						<?php } // Product custom ?>
                        
                    </div>
                  </div>
                </div>
                <?php } ?>
                
                <?php if ($this->allowRating || $this->showReview) { ?>
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                      <?php echo  JText::_ ('COM_VIRTUEMART_REVIEWS'); ?>
                      <span class="VmArrowdown"><i class="plus">+</i><i class="minus">-</i></span>
                    </a>
                  </div>
                  <div id="collapseTwo" class="accordion-body collapse">
                    <div class="accordion-inner">
                 	  <?php echo $this->loadTemplate('reviews');  ?>
                    </div>
                  </div>
                </div>
                <?php } ?>
                 <?php if ($this->allowRating || $this->showReview) { ?>
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwoComents">
                      <?php echo  JText::_ ('COM_VIRTUEMART_COMENTS'); ?>
                      <span class="VmArrowdown"><i class="plus">+</i><i class="minus">-</i></span>
                    </a>
                  </div>
                  <div id="collapseTwoComents" class="accordion-body collapse">
                    <div class="accordion-inner">
                 	 <?php // onContentAfterDisplay event
						echo $this->product->event->afterDisplayContent; 
						
						$comments = JPATH_ROOT . '/components/com_jcomments/jcomments.php';
							if (file_exists($comments)) {
								require_once($comments);
								echo JComments::showComments($this->product->virtuemart_product_id, 'com_virtuemart', $this->product->product_name);
							}
						?>
                    </div>
                  </div>
                </div>
                <?php } ?>
                
                <?php if (!empty($this->product->customfieldsSorted['custom'])) { ?>
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                      <?php echo  JText::_ ('COM_VIRTUEMART_CUSTOM_TAB'); ?>
                      <span class="VmArrowdown"><i class="plus">+</i><i class="minus">-</i></span>
                    </a>
                  </div>
                  <div id="collapseFour" class="accordion-body collapse">
                    <div class="accordion-inner">
                 	  <?php
					   
							$this->position = 'custom';
							echo '<div class="custom">' .$this->loadTemplate('custom').'</div>';
						// Product custom ?>
                    </div>
                  </div>
                </div>
                <?php } ?>
                
                 <?php if (!empty($this->product->customfieldsSorted['video'])) { ?>
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                      <?php echo  JText::_ ('COM_VIRTUEMART_VIDEO'); ?>
                       <span class="VmArrowdown"><i class="plus">+</i><i class="minus">-</i></span>
                    </a>
                  </div>
                  <div id="collapseFive" class="accordion-body collapse">
                    <div class="accordion-inner">
                 	  <?php
					   
							$this->position = 'video';
							echo '<div class="video">' .$this->loadTemplate('video').'</div>';
						// Product custom ?>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>