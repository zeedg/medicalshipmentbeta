<!--- header ----->
@include('header')
<!--- navigation ---->
@include('navigation')
<!--- ADD USER CONTENT -->
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Add News
   </h1>
</section>
<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-12">
         <ul class="bg-danger"></ul>
      </div>
   </div>
   <form class="form" action="{{ url('news/store') }}" enctype="multipart/form-data" id="newsform" method="post">
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
                           <h3 class="box-title">News Information</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="form-horizontal">
                           <div class="box-body">
                              <div class="col-md-6 col-xs-12">
                                 <label>Title:</label>
                                 <input  class='form-control' type='text' name='title' id='title'/>
                              </div>
                              <div class="col-md-6 col-xs-12">
                                 <label>Author:</label>
                                 <input  class='form-control' type='text' name='author' id='authorname'>
                              </div>
                              <div class="col-md-6 col-xs-12">
                                 <label>Upload Image:</label>
                                 <input type="file" name="news_img">
                              </div>
                              <div class="col-md-12 col-xs-12">
                                 <label>Description:</label>
                                 <textarea id="detail" name="description" placeholder="Detail" class="form-control"></textarea>
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
                                 <input class='btn btn-primary' name="add_news" type='submit' value='Submit' class='submit' />
                                 <a class='btn btn-warning' href="{{ url('/news/create') }}">Reset</a><br><br>
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
   </form>
   <!-- /.row -->
</section>
<!-- /.content -->
<!------- footer ------>
@include('footer')
