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
         	Visitor Stats
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
                              <th>Visitor Name</th>
                              <th>IP Address</th>
                              <th>Action</th>
						 </tr>
						</thead>
					 	<tbody>
<?php
$i = 0;
foreach($arrValue['visitor_stats1'] as $visitor_stats1){
	
	$i = $i + 1;
	if($visitor_stats1->user_fname != NULL){ 
		$name = ucwords($visitor_stats1->user_fname.' '.$visitor_stats1->user_lname);
		$email = trim($visitor_stats1->user_email);
		if($email!=''){
			$name .= '( <a target="_blank" href="index.php?controller=user&function=edit&id="'.$visitor_stats1->user_id.'>'.$email.'</a> )';
		}
	} else { $name = 'VISITOR'; }
	
?>
<tr id="user" class="">
	<td><?php echo $i; ?></td>
	<td><?php echo $name; ?></td>
    <td><?php echo trim(stripslashes($visitor_stats1->ip_address)); ?></td>
    <td>
		<div class="dropdown">
			<button id="btn" class="btn btn-fill btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true">
				Actions
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu"  style="right: 0; left: auto;"  aria-labelledby="dropdownMenu">
				<li class="">
					<a href="visitor_stats_listing/<?php if($visitor_stats1->user_id != ''){ echo $visitor_stats1->user_id; } else { echo '0'; } ?>/<?php echo $visitor_stats1->ip_address; ?>" class="tip" data-placement="left" data-element="user38" title="View/Edit <?php echo $visitor_stats1->page_title ?>"><i class="fa fa-pencil text text-primary"></i> View Page Logs <?php echo $visitor_stats1->page_title ?></a>
				</li>

				<li role="separator" class="divider"></li>

				<li class="">
					<a href="visitor_carts_listing/<?php if($visitor_stats1->user_id != ''){ echo $visitor_stats1->user_id; } else { echo '0'; } ?>" class="tip" data-placement="left" data-element="user38" title="View/Edit <?php echo $visitor_stats1->page_title ?>"><i class="fa fa-pencil text text-primary"></i> View Cart Logs <?php echo $visitor_stats1->page_title ?></a>
				</li>

			</ul>
		</div>

	</td>
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
              
              <!-- WEEKLY -->
              <div class="tab-pane" id="weekly">
                
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
                              <th>Visitor Name</th>
                              <th>IP Address</th>
                              <th>Action</th>
						 </tr>
						</thead>
					 	<tbody>
<?php
$i = 0;
foreach($arrValue['visitor_stats7'] as $visitor_stats7){
	
	$i = $i + 1;
	if($visitor_stats7->user_fname != NULL){ 
		$name = ucwords($visitor_stats7->user_fname.' '.$visitor_stats7->user_lname);
		$email = trim($visitor_stats7->user_email);
		if($email!=''){
			$name .= '( <a target="_blank" href="index.php?controller=user&function=edit&id="'.$visitor_stats7->user_id.'>'.$email.'</a> )';
		}
	} else { $name = 'VISITOR'; }
	
?>
<tr id="user" class="">
	<td><?php echo $i; ?></td>
	<td><?php echo $name; ?></td>
    <td><?php echo trim(stripslashes($visitor_stats7->ip_address)); ?></td>
    <td>
		<div class="dropdown">
			<button id="btn" class="btn btn-fill btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true">
				Actions
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu"  style="right: 0; left: auto;"  aria-labelledby="dropdownMenu">
				<li class="">
					<a href="visitor_stats_listing/<?php if($visitor_stats7->user_id != ''){ echo $visitor_stats7->user_id; } else { echo '0'; } ?>/<?php echo $visitor_stats7->ip_address; ?>" class="tip" data-placement="left" data-element="user38" title="View/Edit <?php echo $visitor_stats7->page_title ?>"><i class="fa fa-pencil text text-primary"></i> View Page Logs <?php echo $visitor_stats7->page_title ?></a>
				</li>

				<li role="separator" class="divider"></li>

				<li class="">
					<a href="visitor_carts_listing/<?php if($visitor_stats7->user_id != ''){ echo $visitor_stats7->user_id; } else { echo '0'; } ?>" class="tip" data-placement="left" data-element="user38" title="View/Edit <?php echo $visitor_stats7->page_title ?>"><i class="fa fa-pencil text text-primary"></i> View Cart Logs <?php echo $visitor_stats7->page_title ?></a>
				</li>

			</ul>
		</div>

	</td>
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
              
              <!-- MONTHLY -->
              <div class="tab-pane" id="monthly">
                
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
                              <th>Visitor Name</th>
                              <th>IP Address</th>
                              <th>Action</th>
						 </tr>
						</thead>
					 	<tbody>
<?php
$i = 0;
foreach($arrValue['visitor_stats30'] as $visitor_stats30){
	
	$i = $i + 1;
	if($visitor_stats30->user_fname != NULL){ 
		$name = ucwords($visitor_stats30->user_fname.' '.$visitor_stats30->user_lname);
		$email = trim($visitor_stats30->user_email);
		if($email!=''){
			$name .= '( <a target="_blank" href="index.php?controller=user&function=edit&id="'.$visitor_stats30->user_id.'>'.$email.'</a> )';
		}
	} else { $name = 'VISITOR'; }
	
?>
<tr id="user" class="">
	<td><?php echo $i; ?></td>
	<td><?php echo $name; ?></td>
    <td><?php echo trim(stripslashes($visitor_stats30->ip_address)); ?></td>
    <td>
		<div class="dropdown">
			<button id="btn" class="btn btn-fill btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true">
				Actions
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu"  style="right: 0; left: auto;"  aria-labelledby="dropdownMenu">
				<li class="">
					<a href="visitor_stats_listing/<?php if($visitor_stats30->user_id != ''){ echo $visitor_stats30->user_id; } else { echo '0'; } ?>/<?php echo $visitor_stats30->ip_address; ?>" class="tip" data-placement="left" data-element="user38" title="View/Edit <?php echo $visitor_stats30->page_title ?>"><i class="fa fa-pencil text text-primary"></i> View Page Logs <?php echo $visitor_stats30->page_title ?></a>
				</li>

				<li role="separator" class="divider"></li>

				<li class="">
					<a href="visitor_carts_listing/<?php if($visitor_stats30->user_id != ''){ echo $visitor_stats30->user_id; } else { echo '0'; } ?>" class="tip" data-placement="left" data-element="user38" title="View/Edit <?php echo $visitor_stats30->page_title ?>"><i class="fa fa-pencil text text-primary"></i> View Cart Logs <?php echo $visitor_stats30->page_title ?></a>
				</li>

			</ul>
		</div>

	</td>
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
              
              <!-- QUATERLY -->
              <div class="tab-pane" id="quater">
                
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
                              <th>Visitor Name</th>
                              <th>IP Address</th>
                              <th>Action</th>
						 </tr>
						</thead>
					 	<tbody>
<?php
$i = 0;
foreach($arrValue['visitor_stats90'] as $visitor_stats90){
	
	$i = $i + 1;
	if($visitor_stats90->user_fname != NULL){ 
		$name = ucwords($visitor_stats90->user_fname.' '.$visitor_stats90->user_lname);
		$email = trim($visitor_stats90->user_email);
		if($email!=''){
			$name .= '( <a target="_blank" href="index.php?controller=user&function=edit&id="'.$visitor_stats90->user_id.'>'.$email.'</a> )';
		}
	} else { $name = 'VISITOR'; }
	
?>
<tr id="user" class="">
	<td><?php echo $i; ?></td>
	<td><?php echo $name; ?></td>
    <td><?php echo trim(stripslashes($visitor_stats90->ip_address)); ?></td>
    <td>
		<div class="dropdown">
			<button id="btn" class="btn btn-fill btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true">
				Actions
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu"  style="right: 0; left: auto;"  aria-labelledby="dropdownMenu">
				<li class="">
					<a href="visitor_stats_listing/<?php if($visitor_stats90->user_id != ''){ echo $visitor_stats90->user_id; } else { echo '0'; } ?>/<?php echo $visitor_stats90->ip_address; ?>" class="tip" data-placement="left" data-element="user38" title="View/Edit <?php echo $visitor_stats90->page_title ?>"><i class="fa fa-pencil text text-primary"></i> View Page Logs <?php echo $visitor_stats90->page_title ?></a>
				</li>

				<li role="separator" class="divider"></li>

				<li class="">
					<a href="visitor_carts_listing/<?php if($visitor_stats90->user_id != ''){ echo $visitor_stats90->user_id; } else { echo '0'; } ?>" class="tip" data-placement="left" data-element="user38" title="View/Edit <?php echo $visitor_stats90->page_title ?>"><i class="fa fa-pencil text text-primary"></i> View Cart Logs <?php echo $visitor_stats90->page_title ?></a>
				</li>

			</ul>
		</div>

	</td>
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
              
              <!-- 6MONTHS -->
              <div class="tab-pane" id="6months">
                
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
                              <th>Visitor Name</th>
                              <th>IP Address</th>
                              <th>Action</th>
						 </tr>
						</thead>
					 	<tbody>
<?php
$i = 0;
foreach($arrValue['visitor_stats180'] as $visitor_stats180){
	
	$i = $i + 1;
	if($visitor_stats180->user_fname != NULL){ 
		$name = ucwords($visitor_stats180->user_fname.' '.$visitor_stats180->user_lname);
		$email = trim($visitor_stats180->user_email);
		if($email!=''){
			$name .= '( <a target="_blank" href="index.php?controller=user&function=edit&id="'.$visitor_stats180->user_id.'>'.$email.'</a> )';
		}
	} else { $name = 'VISITOR'; }
	
?>
<tr id="user" class="">
	<td><?php echo $i; ?></td>
	<td><?php echo $name; ?></td>
    <td><?php echo trim(stripslashes($visitor_stats180->ip_address)); ?></td>
    <td>
		<div class="dropdown">
			<button id="btn" class="btn btn-fill btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true">
				Actions
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu"  style="right: 0; left: auto;"  aria-labelledby="dropdownMenu">
				<li class="">
					<a href="visitor_stats_listing/<?php if($visitor_stats180->user_id != ''){ echo $visitor_stats180->user_id; } else { echo '0'; } ?>/<?php echo $visitor_stats180->ip_address; ?>" class="tip" data-placement="left" data-element="user38" title="View/Edit <?php echo $visitor_stats180->page_title ?>"><i class="fa fa-pencil text text-primary"></i> View Page Logs <?php echo $visitor_stats180->page_title ?></a>
				</li>

				<li role="separator" class="divider"></li>

				<li class="">
					<a href="visitor_carts_listing/<?php if($visitor_stats180->user_id != ''){ echo $visitor_stats180->user_id; } else { echo '0'; } ?>" class="tip" data-placement="left" data-element="user38" title="View/Edit <?php echo $visitor_stats180->page_title ?>"><i class="fa fa-pencil text text-primary"></i> View Cart Logs <?php echo $visitor_stats180->page_title ?></a>
				</li>

			</ul>
		</div>

	</td>
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
              
              <!-- YEAR -->
              <div class="tab-pane" id="1year">
                
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
                              <th>Visitor Name</th>
                              <th>IP Address</th>
                              <th>Action</th>
						 </tr>
						</thead>
					 	<tbody>
<?php
$i = 0;
foreach($arrValue['visitor_stats365'] as $visitor_stats365){
	
	$i = $i + 1;
	if($visitor_stats365->user_fname != NULL){ 
		$name = ucwords($visitor_stats365->user_fname.' '.$visitor_stats365->user_lname);
		$email = trim($visitor_stats365->user_email);
		if($email!=''){
			$name .= '( <a target="_blank" href="index.php?controller=user&function=edit&id="'.$visitor_stats365->user_id.'>'.$email.'</a> )';
		}
	} else { $name = 'VISITOR'; }
	
?>
<tr id="user" class="">
	<td><?php echo $i; ?></td>
	<td><?php echo $name; ?></td>
    <td><?php echo trim(stripslashes($visitor_stats365->ip_address)); ?></td>
    <td>
		<div class="dropdown">
			<button id="btn" class="btn btn-fill btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true">
				Actions
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu"  style="right: 0; left: auto;"  aria-labelledby="dropdownMenu">
				<li class="">
					<a href="visitor_stats_listing/<?php if($visitor_stats365->user_id != ''){ echo $visitor_stats365->user_id; } else { echo '0'; } ?>/<?php echo $visitor_stats365->ip_address; ?>" class="tip" data-placement="left" data-element="user38" title="View/Edit <?php echo $visitor_stats365->page_title ?>"><i class="fa fa-pencil text text-primary"></i> View Page Logs <?php echo $visitor_stats365->page_title ?></a>
				</li>

				<li role="separator" class="divider"></li>

				<li class="">
					<a href="visitor_carts_listing/<?php if($visitor_stats365->user_id != ''){ echo $visitor_stats365->user_id; } else { echo '0'; } ?>" class="tip" data-placement="left" data-element="user38" title="View/Edit <?php echo $visitor_stats365->page_title ?>"><i class="fa fa-pencil text text-primary"></i> View Cart Logs <?php echo $visitor_stats365->page_title ?></a>
				</li>

			</ul>
		</div>

	</td>
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
    
            <!----- OTHER DIVS ------>
              
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
  