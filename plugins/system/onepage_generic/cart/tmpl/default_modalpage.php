<?php
/**
** Parts of this code is written by joomlapro.com Copyright (c) 2012, 2015 All Right Reserved.
** Many part of this code is from VirtueMart Team Copyright (c) 2004 - 2015. All rights reserved.
** Some parts might even be Joomla and is Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved. 
** http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
** This source is free software. This version may have been modified pursuant
** to the GNU General Public License, and as distributed it includes or
** is derivative of works licensed under the GNU General Public License or
** other free or open source software licenses.
**
** THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY 
** KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
** IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
** PARTICULAR PURPOSE.

** <author>Joomlaproffs / Virtuemart team</author>
** <email>info@joomlapro.com</email>
** <date>2017</date>
*/
defined('_JEXEC') or die('Restricted access');

$plugin=JPluginHelper::getPlugin('system','onepage_generic');
$params=new JRegistry($plugin->params);
$popupaddress = $params->get("popup_address", 1);
$button_primary_class  = $params->get("button_primary","opg-button-primary");
$button_danger_class  = $params->get("button_danger","opg-button-danger");

if(VmConfig::get('oncheckout_show_legal_info',1))
{
  ?>
	  <div id="full-tos" class="opg-modal">
		  <div class="opg-modal-dialog opg-text-left">
	        <a href="Javascript:void(0);" class="opg-modal-close opg-close"></a>
				<strong><?php echo JText::_('COM_VIRTUEMART_CART_TOS'); ?></strong>
			<?php echo $this->cart->vendor->vendor_terms_of_service;?>
		  </div>
	 </div>
  <?php
}

