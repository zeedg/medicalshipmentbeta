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
          <form action="{{ url('billship/add') }}" method="post" id="myform">
            {{ csrf_field() }}
            <div id="location_holder">
              <h1 style="float:left;" class="h1">&nbsp;Address Type</h1>
              <select name="type" id="type" class="continput validate[required]" style="margin-bottom:20px">
                <option value="">Select Type</option>
                <option value="billing" <?php if(isset($type) and $type=='billing'){ echo 'selected="selected"'; } ?>>Billing</option>
                <option value="shipping" <?php if(isset($type) and $type=='shipping'){ echo 'selected="selected"'; } ?>>Shipping</option>
              </select>
            </div>
            <div id="bill_holder">
              <h1 style="float:left;" class="h1">&nbsp;Address</h1>
              <input type="text" class="continput validate[required,maxSize[20]]" name="fname" id="fname" placeholder="First Name" />
              <input type="text" class="continput validate[required,maxSize[20]]" name="lname" id="lname" placeholder="Last Name" />
              <input type="text" class="continput validate[required]" name="phone" id="phone" placeholder="Phone" />
              <textarea class="continput validate[required]" name="address" id="address" spellcheck='false' placeholder="Address"></textarea>
              <input type="number" class="continput validate[required]" name="zip" id="zip" placeholder="Zip Code (Numeric values only)" />
              <input type="text" class="continput validate[required]" name="city" id="city" placeholder="City"  />
              <select name="state" id="states" class="continput validate[required]" >
                <option value="">United States / Canada</option>
                <option style="font-size:16px;background-color:#00478f;color:#FFF;height:40px !important;" value="Sold Out">United States</option>
                <?php 
			$states = Helper::instance()->states;
            foreach($states as $key=>$value){
               if($value!='*'){
            ?>
                <option class="option" value="<?php echo $key.'_US'?>"><?php echo stripslashes($value)?></option>
                <?php 
               }
            }
            ?>
                <option style="font-size:16px;background-color:#00478f;color:#FFF;height:40px !important;" value="Sold Out">Canada</option>
                <?php
				 $cstates = Helper::instance()->cstates; 
            foreach($cstates as $key=>$value){
               if($value!='*'){
            ?>
                <option class="option" id="option" value="<?php echo $key.'_CA'?>"><?php echo stripslashes($value)?></option>
                <?php 
               }
            }
            ?>
              </select>
            </div>
            <div class="clear"></div>
            <select class="continput validate[required]" title="Select an Address Type" name="address_type" id="address_type" required>
              <option value="">Select an Address Type</option>
              <option value="Educational">Educational</option>
              <option value="Residential">Residential</option>
              <option value="Commercial">Commercial</option>
            </select>
            <input type="text" class="continput" name="ship_dir" id="ship_dir" placeholder="Special Shipping Directions" />
            <input type="checkbox" class="continput" name="default" id="default" style="width:20px;margin-top:10px !important;" />
            <div class="context" style="clear: none; padding-top: 10px;">Make Default:</div>
            <div style="clear:both;">&nbsp;</div>
            <input type="submit" class="signin_btn" value="Add" name="add" />
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