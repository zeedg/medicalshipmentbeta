<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!--- ADD USER CONTENT -->

<?php //print_r($reviews); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Edit Review
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-12">
        <ul class="bg-danger"></ul>
    </div>
  </div>
  <form class="form" action="{{ url('/review/update') }}" id="registerform" method='post'>
  <!-- NEW PROFILE -->
  <div class="row">
             <!-- /.col -->
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <div class="tab-content">


              <div class="tab-pane active" id="setting-info">


                <div class="">
                  <!-- Horizontal Form -->
                  <div class="box box-success">
                    <div class="box-header with-border">
                      <h3 class="box-title">Review Detail</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="form-horizontal">
                      <div class="box-body">
            			  
                          	
                          <div class="col-md-6 col-xs-12">
                            <label>User: </label>
                            <input disabled class='form-control' type='text' name='company_name' id='company_name' value='<?php echo ($reviews[0]->user_email != '')?$reviews[0]->user_email:''; ?>' />
                          </div>

                          <div class="col-md-6 col-xs-12">
                              <label>Product Name:</label>
                              <input disabled class='form-control' type='text' name='contact_first_name' id='contact_first_name' value='<?php echo ($reviews[0]->product_title != '')?$reviews[0]->product_title:''; ?>' />
                          </div>

						            <div class="col-md-6 col-xs-12">
                              <label>Product Item#</label>
                              <input disabled class='form-control' type='text' name='contact_last_name' id='contact_last_name' value='<?php echo ($reviews[0]->product_item_no != '')?$reviews[0]->product_item_no:''; ?>' />
                              <input class='form-control' type='hidden' name='rew_id' id='rew_id' value='<?php echo ($reviews[0]->rew_id != '')?$reviews[0]->rew_id:''; ?>' />
                          </div>	
							
                          <div class="col-md-6 col-xs-12">
                            <label>Rating: </label>
                            <select class='form-control' name="rew_rating">
                              <option <?php echo ($reviews[0]->rew_rating == '0')?'selected':'';?> value="1">Rate Us</option>
                              <option <?php echo ($reviews[0]->rew_rating == '1')?'selected':'';?> value="1">1</option>
                              <option <?php echo ($reviews[0]->rew_rating == '2')?'selected':'';?> value="2">2</option>
                              <option <?php echo ($reviews[0]->rew_rating == '3')?'selected':'';?> value="3">3</option>
                              <option <?php echo ($reviews[0]->rew_rating == '4')?'selected':'';?> value="4">4</option>
                              <option <?php echo ($reviews[0]->rew_rating == '5')?'selected':'';?> value="5">5</option>
                            </select>
                          </div>					
                          <div class="col-md-12 col-xs-12">
                              <label>Comments:</label>
                              <textarea class='form-control' id="review_comments" name="rew_comment"><?php echo (trim($reviews[0]->rew_comment) != '')?trim($reviews[0]->rew_comment):''?></textarea>
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

                              <input type="radio" name="rew_status" <?php echo ($reviews[0]->rew_status == '1') ? 'checked':'' ; ?> value="1"> Enable<br>
							                <input type="radio" name="rew_status" <?php echo ($reviews[0]->rew_status == '0')?'checked':''; ?> value="0"> Disable<br>
                          
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
                          <input class='btn btn-primary' name="add_customer" type='submit' value='Update' class='submit' />
                          <a class='btn btn-warning' href="{{ url('/review') }}">Reset</a><br><br>
                        
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