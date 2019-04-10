
<?php
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;

$delivery_method = '';
$delivery_charges = 0.00;

$ship_pref = '';
if((session()->get('ship_pref') != null)){
	$ship_pref = trim(stripslashes(session()->get('ship_pref')));
}

$ship_to_this = trim(session()->get('ship_to_this'));

//$payment_method=trim(stripslashes($_SESSION['payment_method']));

$medical = Helper::instance();

$cart_total = Helper::instance()->getCartTotal();

$total_item = 0;

# Get Total Quantity/Item + Cart Total

foreach(session()->get('cart') as $post){
	$total_item += $post[ 'product_quantity' ];
}

session()->put('msg_cop', '');

if(request()->input('coupon_code')){
	
	$cc = trim((request()->input('coupon_code')));
	
	$sql = "select c.*, ct.* from coupon c inner join coupon_type ct on c.ct_id=ct.ct_id where c.cop_code='".$cc."' and c.cop_status=1";
	
	$query = DB::select($sql);
	
	$rows = count($query);
	
	if($rows > 0){
		
		$mfaC = @reset(json_decode(json_encode($query), true));
		session()->put('coupon_type', trim($mfaC[ 'ct_id' ]));
		session()->put('coupon_code', trim($mfaC[ 'cop_code' ]));
		session()->put('coupon_count', (int) ($mfaC[ 'cop_count' ]));
		
		if($mfaC[ 'ct_id' ] == 1){
			
			session()->put('coupon_symbol', '=');
			session()->put('coupon_value', 0);
		}
		
		if($mfaC[ 'ct_id' ] == 2){
			
			session()->put('coupon_symbol', '%');
			session()->put('coupon_value', trim($mfaC[ 'cop_off' ]));
		}
		
		if($mfaC[ 'ct_id' ] == 3){
			
			session()->put('coupon_symbol', '$');
			session()->put('coupon_value', trim($mfaC[ 'cop_amount' ]));
		}
		session()->put('msg_cop', '<span class="yes_cop">Coupon code accepted.</span>');
	}else{
		
		session()->put('msg_cop', '<span class="no_cop">This coupon code is incorrect!</span>');
		
		session()->pull('coupon_type');
		session()->pull('coupon_code');
		session()->pull('coupon_count');
		session()->pull('coupon_symbol');
		session()->pull('coupon_value');
		session()->pull('discount_amount');
		session()->pull('ctype');
	}
	# echo '<pre>'.print_r($mfaC,true).'</pre>';exit;
	
}



$discount_amount = 0;

$cop_type = '';

if(session()->get('coupon_type') != false && session()->get('coupon_type') == 1){
	
	$cop_type = 'Free Shipping';
	
	$discount_amount = $delivery_charges;
}

if(session()->get('coupon_type') != null && session()->get('coupon_type') == 2){
	
	$cop_type = '% Off';
	
	$amount = trim(session()->get('coupon_value'))/100*$cart_total;
	
	$discount_amount = $amount;
}

if(session()->get('coupon_type') != null && session()->get('coupon_type') == 3){
	
	$cop_type = '$ Amount';
	
	$amount = trim(session()->get('coupon_value'));
	
	$discount_amount = $amount;
}

session()->put('discount_amount', $discount_amount);
session()->put('ctype', $cop_type);

$tax = 0;

$total_before_tax = $cart_total+$delivery_charges;

$total_after_tax = $cart_total+$delivery_charges+$tax-$discount_amount;

?>

<script src="{{ url('/') }}/frontend/js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="{{ url('/') }}/frontend/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ url('/') }}/frontend/js/jquery.validate.creditcardtypes.js"></script>
<script type="text/javascript">
		$(document).ready(function () {

//	$("#checkout_form").validate();
				$("#po_radio").click(function () {
						$('.check_tab').hide();
						$('.po_tab').show();
				})
				
				$("#moneyorder_radio").click(function () {
						
						$('.check_tab').show();
						$('.po_tab').hide();
				})
				
				$("#check_radio").click(function () {
						
						$('.check_tab').show();
						$('.po_tab').hide();
				})
				
				
		});
		
		$('#checkoutContinue').click(function () {
				 
				 pageurl = '{{ url("/") }}/cart/review';
				 
				 var paymentMethod = $('input:radio[name=payment_method]:checked').val();
				 
				 
				 if (paymentMethod == undefined) {
						 alert('Select payment method Plz');
						 return false;
				 }
				 
				 if (document.getElementById('p_method_checkmo').checked) {
						 
						 if (document.getElementById('check_radio').checked || document.getElementById('moneyorder_radio').checked || document.getElementById('po_radio').checked) {
						 } else {
								 alert('Select Check, Money Order or Purchase Order.');
								 return false;
						 }
				 }
				 
				 if (document.getElementById('po_radio').checked) {
						 if ($('#po_file').val() == '' || $('#po_no').val() == '') {
								 alert('Enter PO number and attach file.');
								 return false;
						 }
				 }
				 
				 $("#loading_payment").show();
				 $("#selectpayment").slideUp();
				 if (paymentMethod == 'ccpayment' || paymentMethod == 'echeckpayment') {
						 
						 var ccId = $('input:radio[name=cc_id]:checked').val();
						 
						 $.ajax({
								 method : "POST" ,
								 url : pageurl ,
								 data : {
										 payment_method : paymentMethod ,
										 cc_id : ccId,
										 _token : "{{ csrf_token() }}"
								 } ,
								 async : true ,
								 success : function (data) {
										 
										 //$('body').html(data);
										 $('#htmldiv').html(data);
								 }
						 });
						 
				 }
				 if (paymentMethod == 'checkmo') {
						 
						 var checkmo = $('input:radio[name=check]:checked').val();
						 var poNo = $('#po_no').val();
						 //var poFile = new FormData(this);
						 
						 $.ajax({
								 method : "POST" ,
								 url : pageurl ,
								 data : {
										 payment_method : paymentMethod ,
										 checkmo : checkmo ,
										 poNo : poNo,
										 _token : "{{ csrf_token() }}"
								 } ,
								 async : true ,
								 success : function (response) {
										 //$('body').html(response);
										 $('#htmldiv').html(response);
								 }
						 });
						 
				 }
				 
				 //to change the browser URL to 'pageurl'
				 if (pageurl != window.location) {
						 window.history.pushState({path : pageurl} , '' , pageurl);
				 }
				 return false;
				 
		 });

