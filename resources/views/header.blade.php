<?php

if(isset(Auth::user()->email)){
	
} else {
?>
<script>window.location = "/main";</script>
<?php
}
//$base_url = "http://localhost/laravel";
$base_url = url('/');
?>

<script type="text/javascript">
		function createSlug(ids) {
				
				var title = escape($('#title').val());
				
				if (title == "") {
						alert('Enter Product Title First');
						return;
				}
				
				title = title.replace('u2122' , '');
				
				if (window.XMLHttpRequest) {
						xmlhttp = new XMLHttpRequest();
				} else {
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				
				xmlhttp.onreadystatechange = function () {
						
						if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
								
								array = xmlhttp.responseText.split('||');
								document.getElementById("slug").value = array[0];
								
								if (array[1] == 0) {
										document.getElementById("slug_view").innerHTML = "<div class='alert alert-success'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'></button>Slug Available</div>";
								} else {
										document.getElementById("slug_view").innerHTML = "<div class='alert alert-danger'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'></button>Slug Unavailable</div>";
								}
								
						}
						
				}
			
			<?php
			//$controller="'".$_GET['controller']."'";
			//$controller="CategoryController";
			//$path=SITE_PATH."index.php?controller=$controller&function=slug";
			?>
				//var con=<?php //echo $controller?>;	
				//var path="controller=" + con + "&function=slug" + "&id=" + ids + "&title="+ title;
				
				var path = "creatslug/" + ids + "/" + title;
				
				xmlhttp.open("GET" , path , true);
				xmlhttp.send();
				
		}
		
		function createSlug2(ids) {
				
				var title = escape($('#title').val());
				
				if (title == "") {
						alert('Enter Product Title First');
						return;
				}
				
				title = title.replace('u2122' , '');
				
				if (window.XMLHttpRequest) {
						xmlhttp = new XMLHttpRequest();
				} else {
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				
				xmlhttp.onreadystatechange = function () {
						
						if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
								
								array = xmlhttp.responseText.split('||');
								document.getElementById("slug").value = array[0];
								
								if (array[1] == 0) {
										document.getElementById("slug_view").innerHTML = "<div class='alert alert-success'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'></button>Slug Available</div>";
								} else {
										document.getElementById("slug_view").innerHTML = "<div class='alert alert-danger'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'></button>Slug Unavailable</div>";
								}
								
						}
						
				}
			
			<?php
			//$controller="'".$_GET['controller']."'";
			//$controller="CategoryController";
			//$path=SITE_PATH."index.php?controller=$controller&function=slug";
			?>
				//var con=<?php //echo $controller?>;	
				//var path="controller=" + con + "&function=slug" + "&id=" + ids + "&title="+ title;
				
				var path = "creatslug2/" + ids + "/" + title;
				
				xmlhttp.open("GET" , path , true);
				xmlhttp.send();
				
		}
</script>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Prospectzio">
	<meta name="author" content="Prospectzio">
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $base_url; ?>/jscss/app-uploads/app-setting-uploads/907cc9b7e4df6be6e048e16f37bd89e31.png">
	<link rel="shortcut icon" sizes="96x96" href="<?php echo $base_url; ?>/jscss/app-uploads/app-setting-uploads/907cc9b7e4df6be6e048e16f37bd89e31.png">
	
	<title>Medicalshipment</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	
	<link rel="icon" href="img/favicon.png" type="image/png" sizes="16x16">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="<?php echo $base_url; ?>/jscss/assets/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo $base_url; ?>/jscss/assets/dist/css/app.css">
	<link rel="stylesheet" href="<?php echo $base_url; ?>/jscss/assets/dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="<?php echo $base_url; ?>/jscss/assets/dist/js/dropzone.css">
	<link rel="stylesheet" href="<?php echo $base_url; ?>/jscss/assets/dist/js/toastr.css">
	<link rel="stylesheet" href="<?php echo $base_url; ?>/jscss/assets/dist/js/lightbox.min.css">
	<link rel="stylesheet" href="<?php echo $base_url; ?>/jscss/assets/dist/js/examples.css">
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!-- iCheck -->
	<link rel="stylesheet" href="<?php echo $base_url; ?>/jscss/assets/plugins/iCheck/square/blue.css">
	<link rel="stylesheet" href="<?php echo $base_url; ?>/jscss/assets/plugins/datatables/dataTables.bootstrap.css">
	<!-- jQuery 2.2.0 -->
	<script src="<?php echo $base_url; ?>/jscss/assets/plugins/jQuery/jQuery-2.2.0.min.js"></script>

</head>
<!-- ADD THE CLASS sidedar-collapse TO HIDE THE SIDEBAR PRIOR TO LOADING THE SITE -->
<body id="appBody" class="hold-transition sidebar-mini skin-green" style="opacity:1 !important;">

<!-- Order Request View MODAL -->
<div class="modal fade" id="order-view-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog big-modal">
		
		<div class="modal-content">
			<div class="modal-header modal-info">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title"></h4>
			</div>
			
			<div class="modal-body white">
				
				<div class="row modal-view-html">
				
				</div>
			
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-icon pull-left" data-dismiss="modal">Cancel</button>
			</div>
		
		</div>
	
	</div>
</div>
<!-- Order Request View MODAL -->

<!-- Site wrapper -->
<div class="wrapper">