<!--- header ----->
@include('header')
<!--- navigation ---->
@include('navigation')

<?php 
error_reporting(0);
$name='';
if($arrValue['cart_stats'][0]->user_fname!= NULL){ 
	$name = ucwords($arrValue['cart_stats'][0]->user_fname.' '.$arrValue['cart_stats'][0]->user_lname);
	$email = trim($arrValue['cart_stats'][0]->user_email);
	if($email!=''){
		$name .= '( '.$email.' )';
	}
}
else { 
	$name = 'Visitor';
}
?>

<!------ content page start --------->
<section class="content-header">
  <h1>
    Visitor Stats
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
	<div class="col-md-12">
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">
         	<?php echo $name?> Cart Stats
          </h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body app-list-ingore">
         	<form name="adminUsers" action="members" method="post">
        		<input type="hidden" name="action" value="action-delete" />
	        	<div class="allutable"><!--  table-responsive -->
					<table class='table table-bordered table-striped table-list-search dataTable'>
						<thead>
						<tr>
							<th>#</th>
							<th>Image</th>
                            <th>Product</th>
                            <th>Action</th>
                            <th>Type</th>
                            <th>IP Address</th>
                            <th>Date</th>
						 </tr>
						</thead>
					 	<tbody>

							<?php 
                            $ci = 0;
                            foreach ($arrValue['cart_stats'] as $cart_stats){
                            $ci++;
							
	$mfas = DB::select("select product_image from product_image where product_id='".$post['product_id']."' order by pi_id ASC limit 0,1");
	foreach($mfas as $mfa){
		$product_image = $mfa->product_image;
	}
	
	$image='<img src='.url('/uploads/slider/'.$cart_stats->slider_image).' alt="Image Not Fount" height="120">';
	$product='<br />'.trim(stripslashes($cart_stats->product_title)).'<br />'.'<b>('.trim(stripslashes($cart_stats->product_item_no)).')</b>';
							 
                            ?>
                            <tr id="user" class="">
                                <td><?php echo $ci; ?></td>
                                <td><?php echo $image; ?></td>
                                <td><?php echo $product; ?></td>
                                <td><?php echo trim(stripslashes($cart_stats->action)); ?></td>
                                <td><?php echo trim(stripslashes($cart_stats->type)); ?></td>
                                <td><?php echo trim(stripslashes($cart_stats->ip_address)); ?></td>
                                <td><?php echo $cart_stats->date; ?></td>
                            </tr>
                            <?php
                            }
                            ?>						
		
					  </tbody>
					  <tfoot>
	                </tfoot>
					</table>
                    
                    <table class='' style="float:right;">
          	<tr>
            <td><?php //echo $categories->links(); ?></td>
          </tr>
          </table>
				</div>
				
        <br><br>

			</form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->

<!------ content page end ----------->

<!------- footer ------>
@include('footer')
  