</script>
<style type="text/css">
	.content {
		width: 80%;
		height: 800px;
		margin: 0 auto;
	}
	
	.continput {
		float: none;
		margin: 0;
		padding: 0;
		padding-left: 3px;
		font-size: 18px;
	}
	
	.context {
		float: none;
		margin: 0;
		padding: 0
	}
	
	#tbl_address {
		margin-top: 0px;
		width: 100%;
	}
	
	strong span {
		text-decoration: underline;
		color: #009900;
	}
	
	input[type=radio] {
		width: auto;
	}
	
	#cc_opt, #mo_opt, #ec_opt {
		display: none;
	}
	
	#cc_opt {
		height: 350px;
	}
	
	.steps {
		float: right;
		margin-top: 10px;
		margin-bottom: 10px;
	}
	
	#tbl_address tr, #tbl_address td {
		border: none;
	}
	
	.account-number-on-image {
		padding-left: 96px;
	}
	
	.a-spacing-base {
		padding-bottom: 10px;
	}
	
	.continput, .input-text {
		width: 390px;
		height: 36px;
		background: url("{{ url('/')}}/uploads/input_bgs.png") no-repeat;
		border: none;
	}
	
	select.continput, select.input-text {
		background: url("{{ url('/')}}/uploads/selexcr_imh.jpg") !important;
		width: 230px !important;
		line-height: 1;
		border: 0;
		border-radius: 0;
		height: 36px;
		-webkit-appearance: none;
		padding: 6px 10px 6px 10px;
		/* color: #a1a2a5;*/
		font-size: 18px;
		outline: none;
	}
	
	.text_areaabg {
		background: url("{{ url('/')}}/uploads/text_areabg.png") !important;
		width: 491px;
		height: 96px;
		border: none;
		color: #a1a2a5;
		font-size: 18px;
		font-family: Arial, Helvetica, sans-serif;
		padding: 6px 0 0 9px;
		margin-top: 20px;
	}
	
	input:focus {
		border: 1px solid #007dc6 !important;
	}
	
	.continput:focus, .input-text:focus {
		background-color: #fff !important;
		background-image: none !important;
		border: 2px solid rgb(48, 129, 190) !important;
		box-shadow: 0 0 10px #1e7ec8 !important;
		height: 36px !important;
	}
	
	.existing-payment-methods-wrapper {
		border: 1px solid #DDD;
		padding: 10px;
		float: left;
		width: 100%;
	}
	
	.cc_style {
		border-bottom: 1px solid #DDD;
		margin-bottom: 10px;
		padding-bottom: 10px;
	}
	
	h3 {
		font-size: 18px;
		font-weight: bold;
	}
	
	#tbl_address td {
		padding: 10px 10px 10px 0px;
	}
	
	.right_bigportion {
		width: 30%;
	}
	
	/* All Mobile Sizes (devices and browser) */
	@media only screen and (min-width: 320px) and (max-width: 480px) {
		#checkout_popup .signin_btn {
			background-position: 0px 0px !important;
			width: 47%;
			background-size: 100% 100% !important;
		}
		
		.checkout_btn {
			width: 47%;
		}
		
		.content {
			width: 95%;
		}
		
		.continput, .input-text, .continput:hover, .input-text:hover {
			background-size: 100% 100% !important;
			width: 100% !important;
		}
		
		#tour_div_9 {
			width: 100%;
		}
		
		h3 {
			font-size: 14px;
		}
		
		.credit_card_logos {
			height: 50%;
			width: 50%;
			float: right;
		}
		
		.stanrd_shipingsmall {
			width: 100% !important;
		}
		
		.a-spacing-base {
			font-size: 12px;
		}
		
		#send_check, #add_a_card, #checking_account {
			font-size: 12px;
		}
		
		.text_areaabg {
			background-size: 100% 100% !important;
			font-size: 12px;
			height: 150px;
			width: 100%;
		}
		
		li {
			font-size: 12px;
		}
		
		.cc_style {
			border-bottom: none;
		}
		
		#tour_div_7 .col-lg-3 {
			width: 85% !important;
		}
		
		#slide_address .col-lg-6 {
			float: left;
		}
	}
</style>

