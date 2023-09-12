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


//init Joomla Framework
define( '_JEXEC', 1 );

define( 'JPATH_BASE', realpath(dirname(__FILE__).'/../../../../..' )); // print this out or observe errors to see which directory you should be in (this is two subfolders in)
define( 'DS', DIRECTORY_SEPARATOR );

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
require_once ( JPATH_BASE .DS.'administrator'.DS.'components'.DS.'com_menus'.DS.'models'.DS.'items.php' );
require_once ( JPATH_CONFIGURATION   .DS.'configuration.php' );
require_once ( JPATH_LIBRARIES .DS.'joomla'.DS.'database'.DS.'database.php' );
require_once ( JPATH_LIBRARIES .DS.'cms'.DS.'version'.DS.'version.php' );
require_once ( JPATH_LIBRARIES .DS.'import.php' );



//DB Connection
$Config = new JConfig();
$db_driver      = $Config->dbtype;   // Database driver name
$db_host        = $Config->host;     // Database host name
$db_user        = $Config->user;     // User for database authentication
$db_pass        = $Config->password; // Password for database authentication
$db_name        = $Config->db;       // Database name
$db_prefix      = $Config->dbprefix; // Database prefix (may be empty)

$version = new JVersion();
$version = (float)$version->RELEASE;

if($version < 3){
    require_once ( JPATH_BASE .DS.'libraries'.DS.'joomla'.DS.'database'.DS.'table.php' );
}

// Database prefix (if empty then remove prefixing double underscore)
$db_prefix      = (trim($db_prefix)=="") ? "":$db_prefix;

$db_connect = mysql_connect($db_host,$db_user,$db_pass);
mysql_select_db($db_name, $db_connect);


function getChildren($parent, $db_prefix, $alias, $menu_id, $lft, $language, $version){
    if($menu_id){
        $query = mysql_query("SELECT * FROM `".$db_prefix."menu` WHERE `parent_id` = '".$menu_id."'");
        if(mysql_num_rows($query)) {
            while ($cat = mysql_fetch_object($query)) {
                mysql_query("delete from `".$db_prefix."menu` where `id` = ".$cat->id);
                removeChildren($cat->id, $db_prefix);
            }
        }
    }

    $query = mysql_query("SELECT * FROM `".$db_prefix."virtuemart_category_categories` WHERE `category_parent_id` = '".$parent."' order by `ordering`");
    if(mysql_num_rows($query)){
        $lang = $language;
        while($cat = mysql_fetch_object($query)){
            if($language == '*'){
                $language = 'en_gb';
            } else {
                $language = str_replace('-', '_', strtolower($language));
            }
            $cat_details = mysql_fetch_object(mysql_query("SELECT * FROM `".$db_prefix."virtuemart_categories_".$language."` WHERE `virtuemart_category_id` = '".$cat->category_child_id."'"));
            if(isset($cat_details->category_name) && $cat_details->category_name){
                $path = $alias.'/'.$cat_details->slug;

                $level = substr_count($path, '/') + 1;

                $rgt = mysql_fetch_object(mysql_query("SELECT max(`rgt`) as `rgt` FROM `".$db_prefix."menu`"));

                $new_lft = $lft + 2;
                $new_rgt = $lft + 3;

                if($version < 3){
                    mysql_query("INSERT INTO `".$db_prefix."menu` (`menutype`, `title`, `alias`, `note`, `path`, `link`, `type`, `published`, `parent_id`, `level`, `component_id`, `ordering`, `checked_out`, `checked_out_time`, `browserNav`, `access`, `img`, `template_style_id`, `params`, `lft`, `rgt`, `home`, `language`, `client_id`) VALUES
('".$_GET['menu_name']."', '".$cat_details->category_name."', '".$cat_details->slug."', '', '".$path."', 'index.php?option=com_virtuemart&view=category&virtuemart_category_id=".$cat_details->virtuemart_category_id."&categorylayout=0', 'component', 1, ".$menu_id.", ".$level.", 10000, 0, 0, '', 0, 1, '', 0, '{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_text\":1,\"page_title\":\"".$cat_details->category_name."\",\"show_page_heading\":0,\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}', 0, 0, 0, '".$lang."', 0);");
                } else {
                    mysql_query("INSERT INTO `".$db_prefix."menu` (`menutype`, `title`, `alias`, `note`, `path`, `link`, `type`, `published`, `parent_id`, `level`, `component_id`,  `checked_out`, `checked_out_time`, `browserNav`, `access`, `img`, `template_style_id`, `params`, `lft`, `rgt`, `home`, `language`, `client_id`) VALUES
('".$_GET['menu_name']."', '".$cat_details->category_name."', '".$cat_details->slug."', '', '".$path."', 'index.php?option=com_virtuemart&view=category&virtuemart_category_id=".$cat_details->virtuemart_category_id."&categorylayout=0', 'component', 1, ".$menu_id.", ".$level.", 10000, 0,  '', 0, 1, '', 0, '{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_text\":1,\"page_title\":\"".$cat_details->category_name."\",\"show_page_heading\":0,\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}', 0, 0, 0, '".$lang."', 0);");
                }

                $id = mysql_insert_id();

                getChildren($cat->category_child_id, $db_prefix, $alias, $id, $new_rgt+1, $lang, $version);
            }
        }
    }
}

function removeChildren($id, $db_prefix){
    if($id){
        $query = mysql_query("SELECT * FROM `".$db_prefix."menu` WHERE `parent_id` = '".$id."'");
        if(mysql_num_rows($query)) {
            while ($cat = mysql_fetch_object($query)) {
                mysql_query("delete from `".$db_prefix."menu` where `id` = ".$cat->id);
                removeChildren($cat->id, $db_prefix);
            }
        }
    }
}

// CONNECTED! so run a SQL query as per usual
$query = mysql_query("SELECT * FROM `".$db_prefix."menu` WHERE `menutype` = '".$_GET['menu_name']."' and `link` like '%index.php?option=com_virtuemart&view=category%' and `level` = 1");
while($cat = mysql_fetch_object($query)){
    preg_match_all('|virtuemart_category_id=([\d]+)|u',$cat->link, $matches);
    if(isset($matches[1][0]) && $matches[1][0]){
        $id = $matches[1][0];

        if($cat->language == '*'){
            $language = 'en_gb';
        } else {
            $language = str_replace('-', '_', strtolower($language));
        }
        $cat_details = mysql_fetch_object(mysql_query("SELECT * FROM `".$db_prefix."virtuemart_categories_".$language."` WHERE `virtuemart_category_id` = '".$id."'"));

        getChildren($id, $db_prefix, $cat_details->slug, $cat->id, $cat->rgt+1, $cat->language, $version);
    }
}

$table = &JTable::getInstance('Menu');
$table->rebuild();


?>
