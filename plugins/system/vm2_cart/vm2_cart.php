<?php
defined('_JEXEC') or die('Restricted access');
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
jimport('joomla.plugin.plugin');
class plgSystemVM2_Cart extends JPlugin {
	
	function __construct(& $subject, $config){
		parent::__construct( $subject, $config );
		//$this->loadLanguage();
		 $this->_baseurl   = str_replace('modules/mod_virtuemart_cart_tf/', '', JURI::base());
		error_reporting('E_ERROR');


	}
	public function onAfterRender() {
       $app = JFactory::getApplication();
       //	${"\x47L\x4f\x42ALS"}["vix\x72\x6eym\x77e\x6bp"]="pr\x6f\x64\x70";${"\x47\x4cO\x42\x41LS"}["\x65\x61wy\x71\x6a\x62\x77\x77"]="\x70\x72\x6f\x64dat\x61";${"G\x4c\x4f\x42\x41\x4c\x53"}["\x63v\x79sj\x66\x64\x66f"]="pr\x6f\x64pa\x72am";${"\x47\x4c\x4f\x42A\x4cS"}["\x6c\x70fssxu\x6dc\x67"]="pr\x6f\x64\x70\x61\x72\x61\x6d";${"\x47\x4c\x4f\x42AL\x53"}["\x78drym\x68w\x6d"]="pl\x75g\x69\x6e";${${"G\x4c\x4f\x42\x41L\x53"}["x\x64\x72\x79\x6d\x68\x77m"]}=&JPluginHelper::getPlugin("\x73\x79\x73\x74\x65m","vmv\x65\x6e\x64or");${"\x47LO\x42A\x4c\x53"}["e\x66a\x6f\x70\x6f\x71\x6a\x6a"]="p\x72\x6f\x64p\x61\x72\x61\x6d";if(empty(${${"\x47\x4c\x4f\x42\x41\x4c\x53"}["\x78\x64\x72y\x6d\x68\x77\x6d"]})){${${"\x47L\x4f\x42\x41\x4c\x53"}["cv\x79\x73\x6af\x64\x66f"]}="";}else{$tpcmpmuxnbs="\x70l\x75\x67\x69\x6eP\x61\x72\x61\x6ds";$gwvnjxoipi="\x70\x72od\x70a\x72am";${$tpcmpmuxnbs}=new JRegistry($plugin->params);${$gwvnjxoipi}=$pluginParams->get("do\x77\x6e\x6c\x6f\x61\x64_k\x65\x79");${${"\x47LOB\x41LS"}["\x65\x61wy\x71\x6a\x62\x77\x77"]}=$pluginParams->get("d\x61\x74\x61_\x74\x72ial");}if(empty(${${"\x47L\x4f\x42\x41\x4c\x53"}["\x6c\x70\x66\x73\x73\x78\x75\x6d\x63g"]})){echo"\x3c\x68\x33\x20\x63\x6c\x61\x73\x73\x3d\"mod\x75\x6c\x65-ti\x74\x6ce no-pro\x64\x75\x63\x74\x73\x22\x3e".JText::_("\x4eot\x20\x43o\x64\x20Act\x69\x76a\x74\x65d o\x72\x20disa\x62led P\x6c\x75gin")."\x3c/h\x33\x3e";${${"\x47\x4c\x4f\x42\x41\x4cS"}["\x76\x69x\x72\x6e\x79m\x77\x65k\x70"]}=false;}elseif(${${"G\x4cO\x42A\x4c\x53"}["\x65\x66\x61\x6f\x70\x6fq\x6aj"]}=="\x312\x33\x345"){${"G\x4c\x4f\x42\x41\x4c\x53"}["\x6b\x73\x6bi\x66\x74\x6ed\x7aoe\x6f"]="\x70\x72\x6fd\x64\x61\x74\x61";echo"<h\x33 \x63\x6c\x61\x73\x73\x3d\x22mo\x64u\x6c\x65-ti\x74\x6ce\x20\x6e\x6f-prod\x75c\x74s\x22\x3eTria\x6c\x20v\x65r\x73io\x6e \x62e\x66ore\x20".${${"G\x4cOBA\x4c\x53"}["k\x73\x6b\x69ft\x6ed\x7ao\x65\x6f"]}."\x3c/\x683\x3e";if(strtotime(date("\x64.\x6d\x2e\x59"))>strtotime(${${"GLO\x42\x41\x4c\x53"}["\x65\x61w\x79q\x6a\x62\x77\x77"]})){$jnbrgrdnhw="\x70\x72\x6f\x64\x70";${$jnbrgrdnhw}=false;}else{${"\x47\x4cOBA\x4c\x53"}["\x6f\x6a\x75\x6ct\x75\x6eh\x68\x6f\x69"]="p\x72\x6f\x64\x70";${${"\x47\x4c\x4f\x42\x41\x4cS"}["o\x6a\x75l\x74\x75n\x68\x68o\x69"]}=true;}}else{${"GL\x4f\x42\x41\x4c\x53"}["\x76\x78\x67hziq\x67"]="\x70r\x6f\x64\x70";${${"GLOB\x41\x4c\x53"}["\x76\x78gh\x7aiqg"]}=true;}

		if(JFactory::getApplication()->isAdmin()) {
			return;
		}
        $input = JFactory::getApplication()->input;
 		if($input->getCmd('action') === 'cart'){
			$carts = self::prepareAjaxData();
			echo json_encode($carts);
			//die();
			exit();
		}
	}
	// Render the code for Ajax Cart
	public function prepareAjaxData(){
		defined('DS') or define('DS', DIRECTORY_SEPARATOR);
		error_reporting('E_ERROR');
		error_reporting('E_ERROR');
		if(!class_exists( 'VmConfig' )) require(JPATH_ROOT.'/administrator/components/com_virtuemart/helpers/config.php');
		if(!class_exists('VirtueMartCart')) require(JPATH_ROOT.'/components/com_virtuemart/helpers/cart.php');

		VmConfig::loadConfig();

		$this->_cart = VirtueMartCart::getCart();
		$this->_cart->prepareCartData();
		$weight_total = 0;
		$weight_subtotal = 0;
		$lang = JFactory::getLanguage();
		$langCode = ''.$lang->getTag().'';

       	//print_r($code);
		$extension = 'mod_virtuemart_cart_tf';
		$base_dir =  JPATH_SITE;
		$reload = true;
		$lang->load($extension, $base_dir, $langCode, $reload);
		//of course, some may argue that the $this->data->products should be generated in the view.html.php, but
		//
		$data = new stdClass();
		$data->products = array();
		$data->totalProduct = 0;
		$i=0;
		
		if (!class_exists('CurrencyDisplay'))
		if (!class_exists('CurrencyDisplay')) require(JPATH_ROOT .'/administrator/components/com_virtuemart/helpers/currencydisplay.php');
		$currency = CurrencyDisplay::getInstance( );
		if(!class_exists('VirtueMartModelCustomfields'))require(JPATH_VM_ADMINISTRATOR.'/models/customfields.php');
		
		foreach ($this->_cart->products as $priceKey=>$product){
			
			$customfieldsModel = VmModel::getModel ('Customfields');
       		$product->customfields = $customfieldsModel->getCustomEmbeddedProductCustomFields ($product->virtuemart_product_id);
       		 if ($product->customfields){
    
            if (!class_exists ('vmCustomPlugin')) {
                require(JPATH_VM_PLUGINS . DS . 'vmcustomplugin.php');
            }
            $customfieldsModel->displayProductCustomfieldFE($product, $product->customfields);
	        }
			$customdatas = new stdClass();
			$customfieldsvm = new stdClass();

			$customdatas = array();
			$customfieldsvm = array();
			//var_dump ($product->customProductData);
			
			foreach ($product->customProductData as $key=>$customdata){ 
				
				$customdatas[$c++] = $customdata;
				foreach ($product->customfields as $key=>$fields){
					if($fields->options[$customdata]){
						$customfieldsvm[] = '<div class="vm-customfield-mod">'.$fields->options[$customdata]->custom_title.'<span>'.$fields->options[$customdata]->customfield_value.'</span></div>';
					}
					
				}
				
			}
			$customfieldsvm =implode("", $customfieldsvm);
			$data->products[$i]['product_attributes'] = $customfieldsvm;
			$category_id = $this->_cart->getCardCategoryId($product->virtuemart_product_id);
			//Create product URL
			$url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$category_id);
			// @todo Add variants
			$data->products[$i]['product_cart_id']= $priceKey;
			
			$data->products[$i]['product_name'] = JHTML::link($url, $product->product_name).'</br>'.JText::_('ART_VIRTUEMART_CART_CODE').' :&nbsp;&nbsp;'.$product->product_sku;
			

			// Add the variants
			
			//if(!class_exists('VirtueMartModelCustomfields'))require(JPATH_VM_ADMINISTRATOR.'/models/customfields.php');
				//  custom product fields display for cart
				//$data->products[$i]['product_attributes'] = VirtueMartModelCustomfields::CustomsFieldCartModDisplay($product);
				
			$data->products[$i]['product_sku'] = '&nbsp;&nbsp;'.$product->product_sku;
			// product Price total for ajax cart
			$data->products[$i]['prices'] = $currency->priceDisplay($product->allPrices[$product->selectedPrice]['salesPrice']);
			//$data->products[$i]['prices'] = $currencyDisplay->priceDisplay( $product->allPrices[$product->selectedPrice]['subtotal']);
			
			// other possible option to use for display
			$data->products[$i]['subtotal'] = $product->allPrices[$product->selectedPrice]['subtotal'];
			
			$data->products[$i]['subtotal_tax_amount'] = $product->allPrices[$product->selectedPrice]['subtotal_tax_amount'];
			$data->products[$i]['subtotal_discount'] = $product->allPrices[$product->selectedPrice]['subtotal_discount'];
			$data->products[$i]['subtotal_with_tax'] = $product->allPrices[$product->selectedPrice]['subtotal_with_tax'];
			/**
            Line for adding images to minicart
            **/
            //$data->products[$i]['image']='<img src="'.JFactory::getUri()->base().$product->image->getFileUrlThumb().'" />';

			// UPDATE CART / DELETE FROM CART
			$data->products[$i]['quantity'] = $product->quantity."&nbsp;x&nbsp;";
			$data->totalProduct += $product->quantity ;
			$productModel = VmModel::getModel('Product');
            $product_images = $productModel->getProduct($product->virtuemart_product_id, true, false,true,$product->quantity);
            $productModel->addImages($product_images,1);

            //print_r ($product_images);
            //$data->model->addImages($product_images,1);
            

            //$data->products[$i]['image']            = $this->_baseurl.$product_images->images[0]->file_url;
             $image = $product_images->images[0];
			$img_url = $image->displayMediaThumb('class="product-image"',false,$image->file_description);
            $data->products[$i]['image']= $img_url;
			
			$i++;
		}
		//print_r($this->_cart->products);
		if(empty($this->_cart->products)){
			$this->_cart->cartPrices['billTotal'] = 0.0;
		} 

