<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<?php
use \App\Http\Controllers\StatisticsController;
?>

<!------ content page start --------->
<section class="content-header">
  <h1 style="width:50%; float:left;">
    Website Statistics
  </h1>
  <li class="dropdown user user-menu" style="list-style:none; width:50%; float:right; text-align:right;">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
       <span class="hidden-xs">
		<span style="color:#333; font-weight:bold; font-size:14px;">
		More Stats
		</span>
	   </span>
    </a>
    <ul class="dropdown-menu" style="right:0; left:inherit;">
        <li>
        <ul class="sidebar-menu treeview treeview-menu">                        	
            <li class="">
                <a href="{{ url('view-piechart') }}"><i class="fa fa-circle-o"></i> Sales Data Pie Chart </a>
            </li>
            <li class="">
                <a href="{{ url('view-barhart') }}"><i class="fa fa-circle-o"></i> Sales Data Bar Chart </a>
            </li>
            <li class="">
                <a href="{{ url('order_report') }}"><i class="fa fa-circle-o"></i> Order Report </a>
            </li>
            <li class="">
                <a href="{{ url('visitor_stats') }}"><i class="fa fa-circle-o"></i> Visitor Stats </a>
            </li>
         </ul>
         </li> 			     					                        
    </ul>
   </li>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
	<div class="col-md-12"></div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        
        <!-- /.box-header -->
        <div class="box-body app-list-ingore">
         	<div class="row">
		        <div class="col-lg-6 col-xs-12">
		          <!-- small box -->
		          <div class="small-box bg-aqua">
		            <div class="inner">
		              <?php
						if(isset($arrValue['account']) && !empty($arrValue['account'])){ 								  
							foreach($arrValue['account'] as $post){
								$account = $post->total;
							}
						}
					  ?>
                      <h3><?php echo $account; ?></h3>
		              <p>User Accounts</p>
		            </div>
		            <div class="icon" style="top:5px;">
		              <i class="ion ion-person-add"></i>
		            </div>
		          </div>
		        </div>
		        
		        <!-- ./col -->
		        <div class="col-lg-6 col-xs-12">
		          <!-- small box -->
		          <div class="small-box bg-red">
		            <div class="inner">
		              <h3><?php echo count(@$arrValue['users-order'])?></h3>

		              <p>Users Order</p>
		            </div>
		            <div class="icon" style="top:5px;">
		              <i class="ion ion-pie-graph"></i>
		            </div>
		          </div>
		        </div>
		        <!-- ./col -->
		      </div>
        </div>
		
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  
  <div class="row">
    <div class="col-xs-6">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">
         	Highest amount in orders
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
							<th>Name</th>
                            <th>Email</th>
							<th>Order Total</th>
						 </tr>
						</thead>
					 	<tbody>
							<?php
                            if(isset($arrValue['highest-amount']) && !empty($arrValue['highest-amount'])){ 										  
                                foreach($arrValue['highest-amount'] as $post){
                                    $user_name = $post->user_fname.' '.$post->user_lname;
                                    $order_total = '$'.number_format($post->order_grand_total,2);
                                    $email = $post->user_email;
                                }
                            } 
                            ?>
                            <tr id="user" class="">
                                <td><?php echo $user_name; ?></td>
                                <td><?php echo $order_total; ?></td>
                                <td><?php echo $email; ?></td>
                            </tr>
					  </tbody>
					  <tfoot>
	                </tfoot>
					</table>
                    
                    <table class='' style="float:right;">
          	<tr>
            <td><?php //echo $keywords_arr->links() ?></td>
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
    
    <div class="col-xs-6">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">
         	Customer Frequently Ordered
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
							<th>Name</th>
                            <th>Email</th>
                            <th>Order Total</th>
						 </tr>
						</thead>
					 	<tbody>
							<?php
                            if(isset($arrValue['frequently-order']) && !empty($arrValue['frequently-order'])){ 									
								foreach($arrValue['frequently-order'] as $post){
										$user_name1 = $post->user_fname.' '.$post->user_lname;
										$order_total1 = '$'.number_format($post->order_grand_total,2);
										$email1 = $post->user_email;
									}
							}
                            ?>
                            <tr id="user" class="">
                                <td><?php echo $user_name1; ?></td>
                                <td><?php echo $order_total1; ?></td>
                                <td><?php echo $email1; ?></td>
                            </tr>
					  </tbody>
					  <tfoot>
	                </tfoot>
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
  
  <div class="row">
    
    <div class="col-xs-6">
      <div class="box">
        
        <div class="box-header">
          <h3 class="box-title">
         	Requested Catalog
          </h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body app-list-ingore">
         	<div class="row">
		        
                <div class="col-md-12">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#today" data-toggle="tab" aria-expanded="true">Today</a></li>
          <li class=""><a href="#weekly" data-toggle="tab" aria-expanded="false">Weekly</a></li>
          <li class=""><a href="#monthly" data-toggle="tab" aria-expanded="false">Monthly</a></li>
          <li class=""><a href="#quater" data-toggle="tab" aria-expanded="false">Quater</a></li>
          <li class=""><a href="#6months" data-toggle="tab" aria-expanded="false">6 Months</a></li>
          <li class=""><a href="#1year" data-toggle="tab" aria-expanded="false">1 Year</a></li>
        </ul>
        <div class="tab-content">
        
              <!-- TODAY -->
              <div class="tab-pane active" id="today">
                <?php
				foreach($arrValue['requested-catalog1'] as $catalog1){
					$catalog_today = $catalog1->tot;
				}
				?>
                <h1><?php echo $catalog_today; ?></h1>
              </div>
              
              <!-- WEEKLY -->
              <div class="tab-pane " id="weekly">
                <?php
				foreach($arrValue['requested-catalog7'] as $catalog7){
					$catalog_weekly = $catalog7->tot;
				}
				?>
                <h1><?php echo $catalog_weekly; ?></h1>
              </div>
              <!-- /.tab-pane -->
    
              <!-- MONTHLY -->
              <div class="tab-pane " id="monthly">
              	<?php
				foreach($arrValue['requested-catalog30'] as $catalog30){
					$catalog_monthly = $catalog30->tot;
				}
				?>
                <h1><?php echo $catalog_monthly; ?></h1>
              </div>
              <!-- /.tab-pane -->
              
              <!-- MONTHLY -->
              <div class="tab-pane " id="quater">
              	<?php
				foreach($arrValue['requested-catalog90'] as $catalog90){
					$catalog_quater = $catalog90->tot;
				}
				?>
                <h1><?php echo $catalog_quater; ?></h1>
              </div>
              <!-- /.tab-pane -->
              
              <!-- MONTHLY -->
              <div class="tab-pane " id="6months">
              	<?php
				foreach($arrValue['requested-catalog180'] as $catalog180){
					$catalog_6montlhy = $catalog180->tot;
				}
				?>
                <h1><?php echo $catalog_6montlhy; ?></h1>
              </div>
              <!-- /.tab-pane -->
              
              <!-- MONTHLY -->
              <div class="tab-pane " id="1year">
              	<?php
				foreach($arrValue['requested-catalog365'] as $catalog365){
					$catalog_yearly = $catalog365->tot;
				}
				?>
                <h1><?php echo $catalog_yearly; ?></h1>
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
    
    <div class="col-xs-6">
      <div class="box">
        
        <div class="box-header">
          <h3 class="box-title">
         	Virtual Catalog Viewed
          </h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body app-list-ingore">
         	<div class="row">
		        
                <div class="col-md-12">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#vtoday" data-toggle="tab" aria-expanded="true">Today</a></li>
          <li class=""><a href="#vweekly" data-toggle="tab" aria-expanded="false">Weekly</a></li>
          <li class=""><a href="#vmonthly" data-toggle="tab" aria-expanded="false">Monthly</a></li>
          <li class=""><a href="#vquater" data-toggle="tab" aria-expanded="false">Quater</a></li>
          <li class=""><a href="#v6months" data-toggle="tab" aria-expanded="false">6 Months</a></li>
          <li class=""><a href="#v1year" data-toggle="tab" aria-expanded="false">1 Year</a></li>
        </ul>
        <div class="tab-content">
        
              <!-- TODAY -->
              <div class="tab-pane active" id="vtoday">
                <?php
				foreach($arrValue['virtual-catalog1'] as $catalog1){
					$catalog_today = $catalog1->tot;
				}
				?>
                <h1><?php echo $catalog_today; ?></h1>
              </div>
              
              <!-- WEEKLY -->
              <div class="tab-pane " id="vweekly">
                <?php
				foreach($arrValue['virtual-catalog7'] as $catalog7){
					$catalog_weekly = $catalog7->tot;
				}
				?>
                <h1><?php echo $catalog_weekly; ?></h1>
              </div>
              <!-- /.tab-pane -->
    
              <!-- MONTHLY -->
              <div class="tab-pane " id="vmonthly">
              	<?php
				foreach($arrValue['virtual-catalog30'] as $catalog30){
					$catalog_monthly = $catalog30->tot;
				}
				?>
                <h1><?php echo $catalog_monthly; ?></h1>
              </div>
              <!-- /.tab-pane -->
              
              <!-- MONTHLY -->
              <div class="tab-pane " id="vquater">
              	<?php
				foreach($arrValue['virtual-catalog90'] as $catalog90){
					$catalog_quater = $catalog90->tot;
				}
				?>
                <h1><?php echo $catalog_quater; ?></h1>
              </div>
              <!-- /.tab-pane -->
              
              <!-- MONTHLY -->
              <div class="tab-pane " id="v6months">
              	<?php
				foreach($arrValue['virtual-catalog180'] as $catalog180){
					$catalog_6montlhy = $catalog180->tot;
				}
				?>
                <h1><?php echo $catalog_6montlhy; ?></h1>
              </div>
              <!-- /.tab-pane -->
              
              <!-- MONTHLY -->
              <div class="tab-pane " id="v1year">
              	<?php
				foreach($arrValue['virtual-catalog365'] as $catalog365){
					$catalog_yearly = $catalog365->tot;
				}
				?>
                <h1><?php echo $catalog_yearly; ?></h1>
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
    
  </div>
  
  
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">
         	Biggest Seller
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
                            <th>Category</th>
                            <th>Product</th>
							<th>Item No</th>
                            <th>Sale Qty</th>
						 </tr>
						</thead>
					 	<tbody>
