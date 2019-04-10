<?php
//$base_url = "http://localhost/laravel";
$base_url = url('/');
?>

</div>
<!-- /.content-wrapper -->
<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->

<footer class="main-footer">
	
	<strong>Copyright &copy; Medicalshipment <?php echo date("Y"); ?>. All Rights Reserved.</strong>
</footer>

<!-- Add the sidebar's background. This div must be placed
					immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<div class="modal fade" id="InactivityModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header modal-danger">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">site inactivity header</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<h5>12345,</h5>
						<p>
							asdf asfasf asdf
						</p>
					
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a id="justlogout" href="#" class="btn btn-fill btn-danger btn-icon">Just Logout Now</a>
				<button type="button" class="btn btn-primary btn-fill btn-icon" data-dismiss="modal">Keep Using System</button>
			</div>
		</div>
	</div>
</div>

<!-- Bootstrap 3.3.6 -->
<script src="<?php echo $base_url; ?>/jscss/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo $base_url; ?>/jscss/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $base_url; ?>/jscss/assets/plugins/fastclick/fastclick.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>/jscss/assets/dist/js/jquery.countdown.min.js"></script>
<!-- DataTables -->
<script src="<?php echo $base_url; ?>/jscss/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $base_url; ?>/jscss/assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo $base_url; ?>/jscss/assets/dist/js/demo.js?<?php echo time(); ?>"></script>
<script src="<?php echo $base_url; ?>/jscss/assets/dist/js/utils.js?<?php echo time(); ?>"></script>
<script src="<?php echo $base_url; ?>/jscss/assets/dist/js/app.min.js?<?php echo time(); ?>"></script>
<script src="<?php echo $base_url; ?>/jscss/assets/dist/js/ifvisible.min.js"></script>
<script src="<?php echo $base_url; ?>/jscss/assets/dist/js/jquery.confirm.min.js"></script>
<script src="<?php echo $base_url; ?>/jscss/assets/dist/js/jquery.blockUI.js"></script>
<script src="<?php echo $base_url; ?>/jscss/assets/dist/js/jquery.timeago.js"></script>
<script src="<?php echo $base_url; ?>/jscss/assets/dist/js/jquery.flot.js"></script>
<script src="<?php echo $base_url; ?>/jscss/assets/dist/js/jquery.flot.pie.js"></script>
<script src="<?php echo $base_url; ?>/jscss/assets/dist/js/jquery.flot.stack.js"></script>

<script src="<?php echo $base_url; ?>/jscss/assets/dist/js/app-help.js?<?php echo time(); ?>"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>/jscss/assets/dist/js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>/jscss/assets/dist/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>/jscss/assets/dist/js/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>/jscss/assets/dist/js/toastr.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>/jscss/assets/dist/js/lightbox.min.js"></script>
<script src="<?php echo $base_url; ?>/jscss/assets/dist/js/master.js?<?php echo time(); ?>"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.3.0/css/iziToast.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.3.0/js/iziToast.min.js"></script>

<script>
		
		$(document).ready(function (event) {
				
				//event.stopPropagation();
		});
		
		//INvisible
		function d(el) {
				return document.getElementById(el);
		}
		
		//Utils.appAutoLogout
		
		ifvisible.setIdleDuration('site inactivity logout');
		
		ifvisible.on('statusChanged' , function (e) {
				//d("result").innerHTML += (e.status+"<br>");
				//event.stopPropagation();
		});
		
		/* ifvisible.idle(function(){
							document.body.style.opacity = 0.5;
			});

			ifvisible.wakeup(function(){
							document.body.style.opacity = 1;
			});*/
		
		
		//event.stopPropagation();
		
		setInterval(function () {
				
				//e.stopPropagation();
				var info = ifvisible.getIdleInfo();
				//inactivity
				var l = parseInt(info.timeLeft / 1000);
				if (l == 300) {
						$('#InactivityModal').modal('show');
				}
				
				if (l == 10) {
						window.location.href = Utils.sourceAppLogout;
				}
				
				
				if (info.timeLeftPer < 3) {
						info.timeLeftPer = 0;
						info.timeLeft = ifvisible.getIdleDuration();
				}
				
				
		} , 200);

</script>

<!---- old js scripts ---->

<script src="<?php echo $base_url; ?>/jscss/js/jquery.canvasjs.min.js"></script>
<!--<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>-->

<!-- Editor -->
<script type="text/javascript" src="<?php echo $base_url; ?>/jscss/editor/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>/jscss/editor/ckfinder/ckfinder.js"></script>

<!-- Editor -->
<script type="text/javascript">
		
		<?php
		$slugs = explode ("/", request()->fullUrl());
 		$pagename = $slugs [(count ($slugs) - 1)];
		if($pagename != 'view-manufacturer'){
		?>
		var editor = CKEDITOR.replace('detail' , {
				filebrowserBrowseUrl : 'jscss/editor/ckfinder/ckfinder.html' ,
				filebrowserImageBrowseUrl : 'jscss/editor/ckfinder/ckfinder.html?type=Images' ,
				filebrowserFlashBrowseUrl : 'jscss/editor/ckfinder/ckfinder.html?type=Flash' ,
				filebrowserUploadUrl : 'jscss/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files' ,
				filebrowserImageUploadUrl : 'jscss/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images' ,
				filebrowserFlashUploadUrl : 'jscss/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
		});
		CKFinder.setupCKEditor(editor , '../');
		<?php } ?>
</script>

<script type="text/javascript">
		
		(function ($) {
				$(document).ready(function () {
						$('.dataTables_paginate ul.pagination, #DataTables_Table_0_info, .dataTables_info').css({
								'display' : 'none'
						});
						$('.dataTables_length').css({
								'display' : 'none'
						});
						$('.dataTables_filter').css({
								'display' : 'none'
						});
				});
		})(jQuery);
		
		/*if there  is any error on */
		<?php if($errors->any()){ ?>
				@foreach ($errors->all() as $error)
		
		iziToast.error({
				title : 'Error' ,
				message : '{{ $error }}' ,
				timeout : 10000 ,
				position : 'topRight' ,
				balloon : false ,
		});
				
				@endforeach
		<?php } ?>
		
		<?php if(isset($_GET[ 'msg' ]) && !empty($_GET[ 'msg' ])){ ?>
		
		iziToast.success({
				title : 'success' ,
				message : '{{ $_GET['msg'] }}' ,
				timeout : 10000 ,
				position : 'topRight' ,
				balloon : false ,
		});
	
	<?php } ?>

</script>

</body>
</html>