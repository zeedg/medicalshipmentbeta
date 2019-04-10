
<?php
$active = 'class="list-group-item category" style=" font-weight:bold;"';
$inactive = 'class="list-group-item list"';

$slugs = explode ("/", request()->fullUrl());
$controller = $slugs [(count ($slugs) - 2)];

$final = $slugs [(count ($slugs) - 1)];
?>

<div class="col-lg-3">
  <div class="col-lg-12">
    <div class="list-group">
      <p class="gloves">My Account</p>
      <a href="{{ url('account/index') }}" <?php if($controller == 'account'){ echo $active; } else { echo $inactive; } ?>>Account Dashboard</a> 
      
      <a href="{{ url('profile/index') }}"  <?php if($controller == 'profile'){ echo $active; } else { echo $inactive; } ?>>Account Information</a> 
      
      <a href="{{ url('order/index') }}"  <?php if($controller == 'order'){ echo $active; } else { echo $inactive; } ?>>My Orders</a> 
      
      <a href="{{ url('saveorder/index') }}"  <?php if($controller == 'saveorder'){ echo $active; } else { echo $inactive; } ?>>Saved Orders</a> 
      
      <a href="{{ url('account/billing') }}"  <?php if($final == 'billing'){ echo $active; } else { echo $inactive; } ?>>Billing Agreement</a> 
      
      <a href="{{ url('quote/index') }}"  <?php if($controller == 'quote'){ echo $active; } else { echo $inactive; } ?>>My Quotes</a> 
      
      <a href="#"  <?php if($controller == 'kit_quote'){ echo $active; } else { echo $inactive; } ?>>Nursing Kit Quotes</a>
<?php /*?><a href="{{ url('kit_quote/listing') }}"  <?php if($controller == 'kit_quote'){ echo $active; } else { echo $inactive; } ?>>Nursing Kit Quotes</a><?php */?> 
    </div>
  </div>
</div>

