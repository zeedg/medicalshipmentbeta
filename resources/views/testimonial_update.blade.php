<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!--- ADD USER CONTENT -->


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Update Testimonial
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-12">
                 <ul class="bg-danger"></ul>            </div>
  </div>
  @foreach ($testimonials as $testimonial)
  <form class="form" action="{{ url('/testimonialedit') }}/{{ $testimonial->testimonial_id }}" enctype="multipart/form-data" id="testimonialform" method='post'>
  <!-- NEW PROFILE -->
  <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="https://help.prospectz.io/wp-content/uploads/2018/12/member.png" alt="USER">

              <h3 class="profile-username text-center">Update Testimonial</h3>

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
                      <h3 class="box-title">Testimonial Information</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="form-horizontal">
                      <div class="box-body">
            			  	
                          <div class="col-md-6 col-xs-12">
                            <label>Name:</label>
                            <input  class='form-control' type='text' name='name' id='name' value='{{ $testimonial->testimonial_name }}' />
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                            <label>Email:</label>
                            <input  class='form-control' type='text' name='email' id='email' value='{{ $testimonial->testimonial_email }}' />
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                            <label>Company:</label>
                            <input  class='form-control' type='text' name='company' id='company' value='{{ $testimonial->testimonial_company }}' />
                          </div>

						  <div class="col-md-12 col-xs-12">
                            <label>Address:</label>
                            <textarea id="address" name="address" placeholder="Address" class="form-control" >{{ $testimonial->testimonial_address }}</textarea>
                          </div>	
							
                          <div class="col-md-12 col-xs-12">
                            <label>Testimonial:</label>
                            <textarea id="testimonial" name="testimonial" placeholder="Testimonial" class="form-control" >{{ $testimonial->testimonial_testimonial }}</textarea>
                          </div>  
                            
						  <div class="col-md-6 col-xs-12">                   
                              <label> Status:</label>
                              <br />
                              <input type="radio" name="status" value="1" <?php if($testimonial->testimonial_status == 1){ echo 'checked="checked"'; } ?>> Enable<br>
							  <input type="radio" name="status" value="0" <?php if($testimonial->testimonial_status == 0){ echo 'checked="checked"'; } ?>> Disable<br>
                          </div>
                            
                          <div class="col-md-6 col-xs-12">
                            <label>Upload Brochure:</label>
                            <input type="file" name="file">
                            <img src="<?php echo url('/uploads/testimonial/'.$testimonial->testimonial_image) ?>" class="img-circle" alt="User Image" width="100px">
                          </div>
                          <input type="hidden" name="testimonial_image" id="testimonial_image" value="{{ $testimonial->testimonial_image }}" />
                          
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
                          <input class='btn btn-primary' name="update_testimonial" type='submit' value='Update' class='submit' />
                          <a class='btn btn-warning' href="{{ url('/testimonialupdate') }}/{{ $testimonial->testimonial_id }}">Reset</a><br><br>
                        
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