<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!--- ADD USER CONTENT -->


<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Osco Settings
	</h1>
</section>

<!-- Main content -->
<section class="content">
	
	<div class="row">
		<div class="col-md-12">
			<ul class="bg-danger"></ul>
		</div>
	</div>
	<form class="form" action="{{ action('OscoSettingsController@update'  , $record['id']) }}" id="registerform" method='post'>
	{{ method_field('PATCH') }}
	{{csrf_field()}}
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
												<label>User Name:</label>
												<input class='form-control' type='text' name='user_name' id='user_name' value='<?= (isset($record[ 'user_name' ])) ? $record[ 'user_name' ]: ''; ?>'/>
											</div>
											
											<div class="col-md-6 col-xs-12">
												<label>Password:</label>
												<input class='form-control' type='password' name='password' id='password' value='<?= (isset($record[ 'password' ])) ? $record[ 'password' ]: ''; ?>'/>
											</div>
										
											<div class="col-md-6 col-xs-12">
												<label>shipment number:</label>
												<input class='form-control' type='text' name='shipper_number' id='shipper_number' value='<?= (isset($record[ 'shipper_number' ])) ? $record[ 'shipper_number' ]: ''; ?>'/>
											</div>
										
											<div class="col-md-6 col-xs-12">
												<label>License number:</label>
												<input class='form-control' type='text' name='access_license_number' id='access_license_number' value='<?= (isset($record[ 'access_license_number' ])) ? $record[ 'access_license_number' ]: ''; ?>'/>
											</div>
										
											<div class="col-md-6 col-xs-12">
												<label>Mark up number</label>
												<input class='form-control' type='number' name='markup_value' id='markup_value' value='<?= (isset($record[ 'markup_value' ])) ? $record[ 'markup_value' ]: ''; ?>'/>
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
											<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
											<input class='btn btn-primary' name="add_customer" type='submit' value='Submit' class='submit'/>
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
		
		<!-- END NEW PROFILE -->
	</form>
	
	<!-- /.row -->
</section>
<!-- /.content -->

<!------- footer ------>
@include('footer')