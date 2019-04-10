@extends('frontwebsite._mainLayout')
@section('content')

<div class="container">
  <div class="row main-contant">
    <div class="container contant-con">
    
      @include('frontwebsite.account_left')
      
      <div class="col-lg-9">
        <div class="bodyinner">
        <h1>My Dashboard</h1>
        <div class="welcome-msg">
    <p class="hello"><br /><strong>Hello, <?php echo session()->get('user_fname').' '.session()->get('user_lname'); ?>!</strong></p><br />
    <p>From your My Account Dashboard you have the ability to view a snapshot of your<br />
     recent account activity and update your account information. Select a link below to<br />
      view or edit information.</p>
</div>
        
      </div>
      <!--bodycontent-->
      
           <p>&nbsp;<br /></p>
      </div>
      
    </div>
    
  </div>
</div>

<div class="clearz"></div>

@endsection()