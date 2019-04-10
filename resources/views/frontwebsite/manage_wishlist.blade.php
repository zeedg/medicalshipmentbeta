@extends('frontwebsite._mainLayout')
@section('content')

<script type="text/javascript">

function cartAll(){

	var atLeastOneIsChecked = $('input[name="product_item[]"]:checked').length > 0;

	if(!atLeastOneIsChecked){

		alert('Atleast one item should be selected');

		return false;

	}

	else{

		document.form_fav.action='<?php echo 'index.php?controller=cart&function=index'?>';

		$('#form_fav').submit();	

	}

}


function RemoveAll(){

	var atLeastOneIsChecked = $('input[name="product_item[]"]:checked').length > 0;
	if(!atLeastOneIsChecked){

		alert('Atleast one item should be selected');

		return false;

	}

	else{

		document.form_fav.action='<?php echo 'index.php?controller=favorites&function=remove'?>';

		$('#form_fav').submit();

	}

}


function addCartSingle(pro_id){


//	$("input:checkbox[value=" + pro_fav_id + "]").attr("checked", true);

	document.form_fav.action='addto_cart';

	$('#form_fav'+pro_id).submit();

}


function addRemoveSingle(pro_id, fav_id){

//	$("input:checkbox[value=" + pro_fav_id + "]").attr("checked", true);
//	var form = 'form_fav'+pro_id;

//	document.form.action='<?php //echo 'index.php?controller=favorites&function=remove'?>';

	alert('favorites/remove/'+fav_id);
	window.location = '{{ url("favorites/remove/") }}/'+fav_id;
	
//	$('#form_fav'+pro_id).submit();

}

function changeUnitPrice(pid,uid,response_id){

//alert(pid + " " + uid + " " + response_id);

if(window.XMLHttpRequest){

	xmlhttp=new XMLHttpRequest();

} 

else {

	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}

xmlhttp.onreadystatechange=function() {

if(xmlhttp.readyState==4 && xmlhttp.status==200){

	document.getElementById("price_" + response_id).innerHTML=xmlhttp.responseText;
}

}

<?php $controller="'server'";?>

var con=<?php echo $controller?>;

var site=<?php echo "'"."'"?>;

var path=site + "index.php?controller=" + con + "&function=changeUnitPrice" + "&product_id=" + pid + "&unit_id=" + uid;

xmlhttp.open("GET",path,true);

xmlhttp.send();	

}
</script>
<script> 

function accordian(ids){

    $(".tbl_" + ids).fadeToggle( "slow", "linear" );

}

function doSearch(ids){

	keyword=$('#keyword').val();

	/*if(ids==0){

		var site=<?php echo "'"."'"?>;

		var path=site + "index.php?controller=favorites&function=index";

		window.location=path; 

	}*/

	if(window.XMLHttpRequest){

		xmlhttp=new XMLHttpRequest();
	} 

	else {

		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function() {
	if(xmlhttp.readyState==4 && xmlhttp.status==200){

		$('#loader').hide();
		document.getElementById("mycart").innerHTML=xmlhttp.responseText;

	}
	}
	<?php $controller="'server'";?>



	var con=<?php echo $controller?>;



	var site=<?php echo "'"."'"?>;



    var path=site + "index.php?controller=" + con + "&function=favorites" + "&category_id=" + ids + "&keyword=" + keyword;



	$('#loader').show();



	xmlhttp.open("GET",path,true);



	xmlhttp.send();	



}

</script>
<style type="text/css">
.cartboxcover h2 {
	float: none !important
}
.dynatable-active-page {
	background: none repeat scroll 0 0 #d5dbe2;
	border-radius: 5px;
	color: #333;
	padding-left: 5px;
	padding-right: 5px;
}
.dynatable-active-page:hover {
	color: #333;
}
.pricebox a, span {
	float: none;
}
.cat_title {
	background-color: #2692da;
	color: #fff;
	font-size: 18px;
	cursor: pointer;
}
.mycart span {
	color: lightskyblue;
	font-size: 14px;
}
.cartadd_link {
	color: #0F0 !important;
}
.cartremove_link {
	color: #F00 !important;
}
.loader {
	position: absolute;
	float: left;
	margin-left: 70px;
	margin-top: 23px;
}
.cart_btn {
	background: #50B738;
	margin-left: 5px;
}
.btncart {
	color: #FFF;
	width: 210px;
}
.list-group {
	min-height: 470px;
}
.container1 li {
	border-top: 1px solid #CCC;
	border-bottom: 1px solid #CCC;
}
.container1 li a {
	font-size: 20px;
	color: #555;
	margin: 0 0 -1px 10px;
	line-height: 35px;
}
.container1 .active {
	background: #007dc6;
	color: #FFF;
}
.container1 .active a {
	color: #FFF;
}
.a-span5, .a-span2 {
	background-color: #f3f3f3;
	color: #111;
	padding: 7px 1px 6px;
}
#offlajn-universal-product-slider-900-1-container {
	height: 410px;
}
.a-input-text {
	width: 390px;
	height: 36px;
	background: url(images/input_bgs.png) no-repeat;
	border: none;
}
.a-input-text:hover {
	background-color: #fff !important;
	background-image: none !important;
	border: 2px solid rgb(48, 129, 190) !important;
	box-shadow: 0 0 10px #1e7ec8 !important;
	height: 36px !important;
}
.new-product {
    top: 45% !important;
}
</style>

