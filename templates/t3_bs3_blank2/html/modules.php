<?php
/** 
 *------------------------------------------------------------------------------
 * @package       T3 Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github 
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/t3fw
 * @Link:         http://t3-framework.org 
 *------------------------------------------------------------------------------
 */

defined('_JEXEC') or die('Restricted access');

/**
 * This is a file to add template specific chrome to module rendering.  To use it you would
 * set the style attribute for the given module(s) include in your template to use the style
 * for each given modChrome function.
 *
 * eg.  To render a module mod_test in the sliders style, you would use the following include:
 * <jdoc:include type="module" name="test" style="slider" />
 *
 * This gives template designers ultimate control over how modules are rendered.
 *
 * NOTICE: All chrome wrapping methods should be named: modChrome_{STYLE} and take the same
 * three arguments.
 */


/*
 * Default Module Chrome that has sematic markup and has best SEO support
 */

function modChrome_T3Xhtml($module, &$params, &$attribs)
{ 
    $headerTag     = htmlspecialchars($params->get('header_tag', 'h3'), ENT_QUOTES, 'UTF-8');
  $headerClass   = htmlspecialchars($params->get('header_class', 'module-title'), ENT_COMPAT, 'UTF-8');

	$badge = preg_match ('/badge/', $params->get('moduleclass_sfx'))? '<span class="badge">&nbsp;</span>' : '';
?>
<?php if ($module->content) { ?>
	<div class="t3-module module <?php echo $params->get('moduleclass_sfx'); ?>" id="Mod<?php echo $module->id; ?>">
    <div class="module-inner">
      <?php echo $badge; ?>
      <?php if ($module->showtitle != 0) : ?>
       <?php   echo '<' . $headerTag . ' class="' . $headerClass . '">' . $module->title . '</' . $headerTag . '>'; ?>
      <b class="click"></b>
      <?php endif; ?>
      <div class="module-ct">
      <?php echo $module->content; ?>
      </div>
    </div>
  </div>
  <?php
} ?>
	<?php
} ?>
