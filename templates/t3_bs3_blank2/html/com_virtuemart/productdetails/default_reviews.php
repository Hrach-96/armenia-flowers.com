<?php
/**
 *
 * Show the product details page
 *
 * @package    VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_reviews.php 6300 2012-07-26 00:40:10Z Milbo $
 */

// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die ('Restricted access');

// Customer Reviews
if ($this->allowRating || $this->showReview) {
	$maxrating = VmConfig::get ('vm_maximum_rating_scale', 5);
	$ratingsShow = VmConfig::get ('vm_num_ratings_show', 3); // TODO add  vm_num_ratings_show in vmConfig
	$stars = array();
	$showall = JRequest::getBool ('showall', FALSE);
	$ratingWidth = $maxrating * 17;
	for ($num = 0; $num <= $maxrating; $num++) {
		$stars[] = '
				<span title="' . (JText::_ ("COM_VIRTUEMART_RATING_TITLE") . $num . '/' . $maxrating) . '" class="vmicon ratingbox" style="display:inline-block;width:' . 17 * $maxrating . 'px;">
					<span class="stars-orange" style="width:' . (17 * $num) . 'px">
					</span>
				</span>';
	} ?>
	<div class="customer-reviews">
		<form method="post" action="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id); ?>" name="reviewForm" id="reviewform">
	<?php
}