<div class="container" id="checkout_body">
	<div class="row main-contant">
		<div class="container contant-con">
			<div class="content">
				<div class="bodyinner">
					
					<div class="steps"><img src="cart_imags3.jpg"/></div>
					<h3><strong>Add a Payment Method</strong></h3>
					<div class="clear:both"></div>
					
					<hr class="a-spacing-base" style="width: 100%;">
					
					<br/>
					<div class="col-lg-12">
						<div class="col-lg-8 left_allportion">
							<div class="left_bigportion">
								<div style="float:left;border-bottom: 1px solid #CCC;padding-bottom: 10px;margin-bottom: 10px;" class="col-lg-12">
									<div id="tour_div_7" class="introjs-showElement introjs-relativePosition">
										<span class="step-header amz-stepped">1</span>
										<strong style="font-size:13px;" class="col-lg-3">Shipping Address</strong>
										<p id="loading_address"><img src="<?php echo url('/'); ?>/uploads/images/loader.gif"/> Loading address information</p>
					 <?php
					 //$medical = new medicalModel();
					 
					 
					 
					 if(isset($arrValue['bsa']) && !empty($arrValue['bsa'])){
					 	foreach ($arrValue['bsa'] as $bsa){
							 
							 foreach($medical->states as $key => $value){
								 if($key == $bsa[ 'bsa_state' ]){
									 $state = $value;
								 }
							 }					 
					 ?>
                      <div id="slide_address">              
                      <span class="col-lg-6"><?php echo $bsa[ 'bsa_fname' ].' '.$bsa[ 'bsa_lname' ] ?><br>
                      <?php echo $bsa[ 'bsa_address' ]; ?><br>
                      <?php echo $bsa[ 'bsa_city' ].', '.@$state.' '.$bsa[ 'bsa_zip' ]; ?><br>
                      <?php if($bsa[ 'bsa_country' ] != 'US'){
                              echo $bsa[ 'bsa_country' ].'<br>';
                          } ?>
                      </span>
                        <p class="col-lg-3">
                            <button class="amz_change" id="amzChangeAddress">Change</button>
                        </p>
                      </div>
					 <?php						 
					 	}
					 }
					 
					 ?>
									</div>
								</div>
								<div class="col-lg-12" id="tour_div_9"><strong style="width: 27%;" class="col-lg-3 active_step">
										<span class="step-header amz-stepped active_step">2</span>Payment Method</strong>
									<p id="loading_payment"><img src="<?php echo url('/'); ?>/uploads/images/loader.gif"/> Saving your payment method</p>
									<div class="col-lg-12" id="selectpayment">
										<p id="CardSuccess" style="color: green; font-size:14px;"></p>
				 <?php
				 
				 
				 $arrArgument[ 'table' ] = 'user_creditcards';
				 $where = array('user_id' => (int) (session()->get('user_id')), 'cc_exp_date >' => date('Y-m-d'));
				 $arrArgument[ 'where' ] = $where;
				 $arrArgument[ 'operator' ] = 'AND';
				 $arrArgument[ 'order' ] = 'id ASC';
				 $arrValue[ 'cc' ] = Helper::instance()->getRecord($arrArgument);
				 
				 $arrArgument[ 'table' ] = 'user_account_bank';
				 $where = array('user_id' => (int) (session()->get('user_id')));
				 $arrArgument[ 'where' ] = $where;
				 
				 $arrValue[ 'bank' ] = Helper::instance()->getRecord($arrArgument);
				 
				 ?>
									<!--<form action="<?php echo url('/').'/uploads/index.php?controller=cart&function=checkout'?>" method="post" id="checkout_form">-->
										
										<div class="existing-payment-methods-wrapper" id="existing-payment-methods">
											<div id="credit_cards" width="70%">
												<div class="col-lg-12 cc_style">
													<div class="col-lg-5"><h3>Your credit and debit cards</h3></div>
													<div class="col-lg-3">Name on card</div>
													<div class="col-lg-2">Expires on</div>
													<div class="col-lg-1" style="float:right;">Edit</div>
												</div>
						 
						 <?php
						 if(sizeof($arrValue[ 'cc' ]) > 0){
						 foreach ($arrValue[ 'cc' ] as $cc)
						 {
						 ?>
												<div class="col-lg-12 cc_style">
													
													<div class="col-lg-5"><input type="radio" name="cc_id" class="cc_radio" onclick="paymentmethodcc('p_method_ccpayment');" value="cc_<?php echo $cc[ 'id' ]; ?>" required="required"/>
							 <?php echo $cc[ 'cc_name' ].' ending with '.substr(preg_replace('/\s+/', '', $cc[ 'cc_number' ]), -4); ?></div>
													<div class="col-lg-3"><?php echo $cc[ 'cc_holder_name' ]; ?></div>
													<div class="col-lg-2"><?php echo date('m/Y', strtotime($cc[ 'cc_exp_date' ])); ?></div>
													<div class="col-lg-1" style="float:right;cursor: pointer;"><a onclick="showEditCard(<?php echo $cc[ 'id' ]; ?>)">Edit</a></div>
												</div>
						 <?php
						 }
						 }
						 ?>
						 
						 <?php
						 if(sizeof($arrValue[ 'bank' ]) > 0){
						 foreach ($arrValue[ 'bank' ] as $bank)
						 {
						 ?>
												<div class="col-lg-12 cc_style">
													
													<div class="col-lg-5"><input type="radio" name="cc_id" onclick="paymentmethod('p_method_echeckpayment');" value="b_<?php echo $bank[ "id" ]; ?>" required="required"/>
							 <?php echo $bank[ "bank_acct_number" ].' ending with '.substr(preg_replace("/\s+/", "", $bank[ "routing_number" ]), -4); ?></div>
													<div class="col-lg-3"><?php echo $bank[ "echeck_name" ]; ?></div>
													<div class="col-lg-3"><?php echo $bank[ "account_type" ]; ?></div>
												</div>
						 
						 <?php
						 }
						 }
						 ?>
											</div>
										</div>
										<div class="clear"></div>
										<br/><br/><br/>
										<dt style="margin-left:0px; height: 90px;">
											<h3 style="float: left; cursor: pointer;" value="ccpayment">Pay By Credit Card (Secure) </h3>
											<input style="float: left; display: none;" id="p_method_ccpayment" value="ccpayment" type="radio" name="payment_method" class="radio" required="required">
											<div style="float:right"><img alt="" title="" src="<?php echo url('/'); ?>/uploads/credit_card_logos_11.gif" width="235" height="35" class="credit_card_logos" border="0"/></div>
											<div class="a-row a-spacing-base"><br/><br/>
												Medical shipment accepts all major credit and debit cards: <br/><br>
												<a onclick="paymentMethod('ccpayment')" style="cursor: pointer;" id="add_a_card">Add a card</a><br/><br/>
											</div>
										
										</dt>
										<div id="cc_opt" style="margin-left: 0px; margin-top: 10px; overflow: auto;height: auto;">
											<div class="a-row a-spacing-small" style="width: 350px; float: left;"> Enter your card information:</div>
											<!--<a onclick="paymentMethod('ccpayment')"><img src="images/close-button.png" alt="Close" title="Close" style="width: 80px; cursor: pointer;" /></a>-->
											<table id="tbl_address">
												<tr>
													<td>
														<div id="card_error" style="color: red;"></div>
													</td>
												</tr>
												<tr>
													<td>
														<select name='card_name' id='card_name' class="continput text required">
															<option value=''>Select Card</option>
															<option value='American Express'>American Express</option>
															<option value='Diners Club'>Diners Club</option>
															<option value='Discover'>Discover</option>
															<option value='Diners Club Enroute'>Diners Club Enroute</option>
															<option value='JCB'>JCB</option>
															<option value='Maestro'>Maestro</option>
															<option value='MasterCard'>MasterCard</option>
															<option value='Solo'>Solo</option>
															<option value='VISA'>VISA</option>
															<option value='VISA Electron'>VISA Electron</option>
															<option value='LaserCard'>LaserCard</option>
														</select>
													</td>
												</tr>
												<tr>
													<td>
														<br/>
														<input type="text" class="continput text required" placeholder="Name on Card" name="card_holder_name" id="card_holder_name" value=""/>
													</td>
												</tr>
												<tr>
													<td>
														<br/>
														<input type="text" class="continput text required creditcard error" placeholder="Credit Card Number" size="15" name="x_card_num" id="x_card_num" value=""/></td>
												</tr>
												<tr>
													<td>
														<br/>
														<input type="text" class="continput text required creditcard error" placeholder="CVV Number" size="15" name="x_card_cvv" id="x_card_cvv" value=""/></td>
												</tr>
												<tr>
													<td><b>Expiration Date</b><br/>
														<select name='x_exp_date_m' id='x_exp_date_m' class="continput text required">
															<option value=''>Month</option>
															<option value='01'>Janaury</option>
															<option value='02'>February</option>
															<option value='03'>March</option>
															<option value='04'>April</option>
															<option value='05'>May</option>
															<option value='06'>June</option>
															<option value='07'>July</option>
															<option value='08'>August</option>
															<option value='09'>September</option>
															<option value='10'>October</option>
															<option value='11'>November</option>
															<option value='12'>December</option>
														</select>
														<select name='x_exp_date_y' id='x_exp_date_y' class="continput text required">
															<option value=''>Year</option>
															<option value='16'>2016</option>
															<option value='17'>2017</option>
															<option value='18'>2018</option>
															<option value='19'>2019</option>
															<option value='20'>2020</option>
															<option value='21'>2021</option>
															<option value='22'>2022</option>
															<option value='23'>2023</option>
															<option value='24'>2024</option>
														</select></td>
												</tr>
												
												<tr>
													<td><input id="ccAddCard" onclick="AddCard();" class="signin_btn" tabindex="0" type="button" value="Add your card"></td>
												</tr>
											
											</table>
										</div>
										
										<div id="cc_opt_edit" style="margin-left: 0px; margin-top: 10px; overflow: auto;height: auto;"></div>
										
										<hr class="a-spacing-base">
										
										<dt style="margin-left:0px; height: 70px;">
											<h3 style="cursor: pointer;">Check / Money Order / Purchase Order </h3><br/><br/>
											<a onclick="paymentMethod('checkmo')" style="cursor: pointer;" id="send_check">Send Check / Money order to medicalshipment</a><br/>
											<input style="float: left; display: none;" id="p_method_checkmo" value="checkmo" type="radio" name="payment_method" class="radio" required="required">
										</dt>
										<div id="mo_opt" style="margin-left: 0px;">
											<!--<a onclick="paymentMethod('checkmo')"><img src="images/close-button.png" alt="Close" title="Close" style="width: 80px; cursor: pointer;" /></a>-->
											<ul class="form-list checkmo-list" id="payment_form_checkmo"><br/>
												<li style="width: 25%; float: left;"><input type="radio" name="check" id="check_radio" value="Check"/>Check</li>
												<li style="width: 25%; float: left;"><input type="radio" name="check" id="moneyorder_radio" value="Money Order"/>Money Order</li>
												<li><input type="radio" name="check" id="po_radio" value="Purchase Order"/>Purchase Order</li>
												<br/>
												<li style="font-size:13px !important;" class="check_tab">
													<label style="font-size:13px !important;">Make Check Payable To:</label>
													<span style="text-transform:uppercase;">Medical Shipment</span></li>
												<li style="font-size:13px !important; width:356px;" class="check_tab">
													<label style="font-size:13px !important;">Send Check To:</label>
													<address class="checkmo-mailing-address" style="font-size:13px !important;">
														Medical Shipment<br>
														8060 Saint Louis Avenue<br>
														Skokie, IL 60076
													</address>
												</li>
												<li style="font-size:13px !important;" class="po_tab">
													<input type="text" name="po_no" class="continput text" id="po_no" placeholder="Purchase Order No"/><br/><br/>
													<form id="poattachment"><input type="file" name="po_file" id="po_file" onchange="uploadImage(this.value)"/></form>
												</li>
											</ul>
										</div>
										
										<hr class="a-spacing-base">
										
										<dt style="margin-left:0px; height: 100px;">
											<h3 style="float: left; cursor: pointer;">Add a bank account</h3>
											<input style="float: left; display: none;" id="p_method_echeckpayment" value="echeckpayment" type="radio" name="payment_method" class="radio" required="required">
											
											<div style="float:right"><img alt="" title="" src="{{ url('/') }}/uploads/echecks.gif" width="98" height="64" class="credit_card_logos" border="0"/></div>
											<br/><br/>
											<div class="a-row a-spacing-base">Use your US based checking account.</div>
											<a onclick="paymentMethod('echeckpayment')" style="cursor: pointer;" id="checking_account">Add a checking account</a><br/>
										</dt>
										<div id="ec_opt" style="margin-left: 0px;">
											<div class="a-row a-spacing-base">
												<div class="a-size-medium a-spacing-base" style="font-size: 18px; padding-bottom: 10px;">Where are my account numbers?
																																																																																																					<!--<a onclick="paymentMethod('echeckpayment')"><img src="images/close-button.png" alt="Close" title="Close" style="width: 80px; cursor: pointer;" /></a>--> </div>
												<img src="{{ url('/') }}/uploads/check-example.gif">
												<div>
													<span class="a-size-mini"><strong> Bank Routing Number </strong></span>
													<span class="a-size-mini account-number-on-image"><strong> Checking Account Number </strong></span>
												</div>
											</div>
											
											<ul id="payment_form_echeckpayment" style="">
												<li>
													<div id="bank_error" style="color: red;"></div>
													<div class="input-box">
														<br>
														<input id="echeckpayment_echeck_name_account" placeholder="Name on Account" name="echeckpayment_echeck_name_account" class="input-text" autocomplete="off">
													</div>
												</li>
												<li>
													<div class="input-box">
														<br>
														<input id="echeckpayment_echeck_routing_number" placeholder="Bank routing number" name="echeck_routing_number" class="input-text" autocomplete="off">
													</div>
												</li>
												<li>
													<div class="input-box">
														<br>
														<input id="echeckpayment_echeck_bank_acct_num" placeholder="Bank account number" name="echeck_bank_acct_num" class="input-text" autocomplete="off">
													</div>
												</li>
												<li>
													<div class="input-box">
														<br>
														<input id="echeckpayment_echeck_driver_license_number" placeholder="Driver's License Number" name="echeckpayment_echeck_driver_license_number" class="input-text" autocomplete="off">
													</div>
												</li>
												<li>
													<div class="input-box">
                    <textarea class="a-spacing-micro text_areaabg" style="margin-top: 10px; margin-bottom: 10px;color: #000;text-transform: uppercase;"> BY CLICKING ON THE CONTINUE BUTTON, I AGREE TO THE TERMS AND CONDITIONS OF USING MY CHECKING ACCOUNT AS A PAYMENT METHOD, WHICH ARE LISTED BELOW, AND AUTHORIZE medicalshipment.com TO DEBIT MY CHECKING ACCOUNT FOR PURCHASES MADE ON medicalshipment.com, ANY medicalshipment.com AFFILIATE WEB SITE, OR THIRD PARTY WEB SITE USING AMAZON PAYMENTS.
