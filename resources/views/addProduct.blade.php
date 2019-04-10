<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!--- ADD USER CONTENT -->


<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Add Product
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-md-12">
                 <ul class="bg-danger"></ul>            </div>
  </div>
  <form class="form" action="{{ url('/storeproduct') }}" enctype="multipart/form-data" id="categoryform" method='post'>
  <!-- NEW PROFILE -->
  <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="https://help.prospectz.io/wp-content/uploads/2018/12/member.png" alt="USER">

              <h3 class="profile-username text-center">Add New Product</h3>

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
                      <h3 class="box-title">Product Information</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="form-horizontal">
                      <div class="box-body">
            			  
                          <div class="col-md-12 col-xs-12">
                              
                              <label>Category</label>
                              <select class="form-control" name="parent" required="required">
                                <option value="">Choose Option</option>
                                <?php 
                                if(isset($arrValue['tree']) && !empty($arrValue['tree'])){
                                foreach($arrValue['tree'] as $cl){?>
                                    <option value="<?php echo $cl["category_id"] ?>"> <?php echo stripslashes(trim($cl["category_title"]))?> </option>
                                <?php 
                                }
                                }
                                ?>
                              </select>
                          </div>
                          
                          <div class="col-md-12 col-xs-12">
                              <label>Manufacturer</label>
                              <select class="form-control" name="manufacturer" required="required">
                                <option value="">Choose Option</option>
                                <?php 
                                if(isset($arrValue['manufacturer']) && !empty($arrValue['manufacturer'])){
                                    foreach($arrValue['manufacturer'] as $cl){?>
                                    <option value="<?php echo $cl->manu_id ?>"> <?php echo stripslashes(trim($cl->manu_title))?> </option>
                                <?php 
                                }
                                }
                                ?>
                              </select>
                          </div>
                          	
                          <div class="col-md-12 col-xs-12">
                            <label>Title:</label>
                            <input  class='form-control' type='text' name='title' id='title' value='' placeholder="Title" />
                          </div>

                          <div class="col-md-12 col-xs-12">
                              <label>Slug:</label>
                              <input  class='form-control' type='text' name='slug' id='slug' readonly="readonly" required />
                              <button onclick="createSlug(0)" type="button" class="btn btn-link">Create Slug</button>
                          </div>
							
                          <div class="form-group" id="slug_view" style="display:none;"></div>
						  
                          
                          <div class="col-md-12 col-xs-12">
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
                                    if(isset($arrValue['attribute']) && !empty($arrValue['attribute'])){
                                    foreach($arrValue['attribute'] as $attr){
                                        $name=trim(stripslashes($attr->attribute_name));
                                        $id=$attr->attribute_id;
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
                                    <td><input type="button" class="btn btn-primary" name="add_attr_set" value="Add" id="add_attr_set" onclick="addAttributeSet()" /></td>
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
                                    <tr id="no_record_row">
                                        <td colspan="3">No Record Found</td>
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                		  </div>	
                          
                          <div class="col-md-12 col-xs-12">
                          <div class="panel panel-default" id="multiple_unit">
				  <div class="panel-heading"> 
					<!--Add Multiple Unit--> 
					Add Price </div>
				  <div class="panel-body">
					<div class="form-group" style="display:none">
					  <select class="form-control" name="unit_price" id="unit_price" onchange="addUnit(this.value)">
						<option value="">Select & Add Unit</option>
						<?php
						if(isset($arrValue['unit']) && !empty($arrValue['unit'])){
							foreach($arrValue['unit'] as $cl){	
							$selected="";
							if($cl->unit_id==7){
								$selected="selected='selected'";
							}
							?>
							<option <?php echo $selected?> value="<?php echo $cl->unit_id?>"> <?php echo stripslashes(trim($cl->unit_title))?> </option>
						<?php 
						}
						}
						?>
					  </select>
					</div>
					<div class="table-responsive">
					  <table class="table table-striped table-bordered table-hover" id="tbl_unit">
						<!--<thead>
															<tr>
																<th>Unit</th>
																<th>Price</th>
																<th>Action</th>
															</tr>
														</thead>-->
						<tbody>
						  <tr>
							<td><input class="form-control" placeholder="Enter Regular Price ( Required )" title="Enter Regular Price" name="unit_7">
							  <br>
							  <input class="form-control" placeholder="Enter Special Price ( Optional )" title="Enter Special Price" name="special_7"></td>
						  </tr>
						</tbody>
					  </table>
					  <input type="hidden" name="unit_id" id="unit_id" value="7" />
					</div>
				  </div>
				</div>
                		  </div>
                          
                          <div class="col-md-12 col-xs-12">
                              <input type="checkbox" name="dropship" id="dropship">
                              <label>Drop Ship?</label>
                            </div>
                            <div class="col-md-12 col-xs-12">
                              <input type="checkbox" name="freeship" id="freeship">
                              <label>Free Shipping?</label>
                            </div>
                            <div class="col-md-12 col-xs-12">
                              <input type="checkbox" name="out_of_stock" id="out_of_stock">
                              <label>Out of Stock?</label>
                            </div>
                          
                          <div class="col-md-12 col-xs-12">
				  <label>Business Rule</label>
				  <select class="form-control" name="product_business_rule">
				  <?php 
					if(isset($arrValue) && !empty($arrValue))
					{
						foreach($arrValue['rules'] as $rule)
						{										
							$selected="";
							/*if($rule->rule_code == $arrValue['detail'][0]['product_business_rule'])
							{
								$selected="selected='selected'";												
							}*/
												
					?>
					<option <?php echo $selected?> value="<?php echo $rule->rule_code ?>" title="<?php echo $rule->rule_description ?>"> <?php echo $rule->rule_code ?> - <?php echo stripslashes(trim($rule->rule_name))?> </option>
					<?php 
						}
					}
					?>
				  </select>
				</div>
                          
                          
                          
                          <div class="col-md-12 col-xs-12">
                  <input type="checkbox" name="bundle" id="bundle">
                  <label for="bundle">Bundled</label>
                  <input type="hidden" id="txtValue" />
                </div>
                <div class="col-md-12 col-xs-12" id="mix_class_qty" style='display: none';>
                  <label>Maximum Quantity</label>
                  <select class="form-control" name="product_mix_class_id">
                  <?php 
				  	if(isset($arrValue) && !empty($arrValue))
					{
						foreach($arrValue['mix_class_qty'] as $mix_class_qty)
						{	
												
					?>
                    <option value="<?php echo $mix_class_qty->mix_class_id ?>" title="<?php echo $mix_class_qty->mix_class_id ?>"> <?php echo $mix_class_qty->max_qty ?></option>
                    <?php 
						}
					}
					?>
                  </select>
                </div>
				<div class="col-md-12 col-xs-12">
				  <label>Packaging</label>
				  <input class="form-control" name="package" placeholder="yes/no">
				</div>
				<div class="col-md-12 col-xs-12">
				  <label>Weight</label>
				  <input class="form-control" name="weight" placeholder="235">
				</div>
				<div class="col-md-12 col-xs-12">
				  <label>Item#</label>
				  <input class="form-control" name="item_no" placeholder="220501">
				</div>
				<div class="col-md-12 col-xs-12">
				  <label>Size</label>
				  <input class="form-control" name="size" placeholder="24">
				</div>
				<div class="col-md-12 col-xs-12">
				  <label>Dimention(Width)</label>
				  <input class="form-control" name="width" placeholder="32" />
				</div>
				<div class="col-md-12 col-xs-12">
				  <label>Dimention(Height)</label>
				  <input class="form-control" name="height" placeholder="46.5" />
				</div>
				<div class="col-md-12 col-xs-12">
				  <label>Dimention(Length)</label>
				  <input class="form-control" name="length" placeholder="25" />
				</div>
				<div class="col-md-12 col-xs-12">
				  <label>Short Detail</label>
				  <textarea class="form-control" spellcheck="false" rows="6" name="sdetail" placeholder="3-Drawer Medication Cart"></textarea>
				</div>
				<div class="col-md-12 col-xs-12">
				  <label>Detail</label>
				  <textarea class="form-control" name="detail" id="editor1" ></textarea>
				</div>
				<div class="col-md-12 col-xs-12">
				  <label>Product PDF Manual</label>
				  <input type="file" name="pdf">
				</div>
				<div class="col-md-12 col-xs-12">
				  <label>Product Video</label>
				  <input type="file" name="video">
				</div>
				<div class="col-md-12 col-xs-12">
				  <label>Is Featured ?</label>
				  <div class="radio">
					<label>
					  <input type="radio" name="featured" id="optionsRadios1" value="1" checked>
					  Yes </label>
				  </div>
				  <div class="radio">
					<label>
					  <input type="radio" name="featured" id="optionsRadios2" value="0" checked="checked">
					  No </label>
				  </div>
				</div>
				<div class="col-md-12 col-xs-12">
				  <label>Upload Image 1</label>
				  <input type="file" name="image[]">
				</div>
				<div class="col-md-12 col-xs-12">
				  <label>Upload Image 2</label>
				  <input type="file" name="image[]">
				</div>
				<div class="col-md-12 col-xs-12">
				  <label>Upload Image 3</label>
				  <input type="file" name="image[]">
				</div>
				<div class="col-md-12 col-xs-12">
				  <label>Upload Image 4</label>
				  <input type="file" name="image[]">
				</div>
				<div class="col-md-12 col-xs-12">
				  <label>Upload Image 5</label>
				  <input type="file" name="image[]">
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
                          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                          <input class='btn btn-primary' name="add_category" type='submit' value='Submit' class='submit' />
                          <a class='btn btn-warning' href="{{ url('/addproduct') }}">Reset</a><br><br>
                        
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

<script>
$(function(){
	productType=1;
	if(productType==2 || productType==3){
		$('#multiple_unit').remove();
	}
	
	$("#bundle").click(function () 
	{
		if ($(this).is(":checked")) 
		{
			$("#mix_class_qty").show();
        } 
		else 
		{
			$("#mix_class_qty").hide();
        }
    });
	
});
function addUnit(unit_id){
	
	
	
	if(unit_id==''){
		return;
	}
	
	if($('#row_' + unit_id).length){
		alert('You have already added this unit');
		return;
	}
	var unit_id_h=$('#unit_id').val();
	if(unit_id_h==''){
		$('#unit_id').val(unit_id);
	}
	else{
		$('#unit_id').val(unit_id_h + ',' + unit_id);
	}
	
	var unit_text=$('#unit_price option:selected').text();
	$('#tbl_unit').append("<tr id='row_" + unit_id + "'><td>" + unit_text + "</td><td><input class='form-control' name='unit_" + unit_id + "' placeholder='Enter Regular Price ( Required )' title='Enter Regular Price'><br><input class='form-control' name='special_" + unit_id + "' placeholder='Enter Special Price ( Optional )' title='Enter Special Price'></td><td><a href='javascript:removeUnit(" + unit_id + ")'>Remove</a></td></tr>");
}
function removeUnit(row_id){
	
	var array='';
	test=$('#unit_id').val();
	var test1=test.split(',');
	for(i=0;i<test1.length;i++){
		if(test1[i]!=row_id){
			array +=test1[i] + ',';		
		}
	}
	array=array.substring(0, array.length - 1);
	$('#unit_id').val(array);
	
	
	$('#row_' + row_id).addClass("danger");
	$('#row_' + row_id).fadeOut(2000, function(){
	
		$('#row_' + row_id).remove();
	
	});
	
	
	
	
}
function addRow(){
	
	var a=$("div[id^='row_']");
	row_number=a.length;
	html=$('#row_1').html();
	$('#row_' + row_number).after('<div class="form-group bg" id="row_' + ( row_number + 1 ) + '"><div><b style="cursor:pointer" onclick="removeRow(' + (row_number + 1) + ')">Remove</b></div>' + html + '</div>');
	
}
function removeRow(id){
	
	$('#row_' + id).fadeOut(1000, function(){
	
		$('#row_' + id).remove();
	
	});
}
</script>
<script type="text/javascript">
function selectRadio(ids){
	
	textarea=document.getElementById('txtValue').value;
	if(document.getElementById(ids).checked){
		
		if(textarea.trim()){
				document.getElementById('txtValue').value=textarea + ',' + ids;
		}
		else{
			document.getElementById('txtValue').value=ids;
		}
		
		var row=document.getElementById(ids + '_row');
		row.style.backgroundColor='whitesmoke';
	
	}
	else{
		
		array_split=textarea.split(',');
		var string='';
		for(i=0;i<array_split.length;i++){
			if(array_split[i]!=ids){
				string +=array_split[i] + ',';
			}
		}
		string=string.replace(/,\s*$/, "");
		document.getElementById('txtValue').value=string;
		
		var row=document.getElementById(ids + '_row');
		row.style.backgroundColor='white';
	
	}
	
	
}
</script>

<script type="text/javascript">
function getAttributeItem(attr_id){
	if(attr_id==''){
		return;	
	}
	if(window.XMLHttpRequest){
		xmlhttp=new XMLHttpRequest();
	}
	else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			attribute_item
			$('#attribute_item').html('');
			$('#attribute_item').append(xmlhttp.responseText);
		}
	}  
	var path="product/getAttributeItem/"+ attr_id;
	xmlhttp.open("GET",path,true);
	xmlhttp.send();
}
function addAttributeSet(){
	var attribute_id=$('#attribute').val();
	var attribute_item_id=$('#attribute_item').val();
	if(attribute_id=='' || attribute_item_id==''){
		alert('Select option');
		return;
	}
	$('#no_record_row').remove();
	var attribute_name=$('#attribute').find(":selected").text();
	var attribute_item_name=$('#attribute_item').find(":selected").text();
	
	if($('#attr_set_' + attribute_id).length){
		alert('You have already added attribute item for ' + attribute_name);
		return;
	}
	$('#tbl_attr').append("<tr id='attr_set_" + attribute_id + "'><td>" + attribute_name + "</td><td>" + attribute_item_name + "</td><td><a href=javascript:removeAttributeSet(" + attribute_id + ")>Remove</a></td><input type='hidden' name='attr_set[]' value=" + attribute_id + "_" + attribute_item_id + "></tr>");
}
function removeAttributeSet(attr_id){
	$('#attr_set_' + attr_id).animate( {backgroundColor:'yellow'}, 250).fadeOut(250,function() {
    	$(this).remove();
		if(totalRows()==1){
			$('#tbl_attr').append("<tr id='no_record_row'><td colspan='3'>No Record Found</td></tr>");
		}
	});
}
function totalRows(){
	var rowCount=$('#tbl_attr tr').length;
	return rowCount;
}
</script>

<!------- footer ------>
@include('footer')