<div id="ajaxcart-popup" style="margin: -50px 0px 0px -125px; left: 40%; top: 40%; position: fixed; z-index: 1000;">
		<p onclick="close_popup();" class="close_popup"></p>
		<div>
			<button type="button" title="Continue Shopping" class="button btn-cart" id="ajaxcart-continue-shopping" onclick="close_popup();"> <span><span>
    <div style="display:inline; padding-top:20px; float:left;margin-top:23px; margin-left:93px;" id="ajaxcart-interval"></div>
    </span></span></button>
		</div>
		<div id="ajaxcart-user-choice"></div>
		<div><a href="{{ url('addto_cart') }}">
				<button type="button" title="Go to cart" class="button_btn_cart" id="ajaxcart-go-to-cart"><span><span></span></span></button>
			</a></div>
	</div>

<div class="container">
  <div class="row main-contant">
    <div class="container contant-con">
      <h1 class="h1">Manage Wish Lists</h1>
      <div class="col-lg-3">
        <div class="col-lg-12">
          <div class="list-group">
            <div class="container1">
              <?php 
			  
			if(isset($wishlists) && !empty($wishlists)){ 
			
				echo "<h2 style='text-align: center; margin: 0;'>Your Lists</h2>";
				echo "<ul>"; ?>
              <form id="wl-item-search" method="post" action="{{ url('favorites/manage_wishlist') }}">
                <div class="a-row a-spacing-none g-item-search">
                  <div class="a-search"> <i class="a-icon a-icon-search"></i>
                    {{ csrf_field() }}
                    <input type="search" placeholder="Find items across your lists" name="itemSearch" class="a-input-text" style="width: 85%;margin-left: 5%;border-right: 1px solid #CCC;border-top-right-radius: 5px;border-bottom-right-radius: 5px;">
                  </div>
                </div>
              </form>
              <?php
				foreach($wishlists as $wishlist){
					if(isset($_GET['w_id']) && $wishlist->id == $_GET['w_id']){ 
						$active = 'class="active"';
					} else {
						$active = '';
					}
					$fUrl = url('/').'/favorites/manage_wishlist/'.$wishlist->id;
					echo '<li style="list-style: none;" "'.$active.'"><a href="'.$fUrl.'">'.$wishlist->wishlist_name.' ('.$wishlist->tot.')</a></li>';
				}
				echo '</ul>';
			}
			echo '<a data-toggle="modal" data-target="#myModal"><input name="button" id="model_wishlist" class="button btncart add_cart" type="submit" value="Manage Wishlists" style="border: none;margin-bottom: 0px !important;"></a>';
			
			$faUrl = "{{ url('favorites/add_wishlist') }}";
			
			echo '<a href="'.$faUrl.'"><input name="button" class="button btncart add_cart" type="submit" value="Create Wishlist" style="border: none;"></a>';
			
			?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="bodyinner">
          <div class="cartboxcover"> <br />
            <br />
            <div class="mycart" id="mycart">
              <table class="a-normal a-align-top g-home-fixed-center">
                <tbody>
                  <?php
				if(isset($_GET['msg']) and $_GET['msg']=='sent'){
					echo '<p>Products added successfully to your wishlist</p>';
				}
				if(isset($_GET['msg']) and $_GET['msg']=='new_list'){
					echo '<p>New wishlist added successfully!</p>';
				}
				
				if(isset($fav) && !empty($fav)){ 
			
					foreach($fav as $mfa){
						
						$product_id = intval($mfa->product_id);
						$fav_id = intval($mfa->fav_id);
						$unit_id = intval($mfa->unit_id);

						$date = strtotime($mfa->fav_date);
						$date = date("y/m/d g:i a", $date);
						
						$proID_favID_unitID = $product_id.'_'.$fav_id.'_'.$unit_id;

						$mfa_unit = DB::select("select * from unit u inner join unit_product up on u.unit_id=up.unit_id where up.product_id='".$product_id."' and up.unit_id='".$unit_id."'");
						
						# Get All Unit
						$query_unit_all = DB::select("select * from unit u inner join unit_product up on u.unit_id=up.unit_id where up.product_id='".$product_id."'");
						
						$mfaImg = DB::select("select product_image from product_image where product_id='".$product_id."' order by pi_id asc limit 0,1");					
						
						$pimg=trim($mfaImg[0]->product_image);

						$price=0;
						$is_Special=0;
						if(trim($mfa_unit[0]->product_sprice)==''){
							$price=trim($mfa_unit[0]->product_price);
						} else {
							$price=trim($mfa_unit[0]->product_sprice);
							$is_Special=1;
						}
						$image = url('').'/uploads/product/'.$pimg;
					?>
                <div class="col-lg-12" style="border-bottom: 1px solid #CCC; margin: 10px 0; padding: 10px 0;">
                  <form action="{{ url('addto_cart') }}" method="post" id="form_fav<?php echo $product_id; ?>" name="form_fav<?php echo $product_id; ?>">
                    <div class="col-lg-2"> <a href="{{ url('product-detail/' .$product_id ) }}"> <img src="<?php echo $image; ?>" width="100" class="img-responsive"> </a> </div>
                    <div class="col-lg-6">
                      <p><a href="{{ url('product-detail/' .$product_id ) }}"> <?php echo stripslashes($mfa->product_title)?> </a></p>
                      <p>Item No: <?php echo stripslashes($mfa->product_item_no)?></p>
                      <p>Price: <?php echo "$".number_format(trim($price), 2)?></p>
                    </div>
                    <div class="col-lg-3">
                      <p>
                        
                        <select name="unit_id" id="unit_id" class="wishlist_unit" onchange="changeUnitPrice('<?php echo $product_id?>',this.value,'<?php echo $proID_favID_unitID?>')" style="display: none;">
                          <?php
								foreach($query_unit_all as $mfa_unit_all){
									$selected="";

									if($mfa_unit_all->unit_id == $mfa_unit[0]->unit_id){

										$selected="selected='selected'";

									}

                            		echo "<option $selected value='".trim($mfa_unit_all->unit_id)."'>".trim(stripslashes($mfa_unit_all->unit_title))."</option>";
								}

								?>
                        </select>
                        {{ csrf_field() }}
                        <input type="hidden" name="fav_id" value="<?php echo trim($fav_id) ?>" />
                        <input type="hidden" name="product_id" value="<?php echo trim($product_id) ?>" />
                        <input type="hidden" name="cquantity" id="cquantity" value="1" />
                      </p>
                      <p>Added <?php echo $date?></p>
                      <button class="add_cart" type="submit" onclick="return addCartSingle('<?php echo $product_id?>');" style="border: none;"></button>
                      <button class="remove" type="button" onclick="return addRemoveSingle('<?php echo $product_id?>', '<?php echo $fav_id?>');" style="border: none;"></button>
                    </div>
                  </form>
                </div>
                <?php



					

					}
				}
				
				else{
					if(!isset($_GET['w_id']))
					{
					//	echo '<h2>Please select a list from left side</h2>';
					}
					else
					{
						echo '<h2>0 items on list</h2>';
					}
					
				}
				?>
                  </tbody>
                
              </table>
            </div>
            <div style="clear:both"></div>
          </div>
        </div>
        <div id="offlajn-universal-product-slider-900-1-container" class=" loading">
          <div class="off_uni_slider_header">
            <div class="title">CUSTOMERS WHO BOUGHT ITEMS IN YOUR WISH LIST ALSO BOUGHT</div>
          </div>
          <div class="controller">
            <div class="off-uni-slider-left new-product new-left" onmouseover="show_overflow('new');" onmouseout="hide_overflow('new');"></div>
            <div class="off-uni-slider-right new-product new-right" onmouseover="show_overflow('new');" onmouseout="hide_overflow('new');"></div>
          </div>
          <div class="offlajn-universal-product-slider-900-1-container-inner" id="new_scroller" onmouseover="show_overflow('new');" onmouseout="hide_overflow('new');">
          <?php
		  if(isset($new_collection) && !empty($new_collection)){ 
			foreach($new_collection as $product){
				$image = url('').'/uploads/product/'.$product->product_image;
			?>
            <div class="off-uni-slider-item">
              <div class="img_container"> <a href="{{ url('product-detail/' .$product->product_id ) }}" style="height: 170px; line-height: 170px;"><img class="off-uni-slider-img" src="<?php echo $image; ?>"/></a><span>
              <?php
              if(isset($product->product_sprice) > 0 && isset($product->product_sprice) != ''){ 
			  	//echo '$'.number_format($product->product_sprice,2);
				echo '$'.$product->product_sprice; 
			  } else { 
			  	echo '$0'; 
			  }
			  ?>
                </span></div>
              <span class="item_name"><a href="{{ url('product-detail/' .$product->product_id ) }}"><?php echo substr($product->product_title, 0,25).'...'; ?></a></span>
              <form id="form3_<?php echo $product->product_id; ?>" action="{{ url('addto_cart') }}" method="post" style="float: left;">
                <input type="hidden" name="qty_cart" id="qty_cart<?php echo $product->product_id; ?>" value="1" class="qty" />
                <input type="hidden" name="product_id" value="<?php echo intval($product->product_id)?>" />
                <input type="hidden" name="cquantity" id="cquantity<?php echo $product->product_id; ?>" value="1" />
                <input type="hidden" name="unit_id" id="unit_id<?php echo $product->product_id; ?>" value="<?php echo intval($product->unit_id)?>" />
              </form>
              <button class="addtocart" onclick="addCarthome(<?php echo $product->product_id; ?>);" ></button>
            </div>
            <?php }}?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="clearz"></div>

