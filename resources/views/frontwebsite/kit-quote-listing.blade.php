@extends('frontwebsite._mainLayout')
@section('content')

<script>

function quoteValidate(){

  var email=document.getElementById('email').value;
  var fname=document.getElementById('fname').value;
  var lname=document.getElementById('lname').value;
  var company=document.getElementById('company').value;
  var phone=document.getElementById('phone').value;  

  var address=document.getElementById('address').value;
  var city=document.getElementById('city').value;
  var zip=document.getElementById('zip').value;
  var state=document.getElementById('state').value;  

  if(email.trim()=='' || fname.trim()=='' || lname.trim()=='' || company.trim()=='' || phone.trim()=='' || address.trim()=='' || city.trim()=='' || zip.trim()=='' || state.trim()=='')
  {
      alert('Fill all required fields');
      return false;
  }

  else
  {  

		if(ValidateEmail(email.trim()))
		{		
			return true;
		}
		else
		{
			return false;
		}
  } 

}

function ValidateEmail(email){

	 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
	 {
		return true;
	 }
	 alert("You have entered an invalid email address!")
	 return false;
}

</script>
<style type="text/css">
.proposal {
	background-image: url("images/fill-form-icon.png");
	padding-left: 23px;
	background-position: 0 0;
	background-repeat: no-repeat;
	min-height: 18px;
	padding: 1px 0 1px 35px;
	text-transform: uppercase;
	font-size: 18px;
	font-family: HelveticaNeue !important;
	font-weight: bold;
	width: 60%;
	margin: 2% auto;
}
.ship {
	background-image: url("images/icon_lorry.gif");
	padding-left: 23px;
	background-position: 0 0;
	background-repeat: no-repeat;
	min-height: 18px;
	padding: 0px 0px 1px 25px;
	text-transform: uppercase;
	font-size: 18px;
	font-family: HelveticaNeue !important;
	font-weight: bold;
}
.tbl input, button, select, textarea {
	height: 36px;
}
.inqury_ipput {
	width: 390px;
	height: 36px;
	background: url(images/input_bgs.png) no-repeat;
	border: none;
	font-size: 18px !important;
}
select.inqury_ipput {
	background: url(images/selexcr_imh.jpg)!important;
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
	background: url(images/text_areabg.png)!important;
	width: 491px;
	height: 96px;
	border: none;
	color: #000;
	font-size: 18px;
	font-family: Arial, Helvetica, sans-serif;
	padding: 6px 0 0 9px;
	margin-top: 15px;
}
input:focus {
	border: 1px solid #007dc6 !important;
}
.inqury_ipput:focus {
	background-color: #fff !important;
	background-image: none !important;
	border: 2px solid rgb(48, 129, 190) !important;
	box-shadow: 0 0 10px #1e7ec8 !important;
	height: 36px !important;
}
.text_areaabg:focus {
	background-color: #fff !important;
	background-image: none !important;
	border: 2px solid rgb(48, 129, 190) !important;
	box-shadow: 0 0 10px #1e7ec8 !important;
	height: 96px !important;
}
.continput1 {
	border: 1px solid #CCC;
}
.stateformError, .state_id3formError {
	left: 245px !important;
}
.quantity-count
{
	width: 50px !important;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>

function updateKitQuoteServer(pid,uid){



	var qnty=$('#1inp' + pid).val();

	

	if(window.XMLHttpRequest){

		xmlhttp=new XMLHttpRequest();

	}

	else{

		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

	}

	

	xmlhttp.onreadystatechange=function(){

	if(xmlhttp.readyState==4 && xmlhttp.status==200){

		array=xmlhttp.responseText.split('__');

		document.getElementById("price_" + pid).innerHTML=array[0];

		<!--document.getElementById("subtotal").innerHTML=array[1];-->

		<!--document.getElementById("gtotal").innerHTML=array[1];-->

		$('#update_'+pid).css('display','none');

		$('#save_'+pid).css('display','block');
		
		setTimeout(function(){ 
			$('#save_'+pid).css('display','none'); 
		}, 2000);

	}

	

	}



<?php $controller="'server'"?>



var con=<?php echo $controller?>;

var site=<?php echo "'".SITE_PATH."'"?>;

var path=site + "index.php?controller=" + con + "&function=updateKitQuote" + "&pid=" + pid + "&qnty=" + qnty;

xmlhttp.open("GET",path,true);

xmlhttp.send();



}

		$(function() {
			
			// OnKeyDown Function
			$("#zip").keyup(function() {
				var zip_in = $(this);
				if ((zip_in.val().length == 5) ) {
					
					$.ajax({
						url: "https://api.zippopotam.us/us/" + zip_in.val(),
						cache: false,
						dataType: "json",
						type: "GET",
					  success: function(result, success) {
							
							cabb=JSON.stringify(result['country abbreviation']);
							cabb=cabb.replace (/"/g,'');
							
							
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
							
						},
						error: function(result, success) {
							
						}
					});
				}
	});

		});
		
	//	$('#myForm').validator();
			
	</script>
<div class="container">
  <div class="row main-contant">
    <div class="container contant-con">
      <div class="col-lg-12">
        <h1 class="h1">Quick Quote</h1>
        <br />
        <p> While we pride ourselves on having some of the best pricing in the industry, MedicalShipment may be able to offer additional savings on select items due to instances of large quantity or other factors. Please submit a list of your commonly purchased items along with quantity to see if you qualify! </p>
        <br />
      </div>
      <form action="<?php echo 'index.php?controller=cart&function=index'?>" method="post" name="move_to_cart" id="move_to_cart">
        <input type="hidden" name="move_cart" value="1" />
        <button type="submit" title="Copy to Quotation" class="button btncart add_cart" style="display:none;"></button>
      </form>
      <form action="<?php echo 'index.php?controller=kit_quote&function=sendEmail'?>" method="post" name="" id="myform">
        <table id="tbl_mycart">
          <thead>
            <tr>
              <th>Image</th>
              <th>Product Name</th>
              <th>Item Number</th>
              <th style="text-align:left">Remarks with Product</th>
              <th>Unit Price</th>
              <th>Quantity</th>
              <th>Subtotal</th>
              <th>Remove</th>
            </tr>
          </thead>
          <?php
					  # echo '<pre>'.print_r($_SESSION['quote'],true).'</pre>';

                        $gtotal=0;

                        if(isset($_SESSION['kit_quote']) && !empty($_SESSION['kit_quote']))
						{                           

                            foreach($_SESSION['kit_quote'] as $value){                            

                                $sql="SELECT p.*, pi.* FROM kit_product p left join kit_product_image pi on p.product_id=pi.product_id where p.product_id='".$value['product_id']."' group by p.product_id";
								
								
                                $query=mysql_query($sql);
                                $row=mysql_num_rows($query);

                                if($row > 0){                                    

                                    $post=mysql_fetch_assoc($query); 
                                    $stotal=trim($post['product_price'])*$value['product_quantity'];
                                    $gtotal+=$stotal;
                        ?>
          <tr>
            <td><a href="<?php echo SITE_PATH.'index.php?controller=kit_product&function=index&id='.$post['product_id']?>"> <img src="image.php?width=100&height=100&image=<?php echo SITE_PATH.'admin/'.IMAGE_PATH_PRODUCT.trim($post['product_image'])?>" class="img-responsive"> </a></td>
            <td><a href="<?php echo SITE_PATH.'index.php?controller=kit_product&function=index&id='.$post['product_id']?>"><?php echo $post['product_title']?></a></td>
            <td><?php echo stripslashes($post['product_item_no'])?></td>
            <td><textarea class="continput1" placeholder="Product Comments" spellcheck="false" name="detail_<?php echo intval($post['product_id'])?>"></textarea></td>
            <td><?php echo '$'.number_format(trim($post['product_price']),2)?></td>
            <td><div class="form-group form-group-options">
                          <div id="1" class="input-group input-group-option quantity-wrapper"> <span class="input-group-addon input-group-addon-remove quantity-remove btn" id="minus_cart" onclick="minus_kit_cart(<?php echo $post['product_id']; ?>, 7);"> <span class="glyphicon glyphicon-minus"></span> </span>
                            <input id="1inp<?php echo $post['product_id']; ?>" type="text" value="<?php echo $value['product_quantity']?>" onkeypress="showUpdateButton(<?php echo $post['product_id']?>)" name="qnty_<?php echo $post['product_id']?>" class="form-control quantity-count" style="margin:0;">
                            <span class="input-group-addon input-group-addon-remove quantity-add btn" id="plus_cart" onclick="plus_kit_cart(<?php echo $post['product_id']; ?>, 7)"> <span class="glyphicon glyphicon-plus"></span> </span> </div>
                          <?php
						  $function="updateKitQuoteServer(".$post['product_id'].", 7)";
						  
						  ?>
                          <a style="display: none; position: absolute; margin-left: 33px;" id="update_<?php echo $post['product_id']?>" href="javascript:<?php echo $function?>">Update</a> <span style="display: none; color:#F00; position: absolute; margin-left: 33px;" id="save_<?php echo $post['product_id']?>">Saved</span> </div></td>
            <!--<td><?php echo $value['product_quantity']?></td>-->
            <td><span class="price" id="price_<?php echo $post['product_id']?>"><?php echo '$'.number_format($stotal,2)?></span></td>
            <td><a style="color:#F00 !important" href="<?php echo SITE_PATH.'index.php?controller=kit_quote&function=removeQuote&pid='.intval($post['product_id'])?>" onclick="return confirm('Do you want to remove this quote item?')">Remove</a></td>
          </tr>
          <?php

                                }

                            }

                        }

                        ?>
          <input type="hidden" name="gtotal" value="<?php echo $gtotal?>" />
        </table>
        <div class="carttop-bottom">
          <div class="row">
            <div class="col-lg-2"> <a href="<?php echo SITE_PATH; ?>">
              <button type="button" title="Continue Shopping" class="button btncart add_cart"><span>Continue Shopping</span></button>
              </a> </div>
            <div class="col-lg-2">
              <button type="button" name="move_shopping_cart" title="Move to Shopping Cart" class="button btn-update btncart add_cart" onclick="document.getElementById('move_to_cart').submit();"><span>Move to Shopping Cart</span></button>
            </div>
          </div>
        </div>
        <div class="clearz"></div>
        <br />
        <h4 class="proposal">Enter your information to get a price proposal</h4>
        <div class="col-lg-6">
          <table class="tbl">
            <tr>
              <td><input type="text" class="inqury_ipput validate[required]" name="email" id="email" value="<?php echo trim(stripslashes($arrData['user'][0]['user_email']))?>" data-errormessage-value-missing="What's your email" placeholder="Email" /></td>
            </tr>
            <tr>
              <td><input type="text" class="inqury_ipput validate[required]" name="fname" id="fname" value="<?php echo trim(stripslashes($arrData['user'][0]['user_fname']))?>" data-errormessage-value-missing="What's your first name" placeholder="First Name" /></td>
            </tr>
            <tr>
              <td><input type="text" class="inqury_ipput validate[required]" name="lname" id="lname" value="<?php echo trim(stripslashes($arrData['user'][0]['user_lname']))?>" data-errormessage-value-missing="What's your last name" placeholder="Last Name" /></td>
            </tr>
            <tr>
              <td><input type="text" class="inqury_ipput validate[required]" name="company" id="company" value="<?php echo trim(stripslashes($arrData['user'][0]['user_company']))?>" data-errormessage-value-missing="What's your company" placeholder="Company" required /></td>
            </tr>
            <tr>
              <td><input type="text" class="inqury_ipput validate[required]" name="phone" id="phone" value="<?php echo trim(stripslashes($arrData['user'][0]['user_phone']))?>" data-errormessage-value-missing="What's your phone" placeholder="Telephone" /></td>
            </tr>
            <tr>
              <td><input type="text" name="address" id="address" class="inqury_ipput validate[required]" spellcheck="false" data-errormessage-value-missing="What's your address" placeholder="Address" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
        </div>
        <div class="col-lg-6">
          <table class="tbl">
            <!--<tr>
              <td><h4 class="ship">SHIPPING DETAILS</h4></td>
            </tr>-->
            <tr>
              <td><input type="text" class="inqury_ipput validate[required]" name="zip" id="zip" data-errormessage-value-missing="What's your zip code" placeholder="Zip Code" /></td>
            </tr>
            <tr>
              <td><input type="text" class="inqury_ipput validate[required]" name="city" id="city" data-errormessage-value-missing="What is your city" placeholder="City" /></td>
            </tr>
            <tr>
              <td><select name="state" id="states" class="inqury_ipput validate[required]" data-errormessage-value-missing="What's your state">
                  <option value="">Choose State</option>
                  <?php 
                        $amsco=new medicalModel();
                        foreach($amsco->states as $key=>$value){
                        if($value!='*'){
                            echo "<option value='".$key."_US''>".$value."</option>";

                        }
                        }
                        ?>
                </select></td>
            </tr>
            <tr>
              <td><select name="country" id="country" class="inqury_ipput validate[required]" data-errormessage-value-missing="What's your country">
                  <option value="US">United States</option>
                </select></td>
            </tr>
            <tr>
              <td><textarea placeholder="General Remarks" name="gremarks" class="text_areaabg" spellcheck="false"></textarea></td>
            </tr>
            <tr>
              <td><input type="submit" class="signin_btn" style="padding:0; width:230px;" value="Submit Quote Request" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
        </div>
        <div class="clearz"></div>
      </form>
    </div>
  </div>
</div>

<!--bodycontent-->

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

		/**
		*
		* @param {jqObject} the field where the validation applies
		* @param {Array[String]} validation rules for this field
		* @param {int} rule index
		* @param {Map} form options
		* @return an error string if validation failed
		*/
		function checkHELLO(field, rules, i, options){
			if (field.val() != "HELLO") {
				// this allows to use i18 for the error msgs
				return options.allrules.validate2fields.alertText;
			}
		}
		jQuery.noConflict();
	</script> 


@endsection()