<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!--- ADD USER CONTENT -->

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Add Address
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-12">
    	<ul class="bg-danger"></ul>
    </div>
  </div>
  
  <form class="form" action="{{ url('/ubs/store') }}" id="ubsform" enctype="multipart/form-data" method='post'>
  <!-- NEW PROFILE -->
  <div class="row">     
        <div class="col-md-12">
          <div class="nav-tabs-custom">           
            <div class="tab-content">

              <div class="tab-pane active" id="setting-info">

                <div class="">
                  <!-- Horizontal Form -->
                  <div class="box box-success">
                    <div class="box-header with-border">
                      <h3 class="box-title">Add Address</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="form-horizontal">
                      <div class="box-body">
                    
                    	  <div class="col-md-6 col-xs-12">
                              <label>Address Type</label>
                              <select class="form-control" id='type' name='type' required>
                                <option value="billing">Billing</option>
                                <option value="shipping">Shipping</option>
                              </select>
                          </div>
                          	
                          <div class="col-md-6 col-xs-12">
                              <label>First Name:</label>
                              <input  class='form-control' type='text' name='first_name' id='first_name' value='' />
                          </div>

						  <div class="col-md-6 col-xs-12">
                              <label>Last Name:</label>
                              <input  class='form-control' type='text' name='last_name' id='last_name' value='' />
                          </div>	
                            
                          <div class="col-md-6 col-xs-12">
                            <label>Phone Number: </label>
                            <input  class='form-control' type='text' name='phone_number' id='phone_number' value='' />
                          </div>				
                          
                          
                          <div class="col-md-6 col-xs-12">
                            <label>Zip Code:</label>
                            <input class='form-control' type='text' name='zip_code' id='zip_code' value='' />
                          </div>
						
                          <div class="col-md-6 col-xs-12">
                              <label>City:</label>
                              <input  class='form-control' type='text' name='city' id='city' value='' />
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>State</label>
                              <select class="form-control" name="state" id="state" required>
                                    
                                    <option value="">United States / Canada</option>
                                    
                                    <option style="font-size:16px;background-color:#00478f;color:#FFF;height:40px !important;" value="Sold Out">United States</option>
                                                                                    
                                        <option class="option" value="AL_US">Alabama</option>
                                    
                                                                                    
                                        <option class="option" value="AK_US">Alaska</option>
                                    
                                                                                    
                                        <option class="option" value="AZ_US">Arizona</option>
                                    
                                                                                    
                                        <option class="option" value="AR_US">Arkansas</option>
                                    
                                                                                    
                                        <option class="option" value="CA_US">California</option>
                                    
                                                                                    
                                        <option class="option" value="CO_US">Colorado</option>
                                    
                                                                                    
                                        <option class="option" value="CT_US">Connecticut</option>
                                    
                                                                                    
                                        <option class="option" value="DE_US">Delaware</option>
                                    
                                                                                    
                                        <option class="option" value="DC_US">District of Columbia</option>
                                    
                                                                                    
                                        <option class="option" value="FL_US">Florida</option>
                                    
                                                                                    
                                        <option class="option" value="GA_US">Georgia</option>
                                    
                                                                                    
                                        <option class="option" value="HI_US">Hawaii</option>
                                    
                                                                                    
                                        <option class="option" value="ID_US">Idaho</option>
                                    
                                                                                    
                                        <option class="option" value="IL_US">Illinois</option>
                                    
                                                                                    
                                        <option class="option" value="IN_US">Indiana</option>
                                    
                                                                                    
                                        <option class="option" value="IA_US">Iowa</option>
                                    
                                                                                    
                                        <option class="option" value="KS_US">Kansas</option>
                                    
                                                                                    
                                        <option class="option" value="KY_US">Kentucky</option>
                                    
                                                                                    
                                        <option class="option" value="LA_US">Louisiana</option>
                                    
                                                                                    
                                        <option class="option" value="ME_US">Maine</option>
                                    
                                                                                    
                                        <option class="option" value="MD_US">Maryland</option>
                                    
                                                                                    
                                        <option class="option" value="MA_US">Massachusetts</option>
                                    
                                                                                    
                                        <option class="option" value="MI_US">Michigan</option>
                                    
                                                                                    
                                        <option class="option" value="MN_US">Minnesota</option>
                                    
                                                                                    
                                        <option class="option" value="MS_US">Mississippi</option>
                                    
                                                                                    
                                        <option class="option" value="MO_US">Missouri</option>
                                    
                                                                                    
                                        <option class="option" value="MT_US">Montana</option>
                                    
                                                                                    
                                        <option class="option" value="NE_US">Nebraska</option>
                                    
                                                                                    
                                        <option class="option" value="NV_US">Nevada</option>
                                    
                                                                                    
                                        <option class="option" value="NH_US">New Hampshire</option>
                                    
                                                                                    
                                        <option class="option" value="NJ_US">New Jersey</option>
                                    
                                                                                    
                                        <option class="option" value="NM_US">New Mexico</option>
                                    
                                                                                    
                                        <option class="option" value="NY_US">New York</option>
                                    
                                                                                    
                                        <option class="option" value="NC_US">North Carolina</option>
                                    
                                                                                    
                                        <option class="option" value="ND_US">North Dakota</option>
                                    
                                                                                    
                                        <option class="option" value="OH_US">Ohio</option>
                                    
                                                                                    
                                        <option class="option" value="OK_US">Oklahoma</option>
                                    
                                                                                    
                                        <option class="option" value="OR_US">Oregon</option>
                                    
                                                                                    
                                        <option class="option" value="PA_US">Pennsylvania</option>
                                    
                                                                                    
                                        <option class="option" value="RI_US">Rhode Island</option>
                                    
                                                                                    
                                        <option class="option" value="SC_US">South Carolina</option>
                                    
                                                                                    
                                        <option class="option" value="SD_US">South Dakota</option>
                                    
                                                                                    
                                        <option class="option" value="TN_US">Tennessee</option>
                                    
                                                                                    
                                        <option class="option" value="TX_US">Texas</option>
                                    
                                                                                    
                                        <option class="option" value="UT_US">Utah</option>
                                    
                                                                                    
                                        <option class="option" value="VT_US">Vermont</option>
                                    
                                                                                    
                                        <option class="option" value="VA_US">Virginia</option>
                                    
                                                                                    
                                        <option class="option" value="WA_US">Washington</option>
                                    
                                                                                    
                                        <option class="option" value="WV_US">West Virginia</option>
                                    
                                                                                    
                                        <option class="option" value="WI_US">Wisconsin</option>
                                    
                                                                                    
                                        <option class="option" value="WY_US">Wyoming</option>
                                    
                                                                                    
                                    <option style="font-size:16px;background-color:#00478f;color:#FFF;height:40px !important;" value="Sold Out">Canada</option>
                                                                                    
                                        <option class="option" value="AB_CA">Alberta</option>
                                    
                                                                                    
                                        <option class="option" value="BC_CA">British Columbia</option>
                                    
                                                                                    
                                        <option class="option" value="MB_CA">Manitoba</option>
                                    
                                                                                    
                                        <option class="option" value="NB_CA">New Brunswick</option>
                                    
                                                                                    
                                        <option class="option" value="NF_CA">Newfoundland</option>
                                    
                                                                                    
                                        <option class="option" value="NT_CA">Northwest Territories</option>
                                    
                                                                                    
                                        <option class="option" value="NS_CA">Nova Scotia</option>
                                    
                                                                                    
                                        <option class="option" value="NU_CA">Nunavut</option>
                                    
                                                                                    
                                        <option class="option" value="ON_CA">Ontario</option>
                                    
                                                                                    
                                        <option class="option" value="PE_CA">Prince Edward Island</option>
                                    
                                                                                    
                                        <option class="option" value="QC_CA">Quebec</option>
                                    
                                                                                    
                                        <option class="option" value="SK_CA">Saskatchewan</option>
                                    
                                                                                    
                                        <option class="option" value="YT_CA">Yukon Territory</option>
                                    
                                                                                    
                                </select>
                          </div>                       
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Address:</label>
                              <textarea  class='form-control' name='address' id='address' value='' /></textarea>
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Address Type</label>
                              <select class="form-control" id='address_type' name='address_type' required>
                                <option value="Choose Type">Choose Type</option>
                                <option value="Educational">Educational</option>
                                <option value="Residential">Residential</option>
                                <option value="Commercial">Commercial</option>
                              </select>
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Special Shipping Directions:</label>
                              <input  class='form-control' type='text' name='shipping_directions' id='shipping_directions' value='' />
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Make Default:</label>
                              <input  type='checkbox' name='make_default' id='make_default' value='1'>
                          </div>

                      </div>
               
                      <!-- /.box-footer -->
                    </div>
                  </div>

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
                          <input class='btn btn-primary' name="add_ubs" type='submit' value='Submit Button' class='submit' />
                          <a class='btn btn-warning' href="{{ url('/addubs') }}">Cancel</a><br><br>
                        
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