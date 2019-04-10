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

        

          

        

          <h1>Order Detail</h1>

          

          

		  <?php
			$carts = Session::get('cart');
          if(isset($carts) && !empty($carts)){

          

          }

          ?>

          

          

          

          <!--<div class="rightbtns">

            <input class="checkout" value="Continue Shopping" type="submit">

            <input class="continue" value="CheckOut" type="submit">carttopx2 yoption2

          </div>-->

          <div class="carttopx">

            <div class="description"><strong>Product</strong></div>

            <div class="yoption"><strong>Quantity</strong></div>

            <div class="cartpricebox"><strong>Price</strong></div>

            <div class="cartpricebox"><strong>Total</strong></div>

            <!--<div class="cartpricebox"><strong>Status</strong></div>-->

          </div>

        

        <?php

		# echo '<pre>'.print_r($arrData['cart'],true).'</pre>';

		//if(isset($arrValue) && !empty($arrValue)){
	if((isset($cart) && !empty($cart)) || (isset($order) && !empty($order)) || (isset($billing) && !empty($billing)) || (isset($shipping) && !empty($shipping))){
			

			$sub_total=0;

			$delivery=$cart[0]['order_delivery_charges'];

			$tax=$cart[0]['order_tax'];

			$discount=$cart[0]['cop_amount'];

			$grand_total1=$cart[0]['order_grand_total'];

		  

			foreach($cart as $post){

				

				$product_id=$post['product_id'];
				$product_quantity=$post['product_quantity'];
				$product_price=$post['product_price'];

				$mfa=@reset(json_decode( json_encode(DB::select("select * from product where product_id='".$product_id."'")) , true));
				
				# Unit Price
				$mfa_unit=json_decode( json_encode(DB::select("select * from unit u inner join unit_product up on u.unit_id=up.unit_id where up.product_id='".intval(trim($post['product_id']))."' and up.unit_id='".intval(trim($post['unit_id']))."'")) , true);

				$is_Special=0;

				$is_Special_Text="";

				if($mfa['product_featured']==2){

					$price=trim($mfa_unit['product_price']);

					$is_Special=1;

					$is_Special_Text=" <div class='special_text'>S</div>";

				}

				

				

				$total=$product_price*intval($product_quantity);

				$sub_total+=$total;

				

				$status = '<span style=color:red>Open</span>';

				if($post['order_status']==1){

					$status = '<span style=color:green>Close</span>';

				}

				

		

		?>

          <form action="<?php echo 'index.php?controller=cart&function=update'?>" method="post" id="form_<?php echo intval($post['product_id'])?>">

          <div class="carttopx2">

            <div class="description2">
				<?php $image = url('').'/uploads/product/'.$post['product_image']; ?>
              <div class="boot"> <img src="<?php echo $image; ?>" width="100" height="100" /> </div>

              <div class="boottxt">

              <strong>

              	<a href="{{ url('product-detail/'.$post['product_id'] ) }}">

			  		<?php echo stripslashes($post['product_title']).$is_Special_Text?>

                </a>

              </strong>

			  <?php /*?><br />

              <strong><span>Unit</span></strong>&nbsp;<?php echo stripslashes($mfa_unit['unit_title'])?><?php */?>

              </div>

            </div>

            <div class="yoption2"><label><?php echo intval($product_quantity)?></label></div>

            <input type="hidden" name="product_id" value="<?php echo intval($post['product_id'])?>">

            <div class="cartpricebox2"><?php echo "$".number_format(stripslashes($post['product_price']), 2)?></div>

            <div class="cartpricebox2"><?php echo "$".number_format(trim($total), 2)?></div>

            <?php /*?><div class="cartpricebox2"><?php echo $status?></div><?php */?>

          </div>

          </form>

          

		  <?php 

			}

			

		}

		

		else{

			

			echo "<h2 class='error'>No Record Found</h2>";

		}

		  

		$td_width='76%';

		$td_bg='#fff';

		$b_ul="style='text-decoration:underline'";

		$tr_border="style='border:0 none'";

		?>       

          

          <div class="clear"></div>

          <table id="tbl_address" width="100%" border="0" style="float: right;">

            

            <tr <?php echo $tr_border?>>

                <td <?php echo $tr_border?> align="right" width="<?php echo $td_width?>"><b <?php echo $b_ul?>>Order Status:</b></td>

                <td <?php echo $tr_border?> align="left" width="100%" bgcolor="<?php echo $td_bg?>"><?php echo "&nbsp;".$status?></td>

            </tr>

            

            <tr <?php echo $tr_border?>>

                <td <?php echo $tr_border?> align="right" width="<?php echo $td_width?>"><b <?php echo $b_ul?>>Sub Total:</b></td>

                <td <?php echo $tr_border?> align="left" width="100%" bgcolor="<?php echo $td_bg?>"><?php echo "&nbsp;$".number_format($sub_total, 2)?></td>

            </tr>

            

            

            

            <tr <?php echo $tr_border?>>

                <td <?php echo $tr_border?> align="right" width="<?php echo $td_width?>"><b <?php echo $b_ul?>>Shipping & Handling Fee:</b></td>

                <td <?php echo $tr_border?> align="left" width="100%" bgcolor="<?php echo $td_bg?>"><?php echo "<span>"."+&nbsp;$".number_format($delivery, 2)."</span>"?></td>

            </tr>

            

            <tr <?php echo $tr_border?>>

                <td <?php echo $tr_border?> align="right" width="<?php echo $td_width?>"><b <?php echo $b_ul?>>Tax:</b></td>

                <td <?php echo $tr_border?> align="left" width="100%" bgcolor="<?php echo $td_bg?>"><?php echo "<span>"."+&nbsp;$".number_format($tax, 2)."</span>"?></td>

            </tr>

            

            <tr <?php echo $tr_border?>>

                <td <?php echo $tr_border?> align="right" width="<?php echo $td_width?>"><b <?php echo $b_ul?>>Discount:</b></td>

                <td <?php echo $tr_border?> align="left" width="100%" bgcolor="<?php echo $td_bg?>"><?php echo "<span>"."-&nbsp;$".number_format($discount, 2)."</span>"?></td>

            </tr>

            

            <tr <?php echo $tr_border?>>

                <td <?php echo $tr_border?> align="right" width="<?php echo $td_width?>"><b <?php echo $b_ul?>>Grand Total:</b></td>

                <td <?php echo $tr_border?> align="left" width="100%" bgcolor="<?php echo $td_bg?>"><?php echo "<span>"."&nbsp;$".number_format($grand_total1, 2)."</span>"?></td>

            </tr>

          </table>

          

          

          

          

          

          <div class="mttop25"></div>

          

          

          

          

          

          

          <?php

          if(isset($arrData['si'])){

			  

			  $td_width='50%';

		  ?>

          

          

          <div class="mttop25"></div>

          <h1>Billing Address</h1>

          <table id="tbl_address" style="">

 

            

            <tr>

            	<td width="<?php echo $td_width?>"><b>Address</b></td>

                <td width="<?php echo $td_width?>"><?php echo $billing[0]['obd_address']?></td>

            </tr>

            <tr>

            	<td width="<?php echo $td_width?>"><b>Zip Code</b></td>

                <td width="<?php echo $td_width?>"><?php echo $billing[0]['obd_zip']?></td>

            </tr>

            <tr>

            	<td width="<?php echo $td_width?>"><b>City</b></td>

                <td width="<?php echo $td_width?>"><?php echo $billing[0]['obd_city']?></td>

            </tr>

            <tr>

            	<td width="<?php echo $td_width?>"><b>State</b></td>

                <td width="<?php echo $td_width?>"><?php echo Helper::instance()->states[$billing[0]['obd_state']]?></td>

            </tr>

            

            

          </table>

          

          <div class="mttop25"></div>

          <h1>Shipping Address</h1>

          <table id="tbl_address" style="">

        	

            <?php 

			if(empty($arrData['shipping'])){

				echo "<tr><td width='100%' colspan='2'>Same as Billing</td></tr>";

			}

			

			else{

			?>

            

            

            <tr>

            	<td width="<?php echo $td_width?>"><b>Address</b></td>

                <td width="<?php echo $td_width?>"><?php echo $shipping[0]['osd_address']?></td>

            </tr>

            <tr>

            	<td width="<?php echo $td_width?>"><b>Zip Code</b></td>

                <td width="<?php echo $td_width?>"><?php echo $shipping[0]['osd_zip']?></td>

            </tr>

            <tr>

            	<td width="<?php echo $td_width?>"><b>City</b></td>

                <td width="<?php echo $td_width?>"><?php echo $shipping[0]['osd_city']?></td>

            </tr>

            <tr>

            	<td width="<?php echo $td_width?>"><b>State</b></td>

                <td width="<?php echo $td_width?>"><?php echo Helper::instance()->states[$shipping[0]['osd_state']]?></td>

            </tr>

            

            <?php

			}

			?>

            

            

          </table>

          

          

          <?php 

		  }

		  ?>

          

          <div class="clear"></div>

          

          

          

          

          

          

          

          <?php

		  # echo '<pre>'.print_r($arrData['si'],true).'</pre>';

		  if(isset($si) && !empty($si)){  

		  

		

		foreach($si as $value){

			

			

			

			

			

			

			$sub_total=0;

			$delivery=trim($value['order_delivery_charges']);

			# $grand_total=trim($value['order_gtotal']);

		  		  

			$date=strtotime($value['si_date']);

			$date=date("y/m/d g:i a", $date);

			?>

			<br />

			<h2>Price Adjustment Detail ( <span class="success" style="float:none"><?php echo stripslashes($date)?></span> )</h2>

			<div class="clear"></div>

			<br />

			<div class="carttopx">

			<div class="description"><strong>Product</strong></div>

			<div class="yoption"><strong>Quantity</strong></div>

			<div class="cartpricebox"><strong>Price</strong></div>

			<div class="cartpricebox"><strong>Total</strong></div>

			<!--<div class="cartpricebox"><strong>Status</strong></div>-->

			</div>

			

			<?php
			$query = @reset(json_decode( json_encode(DB::select("select * from standard_invoicing_detail where si_id='".$value['si_id']."' order by sid_id ASC")) , true));
			$rows = count($query);
			
			if($rows > 0){

				
				$post= $query;
				

				//while($post=mysql_fetch_assoc($queryS)){
				while($post=$query){
				

					$product_id=intval(trim($post['product_id']));

					$product_quantity=intval(trim($post['product_quantity']));

					$product_price=trim($post['product_price']);
				
					$mfa = json_decode( json_encode(DB::select("select * from product where product_id='".$product_id."'")) , true);
					
					# Unit Price

					
					$mfa_unit = json_decode( json_encode(DB::select("select * from unit u inner join unit_product up on u.unit_id=up.unit_id where up.product_id='".intval(trim($post['product_id']))."' and up.unit_id='".intval(trim($post['unit_id']))."'")) , true);
					

					

					$is_Special=0;

					$is_Special_Text="";

					if($mfa['product_featured']==2){

						$price=trim($mfa_unit['product_price']);

						$is_Special=1;

						$is_Special_Text=" <div class='special_text'>S</div>";

					}

					

					

					$total=$product_price*intval($product_quantity);

					$sub_total+=$total;

				

		

		?>

          <form action="<?php echo 'index.php?controller=cart&function=update'?>" method="post" id="form_<?php echo intval($post['product_id'])?>">

          	<div class="carttopx2">

            <div class="description2">

              <div class="boot"> <img src="image.php?width=100&height=100&image=<?php echo 'admin/'.$post['product_image']?>" /> </div>

              <div class="boottxt">

              <strong>

              	<a href="<?php echo 'index.php?controller=product&function=index&id='.intval($post['product_id'])?>">

			  		<?php echo stripslashes($mfa['product_title']).$is_Special_Text?>

                </a>

              </strong>

              <br />

              <strong><span>Unit</span></strong>&nbsp;<?php echo stripslashes($mfa_unit['unit_title'])?>

              </div>

            </div>

            <div class="yoption2">Quantity: <input type="text" class="textbox" value="<?php echo intval($product_quantity)?>" name="quantity"></div>

            <input type="hidden" name="product_id" value="<?php echo intval($post['product_id'])?>">

            <div class="cartpricebox2"><?php echo "$".number_format(stripslashes($post['product_price']), 2)?></div>

            <div class="cartpricebox2"><?php echo "$".number_format(trim($total), 2)?></div>

            <?php /*?><div class="cartpricebox2"><?php echo $status?></div><?php */?>

          </div>

          </form>

          

		  <?php

				}

		  ?>

          

          <div class="clear"></div>

          <div class="subtotal">Subtotal <?php echo "$".number_format($sub_total, 2)?> </div>

          <div class="clear"></div>

          

          <?php

		  if(trim($value['order_tax'])!='' && trim($value['order_tax'])!=0){

				

				$percent=trim($value['order_tax'])/100*$sub_total;

                $sub_total=$sub_total+$percent;

		  ?>

            

                <div class="clear"></div>

                <div class="subtotal">Tax <?php echo '$'.number_format($percent,2)?> </div>

                <div class="clear"></div>

                

                <div class="clear"></div>

                <div class="subtotal">Total <?php echo '$'.number_format($sub_total, 2)?> </div>

                <div class="clear"></div>

            

          <?php 

		  }

		  ?>

          

          

          

          

          <?php

            if($value['ct_id']){	

                

                $str='';

                $off='';

                $amount='';

                $ship='';

                if($value['ct_id']==1){

                    $ship='Free Shipping';

                }

                if($value['ct_id']==2){

                    $str=trim($value['cop_value']);

                    $off='% Off';

                }

                if($value['ct_id']==3){

                    $str=trim($value['cop_value']);

                    $amount='$';

                }

                if($off!=''){

                    $percent=$str/100*$sub_total;

                    $sub_total=$sub_total-$percent;

                }

                if($amount!=''){

                    $dollar=$str;

                    $sub_total=$sub_total-$dollar;

                }?>

            

			

            

                <div class="clear"></div>

                <div class="subtotal">Coupon <?php echo $amount.$str.$off.$ship?> </div>

                <div class="clear"></div>

            

			

			<?php

            }

            ?>

          

          

          

          

          

          <div class="clear"></div>

          <div class="subtotal">Shipping <?php echo "$".number_format($delivery, 2)?> </div>

          <div class="clear"></div>

          

          <div class="clear"></div>

          <div class="subtotal">Grand Total <?php echo "$".number_format($sub_total + $delivery, 2)?> </div>

          <div class="clear"></div>

          

          

          <?php

			}

		}

		  }

		  ?>

          

          

          

          

          

          

          

          

          

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