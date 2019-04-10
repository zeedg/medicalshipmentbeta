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
  
  <!--<form class="form" action="{{ url('/ubs/store') }}" id="ubsform" enctype="multipart/form-data" method='post'>-->
  <form enctype="multipart/form-data" class="col s12" method="post" autocomplete="off" action="<?= (isset($data)) ? action('UbsController@update', ['id' => $data->bsa_id]) : action('UbsController@store'); ?>">
  <input type="hidden" name="_token" value="<?= csrf_token() ?>"/>
  <input name="_method" type="hidden" value="<?= (isset($data)) ? 'PATCH' : 'POST'; ?>">
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
                    	  <div style="display:none;">
                 <input type="text" name="user_id" id="user_id" value="<?php if(isset($data)){ echo $data->user_id; } else { echo '9993'; } ?>" />
                    	  </div>
                          <div class="col-md-6 col-xs-12">
                              <label>Address Type</label>
                              <select class="form-control" id='bsa_type' name='bsa_type' required>
                                <option value="billing" <?php if(isset($data)){ if($data->bsa_type == 'billing'){ ?> selected="selected" <?php } } ?>>Billing</option>
              					<option value="shipping" <?php if(isset($data)){ if($data->bsa_type == 'shipping'){ ?> selected="selected" <?php } } ?>>Shipping</option>
                              </select>
                          </div>
                          	
                          <div class="col-md-6 col-xs-12">
                              <label>First Name:</label>
                              <input  class='form-control' type='text' name='bsa_fname' id='bsa_fname' value='<?php if(isset($data)){ echo $data->bsa_fname; } ?>' />
                          </div>

						  <div class="col-md-6 col-xs-12">
                              <label>Last Name:</label>
                              <input  class='form-control' type='text' name='bsa_lname' id='bsa_lname' value='<?php if(isset($data)){ echo $data->bsa_lname; } ?>' />
                          </div>	
                            
                          <div class="col-md-6 col-xs-12">
                            	<label>Phone Number: </label>
                        		<input  class='form-control' type='text' name='bsa_phone' id='bsa_phone' value='<?php if(isset($data)){ echo $data->bsa_phone; } ?>' />
                          </div>				
                          
                          
                          <div class="col-md-6 col-xs-12">
                            <label>Zip Code:</label>
                            <input class='form-control' type='text' name='bsa_zip' id='bsa_zip' value='<?php if(isset($data)){ echo $data->bsa_zip; } ?>' />
                          </div>
						
                          <div class="col-md-6 col-xs-12">
                              <label>City:</label>
                              <input  class='form-control' type='text' name='bsa_city' id='bsa_city' value='<?php if(isset($data)){ echo $data->bsa_city; } ?>' />
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>State</label>
                              <select class="form-control" name="bsa_country" id="bsa_country" required>
                                    
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
                              <label>State</label>
                              <select class="form-control" name="bsa_state" id="bsa_state" required>
                                    
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
                              <textarea  class='form-control' name='bsa_address' id='bsa_address' /><?php if(isset($data)){ echo $data->bsa_address; } ?></textarea>
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Address Type</label>
                              <select class="form-control" id='bsa_address_type' name='bsa_address_type' required>
                                <option value="Choose Type">Choose Type</option>
                                <option value="Educational" <?php if(isset($data)){ if($data->bsa_address_type == 'Educational'){ ?> selected="selected" <?php } } ?>>Educational</option>
                                <option value="Residential" <?php if(isset($data)){ if($data->bsa_address_type == 'Residential'){ ?> selected="selected" <?php } } ?>>Residential</option>
                                <option value="Commercial" <?php if(isset($data)){ if($data->bsa_address_type == 'Commercial'){ ?> selected="selected" <?php } } ?>>Commercial</option>
                              </select>
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Special Shipping Directions:</label>
                              <input  class='form-control' type='text' name='bsa_ship_dir' id='bsa_ship_dir' value='<?php if(isset($data)){ echo $data->bsa_ship_dir; } ?>' />
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                              <label>Make Default:</label>
                              <input  type='checkbox' name='bsa_default' id='bsa_default' value='1' <?php if(isset($data)){ ?> checked="checked" <?php } ?>>
                          </div>
							
                          <input type="hidden" name="bsa_date" id="bsa_date" value="<?php echo date('Y-m-d H:i:s'); ?>" />  
                            
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
                          <input class='btn btn-primary' name="add_ubs" type='submit' value='Submit' class='submit' />
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