<?php
/**
 * @package	AcyMailing for Joomla
 * @version	6.3.1
 * @author	acyba.com
 * @copyright	(C) 2009-2019 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');
?><form id="acym_form" action="<?php echo acym_completeLink(acym_getVar('cmd', 'ctrl')); ?>" method="post" name="acyForm">
	<input type="hidden" value="<?php echo acym_escape($data['campaignID']); ?>" name="id" id="acym__campaign__choose__campaign">
	<input type="hidden" name="mail[id]" value="<?php echo empty($data['mailInformation']->id) ? '' : intval($data['mailInformation']->id); ?>" />
	<div id="acym__templates__choose" class="acym__content">
        <?php
        $workflow = acym_get('helper.workflow');
        if (empty($data['campaignID'])) $workflow->disabledAfter = 'chooseTemplate';
        echo $workflow->display($this->steps, $this->step, false);

        include(ACYM_VIEW.'mails'.DS.'tmpl'.DS.'choose_template.php');
        ?>
	</div>
    <?php acym_formOptions(false, 'edit', 'chooseTemplate'); ?>
</form>

