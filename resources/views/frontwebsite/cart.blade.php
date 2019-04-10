<?php
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;
?>
@extends('frontwebsite._mainLayout2')
@section('content')
	<?php
	
	$add = "style='display:block; margin-top: 10px;'";
	$edit = "style='display:none'";
	
	$slugs = explode ("/", request()->fullUrl());
 	$url_id = $slugs [(count ($slugs) - 1)];
	
	//if(request()->get('id') != null){
	if(isset($url_id) && is_numeric($url_id)){
		
		$add = "style='display:none'";
		
		$edit = "style='display:block'";
	}
	$ship_id = '';
	if(request()->get('ship_id') != null){
		$ship_id = request()->get('ship_id');
	}
	
	
	$delivery_method = '';
	$delivery_charges = 0.00;
	
	$ship_pref = '';
	if(session()->get('ship_pref') != null){
		$ship_pref = trim(stripslashes(session()->get('ship_pref')));
	}
	
	if(session()->get('ship_to_this') != null){
		$ship_to_this = trim(session()->get('ship_to_this'));
	}else{
		$ship_to_this = '';
	}
	
	
	if(session()->get('payment_method') && session()->get('payment_method') != null){
		$payment_method = trim(stripslashes(session()->get('payment_method')));
	}else{
		$payment_method = '';
	}
	
	//	$medical = new medicalModel;
	
	$cart_total = Helper::instance()->getCartTotal();
	
	$total_item = 0;
	
	# Get Total Quantity/Item + Cart Total
	$sessionCart = (session()->get('cart') != null) ? json_decode(json_encode(session()->get('cart')), true) : [];
	foreach($sessionCart as $post){
		$total_item += $post[ 'product_quantity' ];
	}
	session()->put('msg_cop', '');
	
	if(request()->input('coupon_code') != null){
		
		$cc = trim((request()->input('coupon_code')));
		
		$sql = "select c.*, ct.* from coupon c inner join coupon_type ct on c.ct_id=ct.ct_id where c.cop_code='".$cc."' and c.cop_status=1";
		
		$query = reset(json_decode(json_encode(DB::select($sql)), true));
		
		$rows = count($query);
		
		if($rows > 0){
			
			$mfaC = $rows;
			
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
	}
	
	
	
	$discount_amount = 0;
	
	$cop_type = '';
	
	if(session()->get('coupon_type') != null && session()->get('coupon_type') == 1){
		
		$cop_type = 'Free Shipping';
		
		$discount_amount = $delivery_charges;
	}
	
	if(session()->get('coupon_type') != null && session()->get('coupon_type') == 2){
		
		$cop_type = '% Off';
		
		$amount = trim(session()->get('coupon_value'))/100*$cart_total;
		
		$discount_amount = $amount;
	}
	
	if(session()->get('coupon_type') && session()->get('coupon_type') == 3){
		
		$cop_type = '$ Amount';
		$amount = trim(sessio()->get('coupon_value'));
		$discount_amount = $amount;
	}
	
	
	
	session()->put('discount_amount', $discount_amount);
	
	session()->put('ctype', $cop_type);
	
	
	
	$tax = 0;
	
	$total_before_tax = $cart_total+$delivery_charges;
	
	$total_after_tax = $cart_total+$delivery_charges+$tax-$discount_amount;
	
	?>
		<style type="text/css">
			.tbl input {
				border: 1px solid #66522f4f !important;
			}
			
			li {
				font-size: 11px;
			}
			
			.tbl {
			}
			
			.tbl tr {
				height: auto;
				border: 0px solid #bababa;
			}
			
			.tbl td {
				padding: 4px 4px 4px 0px;
				border: 0px solid #bababa;
			}
			
			.action_btn {
				padding: 0;
			}
			
			.submit_helper {
				padding: 0;
				width: 230px;
				margin: auto;
				line-height: normal;
				border: 0 none;
				float: none;
				font-size: 18px !important;
			}
			
			.proposal {
				font-size: 18px;
				font-weight: bold;
			}
			
			.steps {
				float: right;
				margin-top: 10px;
				margin-bottom: 10px;
			}
			
			.default_chk {
				margin-left: 25px;
				position: absolute;
				margin-top: 0px;
			}
			
			.submit_btn {
				padding: 0;
			}
			
			.inqury_ipput {
				background: rgba(0, 0, 0, 0) url("images/input_bgs.png") no-repeat scroll 0 0 !important;
				border: medium none !important;
				color: #000;
				font-family: arial !important;
				font-size: 18px !important;
				height: 36px !important;
				padding: 0 15px 0 14px !important;
				width: 391px !important;
			}
			
			.signin_btn {
				background-position: -4px 0px !important;
				width: 210px;
			}
			
			.signin_btn:hover {
				background: transparent url("images/login_btn_hover.png") no-repeat scroll 0 0 !important;
			}
			
			.inqury_ipput:focus {
				background-color: #fff !important;
				background-image: none !important;
				border: 2px solid rgb(48, 129, 190) !important;
				box-shadow: 0 0 10px #1e7ec8 !important;
				height: 36px !important;
			}
			
			td a {
				text-decoration: none;
			}
			
			td a:hover {
				text-decoration: underline;
			}
			
			.right_tbl_opt {
				float: left;
				margin-top: -35px;
			}
			
			.deledit_btn {
				background: transparent url("images/del_edit.png") no-repeat scroll 0 0 !important;
				border: medium none;
				color: #616161 !important;
				cursor: pointer !important;
				font-family: Arial, Helvetica, sans-serif !important;
				font-weight: normal;
				margin-right: 9px;
				margin-left: 0px !important;
				margin-top: 2px;
				min-height: 34px;
				padding-bottom: 2px;
				padding-right: 4px;
				width: 96px;
			}
			
			.deledit_btn:hover {
				background: transparent url("images/del_edit_hover.png") no-repeat scroll 0 0 !important;
			}
			
			.formError {
				left: 405px !important;
			}
			
			.content {
				width: 80%;
				height: 800px;
				margin: 0 auto;
			}
			
			.right_bigportion {
				float: right;
				width: 30%;
			}
			
			:-ms-input-placeholder {
				color: #CCC;
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
				
				.inqury_ipput, .inqury_ipput:hover {
					background-size: 100% 100% !important;
					width: 100% !important;
				}
				
				.stanrd_shipingsmall {
					width: 100% !important;
				}
			}
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script>
			$(function () {
					
					// OnKeyDown Function
					$("#zip").keyup(function () {
							var zip_in = $(this);
							
							if ((zip_in.val().length == 5)) {
									
									$.ajax({
											url : "https://api.zippopotam.us/us/" + zip_in.val() ,
											cache : false ,
											dataType : "json" ,
											type : "GET" ,
											success : function (result , success) {
													cabb = JSON.stringify(result['country abbreviation']);
													cabb = cabb.replace(/"/g , '');
													
													// US Zip Code Records Officially Map to only 1 Primary Location
													places = result['places'][0];
													sabb = places['state abbreviation'];
													matchString = sabb + "_" + cabb;
													$("#city").val(places['place name']);
													var select = document.getElementById('states');
													var len = select.options.length;
													for (var i = 0; i < len; i++) {
															
															if (select.options[i].value == matchString) {
																	select.selectedIndex = i;
															}
															
													}
													/*zip_box.addClass('success').removeClass('error');*/
											} ,
											error : function (result , success) {
													/*zip_box.removeClass('success').addClass('error');*/
											}
									});
							}
					});
					
			});
		
		</script>
		
		<div class="container" id="checkout_body">
			<div class="row main-contant">
				<div class="container contant-con">
					<div class="content">
						<div class="col-lg-12">
							<h3>Select a shipping address</h3>
							<div class="steps"><img src="<?php echo url('frontend/images/'); ?>cart_imags2.jpg"/></div>
							<div class="clear:both"></div>
							<br/>
							<br/>
							<br/>
							<div class="col-lg-12">
								<div class="col-lg-8 left_allportion">
									<div class="left_bigportion">
										<div style="float:left;border-bottom: 1px solid #CCC;padding-bottom: 10px;margin-bottom: 10px;" class="col-lg-12" id="ship_panel">
											<div id="tour_div_7" class="introjs-showElement introjs-relativePosition">
												<span class="step-header amz-stepped active_step">1</span>
												<h4 class="active_step" style="border-bottom: 1px solid #CCC;">Shipping Address</h4>
												<p id="loading_address"><img src="{{ url('/uploads/loader.gif') }}"/> Saving address information</p>
												<br/><br/>
												
												<div id="slide_address">
													<ul>
                        <?php /*?><form action="<?php echo 'index.php?controller=cart&function=payment'?>" method="get"><?php */?>
                        <?php /*?><form action="{{ url('cart/payment') }}" method="get"><?php */?>
   							{{ csrf_field() }}
                            <input type="hidden" name="controller" value="cart"/>
                            <input type="hidden" name="function" value="checkout"/>
							 <?php
							 
							 $amsco = Helper::instance();
							 
							 $state_array = $amsco->states;
							 
							 $medical = Helper::instance();
							 $state_array_c = $amsco->cstates;
							 
							 $arrArgument[ 'table' ] = 'bill_ship_address';
							 $where = ['user_id' => session()->get('user_id')];
							 $arrArgument[ 'where' ] = $where;
							 $arrArgument[ 'operator' ] = 'AND';
							 $arrArgument[ 'order' ] = 'bsa_id ASC';
							 $arrValue[ 'bsa' ] = Helper::instance()->getRecord($arrArgument);
							 
							 if(isset($arrValue[ 'bsa' ]) && !empty($arrValue[ 'bsa' ])){
							 
							 echo '<h3>Your address book</h3><br>';
							 
							 foreach($arrValue[ 'bsa' ] as $post){
							 
							 $bsa = $post[ 'bsa_id' ];
							 
							 $fname = trim(stripslashes($post[ 'bsa_fname' ]));
							 $lname = trim(stripslashes($post[ 'bsa_lname' ]));
							 $phone = trim(stripslashes($post[ 'bsa_phone' ]));
							 $zip = trim(stripslashes($post[ 'bsa_zip' ]));
							 $city = trim(stripslashes($post[ 'bsa_city' ]));
							 $state = trim(stripslashes($post[ 'bsa_state' ]));
							 $country = trim(stripslashes($post[ 'bsa_country' ]));
							 $address = trim(stripslashes($post[ 'bsa_address' ]));
							 
							 $default_style = "";
							 
							 if($post[ 'bsa_default' ] == 1){
								 $default_style = "";
							 }
							 
							 ?>
														<div class="col-lg-12">
															<li>
																<input type="radio" name="ship_to_this" class="signin_btn submit_helper" value="<?php echo $bsa?>" <?php if($post[ 'bsa_default' ] == 1){
									echo "checked='checked'";
								} ?> required="required" <?php if($ship_id == $bsa){
									echo ' checked="checked"';
								} ?>>
																<b <?php echo $default_style?>><?php echo ucwords($fname.' '.$lname)?></b>,<?php echo $address?>
								 <?php
								 
								 echo $city.', ';
								 
								 if(@$state_array[ $state ]){
									 echo stripslashes($state_array[ $state ]).' ';
								 }else{
									 echo stripslashes($state_array_c[ $state ]).' ';
								 }
								 echo $zip
								 
								 ?>,<?php if($country != 'US'){
									 echo $country.', ';
								 } ?>
	<a href="{{ url('checkoutpage/'.$bsa) }}">Edit</a> | <a href='<?php echo url('').'index.php?controller=billship&function=remove&id='.$bsa.'&redirect'?>'>Delete</a>
															</li>
														</div>
							 <?php
							 }
							 ?>
														<input type="submit" class="signin_btn submit_helper" id="useAddress" value="Use this Address">
						 <?php  }
						 
						 ?>
													<!--</form>-->
													</ul>
													<div class="col-lg-12" <?php echo $add?>><br/>
													<!--<img src="<?php echo ''; ?>border_02img.jpg">--> <br/>
														<form action="<?php echo url('/addaddress')?>" method="post" {{--onsubmit="return varifyaddress()"--}} id="myform" name="myform">
															<input type="hidden" name="redirect"/>
															{{ csrf_field() }}
															<input type="hidden" name="type" value="shipping"/>
															<table class="tbl">
																<tr>
																	<td><h4 class="proposal">New Address</h4>
																		<br/>
																		<p>Be sure to click "Ship to this address" when done.</p>
																		<p id="addr_error" style="color: red;"></p></td>
																</tr>
																<tr>
																	<td><input type="text" class="inqury_ipput validate[required,maxSize[20]]" name="fname" id="fname" value="" placeholder="First Name" data-errormessage-value-missing="What's your first name"/></td>
																</tr>
																<tr>
																	<td><input type="text" class="inqury_ipput validate[required,maxSize[20]]" name="lname" id="lname" placeholder="Last Name" value="" data-errormessage-value-missing="What's your last name"/></td>
																</tr>
																<tr>
																	<td><input type="text" class="inqury_ipput validate[required]" name="phone" id="phone" placeholder="Phone Number" value="" data-errormessage-value-missing="What's your phone"/></td>
																</tr>
																<tr>
																	<td><input type="text" name="address" id="address" class="inqury_ipput validate[required]" placeholder="Street Address, P.O.Box, C/O" spellcheck="false" data-errormessage-value-missing="What's your address"/></td>
																</tr>
																<tr>
																	<td><input type="number" class="inqury_ipput validate[required]" name="zip" id="zip" onkeypress="return isNumber(event)" placeholder="Zip Code (Numeric values only)" value="" data-errormessage-value-missing="What's your zip code"/></td>
																</tr>
																<tr>
																	<td><input type="text" class="inqury_ipput validate[required]" name="city" id="city" placeholder="City" value="" data-errormessage-value-missing="What's your city"/></td>
																</tr>
																<tr>
																	<td><select name="state" id="states" class="inqury_ipput validate[required]" data-errormessage-value-missing="What's your state">
																			<option value="">United States / Canada</option>
																			<option style="font-size:16px;background-color:#00478f;color:#FFF;" value="Sold Out">United States</option>
										 <?php
										 
										 foreach($medical->states as $key=>$value){
										 
										 if($value != '*'){
										 
										 ?>
																			<option class="option" value="<?php echo $key.'_US'?>"><?php echo stripslashes($value)?></option>
										 <?php
											 
										 }
											 
										 }
										 
										 ?>
																			<option style="font-size:16px;background-color:#00478f;color:#FFF;" value="Sold Out">Canada</option>
										 <?php
										 
										 foreach($medical->cstates as $key=>$value){
										 
										 if($value != '*'){
										 
										 ?>
																			<option class="option" value="<?php echo $key.'_CA'?>"><?php echo stripslashes($value)?></option>
										 <?php
											 
										 }
											 
										 }
										 
										 ?>
																		</select></td>
																</tr>
																<tr>
																	<td><select title="Select an Address Type" name="address_type" class="inqury_ipput validate[required]" data-errormessage-value-missing="Address type please">
																			<option value="">Select an Address Type</option>
																			<option value="Educational">Educational</option>
																			<option value="Residential">Residential</option>
																			<option value="Commercial">Commercial</option>
																		</select></td>
																</tr>
																<tr>
																	<td><input type="text" name="ship_dir" placeholder="Special Shipping Directions" class="inqury_ipput"/></td>
																</tr>
																<tr>
																	<td><input type="checkbox" name="default" id="default" style="width:20px;float:left"/>
																		<label class="default_chk">Default</label></td>
																</tr>
																<tr>
																	<td><input type="submit" name="submit" class="signin_btn submit_helper" value="Ship to this Address"></td>
																</tr>
															</table>
														</form>
													</div>
													<div class="col-lg-12" <?php echo $edit?>><br/>
														<br/>
                                                        
														<form action="{{ url('billship/edit') }}" method="post" id="myform1">
															
                                                            {{ csrf_field() }}
                                                            <input type="hidden" name="redirect" value="1"/>
															<input type="hidden" name="id" value="<?php echo @$arrValue[ 'bsa_edit' ][ 0 ][ 'bsa_id' ]?>"/>
															<input type="hidden" name="type" value="shipping"/>
															<table class="tbl">
																<tr>
																	<td><h4 class="proposal">Edit Address</h4>
																		<br/>
																		<p>Be sure to click "Ship to this address" when done.</p></td>
																</tr>
																<tr>
																	<td><label>First Name <b>*</b></label>
																		<input type="text" class="inqury_ipput validate[required,maxSize[20]]" name="fname" id="fname1" value="<?php echo trim(@$arrValue[ 'bsa_edit' ][ 0 ][ 'bsa_fname' ])?>" required/></td>
																</tr>
																<tr>
																	<td><label>Last Name <b>*</b></label>
																		<input type="text" class="inqury_ipput validate[required,maxSize[20]]" name="lname" id="lname1" value="<?php echo trim(@$arrValue[ 'bsa_edit' ][ 0 ][ 'bsa_lname' ])?>" required/></td>
																</tr>
																<tr>
																	<td><label>Phone <b>*</b></label>
																		<input type="text" class="inqury_ipput validate[required]" name="phone" id="phone" value="<?php echo trim(@$arrValue[ 'bsa_edit' ][ 0 ][ 'bsa_phone' ])?>" required/></td>
																</tr>
																<tr>
																	<td><label>Address <b>*</b></label>
																		<input type="text" name="address" id="address1" class="inqury_ipput validate[required]" required value="<?php echo trim(@$arrValue[ 'bsa_edit' ][ 0 ][ 'bsa_address' ])?>"/></td>
																</tr>
																<tr>
																	<td><label>Zip <b>*</b></label>
																		<input type="text" class="inqury_ipput validate[required]" name="zip" id="zip" value="<?php echo trim(@$arrValue[ 'bsa_edit' ][ 0 ][ 'bsa_zip' ])?>" required/></td>
																</tr>
																<tr>
																	<td><label>City <b>*</b></label>
																		<input type="text" class="inqury_ipput validate[required]" name="city" id="city" value="<?php echo trim(@$arrValue[ 'bsa_edit' ][ 0 ][ 'bsa_city' ])?>" required/></td>
																</tr>
																<tr>
																	<td><label>Country / State <b>*</b></label>
																		<select name="state" id="state" class="inqury_ipput validate[required]">
																			<option value="">United States / Canada</option>
																			<option style="font-size:16px;background-color:#00478f;color:#FFF;" value="Sold Out">United States</option>
										<?php
										
										foreach($medical->states as $key=>$value){
										
										if($value != '*'){
										$selected = ""; 
										if(trim($key) == trim(@$arrValue[ 'bsa_edit' ][ 0 ][ 'bsa_state' ])){
											$selected = "selected='selected'";
										} ?> <option <?php echo $selected?> class="option" value="<?php echo $key.'_US'?>"><?php echo $value?></option> <?php }
										} ?> <option style="font-size:16px;background-color:#00478f;color:#FFF;" value="Sold Out">Canada</option> <?php 
										foreach($medical->cstates as $key=>$value){ 
										if($value != '*'){ 
										$selected = ""; 
										if(trim($key) == trim(@$arrValue[ 'bsa_edit' ][ 0 ][ 'bsa_state' ])){ 
											$selected = "selected='selected'";
										}  ?>
																			<option <?php echo $selected?> class="option" value="<?php echo $key.'_CA'?>"><?php echo $value?></option>
										<?php 
										} 
										}
										?>
																		</select></td>
																</tr>
																<tr>
																	<td><label>Address Type <b>*</b></label>
									 <?php
									 $address_type = trim(@$arrValue[ 'bsa_edit' ][ 0 ][ 'bsa_address_type' ]);
									 $selected = "selected='selected'";
									 ?>
																		<select title="Select an Address Type" name="address_type" class="inqury_ipput validate[required]">
																			<option selected="" value="">Select an Address Type</option>
																			<option value="Educational" <?php if($address_type == 'Educational'){
										 echo $selected;
									 }?>>Educational
																			</option>
																			<option value="Residential" <?php if($address_type == 'Residential'){
										 echo $selected;
									 }?>>Residential
																			</option>
																			<option value="Commercial" <?php if($address_type == 'Commercial'){
										 echo $selected;
									 }?>>Commercial
																			</option>
																		</select></td>
																</tr>
																<tr>
																	<td><label>Special Shipping Directions</label>
																		<input type="text" name="ship_dir" value="<?php echo trim(@$arrValue[ 'bsa_edit' ][ 0 ][ 'bsa_ship_dir' ])?>" class="inqury_ipput"/></td>
																</tr>
																<tr>
									<?php
									
									$checked = "";
									
									if(isset($arrValue[ 'bsa_edit' ][ 0 ][ 'bsa_default' ]) && $arrValue[ 'bsa_edit' ][ 0 ][ 'bsa_default' ] == 1){
										
										$checked = "checked='checked'";
									}
									
									?>
																	<td><input type="checkbox" <?php echo $checked?> name="default" id="default" style="width:20px;float:left"/>
																		<label class="default_chk">Default</label></td>
																</tr>
																<tr>
																	<td><input type="submit" class="signin_btn submit_helper" value="Update Ship Address"></td>
																</tr>
															</table>
														</form>
													</div>
													
													<!--<div class="col-lg-4"> <br />
															<br />
															<table class="tbl">
																	<tr>
																			<td><h4 class="proposal">Address Accuracy</h4>
																					</p></td>
																	</tr>
																	<tr>
																			<td><p>Make sure you get your stuff! If the address is not entered correctly, your package may be returned as undeliverable. You would then have to place a new order. Save time and avoid frustration by entering the address information in the appropriate boxes and double-checking for types and other errors.</p></td>
																	</tr>
															</table>
															<br />
															<br />
													</div>-->
												</div>
											</div>
										</div>
										<div class="col-lg-12" id="tour_div_9"><strong style="width: 27%;" class="col-lg-3">
												<span class="step-header amz-stepped">2</span>Payment Method</strong>
						<?php if($payment_method != ''){?>
											<p id="loading_payment"><img src="<?php echo url(''); ?>images/loader.gif"/> Loading your payment information</p>
											<div id="selectpayment">
												<div class="col-lg-6"><?php echo $payment_method?><br/>
													<br/>
							
							<?php
							
							if(session()->get('msg_cop') != null && session()->get('msg_cop') != ''){
							
							?>
													<table>
														<tbody>
														<tr id="error_message" align="left" width="20%">
															<td width="120"><?php echo trim(session()->get('msg_cop'))?></td>
														</tr>
														</tbody>
													</table>
							<?php
								
							}
							
							?>
												</div>
												<p class="col-lg-3">
													<button class="amz_change" id="amzChangePayment">Change</button>
												</p>
											</div>
						<?php }
						else{ ?>
											<div class="col-lg-9" id="selectpayment"></div>
						<?php } ?>
										
										</div>
										<br>
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
						$sessionCart = json_decode(json_encode(session()->get('cart')), true);
						$sessionCart = (!empty($sessionCart)) ? $sessionCart : [];
						foreach(array_reverse($sessionCart) as $post){
						
						$product_bundle = 0;
						if($post[ 'product_bundle' ] != 0){
							$product_bundle = $post[ 'product_bundle' ];
						}
						
						if(isset($post[ 'configure_product' ]) and $post[ 'configure_product' ] != 0){
							$manufacturer = $post[ 'manufacturer' ];
							$uom = $post[ 'uom' ];
							
							$manuf_rec = mysql_fetch_array(mysql_query("SELECT cpa_option FROM config_product_option where cpo_id=".$manufacturer));
							
							$uom_rec = mysql_fetch_array(mysql_query("SELECT cpa_option FROM config_product_option where cpo_id=".$uom));
						}
						
						$product_id = (int) (trim($post[ 'product_id' ]));
						
						$unit_id = (int) (trim($post[ 'unit_id' ]));
						
						$product_quantity = (int) (trim($post[ 'product_quantity' ]));
						
						$sql = "select p.*, pm.product_image from product as p join product_image as pm on p.product_id= pm.product_id where p.product_id='".$product_id."'";
						
						
						
						$query = DB::select($sql);
						$refdir = json_decode(json_encode($query), true);
						$mfa = reset($refdir);
						
						
						
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
									$query_group = mysql_query($sql_group);
									$mfa_group = mysql_fetch_assoc($query_group);
									$group = trim(stripslashes($mfa_group[ 'bp_title' ]));
									$group_id = trim($mfa_group[ 'bp_id' ]);
									/*echo '<pre>'.print_r($value1,true).'</pre>';*/
									foreach($value1 as $value2){
										
										$exp = explode('|', $value2);
										$value2 = trim($exp[ 0 ]);
										$qty = trim($exp[ 1 ]);
										
										$sql_bundle = "select * from product where product_id in(".$value2.")";
										$query_bundle = mysql_query($sql_bundle);
										
										while($mfaBP = mysql_fetch_assoc($query_bundle)){
											
											# Get Group Title
											$sql_price = "select * from unit_product where product_id='".$mfaBP[ 'product_id' ]."'";
											$query_price = mysql_query($sql_price);
											$mfa_price = mysql_fetch_assoc($query_price);
											$price = trim($mfa_price[ 'product_price' ]);
											$sprice = trim($mfa_price[ 'product_sprice' ]);
											if(trim($sprice) != ''){
												
												$price = $sprice;
											}
											$bundle_unit_price += $price*$qty;
											
											$str .= '<label class="qnty">'.$qty.'</label>'.' x <label class="product">'.$mfaBP[ 'product_title' ].'</label> [ <label class="price">$'.trim($price).'</label> ] '.'<br>';
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
						} ?>
                        
											<div style="float:none; clear:both;">
												<div id="div_custom_img_<?=$mfa[ 'product_id' ]; ?>" style="float:left; width:80px !important;">
													<a href="{{ url('product-detail/') }}<?php echo '/'.$product_id; ?>"><img src="<?php echo url('/').'/uploads/product/'.trim($mfa[ 'product_image' ])?>" width="62" height="60"></a>
												</div>
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
									 echo $bundle_unit_price;
								 }else{
									 echo trim($price);
								 }?>
                  </span> </strong> <br>
													<strong>Quantity: </strong> <span style="" id="qty_change_<?=$mfa[ 'product_id' ]; ?>"><?php echo (int) ($product_quantity); ?></span>
													<input style="display:none;" class="qty_place_ordr" type="text" onkeyup="showHideUpdate(<?php echo $mfa[ 'product_id' ]; ?>)" name="qty_place_order_<?php echo $mfa[ 'product_id' ]; ?>" id="qty_place_order_<?=$mfa[ 'product_id' ]; ?>" value="<?php echo (int) ($product_quantity); ?>">
													<span class="updatqty" id="updateQty_<?=$mfa[ 'product_id' ]; ?>" style="display:none" onclick="updateQty(<?=$mfa[ 'product_id' ]; ?>);">Update</span> <span id="del_link_<?=$mfa[ 'product_id' ]; ?>" style=" display:none;color:#0088CC;cursor: pointer;" onclick="delete_item('<?=$mfa[ 'product_id' ]; ?>')" title="Remove Item" class="del_button_new btn-remove">| Delete</span>
													<p class="f-left1"><a onclick="change_item(<?=$mfa[ 'product_id' ]; ?>);" id="change_link_<?=$mfa[ 'product_id' ]; ?>" style="display: block;">Change</a></p>
												</div>
											</div>
						
						<?php
							
						}
						
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
										<?php /*?><p style="font-size: 16px; line-height: 25px; margin-top: 10px;"><b style="color: brown;">Order Total: $<span id="order_total_bottom"><?php echo number_format(trim($total_after_tax), 2)?></span></b></p><?php */?>
                                        <p style="font-size: 16px; line-height: 25px; margin-top: 10px;"><b style="color: brown;">Order Total: $<span id="order_total_bottom"><?php echo $total_after_tax; ?></span></b></p>
										<p style="font-size: 9px;">By placing your order, you agree to medicalshipment.com's <a href="<?php echo url(''); ?>index.php?controller=content&function=index&slug=term-conditions">privacy notice</a> and <a href="<?php echo url(''); ?>index.php?controller=content&function=index&slug=privacy-policy">conditions of use</a>.</p>
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
										<p style="margin: 0 15px; border-bottom: 1px solid #CCC; padding: 5px 0 10px 0; font-size: 9px;text-align: center;">By placing your order, you agree to medicalshipment.com's <a href="<?php echo url(''); ?>index.php?controller=content&function=index&slug=term-conditions">privacy notice</a> and <a href="<?php echo url(''); ?>index.php?controller=content&function=index&slug=privacy-policy">conditions of use</a>.</p>
										<h1 class="shiping_haad" style="font-size: 13px !important; color: #0d0d0d;font-family: Arial,sans-serif;">Order Summary</h1>
										<br style="clear:both;">
										<div style="float:left; width:190px; height:auto;">
											<table style="width:400px; float:left;">
												<tbody>
												<tr align="left" width="20%" style="margin-top:10px !important;">
													<td width="150"> Items (<span id="cart_quantity_updated"><?php echo trim($total_item)?></span>):</td>
													<td colspan="2">&nbsp;</td>
													<td width="120" style="position:absolute;right:15px;"><span style="float:right;"> $<span id="total_amount"><?php echo trim($cart_total)?></span></span></td>
												</tr>
												<tr align="left" width="20%">
													<td width="150"> Shipping &amp; handling:</td>
													<td colspan="2">&nbsp;</td>
													<td width="120" style="position:absolute;right:15px;"><span style="float:right;"> $<span id="tax_amount"><?php echo $delivery_charges; ?></span></span></td>
												</tr>
												<tr class="stnrad_table" style="float: left; margin-bottom: 10px; margin-top: 10px; width: 241px;"></tr>
												<!--<tr class="line" width="51%">
	
														<td colspan="2">&nbsp;</td>
	
												</tr>-->
												
												<tr align="left" width="20%">
													<td width="150"> Total before Tax:</td>
													<td colspan="2">&nbsp;</td>
													<td width="120" style="position:absolute;right:15px;"><span style="float:right;"> $<span id="total_befor_tax"><?php echo trim($total_before_tax); ?></span></span></td>
												</tr>
												<tr align="left" width="20%">
													<td width="170"> Estimated Tax to be calculated:</td>
													<td colspan="2">&nbsp;</td>
													<td width="120" style="position:absolute;right:15px;"><span style="float:right;">$<span id="tax_ammnt_new"><?php echo trim($tax)?></span></span></td>
												</tr>
						<?php
						
						if($cop_type != '' || session()->get('reference') == 'flyer'){
						
						
						?>
												<tr id="order_discount_coupon" align="left" width="20%">
													<td width="150">Discount:</td>
													<td colspan="2">&nbsp;</td>
													<td width="120" style="position:absolute;right:15px;"><span style="float:right"> - $<?php echo $discount_amount; ?></span></td>
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
													<td id="order_total_clr" class="order_total_clr" width="120" style="position:absolute;right:15px; font-size: 16px; font-weight: bold;"><span style="float:right; color: brown;"> $<span id="grand_total_amount_after_tax" style="color: brown;"><?php echo trim($total_after_tax)?></span></span><br></td>
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
					</div>
				</div>
			</div>
		</div>
		
		<div class="clearz"></div>
		<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
		<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
		<script>
			jQuery(document).ready(function () {
					// binds form submission and fields to the validation engine
					jQuery("#myform").validationEngine();
					jQuery("#myform1").validationEngine();
			});
			jQuery.noConflict();
		</script>
@endsection()