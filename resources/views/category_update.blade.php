<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!--- ADD USER CONTENT -->


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Update Category
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-12">
                 <ul class="bg-danger"></ul>            </div>
  </div>
  @foreach ($categories2 as $category2)
  <form class="form" action="{{ url('/categoryedit') }}/{{ $category2->category_id }}" enctype="multipart/form-data" id="categoryform" method='post'>
  <!-- NEW PROFILE -->
  <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="https://help.prospectz.io/wp-content/uploads/2018/12/member.png" alt="USER">

              <h3 class="profile-username text-center">Update Category</h3>

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
                      <h3 class="box-title">Category Information</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="form-horizontal">
                      <div class="box-body">
            			  
                          <div class="col-md-6 col-xs-12">
                              <label>Category</label>
                              <select class="form-control" id='category' name='category' required>
                                <?php
                                foreach ($categories as $category){
								?>
                                <option value="<?php echo $category['category_id']; ?>" 
								<?php if($category2->category_parent == $category['category_id']){ echo 'selected'; } ?>><?php echo $category['category_title']; ?></option>
                                <?php } ?>
                              </select>
                          </div>
                          	
                          <div class="col-md-6 col-xs-12">
                            <label>Title:</label>
                            <input  class='form-control' type='text' name='title' id='title' value='{{ $category2->category_title }}' />
                          </div>

                          <div class="col-md-6 col-xs-12">
                              <label>Slug:</label>
                              <input  class='form-control' type='text' name='slug' id='slug' readonly="readonly" required value='<?php echo $category2->category_slug; ?>' />
                              <button onclick="createSlug('<?php echo intval($category2->category_id); ?>')" type="button" class="btn btn-link">Create Slug</button>
                          </div>
							
                          <div class="form-group" id="slug_view" style="display:none;"></div>  
                            
						  <div class="col-md-6 col-xs-12">
                              <label>Sort Type</label>
                              <select class="form-control" id='category_sort' name='category_sort' required>
                                <option value="product_id desc" <?php if($category2->category_sort == 'product_id desc'){ echo 'selected'; } ?>>Product (ID) Desc</option>
                                <option value="product_id asc" <?php if($category2->category_sort == 'product_id asc'){ echo 'selected'; } ?>>Product (ID) ASC</option>
                                <option value="product_title asc" <?php if($category2->category_sort == 'product_title asc'){ echo 'selected'; } ?>>Product (Title) ASC</option>
                                <option value="product_title desc" <?php if($category2->category_sort == 'product_title desc'){ echo 'selected'; } ?>>Product (Title) DESC</option>
                                <option value="product_price asc" <?php if($category2->category_sort == 'product_price asc'){ echo 'selected'; } ?>>Price (Low to High)</option>
                                <option value="product_price desc" <?php if($category2->category_sort == 'product_price desc'){ echo 'selected'; } ?>>Price (High to Low)</option>
                                <option value="product_position asc" <?php if($category2->category_sort == 'product_position asc'){ echo 'selected'; } ?>>Custom Position</option>
                              </select>
                          </div>
							
                          <div class="col-md-12 col-xs-12">
                            <label>Detail:</label>
                            <textarea id="detail" name="detail" placeholder="Detail" class="form-control" required=""><?php echo $category2->category_detail; ?></textarea>
                          </div>
                          
                          <div class="col-md-6 col-xs-12">
                            <label>File Input:</label>
                            <input type="file" name="file">
                            <img src="<?php echo url('/uploads/category/').'/'.$category2->category_image ?>" class="img-circle" alt="User Image" width="100px">
                          </div>
                          <input type="hidden" name="category_image" id="category_image" value="{{ $category2->category_image }}" />
                          
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
                          <input class='btn btn-primary' name="update_category" type='submit' value='Update Category' class='submit' />
                          <a class='btn btn-warning' href="{{ url('/categoryupdate') }}/{{ $category2->category_id }}">Cancel</a><br><br>
                        
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