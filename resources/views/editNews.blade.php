<!--- header ----->
@include('header')

<!--- navigation ---->
@include('navigation')

<!--- ADD USER CONTENT -->
<style type="text/css">
  .news_img img{
    width: 100%;
  }
  .del_btn a {
    color: red;
    float: right;
    top: 5px;
    right: 5px;
  }
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Edit News
  </h1>
</section>

<?php


?>


<!-- Main content -->
<section class="content">
  <?php if(Session::get('delete_img')){ ?>
          <div class="alert alert-success"><?php echo Session::get('delete_img'); ?></div>
  <?php } ?>

  <div class="row">
    <div class="col-md-12">
                 <ul class="bg-danger"></ul>            </div>
  </div>
  <form class="form" action="{{ url('/news/update') }}" enctype="multipart/form-data" id="newsform" method='post'>
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
                            <input  class='form-control' type='text' name='title' id='title' value='{{trim($news[0]->title)}}' />
                            <input  class='form-control' type='hidden' name='news_id' id='title' value='{{trim($news[0]->id)}}' />
                          </div>
                          <div class="col-md-6 col-xs-12">
                              <label>Author:</label>
                             <input  class='form-control' type='text' name='author' id='author' value='{{trim($news[0]->author)}}' />
                          </div> 			
                          <div class="col-md-6 col-xs-12">
                            <label>Upload Image:</label>
                            <input type="file" name="news_image_file">
                          </div>
                          <div class="col-md-6 col-xs-12 news_img">
                            <label>Image:</label></br>
                            <?php 
                              if(isset($news[0]->image) && ($news[0]->image != '')){ ?>
                <span class="del_btn"><a onclick="return confirm('Do you want to remove this Image?')" href="{{ url('news/delete_img/'.$news[0]->id.'_'.$news[0]->image) }}" class="glyphicon glyphicon-trash"></a></span>
                <img src="<?php echo url('/uploads/news').'/'.$news[0]->image ?>" alt="{{$news[0]->image}}" >
                           <?php  }else{ ?>
                <img src="<?php echo url('/uploads/news/placeholder.png') ?>" alt="No Image">
                              <?php } ?>
                          </div>
                          
                          <input type="hidden" name="news_image" id="news_image" value="<?php echo $news[0]->image; ?>" />
                            
                          <div class="col-md-12 col-xs-12">
                            <label>Description:</label>
                            <textarea id="detail" name="news_description" placeholder="Detail" class="form-control" required="">{{trim($news[0]->description)}}</textarea>
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
                          <input class='btn btn-primary' name="update_news" type='submit' value='Update' class='submit' />
                          <a class='btn btn-warning' href="{{ url('/news/edit/')}}/{{$news[0]->id }}">Reset</a><br><br>
                        
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