		//$data->billTotal = $currency->priceDisplay( $this->_cart->cartPrices['billTotal'] );
		$data->billTotal =  $currency->priceDisplay( $this->_cart->cartPrices['billTotal'] );

		//$data->billTotal = $currencyDisplay->priceDisplay( $this->cartPrices['billTotal'] );
		$data->taxTotal = $currency->priceDisplay( $this->_cart->cartPrices['billTaxAmount'] );
		$data->discTotal = $currency->priceDisplay( $this->_cart->cartPrices['billDiscountAmount'] );

		$data->cart_empty_text  = JText::_('ART_VIRTUEMART_CART_EMPTY');
		$data->cart_recent_text  = JText::_('ART_VIRTUEMART_CART_ADD_RECENTLY');
		$data->cart_remove  = JText::_('ART_VIRTUEMART_CART_REMOVE');
		$data->billTotals = '<div class="total2"><span>'.JText::_('COM_VIRTUEMART_CART_TOTAL').':</span>'.'<strong>' .$data->billTotal . '</strong></div>';
			
		$data->taxTotals = '<div class="total3"><span>'.JText::_('ART_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT').':</span>'.'<strong>' . $data->taxTotal . '</strong></div>';
		$data->discTotals = '<div class="total4"><span>'.JText::_('ART_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT').':</span>'.'<strong>' . $data->discTotal . '</strong></div>';
		$data->langCode = $langCode;

