<?php
// no direct access
defined('_JEXEC') or die;

require_once dirname(__FILE__).'/helper.php';
$list = modCooltagsCloudHelper::getList($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_cooltags_cloud', $params->get('layout', 'default'));