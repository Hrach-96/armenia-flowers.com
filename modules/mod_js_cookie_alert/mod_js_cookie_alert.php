<?php


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// include the helper file
require_once(dirname(__FILE__).DS.'helper.php');

$jscalert = modJSCAlert::getCAlert( $params );
require( JModuleHelper::getLayoutPath( 'mod_js_cookie_alert' ) );