<!--- header ----->
@include('header')
<!--- navigation ---->
@include('navigation')

<?php 
error_reporting(0);
$name='';
if($arrValue['stats'][0]->user_fname!= NULL){ 
	$name = ucwords($arrValue['stats'][0]->user_fname.' '.$arrValue['stats'][0]->user_lname);
	$email = trim($arrValue['stats'][0]->user_email);
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
         	<?php echo $name?> Stats
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
							<th>Page Title</th>
							<th>Page URL</th>
							<th>Date</th>
						 </tr>
						</thead>
					 	<tbody>

							<?php 
                            $ci = 0;
                            foreach ($arrValue['stats'] as $stats){
                            $ci++; 
                            ?>
                            <tr id="user" class="">
                                <td><?php echo $ci; ?></td>
                                <td><?php echo trim(stripslashes($stats->page_title)); ?></td>
                                <td><?php echo trim(stripslashes($stats->page_url)); ?></td>
                                <td><?php echo $stats->visit_date; ?></td>
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
  