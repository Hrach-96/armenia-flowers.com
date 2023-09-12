<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Mainbody 1 columns, content only
 */

$option = JRequest::getString('option', null);
if($option == 'com_sppagebuilder') {?>
	<div id="t3-mainbody" class="container t3-mainbody" style="padding:0px;">
		<div class="row">
			<!-- MAIN CONTENT -->
			<div id="t3-content" class="t3-content col-xs-12">
				<?php if($this->hasMessage()) : ?>
				<jdoc:include type="message" />
				<?php endif ?>
			</div>
			<!-- //MAIN CONTENT -->

		</div>
	</div> 
	<jdoc:include type="component" />

<?php }else { ?>
<div id="t3-mainbody" class="container t3-mainbody">
	<div class="row">

		<!-- MAIN CONTENT -->
		<div id="t3-content" class="t3-content col-xs-12">
			<jdoc:include type="modules" name="<?php $this->_p('content-top') ?>" style="T3Xhtml" />
			<?php if($this->hasMessage()) : ?>
			<jdoc:include type="message" />
			<?php endif ?>
			<jdoc:include type="component" />
            <jdoc:include type="modules" name="<?php $this->_p('content-bottom') ?>" style="T3Xhtml" />
		</div>
		<!-- //MAIN CONTENT -->

	</div>
</div> 
<?php }
?>