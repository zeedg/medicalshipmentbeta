<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!--- ADD USER CONTENT -->


<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Site Settings
	</h1>
</section>

<!-- Main content -->
<section class="content">
	
	<div class="row">
		<div class="col-md-12">
			<ul class="bg-danger"></ul>
		</div>
	</div>
	<form class="form" action="{{ action('SiteSettingsController@update'  , ((isset($record['id'])) ? $record['id'] : 0 )) }}" id="registerform" method='post'>
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
						<?php if(isset($record) && count($record) > 0){
						foreach($record as $r){
						?>
											<div class="col-md-6 col-xs-12">
												<div class="col-md-12  ">
													<div class="form-group">
														<label for="exampleInputEmail1" style="text-transform: capitalize"><?= $r[ 'lable' ] ?></label>
														<textarea name="data[<?= $r[ 'id' ]  ?>]" cols="30" rows="4" class="form-control"><?= $r[ 'value' ] ?></textarea>
														{{--<small id="emailHelp" class="form-text text-muted">please fill up .</small>--}}
													</div>
												</div>
											
											</div>
						<?php
						}
						}
						?>
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
															<input class='btn btn-primary' name="add_customer" type='submit' value='Update' class='submit'/>
															<a class='btn btn-warning' href="{{ url('/addcustomer') }}">Reset</a><br><br>
														
														</div>
														<!-- /.box-footer -->
													</div>
												</div>
												<!-- /.box -->
											</div>
										</div>
										
										<!-- /.box-footer -->
									</div>
								</div>
							
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