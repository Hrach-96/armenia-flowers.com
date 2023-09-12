<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php if ($this->countModules('slider-wide'))  : ?>

<div id="slider">
 <?php if ($this->countModules('slider-wide')) : ?>
        <!-- HEADcustom -->
        <div class="screen head-custom<?php $this->_c('slider-wide')?>">     
          <jdoc:include type="modules" name="<?php $this->_p('slider-wide') ?>" style="raw" />
        </div>
        <!-- //HEADcustom -->
    <?php endif ?>
  </div>
<?php endif ?>
