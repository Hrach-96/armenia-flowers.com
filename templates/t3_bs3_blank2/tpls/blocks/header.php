<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// get params
$sitename  = $this->params->get('sitename');
$slogan    = $this->params->get('slogan', '');
$logotype  = $this->params->get('logotype', 'text');
$logoimage = $logotype == 'image' ? $this->params->get('logoimage', 'templates/' . T3_TEMPLATE . '/images/logo.png') : '';
if (!$sitename) {
    $sitename = JFactory::getConfig()->get('sitename');
}

?>
<header id="t3-header" class="header-top">
<div class="container">
<div class="row">
  <div class="box-relative">
        <div class="logo col-md-3 mod-logo">
            <div class="logo-<?php echo $logotype ?>">
             <h1>
             <?php if($logotype == 'image'){ ?>
                <a href="<?php echo JUri::base() ?>" title="<?php echo strip_tags($sitename) ?>">
                        <img class="logo-img" src="<?php echo JURI::base(true) . '/' . $logoimage ?>" alt="<?php echo strip_tags($sitename) ?>" />
                </a>
                 <small class="site-slogan hidden-xs"><?php echo $slogan ?></small>
               <?php } else { ?>
               <a href="<?php echo JUri::base() ?>" title="<?php echo strip_tags($sitename) ?>">
                    <span><?php echo $sitename ?></span>
                </a>
                <small class="site-slogan hidden-xs"><?php echo $slogan ?></small>
               <?php } ?>
                
                </h1>
            </div>
        </div>
      <div class="mod-left col-md-9">
        <div class="pos-right">
          <?php if ($this->countModules('headlogin')) : ?>
          <div class="top-header-block3-custom<?php $this->_c('headlogin')?>">   
            <jdoc:include type="modules" name="<?php $this->_p('headlogin') ?>" style="raw" />
          </div>
          <?php endif ?>

          <?php if ($this->countModules('headlist')) : ?>
          <div class="top-header-block4-custom<?php $this->_c('headlist')?>">   
            <jdoc:include type="modules" name="<?php $this->_p('headlist') ?>" style="raw" />
          </div>
          <?php endif ?>
          <div class="clear"></div>
          <?php if ($this->countModules('headlanguage')) : ?>
           <div class="top-header-block1-custom<?php $this->_c('headlanguage')?>">   
            <jdoc:include type="modules" name="<?php $this->_p('headlanguage') ?>" style="raw" />
          </div>
          <?php endif ?>
          <?php if ($this->countModules('headcurrency')) : ?>
          <div class="top-header-block2-custom<?php $this->_c('headcurrency')?>">   
            <jdoc:include type="modules" name="<?php $this->_p('headcurrency') ?>" style="raw" />
          </div>
          <?php endif ?>
          </div>
      </div>
    <div class="clear"></div>
  </div>
    </div></div>
</header>
<div id="t3-menu-box">
<div class="container">
<div class="row">
      <div class="mod-full col-md-12">
        <div class="fright">
           <!-- MAIN NAVIGATION -->
            <nav id="t3-mainnav" class="wrap navbar navbar-default t3-mainnav header-top<?php if ($this->getParam('addon_offcanvas_enable')) : ?><?php echo ' offcanvas_enable' ?> <?php endif ?>">
                <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="t3-navbar">
                      <div class="navbar-header">
                      <?php  if ($this->getParam('navigation_type') == 'megamenu') {?> 
                        <?php if ($this->getParam('navigation_collapse_enable', 1) && $this->getParam('responsive', 1)) : ?>
                          <?php $this->addScript(T3_URL.'/js/nav-collapse.js'); ?>
                          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".t3-navbar-collapse">
                            <i class="fa fa-bars"></i>
                                      <span class="menu_title"><?php echo JText::_('DR_MENU_TITLE'); ?></span>
                          </button>
                                  
                        <?php endif ?>
                        <?php } ?>
                        <?php if ($this->getParam('addon_offcanvas_enable')) : ?>
                          <?php $this->loadBlock ('off-canvas') ?>
                        <?php endif ?>

                      </div>
                
                      <?php if ($this->getParam('navigation_collapse_enable')) : ?>
                        <div class="t3-navbar-collapse navbar-collapse collapse"></div>
                      <?php endif ?>
                       <?php  if ($this->getParam('navigation_type') == 'megamenu') {?> 

                      <div class="navbar-collapse collapse">
                        <jdoc:include type="<?php echo $this->getParam('navigation_type', 'megamenu') ?>" name="<?php echo $this->getParam('mm_type', 'mainmenu') ?>" />
                              
                      </div>
                      <div class="search-custom<?php $this->_c('head-search')?>"> 
                          <jdoc:include type="modules" name="<?php $this->_p('head-search') ?>" style="raw" />
                      </div>
                      <div class="mod-right cart-custom<?php $this->_c('head-cart')?>"> 
                          <jdoc:include type="modules" name="<?php $this->_p('head-cart') ?>" style="raw" />
                      </div>
                        </div>
                      <?php } else { ?>
                      <div id="joom-mainnav" class="t3-mainnav header-top">
                        <jdoc:include type="modules" name="<?php $this->_p('mainnav') ?>" style="raw" />
                        <div class="search-custom<?php $this->_c('head-search')?>"> 
                          <jdoc:include type="modules" name="<?php $this->_p('head-search') ?>" style="raw" />
                        </div>
                        <div class="mod-right cart-custom<?php $this->_c('head-cart')?>"> 
                          <jdoc:include type="modules" name="<?php $this->_p('head-cart') ?>" style="raw" />
                        </div>
                      </div>
              <?php }?> 
        </nav>
<!-- //MAIN NAVIGATION -->
        </div>
      </div>
    <div class="clear"></div>
    </div></div>
</div>