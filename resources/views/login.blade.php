<?php
//include("db.php");

//$base_url = "http://localhost/laravel/";
//$base_url = url('jscss/') . '/';
$base_url = url('/');
?> 

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Medicalshipment</title>
  <meta name="author" content="Prospectzio App" />
  <meta name="title" content="Prospectzio App" />
    <meta name="description" content="Find Prospects The Easy Way..." />
    <meta name="keywords" content="Prospectzio" /> 
<meta property="og:image" content="https://help.prospectz.io/wp-content/uploads/2018/12/prospectzio-app.jpg"/>

  <!-- Tell the browser to be responsive to screen width -->
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $base_url; ?>/jscss/app-uploads/app-setting-uploads/mdimg.png">
  <link rel="shortcut icon" sizes="96x96" href="<?php echo $base_url; ?>/jscss/app-uploads/app-setting-uploads/mdimg.png">

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  	<link rel="icon" href="img/favicon.png" type="image/png" sizes="16x16">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>/jscss/assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link href="<?php echo $base_url; ?>/jscss/assets/fonts/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>/jscss/assets/dist/css/app.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>/jscss/assets/plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="<?php echo $base_url; ?>/jscss/assets/plugins/iCheck/flat/blue.css">

  
</head>


<body class="hold-transition login-page image-background">
<div class="login-box">
    
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">

    <br/>
    
     
      <img src="<?php echo $base_url; ?>/jscss/app-uploads/app-setting-uploads/mdimg.png" class="" alt="Logo" style='margin-left:-12px;' />
      
      <br/>
      
      @if(isset(Auth::user()->email))
      	<script>window.location="<?= url('main/successlogin') ?>";</script>
      @endif
      
      @if ($message = Session::get('error'))
      <div class="alert alert-danger alert-block">
      	<button type="button" class="close" data-dismiss="alert">x</button>
        <strong>{{ $message }}</strong>
      </div>
      @endif
      
      @if (count($errors) > 0)
      	  <div class="alert alert-danger">
          	<ul>
            @foreach($errors->all() as $error)
            	<li>{{ $error }}</li>
            @endforeach
            </ul>
          </div>
      @endif  
      <form method="post" action="{{ url('/main/checklogin') }}">
      	{{ csrf_field() }}
        <div class="form-group">
        	<label>Enter Email</label>
            <input type="email" name="email" class="form-control" />
        </div>
        <div class="form-group">
        	<label>Enter Password</label>
            <input type="password" name="password" class="form-control" />
        </div>
        <div class="form-group">
        	<input type="submit" name="login" class="btn btn-primary" value="Login" />
        </div>
      </form>


  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.0 -->
<script src="<?php echo $base_url; ?>/jscss/assets/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo $base_url; ?>/jscss/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo $base_url; ?>/jscss/assets/plugins/iCheck/icheck.min.js"></script>


<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue',
    });
  });
</script>

<script src="<?php echo $base_url; ?>/jscss/assets/dist/js/jquery.backstretch.min.js"></script>
 

</body>
</html>

