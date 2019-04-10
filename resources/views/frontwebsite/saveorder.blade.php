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
        <div class="cartboxcover">        
        
          <h2>
          	<?php
			$close=0;
			if(isset($status) && trim($status)=='open'){
				echo "Open Orders";	
			}
			if(isset($status) && trim($status)=='close'){
				echo "Order History";
				$close=1;
			}
			?>
          </h2>
          
                    
          <div class="mycart">
				                
                <table id="tbl_mycart">
                	<thead>
                        <tr>
                            <th>Order#</th>
                            <th>Order Date</th>
                            <?php 
							if($close==1){
								
								echo "<th>Delivery Date</th>";
								
							}
							?>
                            <th>Order Status</th>
                            <th>Tracking Number</th>
                            <th>Order Detail</th>
                            <th>Re-Order</th>
                        </tr>
                    </thead>
          
          			<?php
					//echo '<pre>'.print_r($arrData['order_status'][0],true).'</pre>';
					$grand_total=0;
					if(isset($orders) && !empty($orders)){ 
					  
						foreach($orders as $post){
							
							$status=$order_status[$post['order_status']];
							
							$tracking_no=$post['order_tracking_number'];
							$date=strtotime($post['order_date']);
							$date=date("m/d/Y g:i a", $date);
							
							if($close==1){
								
								$ddate=strtotime($post['order_delivery_date']);
								$ddate=date("m/d/Y g:i a", $ddate);
								
							}						
					
					?>                    
                    <tr>
                    	<td><?php echo stripslashes($post['order_id'])?></td>
                        <td><?php echo $date?></td>
                        <?php 
						if($close==1){
							
							echo "<td>".$ddate."</td>";
							
						}
						?>
                        <td><?php echo $status?></td>
                        <td>
						<?php
						if($tracking_no != ''){ echo "<a href='https://wwwapps.ups.com/WebTracking/processInputRequest?HTMLVersion=5.0&error_carried=true&tracknums_displayed=5&TypeOfInquiryNumber=T&loc=en_US&InquiryNumber1=".$tracking_no."&AgreeToTermsAndConditions=yes' target='_blank' style='color: #428bca !important; font-weight: bold;'>".$tracking_no."</a>"; }
						?></td>
                        <td>
                        	<a href="<?php echo 'index.php?controller=saveorder&function=detail&id='.intval($post['order_id'])?>">
								<img src="<?php echo 'images/view_order.png'?>" border="0" title="Order Detail" />
                            </a>
                        </td>
                        <td><a href="<?php echo 'index.php?controller=saveorder&function=reorder&id='.intval($post['order_id'])?>" style="color:#428bca !important">Re-Order</a></td>
                    </tr>
                    
                    <?php
						}						
					}
					?>                    
                    </table>                    
          	</div>          
          <div class="clear"></div>      
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