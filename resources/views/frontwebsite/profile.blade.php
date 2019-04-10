@extends('frontwebsite._mainLayout')
@section('content')

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
.text_areaabg {
	background: url("{{ url('/')}}/uploads/text_areabg.png")!important;
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
.continput:focus {
	background-color: #fff !important;
	background-image: none !important;
	border: 2px solid rgb(48, 129, 190) !important;
	box-shadow: 0 0 10px #1e7ec8 !important;
	height: 36px !important;
}
.h1 {
	text-align: left;
}
.formError
{
	margin-top: 15px !important;
}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<div class="container">
  <div class="row main-contant">
    <div class="container contant-con">
      
      @include('frontwebsite.account_left')
	  
      <div class="col-lg-9">
        <div class="bodyinner">
          <h1 class="h1">Customer Account Profile</h1>
          <?php

		//$medical=new medicalModel();

		if(isset($msg)){
			if($msg==0){
				echo "<h3 class='error'>Email already exist</h3>";
			}
			if($msg==1){
				echo "<h3 class='success'>Profile updated successfully</h3>";
			}
			if($msg==2){
				echo "<h3 class='error'>Something went wrong in query</h3>";
			}
		}

		?>
          <form action="{{ url('profile/index') }}" method="post" id="myform">
            {{ csrf_field() }}
            <input type="text" placeholder="First Name" class="continput validate[required,maxSize[20]]" name="fname" value="<?php echo $detail[0]['user_fname']?>" />
            <input type="text" class="continput validate[required,maxSize[20]]" placeholder="Last Name" name="lname" value="<?php echo $detail[0]['user_lname']?>" />
            <input type="text" placeholder="Company Name" class="continput validate[required]" name="company" value="<?php echo $detail[0]['user_company']?>" />
            <input type="text" placeholder="Position at Company" class="continput validate[required]" name="pcompany" value="<?php echo $detail[0]['user_pcompany']?>" />
            <input type="text" placeholder="Phone Number" class="continput validate[required]" name="phone" value="<?php echo $detail[0]['user_phone']?>" />
            <input type="text" placeholder="Fax Number" class="continput" name="fax" value="<?php echo $detail[0]['user_fax']?>" />
            <input type="text" class="continput validate[required]" placeholder="Email" name="email" value="<?php echo $detail[0]['user_email']?>" />
            <input type="password" class="continput validate[required]" placeholder="Password" name="password" value="<?php echo $detail[0]['user_password']?>" />
            <input type="text" placeholder="Name of GPO Affiliation(if applicable)" class="continput" name="gpo" value="<?php echo $detail[0]['user_gpo']?>" />
            
            <div class="context" style="width: 110px;">&nbsp;</div>
            <input type="submit" class="signin_btn" value="Update" name="update" />
            <div class="clear"></div>
          </form>
          <div class="mycart"> <br />
            <div class="clear"></div>
            <h1 class="h1">Billing Address
            <a href="{{ url('billship/add/billing') }}" style="color:#FFF; float:right; text-transform: capitalize;">Add</a></h1>
            <table id="tbl_mycart">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Full Name</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>City</th>
                  <th>Zip Code</th>
                  <th>State</th>
                  <th>Country</th>
                  <th>Default</th>
                  <th>Edit</th>
                  <th>Remove</th>
                </tr>
              </thead>
              <?php
					$count=0;
					if(isset($bsa_b) && !empty($bsa_b)){ 
						foreach($bsa_b as $post){
							$default='No';
							if($post['bsa_default']==1){
								$default='Yes';
							}
							$count++;
					?>
              <tr>
                <td><?php echo $count?></td>
                <td><?php echo $post['bsa_fname'].' '.$post['bsa_lname']?></td>
                <td><?php echo $post['bsa_phone']?></td>
                <td><?php echo $post['bsa_address']?></td>
                <td><?php echo $post['bsa_city']?></td>
                <td><?php echo $post['bsa_zip']?></td>
                <td><?php echo $post['bsa_state']?></td>
                <td><?php echo $post['bsa_country']?></td>
                <td><?php echo $default?></td>
                <td><a href="{{ url('billship/edit')}}<?php echo '/'.$post['bsa_id'] ?>"> <b>Edit</b> </a></td>
                <td><a href="{{ url('billship/remove')}}<?php echo '/'.$post['bsa_id'] ?>" onclick="return confirm('Do you want to remove this?')"> <b>Remove</b> </a></td>
              </tr>
              <?php
						}

					}

					?>
            </table>
            <h1 class="h1">Shipping Address
            <a href="{{ url('billship/add/shipping') }}" style="color:#FFF; float:right; text-transform: capitalize;">Add</a></h1>
            <table id="tbl_mycart1">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Full Name</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>City</th>
                  <th>Zip Code</th>
                  <th>State</th>
                  <th>Country</th>
                  <th>Default</th>
                  <th>Edit</th>
                  <th>Remove</th>
                </tr>
              </thead>
              <?php
					$count=0;
					if(isset($bsa_s) && !empty($bsa_s)){ 
						foreach($bsa_s as $post){
							$default='No';
							if($post['bsa_default']==1){
								$default='Yes';
							}
							$count++;
					?>
              <tr>
                <td><?php echo $count?></td>
                <td><?php echo $post['bsa_fname'].' '.$post['bsa_lname']?></td>
                <td><?php echo $post['bsa_phone']?></td>
                <td><?php echo $post['bsa_address']?></td>
                <td><?php echo $post['bsa_city']?></td>
                <td><?php echo $post['bsa_zip']?></td>
                <td><?php echo $post['bsa_state']?></td>
                <td><?php echo $post['bsa_country']?></td>
                <td><?php echo $default?></td>
                <td><a href="{{ url('billship/edit')}}<?php echo '/'.$post['bsa_id'] ?>"> <b>Edit</b> </a></td>
                <td><a href="{{ url('billship/remove')}}<?php echo '/'.$post['bsa_id'] ?>" onclick="return confirm('Do you want to remove this?')"> <b>Remove</b> </a></td>
              </tr>
              <?php
						}

					}
					?>
            </table>
          </div>
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