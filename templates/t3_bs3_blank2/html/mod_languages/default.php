<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_languages
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div class="mod-languages">
<?php if ($headerText) : ?>
	<div class="pretext"><p><?php echo $headerText; ?></p></div>
<?php endif; ?>

<?php if ($params->get('dropdown', 1)) : ?>
	<form name="lang" method="post" action="<?php echo htmlspecialchars(JURI::current()); ?>">
	<select class="inputbox" onchange="document.location.replace(this.value);" >
	<?php foreach($list as $language):?>
		<option dir=<?php echo JLanguage::getInstance($language->lang_code)->isRTL() ? '"rtl"' : '"ltr"'?> value="<?php echo $language->link;?>" <?php echo $language->active ? 'selected="selected"' : ''?>>
		<?php echo $language->title_native;?></option>
	<?php endforeach; ?>
	</select>
	</form>
<?php else : ?>
<div id="cur-lang" class="header-button-languages">
        <div class="heading">
            <?php foreach($list as $language):?>
				<?php if ($params->get('show_active', 1) && $language->active): ?>
                  <img src="media/mod_languages/images/<?php echo $language->image; ?>.gif" alt="<?php echo $language->title_native;?>" />
                  <span><?php echo $language->sef; ?></span>
                <?php endif;?>
                
            <?php endforeach; ?>

        </div>
           	<ul class="<?php echo $params->get('inline', 1) ? 'lang-inline' : 'lang-block';?>">
                    <i class="fa fa-sort-desc"></i>
	<div>
	<?php foreach($list as $language):?>
		<?php if ($params->get('show_active', 0) || !$language->active):?>
			<li  dir="<?php echo JLanguage::getInstance($language->lang_code)->isRTL() ? 'rtl' : 'ltr' ?>">
			<a class="<?php echo $language->active ? 'act' : '';?>" href="<?php echo $language->link;?>">
			<?php if ($params->get('image', 1)):?>
				<?php echo JHtml::_('image', 'mod_languages/'.$language->image.'.gif', $language->title_native, array('title'=>$language->title), true);?>
                <?php echo $params->get('full_name', 1) ? $language->title_native : strtoupper($language->sef);?>
                
			<?php else : ?>
				<?php echo $params->get('full_name', 1) ? $language->title_native : strtoupper($language->sef);?>
			<?php endif; ?>
			</a>
			</li>
		<?php endif;?>
	<?php endforeach;?>
    </div>
	</ul>

            
    </div>

<?php endif; ?>


<?php if ($footerText) : ?>
	<div class="posttext"><p><?php echo $footerText; ?></p></div>
<?php endif; ?>

</div>

