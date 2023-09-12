<?php
// No direct access
defined( '_JEXEC' ) or die;
error_reporting('E_ALL');

/**
 *
 * @package     Joomla.Plugin
 * @subpackage  System.Wishlists
 * @since       2.5+
 * @author		olejenya
 */
class plgSystemWishlists extends JPlugin
{
	/**
	 * Class Constructor
	 * @param object $subject
	 * @param array $config
	 */
	public function __construct( & $subject, $config )
	{
		parent::__construct( $subject, $config );
		$this->document = JFactory::getDocument();
	
	}
	function onBeforeRender() {
		$app = JFactory::getApplication();
		$doc = JFactory::getDocument();
		$user =& JFactory::getUser();
		if (!($app->isAdmin())){
			if (!$user->guest) {
				if (isset($_SESSION['id'])) {
					$dbIds = $_SESSION['id'];
					$db =& JFactory::getDBO();
					$q ="SELECT virtuemart_product_id FROM #__wishlists WHERE userid =".$user->id;
					$db->setQuery($q);
					$allproducts = $db->loadAssocList();
					foreach($allproducts as $productbd){
						$allprod['ids'][] = $productbd['virtuemart_product_id'];
					}
					$sessionWP = isset($allprod['ids']) ? $allprod['ids'] : array();

					//print_r($productbd['virtuemart_product_id']);
					for($r=0; $r<count($dbIds); $r++) {
						if(!in_array($dbIds[$r],$sessionWP)) {
					   $q = "";
						$q = "INSERT INTO `#__wishlists`
								(virtuemart_product_id,userid )
								VALUES
								('".$dbIds[$r]."','".$user->id."') ";
								//var_dump ($dbIds[$r]);
						$db->setQuery($q);
						//$db->queryBatch();
						$db->query();
					   }
				   }
				//unset($_SESSION['id']);
			   }
		   }
		}

	}


}  ?>