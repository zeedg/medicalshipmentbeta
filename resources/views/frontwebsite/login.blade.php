@extends('frontwebsite._mainLayout')
@section('content')
	
<style type="text/css">
.submit_btn {
	padding: 0;
}
.inqury_ipput {
	background: rgba(0, 0, 0, 0) url("images/input_bgs.png") no-repeat scroll 0 0 !important;
	/*border: medium none !important;*/
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
input[type="text"]:hover, input[type="checkbox"]:hover
{
	/*border: none !important;*/
}
.formError{
	margin-left: 12px;
}
:-ms-input-placeholder {  
   color: #CCC;  
}

/* All Mobile Sizes (devices and browser) */
@media only screen and (min-width: 320px) and (max-width: 480px) 
{
.inqury_ipput, .inqury_ipput:hover
{
	background-size: 100% 100% !important;
	width: 100% !important;
}
.tbl label
{
	font-size: 13px;
}
}
</style>

<?php if(session()->get('user_email')){ ?>
	<script>window.location="<?= url('login/successlogin') ?>";</script>
<?php } ?>

<div class="container">
  <div class="row main-contant">
    <div class="container contant-con">
      <div class="col-lg-12">
        <div class="bodyinner">
          <h1 class="h1">Customer Account LogIn</h1>
          <h3 class='error'></h3>          
          
          <?php if ($message = session()->get('error')){ ?>
          <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong><?php echo $message; ?></strong>
          </div>
          <?php } ?>
          
          <?php if (count($errors) > 0){ ?>
              <div class="alert alert-danger">
                <ul>
                <?php foreach($errors->all() as $error){ ?>
                    <li><?php echo $error; ?></li>
                <?php } ?>
                </ul>
              </div>
          <?php } ?>
          
          <form action="{{ url('/main/frontlogin') }}" method="post" id="myform">
            <br />
            <div class="col-lg-6" id="login_tbl">
              <table class="tbl">
                <tr>
                  <td>
                  {{ csrf_field() }}
                    <input type="hidden" class="inqury_ipput" name="redirect" value="" />
                    <input type="hidden" class="inqury_ipput" name="pid" value="<?php if(isset($pid)){ echo $pid; } ?>" />
                    <input type="hidden" class="inqury_ipput" name="kid" value="" />
                    <input type="text" class="inqury_ipput validate[required]" data-errormessage-value-missing="What's your email" name="email" id="name" placeholder="Email Address" /></td>
                </tr>
                <tr>
                  <td>
                    <input type="password" class="inqury_ipput validate[required]" data-errormessage-value-missing="What's your password" name="password" id="password" placeholder="Password" required /></td>
                </tr>
                <tr>
                  <td><input type="submit" class="signin_btn" value="Sign In" /></td>
                </tr>
                <tr align="left">
                  <td><label>Forgot your Password? <a href="https://www.medicalshipment.com/index.php?controller=login&function=forget">Click Here</a></label></td>
                </tr>
              </table>
            </div>
            <div class="col-lg-6" id="create_account">
              <table class="tbl">
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><label class="right_tbl_opt">New To Medicalshipment.Com? <a href="https://www.medicalshipment.com/index.php?controller=register&function=index">Create Account</a> </label></td>
                </tr>
              </table>
            </div>
          </form>
        </div>
        
        <!--bodycontent-->
        
        <p>&nbsp;<br />
        </p>
      </div>
    </div>
  </div>
</div>       
    
@endsection()