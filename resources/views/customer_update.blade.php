<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!--- ADD USER CONTENT -->

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Update Customer's Account Information
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-12">
                 <ul class="bg-danger"></ul>            </div>
  </div>
  @foreach ($users as $user)
  <form class="form" action="{{ url('/customeredit') }}/{{ $user->user_id }}" id="registerform" method='post'>
  <!-- NEW PROFILE -->
  <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="https://help.prospectz.io/wp-content/uploads/2018/12/member.png" alt="USER">

              <h3 class="profile-username text-center">Update Customer</h3>

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
                      <h3 class="box-title">Personal Information</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    
                    <div class="form-horizontal">
                      <div class="box-body">
            			  
                          @if($user->cg_id == 1)         
						  	<?php $selected = 'selected' ?>
                          @else        
						  	<?php $selected = '' ?>
                          @endif
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Tax Class</label>
                              <select class="form-control" id='tax_class' name='tax_class' required>
                                <option value="1" <?php echo $selected ?>>Group A</option>
                              </select>
                          </div>
                          	
                          <div class="col-md-6 col-xs-12">
                            <label>Company Name:</label>
                            <input  class='form-control' type='text' name='company_name' id='company_name' value='{{ $user->user_company }}' />
                          </div>

                          <div class="col-md-6 col-xs-12">
                              <label>Contact First Name:</label>
                              <input  class='form-control' type='text' name='contact_first_name' id='contact_first_name' value='{{ $user->user_fname }}' />
                          </div>

						  <div class="col-md-6 col-xs-12">
                              <label>Contact Last Name:</label>
                              <input  class='form-control' type='text' name='contact_last_name' id='contact_last_name' value='{{ $user->user_lname }}' />
                          </div>	
							
                          <div class="col-md-6 col-xs-12">
                            <label>Position at Company:</label>
                            <input class='form-control' type='text' name='position_at_company' id='position_at_company' value='{{ $user->user_pcompany }}' />
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                            <label>Phone Number:</label>
                            <input class='form-control' type='text' name='phone_number' id='phone_number' value='{{ $user->user_phone }}' />
                          </div>
						
                          <div class="col-md-6 col-xs-12">
                              <label>Email:</label>
                              <input  class='form-control' type='text' name='email' id='email' value='{{ $user->user_email }}' />
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Fax Number:</label>
                              <input  class='form-control' type='text' name='fax_number' id='fax_number' value='{{ $user->user_fax }}' />
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Facility Type</label>
                              <select class="form-control" id='facility_type' name='facility_type' required>
                                <option value="Choose Type">Choose Type</option>
                                <option value="1" <?php if($user->user_facility == 1){ echo 'selected'; } ?>>Facility A</option>
                                <option value="2" <?php if($user->user_facility == 2){ echo 'selected'; } ?>>Facility B</option>
                                <option value="3" <?php if($user->user_facility == 3){ echo 'selected'; } ?>>Facility C</option>
                              </select>
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Name of GPO Affiliation(if applicable):</label>
                              <input  class='form-control' type='text' name='gpo' id='gpo' value='{{ $user->user_gpo }}' />
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Password:</label>
                              <input  class='form-control' type='password' name='password' id='password' value='{{ $user->user_password }}' />
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
                          <h3 class="box-title">Miscellaneous:</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="form-horizontal">
                          <div class="box-body">
                              
                              <label> Status:</label>
                              <br />
                              <input type="radio" name="status" value="1" <?php if($user->user_status == 1){ echo 'checked="checked"'; } ?>> Enable<br>
							  <input type="radio" name="status" value="0" <?php if($user->user_status == 0){ echo 'checked="checked"'; } ?>> Disable<br>
                          
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
                          <input class='btn btn-primary' name="update_customer" type='submit' value='Update' class='submit' />
                          <a class='btn btn-warning' href="{{ url('/customerupdate') }}/{{ $user->user_id }}">Reset</a><br><br>
                        
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
@endforeach








  <!-- /.row -->
</section>
<!-- /.content -->

<!------- footer ------>
@include('footer')