<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<?php
use \App\Http\Controllers\StatisticsController;
?>

<!------ content page start --------->
<section class="content-header">
  <h1>
    Website Statistics
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
	<div class="col-md-12"></div>
  </div>

  
  <div class="row">
    
    <div class="col-xs-12">
      <div class="box">
        
        <div class="box-header">
          <h3 class="box-title">
         	Order Report
          </h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body app-list-ingore">
         	<div class="row">
		        
                <div class="col-md-12">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#weekly" data-toggle="tab" aria-expanded="false">Weekly</a></li>
          <li class=""><a href="#monthly" data-toggle="tab" aria-expanded="false">Monthly</a></li>
          <li class=""><a href="#quater" data-toggle="tab" aria-expanded="false">Quater</a></li>
        </ul>
        <div class="tab-content">
        
              <!-- WEEKLY -->
              <div class="tab-pane active" id="weekly">
                
                <div class="col-xs-12">
      <div class="box">
        
        <!-- /.box-header -->
        <div class="box-body app-list-ingore">
         	<form name="adminUsers" action="members" method="post">
        		<input type="hidden" name="action" value="action-delete" />
	        	<div class="allutable"><!--  table-responsive -->
					<table class='table table-bordered table-striped table-list-search dataTable'>
						<thead>
						<tr>
							<th>#</th>
                              <th>Category</th>
                              <th>Product</th>
                              <th>Item No</th>
                              <th>Sale Qty</th>
						 </tr>
						</thead>
					 	<tbody>
<?php
$i = 0;
foreach($arrValue['order_report7'] as $order_report7){
	
	$i = $i + 1;
	$sales=stripslashes($order_report7->sales);

	$parent = StatisticsController::nthLevelCategory($order_report7->category_id);
	
?>
<tr id="user" class="">
	<td><?php echo $i; ?></td>
	<td><?php echo trim(stripslashes($parent)); ?></td>
    <td><?php echo trim(stripslashes($order_report7->product_title)); ?></td>
	<td><?php echo trim(stripslashes($order_report7->product_item_no)); ?></td>
    <td><?php echo (int)$sales; ?></td>
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
            <td><?php //echo $arrValue['order_report7']->links(); ?></td>
          </tr>
          </table>
                    
				</div>
				<input type="hidden" name="csrf" value="f6929e47c0da51842f812850685ab1cf" >
        <br><br>

			</form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

      <!-- /.box -->
    </div>
                
              </div>
              <!-- /.tab-pane -->
    
              <!-- MONTHLY -->
            <div class="tab-pane " id="monthly">
            <div class="col-xs-12">
      <div class="box">
        
        <!-- /.box-header -->
        <div class="box-body app-list-ingore">
         	<form name="adminUsers" action="members" method="post">
        		<input type="hidden" name="action" value="action-delete" />
	        	<div class="allutable"><!--  table-responsive -->
					<table class='table table-bordered table-striped table-list-search dataTable'>
						<thead>
						<tr>
							<th>#</th>
                              <th>Category</th>
                              <th>Product</th>
                              <th>Item No</th>
                              <th>Sale Qty</th>
						 </tr>
						</thead>
					 	<tbody>
<?php
$i = 0;
foreach($arrValue['order_report30'] as $order_report30){
	
	$i = $i + 1;
	$sales=stripslashes($order_report30->sales);

	$parent = StatisticsController::nthLevelCategory($order_report30->category_id);
	
?>
<tr id="user" class="">
	<td><?php echo $i; ?></td>
	<td><?php echo trim(stripslashes($parent)); ?></td>
    <td><?php echo trim(stripslashes($order_report30->product_title)); ?></td>
	<td><?php echo trim(stripslashes($order_report30->product_item_no)); ?></td>
    <td><?php echo (int)$sales; ?></td>
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
            <td><?php //echo $arrValue['order_report7']->links(); ?></td>
          </tr>
          </table>
                    
				</div>
				<input type="hidden" name="csrf" value="f6929e47c0da51842f812850685ab1cf" >
        <br><br>

			</form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

      <!-- /.box -->
    </div>
            </div>
            <!-- /.tab-pane -->
            
            <!-- MONTHLY -->
            <div class="tab-pane " id="quater">
            <div class="col-xs-12">
      <div class="box">
        
        <!-- /.box-header -->
        <div class="box-body app-list-ingore">
         	<form name="adminUsers" action="members" method="post">
        		<input type="hidden" name="action" value="action-delete" />
	        	<div class="allutable"><!--  table-responsive -->
					<table class='table table-bordered table-striped table-list-search dataTable'>
						<thead>
						<tr>
							<th>#</th>
                              <th>Category</th>
                              <th>Product</th>
                              <th>Item No</th>
                              <th>Sale Qty</th>
						 </tr>
						</thead>
					 	<tbody>
<?php
$i = 0;
foreach($arrValue['order_report90'] as $order_report90){
	
	$i = $i + 1;
	$sales=stripslashes($order_report90->sales);

	$parent = StatisticsController::nthLevelCategory($order_report90->category_id);
	
?>
<tr id="user" class="">
	<td><?php echo $i; ?></td>
	<td><?php echo trim(stripslashes($parent)); ?></td>
    <td><?php echo trim(stripslashes($order_report90->product_title)); ?></td>
	<td><?php echo trim(stripslashes($order_report90->product_item_no)); ?></td>
    <td><?php echo (int)$sales; ?></td>
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
            <td><?php //echo $arrValue['order_report7']->links(); ?></td>
          </tr>
          </table>
                    
				</div>
				<input type="hidden" name="csrf" value="f6929e47c0da51842f812850685ab1cf" >
        <br><br>

			</form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

      <!-- /.box -->
    </div>
            </div>
            <!-- /.tab-pane -->
              
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
      </div>
                
		      </div>
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
  