Welcome to the terms and conditions (the "Terms and Conditions") for use of a bank account registered with medicalshipment.com as a payment method on the medicalshipment.com website, any Amazon affiliate website, or third-party website. Please note that your use of the medicalshipment.com website is also governed by our Conditions of Use and Privacy Notice, as well as all other applicable terms, conditions, limitations and requirements contained on the medicalshipment.com website, all of which (as changed over time) are incorporated into these Terms and Conditions. If you choose to use a bank account as your payment method, you accept and agree to these Terms and Conditions.
1. Bank Account Payments. By choosing to use a bank account as your payment method, you will be able to complete your purchase using any valid automated clearing house ("ACH") enabled bank account at a United States-based financial institution. Whenever you choose to pay for an order using your bank account, you are authorizing medicalshipment.com (or its agent) to debit your bank account for the total amount of your purchase (including applicable taxes, fees and shipping costs). Your transaction must be payable in U.S. dollars. medicalshipment.com, in its sole discretion, may refuse this payment option service to anyone or any user without notice for any reason at any time.
2. ACH Authorization. By choosing your bank account as your payment method, you agree that: (a) you have read, understand and agree to these Terms and Conditions, and that this agreement constitutes a "writing signed by you" under any applicable law or regulation, (b) you consent to the electronic delivery of the disclosures contained in these Terms and Conditions, (c) you authorize medicalshipment.com (or its agent) to make any inquiries we consider necessary to validate any dispute involving your payment, which may include ordering a credit report and performing other credit checks or verifying the information you provide against third party databases, and (d) you authorize medicalshipment.com (or its agent) to initiate one or more ACH debit entries (withdrawals) or the creation of an equivalent bank draft for the specified amount(s) from your bank account, and you authorize the financial institution that holds your bank account to deduct such payments.
3. Partial Debits and Returned Payments. If your full order is not processed by us at the same time, you hereby authorize partial debits from your bank account, not to exceed the total amount of your order. If any of your payments are returned unpaid, you authorize medicalshipment.com (or its agent) to make a one-time electronic fund transfer from your account to collect a return fee. This return fee will vary based on which state you are located in, as follows: $20 in CO, CT, ID, IN, NY and UT; $10 in Puerto Rico; and $25.00 for all other states. The return fee may be added to your payment amount and debited from your bank account if we resubmit an ACH debit due to insufficient funds. We may initiate a collection process or legal action to collect any money owed to us. You agree to pay all our costs for such action, including any reasonable attorneys' fees.
4. Cancellations and Refunds. To cancel a purchase made on the medicalshipment.com website and request a refund, please follow the instructions and procedures contained on the medicalshipment.com website. When you cancel a purchase in accordance with these procedures, medicalshipment.com (or its agent) will initiate a credit to your bank account for the correct amount. For purchases made from a seller other than medicalshipment.com, please contact the seller regarding its policy on returns and refunds.
5. Customer Service. Transactions that we process using your bank account will be identified as "Amazon" (or similar identifier) on the statement issued by your bank or other financial institution holding your account. All questions relating to any transactions made using your bank account by us should be initially directed to us. Save the order confirmations that you are provided when you make a purchase, and check them against your bank account statement. You may contact us regarding your medicalshipment.com orders or any payments made using your bank account and by writing to us at http://www.medicalshipment.com/contact-us. You may also view your transaction history for your medicalshipment.com order at any time in the "Your Account" area of the medicalshipment.com website.
6. Transaction Errors. If you believe that any payment transaction initiated by medicalshipment.com (or its agent) with respect to your bank account is erroneous, or if you need more information about any such transaction, you should contact us as soon as possible as provided in Section 5 of these Terms and Conditions. Notify us at once if you believe the password associated with your medicalshipment.com customer account has been lost or stolen, or if someone has attempted (or may attempt) to make a transfer from your bank account to complete a purchase using your medicalshipment.com customer account without your permission. We reserve the right to cancel the ability to pay by bank account on medicalshipment.com or other website for any reason at any time.
7. Your Liability for Unauthorized Transactions. Federal law limits your liability for any fraudulent, erroneous unauthorized transaction from your bank account based on how quickly you report it to your financial institution. As general rule, you should report any fraudulent, erroneous or unauthorized transactions to your bank within 60 days after the questionable transaction FIRST appeared on your bank account statement. You should contact your bank for more information about the policies and procedures that apply to your account and any unauthorized transactions, including any limits on your liability.
8. Electronic Delivery of Future Disclosures. You agree to accept all disclosures and other communications between you and us on this website or at the primary e-mail address associated with your medicalshipment.com customer account. You should print and retain a copy of all such disclosures and communications.
9. Agreement Changes. We may in our discretion change these Terms and Conditions, medicalshipment.com's Conditions of Use and/or its Privacy Notice at any time without notice to you. If any change is found to be invalid, void, or for any reason unenforceable, that change is severable and does not affect the validity and enforceability of any other changes or the remainder of these Terms and Conditions. We reserve the right to subcontract any of our rights or obligations under these Terms and Conditions. YOUR CONTINUED USE OF YOUR BANK ACCOUNT AS A PAYMENT METHOD ON medicalshipment.com OR OTHER SITES USING YOUR AMAZON ACCOUNT ARE ACCEPTED AFTER WE CHANGE THESE TERMS AND CONDITIONS, medicalshipment.com'S CONDITIONS OF USE AND/OR ITS PRIVACY NOTICE CONSTITUTES YOUR ACCEPTANCE OF THESE CHANGES. </textarea>
													</div>
												</li>
												<li>
													<div class="input-box">
														<br>
														<select id="echeckpayment_echeck_account_type" name="echeck_account_type" class="input-text validation-passed" autocomplete="off">
															<option value="">Select Account Type</option>
															<option value="CHECKING">Checking</option>
															<option value="BUSINESSCHECKING">Business checking</option>
															<option value="SAVINGS">Savings</option>
														</select>
													</div>
												</li>
												<li>
													<input id="ccAddBank" onclick="AddBank();" class="signin_btn" tabindex="0" type="button" value="Add your bank">
												</li>
											</ul>
										</div>
										
										<hr class="a-spacing-base">
										
										<tr>
											<td><b>&nbsp;</b></td>
											<td><input type="submit" class="signin_btn" id="checkoutContinue" value="Continue" style="float: right;"/></td>
										</tr>
										<!--</form>-->
										<br/>
										<br/>
					 <?php
					 
					 if(isset($_SESSION[ 'msg_cop' ]) && $_SESSION[ 'msg_cop' ] != ''){
					 
					 ?>
										<table>
											<tbody>
											<tr id="error_message" align="left" width="20%">
												<td width="120"><?php echo trim($_SESSION[ 'msg_cop' ])?></td>
											</tr>
											</tbody>
										</table>
					 <?php
						 
					 }
					 
					 ?>
									</div>
								
								</div>
							</div>
							
							<!--left_bigportion--><br>
							<br>
							<div class="left_bigportion2">
								<span class="step-header amz-stepped">3</span>
								<h4 style="font-size: 14px; font-weight: bold; margin-bottom: 10px!important; padding-bottom: 5px;">Review Items &amp; Shipping</h4>
								<div class="col-lg-6">
					
					<?php
					$a = "";
					$str = "";
					
					$carts = Session::get('cart');
					foreach(array_reverse($carts) as $post){
					
					$product_bundle = 0;
					if($post[ 'product_bundle' ] != 0){
						$product_bundle = $post[ 'product_bundle' ];
					}
					
					if(isset($post[ 'configure_product' ]) and $post[ 'configure_product' ] != 0){
						$manufacturer = $post[ 'manufacturer' ];
						$uom = $post[ 'uom' ];
						
						$manuf_rec = @reset(json_decode(json_encode(DB::select("SELECT cpa_option FROM config_product_option where cpo_id=".$manufacturer)), true));
						
						$uom_rec = @reset(json_decode(json_encode(DB::select("SELECT cpa_option FROM config_product_option where cpo_id=".$uom)), true));
					}
					
					$product_id = (int) (trim($post[ 'product_id' ]));
					
					$unit_id = (int) (trim($post[ 'unit_id' ]));
					
					$product_quantity = (int) (trim($post[ 'product_quantity' ]));
					
					$sql = "select p.*, pm.product_image from product as p join product_image as pm on p.product_id= pm.product_id where p.product_id='".$product_id."'";
					
					
					
					$query = DB::select($sql);
					
					$mfa = @reset(json_decode(json_encode($query), true));
					
					
					
					# Unit Price
					
					$sql_unit = "select * from unit u inner join unit_product up on u.unit_id=up.unit_id where up.product_id='".(int) (trim($post[ 'product_id' ]))."' and up.unit_id='".(int) (trim($post[ 'unit_id' ]))."'";
					
					//	echo $sql_unit;
					
					$query_unit = DB::select($sql_unit);
					
					$mfa_unit = @reset(json_decode(json_encode($query_unit), true));
					
					$price = 0;
					
					$is_Special = 0;
					
					$is_Special_Text = '';
					
					if(trim($mfa_unit[ 'product_sprice' ]) != 2){
						
						$price = trim($mfa_unit[ 'product_price' ]);
					}else{
						
						$price = trim($mfa_unit[ 'product_sprice' ]);
						
						$is_Special = 1;
						
						$is_Special_Text = " <div class='special_text'>S</div>";
					}
					
					# Bundle Product
					$bundle_unit_price = 0;
					if($product_bundle != 0){
						
						$bp_array = array();
						foreach($post[ 'product_bundle' ] as $key => $val){
							
							$group_id = $key;
							$qty = 0;
							
							$k = '';
							foreach($val as $key1 => $val1){
								
								if(is_array($val1)){
									
									foreach($val1 as $product_bundle){
										
										$k .= $product_bundle.',';
									}
								}else{
									
									$qty = $val1;
								}
								if($qty != 0){
									$bp_array[] = array($group_id => array(rtrim($k, ',').'|'.$qty));
								}
							}
						}
						
						foreach($bp_array as $key => $value){
							foreach($value as $key1 => $value1){
								
								
								# Get Group Title
								$sql_group = "select * from bundle_product where bp_id='".$key1."'";
								$query_group = DB::select($sql_group);
								$mfa_group = @reset(json_decode(json_encode($query_group), true));
								$group = trim(stripslashes($mfa_group[ 'bp_title' ]));
								$group_id = trim($mfa_group[ 'bp_id' ]);
								
								foreach($value1 as $value2){
									
									$exp = explode('|', $value2);
									$value2 = trim($exp[ 0 ]);
									$qty = trim($exp[ 1 ]);
									
									$sql_bundle = "select * from product where product_id in(".$value2.")";
									$query_bundle = mysql_query($sql_bundle);
									
									while($mfaBP = mysql_fetch_assoc($query_bundle)){
										
										# Get Group Title
										$sql_price = "select * from unit_product where product_id='".$mfaBP[ 'product_id' ]."'";
										$query_price = DB::select($sql_price);
										$mfa_price = @reset(json_decode(json_encode($query_price), true));
										$price = trim($mfa_price[ 'product_price' ]);
										$sprice = trim($mfa_price[ 'product_sprice' ]);
										if(trim($sprice) != ''){
											
											$price = $sprice;
										}
										$bundle_unit_price += $price*$qty;
										
										$str .= '<label class="qnty">'.$qty.'</label>'.' x <label class="product">'.$mfaBP[ 'product_title' ].'</label> [ <label class="price">$'.number_format(trim($price), 2).'</label> ] '.'<br>';
									}
									
									if($str != ''){
										$str = '<br><label class="group">'.$group.'</label>'.'<br><br>'.$str;
										$a .= $str;
										$str = '';
									}
								}
							}
						}
						/*echo '<pre>'.print_r($bp_array,true).'</pre>';exit;*/
					}
					
					
					
					?>
									<div style="float:none; clear:both;">
										<div id="div_custom_img_<?=$mfa[ 'product_id' ]; ?>" style="float:left; width:80px !important;"><a href="<?php echo url('/').'/uploads/index.php?controller=product&function=index&id='.$product_id?>"><img src="<?php echo url('/').'/uploads/product/'.trim($mfa[ 'product_image' ])?>" width="62" height="60"></a></div>
										<div id="div_custom_<?=$mfa[ 'product_id' ]; ?>" style="float:left; width:71%;  margin-bottom: 15px; line-height: 20px;">
											<input type="hidden" id="price_update_input_<?=$mfa[ 'product_id' ]; ?>" value="<?=$price; ?>">
											<strong> <?php echo stripslashes($mfa[ 'product_title' ])?>
						 <?php if(isset($manufacturer) and $manufacturer != ''){
							 echo '<p>Manufacturer: '.$manuf_rec[ "cpa_option" ].'</p>';
						 }
						 
						 if(isset($uom) and $uom != ''){
							 echo '<p>UOM: '.$uom_rec[ "cpa_option" ].'</p>';
						 }
						 ?>
												<b style="text-decoration:underline">
							<?php
							if($product_bundle != 0){
								echo "<br>".trim($a);
							}
							?>
												</b> <br>
												#<?php echo stripslashes($mfa[ 'product_item_no' ])?></strong><br>
											<strong style="color:#434343;"> $<span id="price_update_<?=$mfa[ 'product_id' ]; ?>">
                  <?php
							 if($bundle_unit_price != 0){
								 echo number_format($bundle_unit_price, 2);
							 }else{
								 echo number_format(trim($price), 2);
							 }?>
                  </span> </strong> <br>
											<strong>Quantity: </strong> <span style="" id="qty_change_<?=$mfa[ 'product_id' ]; ?>"><?php echo (int) ($product_quantity); ?></span>
											<input style="display:none;" class="qty_place_ordr" type="text" onkeyup="showHideUpdate(<?=$mfa[ 'product_id' ]; ?>)" name="qty_place_order_<?=$mfa[ 'product_id' ]; ?>" id="qty_place_order_<?=$mfa[ 'product_id' ]; ?>" value="<?php echo (int) ($product_quantity); ?>">
											<span class="updatqty" id="updateQty_<?=$mfa[ 'product_id' ]; ?>" style="display:none" onclick="updateQty(<?=$mfa[ 'product_id' ]; ?>);">Update</span> <span id="del_link_<?=$mfa[ 'product_id' ]; ?>" style=" display:none;color:#0088CC;cursor: pointer;" onclick="delete_item('<?=$mfa[ 'product_id' ]; ?>')" title="Remove Item" class="del_button_new btn-remove">| Delete</span>
											<p class="f-left1"><a onclick="change_item(<?=$mfa[ 'product_id' ]; ?>);" id="change_link_<?=$mfa[ 'product_id' ]; ?>" style="display: block;">Change</a></p>
										</div>
									</div>
					
					<?php
						
					}
					
					//if($_SESSION[ 'reference' ] == 'flyer'){
					if(session()->get('reference') == 'flyer'){
						$discount_amount = ($cart_total/100)*10;
						$total_after_tax = $total_after_tax-$discount_amount;
					}
					?>
								</div>
								<div class="col-lg-6" style="width: 54%;">
								
								</div>
							</div>
							
							<!--left_bigportion-->
							
							<!--<a onclick="history.back();">
							<button class="signin_btn submit_helper" title="Back" type="submit">Back</button>
							</a> -->
							<div class="left_bigportion2" style="/* width: 280px;bottom: 0px;position: absolute;right: 0; */">
								<div id="review-buttons-container" style="position: relative; top: 0px; left: 25px; width: 260px;float: left;" class=""><a>
										<button onclick="review.save();" class="placeorder_btn" title="Place Order" type="submit" style="margin-top: 15px;"><span style="display:inline-table; padding-left: 2px;color:white;opacity: 0.5;">Place Order</span></button>
									</a><br>
									<span class="please-wait" id="review-please-wait" style="position: relative; left: -88px; display: none;"> <img src="https://www.medicalshipment.com/skin/frontend/default/medicalshipment2012/images/opc-ajax-loader.gif" alt="Submitting order information..." title="Submitting order information..." class="v-middle"> Submitting order information... </span> <br>
									<br>
								</div>
								<p style="font-size: 16px; line-height: 25px;margin-top: 10px;"><b style="color: brown;">Order Total: $<span id="order_total_bottom"><?php echo number_format(trim($total_after_tax), 2)?></span></b></p>
								<p style="font-size: 9px;">By placing your order, you agree to medicalshipment.com's <a href="<?php echo url('/'); ?>/uploads/index.php?controller=content&function=index&slug=term-conditions">privacy notice</a> and <a href="<?php echo url('/'); ?>/uploads/index.php?controller=content&function=index&slug=privacy-policy">conditions of use</a>.</p>
							</div>
						</div>
						<div class="col-lg-4 right_bigportion">
							<div id="tour_div_11" class="stanrd_shipingsmall" style="float:right;width:280px;position:relative">
								<div id="review-buttons-container" style="position: relative; top: 10px; left: 30px; height: 50px;" class=""><a>
										<button onclick="review.save();" class="placeorder_btn" title="Place Order" type="submit"><span style="display:inline-table; padding-left: 2px;color:white;opacity: 0.5;">Place Order</span></button>
									</a><br/>
									<br/>
									<br/>
								</div>
								<p style="margin: 0 15px; border-bottom: 1px solid #CCC; padding: 5px 0 10px 0; font-size: 9px;text-align: center;">By placing your order, you agree to medicalshipment.com's <a href="<?php echo url('/'); ?>/uploads/index.php?controller=content&function=index&slug=term-conditions">privacy notice</a> and <a href="<?php echo url('/'); ?>/uploads/index.php?controller=content&function=index&slug=privacy-policy">conditions of use</a>.</p>
								<h1 class="shiping_haad" style="font-size: 13px !important; color: #0d0d0d;font-family: Arial,sans-serif;">Order Summary</h1>
								<br style="clear:both;">
								<div style="float:left; width:190px; height:auto;">
									<table style="width:400px; float:left;">
										<tbody>
										<tr align="left" width="20%" style="margin-top:10px !important;">
											<td width="150"> Items (<span id="cart_quantity_updated"><?php echo trim($total_item)?></span>):</td>
											<td colspan="2">&nbsp;</td>
											<td width="120" style="position:absolute;right:15px;"><span style="float:right;"> $<span id="total_amount"><?php echo number_format(trim($cart_total), 2)?></span></span></td>
										</tr>
										<tr align="left" width="20%">
											<td width="150"> Shipping &amp; handling:</td>
											<td colspan="2">&nbsp;</td>
											<td width="120" style="position:absolute;right:15px;"><span style="float:right;"> $<span id="tax_amount"><?php echo number_format($delivery_charges, 2)?></span></span></td>
										</tr>
										<tr class="stnrad_table" style="float: left; margin-bottom: 10px; margin-top: 10px; width: 241px;"></tr>
										<!--<tr class="line" width="51%">

												<td colspan="2">&nbsp;</td>

										</tr>-->
										
										<tr align="left" width="20%">
											<td width="150"> Total before Tax:</td>
											<td colspan="2">&nbsp;</td>
											<td width="120" style="position:absolute;right:15px;"><span style="float:right;"> $<span id="total_befor_tax"><?php echo number_format(trim($total_before_tax), 2)?></span></span></td>
										</tr>
										<tr align="left" width="20%">
											<td width="170"> Estimated Tax to be calculated:</td>
											<td colspan="2">&nbsp;</td>
											<td width="120" style="position:absolute;right:15px;"><span style="float:right;">$<span id="tax_ammnt_new"><?php echo number_format(trim($tax), 2)?></span></span></td>
										</tr>
					<?php
					
					//if($cop_type != '' || $_SESSION[ 'reference' ] == 'flyer'){
					if($cop_type != '' || session()->get('reference') == 'flyer'){
					?>
										<tr id="order_discount_coupon" align="left" width="20%">
											<td width="150">Discount:</td>
											<td colspan="2">&nbsp;</td>
											<td width="120" style="position:absolute;right:15px;"><span style="float:right"> - $<?php echo number_format($discount_amount, 2)?></span></td>
										</tr>
					<?php
						
					}
					
					?>
										</tbody>
									</table>
									<div class="stnrad_table" style="float: left; margin-bottom: 10px; margin-left: 18px; width: 241px;"></div>
									<table style="width:400px; float:left;">
										<tbody>
										<tr align="left" width="20%">
											<td width="150" style="font-size: 16px; font-weight: bold;"><b style="color: brown;">Order Total:</b></td>
											<td colspan="2">&nbsp;</td>
											<td id="order_total_clr" class="order_total_clr" width="120" style="position:absolute;right:15px; font-size: 16px; font-weight: bold;"><span style="float:right; color: brown;"> $<span id="grand_total_amount_after_tax" style="color: brown;"><?php echo number_format(trim($total_after_tax), 2)?></span></span><br></td>
										</tr>
										</tbody>
									</table>
								</div>
								<div id="checkout-review-submit">
									<form action="" id="checkout-agreements" onsubmit="return false;">
										<ol class="checkout-agreements">
										</ol>
									</form>
								</div>
							</div>
							
							<!--stanrd_shiping-->
							<div class="clear"></div>
						</div>
					
					</div>
				
				</div>
				
				<!--bodycontent-->
				
				<div class="contentbot"></div>
			</div>
			
			<!--content End-->
		
		</div>
	</div>
</div>
<script type="text/javascript">
		
		/*function submitForm(){
		
			var checkedValue=$('.radio:checked').val();
		
			if(checkedValue=='checkmo' || checkedValue=='echeckpayment'){
		
				$('#cc_opt').html('');
				
		//		$('#selectpayment').slideUp('slow');
		
				$("#checkout_form").submit();
		
			}
		}*/

</script>
