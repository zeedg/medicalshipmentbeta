<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!------ content page start --------->
<section class="content-header">
	<h1>
		Manage Addresses
	</h1>
</section>

<!-- Main content -->
<section class="content">
	
	<div class="row">
		<div class="col-md-12">
		</div>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">
						Manage Addresses
					</h3>
					
					<!-- Status Load -->
					<!--<a data-toggle="modal" href="#options-modal-modal" class="btn btn-success btn-sm pull-right"><i class="fa fa-group"></i> Load Members By Option</a>-->
					<!-- //Status Load  -->
					<table class="table table-striped">
						<thead>
						<tr>
							<th>Firstname</th>
							<th>Lastname</th>
							<th>Email</th>
						</tr>
						</thead>
						<tbody>
			<?php
			if(isset($record)){
			foreach($record as $row){
			?>
						<tr>
							<td><?= $row->bsa_fname ?></td>
							<td><?= $row->bsa_lname ?></td>
							<td><?= $row->bsa_phone ?></td>
							<td><a href="<?= action('UbsController@edit', ['id' => $row->bsa_id]) ?>">Edit</a></td>
						</tr><?php
			}
			}
			?>
						
						</tbody>
					</table>
				</div>
				<!-- /.box-header -->
				
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
			
			<!-- /.box -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
</section>
<!-- /.content -->

<!------ content page end ----------->

<!------- footer ------>
@include('footer')
