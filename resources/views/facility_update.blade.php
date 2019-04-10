<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!--- ADD USER CONTENT -->


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Update Facility
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-12">
                 <ul class="bg-danger"></ul>            </div>
  </div>
  @foreach ($facilities as $facility)
  <form class="form" action="{{ url('/facilityedit') }}/{{ $facility->facility_id }}" enctype="multipart/form-data" id="facilityform" method='post'>
  <!-- NEW PROFILE -->
  <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="https://help.prospectz.io/wp-content/uploads/2018/12/member.png" alt="USER">

              <h3 class="profile-username text-center">Update Facility</h3>

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
                      <h3 class="box-title">Facility Information</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="form-horizontal">
                      <div class="box-body">
            			  	
                          <div class="col-md-6 col-xs-12">
                            <label>Title:</label>
                            <input  class='form-control' type='text' name='title' id='title' value='{{ $facility->facility_title }}' />
                          </div>

						  <div class="col-md-6 col-xs-12">                   
                              <label> Status:</label>
                              <br />
                              <input type="radio" name="status" value="1" <?php if($facility->facility_status == 1){ echo 'checked="checked"'; } ?>> Enable<br>
							  <input type="radio" name="status" value="0" <?php if($facility->facility_status == 0){ echo 'checked="checked"'; } ?>> Disable<br>
                          </div>
                            
                          <div class="col-md-6 col-xs-12">
                            <label>Upload Brochure:</label>
                            <input type="file" name="file">
                            <img src="<?php echo url('/uploads/facility/'.$facility->facility_image) ?>" class="img-circle" alt="User Image" width="100px">
                          </div>
                          <input type="hidden" name="facility_image" id="facility_image" value="{{ $facility->facility_image }}" />
                          
                      </div>
               
                      <!-- /.box-footer -->
                    </div>
                  </div>

                </div>

                <div class="row">
                    
                    
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
                          <input class='btn btn-primary' name="update_facility" type='submit' value='Update' class='submit' />
                          <a class='btn btn-warning' href="{{ url('/facilityupdate') }}/{{ $facility->facility_id }}">Reset</a><br><br>
                        
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