<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!--- ADD USER CONTENT -->


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Edit Product Price
  </h1>
</section>
<?php


?>


<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-12">
                 <ul class="bg-danger"></ul>            </div>
  </div>
  <form class="form" action="{{ url('product/update') }}" id="registerform" method='post'>
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
                      <h3 class="box-title">Edit Product Price</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="form-horizontal">
                      <div class="box-body">
                    
                          <div class="col-md-6 col-xs-12">
                              <label>Product:</label>
                              <input disabled class='form-control' type='text' name='product_title' id='product_title' value="{{$products[0]->product_title}}" />
                          </div>

						  <div class="col-md-6 col-xs-12">
                              <label>Item Number:</label>
                              <input disabled class='form-control' type='text' name='product_item_no' id='product_item_no' value="{{$products[0]->product_item_no}}" />
                          </div>	
                            
                          <div class="col-md-6 col-xs-12">
                            <label>Update Price: </label>
                            <input  class='form-control' type='text' name='product_price' id='product_price' value="{{$products[0]->product_price}}" />
                            <input  class='form-control' type='hidden' name='update' id='update' value="price_only" />
                            <input  class='form-control' type='hidden' name='product_id' id='product_id' value="{{$products[0]->product_id}}" />
                          </div>				
                          
                          
                          <div class="col-md-6 col-xs-12">
                            <label>Enter Special Price:</label>
                            <input class='form-control' type='text' name='product_sprice' id='product_sprice' value="<?php echo ($products[0]->product_sprice != '')?$products[0]->product_sprice:''; ?>" />
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
                          <input class='btn btn-primary' name="add_customer" type='submit' value='Update' class='submit' />
                          <a class='btn btn-warning' href="{{ url('/addcustomer') }}">Reset</a><br><br>
                        
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