<?php
defined( '_JEXEC' ) or die( 'Restricted access' ); 
jimport('joomla.installer.installer');
jimport('joomla.installer.helper');

class com_cooltagsInstallerScript
{
	
	function install($parent) 
	{
		echo '<h1><img src="components/com_cooltags/assets/img/logo_90x90.png" alt="logo" width="90" height="90" style="vertical-align:center" /> CoolTags Component Installation</h1>';
		$app = JFactory::getApplication();			
		$error = 0;		
		$cache =  JFactory::getCache();
		$cache->clean( null, 'com_cooltags' );
		$db	= JFactory::getDBO();
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');		
					
		$install = '<table class="table table-condensed table-striped"><tbody>
		<tr><td><span class="icon-ok"></span> CoolTags Component installed successfully</td></tr>';
		

		$module_installer = new JInstaller;
		$file_origin = JPATH_ADMINISTRATOR.'/components/com_cooltags/install/modules/mod_cooltags_cloud';
		if( $module_installer->install( $file_origin ) )
		{
			$q = "UPDATE #__modules SET ordering='1', published='1' WHERE `module`='mod_cooltags_cloud'";
			$db->setQuery( $q );
			$db->query();	
			$install .= '<tr><td><span class="icon-ok"></span> Cooltags Cloud module Installed successfully</td></tr>';
		} else $error++;
		
		$plugin_installer = new JInstaller;
		$file_origin = JPATH_ADMINISTRATOR.'/components/com_cooltags/install/plugins/vmcustom/plg_vmcustom_cooltags';
		if( $plugin_installer->install( $file_origin ) )
		{	
			$q = "UPDATE #__extensions SET  enabled='1' WHERE `element`='plg_vmcustom_cooltags'";
			$db->setQuery( $q );
			$db->query();
			$install .= '<tr><td><span class="icon-ok"></span> Cooltags VMcustom plugin Installed successfully. Create the Product Tags custom field in Virtuemart backend and add it to your products with comma separated tags</td></tr>';
		}
		else $error++;
		
		
		$plugin_installer = new JInstaller;
		$file_origin = JPATH_ADMINISTRATOR.'/components/com_cooltags/install/plugins/search/plg_search_cooltagsearch';
		if( $plugin_installer->install( $file_origin ) )
		{	
			$q = "UPDATE #__extensions SET  enabled='1' WHERE `element`='plg_search_cooltagsearch'";
			$db->setQuery( $q );
			$db->query();
			$install .= '<tr><td><span class="icon-ok"></span> Cooltags Joomla Search plugin Installed and enabled successfully.</td></tr>';
		}
		else $error++;
		
		
		$install .= '</tbody></table>';
		
		$install .='<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FNordmograph-Web-marketing-and-Joomla-expertise%2F368385633962&amp;width&amp;layout=button_count&amp;action=recommend&amp;show_faces=false&amp;share=false&amp;height=21&amp;appId=739550822721946" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe>';
		
		$install .='<div style="text-align:center;padding:0 0 100px; 0"><h3>Start here:</h3><br /><a href="index.php?option=com_config&view=component&component=com_cooltags" class="btn btn-success btn-large"><span class="icon-cog"></span> CoolTags Component Settings</a></div>';
		
		echo $install;
	}

function update($parent) 
{  
	$app = JFactory::getApplication();			
		$error = 0;		
		$cache =  JFactory::getCache();
		$cache->clean( null, 'com_cooltags' );
		$db	= JFactory::getDBO();
		jimport('joomla.filesystem.folder');
				jimport('joomla.filesystem.file');	
				
				
		$update ='';
	
		$module_installer = new JInstaller;
		$file_origin = JPATH_ADMINISTRATOR.'/components/com_cooltags/install/modules/mod_cooltags_cloud';
		if( $module_installer->install( $file_origin ) )
		{
			$q = "UPDATE #__modules SET ordering='1', published='1' WHERE `module`='mod_cooltags_cloud'";
			$db->setQuery( $q );
			$db->query();	
			$update .= '<div class="alert alert-success" >Installing/updating module was also successfull.</div>';
		}
		else $error++;
		
		$plugin_installer = new JInstaller;
		$file_origin = JPATH_ADMINISTRATOR.'/components/com_cooltags/install/plugins/vmcustom/plg_vmcustom_cooltags';
		if( $plugin_installer->install( $file_origin ) )
		{	
			$update .= '<div class="alert alert-success" > Cooltags VMcustom plugin updateded successfully. Create the Product Tags custom field In Virtuemart backend and add it to your products with comma separated tags</div>';
		}
		else $error++;
		
		
		$plugin_installer = new JInstaller;
		$file_origin = JPATH_ADMINISTRATOR.'/components/com_cooltags/install/plugins/search/plg_search_cooltagsearch';
		if( $plugin_installer->install( $file_origin ) )
		{	
			$update .= '<div class="alert alert-success" > Cooltags Joomla Search plugin updated successfully.</div>';
		}
		else $error++;
		
		
		
		
		


  $update .='<div style="text-align:center;padding:0 0 100px; 0"><br /><a href="index.php?option=com_config&view=component&component=com_cooltags" class="btn btn-success btn-large"><span class="icon-location"></span> CoolTags Settings</a></div>';
  echo $update;
}

function preflight($type, $parent) 
{
 // ...
}
 
function postflight($type, $parent)
{
  //...
}

}