<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!--- ADD USER CONTENT -->


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Add Keyword
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-12">
                 <ul class="bg-danger"></ul>            </div>
  </div>
  <form class="form" action="{{ url('/storekeyword') }}" id="keywordform" method='post'>
  <!-- NEW PROFILE -->
  <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="https://help.prospectz.io/wp-content/uploads/2018/12/member.png" alt="USER">

              <h3 class="profile-username text-center">Add New Keyword</h3>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#setting-info" data-toggle="tab" aria-expanded="true">Settings</a></li>
            </ul>
            <div class="tab-content">


              <div class="tab-pane active" id="setting-info">


                <div class="">
                  <!-- Horizontal Form -->
                  <div class="box box-success">
                    <div class="box-header with-border">
                      <h3 class="box-title">Keyword Information</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="form-horizontal">
                      <div class="box-body">
            			  
                          <div class="col-md-6 col-xs-12">
                            <label>Keyword:</label>
                            <input  class='form-control' type='text' name='keyword' id='keyword' value='' />
                          </div>

                      </div>
               
                      <!-- /.box-footer -->
                    </div>
                  </div>

                </div>

                <div class="row">
                    
                  <div class="col-md-12 col-xs-12">
                      <!-- Horizontal Form -->
                      <div class="box box-danger">
                        <div class="box-header with-border">
                          <h3 class="box-title">Categories List:</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="form-horizontal">
                          <div class="box-body">
                              
	<?php			
	foreach($categories as $mfa){
	$sqla = DB::select("select * from category where category_parent='".$mfa->category_id."' order by category_title asc");
	?>
  <div class="col-md-12 col-xs-12">
  <div class="col-md-12 col-xs-12">
	  <input type="checkbox" name="categories[]" value="<?php echo stripslashes($mfa->category_id)?>" id="<?php echo stripslashes($mfa->category_id)?>" />
	  <label for="<?php echo stripslashes($mfa->category_id)?>" style="font-size:20px;"><strong><?php echo stripslashes($mfa->category_title)?></strong></label></div>
	<?php 
		//if($num > 0){
			foreach($sqla as $mfas){	
			?>
	<div class="col-md-6 col-xs-6">
	  <input type="checkbox" name="categories[]" value="<?php echo stripslashes($mfas->category_id)?>" id="<?php echo stripslashes($mfas->category_id)?>" />
	  <label for="<?php echo stripslashes($mfas->category_id)?>"><?php echo stripslashes($mfas->category_title)?></label>
	</div>
	<?php 
			}
		//}
?>

                  </div>
                  <div class="col-md-12 col-xs-12">&nbsp;</div>
                  <?php		 
						}

				?>  	
                          
                          </div>
                          <!-- /.box-footer -->
                        </div>
                      </div>
                      <!-- /.box -->
                    </div> 
                    
                  <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="box box-info">
                      <div class="box-header with-border">
                        <h3 class="box-title">Confirm Changes - Action</h3>
                      </div>
                      <!-- /.box-header -->
                      <!-- form start -->
                      <div class="form-horizontal">
                        <div class="box-body">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                          <input class='btn btn-primary' name="add_keyword" type='submit' value='Submit' class='submit' />
                          <a class='btn btn-warning' href="{{ url('/addkeyword') }}">Reset</a><br><br>
                        
                        </div>
                        <!-- /.box-footer -->
                      </div>
                    </div>
                    <!-- /.box -->
                  </div>

                </div>

              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
  <!-- END NEW PROFILE -->
  </from>

  <!-- /.row -->
</section>
<!-- /.content -->

<!------- footer ------>
@include('footer')