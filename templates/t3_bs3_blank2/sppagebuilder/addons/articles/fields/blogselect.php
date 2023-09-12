<?php
/**
* @package Helix3 Framework
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2015 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/  

//no direct accees
defined ('_JEXEC') or die ('resticted aceess');
$doc = JFactory::getDocument();

$path = dirname(dirname( __DIR__ )) .'/articles/tmpl/';
//print_r($path);
$entries = scandir(''.$path.'');
$bloglist = array();
foreach($entries as $entry) {
    $bloglist[$entry] = $entry;
}
$bloglist = array_slice($bloglist, 2);