<html>
<head>
<title>Payment Page</title>
</head>
<body>

<style>

	.panel-group .panel {
		border-radius: 0;
		box-shadow: none;
		border-color: #EEEEEE;
	}

	.panel-default > .panel-heading {
		padding: 0;
		border-radius: 0;
		color: #212121;
		background-color: #FAFAFA;
		border-color: #EEEEEE;
	}

	.panel-title {
		font-size: 14px;
	}

	.panel-title > a {
		display: block;
		padding: 15px;
		text-decoration: none;
    background-color:#fff;
	}

	.more-less {
		float: right;
		color: #ffc704;
	}

	.panel-default > .panel-heading + .panel-collapse > .panel-body {
		border-top-color: #ededed;
	}

</style>

<script>

	function toggleIcon(e) {
        $(e.target)
            .prev('.panel-heading')
            .find(".more-less")
            .toggleClass('glyphicon-chevron-up glyphicon-chevron-down');
    }
    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);

</script>


<?php 

/*
$yandexCC = 1;
$usPPCC = 1;
$ameriaCC = 1;
$acbaCC = 1;
$euroPPCC = 1;
$usStripeCC =1;
$euroStripeCC =1;

$langCC = $GLOBALS['mosConfig_lang'];
$paymentTitleCC;
$paymentDescCC; 

$order_number		= $db->f("order_id");
$total_sum_to_pay 	= $db->f("order_total");
$shipping_rate          = (int)$_SESSION['my_shipping_rate'][3];
//$total_sum_to_pay       = $total_sum_to_pay + $shipping_rate;
$the_domain = preg_replace("/^(.*.)?([^.]*..*)$/", "$2", $_SERVER['HTTP_HOST']);

$total_sum_to_pay_rounded = round( $total_sum_to_pay, 0);
$total_sum_to_pay_rub = round($GLOBALS['CURRENCY']->convert($total_sum_to_pay, $GLOBALS['product_currency'], 'RUB'),0);
$total_sum_to_pay_usd = round($GLOBALS['CURRENCY']->convert($total_sum_to_pay, $GLOBALS['product_currency'], 'USD'),0);
$total_sum_to_pay_euro = round($GLOBALS['CURRENCY']->convert($total_sum_to_pay, $GLOBALS['product_currency'], 'EUR'),0);
$total_sum_to_pay_gbp = round($GLOBALS['CURRENCY']->convert($total_sum_to_pay, $GLOBALS['product_currency'], 'GBP'),0);

if ($langCC == "russian") {
	$paymentTitleCC = "Russian YooMoney(Yandex) Payment System";
	$paymentDescCC = "Here is the total amount of your order, please click on your preferred currency to pay."; 
} elseif ($langCC == "armenian") {
	$paymentTitleCC = "???????? YooMoney(Yandex) Վճարային համակարգ";
	$paymentDescCC = "Here is the total amount of your order, please click on your preferred currency to pay."; 
}elseif ($langCC == "spanish") {
	$paymentTitleCC = "Russian YooMoney(Yandex) Payment System";
	$paymentDescCC = "Here is the total amount of your order, please click on your preferred currency to pay."; 
}elseif ($langCC == "french") {
	$paymentTitleCC = "Russian YooMoney(Yandex) Payment System";
	$paymentDescCC = "Here is the total amount of your order, please click on your preferred currency to pay."; 
}elseif ($langCC == "german") {
	$paymentTitleCC = "Russian YooMoney(Yandex) Payment System";
	$paymentDescCC = "Here is the total amount of your order, please click on your preferred currency to pay."; 
}else {   // english
	
}

*/
?>




<div class="container demo">

	
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingOne">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						<i class="more-less glyphicon glyphicon-chevron-down"></i>
				
						
						Yandex Payment #1
					</a>
				</h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
				<div class="panel-body">
				
	
					 Describtion
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingTwo">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						<i class="more-less glyphicon glyphicon-chevron-down"></i>
						
						
						
						PayPal Payment #2
					</a>
				</h4>
			</div>
			<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				<div class="panel-body">
				
				  Describtion
				
				</div>
			</div>
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingTwo">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						<i class="more-less glyphicon glyphicon-chevron-down"></i>
						
						
						
						Ameria Payment #3
					</a>
				</h4>
			</div>
			<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				<div class="panel-body">
				
				  Describtion
				
				</div>
			</div>
		</div>
		
		
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingTwo">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						<i class="more-less glyphicon glyphicon-chevron-down"></i>
						
						
						
						Ameria Payment #4
					</a>
				</h4>
			</div>
			<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				<div class="panel-body">
				
				  Describtion
				
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingThree">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						<span class="more-less glyphicon glyphicon-chevron-down"></span>
						
						
						PayPal Payment #5
					</a>
				</h4>
			</div>
			<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
				<div class="panel-body">
				
				Describtion
				

				</div>
			</div>
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingThree">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						<span class="more-less glyphicon glyphicon-chevron-down"></span>
						
						Euro PayPal Payment #6
					</a>
				</h4>
			</div>
			<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
				<div class="panel-body">
				
				Describtion
				

				</div>
			</div>
		</div>
		
				<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingThree">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						<span class="more-less glyphicon glyphicon-chevron-down"></span>
						
						Euro Stripe Payment #7
					</a>
				</h4>
			</div>
			<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
				<div class="panel-body">
				
				Describtion
				

				</div>
			</div>
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingThree">
				<h4 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						<span class="more-less glyphicon glyphicon-chevron-down"></span>
						
						US Stripe Payment #8
					</a>
				</h4>
			</div>
			<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
				<div class="panel-body">
				
				Describtion
				

				</div>
			</div>
		</div>

	</div><!-- panel-group -->
	
	
</div><!-- container -->



</body>
</html>
