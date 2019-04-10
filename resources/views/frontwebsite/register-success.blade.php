@extends('frontwebsite._mainLayout')
@section('content')

<style type="text/css">
input, button, select, textarea {
	width: 50%;
	height: 35px;
}
.inqury_ipput {
	width: 390px;
	height: 36px;
	background: url(images/input_bgs.png) no-repeat;
	border: none;
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
	color: #a1a2a5;
	font-size: 18px;
	font-family: Arial, Helvetica, sans-serif;
	padding: 6px 0 0 9px;
	margin-top: 20px;
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
.signin_btn{
	width:190px;
	border-radius: 7px;
}
.h1 {
	text-align: left;
}
</style>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<div class="container">
  <div class="row main-contant">
    <div class="container contant-con">
      <h1 class="h1">Complete Registration</h1>
      <div class="col-lg-12" id="register"><br /><br /><br />
      <h3 style="color:green; line-height: 35px;">
      Congratulation!<br />
      Your account created successfully. Please check your email and click on link to activate your account.</h3><br /><br /><br />
	  
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