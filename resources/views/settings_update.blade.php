<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!--- ADD USER CONTENT -->

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Update Site Settings
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-12">
                 <ul class="bg-danger"></ul>            </div>
  </div>
  <?php
  foreach ($arrData as $arrData){
  
  ?>
  <form class="form" action="{{ url('settingsedit/1') }}" id="registerformadmin" method='post'>
  <!-- NEW PROFILE -->
  <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="https://help.prospectz.io/wp-content/uploads/2018/12/member.png" alt="USER">

              <h3 class="profile-username text-center">Update Site Settings</h3>

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
                      <h3 class="box-title">Site Information</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    
                    <div class="form-horizontal">
                      <div class="box-body">
            			  
                          <div class="col-md-6 col-xs-12">
                              <label>Site Email</label>
                              <input class="form-control" name="site_email" value="<?php echo $arrData['site_email'] ?>" required>
                          </div>

						  <div class="col-md-6 col-xs-12">
                              <label>Payment Email</label>
                              <input class="form-control" name="payment_email" value="<?php echo $arrData['payment_email'] ?>" required>
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Phone1</label>
                              <input class="form-control" name="site_phone1" value="<?php echo $arrData['site_phone1'] ?>" required>
                          </div>	
							
                          <div class="col-md-6 col-xs-12">
                              <label>Phone2</label>
                              <input class="form-control" name="site_phone2" value="<?php echo $arrData['site_phone2'] ?>" required>
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Address1</label>
                           	  <textarea class="form-control" spellcheck="false" rows="3" name="site_address1"><?php echo $arrData['site_address1'] ?></textarea>
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Address2</label>
                              <textarea class="form-control" spellcheck="false" rows="3" name="site_address2"><?php echo $arrData['site_address2']?></textarea>
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Free Shipping Limit</label>
                              <input class="form-control" name="free_ship_limit" value="<?php echo $arrData['free_ship_limit'] ?>" required>
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>UPS Access Number</label>
                              <input class="form-control" name="ups_accessnumber" value="<?php echo $arrData['ups_accessnumber'] ?>" required>
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>UPS Username</label>
                              <input class="form-control" name="ups_username" value="<?php echo $arrData['ups_username'] ?>" required>
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>UPS Password</label>
                              <input class="form-control" name="ups_password" value="<?php echo $arrData['ups_password'] ?>" required>
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>UPS Shipper Number</label>
                              <input class="form-control" name="ups_shippernumber" value="<?php echo $arrData['ups_shippernumber'] ?>" required>
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Facebook</label>
                              <input class="form-control" name="facebook" value="<?php echo $arrData['facebook'] ?>">
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Google+</label>
                              <input class="form-control" name="google" value="<?php echo $arrData['google'] ?>">
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Twitter</label>
                              <input class="form-control" name="twitter" value="<?php echo $arrData['twitter'] ?>">
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>LinkedIn</label>
                              <input class="form-control" name="inn" value="<?php echo $arrData['inn'] ?>">
                          </div>
                          
                          <input type="hidden" name="id" value="<?php echo $arrData['id'] ?>" />

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
                          <input class='btn btn-primary' name="update_settings" type='submit' value='Update' class='submit' />
                          <a class='btn btn-warning' href="{{ url('/settingsshow') }}/<?php echo $arrData['id'] ?>">Reset</a><br><br>
                        
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
<?php } ?>








  <!-- /.row -->
</section>
<!-- /.content -->

<!------- footer ------>
@include('footer')