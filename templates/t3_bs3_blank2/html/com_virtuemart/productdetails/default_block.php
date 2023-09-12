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
 <div class="bs-docs-example3">
    <?php  if ($this->product->product_desc || !empty($this->product->customfieldsSorted['tags']) ) { ?>
      	<h3 class="module-title">
            <?php echo JText::_('COM_VIRTUEMART_PRODUCT_DESC_TITLE'); ?>
        </h3>
        <div class="block-inner">
          <?php echo '<div class="desc">' .$this->product->product_desc.'</div>'; ?>
             <?php
		  		 if (!empty($this->product->customfieldsSorted['tags'])) {
				$this->position = 'tags';
				echo '<div class="tags">' .$this->loadTemplate('tags').'</div>';
				 }
			// Product custom ?>
        </div>
    <?php } ?>
                
    <?php  if (!empty($this->product->customfieldsSorted['filter']) || !empty($this->product->customfieldsSorted['normal']) ) { ?>
              	<h3 class="module-title">
                	<?php echo JText::_('COM_VIRTUEMART_PRODUCT_SPECIFICATIONS'); ?>
                </h3>
                    <div class="block-inner">
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
                <?php } ?>
                
                <?php if ($this->allowRating || $this->showReview) { ?>
                  <h3 class="module-title">
                      <?php echo  JText::_ ('COM_VIRTUEMART_REVIEWS'); ?>
                   </h3>
                    <div class="block-inner">
                 	  <?php echo $this->loadTemplate('reviews');  ?>
                    </div>
                <?php } ?>
                 <?php if ($this->allowRating || $this->showReview) { ?>
                  	<h3 class="module-title">
                      <?php echo  JText::_ ('COM_VIRTUEMART_COMENTS'); ?>
                     </h3>
                    <div class="block-inner">
                 	 <?php // onContentAfterDisplay event
						echo $this->product->event->afterDisplayContent; 
						
						$comments = JPATH_ROOT . '/components/com_jcomments/jcomments.php';
							if (file_exists($comments)) {
								require_once($comments);
								echo JComments::showComments($this->product->virtuemart_product_id, 'com_virtuemart', $this->product->product_name);
							}
						?>
                    </div>
                <?php } ?>
                
                <?php if (!empty($this->product->customfieldsSorted['custom'])) { ?>
                  	<h3 class="module-title">
                      <?php echo  JText::_ ('COM_VIRTUEMART_CUSTOM_TAB'); ?>
                  	</h3>
                    <div class="block-inner">
                 	  <?php
					   
						$this->position = 'custom';
						echo '<div class="custom">' .$this->loadTemplate('custom').'</div>';
						// Product custom ?>
                    </div>
                <?php } ?>
                
                 <?php if (!empty($this->product->customfieldsSorted['video'])) { ?>
                 <h3 class="module-title">
                      <?php echo  JText::_ ('COM_VIRTUEMART_VIDEO'); ?>
                    </h3>
                  
                    <div class="block-inner">
                 	  <?php
					   
							$this->position = 'video';
							echo '<div class="video">' .$this->loadTemplate('video').'</div>';
						// Product custom ?>
                    </div>
                <?php } ?>
</div>