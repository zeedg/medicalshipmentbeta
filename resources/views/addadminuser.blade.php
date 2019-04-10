<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!--- ADD USER CONTENT -->




<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Add Admin User's Account Information
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-12">
                 <ul class="bg-danger"></ul>            </div>
  </div>
  <form class="form" action="{{ url('/registeradminuser') }}" id="registerform" method='post'>
  <!-- NEW PROFILE -->
  <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="https://help.prospectz.io/wp-content/uploads/2018/12/member.png" alt="USER">

              <h3 class="profile-username text-center">Add New Admin User</h3>

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
            			  	
                          <div class="col-md-6 col-xs-12">
                              <label>First Name:</label>
                              <input  class='form-control' type='text' name='first_name' id='first_name' value='' />
                          </div>

						  <div class="col-md-6 col-xs-12">
                              <label>Last Name:</label>
                              <input  class='form-control' type='text' name='last_name' id='last_name' value='' />
                          </div>	
							
                          <div class="col-md-6 col-xs-12">
                              <label>User Name:</label>
                              <input  class='form-control' type='text' name='user_name' id='user_name' value='' />
                          </div>  
                            
                          <div class="col-md-6 col-xs-12">
                              <label>Email:</label>
                              <input  class='form-control' type='text' name='user_email' id='user_email' value='' />
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Password:</label>
                              <input  class='form-control' type='password' name='password' id='password' value='' />
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
                              <input type="radio" name="status" value="1"> Enable<br>
							  <input type="radio" name="status" value="0"> Disable<br>
                          
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
                          <input class='btn btn-primary' name="add_adminuser" type='submit' value='Submit' class='submit' />
                          <a class='btn btn-warning' href="{{ url('/addadminuser') }}">Reset</a><br><br>
                        
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