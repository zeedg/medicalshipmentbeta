<?php 
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;



set_time_limit(0);

//$delivery_method=trim(stripslashes($_SESSION['delivery_method']));



//$delivery_charges=trim(stripslashes($_SESSION['delivery_charges']));



$delivery_method='';

$delivery_charges=0.00;



$ship_pref='';

if(session()->get('ship_pref') != null){
	$ship_pref=trim(stripslashes($_SESSION['ship_pref']));

}



$ship_to_this=trim(session()->get('ship_to_this'));



$payment_method=trim(session()->get('payment_method'));


$cart_total = Helper::instance()->getCartTotal();

$total_item=0;



# Get Total Quantity/Item + Cart Total

$sessionCart = json_decode(json_encode(session()->get('cart')), true);
$sessionCart = (!empty($sessionCart)) ? $sessionCart : [];
foreach(array_reverse($sessionCart) as $post){
	$total_item+=$post['product_quantity'];
}

session()->put('msg_cop', '');

if(isset($_POST['coupon_code'])){

	$cc=trim($_POST['coupon_code']);

	$sql = "select c.*, ct.* from coupon c inner join coupon_type ct on c.ct_id=ct.ct_id where c.cop_code='".$cc."' and c.cop_status=1";
	$query = DB::select($sql);
	
	$rows=count($query);

	if($rows > 0){
		
		$mfaC = @reset(json_decode(json_encode($query), true));
		
		session()->put('coupon_type', trim($mfaC['ct_id']));
		session()->put('coupon_code', trim($mfaC['cop_code']));
		session()->put('coupon_count', intval($mfaC['cop_count']));

		if($mfaC['ct_id']==1){
			
			session()->put('coupon_symbol', '=');
			session()->put('coupon_value', 0);
			
		}



		if($mfaC['ct_id']==2){

			session()->put('coupon_symbol', '%');
			session()->put('coupon_value', trim($mfaC['cop_off']));

		}



		if($mfaC['ct_id']==3){
			
			session()->put('coupon_symbol', '$');
			session()->put('coupon_value', trim($mfaC['cop_amount']));	

		}

		session()->put('msg_cop', '<span class="yes_cop">Coupon code accepted.</span>');

	} else {
		
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

$discount_amount=0;

$cop_type='';

if(session()->get('coupon_type') != null && session()->get('coupon_type') == 1){
	$cop_type='Free Shipping';
	$discount_amount=$delivery_charges;
}


if(session()->get('coupon_type') != null && session()->get('coupon_type') == 2){
	$cop_type='% Off';
	$amount=trim(session()->get('coupon_value'))/100*$cart_total;
	$discount_amount=$amount;
}



if(session()->get('coupon_type') != null && session()->get('coupon_type') == 3){

	$cop_type='$ Amount';
	$amount=trim(session()->get('coupon_value'));
	$discount_amount=$amount;

}

session()->put('discount_amount', $discount_amount);

session()->put('ctype', $cop_type);

$tax=0;

$total_before_tax=$cart_total + $delivery_charges;

$total_after_tax=$cart_total + $delivery_charges + $tax - $discount_amount;

?>

<script type="text/javascript" src="{{ url('/') }}/frontend/js/jquery.validate.min.js"></script>

<script type="text/javascript" src="{{ url('/') }}/frontend/js/jquery.validate.creditcardtypes.js"></script>

<script>







	$(document).ready(function(){



	$("#add_billing").click(function(){		

		$("#change_billing_popup").hide();

	})

	

	$("#add_bill_address").click(function(){

		var fname = $("#fname").val();

		var lname = $("#lname").val();

		var phone = $("#phone").val();

		var address = $("#address").val();

		var zip = $("#zip").val();

		var city = $("#city").val();

		var states = $("#states").val();

		var address_type = $("#address_type").val();

		var ship_dir = $("#ship_dir").val();

		if(fname != '' && lname !='' && address != '' && zip != '' && city != '' && states != ''){

		$.post("<?php echo 'SITE_PATH' ?>add_billing_address.php", { fname: fname, lname: lname, phone: phone, address: address, zip: zip, city: city, states: states, address_type: address_type, ship_dir: ship_dir},function(response){



			window.location = 'index.php?controller=cart&function=review';

        });

		}

		return false;

	})



//	$("#checkout_form").validate();



});



function showHidebilling_div_copy()

{

	$("#change_billing_popup").toggle();

}



function saveBillingAddress(addr_id)

{

	$("#changed_billing_address").html(addr_id);

//	alert(addr_id);

}

function change_item(id)

{

	$('#change_link_'+id).hide();

	$('#del_link_'+id).show();

	$('#updateQty_'+id).show();

	$('#qty_place_order_'+id).show();

	$('#qty_change_'+id).hide();

}



function updateQty(item){

	element='qty_place_order_'+ item;

	save_update='updateQty_'+ item;

	qty=document.getElementById(element).value;

	var price = $('#price_update_input_'+item).val();

	$('#del_link_'+item).hide;

	var final_price = '$'+parseFloat(price) * parseInt(qty);

	var final_price_float=parseFloat(final_price).toFixed(2);

	//document.getElementById('mask').style.display='block';

	//document.getElementById('magalter-ajaxcart-overlay-loader-new').style.display='block';

	$('#del_link_'+item).hide();

	var totalbefortax = $("#total_befor_tax");

	var tax_amount = parseFloat($("#tax_amount").html()).toFixed(2);

	var tax_ammnt_new = parseFloat($("#tax_ammnt_new")).toFixed(2);

//	alert("final_price = "+item+'_'+tax_amount);

	$.post("index.php?controller=cart&function=ajax_update", {

		item: item,

		qty: qty,

		tax_amount: tax_amount,

		tax_ammnt_new: tax_ammnt_new,

		action: 'place order qty update',

		

	}, function(response, status){

	//	alert(response);

		if(status=='success'){

			var res_cart=response.split('C_Q');

			var split_val=res_cart[0];

			var total_amount=res_cart[1];

			var shipping_tax=res_cart[2];

			var total_amount_int=parseFloat(total_amount);

			var shippint_tax_int=parseFloat(shipping_tax);

			var total_befor_tax=res_cart[1];

			var total_amount_after_tax_int=res_cart[4];

			var item_price = res_cart[3];

		$('#price_update_'+ item).html(item_price);

		$('#qty_change_'+item).html(qty);

		$('#updateQty_'+ item).hide();

		$('#cart_quantity_updated').html(split_val);

		$('#total_amount').html(total_amount);

		$('#tax_amount').html(shipping_tax).toFixed(2);;

		$('#total_befor_tax').html(total_befor_tax);

		$('#grand_total_amount_after_tax').html(total_amount_after_tax_int);

		$('#order_total_bottom').html(total_amount_after_tax_int);

		$('#qty_place_order_'+item).hide();

		$('#qty_change_'+item).show();

		$('#change_link_'+item).show();

		document.getElementById('mask').style.display='none';

		document.getElementById('magalter-ajaxcart-overlay-loader-new').style.display='none';

		}

		

	});

	return false;

}





function showHideUpdate(id){

	jQuery('#updateQty_'+ id).css({ 'color': '#0088CC'});

		jQuery('#updateQty_'+ id).html('Update');	

	jQuery('#updateQty_'+ id).show();

}



function delete_item(id)

{

	var hrf = "index.php?controller=cart&function=ajax_remove";	

	var _total_amount = document.getElementById('total_amount').innerHTML;

	_total_amount = _total_amount.replace(",",""); 



	var _tax_amount = document.getElementById('tax_amount').innerHTML;

	_tax_amount = _tax_amount.replace(",",""); 



	var _price_update = document.getElementById('price_update_'+id).innerHTML;

	_price_update = _price_update.replace(",",""); 



	var tax_ammnt_new = document.getElementById('tax_ammnt_new').innerHTML;

	tax_ammnt_new = tax_ammnt_new.replace(",",""); 



	var _qty = document.getElementById('qty_change_'+id).innerHTML;

	var _qty_change = document.getElementById('cart_quantity_updated').innerHTML;

	



//	alert(_total_amount+'-'+_price_update);



	_ttl_amount = parseFloat(_total_amount) - parseFloat(_price_update);

	_grand_ttl_amount = parseFloat(_ttl_amount) + parseFloat(_tax_amount);

	_grand_ttl_amount_new = parseFloat(_grand_ttl_amount) + parseFloat(tax_ammnt_new);

	_ttl_qty =  parseInt(_qty_change) - parseInt(_qty);



	

							



	jQuery.post(hrf, {

		id: id,

		}, function(response){

			

			var element = document.getElementById('div_custom_'+id);

			element.parentNode.removeChild(element);



			var element2 = document.getElementById('div_custom_img_'+id);

			element2.parentNode.removeChild(element2);



			document.getElementById('total_amount').innerHTML = _ttl_amount.toFixed(2);

			document.getElementById('total_befor_tax').innerHTML = _grand_ttl_amount.toFixed(2);

			document.getElementById('grand_total_amount_after_tax').innerHTML = _grand_ttl_amount_new.toFixed(2);

			document.getElementById('cart_quantity_updated').innerHTML = _ttl_qty;



	});



	

}

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<script>

		$(function() {

			

			// OnKeyDown Function

			$("#zip").keyup(function() {

				var zip_in = $(this);

				

				if ((zip_in.val().length == 5) ) 

				{

					

					$.ajax({

						url: "https://api.zippopotam.us/us/" + zip_in.val(),

						cache: false,

						dataType: "json",

						type: "GET",

					  success: function(result, success) {

							cabb=JSON.stringify(result['country abbreviation']);

							cabb=cabb.replace (/"/g,'');

							

							// US Zip Code Records Officially Map to only 1 Primary Location

							places = result['places'][0];

							sabb=places['state abbreviation'];

							matchString=sabb + "_" + cabb;

							$("#city").val(places['place name']);

							var select = document.getElementById('states');

    						var len = select.options.length;

							for(var i=0;i<len;i++){

								

							  	if(select.options[i].value==matchString){

									select.selectedIndex=i;

								}

								

					  		}

							/*zip_box.addClass('success').removeClass('error');*/

						},

						error: function(result, success) {

							/*zip_box.removeClass('success').addClass('error');*/

						}

					});

				}

	});



		});

	

	</script>

<style type="text/css">

a:hover {

	text-decoration: underline;

	cursor: pointer;

}

.content {

	width: 80%;

	height: 800px;

	margin: 0 auto;

}

.continput {

	float: none;

	margin: 0;

	padding: 0;

	padding-left: 3px

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

	height: 270px;

}

.right_bigportion {

	float: sda;

	width: 30%;

}

.steps {

	float: right;

	margin-top: 10px;

	margin-bottom: 10px;

}

.no_cop {

	color: #F00;

}

.yes_cop {

	color: #0F0;

}

.qty_place_ordr {

	width: 35px;

	height: 25px;

	margin-top: 5px;

	text-align: center;

	padding: 0;

}

.updatqty {

	color: rgb(0, 136, 204);

	cursor: pointer;

}

.updatqty:hover, .del_button_new:hover {

	text-decoration: underline;

}

.qty_place_ordr:focus, #coupon_code:focus {

	background-color: #fff !important;

	background-image: none !important;

	border: 2px solid rgb(48, 129, 190) !important;

	box-shadow: 0 0 10px #1e7ec8 !important;

	height: 32px !important;

}

#change_billing_popup {

	background: none repeat scroll 0 0 #F7F7F7;

	border: 1px solid #CCCCCC;

	border-radius: 5px;

	box-shadow: 4px 5px 11px #999999;

	opacity: 1;

	padding: 10px;

	position: fixed;

	width: 928px;

	top: 6%;

	left: 19%;

	margin: 56px 0 0 -18px;

	z-index: 10000000;

}

.color_stip {

	background-color: #009900;

	border-radius: 5px 5px 0 0;

	float: left;

	height: 37px;

	margin-left: -11px;

	margin-top: -10px;

	padding-left: 3px;

	width: 928px;

}

#close_button {

	color: #FFFFFF;

	cursor: pointer;

	float: right;

	font-weight: bold;

	margin-right: 8px;

	margin-top: 8px;

}