<script type="text/javascript">
$(document).ready(function(){
	<?php
	if(isset($_GET['msg']) and $_GET['msg']=='new_list'){ ?>
  		$('#model_wishlist').trigger('click');
  	<?php } ?>
	
});
	
	function get_wishlist(pid)
	{
		document.getElementById("wish_product_id").value = pid;
		$('#myWishList').trigger('click');
	}
</script>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog"> 
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" style="width: 5px; margin-top: -10px;">&times;</button>
      </div>
      <div class="modal-body">
        <form name="multi_wishlist" method="post" action="{{ url('favorites/manage_wishlist') }}">
          <table id="g-manage-table-wishlist" class="a-keyvalue a-spacing-mini" style="width: 100%;">
            <tbody>
              <tr>
                <th class="a-span5"> <span class="a-text-bold">Wish Lists</span> </th>
                <th class="a-span2"> <span class="a-text-bold">Default</span> </th>
                <th class="a-span2"> <span class="a-text-bold">Delete</span> </th>
              </tr>
              
              <?php
			  if(isset($wishlists) && !empty($wishlists)){ 
				foreach($wishlists as $wishlist){
			  ?>
              {{ csrf_field() }}
			  <tr>
                <td class="g-manage-name">
					<?php echo $wishlist->wishlist_name; ?>
                </td>
                <td class="g-manage-default">
					<input type="radio" name="default" value="<?php echo $wishlist->id; ?>" <?php if($wishlist->default_value == 1){ echo "checked='checked'"; } ?> >
                </td>
                <td class="g-manage-delete">
                	<input type="checkbox" name="delete[]" value="<?php echo $wishlist->id; ?>">
                </td>
              </tr>
              <?php } 
			  } ?>
              
              <tr>
                <td></td>
                <td colspan="2"><input name="submit" class="button btncart add_cart" type="submit" value="Submit" style="border: none;"></td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myWishList" role="dialog">
  <div class="modal-dialog"> 
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" style="width: 5px; margin-top: -10px;">&times;</button>
      </div>
      <div class="modal-body">
        <?php if(isset($arrData['wishlists']) && !empty($arrData['wishlists'])){ ?>
        <form action="{{ url('favorites/index') }}" method="post" id="form_whish_<?php echo  intval($product['p_id'])?>">
          <table id="g-manage-table-wishlist1" class="a-keyvalue a-spacing-mini" style="width: 100%;">
            <tbody>
              <tr>
                <th class="a-span8"> <input type="hidden" name="product_id" id="wish_product_id" />
                  <input type="hidden" name="unit_id_f" id="unit_id_f" value="7" />
                </th>
              </tr>
              <tr>
                <td class="g-manage-name"><select name="w_id" id="w_id" required="required">
                    <option value="">Select List</option>
                    <?php
				 		  		foreach($arrData['wishlists'] as $wishlist){ ?>
                    <option value="<?php echo $wishlist['id']; ?>"><?php echo $wishlist['wishlist_name']; ?></option>
                    <?php } ?>
                  </select></td>
              </tr>
              <tr>
                <td colspan="2"><input name="submit" class="button btncart add_cart" type="submit" value="Submit" style="border: none;"></td>
              </tr>
            </tbody>
          </table>
        </form>
        <? }
		else { ?>
        <form method="post" action="{{ url('favorites/add_wishlist') }}" class="a-spacing-top-small">
          <table id="g-manage-table-wishlist2" class="a-keyvalue a-spacing-mini" style="width: 100%;">
            <tbody>
              <tr>
                <th></th>
              </tr>
              <tr>
                <td class="a-span4 a-text-left a-align-bottom"><input type="hidden" name="u_id" value="<?php echo session()->get('user_id'); ?>">
                  <input type="text" name="wishlist_name" class="inqury_ipput" placeholder="Enter Wish List Name" required="required"></td>
              </tr>
              <tr>
                <td><button name="submitForm" class="button2 btn-proceed-checkout btn-checkout2 btncart add_cart" type="submit">Submit</button></td>
              </tr>
            </tbody>
          </table>
        </form>
        <?php } ?>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection()