<?php
// No direct access
defined('_JEXEC') or die;


class CooltagsHelper
{
	public static function addSubmenu($vName = '')
	{

	}

	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_cooltags';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}