<?php
$i = 0;
foreach ($arrValue['biggest-seller'] as $post){ 
	
	$i = $i + 1;
	$sales=stripslashes($post->sales);

	$parent = StatisticsController::nthLevelCategory($post->category_id);
	
	/*echo '<pre>';
	print_r($parent);exit;*/
	
	/*$arrayRev = array_reverse($parent);
	$parent = implode(' &raquo; ', $arrayRev);*/
	
?>
<tr id="user" class="">
	<td><?php echo $i; ?></td>
	<td><?php echo trim(stripslashes($parent)); ?></td>
    <td><?php echo trim(stripslashes($post->product_title)); ?></td>
	<td><?php echo trim(stripslashes($post->product_item_no)); ?></td>
    <td><?php echo stripslashes($sales); ?></td>
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
            <td><?php //echo $keywords_arr->links() ?></td>
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
    <!-- /.col -->
  </div>
  
  
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">
         	List All Items (By Best Seller)
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
                              <th>Category</th>
                              <th>Product</th>
                              <th>Item No</th>
                              <th>Sale Qty</th>
						 </tr>
						</thead>
					 	<tbody>
<?php
$i = 0;
foreach ($arrValue['list_all_items'] as $post){ 
	
	$i = $i + 1;
	//$sales=stripslashes($post->sales);

	$parent = StatisticsController::nthLevelCategory($post->category_id);
	
?>
<tr id="user" class="">
	<td><?php echo $i; ?></td>
	<td><?php echo trim(stripslashes($parent)); ?></td>
    <td><?php echo trim(stripslashes($post->product_title)); ?></td>
	<td><?php echo trim(stripslashes($post->product_item_no)); ?></td>
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
            <td><?php echo $arrValue['list_all_items']->links(); ?></td>
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
    <!-- /.col -->
  </div>
  
  
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">
         	Customers in States
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
                    		<th>State</th>
                    		<th>Number of Customer</th>
						 </tr>
						</thead>
					 	<tbody>
<?php
$i = 0;
foreach ($arrValue['customers-statewise'] as $post){ 
	
	$i = $i + 1;
	
	$from_state = $post->fromstate;
	$state_name = $post->bsa_state;
	
?>
<tr id="user" class="">
	<td><?php echo $i; ?></td>
	<td><?php echo trim(stripslashes($state_name)); ?></td>
    <td><?php echo trim(stripslashes($from_state)); ?></td>
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
            <td><?php //echo $keywords_arr->links() ?></td>
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
    <!-- /.col -->
  </div>
  
  <!-- /.row -->
</section>
<!-- /.content -->

<!------ content page end ----------->

<!------- footer ------>
@include('footer')
  