.f-left1 {

	width: 65%;

	float: right;

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

.inqury_ipput:focus {

	background-color: #fff !important;

	background-image: none !important;

	border: 2px solid rgb(48, 129, 190) !important;

	box-shadow: 0 0 10px #1e7ec8 !important;

	height: 36px !important;

}

#save_order, #save_order1 {

	display: none;

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

.col-lg-3 {

	width: 50% !important;

}

.col-lg-6 {

	float: left;

}

#slide_address, #selectpayment {

	clear: both;

	margin-left: 9%

}

.left_bigportion2 .col-lg-6 {

	width: 95% !important;

}

.stanrd_shipingsmall {

	width: 100% !important;

}

#btnOpenDialog {

	width: 100% !important;

}

.inqury_ipput, .inqury_ipput:hover {

	background-size: 100% 100% !important;

	width: 100% !important;

}

}

@media print {

.content {

	width: 100%;

}

.left_allportion {

	width: 60%;

}

#discount-coupon-form {

	display: none;

}

.col-lg-12, #ship_panel {

	width: 100% !important;

}

.col-lg-6 {

	width: 100% !important;

}

.ship_speed {

	float: left !important;

	margin-left: 0 !important;

}

.amz_change {

	float: right;

}

}

</style>



<div class="container" id="checkout_body">

  <div class="row main-contant">

    <div class="container contant-con">

      <div class="content">

        <div class="bodyinner">

          <?php 

		if(session()->get('all_error') != null){
			foreach(session()->get('all_error') as $key=>$value){
				echo "<span style='color:red'>$key</span>: ".trim($value).'<br>';	
			}
			session()->pull('all_error');
		  }



		  ?>

          <div class="steps"><img src="{{ url('/') }}/uploads/cart_imags4.jpg"  /></div>

          <h3><strong>Review Your Order <?php echo session()->get('reference')?></strong></h3>

          <br />

          <!--<p>By placing your order, you agree to medicalshipment.com's privacy notice and conditions of use.</p>-->

          <div class="clear:both"></div>

          <br />

          <br />

          <div class="col-lg-12">

            <div class="col-lg-8 left_allportion">

              <div class="left_bigportion">

                <div style="float:left;border-bottom: 1px solid #CCC;padding-bottom: 10px;margin-bottom: 10px;" class="col-lg-12" id="ship_panel">

                  <div id="tour_div_7" class="introjs-showElement introjs-relativePosition"> <span class="step-header amz-stepped">1</span> <strong style="font-size:13px;" class="col-lg-3">Shipping Address</strong>

                    <p id="loading_address"><img src="{{ url('/') }}/uploads/loader.gif" /> Loading your address information</p>

                    <?php


				  if(isset($arrValue['bsa']) && !empty($arrValue['bsa'])){



						foreach ($arrValue['bsa'] as $bsa){

							

							$c_name = $bsa['bsa_fname'].' '.$bsa['bsa_lname'];

							$c_address = $bsa['bsa_address'];

							$c_city = $bsa['bsa_city'];

							$c_zip = $bsa['bsa_zip'];

							$c_state = $bsa['bsa_state'];

							$c_country = $bsa['bsa_country'];

							$c_phone = $bsa['bsa_phone'];

							if($bsa['bsa_phone']=='Residential')

							{

								$isResidential = 'true';

							}

							else{

								$isResidential = 'false';

							}


							$medical = Helper::instance();
							foreach($medical->states as $key=>$value){



								if($key == $bsa['bsa_state'])



								{



									$state = $value;



								}



							}



				  ?>

                    <div id="slide_address"> <span class="col-lg-6"><?php echo $bsa['bsa_fname'].' '.$bsa['bsa_lname'] ?><br>

                      <?php echo $bsa['bsa_address']; ?><br>

                      <?php echo $bsa['bsa_city'].', '.$state.' '.$bsa['bsa_zip']; ?><br>

                      <?php if($bsa['bsa_country'] != 'US'){ echo $bsa['bsa_country'].'<br>'; }?>

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

                <div class="col-lg-12" id="tour_div_9"> <strong style="font-size:13px; width: 28.5%;" class="col-lg-3"> <span class="step-header amz-stepped">2</span>Payment Method</strong>

                  <p id="loading_payment"><img src="{{ url('/') }}/uploads/loader.gif" /> Loading your payment information</p>

                  <div id="selectpayment">

                    <div class="col-lg-6"><strong><?php echo $payment_method?></strong><br />

                      <br />

                      <strong style="font-size:13px;">Billing Address</strong>: <br />

                      <span id="changed_billing_address">

                      <?php

						if(session()->get('billing_address') != null){

							echo session()->get('billing_address');

						}

						else

						{

							echo 'Same as shipping address';

						}

				  ?>

                      </span> <span onclick="showHidebilling_div_copy()" id="change_billing_add" class="change_billing_add"><a href="#">Change</a></span><br />

                      <br />

                      <form id="discount-coupon-form" action="" method="post">

                        <label for="coupon_code"> Enter your coupon code if you have.</label>

                        <input id="coupon_code" name="coupon_code" value="<?php echo trim(@session()->get('coupon_code'))?>" required="required">

                        <button class="amz_change" style="height: 32px !important; margin-left: 0px;width: 80px;margin-top: 3px;" type="submit" value="Apply Coupon"><span>Apply</span></button>

                      </form>

                      <?php 

					if(session()->get('coupon_code') != null && session()->get('coupon_code') != ''){


				  ?>

                      <table>

                        <tbody>

                          <tr id="error_message" align="left" width="20%">

                            <td width="120"><?php echo trim(session()->get('coupon_code'))?></td>

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

                </div>

                <br>

              </div>

              

              <!--left_bigportion--><br>

              <br>

              <div class="left_bigportion2"> <span class="step-header amz-stepped active_step">3</span>

                <h4 class="active_step" style="border-bottom: 1px solid #CCC;"><span>Review Items &amp; Shipping</span> 

                  <!--<span id="delivery_date" style="float: right;">Estimated delivery: <?php echo date('M. d, Y', strtotime(date('Y-m-d'). ' + 6 days')); ?></span>--> 

                </h4>

                <div class="col-lg-6">

                  <?php         

			$a="";

			$str="";
			
			
			$sessionCart = json_decode(json_encode(session()->get('cart')), true);
			$sessionCart = (!empty($sessionCart)) ? $sessionCart : [];
			foreach(array_reverse($sessionCart) as $post){
	
			$product_bundle=0;

			if($post['product_bundle']!=0){

				$product_bundle=$post['product_bundle'];

			}

			

			if(isset($post['configure_product']) and $post['configure_product']!=0){

				$manufacturer = $post['manufacturer'];

				$uom = $post['uom'];

				$sql = "SELECT cpa_option FROM config_product_option where cpo_id=".$manufacturer;
				$query = DB::select($sql);
				$manuf_rec = json_decode(json_encode($query), true);
				
				$sql_uom = "SELECT cpa_option FROM config_product_option where cpo_id=".$uom;
				$query_uom = DB::select($sql_uom);
				$uom_rec = json_decode(json_encode($query_uom), true);
				
			}

			$product_id=intval(trim($post['product_id']));
			$unit_id=intval(trim($post['unit_id']));
			$product_quantity=intval(trim($post['product_quantity']));

			$sql = "select p.*, pm.product_image from product as p join product_image as pm on p.product_id= pm.product_id where p.product_id='".$product_id."'";
			$query = DB::select($sql);
			$mfa = @reset(json_decode(json_encode($query), true));

			# Unit Price
			$sql_unit = "select * from unit u inner join unit_product up on u.unit_id=up.unit_id where up.product_id='".intval(trim($post['product_id']))."' and up.unit_id='".intval(trim($post['unit_id']))."'";
			$query_unit = DB::select($sql_unit);
			$mfa_unit = @reset(json_decode(json_encode($query_unit), true));

			$price=0;
			$is_Special=0;
			$is_Special_Text='';

			if(trim($mfa_unit['product_sprice'])!=2){
				$price=trim($mfa_unit['product_price']);
			} else {
				$price=trim($mfa_unit['product_sprice']);
				$is_Special=1;
				$is_Special_Text=" <div class='special_text'>S</div>";
			}

			# Bundle Product
			$bundle_unit_price=0;
			
			if($product_bundle!=0){
				
				$bp_array=array();

				foreach($post['product_bundle'] as $key=>$val){

					$group_id=$key;
					$qty=0;
					$k='';

					foreach($val as $key1=>$val1){
						if(is_array($val1)){
							foreach($val1 as $product_bundle){
								$k.=$product_bundle.',';
							}
						} else {
							$qty=$val1;
						}

						if($qty!=0){

							$bp_array[]=array( $group_id=>array(rtrim($k,',').'|'.$qty));

						}

					}

				}

								

					

					foreach($bp_array as $key=>$value){

						foreach($value as $key1=>$value1){

							# Get Group Title
							$sql_group = "select * from bundle_product where bp_id='".$key1."'";
							$query_group = DB::select($sql_group);
							$mfa_group = @reset(json_decode(json_encode($query_group), true));

							$group=trim($mfa_group['bp_title']);

							$group_id=trim($mfa_group['bp_id']);

							/*echo '<pre>'.print_r($value1,true).'</pre>';*/

							foreach($value1 as $value2){

								

								$exp=explode('|', $value2);

								$value2=trim($exp[0]);

								$qty=trim($exp[1]);

								
								$sql_bundle = "select * from product where product_id in(".$value2.")";
								$query_bundle2 = DB::select($sql_bundle);
								$query_bundle = @reset(json_decode(json_encode($query_bundle2), true));
								

								foreach($query_bundle as $mfaBP){
									

									# Get Group Title
									$sql_price = "select * from unit_product where product_id='".$mfaBP['product_id']."'";
									$query_price = DB::select($sql_price);
									$mfa_price = @reset(json_decode(json_encode($query_price), true));

									$price=trim($mfa_price['product_price']);

									$sprice=trim($mfa_price['product_sprice']);

									if(trim($sprice)!=''){

										

										$price=$sprice;

									}									

									$bundle_unit_price+=$price*$qty;

									

									$str.='<label class="qnty">'.$qty.'</label>'.' x <label class="product">'.$mfaBP['product_title'].'</label> [ <label class="price">$'.number_format(trim($price),2).'</label> ] '.'<br>';

									

								}

								

									if($str!=''){

										$str='<br><label class="group">'.$group.'</label>'.'<br><br>'.$str;

										$a.=$str;

										$str='';

									}

							

							}

						

						}

					}

								

							/*echo '<pre>'.print_r($bp_array,true).'</pre>';exit;*/	

			}



						



			?>

                  <div style="float:none; clear:both;">

                    <div id="div_custom_img_<?=@$mfa['product_id']; ?>" style="float:left; width:80px !important;"><a href="<?php echo 'index.php?controller=product&function=index&id='.$product_id?>"><img src="image.php?width=100&height=100&image=<?php echo 'admin/'.trim(@$mfa['product_image'])?>" width="62" height="60"></a></div>

                    <div id="div_custom_<?=$mfa['product_id']; ?>" style="float:left; width:71%;  margin-bottom: 15px; line-height: 20px;">

                      <input type="hidden" id="price_update_input_<?=$mfa['product_id']; ?>" value="<?=$price; ?>">

                      <strong> <?php echo stripslashes($mfa['product_title'])?>

                      <?php	if(isset($manufacturer) and $manufacturer != ''){

							echo '<p>Manufacturer: '.$manuf_rec["cpa_option"].'</p>';

						}

						

						if(isset($uom) and $uom != ''){

							echo '<p>UOM: '.$uom_rec["cpa_option"].'</p>';

						}

				?>

                      <b style="text-decoration:underline">

                      <?php 

                if($product_bundle!=0){

                    echo "<br>".trim($a);

                }

                ?>

                      </b> <br>

                      #<?php echo stripslashes($mfa['product_item_no'])?></strong><br>

                      <strong style="color:#434343;"> $<span id="price_update_<?=$mfa['product_id']; ?>">

                      <?php

				if($bundle_unit_price!=0){

					echo number_format($bundle_unit_price,2);

				}

				else{

					echo number_format(trim($price), 2);	

				}?>

                      </span> </strong> <br>

                      <strong>Quantity: </strong> <span style="" id="qty_change_<?=$mfa['product_id']; ?>"><?php echo intval($product_quantity); ?></span>

                      <input style="display:none;" class="qty_place_ordr" type="text" onkeyup="showHideUpdate(<?=$mfa['product_id']; ?>)" name="qty_place_order_<?=$mfa['product_id']; ?>" id="qty_place_order_<?=$mfa['product_id']; ?>" value="<?php echo intval($product_quantity); ?>">

                      <span class="updatqty" id="updateQty_<?=$mfa['product_id']; ?>" style="display:none" onclick="updateQty(<?=$mfa['product_id']; ?>);">Update</span> <span id="del_link_<?=$mfa['product_id']; ?>" style=" display:none;color:#0088CC;cursor: pointer;" onclick="delete_item('<?=$mfa['product_id']; ?>')" title="Remove Item" class="del_button_new btn-remove">| Delete</span>

                      <p class="f-left1"><a onclick="change_item(<?=$mfa['product_id']; ?>);" id="change_link_<?=$mfa['product_id']; ?>" style="display: block;">Change</a></p>

                    </div>

                  </div>

                  <?php 



			} ?>

                </div>

                <div class="col-lg-6" style="width: 49%;">

                  <div class="ship_speed" style="float:right; margin-right: 0px; width:340px;"> <strong style="font-size:13px;">Choose a shipping speed:</strong><br>

                    <br>

                    <td colspan="2"><?php          	


						if(session()->get('reference') != null && session()->get('reference') == 'flyer'){
							$discount_amount=($cart_total/100)*10;

							$total_after_tax=$total_after_tax - $discount_amount;

						}

	//	require("upsRate.php");

		

		//require("oscoSocketInterface.php");
?>
		@include('frontwebsite.oscoSocketInterface')
<?php
		
		$osco = $arrValue['osco'][0];





		/*************************************



		Get your own credentials from ups.com



		*************************************/



		$ups_accessnumber = "5CE8D2BDB60C7525";



		$ups_username = "pgeegan";



		$ups_password = "Hovercraft1";



		$ups_shippernumber = "R8W175";

		// just doing domestic for demonstration purposes

		/*$services = array(



						"Ground"=>"03",



						"2nd Day Air"=>"02", 



						"Next Day Air Saver"=>"13",



						"Next Day Air"=>"01",



						"Next Day Air (early AM)"=>"14"



					);



		



		$myRate = new upsRate;



		$myRate->setCredentials($ups_accessnumber, $ups_username, $ups_password, $ups_shippernumber);*/

		

		$product_xml = '';


		$sessionCart = json_decode(json_encode(session()->get('cart')), true);
		$sessionCart = (!empty($sessionCart)) ? $sessionCart : [];
		foreach(array_reverse($sessionCart) as $post){

				

				$product_id=intval(trim($post['product_id']));

				
				$sql = "select p.*, up.* from product p join unit_product up on p.product_id=up.product_id where p.product_id='".$product_id."'";
				$query = DB::select($sql);
				$mfa = @reset(json_decode(json_encode($query), true));

				if($mfa['product_length'] > 0){
					$length = trim($mfa['product_length']);
				}
				else{
					$length = 0.00;
				}	

				if($mfa['product_width'] > 0){
					$width = trim($mfa['product_width']);
				}
				else{
					$width = 0.00;
				}	

				if($mfa['product_height'] > 0){
					$height= trim($mfa['product_height']);
				}
				else{
					$height = 0.00;
				}	
				
				if($mfa['product_weight'] > 0){
					$weight = trim($mfa['product_weight']);
				}
				else{
					$weight = 0.00;
				}

				if($mfa['product_sprice'] > 0){
					$price = trim($mfa['product_sprice']);
				}
				else{
					$price = trim($mfa['product_price']);
				}
				
				$product_uom = substr($mfa['product_item_no'],6);

				if($product_uom == '')
				{
					$product_uom = 'EA';
				}				

				$rule = $mfa['product_business_rule'];				

				if($mfa['product_dropship'] == 0)
				{					
					
					if($mfa['product_bundle'] == 1)
					{
						$bundle = "<BUNDLE_ONLY>1</BUNDLE_ONLY>";
						//$rule   = $mfa['product_mix_class_id'];
						
						$rule   = '5';
					}
					elseif($rule == 8)
					{
						$bundle = "<BUNDLE_ONLY>1</BUNDLE_ONLY>";
					}
					else
					{
						$bundle = '';
					}

					$product_xml.='<SKU>
					  <SKU_ID>'.$mfa["product_item_no"].'</SKU_ID>
					  <QTY>'.$post["product_quantity"].'</QTY>
					  <LENGTH>'.$length.'</LENGTH>
					  <WIDTH>'.$width.'</WIDTH>
					  <HEIGHT>'.$height.'</HEIGHT>
					  <WEIGHT>'.$weight.'</WEIGHT>					  
					  '.$bundle.'
					  <MIX_CLASS_OPTIONS>
						<MIX_CLASS_ID>'.$rule.'</MIX_CLASS_ID>
					  </MIX_CLASS_OPTIONS>
					</SKU>';					    

				}
			}
		
		//echo $product_xml; exit;	

	$xml_data =  '<OSCO_DATA>
				  <OSCOSecurity>
					<Username>'.$osco["user_name"].'</Username>
					<Password>'.$osco["password"].'</Password>
				  </OSCOSecurity>
				  <ORDER>
					<ORDER_ID>test_order_1</ORDER_ID>
					<MAX_CUBE_UTIL>100</MAX_CUBE_UTIL>
				  </ORDER>
				  <UPS>
					<AccessLicenseNumber>'.$osco["access_license_number"].'</AccessLicenseNumber>
					<Username>'.$osco["user_name"].'</Username>
					<Password>'.$osco["password"].'</Password>
					<ShipperNumber>'.$osco["shipper_number"].'</ShipperNumber>
					<GetNegotiatedRate>True</GetNegotiatedRate>
					<ShipmentOptions>
					  <ServiceCode>ALL</ServiceCode>
					  <UOM>LBS</UOM>
					  <CodCode/>
					  <CodCurrency/>
					  <CodAmount/>
					  <DeliveryConfirmationType/>
					  <SaturdayDelivery>False</SaturdayDelivery>
					</ShipmentOptions>
					<ShipperAddress>
					  <AddressLine1>8060 Saint Louis Avenue</AddressLine1>
					  <AddressLine2/>
					  <AddressLine3/>
					  <City>Skokie</City>
					  <State>IL</State>
					  <Zip>60076</Zip>
					  <Country>US</Country>
					</ShipperAddress>
					<ShipFromAddress>
					  <AddressLine1>8060 Saint Louis Avenue</AddressLine1>
					  <AddressLine2/>
					  <AddressLine3/>
					  <City>Skokie</City>
					  <State>IL</State>
					  <Zip>60076</Zip>
					  <Country>US</Country>
					</ShipFromAddress>
					<ShipToAddress>
					  <AddressLine1>'.$c_address.'</AddressLine1>
					  <AddressLine2/>
					  <AddressLine3/>
					  <City>'.$c_city.'</City>
					  <State>'.$c_state.'</State>
					  <Zip>'.$c_zip.'</Zip>
					  <Country>'.$c_country.'</Country>
					</ShipToAddress>
				  </UPS>
				  <SKUDATA>
					'.$product_xml.'
				  </SKUDATA>
				</OSCO_DATA>';					

			//	echo $xml_data; exit;			

			$xml_name = strtotime(date('Y-m-d H:i:s'));				

			$xmlosco=new SimpleXMLElement($xml_data);	

			$xmlosco->asXML("Ratelogix_xml/".$xml_name."_to_osco.xml");
			
			$oscoResultsMsg = getOSCOResults($xml_data);			

			$xmlobj=new SimpleXMLElement($oscoResultsMsg);			
			
			
			
			$array = json_decode(json_encode((array)$xmlobj), TRUE); 
            //echo '<pre>'.print_r($array).'</pre>'; exit;
			/*echo '<pre>'; print_r($array); exit;

			foreach ($array['UPSRate']['Service'] as $service)

			{

				echo $service['ServiceDescription'].' => '.$service['CarrierCharges'].'<br>';	

			}

			exit;*/



			$xmlobj->asXML("Ratelogix_xml/".$xml_name.".xml");

			session()->put('xml_name', $xml_name);
			
			if(isset($array['UPSRate']['ErrorCode']) && $array['UPSRate']['ErrorCode'] != ''){
				$status = $array['UPSRate']['ErrorCode'];
				//$status = $array['ERROR_CODE'];
			} else {
				$status = '';
			}

	//		if($status == 'ERROR')
			if(@$status && $status != '')

			{

			//	$_SESSION['order_error_message'] = $array['RateResponse']['RateResult']['sMessage'];

				echo "<li style='list-style: none; color:red;'><strong>You can't place your order right now. Please Save order and contact customer support.</strong></li>";

				?>

                      <style type="text/css">

					#place_order_btn1, #place_order_btn{ display: none;}

					#save_order, #save_order1{ display: block;}

				</style>

                      <?php 

			}

			else{

				

				echo '<ul>';

				

				foreach ($array['UPSRate']['Service'] as $ups)

				{

					$osco_rate = $ups['CarrierCharges'];

					$osco_markup = ($ups['CarrierCharges']*$osco['markup_value'])/100;

					$rate = round($osco_rate + $osco_markup,2);

					$method = 'UPS '.$ups['ServiceDescription'];

					if(session()->get('reference') != null && session()->get('reference') == 'flyer')
					{

						$rate = '0.00';

					}

					

					echo "<li style='list-style: none;'>"; ?>

                      <input type="radio" name="shipping_method" id="shipping_method" value="<?php echo $rate; ?>" onclick="add_shipping(<?php echo $rate; ?>, '<?php echo $method; ?>');" />

                      <?php echo "<label>".trim($method)." ($".$rate.")</label></li>";

				}

			}

			echo '<br><h4><b>Choose a shipping preference</b></h4><br>

					

					<li style="line-height: 20px; font-size: 12px;list-style: none;"><input type="radio" id="ship_pref1" name="ship_pref" value="Group my items into a few shipments as possible" required />

						Group my items into a few shipments as possible.</li>

					<li style="line-height: 20px; font-size: 12px;list-style: none;"><input type="radio" id="ship_pref2" name="ship_pref" value="I want my items faster. Ship them as they become available" required />

						I want my items faster. Ship them as they become available.</li>';

	

			echo "</ul>";

			?> <br />

                      <div id="response_ship" class="response_ship"></div>

                      <input type="hidden" name="user_zip" id="user_zip" value="<?php echo trim($arrValue['bsa'][0]['bsa_zip'])?>" /></td>

                  </div>

                </div>

              </div>

              

              <!--left_bigportion--> 

              

              <!--<a onclick="history.back();">

            <button class="signin_btn submit_helper" title="Back" type="submit">Back</button>

            </a> -->

              <div class="left_bigportion2" id="place_order">

                <div id="review-buttons-container" style="position: relative; top: 0px; left: 25px; width: 260px;float: left;" class=""> <!--<a href="index.php?controller=cart&amp;function=checkoutCustomer">-->

                  <button onclick="reviewSave();" class="placeorder_btn" id="place_order_btn1" title="Place Order" type="submit" style="margin-top: 15px;"><span style="display:inline-table; padding-left: 2px;color:white;">Place Order</span></button>

                  <button onclick="OrderSave();" class="placeorder_btn" id="save_order1" title="Save Order" type="submit" style="margin-top: 15px;"><span style="display:inline-table; padding-left: 2px;color:white;">Save Order</span></button>

                  <!--</a>--><br>

                  <span class="please-wait" id="review-please-wait" style="position: relative; left: -88px; display: none;"> <img src="/opc-ajax-loader.gif" alt="Submitting order information..." title="Submitting order information..." class="v-middle"> Submitting order information... </span> <br>

                  <br>

                </div>

                <p style="font-size: 16px; line-height: 25px;margin-top: 10px;"><b style="color: brown;">Order Total: $<span id="order_total_bottom"><?php echo number_format(trim($total_after_tax), 2)?></span></b></p>

                <p style="font-size: 9px;">By placing your order, you agree to medicalshipment.com's <a href="index.php?controller=content&function=index&slug=term-conditions">privacy notice</a> and <a href="index.php?controller=content&function=index&slug=privacy-policy">conditions of use</a>.</p>

              </div>

              <p>Do you need help? Explore our <a href="index.php?controller=content&function=index&slug=help">Help page</a> or <a href="index.php?controller=contact&function=index">contact us</a> </p>

              <br />

            </div>

            <div class="col-lg-4 right_bigportion">

              <div id="tour_div_11" class="stanrd_shipingsmall" style="float:right;width:280px;position:relative">

                <div id="review-buttons-container" style="position: relative; top: 10px; left: 30px; height: 50px;" class="">

                  <button onclick="reviewSave();" class="placeorder_btn" id="place_order_btn1" title="Place Order" type="submit"><span style="display:inline-table; padding-left: 2px;color:white;">Place Order</span></button>

                  <button onclick="orderSave();" class="placeorder_btn" id="save_order" title="Save Order" type="submit"><span style="display:inline-table; padding-left: 2px;color:white;">Save Order</span></button>

                  <br />

                  <br />

                  <br />

                </div>

                <p style="margin: 0 15px; border-bottom: 1px solid #CCC; padding: 5px 0 10px 0; font-size: 9px;text-align: center;">By placing your order, you agree to medicalshipment.com's <a href="index.php?controller=content&function=index&slug=term-conditions">privacy notice</a> and <a href="index.php?controller=content&function=index&slug=privacy-policy">conditions of use</a>.</p>

                <h1 class="shiping_haad" style="font-size: 13px !important; color: #0d0d0d;font-family: Arial,sans-serif;">Order Summary</h1>

                <br style="clear:both;">

                <div style="float:left; width:190px; height:auto;">

                  <table style="width:400px; float:left;">

                    <tbody>

                      <tr align="left" width="20%" style="margin-top:10px !important;">

                        <td width="150"> Items (<span id="cart_quantity_updated"><?php echo trim($total_item)?></span>): </td>

                        <td colspan="2">&nbsp;</td>

                        <td width="120" style="position:absolute;right:15px;"><span style="float:right;"> $<span id="total_amount"><?php echo number_format(trim($cart_total),2)?></span></span></td>

                      </tr>

                      <tr align="left" width="20%">

                        <td width="150"> Shipping &amp; handling: </td>

                        <td colspan="2">&nbsp;</td>

                        <td width="120" style="position:absolute;right:15px;"><span style="float:right;"> $<span id="tax_amount"><?php echo number_format($delivery_charges,2)?></span></span></td>

                      </tr>

                      <tr class="stnrad_table" style="float: left; margin-bottom: 10px; margin-top: 10px; width: 241px;"></tr>

                      <!--<tr class="line" width="51%">



                      <td colspan="2">&nbsp;</td>



                    </tr>-->

                      

                      <tr align="left" width="20%">

                        <td width="150"> Total before Tax: </td>

                        <td colspan="2">&nbsp;</td>

                        <td width="120" style="position:absolute;right:15px;"><span style="float:right;"> $<span id="total_befor_tax"><?php echo number_format(trim($total_before_tax), 2)?></span></span></td>

                      </tr>

                      <tr align="left" width="20%">

                        <td width="170"> Estimated Tax to be calculated: </td>

                        <td colspan="2">&nbsp;</td>

                        <td width="120" style="position:absolute;right:15px;"><span style="float:right;">$<span id="tax_ammnt_new"><?php echo number_format(trim($tax), 2)?></span></span></td>

                      </tr>

                      <?php 

					if($cop_type!='' || session()->get('reference') == 'flyer'){
						



					?>

                      <tr id="order_discount_coupon" align="left" width="20%">

                        <td width="150">Discount:</td>

                        <td colspan="2">&nbsp;</td>

                        <td width="120" style="position:absolute;right:15px;"><span style="float:right"> - $<span id="discount"><?php echo number_format($discount_amount,2)?></span></span></td>

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

        <div id="change_billing_popup" style="display:none;">

          <div class="color_stip">

            <div id="close_button" onclick="document.getElementById('change_billing_popup').style.display='none';">Close <img id="img_hover" src="button_delete_green.png" style="height: 20px;"> </div>

          </div>

          <div style="float: left; min-height: 354px; margin-top: 12px; overflow: auto; padding-left: 30px; padding-top: 21px; width: 100%;">

            <?php



					//$amsco=new medicalModel();
					$amsco=Helper::instance();


                    $state_array=$amsco->states;



					$state_array_c=$amsco->cstates;


					$addr1 = "select * from bill_ship_address WHERE user_id='".session()->get('user_id')."' order by bsa_id ASC";
					$addr2 = DB::select($addr1);
					$addr = json_decode(json_encode($addr2), true);

						foreach($addr as $post){

							$bsa=$post['bsa_id'];
							$fname=trim($post['bsa_fname']);
							$lname=trim($post['bsa_lname']);
							$phone=trim($post['bsa_phone']);
							$zip=trim($post['bsa_zip']);
							$city=trim($post['bsa_city']);
							$state=trim($post['bsa_state']);

							if($post['bsa_country'] != 'US'){ 

								$country=', '.trim($post['bsa_country']);

							}

							else

							{

								$country = '';

							}



							$address=trim($post['bsa_address']);



							$default_style="";

							



					?>

            <form id="co-billing-form1949" action="" method="post">

              <div style="float:left; width:280px;height:auto; margin-right:0px; margin-bottom:10px; font-family: arial;  margin-top: -16px;">

                <p></p>

                <h1 style="color: #000000; float: none; font-family: arial; font-weight: bold; margin-left: -5px; background: none;"><?php echo ucwords($fname.' '.$lname)?></h1>

                <p><?php echo $address?></p>

                <?php

				echo $city.', ';



				if(@$state_array[$state]){

					$state1 = $state_array[$state].' ';

					echo $state_array[$state].' ';

				}

				else{

					$state1 = $state_array_c[$state].' ';

					echo $state_array_c[$state].' ';

				}

				

				echo $zip;

				

				echo $country; ?>

                <br>

                <button type="button" onclick="saveBillingAddress('<?php echo ucwords($fname.' '.$lname).'<br>'.$address.'<br>'.$city.', '.$state1.' '.$zip.$country; ?>');document.getElementById('change_billing_popup').style.display='none';" style="margin-top: 15px; margin-bottom: 5px;" class="signin_btn"><span><span>Bill to this Address</span></span></button>

                <br>

              </div>

            </form>

            <?php } ?>

            <div style="float:left;width: 207px;height:auto;margin-right:0px;margin-bottom:10px; font-family: arial;padding: 35px 3px 35px 35px;border: 1px solid #CCC;"> <img src="https://images-na.ssl-images-amazon.com/images/G/01/checkout/addaddress._CB147050552_.gif"> <a data-toggle="modal" data-target="#myModal" id="add_billing"> Add a billing address</a> </div>

          </div>

          <br style="clear:both;">

        </div>

        

        <!--bodycontent-->

        

        <div class="contentbot"></div>

      </div>

      

      <!--content End--> 

      

    </div>

  </div>

</div>

<!-- Modal -->

<div class="modal fade" id="myModal" role="dialog">

  <div class="modal-dialog"> 

    

    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <h4 class="proposal">Add a billing address</h4>

        <button type="button" class="close" data-dismiss="modal" style="width: 5px; margin-top: -10px;">&times;</button>

      </div>

      <div class="modal-body">

        <form action="<?php echo 'index.php?controller=cart&function=review'?>" method="post" onsubmit="return varifyaddress()" id="myform">

          <input type="hidden" name="redirect" />

          <input type="hidden" name="type" value="shipping" />

          <table class="tbl">

            <tr>

              <p id="addr_error" style="color: red;"></p>

              <td><input type="text" class="inqury_ipput validate[required,maxSize[20]]" name="fname" id="fname" value="" placeholder="First Name" data-errormessage-value-missing="What's your first name" /></td>

            </tr>

            <tr>

              <td><input type="text" class="inqury_ipput validate[required,maxSize[20]]" name="lname" id="lname" placeholder="Last Name" value="" data-errormessage-value-missing="What's your last name" /></td>

            </tr>

            <tr>

              <td><input type="text" class="inqury_ipput validate[required]" name="phone" id="phone" placeholder="Phone Number" value="" data-errormessage-value-missing="What's your phone" /></td>

            </tr>

            <tr>

              <td><input type="text" name="address" id="address" class="inqury_ipput validate[required]" placeholder="Street Address, P.O.Box, C/O" spellcheck="false" data-errormessage-value-missing="What's your address" /></td>

            </tr>

            <tr>

              <td><input type="text" class="inqury_ipput validate[required]" name="zip" id="zip" placeholder="Zip Code" value="" data-errormessage-value-missing="What's your zip code" /></td>

            </tr>

            <tr>

              <td><input type="text" class="inqury_ipput validate[required]" name="city" id="city" placeholder="City" value="" data-errormessage-value-missing="What's your city" /></td>

            </tr>

            <tr>

              <td><select name="state" id="states" class="inqury_ipput validate[required]" data-errormessage-value-missing="What's your state">

                  <option value="">United States / Canada</option>

                  <option style="font-size:16px;background-color:#00478f;color:#FFF;" value="Sold Out">United States</option>

                  <?php 

            

                                            foreach($medical->states as $key=>$value){

            

                                               if($value!='*'){

            

                                            ?>

                  <option class="option" value="<?php echo $key.'_US'?>"><?php echo $value?></option>

                  <?php 

            

                                               }

            

                                            }

            

                                            ?>

                  <option style="font-size:16px;background-color:#00478f;color:#FFF;" value="Sold Out">Canada</option>

                  <?php 

            

                                            foreach($medical->cstates as $key=>$value){

            

                                               if($value!='*'){

            

                                            ?>

                  <option class="option" value="<?php echo $key.'_CA'?>"><?php echo $value?></option>

                  <?php 

            

                                               }

            

                                            }

            

                                            ?>

                </select></td>

            </tr>

            <tr>

              <td><select title="Select an Address Type" name="address_type" id="address_type" class="inqury_ipput validate[required]" data-errormessage-value-missing="Address type please">

                  <option value="">Select an Address Type</option>

                  <option value="Educational">Educational</option>

                  <option value="Residential">Residential</option>

                  <option value="Commercial">Commercial</option>

                </select></td>

            </tr>

            <tr>

              <td><input type="text" name="ship_dir" id="ship_dir" placeholder="Special Shipping Directions" class="inqury_ipput" /></td>

            </tr>

            <tr>

              <td><input type="submit" name="submit" id="add_bill_address" class="signin_btn submit_helper" value="Use this Address"></td>

            </tr>

          </table>

        </form>

      </div>

    </div>

  </div>

</div>



<!-- Modal -->

<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>

<script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">

	</script> 

<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8">

	</script> 

<script>

		jQuery(document).ready(function(){

			// binds form submission and fields to the validation engine

			jQuery("#myform").validationEngine();

		});

		jQuery.noConflict();

	</script>