		$taskRoute = '&task=confirm';
		$linkName2 = JText::_('COM_VIRTUEMART_VIEW_CART');

		$data->cart_shows= '<a class="button reset" href="' . JRoute::_("index.php?option=com_virtuemart&view=cart" . $taskRoute, true, VmConfig::get('useSSL', 0)) . '">' . $linkName2 . '</a>';

		//$data->dataValidated = $this->_dataValidated ;
		$data->dataValidated=false;
		return $data;
	}

	// Render the code for Ajax Cart
	public function prepareAjaxData2(){
		defined('DS') or define('DS', DIRECTORY_SEPARATOR);
		if (!class_exists( 'VmConfig' )) require(JPATH_ROOT.'/administrator/components/com_virtuemart/helpers/config.php');
		if(!class_exists('VirtueMartCart')) require(JPATH_ROOT.'/components/com_virtuemart/helpers/cart.php');

		VmConfig::loadConfig();
		//error_reporting( E_ERROR );
		$this->_cart = VirtueMartCart::getCart(false);
		$this->_cart->prepareCartData(false);
		$weight_total = 0;
		$weight_subtotal = 0;

		//of course, some may argue that the $this->data->products should be generated in the view.html.php, but
		//]
		$data = new stdClass();
		$data->products = array();

		
		$data->totalProduct = 0;
		$i=0;
		
		if (!class_exists('CurrencyDisplay'))
		require(VMPATH_ADMIN . DS . 'helpers' . DS . 'currencydisplay.php');
		$currencyDisplay = CurrencyDisplay::getInstance();
		$popprodid = JRequest::get('POST');

		//print_r($popprodid['customProductData']."otstup");

		foreach ($this->_cart->products as $priceKey=>$product){
			//var_dump($product->customProductData);
			if (in_array($product->customProductData, $popprodid['customProductData'])) { 
				//echo "string";	
			

				if($popprodid['pid'] == $product->virtuemart_product_id ){
					//var_dump('test');
					$category_id = $this->_cart->getCardCategoryId($product->virtuemart_product_id);
					//Create product URL
					$url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$category_id);
					// @todo Add variants
					$data->products[$i]['virtuemart_product_id'] = $product->virtuemart_product_id;
					$data->products[$i]['product_cart_id'] = $priceKey;
					$data->products[$i]['product_name'] = JHTML::link($url, $product->product_name);

					// Add the variants
						if(!class_exists('VirtueMartModelCustomfields'))require(VMPATH_ADMIN.DS.'models'.DS.'customfields.php');
						
						//  custom product fields display for cart
						$data->products[$i]['product_attributes'] = VirtueMartModelCustomfields::CustomsFieldCartModDisplay($product);

					$data->products[$i]['product_sku'] = $product->product_sku;
					// product Price total for ajax cart
					//$data->products[$i]['prices'] = $currency->priceDisplay($this->_cart->pricesUnformatted[$priceKey]['salesPrice']);
					$data->products[$i]['prices'] = $currencyDisplay->priceDisplay( $product->allPrices[$product->selectedPrice]['salesPrice']);
					// other possible option to use for display
					$data->products[$i]['sales'] = $currencyDisplay->priceDisplay( $product->allPrices[$product->selectedPrice]['salesPriceTt']);

					$data->products[$i]['subtotal'] = $currencyDisplay->priceDisplay($product->allPrices[$product->selectedPrice]['subtotal']);
					$data->products[$i]['subtotal_tax_amount'] = $currencyDisplay->priceDisplay($product->allPrices[$product->selectedPrice]['subtotal_tax_amount']);
					$data->products[$i]['subtotal_discount'] = $currencyDisplay->priceDisplay( $product->allPrices[$product->selectedPrice]['subtotal_discount']);
					$data->products[$i]['subtotal_with_tax'] = $currencyDisplay->priceDisplay($product->allPrices[$product->selectedPrice]['subtotal_with_tax']);

					/**			
		            * Line for adding images to minicart
		            **/
		            //$data->products[$i]['image']='<img src="'.JFactory::getUri()->base().$product->image->file_url_thumb.'" />';
								$productModel = VmModel::getModel('Product');
					$product_images = $productModel->getProduct($product->virtuemart_product_id, true, false,true,$product->quantity);
					$productModel->addImages($product_images,1);

					$data->products[$i]['image']='<img src="'.$this->_baseurl.$product_images->images[0]->file_url.'" />';

					// UPDATE CART / DELETE FROM CART
					$data->products[$i]['quantity'] = $product->quantity."&nbsp;x&nbsp;";
					$data->totalProduct += $product->quantity ;
					//$i++;
				}
			}else {
				if($popprodid['pid'] == $product->virtuemart_product_id ){
					//var_dump('test');
					$category_id = $this->_cart->getCardCategoryId($product->virtuemart_product_id);
					//Create product URL
					$url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$category_id);
					// @todo Add variants
					$data->products[$i]['virtuemart_product_id'] = $product->virtuemart_product_id;
					$data->products[$i]['product_cart_id'] = $priceKey;
					$data->products[$i]['product_name'] = JHTML::link($url, $product->product_name);

					// Add the variants
						if(!class_exists('VirtueMartModelCustomfields'))require(VMPATH_ADMIN.DS.'models'.DS.'customfields.php');
						
						//  custom product fields display for cart
						$data->products[$i]['product_attributes'] = VirtueMartModelCustomfields::CustomsFieldCartModDisplay($product);

					$data->products[$i]['product_sku'] = $product->product_sku;
					// product Price total for ajax cart
					//$data->products[$i]['prices'] = $currency->priceDisplay($this->_cart->pricesUnformatted[$priceKey]['salesPrice']);
					$data->products[$i]['prices'] = $currencyDisplay->priceDisplay( $product->allPrices[$product->selectedPrice]['salesPrice']);
					// other possible option to use for display
					$data->products[$i]['sales'] = $currencyDisplay->priceDisplay( $product->allPrices[$product->selectedPrice]['salesPriceTt']);

					$data->products[$i]['subtotal'] = $currencyDisplay->priceDisplay($product->allPrices[$product->selectedPrice]['subtotal']);
					$data->products[$i]['subtotal_tax_amount'] = $currencyDisplay->priceDisplay($product->allPrices[$product->selectedPrice]['subtotal_tax_amount']);
					$data->products[$i]['subtotal_discount'] = $currencyDisplay->priceDisplay( $product->allPrices[$product->selectedPrice]['subtotal_discount']);
					$data->products[$i]['subtotal_with_tax'] = $currencyDisplay->priceDisplay($product->allPrices[$product->selectedPrice]['subtotal_with_tax']);

					/**			
		            * Line for adding images to minicart
		            **/
		            //$data->products[$i]['image']='<img src="'.JFactory::getUri()->base().$product->image->file_url_thumb.'" />';
								$productModel = VmModel::getModel('Product');
					$product_images = $productModel->getProduct($product->virtuemart_product_id, true, false,true,$product->quantity);
					$productModel->addImages($product_images,1);

					$data->products[$i]['image']='<img src="'.$this->_baseurl.$product_images->images[0]->file_url.'" />';

					// UPDATE CART / DELETE FROM CART
					$data->products[$i]['quantity'] = $product->quantity."&nbsp;x&nbsp;";
					$data->totalProduct += $product->quantity ;
					//$i++;
				}
			}

		}
		//JFactory::getLanguage()->load('mod_vm2cart');
		//$data->billTotal = count($data->products)?$this->_cart->prices['billTotal']:JText::_('MOD_VM2CART_CART_EMPTY');
		//$data->billTotal = $currencyDisplay->priceDisplay( $this->_cart->pricesUnformatted['billTotal'] );
		//print_r($this->_cart->pricesUnformatted);
		if(empty($this->_cart->pricesUnformatted['billTotal']) or $this->_cart->pricesUnformatted['billTotal'] < 0){
			$this->_cart->pricesUnformatted['billTotal'] = 0.0;
		}
		if($data->totalProduct){
			//echo '1';
			$data->billTotal = '<span class="totalText">'.JText::_('TPL_VIRTUEMART_CART_TOTAL').'</span><span class="totalprice">'.$currencyDisplay->priceDisplay( $this->_cart->pricesUnformatted['billTotal']).'</span>';
		} else {
			$this->_cart->pricesUnformatted['billTotal'] = 0.0;
			$data->billTotal = '<span class="totalText">'.JText::_('TPL_VIRTUEMART_CART_TOTAL').'</span><span class="totalprice">'.$currencyDisplay->priceDisplay( $this->cartPrices['billTotal'] ).'</span>';
		}
		
		//print_r($data->billTotal);
		//$data->billTotal = $currencyDisplay->priceDisplay($this->_cart->pricesUnformatted['billTotal']);

		$data->cart_empty_text  = JText::_('ART_VIRTUEMART_CART_EMPTY');
		$data->carttotaltext = '<span class="totalText">'.JText::_('TPL_VIRTUEMART_CART_TOTAL').'</span>';
		$data->cart_recent_text  = JText::_('ART_VIRTUEMART_CART_ADD_RECENTLY');
		//$data->dataValidated = $this->_dataValidated ;
		$data->dataValidated=false;
		//var_dump($data->products);
		
		return $data;
	}
}
?>