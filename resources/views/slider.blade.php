
<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!------ content page start --------->
<section class="content-header">
  <h1>
    Manage Slider
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
         	Manage Slider
          </h3>
            
            </br>
          </br>
          <div class="row">
            <div class="col-md-6">
                <select onchange="getvalue(this.value)" class="form-control" id="selectedOption">
            <option value="10" <?php if(Session::get('selected_option') == '10'){echo 'selected';} ?>>10</option>
                  <option value="25" <?php if(Session::get('selected_option') == '25'){echo 'selected'; }?>>25</option>
                  <option value="50" <?php if(Session::get('selected_option') == '50'){echo 'selected';} ?>>50</option>
                  <option value="100" <?php if(Session::get('selected_option') == '100'){echo 'selected';} ?>>100</option>
                  <option value="200" <?php if(Session::get('selected_option') == '200'){echo 'selected'; } ?>>200</option>
                  <option value="300" <?php if(Session::get('selected_option') == '300'){ echo 'selected';} ?>>300</option>
                </select>      
            </div>
            <div class="col-md-6">
              <input placeholder="Search..." type="text" name="search_value" onkeyup="getuser_record(this.value)" class="form-control" value="{{ Session::get('keyword') }}" id="keyWord">
            </div>
          </div>
            
           <!-- Status Load -->
          	<!--<a data-toggle="modal" href="#options-modal-modal" class="btn btn-success btn-sm pull-right"><i class="fa fa-group"></i> Load Members By Option</a>-->
          <!-- //Status Load  -->

        </div>
        <!-- /.box-header -->
        <div class="box-body app-list-ingore">
         	<form name="slider" action="members" method="post">
        		<input type="hidden" name="action" value="action-delete" />
	        	<div class="allutable"><!--  table-responsive -->
					<table class='table table-bordered table-striped table-list-search dataTable'>
						<thead>
						<tr>
							<th>#</th>
							<th>Title</th>
							<th>Redirect</th>
							<th>Action</th>
						 </tr>
						</thead>
					 	<tbody>

<?php $ci = 0; ?>

@foreach ($sliders as $slider)
<?php $ci++; ?>
<tr id="user" class="">
	<td>{{ $slider->slider_id }}</td>
    <td>
	{{ $slider->slider_title }}	
	</td>

	<td>
	{{ $slider->slider_redirect }}																			
	</td>
	
	<td>
		<div class="dropdown">
			<button id="btn" class="btn btn-fill btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true">
				Actions
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu"  style="right: 0; left: auto;"  aria-labelledby="dropdownMenu">
				<li class="">
					<a href="sliderupdate/{{ $slider->slider_id }}" class="tip" data-placement="left" data-element="user38" title="View/Edit {{ $slider->slider_title }}"><i class="fa fa-pencil text text-primary"></i> View/Edit {{ $slider->slider_title }}</a>
				</li>

				<li role="separator" class="divider"></li>

				<li class="">
					<a href="destroyslider/{{ $slider->slider_id }}" class="dAction tip" data-id="{{ $slider->slider_id }}" data-option="" data-type="deactivate-user" data-modal-title="De/Activate Thandi Ngobese's Account" data-modal-text="Are you sure you want to De/Activate this User Account ?" data-form="adminUsers"  data-placement="left" data-element="user{{ $slider->slider_id }}" title="De/Activate {{ $slider->slider_title }}" ><i class="fa fa-ban text text-danger"></i> De/Activate {{ $slider->slider_title }}</a>
				</li>

			</ul>
		</div>

	</td>
</tr>
@endforeach															
                                                                
                                                                
                                                                
								
					  </tbody>
					  <tfoot>
	                </tfoot>
					</table>
                    
                    <table class='' style="float:right;">
          	<tr>
            <td>{{ $sliders->links() }}</td>
          </tr>
          </table>
                    
				</div>
				<input type="hidden" name="csrf" value="f6929e47c0da51842f812850685ab1cf" >
        <br><br>

			</form>
        </div>
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

<script type="text/javascript">
  
(function($){
  $(document).ready(function(){
    $('.dataTables_paginate ul.pagination, #DataTables_Table_0_info, #DataTables_Table_0_length, #DataTables_Table_0_filter, .dataTables_paginate ').css({
    'display' : 'none'
  });
  });

})(jQuery);

function getvalue(value){
 // var keyword = $("#keyWord").val();
  $.ajax({
      url: "{{ url('slider/filter') }}",
      data: {
        selected_option : value
       },
       type: 'get',
       contentType: "json",
       success:function(response, status){
        $('.box-body').html($(response).find('.box-body').html());
       }
    });

   // alert(value);

  }
  function getuser_record(value){
    var selected = $('#selectedOption :selected').text();
    $.ajax({
    url: "{{ url('slider/filter') }}",
    method: 'get',
    data:  { keyword: value, selected_option : selected },
    contentType: 'json',
    cache: false,
    success: function(data) {
        $('.box-body').html($(data).find('.box-body').html());
        //console.log(data);
    },
    error: function(data) {  
        console.log(data);
        console.log("error");                 
    }
});

  }

   
</script>

<!------- footer ------>
@include('footer')
  