@extends('frontwebsite._mainLayout')
@section('content')

<?php
use App\Helpers\Helper;
?>

<style type="text/css">
input, button, select, textarea {
	height: 35px;
}
.continput {
	width: 390px;
	height: 36px;
	background: url("{{ url('/')}}/uploads/input_bgs.png") no-repeat;
	border: none;
	clear: both;
}
select.continput {
	background: url("{{ url('/')}}/uploads/selexcr_imh.jpg")!important;
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
textarea.continput {
	background: url("{{ url('/')}}/uploads/text_areabg.png")!important;
	width: 491px;
	height: 96px;
	border: none;
	color: #444;
	font-size: 18px;
	font-family: Arial, Helvetica, sans-serif;
	padding: 6px 0 0 9px;
	margin-top: 20px;
}
input:focus {
	border: 1px solid #007dc6 !important;
}
.continput:focus {
	background-color: #fff !important;
	background-image: none !important;
	border: 2px solid rgb(48, 129, 190) !important;
	box-shadow: 0 0 10px #1e7ec8 !important;
	height: 36px !important;
}
textarea.continput:focus {
	background-color: #fff !important;
	background-image: none !important;
	border: 2px solid rgb(48, 129, 190) !important;
	box-shadow: 0 0 10px #1e7ec8 !important;
	height: 96px !important;
}
.h1 {
	text-align: left;
}
.option {
	padding: 10px !important;
	height: 30px !important;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>
		$(function() {
			
			/*$(document).ready( function() 
			{
				$('#citybox').hide();
				$('#statebox').hide();
				
			});*/
			
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
			
	</script>
<div class="container">
  <div class="row main-contant">
    <div class="container contant-con">
      @include('frontwebsite.account_left')
      <div class="col-lg-9">
        <div class="bodyinner">
          <?php 

		if(isset($error) && !empty($error)){

			echo "<h3 class='error'>".$error."</h3>";

		}

		?>
          <form action="{{ url('billship/edit') }}" method="post" id="myform">
            <input type="hidden" name="id" value="<?php echo $bsa[0]['bsa_id']?>">
            {{ csrf_field() }}
            <div id="location_holder">
              <h1 style="float:left;" class="h1">&nbsp;Address Type</h1>
              <select name="type" id="type" class="continput validate[required]" required style="margin-bottom:20px">
                <option value="">Select Type</option>
                <option value="billing" <?php if($bsa[0]['bsa_type']=='billing'){ echo "selected='selected'";}?>>Billing</option>
                <option value="shipping" <?php if($bsa[0]['bsa_type']=='shipping'){ echo "selected='selected'";}?>>Shipping</option>
              </select>
            </div>
            <div id="bsa_holder">
              <h1 style="float:left" class="h1">&nbsp;Address</h1>
              <input type="text" class="continput validate[required,maxSize[20]]" name="fname" placeholder="First Name" value="<?php echo $bsa[0]['bsa_fname']?>" />
              <input type="text" class="continput validate[required,maxSize[20]]" name="lname" placeholder="Last Name" value="<?php echo $bsa[0]['bsa_lname']?>" />
              <input type="text" class="continput validate[required]" name="phone" placeholder="Phone Number" value="<?php echo $bsa[0]['bsa_phone']?>" />
              <textarea class="continput validate[required]" name="address" placeholder="Address" spellcheck='false'><?php echo $bsa[0]['bsa_address']?></textarea>
              <input type="number" class="continput validate[required]" name="zip" id="zip" placeholder="Zip Code (Numeric values only)" value="<?php echo $bsa[0]['bsa_zip']?>" />
              <input type="text" class="continput validate[required]" name="city" id="city" placeholder="City" value="<?php echo $bsa[0]['bsa_city']?>" />
              <select name="state" id="states" class="continput validate[required]">
                <option value="">United States / Canada</option>
                <option style="font-size:16px;background-color:#00478f;color:#FFF;height:40px !important;" value="Sold Out">United States</option>
                <?php 
			$states = Helper::instance()->states;
            foreach($states as $key=>$value){

               if($value!='*'){

				   

				   $selected="";

				   if(trim($key)==trim($bsa[0]['bsa_state'])){

						$selected="selected='selected'";

				   }

            ?>
                <option <?php echo $selected?> class="option" value="<?php echo $key.'_US'?>"><?php echo $value?></option>
                <?php 

               }

            }

            ?>
                <option style="font-size:16px;background-color:#00478f;color:#FFF;height:40px !important;" value="Sold Out">Canada</option>
                <?php 
			$cstates = Helper::instance()->cstates; 
            foreach($cstates as $key=>$value){

               if($value!='*'){

				   

				   $selected="";

				   if(trim($key)==trim($bsa[0]['bsa_state'])){

						$selected="selected='selected'";

				   }

            ?>
                <option <?php echo $selected?> class="option" value="<?php echo $key.'_CA'?>"><?php echo $value?></option>
                <?php 

               }

            }

            ?>
              </select>
            </div>
            <?php 
	   $address_type=trim(stripslashes($bsa[0]['bsa_address_type']));
	   $selected="selected='selected'";
	   ?>
            <div class="context">Address Type:</div>
            <select class="continput validate[required]" title="Select an Address Type" name="address_type">
              <option selected="" value="">Select an Address Type</option>
              <option value="Educational" <?php if($address_type=='Educational'){ echo $selected;}?>>Educational</option>
              <option value="Residential" <?php if($address_type=='Residential'){ echo $selected;}?>>Residential</option>
              <option value="Commercial"  <?php if($address_type=='Commercial'){ echo $selected;}?>>Commercial</option>
            </select>
            <input type="text" class="continput" name="ship_dir" placeholder="Special Shipping Directions" value="<?php echo $bsa[0]['bsa_ship_dir']?>" />
            <?php

	   $checked="";

	   if($bsa[0]['bsa_default']==1){

		   $checked="checked='checked'";

	   }

	   ?>
            <input type="checkbox" class="continput" name="default" id="default" <?php echo $checked?> style="width:20px;margin-top:10px !important" />
            <div class="context" style="clear: none; padding-top: 10px;">Make Default:</div>
            <div style="clear:both;">&nbsp;</div>
            <input type="submit" class="signin_btn" value="Update" name="edit" />
            <input type="reset" class="signin_btn" value="Reset" />
          </form>
        </div>
        
        <!--bodycontent-->
        
        <p>&nbsp;<br />
        </p>
      </div>
    </div>
  </div>
</div>
<div class="clearz"></div>
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

@endsection()