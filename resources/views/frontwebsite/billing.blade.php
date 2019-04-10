@extends('frontwebsite._mainLayout')
@section('content')

<script type="text/javascript">
function updateCart(pid){
	$('#form_' + pid).submit();
}
</script>
<style type="text/css">
h2{ float:none !important}
</style>
<div class="container">
  <div class="row main-contant">
    <div class="container contant-con">
      @include('frontwebsite.account_left')
      <div class="col-lg-9">
        <div class="bodyinner">
        
        	<div class="my-account"><div class="page-title">
    <h1>Billing Agreements</h1>
</div>


<div class="billing-agreements">
                <p>There are no billing agreements yet.</p>
    
        
</div></div>

      </div>
      <!--bodycontent-->
      
           <p>&nbsp;<br /></p>
      </div>
      
    </div>
    
  </div>
</div>

<div class="clearz"></div>

@endsection()