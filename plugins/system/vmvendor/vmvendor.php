<?php
// No direct access
defined( '_JEXEC' ) or die;
/**
 *
 * @package     Joomla.Plugin
 * @subpackage  System.Vmvendor
 * @since       2.5+
 * @author        velikorodnov
 */
 jimport('joomla.plugin.plugin');
class plgSystemVmvendor extends JPlugin
{
    /**
     * Class Constructor
     * @param object $subject
     * @param array $config
     */
    public function __construct( & $subject, $config )
    {
        parent::__construct( $subject, $config );
        $this->loadLanguage();
    }
    public function onBeforeRender(){
    $app = JFactory::getApplication();
        $doc = JFactory::getDocument();
        if( !$app->isSite()){
            $option   = $app->input->getCmd('option', '');
            $view     = $app->input->getCmd('view', '');
            if (($option == 'com_virtuemart') && ($view == 'user')){
                $jsq='
                
                jQuery(document).ready(function () {
                    var publish = jQuery("#toolbar-publish button").attr("onclick");
                    var unpublish = jQuery("#toolbar-unpublish button").attr("onclick");
                    //alert(publish.search("user_is_vendor.1"));
                    //alert(unpublish.indexOf("user_is_vendor.0"));
                    //alert(publish);
                    //alert(unpublish);
                    jQuery("#toolbar-publish button").attr("onclick","").unbind("click");
                    jQuery("#toolbar-unpublish button").attr("onclick","").unbind("click");
                    jQuery("#toolbar-publish").live("click", function(event){
                        if (publish.search("user_is_vendor.1")!= -1){
                            event.preventDefault();
                            var datastring = jQuery("#adminForm").serialize();
                            var frm = jQuery("#adminForm");
                            jQuery.ajax({
                                        type: frm.attr("method"),
                                        url: "?action=addVendor",
                                        data: datastring,
                                        dataType: "json",
                                        success: function(data) {
                                            //var obj = jQuery.parseJSON(data); if the dataType is not specified as json uncomment this
                                            // do what ever you want with the server response
                                            alert(data.message);
                                        },
                                        error: function(){
                                              alert("error handing here");
                                        }
                                    });
                        }
                        return false;
                    });
                    jQuery("#toolbar-unpublish").live("click", function(event){
                        if (unpublish.search("user_is_vendor.0")!= -1){
                            event.preventDefault();
                            var datastring = jQuery("#adminForm").serialize();
                            var frm = jQuery("#adminForm");
                            jQuery.ajax({
                                        type: frm.attr("method"),
                                        url: "?action=removeVendor",
                                        data: datastring,
                                        dataType: "json",
                                        success: function(data) {
                                            //var obj = jQuery.parseJSON(data); if the dataType is not specified as json uncomment this
                                            // do what ever you want with the server response
                                            alert(data.remmessage);
                                        },
                                        error: function(){
                                              alert("error handing here");
                                        }
                                    });
                        }
                        return false;
                    });
                });
                ' ;
                $doc->addScriptDeclaration($jsq);
            }
        }
    }

    public function onAfterInitialise(){
        $this->addVendor();
        $this->remVendor();
    }
    public function addVendor(){
        $input = JFactory::getApplication()->input;
        if($input->getCmd('action') === 'addVendor'){
            $cid= $_POST['cid'];
            $boxchecked = $_POST['boxchecked'];
            //var_dump ($cid);
            //var_dump ($boxchecked);
            //echo json_encode($vendordataadd);
			if($boxchecked > 0){
				$db = JFactory::getDbo();
				$q ="SELECT virtuemart_user_id FROM #__virtuemart_vmusers WHERE virtuemart_user_id > 0;";
				$db->setQuery($q);
				$ven_null = $db->loadAssocList();
				//var_dump ($ven_null[0]['virtuemart_vendor_id']);
				if ($ven_null[0]['virtuemart_user_id'] >0){
					for($r=0; $r<count($cid); $r++) {
						//var_dump($cid[$r]);
						$query = $db->getQuery(true);
						$fields = array(
							$db->quoteName('user_is_vendor') . ' =  1',
							$db->quoteName('virtuemart_vendor_id') . ' = 1'
						);
						//var_dump ($conditions);
						$query->update($db->quoteName('#__virtuemart_vmusers'))->set($fields)->where($db->quoteName('virtuemart_user_id'). ' = "'.$cid[$r].'"');
						$db->setQuery($query);
						$result = $db->execute();
					}
					 $this->addshowJSON(true, 'The user with virtuemart is set as vendor');
				}else {
					 $this->addshowJSON(true, 'Please first create vendor this shop');
				}
				//var_dump ($result);
            
			}else {
				$this->addshowJSON(true, 'Please first make a selection from the list');
			}
        }
    }
    public function addshowJSON($result, $message=''){
        echo json_encode(array('result'=>$result, 'message'=>$message));
        exit;
    }
    public function remVendor(){
        $input = JFactory::getApplication()->input;
         if($input->getCmd('action') === 'removeVendor'){
            $cid= $_POST['cid'];
            $boxchecked = $_POST['boxchecked'];
            //var_dump ($cid);
            //var_dump ($boxchecked);
            //echo json_encode($vendordataadd);
			if($boxchecked > 0){
				$db = JFactory::getDbo();
				for($r=0; $r<count($cid); $r++) {
					//var_dump($cid[$r]);
					$query = $db->getQuery(true);
					$fields = array(
						$db->quoteName('user_is_vendor') . ' =  0',
						$db->quoteName('virtuemart_vendor_id') . ' = 0'
					);
					//var_dump ($conditions);
					$query->update($db->quoteName('#__virtuemart_vmusers'))->set($fields)->where($db->quoteName('virtuemart_user_id'). ' = "'.$cid[$r].'"');
					$db->setQuery($query);
					$result = $db->execute();
				}
				//var_dump ($result);
             $this->removeshowJSON(true, 'The user with virtuemart is remove as vendor');
			}else {
				$this->removeshowJSON(true, 'Please first make a selection from the list');
			}
        }
    }
    public function removeshowJSON($remresult, $remmessage=''){
        echo json_encode(array('remresult'=>$remresult, 'remmessage'=>$remmessage));
        exit;
    }
}


