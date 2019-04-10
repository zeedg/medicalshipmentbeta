<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!--- ADD USER CONTENT -->


<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Add Category
	</h1>
</section>

<!-- Main content -->
<section class="content">
	
	<div class="row">
		<div class="col-md-12">
			<ul class="bg-danger"></ul>
		</div>
	</div>
	<form class="form" action="{{ url('/storecategory') }}" enctype="multipart/form-data" id="categoryform" method='post'>
		<!-- NEW PROFILE -->
		<div class="row">
			<div class="col-md-3">
				
				<!-- Profile Image -->
				<div class="box box-primary">
					<div class="box-body box-profile">
						<img class="profile-user-img img-responsive img-circle" src="https://help.prospectz.io/wp-content/uploads/2018/12/member.png" alt="USER">
						
						<h3 class="profile-username text-center">Add New Category</h3>
					
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
													<option value="<?php echo $category[ 'category_id' ]; ?>"><?php echo trim(stripslashes($category[ 'category_title' ])); ?></option>
							<?php } ?>
												</select>
											</div>
											
											<div class="col-md-6 col-xs-12">
												<label>Title:</label>
												<input class='form-control' type='text' name='title' id='title' value=''/>
											</div>
											
											<div class="col-md-6 col-xs-12">
												<label>Slug:</label>
												<input class='form-control' type='text' name='slug' id='slug' readonly="readonly" required/>
												<button onclick="createSlug(0)" type="button" class="btn btn-link">Create Slug</button>
											</div>
											
											<div class="form-group" id="slug_view" style="display:none;"></div>
											
											<div class="col-md-6 col-xs-12">
												<label>Sort Type</label>
												<select class="form-control" id='category_sort' name='category_sort' required>
													<option value="product_id desc">Product (ID) Desc</option>
													<option value="product_id asc">Product (ID) ASC</option>
													<option value="product_title asc">Product (Title) ASC</option>
													<option value="product_title desc">Product (Title) DESC</option>
													<option value="product_price asc">Price (Low to High)</option>
													<option value="product_price desc">Price (High to Low)</option>
													<option value="product_position asc">Custom Position</option>
												</select>
											</div>
											
											<div class="col-md-12 col-xs-12">
												<label>Detail:</label>
												<textarea id="detail" name="detail" placeholder="Detail" class="form-control"></textarea>
											</div>
											
											<div class="col-md-6 col-xs-12">
												<label>File Input:</label>
												<input type="file" name="file">
											</div>
										
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
												<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
												<input class='btn btn-primary' name="add_category" type='submit' value='Submit' class='submit'/>
												<a class='btn btn-warning' href="{{ url('/addcategory') }}">Reset</a><br><br>
											
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