if($popupaddress > 1)
{
?>
<div id="billtopopup" class="opg-modal"><!-- Billto Modal Started -->
	 <div class="opg-modal-dialog"><!-- Billto Modal Started -->
	   <a href="Javascript:void(0);" class="opg-modal-close opg-close"></a>
    	<div class="opg-modal-header"><h5 class="opg-panel-title"><?php echo JText::_('PLG_SYSTEM_VMUIKIT_CHANGE_BILLTO_ADDRESS_HEADING'); ?></h5></div>

	  <?php 
	  	echo '<div class="adminform" id="billto_fields_div" style="margin:0;">';
		$skipped_fields_array = array('customer_note', 'agreed','name','username','password','password2','email'); 
		foreach($this->cart->BTaddress["fields"] as $singlefield) {
         
		 if($singlefield['formcode'] != "")
		 {
		    if(in_array($singlefield['name'],$skipped_fields_array)) {
				continue;
			}
			echo "<div class='opg-width-1-1 opg-margin-small'>";
			if($singlefield['type'] == "select")
	        {	
			  $singlefield['formcode']=str_replace('vm-chzn-select','',$singlefield['formcode']);
		      echo '<label class="' . $singlefield['name'] . '" for="' . $singlefield['name'] . '_field">';
		      echo $singlefield['title'] . ($singlefield['required'] ? ' *' : '');
		      echo '</label><br />';
			}
			else if($singlefield['type'] == "checkbox") 
			{
			  $singlefield['formcode']= '<label>'.$singlefield["formcode"].$singlefield["title"].'</label>';
			}
			else
			{
			 $singlefield['formcode']=str_replace('<input','<input placeholder="'.$singlefield['title'].'"' ,$singlefield['formcode']);
			 $singlefield['formcode']=str_replace('size="30"','' ,$singlefield['formcode']);
			}

		    if($singlefield['name']=='zip') {
			    $replacetext = 'input ';
		    	$singlefield['formcode']=str_replace('input', $replacetext ,$singlefield['formcode']);
		    } 
			else if($singlefield['name']=='title') {
				$singlefield['formcode']=str_replace('vm-chzn-select','',$singlefield['formcode']);
		    }
		    echo $singlefield['formcode'];
			echo '</div>';
	      }
		}
	    echo '</div>';
	?>
	  <div class="opg-modal-footer">
	  	 <a class="opg-button <?php echo $button_primary_class; ?>" href="Javascript:void(0);" onclick="validatebillto('no');"><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_SUBMIT"); ?></a>
		 <a id="shiptoclose" href="Javascript:void(0);" class="opg-modal-close opg-button"><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_CANCEL"); ?></a>
		 
		 <a id="billtoclose" href="Javascript:void(0);" onclick="removebillto();" class="opg-modal-close opg-margin-left opg-button <?php echo $button_danger_class; ?>"><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_REMOVE_BILLTO"); ?></a>
	  </div>
    </div> <!-- Billto Modal ended -->
</div><!-- Billto Modal ended -->

<?php
}
else
{
?>
<div id="shiptopopup" class="opg-modal"><!-- Shipto Modal Started -->
	 <div class="opg-modal-dialog"><!-- Shipto Modal Started -->
		<a href="Javascript:void(0);" class="opg-modal-close opg-close"></a>
    	   <div class="opg-modal-header"><h5 class="opg-panel-title"><?php echo JText::_('PLG_SYSTEM_VMUIKIT_CHANGE_SHIP_ADDRESS_HEADING'); ?></h5></div>
      <label class="opg-text-small opg-hidden">
	  <?php 
	    $samebt = "";
		if($this->cart->STsameAsBT == 0)
		{
			$samebt = '';
			$shiptodisplay = "";
			
		}
	    else if($params->get('check_shipto_address') == 1)
		{
			$samebt = 'checked="checked"';
			$shiptodisplay = "";
		}
		else
		{
		   $samebt = '';
		   $shiptodisplay = "";
		}
	
		
	  ?> 
      <input class="inputbox opg-hidden" type="checkbox" name="STsameAsBT" checked="checked" id="STsameAsBT" value="1"/>
	  
	  <?php
		if(!empty($this->cart->STaddress['fields'])){
			if(!class_exists('VmHtml'))require(JPATH_VM_ADMINISTRATOR.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'html.php');
				echo JText::_('COM_VIRTUEMART_USER_FORM_ST_SAME_AS_BT');
		?>
		</label>
      <?php
		}
 		?>
        <?php
		
		$show_shiptoaddress_list = $params->get("show_shiptoaddress_list", 1); 
		if(!empty($this->cart->lists['shipTo']) && $show_shiptoaddress_list){
				echo $this->cart->lists['shipTo'];
				?>
                  <a class="opg-button" style="margin-top:10px; margin-bottom:10px;" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=user&task=editaddresscart&addrtype=ST&virtuemart_user_id[]=' . $this->cart->lists['current_id'], $this->useXHTML, $this->useSSL) ?>" rel="nofollow">
			<?php echo vmText::_ ('COM_VIRTUEMART_USER_FORM_ADD_SHIPTO_LBL'); ?>
				  </a>
                <?php
		}
		if(empty($this->cart->lists['current_id']))
		{
		  $this->cart->lists['current_id'] = 0;	
		}
		?>
      

    <?php if(!isset($this->cart->lists['current_id'])) $this->cart->lists['current_id'] = 0; ?>
    <?php
		echo '	<div class="adminform" id="shipto_fields_div" style="'.$shiptodisplay.'">';
		foreach($this->cart->STaddress["fields"] as $singlefield) {
		 echo '<div class="opg-width-1-1 opg-margin-small">';
	     if($singlefield['type'] == "select")
	      {		
		    echo '<label class="' . $singlefield['name'] . '" for="' . $singlefield['name'] . '_field">';
		    echo $singlefield['title'] . ($singlefield['required'] ? ' *' : '');
		    echo '</label><br/>';
		  }
		  else if($singlefield['type'] == "checkbox") 
		  {
		    $singlefield['formcode']= '<label>'.$singlefield["formcode"].$singlefield["title"].'</label>';
		  }
		  else
		  {
		    $singlefield['formcode']=str_replace('<input','<input placeholder="'.$singlefield['title'].'"' ,$singlefield['formcode']);
		  }
	    if($singlefield['name']=='shipto_zip') {
			// onchange="javascript:updateaddress(3);"
			  $replacetext = 'input';
			  $singlefield['formcode']=str_replace('input', $replacetext ,$singlefield['formcode']);
	    } 
		else if($singlefield['name']=='customer_note') {
		}
		else if($singlefield['name']=='shipto_virtuemart_country_id') {
		    	//$singlefield['formcode']=str_replace('<select','<select onchange="javascript:updateaddress(1);"',$singlefield['formcode']);
		    	$singlefield['formcode']=str_replace('class="virtuemart_country_id','class="shipto_virtuemart_country_id',$singlefield['formcode']);
				$singlefield['formcode']=str_replace('vm-chzn-select','',$singlefield['formcode']);

    	}else if($singlefield['name']=='shipto_virtuemart_state_id') {
	    	$singlefield['formcode']=str_replace('id="virtuemart_state_id"','id="shipto_virtuemart_state_id"',$singlefield['formcode']);
	        $replacetext = '<select onchange="javascript:updateaddress(2);"';
			$replacetext = "<select ";
	    	$singlefield['formcode']=str_replace('<select',$replacetext,$singlefield['formcode']);
			if($singlefield['required'])
			{
				  $singlefield['formcode']=str_replace('vm-chzn-select','required',$singlefield['formcode']);
			}
			else
			{
			   $singlefield['formcode']=str_replace('vm-chzn-select','',$singlefield['formcode']);
			} 
	    }
	    echo $singlefield['formcode'];
		echo '</div>';
	}	
    echo '</div>';
	?>
	  <div class="opg-modal-footer">
	  	 <a class="opg-button <?php echo $button_primary_class;  ?>" href="Javascript:void(0);" onclick="validateshipto();"><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_SUBMIT"); ?></a>
		 <a  href="Javascript:void(0);" id="shiptoclose" class="opg-modal-close opg-button"><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_CANCEL"); ?></a>
		 
		 <a href="Javascript:void(0);" id="shiptoclose" onclick="removeshipto();" class="opg-modal-close opg-margin-left opg-button <?php echo $button_danger_class; ?>"><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_REMOVE_SHIPTO"); ?></a>
	  </div>
    </div> <!-- Shipto Modal ended -->
</div><!-- Shipto Modal ended -->
<?php
}
  $customernote = FALSE;
  foreach($this->cart->BTaddress["fields"] as $field) 
  {
     if($field['name']=='customer_note') 
 	 {
	   $customernote = true;
	   $singlefield = $field;
	   break;
	 }
  } 
  foreach($this->cart->STaddress["fields"] as $field) 
  {
     if($field['name']=='customer_note') 
 	 {
	   $customernote = true;
	   $singlefield = $field;
	   break;
	 }
  } 
  foreach($this->userFieldsCart["fields"] as $field) 
  {
     if($field['name']=='customer_note') 
 	 {
	   $customernote = true;
	   $singlefield = $field;
	   break;
	 }
  } 
   if($customernote) 
	 {
	 ?>
    <div id="commentpopup" class="opg-modal"><!-- Comment Modal Started -->
	 <div class="opg-modal-dialog"><!-- Comment Modal Started -->
		<a href="Javascript:void(0);" class="opg-modal-close opg-close"></a>
    	   <div class="opg-modal-header"><h5 class="opg-panel-title"><?php echo JText::_('COM_VIRTUEMART_COMMENT_CART'); ?></h5></div>
		   <div id="extracomments" class="customer-comments">
		   <?php
			   if($singlefield['required'])
			   {
			     $tmptext = "";
				 $tmptext = str_replace("<textarea", '<textarea class="required"', $tmptext);
				 echo $tmptext;

			   }
			   else
			   {
			    	echo $singlefield['formcode'];
			   }
			   ?>
		   </div>
		   <div class="opg-modal-footer">
	  			 <a class="opg-button <?php echo $button_primary_class;  ?>" href="Javascript:void(0);" onclick="validatecomment();"><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_SUBMIT"); ?></a>
				 <a href="Javascript:void(0);" id="commentclose" class="opg-modal-close opg-button"><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_CANCEL"); ?></a>
                  <a href="Javascript:void(0);" onclick="removeomment()" id="commentclose" class="opg-modal-close opg-button opg-button-danger"><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_CLEAR"); ?></a>
		   </div>
    </div> <!-- comments Modal ended -->
	</div><!-- comments Modal ended -->
   <?php
   }

