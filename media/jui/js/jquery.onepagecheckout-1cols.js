var geoip_country_name,geoip_city,requestUpdate = false;valid_form = true;
;(function(nx, $) {
	var $cache = {},
		isGuest,visiteds=false;
	
	var vmConfig,
		frmCheckOut,
		frmLogin,
		UI = {},
		flBillTo,flShipTo;
	
	function setup_Ajax() {
		
		$(document).ajaxSend(function(event, jqXHR, settings) {
		    $('#general-ajax-load').fadeIn();
		    valid_form = false;
		    requestUpdate = true;
		}).ajaxComplete(function(event, jqXHR, settings) {
		    $('#general-ajax-load').fadeOut();
		    valid_form = true;
		    requestUpdate = false;
		});
		$.ajaxSetup({ cache: false });
	}
	
	function update_DOM(condition,id,type,value) {
		if(condition == 1 || condition == true) {
			if(document.id(id) !== null) {
				document.id(id).set(type,value);
			}
		}
	}
	
	function load_GeoIp() {
		if(typeof geoip2 == "object"){
			var onSuccess = function(location){
				var city_fld = $('#city_field'),
					country_matched,
					country_fld = $('#virtuemart_country_id');
			
				country_matched = country_fld.find('[data-iso="'+location.country.iso_code+'"]:eq(0)').val();
				
				if( (country_fld.val()=='')){
					city_fld.val(location.city.names.en);
					country_fld.val(country_matched);
					jQuery('#virtuemart_country_id').find('option[value="'+country_matched+'"]').attr('selected','selected').change().trigger('liszt:updated');
					//jQuery('.billing-box select').styler().trigger('refresh');
				}
			};
	
			var onError = function(error){
				/*
			    alert(
			        "Error:\n\n"
			        + JSON.stringify(error, undefined, 4)
			    );
			    */
			};
	
			geoip2.city(onSuccess, onError);
		}
	}
	
	function copy_Fields () {
		flBillTo.filter(":not('#STsameAsBT')").each(function() {
			var f = $(this);
			var BT_fid = f.attr('id');
			var ST_fid = 'shipto_'+BT_fid;
			
			if(UI.cbSTsameAsBT.prop('checked')==true) {
				if(BT_fid == 'virtuemart_country_id') {
					var html = f.html(); 
					$('#'+ST_fid).html(html);
				}
				if(BT_fid == 'virtuemart_state_id') {
					var html = f.html(); 
					$('#'+ST_fid).html(html);
				}
				$('#'+ST_fid).val(f.val()).trigger('liszt:updated');
				$('.billing-box select').styler().trigger('refresh');
			}
		})
	}//copy_Fields
	
		function toggle_pnlRegister () {
		(UI.cbRegister.prop("checked")==true) ? frmCheckOut.find('#user-register-fields').fadeIn() : frmCheckOut.find('#user-register-fields').fadeOut();
		$('#registerLeb').click(function() {
			$('#user-actions-trigger').find('#user-register-fields').toggle();
		})
		return UI.cbRegister;
	}//func - toggle_pnlRegister

	
	function toggle_pnlShipTo () {
		if(UI.cbSTsameAsBT.prop("checked")==true) {
			frmCheckOut.find('#table_shipto').fadeOut();
			copy_Fields();
		} else {
			frmCheckOut.find('#table_shipto').fadeIn();
		}
		$('#STsameAsBTLeb').click(function() {
			$('#div_shipto').find('#table_shipto').toggle();
		})
		return UI.cbSTsameAsBT;
	}//func - toggle_pnlShipTo

	function process_Coupon() {
		var url = 'index.php?api_controller=checkout&api_ajax=set_coupon&coupon=' + UI.tbCoupon.val()
			$.getJSON(url,function(rs){
				if(rs.salesPriceCoupon !== null && rs.salesPriceCoupon !=='') {
					frmCheckOut.find('#coupon_price').html(rs.salesPriceCoupon);
					UI.lblCoupon.fadeIn();
					if(rs.billTotal !== null && rs.billTotal !=='') {frmCheckOut.find('#bill_total').html(rs.billTotal);}
				} else {
					alert(Joomla.JText._('SYSTEM_ONESTEPCHECKOUT_COUPON_INVALID'));
					UI.lblCoupon.fadeOut();
					frmCheckOut.find('#coupon_price').empty();
					if(rs.billTotal !== null && rs.billTotal !=='') {frmCheckOut.find('#bill_total').html(rs.billTotal);}
				}
			});
	}//func - process_coupon
	
	
	function change_Fields () {
		var f = $(this);
		var BT_fid = f.attr('id');
		var ST_fid = 'shipto_'+BT_fid;
		
		if(UI.cbSTsameAsBT.prop('checked')==true) {
			if(BT_fid == 'virtuemart_country_id') {
				var dbBTStates = frmCheckOut.find('#virtuemart_state_id').empty();
				UI.default_opt.appendTo(dbBTStates);
				//dbBTStates.trigger('change');
			}
			if(BT_fid == 'virtuemart_state_id') {
				var html = f.html(); 
				$('#'+ST_fid).html(html);
			}
			$('#'+ST_fid).val(f.val()).trigger('change').trigger('liszt:updated');
			$('.billing-box select').styler().trigger('refresh');
		}
	}
	
	function update_form(task,id) {
		var did=id;
		if(task=='update_product') {
			if(document.id('quantity_'+id).value<=0) {
				return alert(Joomla.JText._('SYSTEM_ONESTEPCHECKOUT_DATA_INVALID'));
			}
		}
		var update_address=true;
		if(task==false) {
			update_address=false;
		}
		var url="index.php?api_controller=checkout";
		if(!task) {
			var task='update_form';
		}
		url+='&api_ajax='+task;
		if(id) {
			url+='&id='+id;
		}
		if(task=='update_product') {
			url+='&quantity='+document.id('quantity_'+id).value;
		}
		/*
		if(update_address==false) {
			url+='&update_address=false';
		}
		*/
		url+='&update_address=1';
		// get ajax data
		if(!requestUpdate) {
			requestUpdate = true;
			$('#shipping_method .pane-inner').css('visibility','hidden');
			$.ajax({
				url:url,
				type:'POST',
				cache:false,
				data:$('#checkoutForm').serialize(),
				dataType:'json',
				success : function (rs){
						requestUpdate = false;
						if(rs.error) {
							//raise error msg
						} else {
							//process remove product task
							if(task=='remove_product') {
								document.id('product_row_'+id).destroy();
							}
							//end - process remove product task
							
							//update cart module
							if(Virtuemart) Virtuemart.productUpdate($('.vmCartModule'));
							
							
							//update product list
							if(rs.price.products) {
								for(var _id in rs.price.products) {
									update_DOM(vmconfig.show_tax, 'subtotal_tax_amount_'+_id, 'text', rs.price.products[_id].subtotal_tax_amount);
									update_DOM(true, 'subtotal_discount_'+_id, 'text', rs.price.products[_id].subtotal_discount);
									update_DOM(true, 'subtotal_with_tax_'+_id, 'html', rs.price.products[_id].subtotal_with_tax);
									
								}
							}//end - update product list
							
							update_DOM(vmconfig.show_tax, 'tax_amount', 'text', rs.price.taxAmount);
							update_DOM(vmconfig.show_tax, 'discount_amount', 'text', rs.price.discountAmount);
							update_DOM(true, 'sales_price', 'text', rs.price.salesPrice);
							update_DOM(vmconfig.show_tax, 'shipment_tax', 'text', rs.price.shipmentTax);
							update_DOM(true, 'shipment', 'text', rs.price.salesPriceShipment);
							update_DOM(vmconfig.show_tax, 'payment_tax', 'text', rs.price.paymentTax);
							update_DOM(true, 'payment', 'text', rs.price.salesPricePayment);
							update_DOM(vmconfig.show_tax, 'total_tax', 'text', rs.price.billTaxAmount);
							update_DOM(true, 'total_amount', 'text', rs.price.billDiscountAmount);
							update_DOM(true, 'bill_total', 'text', rs.price.billTotal);
							
							//update shipments list
							document.id('shipments').empty();
							var shipments="";
							if(rs.shipments) {
								for(var i=0;i<rs.shipments.length;i++) {
									shipments+=rs.shipments[i].toString()+'<br />';
								}
								document.id('shipments').set('html',shipments);
								$('#shipments input').styler().trigger('refresh');	
								
							}// end - update shipments list
							
							// update payments list
							document.id('payments').empty();
							var payments="";
							if(rs.payments) {
								for(var i=0;i<rs.payments.length;i++) {
									payments+=rs.payments[i].toString()+'<br />';
								}
								document.id('payments').set('html',payments);
								$('#payments input').styler().trigger('refresh');	
							}//end - update payments list
							
							//callback functions
							/*
							 * shipments
							 */
							
							$('#shipments .jq-radio').click(function() {
								update_form();
							})

							/*
							 * payments
							 */
							$('#payments .jq-radio').click(function() {
								update_form();
							})
							$('#shipping_method .pane-inner').css('visibility','visible').fadeIn();
							
						}//data
					}
			})//ajax
		}
	}

	function submit_order() {
		var cbTOS = frmCheckOut.find('#tosAccepted');
		
		if(vmConfig.oncheckout_show_legal_info == 1) {
			if(vmConfig.agree_to_tos_onorder) {
				if(cbTOS.prop('checked') == false) {
					return alert(Joomla.JText._('SYSTEM_ONESTEPCHECKOUT_TOS_CONFIRM'));
				}
			}
		} else {
			cbTOS.prop('checked',true);
		}
		
		var shipments_checked = $(':input:checked','#shipments').length;
		var payments_checked = $(':input:checked','#payments').length;
		if(shipments_checked <= 0) {
			return alert(Joomla.JText._('SYSTEM_ONESTEPCHECKOUT_SHIPMENT_INVALID'));
		}
		
		if(payments_checked <=0 ) {
			return alert(Joomla.JText._('SYSTEM_ONESTEPCHECKOUT_PAYMENT_INVALID'));
		}

		var register_state=true;
		if(document.id('register') && document.id('register').checked==true) {
			register_state=false;
			new Request.JSON({
				'url':'index.php?api_controller=checkout&api_ajax=register',
				'method':'post',
				'async':false,
				'noCache':true,
				'data':document.id('div_billto').toQueryString()+'&address_type=BT&'+vmconfig.token+'=1',
				'onSuccess':function(json,text) {
					if(json.error && json.error==1) {
						alert(json.message);
					} else {
						register_state=true;
					}
				},
				'onFailure':function(xhr) {
					if(xhr.status==500) {
						register_state=true;
					}
				}
			}).send();
		}
		if(!register_state) {
			return;
		}
		
		if(UI.cbSTsameAsBT.prop('checked') == true) {
			copy_Fields();
		} 
		
		var validator=new JFormValidator();
		//check bill to info
		validator.attachToForm(document.id('table_billto'));
		var valid_billto=true;
		document.id('table_billto').getElements('input').each(function(el) {
			var cval = validator.validate(el);
			valid_billto = valid_billto && cval;
		});
		if(valid_billto && document.id('virtuemart_country_id').value<=0) {
			valid_billto = false;
			return alert(Joomla.JText._('SYSTEM_ONESTEPCHECKOUT_COUNTRY_INVALID'));
		}
		if(!valid_billto) {
			$('html,body').animate({scrollTop: $('#table_billto').offset().top},'slow');
			valid_billto = false;
			return alert(Joomla.JText._('SYSTEM_ONESTEPCHECKOUT_FORM_INVALID'));
		}
		
		// validate ship to info
		validator.attachToForm(document.id('table_shipto'));
		var valid_shipto=true;
		document.id('table_shipto').getElements('input').each(function(el) {
			var cval = validator.validate(el);;
			valid_shipto = valid_shipto && cval;
		});
		
		if(valid_shipto && document.id('shipto_virtuemart_country_id').value<=0) {
			$('html,body').animate({scrollTop: $('#shipto_virtuemart_country_id').offset().top},'slow');
			valid_shipto = false;
			alert(Joomla.JText._('SYSTEM_ONESTEPCHECKOUT_SHIPTO_COUNTRY_INVALID'));
			return false;
		}
		
		var shipto_state = $('#shipto_virtuemart_state_id');
		if(valid_shipto && (shipto_state.val()<=0 || shipto_state.val()=='') && 
				(document.getElementById('shipto_virtuemart_state_id').getAttribute("required") == "required")) {
			$('html,body').animate({scrollTop: $('#shipto_virtuemart_country_id').offset().top},'slow');
			valid_shipto = false;
			alert(Joomla.JText._('SYSTEM_ONESTEPCHECKOUT_SHIPTO_STATE_INVALID'));
			return false;
		}
		
		if(!valid_shipto) {
			$('html,body').animate({scrollTop: $('#table_shipto').offset().top},'slow');
			alert(Joomla.JText._('SYSTEM_ONESTEPCHECKOUT_INFO_INVALID'));
			return false;
		}
		if((valid_billto && valid_shipto) == false) { return false; }
		
		var STsameAsBT = UI.cbSTsameAsBT.prop('checked')==true ? 1:0;
		
		$.getJSON('index.php?api_controller=checkout&api_ajax=set_checkout&tosAccepted=1&STsameAsBT=' + STsameAsBT,
				{
					//WTF -IEs does not works
					data:$('#checkoutForm').serialize(),
					method:"GET"
				},
				function(res){
					if(res.status == 'success') {
						frmCheckOut.submit();
					}
				}
		);
	}
	
	/*
	 * initialize Config
	 */	
	function init_Config(){ 
		vmConfig = window.vmconfig || {};
		setup_Ajax();
		
		isGuest = $('#cart-view-3cols').data('user-guest');
	}
	/*
	 * initialize Cache
	 */
	function init_Cache() {
		$cache = {
				login: $('#com-form-login'),
				login_pane: $('#login-pane'),
				alert_message: $('#alert-message'),
				checkoutForm: $('#checkoutForm'),
				billto: $('#div_billto'),
				shipto: $('#div_shipto'),
				billing_info: $('#billing_info'),
				shipping_info: $('#shipping_info'),
				coupon: $('.coupon-pane').first()
		}
		// main forms
		frmCheckOut = $('#checkoutForm');
		frmLogin 	= $('#com-form-login');
		
		// UI
		UI.cbRegister 	= frmCheckOut.find('#register');
		UI.cbSTsameAsBT = frmCheckOut.find('#STsameAsBT');
		UI.tbCoupon 	= frmCheckOut.find('#coupon_code');
		UI.lblCoupon 	= frmCheckOut.find('#coupon_code_txt');
		UI.btnCoupon 	= frmCheckOut.find('#coupon_code_button');
		UI.btnCheckOut 	= frmCheckOut.find('a.vm-button-correct:eq(0)');
		UI.hlTOS		= frmCheckOut.find('span.terms-of-service:eq(0)');
		UI.btnEmptyCart = frmCheckOut.find('#empty_cart');
		
		UI.dbBTCountry	= frmCheckOut.find('#virtuemart_country_id'); // BT = BillTo
		UI.dbSTCountry	= frmCheckOut.find('#shipto_virtuemart_country_id'); // ST = ShipTo
		
		// fields
		flBillTo = frmCheckOut.find('#table_billto input,#table_billto select');
		flShipTo = frmCheckOut.find('#table_shipto input,#table_shipto select');
		
		fBillToZip = flBillTo.filter('#zip_field')
		fShipToZip = flShipTo.filter('#shipto_zip_field')
		fShipToNickName = flShipTo.filter('#shipto_address_type_name_field')
		
		//UI.default_opt = frmCheckOut.find('#virtuemart_state_id option:eq(0)');
		UI.default_opt = $('<option value="" checked="checked">'+Joomla.JText._('COM_VIRTUEMART_LIST_EMPTY_OPTION')+'</option>');
		//console.log(UI.default_opt);
	}	
	

	function init_Dom() {
		$('#system-message-container').hide();
		$('#full-tos').hide();
		//$('#email_field').addClass('validate-email');
	}	
	
	function init_Events() {
		if(vmConfig.geoip == 1) {load_GeoIp();}
		visiteds = $.cookies.get('visiteds');
		if(visiteds == null && UI.cbSTsameAsBT.prop("checked")== false) {UI.cbSTsameAsBT.prop("checked",true)}
		visiteds = 1;
		 $.cookies.get('visiteds',visiteds);
		/*
		 * login pane
		 */
		$('#login-modal-trigger').click(function() {
			$cache.login_modal = $('#login-modal').dialog({
				title: 'Login',
				dialogClass: 'ui-login-dialog',
				position: ['center', 'center'],
				modal: true,
				resizable: false,
				width: '370',
				create: function( event, ui ) {
				}
			}).find('input[type="submit"]').click(function(event) {
				event.preventDefault();
				var _form = $('.ui-login-dialog #com-form-login'),
					f_username = _form.find('input[name="username"]'),
					f_password = _form.find('input[name="password"]');
				if(f_username.val() === '') {
					_form.find('#advice-required-entry-login-username').fadeIn();
				}
				if(f_password.val() === '') {
					_form.find('#advice-required-entry-login-password').fadeIn();
				}
				if(f_username.val()!=='' && f_password.val() !== '') {
					_form.find('#advice-required-entry-login-username').fadeOut().end()
						.find('#advice-required-entry-login-password').fadeOut();
					_form.submit();
					return true;
				} else {
					return false;
				}
			}).end()
			.find('#remind-password-trigger').click(function(event) {
				event.preventDefault();
				$('#login-modal').dialog("close");
				$cache.remind_modal = $('#login-remind-modal').dialog({
					title: 'Remind Password',
					dialogClass: 'ui-remind-dialog',
					position: ['center', 'center'],
					modal: true,
					width: '400',
					resizable: false
				});
				$cache.remind_modal.find('.btn-back').click(function(event) {
					event.preventDefault();
					$cache.remind_modal.dialog("close");
					$('#login-modal').dialog("open");
				});
			}).end()
			.find('#reset-password-trigger').click(function(event) {
				event.preventDefault();
				$('#login-modal').dialog("close");
				$cache.reset_modal = $('#login-reset-modal').dialog({
					title: 'Reset Password',
					dialogClass: 'ui-reset-dialog',
					position: ['center', 'center'],
					modal: true,
					width: '400',
					resizable: false
				});
				$cache.reset_modal.find('.btn-back').click(function(event) {
					event.preventDefault();
					$cache.reset_modal.dialog("close");
					$('#login-modal').dialog("open");
				});
			});
		});
		
		
		/*
		 * product list
		 */
		/* update product */
		$('.product-quanlity input[name="update"]').click(function() {
			var that = $(this),pid = that.data('pid');
			update_form('update_product', pid);
		});
		/* remove product */
		$('.product-quanlity a[name="remove"]').click(function() {
			var that = $(this),pid = that.data('pid');
			update_form('remove_product', pid);
		});

		/*
		 * shipments
		 */
		var virtuemart_shipmentmethod_id = $.cookies.get('virtuemart_shipmentmethod_id');
		if($('#shipment_id_'+ virtuemart_shipmentmethod_id).length > 0) {
			$('#shipment_id_'+ virtuemart_shipmentmethod_id).prop("checked",true);
		}
		
		$('#shipments .jq-radio').click(function() {
			$.cookies.set('virtuemart_shipmentmethod_id',$(this).val());
			update_form();
		})

		/*
		 * payments
		 */
		var vmpayment_cardinfo = $('#payments').find('.vmpayment_cardinfo'),
			payment_gate = vmpayment_cardinfo.prev().prev().prev();
			
		
		$('#payments .jq-radio').click(function() {
			update_form();
		})
		
		if(payment_gate.length > 0) {
			if(payment_gate.prop("checked") == true) {
				vmpayment_cardinfo.show();
			} else {
				vmpayment_cardinfo.hide();
			}
		}
		/*
		 * TOS
		 */
		UI.hlTOS.click( function(){
			if(typeOf($.facebox) == "function") {
				$.facebox( { div: '#full-tos' }, 'my-groovy-style');
			} else {
				if(typeOf($.fancybox) == "function") {
					var con = $('div#full-tos').html();
					$.fancybox ({ div: '#full-tos', content: con });
				}
			}
			
		});
		
		/*
		 * Coupon
		 */
		UI.btnCoupon.click(function(e) {
			e.preventDefault();
			process_Coupon();
		});
		
		toggle_pnlRegister().click(toggle_pnlRegister);
		toggle_pnlShipTo().click(toggle_pnlShipTo);
		//callback_Events ();

		/*
		 * ShipTo Country dropbox events
		 */
		UI.dbSTCountry.change(function() {
		//$('.billing-box select').styler().trigger('refresh');

			update_form();
		})
		
		/*
		 * Resgister password fields
		 */
		var password = frmCheckOut.find('#password_field'),
			password2 = frmCheckOut.find('#password2_field');
		
		password2.val(password.val());
		
		password.change(function() {
			password2.val($(this).val());
		});
		
		/*  
		 * BillTo Zip code
		 */ 
		if(fBillToZip.length > 0) {fBillToZip.val(' ')}
		fBillToZip.bind('focus change blur',function(){
			if($(this).val() === '') $(this).val(' ');
		});
		
		/* ShipTo Zip code - wtf!!! 
		 * It must have a value (not empty)
		 */ 
		if(fShipToZip.length > 0) {fShipToZip.val(' ')}
		fShipToZip.bind('focus change blur',function(){
			if($(this).val() === '') $(this).val(' ');
		});
		
		if(fShipToNickName.length > 0) {fShipToNickName.val('ST')}
		fShipToNickName.bind('focus change blur',function(){
			if($(this).val() === '') $(this).val('ST');
		});

		/*
		 * Submit order
		 */
		UI.btnCheckOut.click(function(e){
			e.preventDefault();
			submit_order();
		});

		/*
		 * flBillTo
		 */
		flBillTo.bind('change',change_Fields);
		$('#virtuemart_country_id').change(function(){
			update_form();
			//$('.billing-box select').styler().trigger('refresh');

			});
		
		
		UI.btnEmptyCart.bind('click', function() {
			$.ajax({url:'index.php?api_controller=checkout&api_ajax=empty_cart'}).done(function() {
				window.location.reload();
			});
		})
		/*
		 * Update Checkout form
		 */		
		update_form();
	}	
	/******* nx.checkout public object ********/
	nx.checkout = {
			vmConfig: {},
			init : function () {
				init_Config();
				init_Dom();
				init_Cache();
				init_Events();
			},
			update_form: function(task,id) {
				update_form();
				//$('.billing-box select').styler().trigger('refresh');
			}
	};
	$().ready(function() {
		nx.checkout.vmConfig = window.vmconfig || {};
		nx.checkout.init();
	});
}(window.nx = window.nx || {}, jQuery))