<?php


// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );	
	$document = & JFactory::getDocument();
	if (trim( $params->get( 'js_alert_jquery' ) ) == 1) {
	$document->addScript("https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js");
					}
	else if (trim( $params->get( 'js_alert_jquery' ) ) == 0) {
	$jscalert .= ' ';
					}
	$document->addStyleSheet(JURI::root() . 'modules/mod_js_cookie_alert/tmpl/css/style.css', 'text/css', null, array() );
	$document->addScript(JURI::root() . 'modules/mod_js_cookie_alert/tmpl/js/cookiealert.js');
	echo $jscalert;
