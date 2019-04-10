@extends('frontwebsite._mainLayout')
@section('content')
	
<script type="text/javascript">

function updateCart(){

	$('#form_update').submit();
	

}


function updateCartServer(pid,uid){



	var qnty=$('#1inp' + pid).val();

	

	if(window.XMLHttpRequest){

		xmlhttp=new XMLHttpRequest();

	}

	else{

		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

	}

	

	xmlhttp.onreadystatechange=function(){

	if(xmlhttp.readyState==4 && xmlhttp.status==200){

		array=xmlhttp.responseText.split('__');

		document.getElementById("price_" + pid).innerHTML=array[0];

		document.getElementById("subtotal").innerHTML=array[1];

		<!--document.getElementById("gtotal").innerHTML=array[1];-->

		$('#update_'+pid).css('display','none');

		$('#save_'+pid).css('display','block');
		
		setTimeout(function(){ 
			$('#save_'+pid).css('display','none'); 
		}, 2000);

	}

	

	}


var path= "{{url('')}}" + "/cart_update2/"+pid+"/"+qnty+"/"+uid;

xmlhttp.open("GET",path,true);

xmlhttp.send();



}

</script>    
<style>
textarea:focus, input:focus, select:focus, input[type]:focus, .uneditable-input:focus {
	border-color: #00478f;
	/*box-shadow: 0 1px 1px  #00478f inset, 0 0 8px #00478f;*/
	outline: 0 none;
}
.start_here {
	color: #08c !important;
}
.start_here:hover {
	color: #08c;
	text-decoration: underline;
}
.btn_login {
	margin-left: 0px;
}
.cart_btnbig {
	text-decoration: none !important;
}
.dispaly_Cart a:hover {
	text-decoration: underline !important;
}
.input-group-addon {
    padding: 6px 12px !important;
}
</style>
    
    <div class="container">
  <div class="row main-contant">
    <div class="container contant-con">
      <div class="col-lg-12">
        <div class="col-lg-12">
          <div class="col-lg-12 pad-left">
            <div class="cart">
              <h1 class="h1">Shopping Cart</h1>
              <form action="{{ url('cart_update') }}" method="post" id="form_update">
                
				{{ csrf_field() }}
				<?php

				 $cookie_id=session()->get('user_fname').session()->get('user_id');
                 $cookie_sql = DB::select("select product_id, unit_id, product_quantity from cookie_cart where cookie_id='".$cookie_id."'");
				 
                 $cookie_row=count($cookie_sql);
                 $arr_cookie=array();
                 $pid=array();
                 $uid=array();
                 $q=array();
                 /*if(!is_array($_SESSION['cart'])){
                 	$_SESSION['cart']=array();
                 }*/
                 if ($cookie_row>0) {
                 	foreach($cookie_sql as $cookie_items){	
						$pid[]=$cookie_items->product_id;
						$uid[]=$cookie_items->unit_id;
						$q[]=$cookie_items->product_quantity;
					}
                  	
					//jugart
					session()->pull('cart');
					
                 	for($i=0; $i<count($pid); $i++) { 
						/*$_SESSION['cart'][$i]['product_id']=$pid[$i];
						$_SESSION['cart'][$i]['unit_id']=$uid[$i];
						$_SESSION['cart'][$i]['product_quantity']=$q[$i];
						$_SESSION['cart'][$i]['product_bundle']=0;*/
						
						session()->push('cart', [
							'product_id' => $pid[$i],
							'unit_id' => $uid[$i],
							'product_quantity' => $q[$i],
							'product_bundle' => 0
						]);
						
                 	}
                 }

				//dd(session()->all());
				$cart = Session::get('cart');
				
                $sub_total=0;

                if(isset($cart[0]['product_id']) && !empty($cart[0]['product_id'])){

                ?>
                <table id="shopping-cart-table" class="data-table cart-table">
                  <thead>
                    <tr class="carttop">
                      <th><input type="checkbox" name="selectAll" id="selectAll" title="Select All" /></th>
                      <th class="pro-img"><span class="nobr">Image</span></th>
                      <th><span class="nobr">Product Name</span></th>
                      <th><span class="nobr">Move to Wishlist</span></th>
                      <th><span class="nobr">Unit Price</span></th>
                      <th class="qty_height"><span class="nobr">Qty</span></th>
                      <th><span class="nobr">Subtotal</span></th>
                      <th><span class="nobr">Remove</span></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php         
			$a="";
			$str="";
			$cart_checkbox = '';
			
			foreach(array_reverse($cart) as $post){
			
			$product_bundle=0;
			if($post['product_bundle']!=0){
				$product_bundle=$post['product_bundle'];
			}
			
			if(isset($post['configure_product']) and $post['configure_product']!=0){
				$manufacturer = $post['manufacturer'];
				$uom = $post['uom'];
				
				$manuf_rec = mysql_fetch_array(mysql_query("SELECT cpa_option FROM config_product_option where cpo_id=".$manufacturer));
				
				$uom_rec = mysql_fetch_array(mysql_query("SELECT cpa_option FROM config_product_option where cpo_id=".$uom));
			}
			
			$product_id=intval(trim($post['product_id']));

			$unit_id=intval(trim($post['unit_id']));

			$product_quantity=intval(trim($post['product_quantity']));

			$query = DB::select("select p.*, pm.product_image from product as p join product_image as pm on p.product_id= pm.product_id where p.product_id='".$product_id."'");
			
			$mfa = $query;
			
			# Unit Price
			$query_unit = DB::select("select * from unit u inner join unit_product up on u.unit_id=up.unit_id where up.product_id='".intval(trim($post['product_id']))."' and up.unit_id='".intval(trim($post['unit_id']))."'");
			
			//$mfa_unit=mysql_fetch_array($query_unit);
			$mfa_unit = $query_unit;	
			
			$price=0;
			$is_Special=0;
			$is_Special_Text='';
			
			if($mfa_unit){			
				if(trim($mfa_unit[0]->product_sprice) == ''){
					$price=trim($mfa_unit[0]->product_price);
				} else {
					$price=trim($mfa_unit[0]->product_sprice);
					$is_Special=1;
					$is_Special_Text="<div class='special_text'>".'$'.number_format(trim($mfa_unit[0]->product_price), 2)."</div>";
				}
			}
			

			$total=trim($price)*intval($product_quantity);

			$sub_total+=$total;
			
			# Bundle Product
			$bundle_unit_price=0;
			//PRODUCT BUNDLE
			
		
			?>
                    <tr class="first odd">
                      <td><input type="checkbox" name="quoteProduct<?php echo $post['product_id']?>" class="quoteProduct" id="quoteProduct<?php echo $post['product_id']?>" value="<?php echo $post['product_id']?>" onclick="quoteProduct(<?php echo $post['product_id']?>);" /></td>
                      <td><a href="{{ url('product-detail/') }}<?php echo '/'.$product_id; ?>"> <img src="{{ url('/uploads/product/' . trim($mfa[0]->product_image)) }}" alt="<?php echo stripslashes($mfa[0]->product_title)?>" class="img-responsive" width="100px"; > </a></td>
                      <td><a href="{{ url('product-detail/'.$product_id) }}"><?php echo stripslashes($mfa[0]->product_title)?></a></td>
                      <td><a onclick="document.getElementById('form_whish_<?php echo intval($product_id)?>').submit();">Move</a></td>
                      <td><?php
                        
							//echo '<span class="price">'."$".number_format(trim($price), 2).'</span>';
							echo '<span class="price">'."$".trim($price).'</span>';	
							echo $is_Special_Text;
						
						?></td>
                      <td><div class="form-group form-group-options">
                          <div id="1" class="input-group input-group-option quantity-wrapper"> <span class="input-group-addon input-group-addon-remove quantity-remove btn" id="minus_cart" onclick="minus_cart(<?php echo $mfa[0]->product_id; ?>, <?php echo $unit_id; ?>);"> <span class="glyphicon glyphicon-minus"></span> </span>
                            <input id="1inp<?php echo $mfa[0]->product_id; ?>" type="text" value="<?php echo intval($product_quantity)?>" onkeypress="showUpdateButton(<?php echo $mfa[0]->product_id?>)" name="qnty_<?php echo $mfa[0]->product_id?>" class="form-control quantity-count" style="margin:0;">
                            <span class="input-group-addon input-group-addon-remove quantity-add btn" id="plus_cart" onclick="plus_cart(<?php echo $mfa[0]->product_id; ?>, <?php echo $unit_id; ?>)"> <span class="glyphicon glyphicon-plus"></span> </span> </div>
                          <?php
						  $function="updateCartServer(".$mfa[0]->product_id.", ".$unit_id.")";
						  if($bundle_unit_price!=0){
							  
							  $function="updateCartServerBundle(".$mfa[0]->product_id.", ".$bundle_unit_price.")";
						  }
						  ?>
                          <a style="display: none; position: absolute; margin-left: 33px;" id="update_<?php echo $mfa[0]->product_id?>" href="javascript:<?php echo $function?>">Update</a> <span style="display: none; color:#F00; position: absolute; margin-left: 33px;" id="save_<?php echo $mfa[0]->product_id?>">Saved</span> </div></td>
                      <td><span class="price" id="price_<?php echo $mfa[0]->product_id?>">
                        <?php
                        if($bundle_unit_price!=0){
                        	echo "$".number_format(trim($bundle_unit_price)*$product_quantity, 2);
                        } else {
							echo "$".number_format(trim($total), 2);
						}
						?>
                        </span></td>
                      <td><a href="{{ url('product_remove/'.intval($mfa[0]->product_id).'/'.$unit_id) }}" title="Remove Item" class="btn-remove btn-remove2">Remove Item</a></td>
                    </tr>
                    <?php 					
					
			$cart_checkbox.='<input type="checkbox" name="quote1Product'.$post['product_id'].'" class="quote1Product" id="quote1Product'.$post['product_id'].'" value="'.$post['product_id'].'" style="display: none;" />';

			} ?>
                  </tbody>
                </table>
              
            <?php  ?>  
              </form>
              
                            <form action="https://www.medicalshipment.com/index.php?controller=favorites&function=index" method="post" id="form_whish_3156">
                      <input type="hidden" name="product_id" value="3156" />
                      <input type="hidden" name="unit_id_f" id="unit_id_f" value="7" />

                </form>
                              <div class="carttop-bottom">
                <div class="row">
                  <div class="col-lg-2"> <a href="javascript:history.go(-1);">
                    <button type="button" title="Continue Shopping" class="button btncart add_cart"><span>Continue Shopping</span></button>
                    </a> </div>
                  <div class="col-lg-2">
                    <form action="https://www.medicalshipment.com/index.php?controller=quote&function=index" method="post" name="copy_to_quotation" id="copy_to_quotation">
                      <input type="hidden" name="copy_quote" value="" />
                      <input type="checkbox" name="quote1Product3156" class="quote1Product" id="quote1Product3156" value="3156" style="display: none;" />                      <button type="button" title="Copy to Quotation" class="button btncart add_cart" onclick="copy_to_quotation_submit();"><span>Copy to Quotation</span></button>
                    </form>
                  </div>
                  <div class="col-lg-2"> <a href="{{ url('product_removeAll') }}">
                    <button type="button" name="update_cart_action" value="empty_cart" title="Clear Shopping Cart" class="button btn-empty btncart add_cart" id="empty_cart_button"><span>Clear Shopping Cart</span></button>
                    </a> </div>
                  <div class="col-lg-2">
                    <button type="submit" onclick="updateCart()" name="update_cart_action" value="update_qty" title="Update Shopping Cart" class="button btn-update btncart add_cart"><span>Update Shopping Cart</span></button>
                  </div>
                </div>
              </div>
              <div class="cart-collaterals">
                <div class="totals" style="float:right;background-color:#F9F9F9; border:1px solid #DBDBDB; margin:15px 0; padding:15px;">
                  <style type="text/css">

.a-right {

    text-align: left !important;

}

</style>
                  <table id="shopping-cart-totals-table">
                    <colgroup>
                    <col>
                    <col width="1">
                    </colgroup>
                    
                    <!--<tfoot>

                      <tr class="cartbotborder" >

                        <td style="" class="a-right" colspan="1"><strong>Shipping</strong></td>

                        <td style="" class="a-right" id="sveUkupno"><strong><span class="price">TBD</span></strong></td>

                      </tr>

                    </tfoot>-->
                    
                    <tbody>
                      <tr class="cartbotborder">
                        <td style="" class="a-right" colspan="1"> Subtotal </td>
                        <td style="" class="a-right" id="sveUkupno_sub"><span class="price" id="subtotal"><?php echo "$".number_format(trim($sub_total), 2)?></span></td>
                      </tr>
                      <!--<tr class="cartbotborder">
                        <td style="" class="a-right" colspan="1"> Grand Total </td>
                        <td style="" class="a-right" id="sveUkupno_sub"><span class="price" id="gtotal">$8.75</span></td>
                      </tr>-->
                    </tbody>
                  </table>
                                    <?php /*?><form action="https://www.medicalshipment.com/index.php?controller=cart&function=payment" method="post" id="form_pm" name="form_pm"><?php */?>
				<form action="{{ url('/checkoutpage') }}" method="post" id="form_pm" name="form_pm"> 
    				{{ csrf_field() }}                 
                    <div class="clear"></div>
                    <div class="subtotal">
                      <input type="hidden" class="continput" name="coupon" placeholder="Enter Coupon Code">
                      
                      <!--<input class="checkout" value="Enter Coupon" type="button" style="width:130px;border-radius:0 3px 3px 0;margin-top:20px;height:32px;background-image:none;background-color:#009900">--> 
                      
                    </div>
                    <div class="clear"></div>
                    <ul class="checkout-types">
                      <li style="text-align:center;">
                        <div id="button_change">
                          <button type="submit" class="button2 btn-proceed-checkout btn-checkout2 btncart add_cart" title=""><span style="display: inline-table;"><span style="margin-right:0px !important;color:#FFF">Proceed to Checkout</span></span></button>
                        </div>
                      </li>
                      <li style="text-align:center;">
                        <div id="button_change"> <a href="https://www.medicalshipment.com/checkout/onepage/" title=""></a> </div>
                      </li>
                    </ul>
                  </form>
                </div>
              </div>
            </div>
          </div>
          
          <?php } else {
          	echo "<h2 class='error'>Your cart is empty.</h2>";
          } ?>
                    <div class="clear"></div>
        </div>
      </div>
    </div>
  </div>
</div>
    
@endsection()