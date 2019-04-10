<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!--- ADD USER CONTENT -->

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Edit Product Detail
	</h1>
</section>
<?php

?>
<style type="text/css">
	.deletePopr {
		z-index: 999999;
		position: absolute;
		right: 16px;
	}
	
	.imageContainer {}
	
	.imageContainer input {margin-bottom: 10px;}
	
	#product_images div {
		width: 200px;
		height: 200px;
		overflow: hidden;
		position: relative;
	}
	
	#product_images div img {
		width: 100%;
		height: auto;
	}
	
	#product_images div video {
		width: 100%;
		height: auto;
	}
	
	#product_images div a img {
		width: 100%;
		height: 100px;
		
	}
	
	.del_btn {
		position: absolute;
		top: 0;
		right: 0;
		color: wheat;
		background-color: red;
		border-radius: 50%;
		padding: 5px 11px;
	}
</style>
<!-- Main content -->
<section class="content">
	
	<div class="row">
		<div class="col-md-12">
			<ul class="bg-danger"></ul>
		</div>
	</div>
	<form class="form" action="{{ url('product/update') }}" id="registerform" method='post' enctype="multipart/form-data">
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
										<h3 class="box-title">Edit Product Detail</h3>
									</div>
									<!-- /.box-header -->
				<?php //print_r($categories); ?>
								
								<!-- form start -->
									<div class="form-horizontal">
										<div class="box-body">
											<div class="row">
												{{ csrf_field() }}
												<div class="col-md-6 col-xs-12">
													<label>Category:</label>
													<select class="form-control" name="category_id" required="">
														@foreach($categories as $category)
															<option value="{{$category->category_id}}"
							 
							 <?php
								echo ($products[ 0 ]->category_id == $category->category_id) ? 'selected' : '';
								?>
															
															>{{$category->category_title}}</option>
														@endforeach
													</select>
												</div>
												
												<div class="col-md-6 col-xs-12">
													<label>Manufacturer:</label>
													<select class="form-control" name="manu_id" required="">
														@foreach($manufacturers as $manufacturer)
															<option value="{{$manufacturer->manu_id}}"
							 <?php
								echo ($products[ 0 ]->manu_id == '$manufacturer->manu_id') ? 'selected' : '';
								?>
															
															>{{$manufacturer->manu_title}}</option>
														@endforeach
													</select>
												</div>
												<div class="col-md-6 col-xs-12">
													<label>Business Rule:</label>
													<select class="form-control" name="product_business_rule">
														@foreach($business_rules as $business_rule)
															<option value="{{$business_rule->id}}"
							 <?php
								
								echo ($business_rule->id == $products[ 0 ]->product_business_rule) ? "selected" : ''; ?> >{{$business_rule->rule_code}} - {{$business_rule->rule_name}}
															</option>
														@endforeach
													</select>
												</div>
												<div class="col-md-3 col-xs-12">
													</br>
													<input class='form-check-input' type='checkbox' name='product_dropship' id='product_dropship' value="1"
						 
						 <?php
							echo ($products[ 0 ]->product_dropship == '1') ? 'checked' : '';
							?>
													
													/>
													<label> Drop Ship?</label>
												</div>
												<div class="col-md-3 col-xs-12">
													</br>
													<input class='form-check-input' type='checkbox' name='product_freeship' id='product_freeship' value="1"
						 <?php
							echo ($products[ 0 ]->product_freeship == '1') ? 'checked' : '';
							?>
													
													/>
													<label> Free Shipping?</label>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													
													<div class="panel panel-default">
														<div class="panel-heading">
															Manage Attribute Set
														</div>
														<div class="panel-body">
															
															<div class="table-responsive">
																<table class="table table-striped table-bordered table-hover">
																	<tr>
																		<td>
																			<select class="form-control" name="attribute" id="attribute" onchange="getAttributeItem(this.value)">
																				<option value="">Select...</option>
										 <?php
										 if(isset($attributes) && !empty($attributes)){
											 foreach($attributes as $attr){
												 $name = trim(stripslashes($attr->attribute_name));
												 $id = $attr->attribute_id;
												 echo "<option value=".$id.">".$name."</option>";
											 }
										 }
										 ?>
																			</select>
																		</td>
																		<td>
																			<select class="form-control" name="attribute_item" id="attribute_item">
																				<option value="">Select...</option>
																			</select>
																		</td>
																		<td><input type="button" class="btn btn-primary" name="add_attr_set" value="Add" id="add_attr_set" onclick="addAttributeSet()"/></td>
																	</tr>
																</table>
															</div>
															
															<div class="table-responsive">
																<table class="table table-striped table-bordered table-hover" id="tbl_attr">
																	<thead>
																	<tr>
																		<th>Attribute</th>
																		<th>Attribute Item</th>
																		<th>Action</th>
																	</tr>
																	</thead>
																	<tbody>
								 <?php //print_r($product_items); ?>
								 <?php if(isset($product_items) && ($product_items != '')){?>
																	
																	@foreach($product_items as $item)
																		
																		<tr id="attr_set_{{$item->attribute_id}}">
																			<td>{{$item->attribute_name}}</td>
																			<td>{{$item->attribute_item_name}}</td>
																			<td><a href="javascript:removeAttributeSet({{$item->attribute_id}})">Remove</a></td>
																			<input type="hidden" name="attr_set[]" value="{{$item->attribute_id}}_{{$item->attribute_item_id}}"></tr>
																	
																	@endforeach
								 
								 <?php  }else{ ?>
																	
																	<tr id="no_record_row">
																		<td colspan="3">No Record Found</td>
																	</tr>
								 
								 <?php } ?>
																	
																	</tbody>
																</table>
															</div>
														</div>
													</div>
												</div>
												
												<div class="col-md-3 col-xs-12">
													<label>Product PDF Manual:</label>
													<input class='form-control-file' type='file' name='product_file' id='product_file' value="c:/passwords.txt"/>
												</div>
												<div class="col-md-3 col-xs-12">
													<label>Product Video:</label>
													<input class='form-control-file' type='file' name='prodcut_video' id='prodcut_video'/>
												</div>
												<br>
												<hr>
												<h3>Images</h3>
												<div class="imageContainer">
													<div class="col-md-3 col-xs-12">
														<input class='form-control-file' type='file' name='product_img[]' id='product_img_1'/>
													</div>
													<div class="col-md-3 col-xs-12">
														
														<input class='form-control-file' type='file' name='product_img[]' id='product_img_2'/>
													</div>
													<div class="col-md-3 col-xs-12">
														
														<input class='form-control-file' type='file' name='product_img[]' id='product_img_3'/>
													</div>
													<div class="col-md-3 col-xs-12">
														
														<input class='form-control-file' type='file' name='product_img[]' id='product_img_4'/>
													</div>
													<div class="col-md-3 col-xs-12">
														
														<input class='form-control-file' type='file' name='product_img[]' id='product_img_5'/>
													</div>
												</div>
												<div class="col-md-3 col-xs-12">
													<label>Is Featured ?</label>
													</br>
													<label>Yes</label>
													<input value="1" class='form-control-file' type='radio' name='product_featured' id='product_featured'
						 <?php
							echo ($products[ 0 ]->product_featured == '1') ? 'checked' : '';
							?>
													
													/>
													<label>No</label>
													<input value="0" class='form-control-file' type='radio' name='product_featured' id='product_featured'
						 
						 <?php
							echo ($products[ 0 ]->product_featured == '0') ? 'checked' : '';
							?>
													
													/>
												</div>
												<div class="col-md-3 col-xs-12">
													</br>
													<input class='form-check-input' type='checkbox' name='product_out_of_stock' id='product_out_of_stock' value="1"
						 
						 <?php
							echo ($products[ 0 ]->product_out_of_stock == '1') ? 'checked' : '';
							?>
													
													/>
													<label> Out of Stock?</label>
												</div>
												<div class="col-md-3 col-xs-12">
													</br>
													<input class='form-check-input' type='checkbox' name='product_bundle' id='product_bundle' value="1"
						 
						 <?php
							echo ($products[ 0 ]->product_bundle == '1') ? 'checked' : '';
							?>
													
													/>
													<label> Bundled</label>
												</div>
											
											</div>
											
											<div class="row">
												
												<div class="col-md-6 col-xs-12">
													<label>Product Title: </label>
													<input class='form-control' type='text' name='product_title' id='product_title' value="{{$products[0]->product_title}}"/>
													<input class='form-control' type='hidden' name='update' id='update' value="product_detail"/>
													<input class='form-control' type='hidden' name='product_id' id='product_id' value="{{$products[0]->product_id}}"/>
												</div>
												
												<div class="col-md-6 col-xs-12">
													<label>Sorting Order:</label>
													<input class='form-control' type='text' name='product_sort_order' id='product_sort_order' value="<?php echo ($products[ 0 ]->product_sort_order != '') ? $products[ 0 ]->product_sort_order : ''; ?>"/>
												</div>
												<div class="col-md-6 col-xs-12">
													<label>Slug:</label>
													<input class='form-control' type='text' name='product_slug' id='product_slug' value="<?php echo ($products[ 0 ]->product_slug != '') ? $products[ 0 ]->product_slug : ''; ?>"/>
												</div>
												<div class="col-md-6 col-xs-12">
													<label>Packaging:</label>
													<input class='form-control' type='text' name='product_package' id='product_package' value="<?php echo ($products[ 0 ]->product_package != '') ? $products[ 0 ]->product_package : ''; ?>"/>
												</div>
												<div class="col-md-6 col-xs-12">
													<label>Weight:</label>
													<input class='form-control' type='text' name='product_weight' id='product_weight' value="<?php echo ($products[ 0 ]->product_weight != '') ? $products[ 0 ]->product_weight : ''; ?>"/>
												</div>
												<div class="col-md-6 col-xs-12">
													<label>Item#:</label>
													<input class='form-control' type='text' name='product_item_no' id='product_item_no' value="<?php echo ($products[ 0 ]->product_item_no != '') ? $products[ 0 ]->product_item_no : ''; ?>"/>
												</div>
												<div class="col-md-6 col-xs-12">
													<label>Size:</label>
													<input class='form-control' type='text' name='product_size' id='product_size' value="<?php echo ($products[ 0 ]->product_size != '') ? $products[ 0 ]->product_size : ''; ?>"/>
												</div>
												<div class="col-md-6 col-xs-12">
													<label>Dimention(Width):</label>
													<input class='form-control' type='text' name='product_width' id='product_width' value="<?php echo ($products[ 0 ]->product_width != '') ? $products[ 0 ]->product_width : ''; ?>"/>
												</div>
												<div class="col-md-6 col-xs-12">
													<label>Dimention(Height):</label>
													<input class='form-control' type='text' name='product_height' id='product_height' value="<?php echo ($products[ 0 ]->product_height != '') ? $products[ 0 ]->product_height : ''; ?>"/>
												</div>
												<div class="col-md-6 col-xs-12">
													<label>Dimention(Length):</label>
													<input class='form-control' type='text' name='product_length' id='product_length' value="<?php echo ($products[ 0 ]->product_length != '') ? $products[ 0 ]->product_length : ''; ?>"/>
												</div>
											
											</div>
											<div class="row">
												
												<div class="col-md-6 col-xs-12">
													<label>Short Detail:</label>
													<textarea class='form-control' name='product_sdetail' id='product_sdetail'><?php echo ($products[ 0 ]->product_sdetail != '') ? trim(strip_tags($products[ 0 ]->product_sdetail)) : ''; ?></textarea>
												</div>
												<div class="col-md-6 col-xs-12">
													<label>Complete Detail:</label>
													<textarea class='form-control' name='product_detail' id='product_detail'><?php echo ($products[ 0 ]->product_detail != '') ? trim(strip_tags($products[ 0 ]->product_detail)) : ''; ?></textarea>
												</div>
												
												<div id="product_images">
							<?php if(!empty($products[ 0 ]->product_pdf)) { ?>
													<div class="col-md-3">
														<p>Uploaded File</p>
														<button class="btn btn-danger btn-xs deletePopr" type="button" onclick="return deletefile('pdf' , this , {{$products[0]->product_id}} , 0)">Delete</button>
														<a download href="<?php echo url('/uploads/product/'.$products[ 0 ]->product_pdf) ?>">
															<img id="uploaded_file" src="<?php echo url('/placeholder/pdf.png') ?>" style="height: 145px;"/>
														</a>
													
													</div>
							<?php } ?>
							<?php if(!empty($products[ 0 ]->product_video)) { ?>
													<div class="col-md-3">
														<p>Uploaded Video</p>
														<button class="btn btn-danger btn-xs deletePopr" type="button" onclick="return deletefile('video' , this , {{$products[0]->product_id}} , 0)">Delete</button>
														<video controls id="uploaded_video" style="height: 145px;">
															<source src="<?php echo url('/uploads/product/'.$products[ 0 ]->product_video) ?>" type="video/mp4">
															Your browser does not support the video tag.
														</video>
													
													</div>
							<?php } ?>
													<hr>
													
													<p>Images</p>
							<?php
							if(isset($pro_images) && count($pro_images) > 0){
							foreach($pro_images as $r){ ?>
													<div class="col-md-3">
														<button class="btn btn-danger btn-xs deletePopr" type="button" onclick="return deletefile('image' , this , {{$products[0]->product_id}} , {{ $r->pi_id }})">Delete</button>{{--filetype , ele  , productId , imgId--}}
														<img class="img-rounded" src="<?= url('/uploads/product/'.$r->product_image) ?>" alt="<?=  (isset($r->product_image) ? $r->product_image : '')  ?>" style="height: 145px;">
													</div>
							<?php }
							}
							?>
												
												</div>
											</div>
										</div>
									</div>
									<!--  <input class='form-control-file' type='file' name='product_img_1' id='product_img_1' /> -->
								
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
									<input class='btn btn-primary' name="add_customer" type='submit' value='Update' class='submit'/>
									<a class='btn btn-warning' href="{{ url('/addcustomer') }}">Reset</a>
									<br>
									<br>
								
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
<script>
		$(function () {
				productType = 1;
				if (productType == 2 || productType == 3) {
						$('#multiple_unit').remove();
				}
				
				$("#bundle").click(function () {
						if ($(this).is(":checked")) {
								$("#mix_class_qty").show();
						} else {
								$("#mix_class_qty").hide();
						}
				});
				
		});
		
		function addUnit(unit_id) {
				
				
				if (unit_id == '') {
						return;
				}
				
				if ($('#row_' + unit_id).length) {
						alert('You have already added this unit');
						return;
				}
				var unit_id_h = $('#unit_id').val();
				if (unit_id_h == '') {
						$('#unit_id').val(unit_id);
				} else {
						$('#unit_id').val(unit_id_h + ',' + unit_id);
				}
				
				var unit_text = $('#unit_price option:selected').text();
				$('#tbl_unit').append("<tr id='row_" + unit_id + "'><td>" + unit_text + "</td><td><input class='form-control' name='unit_" + unit_id + "' placeholder='Enter Regular Price ( Required )' title='Enter Regular Price'><br><input class='form-control' name='special_" + unit_id + "' placeholder='Enter Special Price ( Optional )' title='Enter Special Price'></td><td><a href='javascript:removeUnit(" + unit_id + ")'>Remove</a></td></tr>");
		}
		
		
		// function readURL(input) {
		//     if (input.files && input.files[0]) {
		
		//       //console.log(input.files[0].type);
		//         var reader = new FileReader();
		
		//         reader.onload = function (e) {
		//             $('#uploaded_img_1').attr('src', e.target.result);
		//         }
		
		//         reader.readAsDataURL(input.files[0]);
		//     }
		// }
		
		// $("#product_img_1").change(function(){
		//     readURL(this);
		// });
		//  function readURL(input) {
		//     if (input.files && input.files[0]) {
		
		//       //console.log(input.files[0].type);
		//         var reader = new FileReader();
		
		//         reader.onload = function (e) {
		//             $('#uploaded_img_2').attr('src', e.target.result);
		//         }
		
		//         reader.readAsDataURL(input.files[0]);
		//     }
		// }
		
		// $("#product_img_2").change(function(){
		//     readURL(this);
		// });
		
		
		function removeUnit(row_id) {
				
				var array = '';
				test = $('#unit_id').val();
				var test1 = test.split(',');
				for (i = 0; i < test1.length; i++) {
						if (test1[i] != row_id) {
								array += test1[i] + ',';
						}
				}
				array = array.substring(0 , array.length - 1);
				$('#unit_id').val(array);
				
				
				$('#row_' + row_id).addClass("danger");
				$('#row_' + row_id).fadeOut(2000 , function () {
						
						$('#row_' + row_id).remove();
						
				});
				
				
		}
		
		function addRow() {
				
				var a = $("div[id^='row_']");
				row_number = a.length;
				html = $('#row_1').html();
				$('#row_' + row_number).after('<div class="form-group bg" id="row_' + (row_number + 1) + '"><div><b style="cursor:pointer" onclick="removeRow(' + (row_number + 1) + ')">Remove</b></div>' + html + '</div>');
				
		}
		
		function removeRow(id) {
				
				$('#row_' + id).fadeOut(1000 , function () {
						
						$('#row_' + id).remove();
						
				});
		}
