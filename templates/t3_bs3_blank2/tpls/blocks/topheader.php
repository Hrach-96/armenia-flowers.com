<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="container cookies_height">
  <div class="cookies<?php $this->_c('cookies')?>">
  <jdoc:include type="modules" name="<?php $this->_p('cookie') ?>" />
  </div>
  </div>
<div class="header-top">
	<div class="header-top-border">
		<div class="top-header">
			<div class="container">
				<div class="row">

					<div class="mod-left col-md-8">
						<?php if ($this->countModules('topcall')) : ?>
						<div class="top-header-block1-custom<?php $this->_c('topcall')?>">   
			        		<jdoc:include type="modules" name="<?php $this->_p('topcall') ?>" style="raw" />
			        	</div>
			        	<?php endif ?>
		        	</div>

		        	<div class="mod-right col-md-4">
			        	<?php if ($this->countModules('topcomparelist')) : ?>
			        	<div class="top-header-block2-custom<?php $this->_c('topcomparelist')?>">   
			        		<jdoc:include type="modules" name="<?php $this->_p('topcomparelist') ?>" style="raw" />
			        	</div>
			        	<?php endif ?>
		        		<?php if ($this->countModules('topwishlist')) : ?>
			        	<div class="top-header-block3-custom<?php $this->_c('topwishlist')?>">   
			        		<jdoc:include type="modules" name="<?php $this->_p('topwishlist') ?>" style="raw" />
			        	</div>
			        	<?php endif ?>
		        	</div>

	       		</div>
	       	</div>	
		</div>
	</div>
</div>
