<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php if ($this->countModules('breadcrumbs')) : ?>
<div class="top-breadcrumbs">
<div class="container top-header">
        <div class="breadcrumbs breadcrumbs-custom<?php $this->_c('breadcrumbs')?>">     
       		<jdoc:include type="modules" name="<?php $this->_p('breadcrumbs') ?>" style="raw" />
        </div>
 </div>
</div>        
<?php endif ?>