</script>
<script type="text/javascript">
		function selectRadio(ids) {
				
				textarea = document.getElementById('txtValue').value;
				if (document.getElementById(ids).checked) {
						
						if (textarea.trim()) {
								document.getElementById('txtValue').value = textarea + ',' + ids;
						} else {
								document.getElementById('txtValue').value = ids;
						}
						
						var row = document.getElementById(ids + '_row');
						row.style.backgroundColor = 'whitesmoke';
						
				} else {
						
						array_split = textarea.split(',');
						var string = '';
						for (i = 0; i < array_split.length; i++) {
								if (array_split[i] != ids) {
										string += array_split[i] + ',';
								}
						}
						string = string.replace(/,\s*$/ , "");
						document.getElementById('txtValue').value = string;
						
						var row = document.getElementById(ids + '_row');
						row.style.backgroundColor = 'white';
						
				}
				
				
		}
</script>

<script type="text/javascript">
		function getAttributeItem(attr_id) {
				if (attr_id == '') {
						return;
				}
				if (window.XMLHttpRequest) {
						xmlhttp = new XMLHttpRequest();
				} else {
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function () {
						if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
								attribute_item
								$('#attribute_item').html('');
								$('#attribute_item').append(xmlhttp.responseText);
								
						}
				}
				var path = "{{ url('/product/getAttributeItem/') }}/" + attr_id;
				
				xmlhttp.open("GET" , path , true);
				xmlhttp.send();
		}
		
		function addAttributeSet() {
				var attribute_id = $('#attribute').val();
				var attribute_item_id = $('#attribute_item').val();
				if (attribute_id == '' || attribute_item_id == '') {
						alert('Select option');
						return;
				}
				$('#no_record_row').remove();
				var attribute_name = $('#attribute').find(":selected").text();
				var attribute_item_name = $('#attribute_item').find(":selected").text();
				
				if ($('#attr_set_' + attribute_id).length) {
						alert('You have already added attribute item for ' + attribute_name);
						return;
				}
				
				/*posting these values to database*/
				$.post('{{ action('ProductController@saveValues') }}' , {
						mainCat : attribute_name ,
						subcat : attribute_item_name ,
						_token : "{{ csrf_token() }}" ,
						productId : $("[name='product_id']").val() ,
				} , function (res) {
						/*var pre = JSON.parse(res);*/
						if (typeof res.status != 'undefined' && res.status == 'success') {
								iziToast.success({
										title : 'OK' ,
										message : res.msg ,
								});
						} else {
								iziToast.error({
										title : 'Error' ,
										message : res.msg ,
								});
						}
				});
				
				$('#tbl_attr').append("<tr id='attr_set_" + attribute_id + "'><td>" + attribute_name + "</td><td>" + attribute_item_name + "</td><td><a href=javascript:removeAttributeSet(" + attribute_id + ")>Remove</a></td><input type='hidden' name='attr_set[]' value=" + attribute_id + "_" + attribute_item_id + "></tr>");
		}
		
		function removeAttributeSet(attr_id) {
				
				console.log({
						mainCat : $('#attr_set_' + attr_id).find('td:nth-child(2)').text() ,
						subcat : $('#attr_set_' + attr_id).find('td:nth-child(3)').text() ,
						_token : "{{ csrf_token() }}" ,
						productId : $("[name='product_id']").val() ,
				});
				$.post('{{ action('ProductController@deleteAttr') }}' , {
						mainCat : $('#attr_set_' + attr_id).find('td:nth-child(1)').text() ,
						subcat : $('#attr_set_' + attr_id).find('td:nth-child(2)').text() ,
						_token : "{{ csrf_token() }}" ,
						productId : $("[name='product_id']").val() ,
				} , function (res) {
						
						/*var pre = JSON.parse(res);*/
						if (typeof res.status != 'undefined' && res.status == 'success') {
								
								$('#attr_set_' + attr_id).animate({backgroundColor : 'yellow'} , 250).fadeOut(250 , function () {
										$(this).remove();
										if (totalRows() == 1) $('#tbl_attr').append("<tr id='no_record_row'><td colspan='3'>No Record Found</td></tr>");
								});
								
								
								iziToast.success({
										title : 'OK' ,
										message : res.msg
								});
								
						} else {
								iziToast.error({
										title : 'Error' ,
										message : res.msg
								});
						}
				})
				
		}
		
		function totalRows() {
				var rowCount = $('#tbl_attr tr').length;
				return rowCount;
		}
		
		function deletefile(filetype , ele , productId , imgId) {
				
				if (confirm('are you sure you want to delete this file')) {
						var deleteType = (filetype == 'image') ? 'i' : ((filetype == 'pdf') ? 'p' : 'v');
						
						$.post('{{ action('ProductController@deleteFileUnlink') }}' , {
								type : deleteType ,
								id : productId ,
								imgId : imgId ,
								_token : "{{csrf_token()}}" ,
						} , function (res) {
								console.log(res);
								if (typeof res.status != 'undefined' && res.status == 'success') {
										$(ele).closest('.col-md-3').remove();
										iziToast.success({
												title : 'OK' ,
												message : res.msg
										});
										
								} else {
										
										iziToast.error({
												title : 'Error' ,
												message : res.msg
										});
										
								}
						})
						
				} else {
						console.log('delete action cancelled');
				}
		}

</script>
@include('footer')