?>
<!-- SHIPMENT SELECT MODAL START -->
<?php
	  $listshipments = $params->get("list_allshipment", 0);				
	  if(!$listshipments)
	  { //IF NOT LIST SHIPMENTS START
				  echo '<div id="shipmentdiv" class="opg-modal">';
				   echo '<div class="opg-modal-dialog">';
				    echo '<a href="Javascript:void(0);" class="opg-modal-close opg-close"></a>';
				     echo '<div class="opg-modal-header"><h5 class="opg-panel-title">'.JText::_("COM_VIRTUEMART_CART_SELECT_SHIPMENT").'</h5></div>';
				      echo "<fieldset id='shipment_selection'>";					
					   echo '<ul class="opg-list" id="shipment_ul">';
						foreach($this->shipments_shipment_rates as $rates) 
						{
						     if(strpos($rates, "checked") !== false)
							 {
							   $actclass = "liselcted";
							 }
							 else
							 {
							   $actclass = "";
							 }
						     echo '<li class="'.$actclass.'">';
							 echo '<label class="opg-width-1-1">'.$rates.'</label>';
							 echo '</li><hr class="opg-hr opg-margin-small-bottom opg-margin-small-top" />';
						}
					echo "</ul>";
					echo "</fieldset>";
					
			
				?>
				<div class="opg-modal-footer">
				<a href="Javascript:void(0);" class="opg-button <?php echo $button_primary_class;  ?>" id="shipmentset"><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_SUBMIT"); ?></a>
				<a href="Javascript:void(0);" id="shipmentclose" class="opg-modal-close opg-button"><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_CANCEL"); ?></a>
				</div>
				<?php
				echo '</div>';
				echo '</div>';
		} //IF NOT LIST SHIPMENTS END
				?>
