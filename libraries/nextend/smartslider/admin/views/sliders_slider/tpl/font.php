<?php
/*
# author Roland Soos
# copyright Copyright (C) Nextendweb.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-3.0.txt GNU/GPL
*/
defined('_JEXEC') or die('Restricted access'); ?><?php
$this->loadFragment('headerstart');
?>
<div class="smartslider-button smartslider-save" onclick="setTimeout(function(){njQuery('#smartslider-form').submit();}, 300);"><?php echo NextendText::_('Save'); ?></div>
<div class="smartslider-button smartslider-cancel" onclick="window.nextendsave=true;location.href='<?php echo $this->route('controller=sliders&view=sliders_slider&action=dashboard&sliderid=' . NextendRequest::getInt('sliderid')); ?>';"><?php echo NextendText::_('Cancel'); ?></div>
<?php
$this->loadFragment('headerend');
?>

<?php
$this->loadFragment('firstcolstart');
?>

<?php
$this->loadFragment('firstcolend');
?>

<?php
$this->loadFragment('secondcolstart');
?>

<form id="smartslider-form" action="" method="post">
    <?php
    NextendForm::tokenize();
    $settingsModel = $this->getModel('settings');
    $settingsModel->form($this->xml);
    ?>
    <input name="namespace" value="<?php echo $this->xml; ?>" type="hidden" />
    <input name="save" value="1" type="hidden" />
</form>

<?php
$this->loadFragment('secondcolend');
?>

<?php
$this->loadFragment('footer');
?>