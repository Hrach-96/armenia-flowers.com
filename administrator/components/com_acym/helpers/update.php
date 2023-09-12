<?php
/**
 * @package	AcyMailing for Joomla
 * @version	6.3.1
 * @author	acyba.com
 * @copyright	(C) 2009-2019 ACYBA S.A.R.L. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die('Restricted access');
?><?php

class acymupdateHelper
{
    var $errors = [];

    var $bounceVersion = 1;

    const FIRST_EMAIL_NAME_KEY = 'ACYM_FIRST_EMAIL_NAME';

    public function __construct()
    {
        global $acymCmsUserVars;
        $this->cmsUserVars = $acymCmsUserVars;
    }

    public function installBounceRules()
    {
        $ruleClass = acym_get('class.rule');
        if ($ruleClass->getOrderingNumber() > 0) {
            return;
        }
        $config = acym_config();
        $replyTo = $config->get('replyto_email');
        $bounce = $config->get('bounce_email');
        $from = $config->get('from_email');

        $forwardEmail = $replyTo != $bounce ? $replyTo : $from;
        if (empty($forwardEmail)) $forwardEmail = acym_currentUserEmail();

        $forwardEmail = str_replace('"', '', $forwardEmail);

        $query = "INSERT INTO `#__acym_rule` (`id`, `name`, `ordering`, `regex`, `executed_on`, `action_message`, `action_user`, `active`, `increment_stats`, `execute_action_after`) VALUES ";
        $query .= "(1, 'ACYM_ACTION_REQUIRED', 1, 'action *requ|verif', '[\"subject\"]', '{\"0\":\"delete_message\",\"1\":\"forward_message\",\"forward_to\":\"".$forwardEmail."\"}', '[]', 1, 0, 0),";
        $query .= "(2, 'ACYM_ACKNOWLEDGMENT_RECEIPT_SUBJECT', 2, '(out|away) *(of|from)|vacation|holiday|absen|congés|recept|acknowledg|thank you for', '[\"subject\"]', '[\"delete_message\"]', '[]', 1, 0, 0),";
        $query .= "(3, 'ACYM_FEEDBACK_LOOP', 3, 'feedback|staff@hotmail.com|complaints@.{0,15}email-abuse.amazonses.com|complaint about message', '[\"senderInfo\",\"subject\"]', '[\"save_message\",\"delete_message\"]', '[\"unsubscribe_user\"]', 1, 0, 0),";
        $query .= "(4, 'ACYM_FEEDBACK_LOOP_BODY', 4, 'Feedback-Type.{1,5}abuse', '[\"body\"]', '[\"save_message\",\"delete_message\"]', '[\"unsubscribe_user\"]', 1, 1, 0),";
        $query .= "(5, 'ACYM_MAILBOX_FULL', 5, '((mailbox|mailfolder|storage|quota|space|inbox) *(is)? *(over)? *(exceeded|size|storage|allocation|full|quota|maxi))|status(-code)? *(:|=)? *5.2.2|quota-issue|not *enough.{1,20}space|((over|exceeded|full|exhausted) *(allowed)? *(mail|storage|quota))', '[\"subject\",\"body\"]', '[\"save_message\",\"delete_message\"]', '[\"block_user\"]', 1, 1, 0),";
        $query .= "(6, 'ACYM_BLOCKED_GOOGLE_GROUPS', 6, 'message *rejected *by *Google *Groups', '[\"body\"]', '[\"delete_message\"]', '[]', 1, 1, 0),";
        $query .= "(7, 'ACYM_MAILBOX_DOESNT_EXIST_1', 7, '(Invalid|no such|unknown|bad|des?activated|inactive|unrouteable) *(mail|destination|recipient|user|address|person)|bad-mailbox|inactive-mailbox|not listed in.{1,20}directory|RecipNotFound|(user|mailbox|address|recipients?|host|account|domain) *(is|has been)? *(error|disabled|failed|unknown|unavailable|not *(found|available)|.{1,30}inactiv)|no *mailbox *here|user does.?n.t have.{0,30}account', '[\"subject\",\"body\"]', '[\"save_message\",\"delete_message\"]', '[\"block_user\"]', 1, 1, 0),";
        $query .= "(8, 'ACYM_MESSAGE_BLOCKED_RECIPIENTS', 8, 'blocked *by|block *list|look(ed)? *like *spam|spam-related|spam *detected| CXBL | CDRBL | IPBL | URLBL |(unacceptable|banned|offensive|filtered|blocked|unsolicited) *(content|message|e?-?mail)|service refused|(status(-code)?|554) *(:|=)? *5.7.1|administratively *denied|blacklisted *IP|policy *reasons|rejected.{1,10}spam|junkmail *rejected|throttling *constraints|exceeded.{1,10}max.{1,40}hour|comply with required standards|421 RP-00|550 SC-00|550 DY-00|550 OU-00', '[\"body\"]', '{\"0\":\"delete_message\",\"1\":\"forward_message\",\"forward_to\":\"".$forwardEmail."\"}', '[]', 1, 1, 0),";
        $query .= "(9, 'ACYM_MAILBOX_DOESNT_EXIST_2', 9, 'status(-code)? *(:|=)? *5.(1.[1-6]|0.0|4.[0123467])|recipient *address *rejected|does *not *like *recipient', '[\"subject\",\"body\"]', '[\"save_message\",\"delete_message\"]', '[\"block_user\"]', 1, 1, 0),";
        $query .= "(10, 'ACYM_DOMAIN_NOT_EXIST', 10, 'No.{1,10}MX *(record|host)|host *does *not *receive *any *mail|bad-domain|connection.{1,10}mail.{1,20}fail|domain.{1,10}not *exist|fail.{1,10}establish *connection', '[\"subject\",\"body\"]', '[\"save_message\",\"delete_message\"]', '[\"block_user\"]', 1, 1, 0),";
        $query .= "(11, 'ACYM_TEMPORARY_FAILURES', 11, 'has.*been.*delayed|delayed *mail|message *delayed|message-expired|temporar(il)?y *(failure|unavailable|disable|offline|unable)|deferred|delayed *([0-9]*) *(hour|minut)|possible *mail *loop|too *many *hops|delivery *time *expired|Action: *delayed|status(-code)? *(:|=)? *4.4.6|will continue to be attempted|unable to deliver in.*Status: 4.4.7', '[\"subject\",\"body\"]', '[\"save_message\",\"delete_message\"]', '[\"block_user\"]', 1, 1, 0),";
        $query .= "(12, 'ACYM_FAILED_PERM', 12, 'failed *permanently|permanent.{1,20}(failure|error)|not *accepting *(any)? *mail|does *not *exist|no *valid *route|delivery *failure', '[\"subject\",\"body\"]', '[\"save_message\",\"delete_message\"]', '[\"block_user\"]', 1, 1, 0),";
        $query .= "(13, 'ACYM_ACKNOWLEDGMENT_RECEIPT_BODY', 13, 'vacances|holiday|vacation|absen|urlaub', '[\"body\"]', '[\"delete_message\"]', '[]', 1, 0, 0),";
        $query .= "(14, 'ACYM_FINAL_RULE', 14, '.', '[\"senderInfo\",\"subject\"]', '{\"0\":\"delete_message\",\"1\":\"forward_message\",\"forward_to\":\"".$forwardEmail."\"}', '[]', 1, 1, 0);";

        acym_query($query);

        $newConfig = new stdClass();
        $newConfig->bounceVersion = $this->bounceVersion;
        $config->save($newConfig);
    }

    public function addUpdateSite()
    {
        $config = acym_config();

        $newconfig = new stdClass();
        $newconfig->website = ACYM_LIVE;
        $newconfig->max_execution_time = 0;

        $config->save($newconfig);

        acym_query('DELETE FROM #__updates WHERE element = "com_acym"');

        $update_site_id = acym_loadResult("SELECT update_site_id FROM #__update_sites WHERE location LIKE '%component=acymailing%' AND type LIKE 'extension'");

        $object = new stdClass();
        $object->name = 'AcyMailing';
        $object->type = 'extension';
        $object->location = ACYM_UPDATEMEURL.'updatexml&component=acymailing&cms=joomla&level='.$config->get('level').'&version='.$config->get('version');

        $object->enabled = 1;

        if (empty($update_site_id)) {
            $update_site_id = acym_insertObject("#__update_sites", $object);
        } else {
            $object->update_site_id = $update_site_id;
            acym_updateObject("#__update_sites", $object, 'update_site_id');
        }

        $extension_id = acym_loadResult("SELECT extension_id FROM #__extensions WHERE `element` = 'com_acym' AND type LIKE 'component'");
        if (empty($update_site_id) || empty($extension_id)) {
            return false;
        }

        $query = 'INSERT IGNORE INTO #__update_sites_extensions (update_site_id, extension_id) values ('.intval($update_site_id).','.intval($extension_id).')';
        acym_query($query);

        return true;
    }

    public function installLanguages()
    {
        $siteLanguages = acym_getLanguages();
        if (!empty($siteLanguages[ACYM_DEFAULT_LANGUAGE])) {
            unset($siteLanguages[ACYM_DEFAULT_LANGUAGE]);
        }

        $installedLanguages = array_keys($siteLanguages);
        if (empty($installedLanguages)) return;

        ob_start();
        $languagesContent = acym_fileGetContent(ACYM_UPDATEURL.'loadLanguages&json=1&component=acym&codes='.implode(',', $installedLanguages));
        $warnings = ob_get_clean();
        if (!empty($warnings) && acym_isDebug()) acym_enqueueMessage($warnings, 'warning');

        if (empty($languagesContent)) {
            acym_enqueueMessage(acym_translation('ACYM_ERROR_LOAD_LANGUAGES'), 'error');

            return;
        }

        $decodedLanguages = json_decode($languagesContent, true);

        $success = [];
        $error = [];
        $errorLoad = [];

        foreach ($decodedLanguages as $code => $content) {
            if (empty($content)) {
                $errorLoad[] = $code;
                continue;
            }

            $path = acym_getLanguagePath(ACYM_ROOT, $code).DS.$code.'.'.ACYM_LANGUAGE_FILE.'.ini';
            if (acym_writeFile($path, $content)) {
                $this->installBackLanguages($code);
                $success[] = $code;
            } else {
                $error[] = acym_translation_sprintf('ACYM_ERROR_SAVE_FILE', $path);
            }
        }

        if (!empty($success)) acym_enqueueMessage(acym_translation_sprintf('ACYM_TRANSLATION_INSTALLED', implode(', ', $success)), 'success');
        if (!empty($error)) acym_enqueueMessage($error, 'error');
        if (!empty($errorLoad)) acym_enqueueMessage(acym_translation_sprintf('ACYM_ERROR_LOAD_LANGUAGE', implode(', ', $errorLoad)), 'warning');
    }

    public function installBackLanguages($onlyCode = '')
    {
        if (ACYM_CMS != 'joomla') return;

        $menuStrings = [
            'ACYM_USERS',
            'ACYM_CUSTOM_FIELDS',
            'ACYM_LISTS',
            'ACYM_TEMPLATES',
            'ACYM_CAMPAIGNS',
            'ACYM_QUEUE',
            'ACYM_AUTOMATION',
            'ACYM_STATISTICS',
            'ACYM_BOUNCE_HANDLING',
            'ACYM_CONFIGURATION',
            'ACYM_MENU_PROFILE',
            'ACYM_MENU_PROFILE_DESC',
            'ACYM_MENU_ARCHIVE',
            'ACYM_MENU_ARCHIVE_DESC',
        ];

        if (empty($onlyCode)) {
            $siteLanguages = array_keys(acym_getLanguages());
        } else {
            $siteLanguages = [$onlyCode];
        }

        foreach ($siteLanguages as $code) {

            $path = acym_getLanguagePath(ACYM_ROOT, $code).DS.$code.'.com_acym.ini';
            if (!file_exists($path)) continue;

            $content = file_get_contents($path);
            if (empty($content)) continue;


            $menuFileContent = 'ACYM="AcyMailing 6"'."\r\n";
            $menuFileContent .= 'COM_ACYM="AcyMailing 6"'."\r\n";
            $menuFileContent .= 'COM_ACYM_CONFIGURATION="AcyMailing 6"'."\r\n";

            foreach ($menuStrings as $oneString) {
                preg_match('#[^_]'.$oneString.'="(.*)"#i', $content, $matches);
                if (empty($matches[1])) continue;

                $menuFileContent .= $oneString.'="'.$matches[1].'"'."\r\n";
            }

            $menuPath = ACYM_ROOT.'administrator'.DS.'language'.DS.$code.DS.$code.'.com_acym.sys.ini';

            if (!acym_writeFile($menuPath, $menuFileContent)) {
                acym_enqueueMessage(acym_translation_sprintf('ACYM_FAIL_SAVE_FILE', $menuPath), 'error');
            }
        }
    }

    public function installFields()
    {
        $query = "INSERT IGNORE INTO #__acym_field (`id`, `name`, `type`, `value`, `active`, `default_value`, `required`, `ordering`, `option`, `core`, `backend_profile`, `backend_listing`, `backend_filter`, `frontend_form`, `frontend_profile`, `frontend_listing`, `frontend_filter`, `access`, `namekey`) VALUES
    (1, 'ACYM_NAME', 'text', NULL, 1, NULL, 0, 1, '{\"editable_user_creation\":\"1\",\"editable_user_modification\":\"1\",\"error_message\":\"\",\"error_message_invalid\":\"\",\"size\":\"\",\"rows\":\"\",\"columns\":\"\",\"format\":\"\",\"custom_text\":\"\",\"css_class\":\"\",\"authorized_content\":{\"0\":\"all\",\"regex\":\"\"}}', 1, 1, 1, 0, 1, 1, 1, 0, 'all', 'acym_name'),
    (2, 'ACYM_EMAIL', 'text', NULL, 1, NULL, 1, 2, '{\"editable_user_creation\":\"1\",\"editable_user_modification\":\"1\",\"error_message\":\"\",\"error_message_invalid\":\"\",\"size\":\"\",\"rows\":\"\",\"columns\":\"\",\"format\":\"\",\"custom_text\":\"\",\"css_class\":\"\",\"authorized_content\":{\"0\":\"all\",\"regex\":\"\"}}', 1, 1, 1, 0, 1, 1, 1, 0, 'all', 'acym_name');";
        acym_query($query);
    }

    public function installTemplates()
    {
        $mailClass = acym_get('class.mail');

        $defaultTemplatesFolder = ACYM_BACK.'templates'.DS;
        $names = acym_getFolders($defaultTemplatesFolder);

        $creationDate = acym_escapeDB(acym_date('now', 'Y-m-d H:i:s', false));
        $currentUserId = acym_currentUserId();
        foreach ($names as $name) {
            $templatePath = $defaultTemplatesFolder.$name.DS;
            $mailName = str_replace('_', ' ', $name);
            $oneMail = $mailClass->getOneByName($mailName);
            if (!empty($oneMail)) continue;

            $tmplName = acym_escapeDB($mailName);
            $thumbnail = acym_escapeDB($name.'.png');
            $body = acym_escapeDB(str_replace('{acym_media}', ACYM_IMAGES, file_get_contents($templatePath.'content.txt')));
            $settings = acym_escapeDB(file_get_contents($templatePath.'settings.txt'));
            if (file_exists($templatePath.'stylesheet.txt')) {
                $stylesheet = acym_escapeDB(file_get_contents($templatePath.'stylesheet.txt'));
            } else {
                $stylesheet = '""';
            }

            $query = 'INSERT INTO `#__acym_mail` (`name`, `creation_date`, `thumbnail`, `drag_editor`, `library`, `type`, `body`, `subject`, `template`, `from_name`, `from_email`, `reply_to_name`, `reply_to_email`, `bcc`, `settings`, `stylesheet`, `attachments`, `creator_id`) VALUES
                     ('.$tmplName.', '.$creationDate.', '.$thumbnail.', 1, 1, "standard", '.$body.', "", 1, NULL, NULL, NULL, NULL, NULL, '.$settings.', '.$stylesheet.', NULL, '.$currentUserId.');';
            acym_query($query);
        }

        acym_deleteFolder(ACYM_BACK.'templates');
    }

    private function _newAutomationAdmin($title)
    {
        $automationClass = acym_get('class.automation');
        $stepClass = acym_get('class.step');
        $conditionClass = acym_get('class.condition');
        $mailClass = acym_get('class.mail');
        $actionClass = acym_get('class.action');


        $adminCreate = new stdClass();
        $adminCreate->desc = 'ACYM_ADMIN_USER_CREATE_DESC';
        $adminCreate->triggers = '{"user_creation":[""],"type_trigger":"user"}';
        $adminCreate->conditions = '{"type_condition":"user"}';
        $adminCreate->emailTitle = acym_translation('ACYM_USER_CREATION');
        $adminCreate->emailSubject = '{trans:ACYM_USER_CREATION}';
        $adminCreate->emailContent = '<h1 style="font-size: 24px;">{trans:ACYM_HELLO} {subtag:name|ucfirst},</h1>
                    <p>{trans:ACYM_NEW_USER_ACYMAILING}:</p>
                    <p>{trans:ACYM_NAME}: {subtag:name|info:current}</p>
                    <p>{trans:ACYM_EMAIL}: {subtag:email|info:current}</p>';

        $adminModif = new stdClass();
        $adminModif->desc = 'ACYM_ADMIN_USER_MODIFICATION_DESC';
        $adminModif->triggers = '{"user_modification":[""],"type_trigger":"user"}';
        $adminModif->conditions = '{"type_condition":"user"}';
        $adminModif->emailTitle = acym_translation('ACYM_USER_MODIFICATION');
        $adminModif->emailSubject = '{trans:ACYM_USER_MODIFICATION}';
        $adminModif->emailContent = '<h1 style="font-size: 24px;">{trans:ACYM_HELLO} {subtag:name|ucfirst},</h1>
                    <p>{trans:ACYM_USER_MODIFY_ACYMAILING}:</p>
                    <p>{trans:ACYM_NAME}: {subtag:name|info:current}</p>
                    <p>{trans:ACYM_EMAIL}: {subtag:email|info:current}</p>';

        $info = [
            'ACYM_ADMIN_USER_CREATE' => $adminCreate,
            'ACYM_ADMIN_USER_MODIFICATION' => $adminModif,
        ];

        $newAutomation = new stdClass();
        $newAutomation->name = $title;
        $newAutomation->description = $info[$title]->desc;
        $newAutomation->active = 0;
        $newAutomation->admin = 1;
        $newAutomation->id = $automationClass->save($newAutomation);
        if (empty($newAutomation->id)) return false;

        $newStep = new stdClass();
        $newStep->name = 'ACYM_ADMIN_USER_CREATE';
        $newStep->triggers = $info[$title]->triggers;
        $newStep->automation_id = $newAutomation->id;
        $newStep->id = $stepClass->save($newStep);
        if (empty($newStep->id)) return false;

        $newCondition = new stdClass();
        $newCondition->step_id = $newStep->id;
        $newCondition->conditions = $info[$title]->conditions;
        $newCondition->id = $conditionClass->save($newCondition);
        if (empty($newCondition->id)) return false;

        $mailAutomation = new stdClass();
        $mailAutomation->type = 'automation';
        $mailAutomation->library = 1;
        $mailAutomation->template = 0;
        $mailAutomation->drag_editor = 1;
        $mailAutomation->creator_id = acym_currentUserId();
        $mailAutomation->creation_date = date('Y-m-d H:i:s', time());
        $mailAutomation->name = acym_translation($info[$title]->emailTitle);
        $mailAutomation->subject = acym_translation($info[$title]->emailSubject);
        $mailAutomation->body = $this->getFormatedNotification($info[$title]->emailContent);

        $mailAutomation->id = $mailClass->save($mailAutomation);
        if (empty($mailAutomation->id)) return false;

        $newAction = new stdClass();
        $newAction->condition_id = $newCondition->id;
        $newAction->actions = '[{"acy_add_queue":{"mail_id":"'.intval($mailAutomation->id).'","time":"[time]"}}]';
        $newAction->filters = '{"0":{"1":{"acy_field":{"field":"email","operator":"=","value":"'.acym_currentUserEmail().'"}}},"type_filter":"classic"}';
        $newAction->order = 1;
        $newAction->id = $actionClass->save($newAction);
        if (empty($newAction->id)) return false;
    }

    public function installAdminNotif()
    {
        $automationClass = acym_get('class.automation');
        $automationAdmin = $automationClass->getAutomationsAdmin();

        if (empty($automationAdmin['ACYM_ADMIN_USER_CREATE'])) {
            $this->_newAutomationAdmin('ACYM_ADMIN_USER_CREATE');
        }

        if (empty($automationAdmin['ACYM_ADMIN_USER_MODIFICATION'])) {
            $this->_newAutomationAdmin('ACYM_ADMIN_USER_MODIFICATION');
        }
    }

    public function installList()
    {
        $listClass = acym_get('class.list');
        $listClass->addDefaultList();
    }

    public function installNotifications()
    {
        $searchSettings = [
            'offset' => 0,
            'mailsPerPage' => 9000,
            'key' => 'name',
        ];

        $mailClass = acym_get('class.mail');
        $userClass = acym_get('class.user');
        $notifications = $mailClass->getMailsByType('notification', $searchSettings);
        $notifications = $notifications['mails'];

        $addNotif = [];

        if (empty($notifications['acy_report'])) {
            $addNotif[] = [
                'name' => 'acy_report',
                'subject' => 'AcyMailing Cron Report {mainreport}',
                'content' => '<p>{report}</p><p>{detailreport}</p>',
            ];
        }

        if (empty($notifications['acy_confirm'])) {
            $addNotif[] = [
                'name' => 'acy_confirm',
                'subject' => '{subtag:name|ucfirst}, {trans:ACYM_PLEASE_CONFIRM_SUBSCRIPTION}',
                'content' => $this->getFormatedNotification(
                    '<h1 style="font-size: 24px;">Hello {subtag:name|ucfirst},</h1>
                    <p>{trans:ACYM_CONFIRM_MESSAGE}</p>
                    <p>{trans:ACYM_CONFIRM_MESSAGE_ACTIVATE}</p>
                    <p style="text-align: center;"><strong>{confirm}{trans:ACYM_CONFIRM_SUBSCRIPTION}{/confirm}</strong></p>'
                ),
            ];
        }

        $firstEmail = $mailClass->getOneByName(acym_translation(self::FIRST_EMAIL_NAME_KEY));

        if (empty($firstEmail)) {
            $currentCMSId = acym_currentUserId();
            $currentCMSEmail = acym_currentUserEmail();
            $user = $userClass->getOneByCMSId($currentCMSId);
            if (empty($user)) $user = $userClass->getOneByEmail($currentCMSEmail);
            if (empty($user)) {
                $newUser = new stdClass();
                $newUser->email = $currentCMSEmail;
                $newUser->confirmed = 1;
                $newUser->cms_id = $currentCMSId;
                $newUser->id = $userClass->save($newUser);
                $user = $userClass->getOneById($newUser->id);
            }
            $addNotif[] = [
                'name' => acym_translation(self::FIRST_EMAIL_NAME_KEY),
                'subject' => acym_translation('ACYM_YOUR_FIRST_EMAIL'),
                'content' => '<div id="acym__wysid__template" class="cell">
					<table class="body">
						<tbody>
							<tr>
								<td align="center" class="center acym__wysid__template__content" valign="top" style="background-color: rgb(245, 245, 245); padding: 40px 0 40px;">
									<center>
										<table align="center">
											<tbody>
												<tr>
													<td class="acym__wysid__row ui-droppable ui-sortable" bgcolor="#ffffff" style="background-color: rgb(255, 255, 255); min-height: 0px; display: table-cell;">
														<table class="row acym__wysid__row__element" style="z-index: 100; background-color: rgb(238, 238, 238);" bgcolor="#eeeeee">
															<tbody bgcolor="" style="background-color: inherit;">
																<tr>
																	<th class="small-12 medium-12 large-12 columns">
																		<table class="acym__wysid__column" style="min-height: 0px; display: table;">
																			<tbody class="ui-sortable" style="min-height: 0px; display: table-row-group;">
                                                                                <tr class="acym__wysid__column__element ui-draggable" style="position: relative; top: inherit; left: inherit; right: inherit; bottom: inherit; height: auto;">
                                                                                    <td class="large-12 acym__wysid__column__element__td" style="outline-width: 0px;">
                                                                                        <div class="acym__wysid__tinymce--text mce-content-body" id="mce_0" style="position: relative;" spellcheck="false" contenteditable="false">
                                                                                            <p style="font-family: Helvetica; font-size: 16px; font-weight: normal; font-style: normal; color: rgb(0, 0, 0); word-break: break-word; text-align: center;" data-mce-style="font-family: Helvetica; font-size: 16px; font-weight: normal; font-style: normal; color: #000000; word-break: break-word; text-align: center;">
                                                                                                <span style="font-size: 12px; color: rgb(165, 165, 165);" data-mce-style="font-size: 12px; color: #a5a5a5;">We need your feedback!</span>
                                                                                            </p>
                                                                                            <p style="font-family: Helvetica; font-size: 16px; font-weight: normal; font-style: normal; color: rgb(0, 0, 0); word-break: break-word; text-align: center;" data-mce-style="font-family: Helvetica; font-size: 16px; font-weight: normal; font-style: normal; color: #000000; word-break: break-word; text-align: center;">
                                                                                                <span style="font-size: 12px; color: rgb(165, 165, 165);" data-mce-style="font-size: 12px; color: #a5a5a5;">Having trouble seeing this email?</span>
                                                                                                <span class="acym_dynamic mceNonEditable" contenteditable="false" data-dynamic="{readonline}Click here to view it online{/readonline}">
                                                                                                    <a style="text-decoration: none;" href="'.acym_frontendLink(
                        'archive&task=view&id=id_view_it_online_first_test&userid='.$user->id.'-'.$user->key,
                        true,
                        true
                    ).' target="_blank" rel="noopener" data-mce-style="text-decoration: none;">
                                                                                                        <span class="acym_online">Click here to view it online</span>
                                                                                                    </a>
                                                                                                    <em class="acym_remove_dynamic acymicon-close"></em>
                                                                                                </span>
                                                                                            </p>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
																		</table>
																	</th>
																</tr>
															</tbody>
														</table>
														<table class="row acym__wysid__row__element" bgcolor="#ffffff" style="background-color: rgb(255, 255, 255); z-index: 100;">
														    <tbody bgcolor="" style="background-color: inherit;">
														        <tr>
														            <th class="small-12 medium-12 large-12 columns acym__wysid__row__element__th" valign="top">
														                <table class="acym__wysid__column" style="min-height: 0px; display: table;">
														                    <tbody class="ui-sortable" style="min-height: 0px; display: table-row-group;">
														                        <tr class="acym__wysid__column__element ui-draggable" style="position: relative; top: inherit; left: inherit; right: inherit; bottom: inherit; height: auto;">
														                            <td class="large-12 acym__wysid__column__element__td" style="outline-width: 0px;">
														                                <div class="acym__wysid__tinymce--image mce-content-body" id="mce_9" style="position: relative;" spellcheck="false" contenteditable="false">
														                                    <p style="font-family: Helvetica; font-size: 16px; font-weight: normal; font-style: normal; color: #000000; word-break: break-word;" data-mce-style="font-family: Helvetica; font-size: 16px; font-weight: normal; font-style: normal; color: #000000; word-break: break-word;">
														                                        <img class="" src="'.ACYM_LIVE.ACYM_UPLOAD_FOLDER.'logo_acymailing_step_email.png" alt="logo_acymailing_step_email" style="max-width: 100%; height: 119px; box-sizing: border-box; padding: 0px 5px; display: block; margin-left: auto; margin-right: auto;" data-mce-style="max-width: 100%; height: 119px; box-sizing: border-box; padding: 0px 5px; display: block; margin-left: auto; margin-right: auto;" height="119" width="428">
                                                                                            </p>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="acym__wysid__column__element acym__wysid__column__element__separator cursor-pointer ui-draggable" style="position: relative; top: inherit; left: inherit; right: inherit; bottom: inherit; height: auto;">
                                                                                    <td class="large-12 acym__wysid__column__element__td" style="outline-width: 0px;">
                                                                                        <hr style="border-bottom: 3px solid rgb(214, 214, 214); width: 24%; border-top: none; border-left: none; border-right: none;" class="acym__wysid__row__separator">
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class="row acym__wysid__row__element" bgcolor="#ffffff" style="background-color: rgb(255, 255, 255); z-index: 100;">
                                                            <tbody bgcolor="" style="background-color: inherit;">
                                                                <tr>
                                                                    <th class="small-12 medium-12 large-12 columns acym__wysid__row__element__th" valign="top">
                                                                        <table class="acym__wysid__column" style="min-height: 0px; display: table;">
                                                                            <tbody class="ui-sortable" style="min-height: 0px; display: table-row-group;">
                                                                                <tr class="acym__wysid__column__element ui-draggable" style="position: relative; top: inherit; left: inherit; right: inherit; bottom: inherit; height: auto;">
                                                                                    <td class="large-12 acym__wysid__column__element__td" style="outline-width: 0px;">
                                                                                        <div class="acym__wysid__tinymce--text mce-content-body" id="mce_10" style="position: relative;" spellcheck="false" contenteditable="false">
                                                                                            <h1 style="font-family: Helvetica; font-size: 34px; font-weight: normal; font-style: normal; color: rgb(0, 0, 0); text-align: center;" data-mce-style="font-family: Helvetica; font-size: 34px; font-weight: normal; font-style: normal; color: #000000; text-align: center;">
                                                                                                <span style="color: rgb(0, 164, 255);" data-mce-style="color: #00a4ff;">Dear&nbsp;</span><span class="acym_dynamic mceNonEditable" contenteditable="false" data-dynamic="{subtag:name|part:first|ucfirst}">Admin<em class="acym_remove_dynamic acymicon-close"></em></span><span style="color: rgb(0, 164, 255);" data-mce-style="color: #00a4ff;">,</span>
                                                                                            </h1>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="acym__wysid__column__element ui-draggable" style="position: relative; top: inherit; left: inherit; right: inherit; bottom: inherit; height: auto;">
                                                                                    <td class="large-12 acym__wysid__column__element__td" style="outline-width: 0px;">
                                                                                        <div class="acym__wysid__tinymce--text mce-content-body" id="mce_11" style="position: relative;" spellcheck="false" contenteditable="false">
                                                                                            <p class="p1" data-mce-style="color: #000000; font-family: Helvetica; text-align: center; word-break: break-word; font-size: 16px; font-weight: normal; font-style: normal;" style="color: rgb(0, 0, 0); font-family: Helvetica; text-align: center; word-break: break-word; font-size: 16px; font-weight: normal; font-style: normal;">
                                                                                                <span style="color: rgb(153, 153, 153); font-size: 18px;" data-mce-style="color: #999999; font-size: 18px;">Amazing, you are going to send your first email!&nbsp;</span>
                                                                                            </p>
                                                                                            <p class="p1" data-mce-style="color: #000000; font-family: Helvetica; text-align: center; word-break: break-word; font-size: 16px; font-weight: normal; font-style: normal;" style="color: rgb(0, 0, 0); font-family: Helvetica; text-align: center; word-break: break-word; font-size: 16px; font-weight: normal; font-style: normal;">
                                                                                                <br>
                                                                                            </p>
                                                                                            <p class="p1" data-mce-style="color: #000000; font-family: Helvetica; text-align: center; word-break: break-word; font-size: 16px; font-weight: normal; font-style: normal;" style="color: rgb(0, 0, 0); font-family: Helvetica; text-align: center; word-break: break-word; font-size: 16px; font-weight: normal; font-style: normal;">
                                                                                                <span style="color: rgb(153, 153, 153); font-size: 18px;" data-mce-style="color: #999999; font-size: 18px;">Feel free to drag &amp; drop some content and give</span>
                                                                                            </p>
                                                                                            <p class="p1" data-mce-style="color: #000000; font-family: Helvetica; text-align: center; word-break: break-word; font-size: 16px; font-weight: normal; font-style: normal;" style="color: rgb(0, 0, 0); font-family: Helvetica; text-align: center; word-break: break-word; font-size: 16px; font-weight: normal; font-style: normal;">
                                                                                                <span style="color: rgb(153, 153, 153); font-size: 18px;" data-mce-style="color: #999999; font-size: 18px;">a try to the AcyMailing editor.</span><br><br>
                                                                                                <span style="color: rgb(153, 153, 153); font-size: 18px;" data-mce-style="color: #999999; font-size: 18px;">Once it is done then click on the "Save" button</span>
                                                                                            </p>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class="row acym__wysid__row__element" bgcolor="#ffffff" style="background-color: rgb(255, 255, 255); z-index: 100; padding: 0px;">
                                                            <tbody bgcolor="" style="background-color: inherit;">
                                                                <tr>
                                                                    <th class="small-12 medium-12 large-12 columns acym__wysid__row__element__th" valign="top">
                                                                        <table class="acym__wysid__column" style="min-height: 0px; display: table;">
                                                                            <tbody class="ui-sortable" style="min-height: 0px; display: table-row-group;">
                                                                                <tr class="acym__wysid__column__element ui-draggable" style="position: relative; top: inherit; left: inherit; right: inherit; bottom: inherit; height: auto;">
                                                                                    <td class="large-12 acym__wysid__column__element__td" style="outline-width: 0px;">
                                                                                        <div class="acym__wysid__tinymce--image mce-content-body" id="mce_12" style="position: relative;" spellcheck="false" contenteditable="false">
                                                                                            <p style="font-family: Helvetica; font-size: 16px; font-weight: normal; font-style: normal; color: #000000; word-break: break-word;" data-mce-style="font-family: Helvetica; font-size: 16px; font-weight: normal; font-style: normal; color: #000000; word-break: break-word;">
                                                                                                <img class="" src="'.ACYM_LIVE.ACYM_UPLOAD_FOLDER.'image_mailing_step_email.jpg" alt="image_mailing_step_email" style="max-width: 100%; height: auto; box-sizing: border-box; padding: 0 5px; display: block; margin-left: auto; margin-right: auto;" data-mce-style="max-width: 100%; height: auto; box-sizing: border-box; padding: 0 5px; display: block; margin-left: auto; margin-right: auto;" height="401" width="580">
                                                                                            </p>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class="row acym__wysid__row__element" bgcolor="#303e47" style="background-color: rgb(48, 62, 71); z-index: 100;">
                                                            <tbody bgcolor="" style="background-color: inherit;">
                                                                <tr>
                                                                    <th class="small-12 medium-12 large-12 columns acym__wysid__row__element__th" valign="top">
                                                                        <table class="acym__wysid__column" style="min-height: 0px; display: table;">
                                                                            <tbody class="ui-sortable" style="min-height: 0px; display: table-row-group;">
                                                                                <tr class="acym__wysid__column__element ui-draggable" style="position: relative; top: inherit; left: inherit; right: inherit; bottom: inherit; height: auto;">
                                                                                    <td class="large-12 acym__wysid__column__element__td" style="outline-width: 0px;">
                                                                                        <div class="acym__wysid__tinymce--text mce-content-body" id="mce_13" style="position: relative;" spellcheck="false" contenteditable="false">
                                                                                            <p style="font-family: Helvetica; font-size: 16px; font-weight: normal; font-style: normal; color: rgb(0, 0, 0); word-break: break-word; text-align: center;" data-mce-style="font-family: Helvetica; font-size: 16px; font-weight: normal; font-style: normal; color: #000000; word-break: break-word; text-align: center;">
                                                                                                <span class="acym_dynamic mceNonEditable" contenteditable="false" data-dynamic="{unsubscribe}Unsubscribe{/unsubscribe}">
                                                                                                    <a style="text-decoration: none;" href="'.acym_frontendLink(
                        'frontusers&task=unsubscribe&id='.$user->id.'&key='.$user->key,
                        true,
                        true
                    ).' target="_blank" rel="noopener" data-mce-style="text-decoration: none;">
                                                                                                        <span class="acym_unsubscribe">Unsubscribe</span>
                                                                                                    </a>
                                                                                                    <em class="acym_remove_dynamic acymicon-close"></em>
                                                                                                </span>
                                                                                            </p>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
													</td>
												</tr>
											</tbody>
										</table>
									</center>
								</td>
							</tr>
						</tbody>
					</table>
				</div>',
                'template' => 1,
                'settings' => '{"p":{"font-family":"Helvetica","font-size":"16px"},"#acym__wysid__background-colorpicker":{"background-color":"#f5f5f5"}}',
                'type' => 'standard',
                'thumbnail' => 'thumbnail_first_email.png',
            ];
            $mailingImage = 'image_mailing_step_email.jpg';
            $logoAcymailing = 'logo_acymailing_step_email.png';
            $thumbnailFirstStep = 'thumbnail_first_email.png';

            acym_createFolder(ACYM_ROOT.ACYM_UPLOAD_FOLDER);
            acym_createFolder(ACYM_UPLOAD_FOLDER_THUMBNAIL);

            if (!file_exists(ACYM_ROOT.ACYM_UPLOAD_FOLDER.$mailingImage)) copy(ACYM_ROOT.ACYM_MEDIA_FOLDER.DS.'images'.DS.$mailingImage, ACYM_ROOT.ACYM_UPLOAD_FOLDER.$mailingImage);
            if (!file_exists(ACYM_ROOT.ACYM_UPLOAD_FOLDER.$logoAcymailing)) copy(ACYM_ROOT.ACYM_MEDIA_FOLDER.DS.'images'.DS.$logoAcymailing, ACYM_ROOT.ACYM_UPLOAD_FOLDER.$logoAcymailing);
            if (!file_exists(ACYM_UPLOAD_FOLDER_THUMBNAIL.$thumbnailFirstStep)) copy(ACYM_ROOT.ACYM_MEDIA_FOLDER.DS.'images'.DS.$thumbnailFirstStep, ACYM_UPLOAD_FOLDER_THUMBNAIL.$thumbnailFirstStep);
        }

        if (!empty($addNotif)) {
            foreach ($addNotif as $oneNotif) {
                $notif = new stdClass();
                $notif->type = empty($oneNotif['type']) ? 'notification' : $oneNotif['type'];
                $notif->library = 1;
                $notif->template = empty($oneNotif['template']) ? 0 : $oneNotif['template'];
                $notif->settings = empty($oneNotif['settings']) ? '' : $oneNotif['settings'];
                $notif->drag_editor = 1;
                $notif->creator_id = acym_currentUserId();
                $notif->creation_date = date('Y-m-d H:i:s', time());
                $notif->name = $oneNotif['name'];
                $notif->subject = $oneNotif['subject'];
                $notif->body = $oneNotif['content'];
                $notif->thumbnail = empty($oneNotif['thumbnail']) ? '' : $oneNotif['thumbnail'];

                $notif->id = $mailClass->save($notif);
                if (empty($notif->id)) {
                    acym_enqueueMessage(acym_translation_sprintf('ACYM_ERROR_INSTALLING_X_TEMPLATE', $notif->name), 'error');

                    return false;
                }
                if (acym_translation(self::FIRST_EMAIL_NAME_KEY) === $notif->name) {
                    $notif->body = str_replace('id_view_it_online_first_test', $notif->id, $notif->body);
                    $mailClass->save($notif);
                }
            }
        }

        return true;
    }

    private function getFormatedNotification($content)
    {
        $begining = '<div id="acym__wysid__template" class="cell"><table class="body"><tbody><tr><td align="center" class="center acym__wysid__template__content" valign="top" style="background-color: rgb(239, 239, 239); padding: 40px 0 120px 0;"><center><table align="center"><tbody><tr><td class="acym__wysid__row ui-droppable ui-sortable" style="min-height: 0px; display: table-cell;"><table class="row acym__wysid__row__element" bgcolor="#dadada"><tbody style="background-color: rgb(218, 218, 218);" bgcolor="#ffffff"><tr><th class="small-12 medium-12 large-12 columns acym__wysid__row__element__th"><table class="acym__wysid__column" style="min-height: 0px; display: table;"><tbody class="ui-sortable" style="min-height: 0px; display: table-row-group;"><tr class="acym__wysid__column__element ui-draggable" style="position: relative; top: inherit; left: inherit; right: inherit; bottom: inherit; height: auto;"><td class="large-12 acym__wysid__column__element__td" style="outline: rgb(0, 163, 254) dashed 0px; outline-offset: -1px;"><span class="acy-editor__space acy-editor__space--focus" style="display: block; padding: 0px; margin: 0px; height: 10px;"></span></td></tr></tbody></table></th></tr></tbody></table><table class="row acym__wysid__row__element" bgcolor="#ffffff"><tbody style="background-color: rgb(255, 255, 255);" bgcolor="#ffffff"><tr><th class="small-12 medium-12 large-12 columns"><table class="acym__wysid__column" style="min-height: 0px; display: table;"><tbody class="ui-sortable" style="min-height: 0px; display: table-row-group;"><tr class="acym__wysid__column__element ui-draggable" style="position: relative; top: inherit; left: inherit; right: inherit; bottom: inherit; height: auto;"><td class="large-12 acym__wysid__column__element__td" style="outline: rgb(0, 163, 254) dashed 0px; outline-offset: -1px;"><div class="acym__wysid__tinymce--text mce-content-body" style="position: relative;" spellcheck="false">';
        $ending = '</div></td></tr></tbody></table></th></tr></tbody></table><table class="row acym__wysid__row__element" bgcolor="#dadada" style="position: relative; z-index: 100; top: 0; left: 0;"><tbody style="background-color: rgb(218, 218, 218);" bgcolor="#ffffff"><tr><th class="small-12 medium-12 large-12 columns acym__wysid__row__element__th"><table class="acym__wysid__column" style="min-height: 0px; display: table;"><tbody class="ui-sortable" style="min-height: 0px; display: table-row-group;"><tr class="acym__wysid__column__element ui-draggable" style="position: relative; top: inherit; left: inherit; right: inherit; bottom: inherit; height: auto;"><td class="large-12 acym__wysid__column__element__td" style="outline: rgb(0, 163, 254) dashed 0px; outline-offset: -1px;"><span class="acy-editor__space acy-editor__space--focus" style="display: block; padding: 0px; margin: 0px; height: 10px;"></span></td></tr></tbody></table></th></tr></tbody></table></td></tr></tbody></table></center></td></tr></tbody></table></div>';

        return $begining.$content.$ending;
    }

    public function installExtensions()
    {
        $dirs = acym_getFolders(ACYM_BACK.'extensions');
        if (empty($dirs)) return;

        $extensionsToPublish = [
            'acymtriggers',
            'jceacym',
        ];
        $existingExtensions = acym_loadResultArray('SELECT `element` FROM #__extensions WHERE `type` = "plugin" AND `folder` = "system" AND `element` IN ("'.implode('", "', $extensionsToPublish).'")');

        if (!empty($existingExtensions)) {
            $extensionsToPublish = array_diff($extensionsToPublish, $existingExtensions);
        }

        $installer = JInstaller::getInstance();
        foreach ($dirs as $oneExtension) {
            $installer->install(ACYM_BACK.'extensions'.DS.$oneExtension);
        }

        acym_query('UPDATE #__extensions SET `enabled` = 1 WHERE `type` = "plugin" AND `folder` = "system" AND `element` IN ("'.implode('", "', $extensionsToPublish).'")');

        acym_deleteFolder(ACYM_BACK.'extensions');
    }
}