if ($this->showReview) {

	?>
    	
	<div class="list-reviews">
    <h4><?php echo JText::_ ('LAST_REVIEW'); ?></h4>
    <ul class="scroll-pane reviews-pagination">
    
		<?php
		$i = 0;
		$review_editable = TRUE;
		$reviews_published = 0;
		if ($this->rating_reviews) {
			foreach ($this->rating_reviews as $review) {
				if ($i % 2 == 0) {
					$color = 'rnormal';
				} else {
					$color = 'rnormal more';
				}

				/* Check if user already commented */
				// if ($review->virtuemart_userid == $this->user->id ) {
				if ($review->created_by == $this->user->id && !$review->review_editable) {
					$review_editable = FALSE;
				}
				?>
				<?php // Loop through all reviews
				if (!empty($this->rating_reviews) && $review->published) {
					$reviews_published++;
					?>
					<li class="<?php echo $color ?>">
                    <div class="wrapper">
                    	<div class="flleft">
                            <span class="rbold"><?php echo $review->customer ?></span>
                            <span class="rdate"><?php echo JHTML::date ($review->created_on, JText::_ ('DATE_FORMAT_LC')); ?></span>
                        </div>
                        <div class="flright">
                        	<span class="rvote"><?php echo $stars[(int)$review->review_rating] ?></span>
                         </div>
                    </div>
                    <div class="coment">
                  		<?php echo $review->comment; ?>
                    </div>
					</li>
					<?php
				}
				$i++;
				//if ($i == $ratingsShow && !$showall) {
					/* Show all reviews ? */
					//if ($reviews_published >= $ratingsShow) {
						//$attribute = array('class'=> 'details', 'title'=> JText::_ ('COM_VIRTUEMART_MORE_REVIEWS'));
						//echo JHTML::link ($this->more_reviews, JText::_ ('COM_VIRTUEMART_MORE_REVIEWS'), $attribute);
					//}
					//break;
				//}
			}

		} else {
			// "There are no reviews for this product"
			?>
			<span class="step"><?php echo JText::_ ('COM_VIRTUEMART_NO_REVIEWS') ?></span>
			<?php
		}  ?>
         </ul>
	</div>

		<div class="write-reviews">

			<?php // Show Review Length While Your Are Writing
			$reviewJavascript = "
			function check_reviewform() {
				var form = document.getElementById('reviewform');

				var ausgewaehlt = false;

				// for (var i=0; i<form.vote.length; i++) {
					// if (form.vote[i].checked) {
						// ausgewaehlt = true;
					// }
				// }
					// if (!ausgewaehlt)  {
						// alert('" . JText::_ ('COM_VIRTUEMART_REVIEW_ERR_RATE', FALSE) . "');
						// return false;
					// }
					//else
					if (form.comment.value.length < " . VmConfig::get ('reviews_minimum_comment_length', 100) . ") {
						alert('" . addslashes (JText::sprintf ('COM_VIRTUEMART_REVIEW_ERR_COMMENT1_JS', VmConfig::get ('reviews_minimum_comment_length', 100))) . "');
						return false;
					}
					else if (form.comment.value.length > " . VmConfig::get ('reviews_maximum_comment_length', 2000) . ") {
						alert('" . addslashes (JText::sprintf ('COM_VIRTUEMART_REVIEW_ERR_COMMENT2_JS', VmConfig::get ('reviews_maximum_comment_length', 2000))) . "');
						return false;
					}
					else {
						return true;
					}
				}

				function refresh_counter() {
					var form = document.getElementById('reviewform');
					form.counter.value= form.comment.value.length;
				}
				jQuery(function($) {
					var steps = ".$maxrating.";
					var parentPos= $('.write-reviews .ratingbox').position();
					var boxWidth = $('.write-reviews .ratingbox').width();// nbr of total pixels
					var starSize = (boxWidth/steps);
					var ratingboxPos= $('.write-reviews .ratingbox').offset();
					var ratingbox=$('.write-reviews .ratingbox')
						$('.write-reviews .ratingbox').mousemove( function(e){
							var span = $(this).children();
							var dif = Math.floor(e.pageX-ratingbox.offset().left); 
							difRatio = Math.floor(dif/boxWidth* steps )+1; //step
							span.width(difRatio*starSize);
							$('#vote').val(difRatio);
							//console.log('note = ', difRatio);
							
						});
						$('.write-reviews .ratingbox').click(function(){
					    $('.button_vote').click();});
				});


				";
			$document = JFactory::getDocument ();
			$document->addScriptDeclaration ($reviewJavascript);
			
			
				?>
                <?php if ($review_editable) { 
					echo '';
				} else {
					echo '<strong class="user">' . JText::_ ('COM_VIRTUEMART_DEAR') . $this->user->name . ',</strong>';
					echo JText::_ ('COM_VIRTUEMART_REVIEW_ALREADYDONE');
					echo '<br /><br />';
			}
			?>
				<span class="step"><?php echo JText::sprintf ('COM_VIRTUEMART_REVIEW_COMMENT', VmConfig::get ('reviews_minimum_comment_length', 100), VmConfig::get ('reviews_maximum_comment_length', 2000)); ?></span>
                
                <textarea class="virtuemart" title="<?php echo JText::_ ('COM_VIRTUEMART_WRITE_REVIEW') ?>" class="inputbox" id="comment" onblur="refresh_counter();" onfocus="refresh_counter();" onkeyup="refresh_counter();" name="comment" rows="5" cols="60"><?php if (!empty($this->review->comment)) {
					echo '';
				} ?></textarea>
               
                
                <div class="wrapper">
                <?php
                if ($this->showRating) {
					?>
					<span class="step"><?php echo JText::_ ('COM_VIRTUEMART_RATING_FIRST_RATE') ?></span>
					<span class="svrat"><?php echo JText::_ ('SV_VIRTUEMART_RATING') ?></span>
					<div class="clearfix"></div>
                    <div class="rating">
						<label class="vote" for="vote"><?php echo $stars[$maxrating]; ?></label>
						<input type="hidden" id="vote" value="<?php echo $maxrating ?>" name="vote">
					</div>

					<?php

			} ?>
				<div class="rcount"><?php echo JText::_ ('COM_VIRTUEMART_REVIEW_COUNT') ?>
					<input type="text" value="0" size="4" class="vm-default" name="counter" maxlength="4" readonly="readonly"/>
				</div>
                </div>
                <div class="clearfix"></div>
                <?php if ($this->allowRating && $review_editable) { ?>
				<input class="button reset2" type="submit" onclick="return( check_reviewform());" name="submit_review" title="<?php echo JText::_ ('COM_VIRTUEMART_REVIEW_SUBMIT')  ?>" value="<?php echo JText::_ ('COM_VIRTUEMART_REVIEW_SUBMIT')  ?>"/>
				<?php } ?>
			</div>
		<?php
	}

if ($this->allowRating || $this->showReview) {
	?>
	<input type="hidden" name="virtuemart_product_id" value="<?php echo $this->product->virtuemart_product_id; ?>"/>
	<input type="hidden" name="option" value="com_virtuemart"/>
	<input type="hidden" name="virtuemart_category_id" value="<?php echo JRequest::getInt ('virtuemart_category_id'); ?>"/>
	<input type="hidden" name="virtuemart_rating_review_id" value="0"/>
	<input type="hidden" name="task" value="review"/>
    	<?php } ?>

		</form>
	</div>