<!-- SHHIPMENT SELECT MODAL ENDIRECTORY_SEPARATOR -->
<!-- PAYMENT SELECT MODAL STARTS -->
<?php
		 $listpayments = $params->get("list_allpayment", 0);	
         if(!$listpayments)
		 {  //IF NOT LIST PAYMENTS START
		    echo '<div id="paymentdiv" class="opg-modal">';
		    echo '<div class="opg-modal-dialog">';
			    echo '<a href="Javascript:void(0);" class="opg-modal-close opg-close"></a>';
			      echo '<div class="opg-modal-header"><h5 class="opg-panel-title">'.JText::_("COM_VIRTUEMART_CART_SELECT_PAYMENT").'</h5></div>';
			  	  $paymentsarr = $this->paymentplugins_paymentsnew;
				   echo '<div id="paymentsdiv">';
					echo '<ul class="opg-list" id="payment_ul">';
						foreach($paymentsarr as $pay)
						{
						  $pos = strpos($pay, '</span></span>');
						  $pay = substr($pay, 0, $pos);
						  echo '<li>'.$pay.'</li><hr class="opg-margin-small-bottom opg-margin-small-top" />';
						}
					echo '</ul>';
				  echo '</div>';
			?>
			<div class="opg-modal-footer">
			<a href="Javascript:void(0);" class="opg-button <?php echo $button_primary_class;  ?>" id="paymentset"><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_SUBMIT"); ?></a>
			<a href="Javascript:void(0);" id="paymentclose" class="opg-modal-close opg-button"><?php echo JText::_("PLG_SYSTEM_VMUIKIT_ONEPAGE_CANCEL"); ?></a>
			</div>
			<?php
			echo '</div>';
			echo '</div>';
		} //IF NOT LIST PAYMENTS END
   ?>
 <!-- PAYMENT SELECT MODAL ENDIRECTORY_SEPARATOR -->