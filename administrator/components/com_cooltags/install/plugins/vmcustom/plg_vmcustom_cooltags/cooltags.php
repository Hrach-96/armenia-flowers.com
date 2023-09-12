<?php
defined('_JEXEC') or 	die( 'Direct Access to ' . basename( __FILE__ ) . ' is not allowed.' ) ;
if (!class_exists('vmCustomPlugin')) require(JPATH_VM_PLUGINS . '/vmcustomplugin.php');
class plgVmCustomCooltags extends vmCustomPlugin {
	function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$varsToPush = array(
			'product_tags'=>array('','string')
		);
		$this->setConfigParameterable ('customfield_params', $varsToPush);
	}

	function plgVmOnProductEdit($field, $product_id, &$row,&$retValue)
	{
		if ($field->custom_element != $this->_name) return '';

		if (empty($field->product_tags) )
			$product_tags = '';
		else
			$product_tags = $field->product_tags;

		$html ='<script src="../plugins/vmcustom/cooltags/js/tags.js"></script>
                <link rel="stylesheet" href="../plugins/vmcustom/cooltags/css/tags.css" type="text/css" />
                <fieldset><legend><i class="icon-tags"></i>  '. JText::_('VMCUSTOM_COOLTAGS_SEPARATEDTAGS') .'</legend><table class="admintable">';
		$html .= '<tr><td></td><td><div class="vm_tag_container">';
        $html .= '<input type="hidden" class="vm_tag_full" id="product_tags'.$row.'" name="customfield_params['.$row.'][product_tags]" value="'.$product_tags.'">';
        $product_tags = explode(',', $product_tags);

        foreach($product_tags as $tag){
            $html .= '<div><input class="vm_tag" type="text" size="80" maxlength="255" value="'.$tag.'"><span class="vmicon tag_delete"></span></div>';
        }

        $html .= '</div><a class="tag_add" href="#nogo">Add new tag</a>';
		$html .='</td></tr></table></fieldset>';
		$retValue .= $html  ;
		$row++;
		return true  ;
	}



	function plgVmOnDisplayProductFEVM3( $product, &$group)
	{
		$html = '';
		$cparams 					= JComponentHelper::getParams('com_cooltags');
		$mode	 					= $cparams->get('mode','1');
		$cooltags_itemid 			= $cparams->get('cooltags_itemid');
		if($cooltags_itemid=='')
			$cooltags_itemid = JFactory::getApplication()->input->get('Itemid','', 'int');
		$product_tags = &$group->product_tags;
		
		$sep_tags = explode(',',$product_tags);
		$product_tags_html = '';
			
		foreach($sep_tags as $sep_tag)
		{
			$sep_tag = strtolower($sep_tag);
			if($mode==1)
				$tag_url = JRoute::_('index.php?option=com_cooltags&view=productslist&tag='.$sep_tag.'&Itemid='.$cooltags_itemid  );
			else
				$tag_url = JRoute::_('index.php?searchword='.$sep_tag.'&ordering=newest&searchphrase=exact&option=com_search&Itemid='.$cooltags_itemid  );
			if($sep_tag!='')
				$product_tags_html .= '<a class="btx" href="'.$tag_url.'">'.$sep_tag.'</a> ';
		}
		$html .= '<div style="padding:5px 0 3px 0">';
		$html .= '<i class="icon-tags"></i> ';
		$html .= $product_tags_html ;
		$html .= '</div>';

		if($product_tags_html !=''){
			$group->display .= $html;
			return true;
		}
    }

	function plgVmOnStoreProduct($data,$plugin_param){
		$this->tableFields = array ( 'id', 'virtuemart_product_id', 'virtuemart_custom_id' );

		return $this->OnStoreProduct($data,$plugin_param);
	}
	
	public function plgVmAddToSearch(&$where,&$PluginJoinTables,$custom_id)
	{
		if ($keyword = vRequest::uword('cooltags', null, ' '))
		{		
			if ($this->_name != $this->GetNameByCustomId($custom_id)) return;
			
			$db = JFactory::getDBO();
			
			$keyword = '"%' . $db->escape( $keyword, true ) . '%"' ;
			
			$where[] = ' SUBSTRING('.$this->_name .'.`customfield_params`,14) LIKE '.$keyword;
			
			$PluginJoinTables[] = $this->_name ;
		}
		return true;
	}
	
	protected function plgVmOnStoreInstallPluginTable($psType) {
		return $this->onStoreInstallPluginTable($psType);
	}

	function plgVmSetOnTablePluginParamsCustom($name, $id, &$table){
		return $this->setOnTablePluginParams($name, $id, $table);
	}

	function plgVmDeclarePluginParamsCustom($psType,$name,$id, &$data){
		return $this->declarePluginParams($psType, $name, $id, $data);
	}

	function plgVmOnDisplayEdit($virtuemart_custom_id,&$customPlugin){
		return $this->onDisplayEditBECustom($virtuemart_custom_id,$customPlugin);
	}

	function plgVmDeclarePluginParamsCustomVM3(&$data){
	  return $this->declarePluginParams('custom', $data);
	}
	function plgVmGetTablePluginParams($psType, $name, $id, &$xParams, &$varsToPush){
	  return $this->getTablePluginParams($psType, $name, $id, $xParams, $varsToPush);
	}
}