<?php
// No direct access
defined( '_JEXEC' ) or die;

class plgSystemWishlistsInstallerScript
{

	function postflight( $type, $parent )
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery( true );
		$query->update( '#__extensions' )->set( 'enabled=1' )->where( 'type=' . $db->q( 'plugin' ) )->where( 'element=' . $db->q( 'wishlists' ) );
		$db->setQuery( $query )->execute();

	}
}