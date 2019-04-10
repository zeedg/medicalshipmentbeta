
<?php
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;
?>
@extends('frontwebsite._mainLayout')
@section('content')
	<style>
		.add_wishlist, .add_cart, .add_quote {background: green; color: white; font-size: 17px; border: 1px solid black; border-radius: 7px; text-align: center; padding-top: 8px; margin-right: 10px;}
		
		.col-lg-12.inner-prod.bor-bot img {max-height: 200px;}
	</style>
 
 <?php
 
 $keyword = trim(stripslashes(urldecode((isset($_GET[ 'keyword' ])) ? $_GET[ 'keyword' ] : '')));
 function strip($str){
	 return trim(stripslashes($str));
 }
 function checkedAttributeItem($attr_item_id){
	 $flag = 0;
	 if(isset($_GET[ 'attribute' ])){
		 
		 $attr_str = trim($_GET[ 'attribute' ]);
		 $exp = explode('_', $attr_str);
		 foreach($exp as $val){
			 $exp_ = explode('.', $val);
			 if($exp_[ 2 ] == $attr_item_id){
				 $flag = 1;
			 }
		 }
	 }
	 return $flag;
 }
 function openAttributeCollapse($attr_id){
	 $flag = 0;
	 if(isset($_GET[ 'attribute' ])){
		 
		 $attr_str = trim($_GET[ 'attribute' ]);
		 $exp = explode('_', $attr_str);
		 foreach($exp as $val){
			 $exp_ = explode('.', $val);
			 if($exp_[ 0 ] == $attr_id){
				 $flag = 1;
			 }
		 }
	 }
	 return $flag;
 }
 function getPrevExpendy($str, $array){
	 $return = 0;
	 foreach($array as $val){
		 $expendy = $val[ 'expendy' ];
		 $attr_item = $val[ 'attr_item' ];
		 if($attr_item == $str){
			 $return = $expendy;
		 }
	 }
	 return $return;
 }
 
 ?>
	<link href="{{url('/frontend/')}}collaps/lib/demo.css" rel="stylesheet" type="text/css">
	<script src="{{url('/frontend/')}}collaps/lib/jquery.js"></script>
	<script src="{{url('/frontend/')}}collaps/lib/chili-1.7.pack.js"></script>
	<script src="{{url('/frontend/')}}collaps/lib/jquery.easing.js"></script>
	<script src="{{url('/frontend/')}}collaps/lib/jquery.dimensions.js"></script>
	<script src="{{url('/frontend/')}}collaps/lib/jquery.accordion.js"></script>
	<script type="text/javascript">
		 $.noConflict();
		 jQuery().ready(function () {
				 
				 jQuery('#navigation').accordion({
						 active : false ,
						 header : '.head' ,
						 navigation : true ,
						 event : 'mouseover' ,
						 fillSpace : true ,
						 animated : 'easeslide'
				 });
				 
				 
		 });
		 
		 /*function price_string(price) {
				 var url = window.location.href
				 
				 url = url + "/&price=" + price;
				 return url;
		 }*/
		 
		 function price_string(price){
			var url = window.location.href
				var n=url.search("price");
			
			if(n==-1){
				url=url + "/&price="+price;	
			}
			else{			
					array=url.split("&");
					str="";
					for(i=0;i<array.length;i++){
						
						var n=array[i].search("price");
						if(n==-1){
							var m=array[i].search("attribute");
							if(m==-1){
								str+=array[i] + "&";
							}
						} else {
							/*if(price.trim()!=''){
								str=str + "price="+price;
								
							} else {*/
								
								var wlh = window.location.href
								var wlh2 = wlh.replace("category/", "category?id="); 
								
								var url2=removeParam('price', wlh2);
								str = url2.replace("category?id=", "category/");
								
								var n2 = str.endsWith("/");
								
								if(n2 == true){
									str=str.substring(0, str.length - 1);	
								}
								
								if(price.trim()!=''){
									str=str + "/&price="+price;
								}
								
							//}
						}
					}
					url=str;
			}
			return url;
		}
		 
		 
		 function size_string(size) {
				 var url = window.location.href
				 var n = url.search("size");
				 
				 if (n == -1) {
						 url = url + "&size=" + size;
				 } else {
						 array = url.split("&");
						 str = "";
						 for (i = 0; i < array.length; i++) {
								 
								 var n = array[i].search("size");
								 if (n == -1) {
										 str += array[i] + "&";
								 } else {
										 if (size.trim() != '') {
												 str = str + "size=" + size;
										 } else {
												 str = str.substring(0 , str.length - 1);
										 }
								 }
						 }
						 url = str;
				 }
				 return url;
		 }
		 
		 function meterial_string(meterial) {
				 var url = window.location.href
				 var n = url.search("meterial");
				 
				 if (n == -1) {
						 url = url + "&meterial=" + meterial;
				 } else {
						 array = url.split("&");
						 str = "";
						 for (i = 0; i < array.length; i++) {
								 
								 var n = array[i].search("meterial");
								 if (n == -1) {
										 str += array[i] + "&";
								 } else {
										 if (meterial.trim() != '') {
												 str = str + "meterial=" + meterial;
										 } else {
												 str = str.substring(0 , str.length - 1);
										 }
								 }
						 }
						 url = str;
				 }
				 return url;
		 }
		 
		 function offer_string(offer) {
				 var url = window.location.href
				 var n = url.search("special_offer");
				 
				 if (n == -1) {
						 url = url + "&special_offer=" + offer;
				 } else {
						 array = url.split("&");
						 str = "";
						 for (i = 0; i < array.length; i++) {
								 
								 var n = array[i].search("special_offer");
								 if (n == -1) {
										 str += array[i] + "&";
								 } else {
										 if (offer.trim() != '') {
												 str = str + "special_offer=" + offer;
										 } else {
												 str = str.substring(0 , str.length - 1);
										 }
								 }
						 }
						 url = str;
				 }
				 return url;
		 }
		 
		 function view_string(view) {
				 var url = window.location.href
				 var n = url.search("grid");
				 
				 if (n == -1) {
						 url = url + "&grid=" + view;
				 } else {
						 array = url.split("&");
						 str = "";
						 for (i = 0; i < array.length; i++) {
								 
								 var n = array[i].search("grid");
								 if (n == -1) {
										 str += array[i] + "&";
								 } else {
										 if (view.trim() != '') {
												 str = str + "grid=" + view;
										 } else {
												 str = str.substring(0 , str.length - 1);
										 }
								 }
						 }
						 url = str;
				 }
				 return url;
		 }
		 
		 function manuf_string(brand) {
				 var url = window.location.href
				 var n = url.search("brand");
				 
				 if (n == -1) {
						 url = url + "&brand=" + brand;
				 } else {
						 array = url.split("&");
						 str = "";
						 for (i = 0; i < array.length; i++) {
								 
								 var n = array[i].search("brand");
								 if (n == -1) {
										 str += array[i] + "&";
								 } else {
										 if (brand.trim() != '') {
												 str = str + "brand=" + brand;
										 } else {
												 str = str.substring(0 , str.length - 1);
										 }
								 }
						 }
						 url = str;
				 }
				 return url;
		 }
		 
		 function match_string(val) {
			 var url = window.location.href
			 var n = url.search("match");
			 
			 if (n == -1) {
					 url = url + "/&match=" + val;
			 } else {
					 array = url.split("&");
					 str = "";
					 for (i = 0; i < array.length; i++) {
							 
							 var n = array[i].search("match");
							 if (n == -1) {
									 str += array[i] + "&";
							 } else {
									 if (val.trim() != '') {
											 str = str + "match=" + val;
									 } else {
											 //	alert(str);	
									 }
							 }
					 }
					 if (str.charAt(str.length - 1) == '&') {
						str = str.substring(0 , str.length - 1);	// Trim last & operator
					 	str = str.replace("http://localhost/manager/category/2/", "http://localhost/manager/category/2");
					 }
					 url = str;
			 }
			 return url;
		 }
		 
		 function fromto_price_string(from_price,to_price) {
				 var url = window.location.href		 
				 url = url + "/&fromto=" + from_price + "-" + to_price;
				 return url;
		 }
		 
		 function fromto_top_price_string(from_price,to_price) {
				 var url = window.location.href		 
				 url = url + "/&fromto=" + from_price + "-" + to_price;
				 return url;
		 }
		 
		 function submit_filter(val) {
				 if (val == 'from_to') {
						 var from_price = document.getElementById('from_price').value;
						 var to_price = document.getElementById('to_price').value;
						 var url = fromto_price_string(from_price,to_price);
						 window.location = url;
				 } else if (val == 'top_from_to') {
						 var from_price = document.getElementById('top_from_price').value;
						 var to_price = document.getElementById('top_to_price').value;
						 //var url = window.location.href + "&from_price=" + from_price + "&to_price=" + to_price;
						 var url = fromto_top_price_string(from_price,to_price);
						 window.location = url;
				 } else if (val == 'price05') {
						 if (document.getElementById('price05').checked == false) {
								 val = '';
						 }
						 var url = price_string(val);
						 window.location = url;
				 } else if (val == 'price510') {
						 if (document.getElementById('price510').checked == false) {
								 val = '';
						 }
						 var url = price_string(val);
						 window.location = url;
				 } else if (val == 'price1020') {
						 if (document.getElementById('price1020').checked == false) {
								 val = '';
						 }
						 var url = price_string(val);
						 window.location = url;
				 } else if (val == 'price20100') {
						 if (document.getElementById('price20100').checked == false) {
								 val = '';
						 }
						 var url = price_string(val);
						 window.location = url;
				 } else if (val == 'price100') {
						 if (document.getElementById('price100').checked == false) {
								 val = '';
						 }
						 var url = price_string(val);
						 window.location = url;
				 } else if (val == 'Small') {
						 if (document.getElementById('s').checked == false) {
								 val = '';
						 }
						 var url = size_string(val);
						 window.location = url;
				 } else if (val == 'Medium') {
						 if (document.getElementById('m').checked == false) {
								 val = '';
						 }
						 var url = size_string(val);
						 window.location = url;
				 } else if (val == 'Large') {
						 if (document.getElementById('l').checked == false) {
								 val = '';
						 }
						 var url = size_string(val);
						 window.location = url;
				 } else if (val == 'X-Large') {
						 if (document.getElementById('xl').checked == false) {
								 val = '';
						 }
						 var url = size_string(val);
						 window.location = url;
				 } else if (val == 'Latex-Free') {
						 if (document.getElementById('cotton').checked == false) {
								 val = '';
						 }
						 var url = meterial_string(val);
						 window.location = url;
				 } else if (val == 'Metal') {
						 if (document.getElementById('Metal').checked == false) {
								 val = '';
						 }
						 var url = meterial_string(val);
						 window.location = url;
				 } else if (val == 'Latex') {
						 if (document.getElementById('Latex').checked == false) {
								 val = '';
						 }
						 var url = meterial_string(val);
						 window.location = url;
				 } else if (val == 'sprice') {
						 if (document.getElementById('sprice').checked == false) {
								 val = '';
						 }
						 var url = offer_string(val);
						 window.location = url;
				 } else if (val == 'nprice') {
						 if (document.getElementById('nprice').checked == false) {
								 val = '';
						 }
						 var url = offer_string(val);
						 window.location = url;
				 } else if (val == 'false' || val == 'true') {
						 var url = view_string(val);
						 window.location = url;
				 }
		 }
		 
		 function submit_manufacture(val) {
				 if (document.getElementById('manufacture' + val).checked == false) {
						 val = '';
				 }
				 var url = manuf_string(val);
				 window.location = url;
		 }
		 
		 function submit_match(val) {
				 if (document.getElementById(val).checked == false) {
						 val = '';
				 }
				 var url = match_string(val);
				 window.location = url;
		 }
	</script>
	<link href="{{url('/frontend/')}}/css/expandy.css" rel="stylesheet">
	<style type="text/css">
		.prodtxt {
			background-color: #d5dbe2;
			padding: 5px;
			border-radius: 4px
		}
		
		.bodycontent h1 {
			width: auto
		}
		
		.proright {
			width: 60%
		}
		
		.proimage {
			border-radius: 0;
			border: 0 none;
			background-color: #FFF;
			float: left;
			padding-right: 2%;
		}
		
		.proimage img {
			border-radius: 4px;
		}
		
		#links {
			color: #FFF;
			text-decoration: underline !important;
		}
		
		.col-lg-3 {
			margin-right: 0;
		}
		
		#from_price:hover, #to_price:hover, #price05:hover, #price510:hover, #price1020:hover, #price20100:hover, #price100:hover, #s:hover, #m:hover, #l:hover, #xl:hover, #cotton:hover, #Metal:hover, #Latex:hover, #sprice:hover, #nprice:hover {
			border: 1px solid #007dc6;
		}
		
		#top_from_price:hover, #top_to_price:hover, #best_seller:hover, #low_to_high:hover, #high_to_low:hover, .manufacture:hover {
			border: 1px solid #007dc6 !important;
		}
		
		input[type=checkbox]:checked, .prinput input[type="checkbox"]:checked {
			/*background: url('images/check.png') no-repeat 3px 1px !important;*/
			background: url("{{ url('/')}}/uploads/images/check.png") no-repeat 3px 1px !important;
			border: 1px solid #007dc6 !important;
		}
	</style>
	<div class="container">
		<div class="row main-contant">
			<div class="container contant-con">
				<div class="col-lg-3">
			<?php
			# echo '<pre>'.print_r($arrData['expendy_old_ids'],true).'</pre>';
			if(isset($arrData[ 'search_attribute' ]) && !empty($arrData[ 'search_attribute' ])){
				echo $arrData[ 'search_attribute' ];
			}
			?>
					<div class="col-lg-12">
						<div class="list-group">
				<?php
				/*$categoryList = fetchCategoryTree();
				
				foreach($categoryList as $cl) {
				
				
				$name=trim(stripslashes($cl["name"]));
				if(strpos($name,'�') == false) {
					$name='<b style="color:#00478f;font-size:16px">'.trim(stripslashes($cl["name"])).'</b>';
				}
				
				$value=$cl["id"];
				if($value==$_GET["id"])
				{ $active = 'style="font-weight:bold; background-color: #ccc; padding-left: 5px;"'; }
				else{ $active = ''; }
				echo '<a href="'.url('').'index.php?controller=category&function=index&id='.$value.'" class="list-group-item list" '.$active.'>'.$name.'</a>';
				}*/
				?>
				<?php
				if(!isset($_GET[ 'grid' ]) or $_GET[ 'grid' ] == 'false'){
					$grid = 'false';
				}else{
					$grid = 'true';
				}
				?>
							<div class="container1">
								<form name="product_filter" id="product_filter" method="get" action="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
                                
									<h2>Price</h2>
									<p <?php if(isset($_GET[ 'price' ])){
					 echo "style='display: block;'";
				 } ?>>
									<div class="prinput"> $
										<input type="hidden" name="left_filter" value="left_filter">
										<input type="text" name="from_price" id="from_price">
																															to $
										<input type="text" name="to_price" id="to_price">
										<input type="button" name="price_go" value="GO" onclick="submit_filter('from_to');">
										<br/>
										<input type="checkbox" name="price" id="price05" value="0-5" onclick="submit_filter('price05');" <?php if(isset($_GET[ 'price' ]) && $_GET[ 'price' ] == 'price05'){
						echo "checked='checked'";
					} ?> />
										<label for="price05">$0 - $5 </label>
										<br/>
                                        
										<br/>
										<input type="checkbox" name="price" id="price510" value="5-10" onclick="submit_filter('price510');" <?php if(isset($_GET[ 'price' ]) && $_GET[ 'price' ] == 'price510'){
						echo "checked='checked'";
					} ?> />
										<label for="price510">$5 - $10 </label>
										<br/>
										<br/>
										<input type="checkbox" name="price" id="price1020" value="10-20" onclick="submit_filter('price1020');" <?php if(isset($_GET[ 'price' ]) && $_GET[ 'price' ] == 'price1020'){
						echo "checked='checked'";
					} ?> />
										<label for="price1020">$10 - $20 </label>
										<br/>
										<br/>
										<input type="checkbox" name="price" id="price20100" value="20-100" onclick="submit_filter('price20100');" <?php if(isset($_GET[ 'price' ]) && $_GET[ 'price' ] == 'price20100'){
						echo "checked='checked'";
					} ?> />
										<label for="price20100">$20 - $100 </label>
										<br/>
										<br/>
										<input type="checkbox" name="price" id="price100" value="100+" onclick="submit_filter('price100');" <?php if(isset($_GET[ 'price' ]) && $_GET[ 'price' ] == 'price100'){
						echo "checked='checked'";
					} ?> />
										<label for="price100">$100+ </label>
										<br/>
										<br/>
									</div>
									</p>
								<!--<h2>Popular Sizes</h2>
                <p>
                <div class="prinput">
                  <input type="checkbox" id="s" onclick="submit_filter('Small');" <?php if(isset($_GET[ 'size' ]) && $_GET[ 'size' ] == 'Small'){
					echo "checked='checked'";
				} ?> />
                  <label for="s">S</label>
                  <br />
                  <br />
                  <input type="checkbox" id="m" onclick="submit_filter('Medium');" <?php if(isset($_GET[ 'size' ]) && $_GET[ 'size' ] == 'Medium'){
					echo "checked='checked'";
				} ?> />
                  <label for="m">M </label>
                  <br />
                  <br />
                  <input type="checkbox" id="l" onclick="submit_filter('Large');" <?php if(isset($_GET[ 'size' ]) && $_GET[ 'size' ] == 'Large'){
					echo "checked='checked'";
				} ?> />
                  <label for="l">L</label>
                  <br />
                  <br />
                  <input type="checkbox" id="xl" onclick="submit_filter('X-Large');" <?php if(isset($_GET[ 'size' ]) && $_GET[ 'size' ] == 'X-Large'){
					echo "checked='checked'";
				} ?> />
                  <label for="xl">XL </label>
                  <br />
                  <br />
                </div>
                </p>-->
				<?php
				/*if(isset($arrData['search_attribute']) && !empty($arrData['search_attribute'])){
					echo $arrData['search_attribute'];
				}*/
				# echo '<pre>'.print_r($arrData['attribute'],true).'</pre>';
				$expendy = 1;
				$open_collapse = array();
				if(isset($attributes) && !empty($attributes)){
					foreach($attributes as $post){
						$expendy++;
						$attr_id = $post[ 'attr_id' ];
						$attr_name = $post[ 'attr_name' ];
						$active = '';
						$display = '';
						if(openAttributeCollapse($attr_id)){
							$active = 'active';
							$display = "style='display:block'";
						}
						echo '<h2>'.$attr_name.'</h2><p><div class="prinput">';
						foreach($post[ 'detail' ] as $val){
							$attr_item_id = $val[ 'attr_item' ];
							$attr_item_name = $val[ 'attr_item_name' ];
							$total = $val[ 'total' ];
							$checked = "";
							$attr_item_str = "'".$expendy.'.'.$attr_id.'.'.$attr_item_id."'";
							if(isset($_GET[ 'attribute' ])){
								$return = getPrevExpendy($attr_id.'.'.$attr_item_id, $arrData[ 'expendy_old_ids' ]);
								if($return){
									$attr_item_str = "'".$return.'.'.$attr_id.'.'.$attr_item_id."'";
								}
							}
							if(checkedAttributeItem($attr_item_id)){
								$checked = "checked='checked'";
								$open_collapse[] = $expendy;
							}
							echo '<input '.$checked.' type="checkbox" id="item_'.$attr_item_id.'" value="item_'.$attr_item_id.'" onclick="getItem('.$attr_item_str.')">
						  <label>'.$attr_item_name.'('.$total.')'.'</label>
						  <br /><br />';
						}
						echo '</div></p>';
					}
				}else{
					echo "<p style='color:#D9534F'>not found any attribute set</p>";
				}
				//echo '<pre>'.print_r($open_collapse,true).'</pre>';
				?>
								<!--<h2>Material</h2>
              <p>
              <div class="prinput">
                <input type="checkbox" id="cotton" onclick="submit_filter('Latex-Free');" <?php if(isset($_GET[ 'meterial' ]) && $_GET[ 'meterial' ] == 'Latex-Free'){
					echo "checked='checked'";
				} ?> />
                <label for="cotton">Latex-Free</label><br />
                <br />
                <!--<input type="checkbox" id="Metal" onclick="submit_filter('Metal');" <?php if(isset($_GET[ 'meterial' ]) && $_GET[ 'meterial' ] == 'Metal'){
					echo "checked='checked'";
				} ?> />
                <label for="Metal">Metal </label><br />
                <br />-->
								<!--<input type="checkbox" id="Latex" onclick="submit_filter('Latex');" <?php if(isset($_GET[ 'meterial' ]) && $_GET[ 'meterial' ] == 'Latex'){
					echo "checked='checked'";
				} ?> />
                <label for="Latex">Latex </label><br />
                <br />
              </div>
              </p>
              <h2>Special Offer</h2>
              <p>
              <div class="prinput">
                <input type="checkbox" id="sprice" onclick="submit_filter('sprice');" <?php if(isset($_GET[ 'special_offer' ]) && $_GET[ 'special_offer' ] == 'sprice'){
					echo "checked='checked'";
				} ?> />
                <label for="sprice">Special Price</label><br />
                <br />
                <input type="checkbox" id="nprice" onclick="submit_filter('nprice');" <?php if(isset($_GET[ 'special_offer' ]) && $_GET[ 'special_offer' ] == 'nprice'){
					echo "checked='checked'";
				} ?> />
                <label for="nprice">Normal Price</label><br />
                <br />
                <br />
              </div>
              </p>-->
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-9">
					<div class="col-lg-12" id="refine" style="border-bottom: 2px solid #CCC; padding-bottom: 15.5px; margin-bottom: 5px; margin-top:-5px">
			 <?php
			 
			
			 ?>
						<div class="refine">&nbsp;&nbsp;&nbsp;Refine</div>
						<div id="flip">Price</div>
						<div id="panel">$
							<input type="text" name="top_from_price" id="top_from_price" <?php if(@$_GET[ 'from_price' ]){
				 echo "value='".$_GET[ 'from_price' ]."'";
			 } ?> />
																						to $
							<input type="text" name="top_to_price" id="top_to_price" <?php if(@$_GET[ 'to_price' ]){
				 echo "value='".$_GET[ 'to_price' ]."'";
			 } ?> />
							<input type="submit" name="price_go" value="GO" onclick="submit_filter('top_from_to');">
						</div>
						<div id="flip2" style="display: none;">Top Brands</div>
						<div id="panel2">
				<?php foreach($manufacturer as $manuf){ ?>
							<input type="checkbox" name="manufacture" class="manufacture" id="manufacture<?=$manuf[ 'manu_id' ]; ?>" onclick="submit_manufacture('<?=$manuf[ 'manu_id' ]; ?>');" <?php if(isset($_GET[ 'brand' ]) && $_GET[ 'brand' ] == $manuf[ 'manu_id' ]){
				 echo "checked='checked'";
			 } ?> />
							<label for="manufacture<?=$manuf[ 'manu_id' ]; ?>">
				 <?=$manuf[ 'manu_title' ]; ?>
							</label>
							<br/>
				<?php } ?>
						</div>
						<div class="btn-group" style="float: right; width: 270px;">
				<?php if(!isset($_GET[ 'match' ]) or $_GET[ 'match' ] == 'best_seller'){
					$flip3 = "Sort";
				} ?>
				<?php if(isset($_GET[ 'match' ]) and $_GET[ 'match' ] == 'low_to_high'){
					$flip3 = "Low to high";
				} ?>
				<?php if(isset($_GET[ 'match' ]) and $_GET[ 'match' ] == 'high_to_low'){
					$flip3 = "High to low";
				} ?>
							<div id="flip3" style="margin-right: 5%; width: 140px; background-position-x: 29px;">
				 <?=$flip3; ?>
							</div>
							<div id="panel3">
							<!--<input type="checkbox" name="best_match" id="best_seller" onclick="submit_match('best_seller');" <?php if(isset($_GET[ 'match' ]) && $_GET[ 'match' ] == 'best_seller'){
				 echo "checked='checked'";
			 } ?> />
                  <label for="best_seller">Best sellers</label> <br />-->
								<input type="checkbox" name="best_match" id="low_to_high" onclick="submit_match('low_to_high');" <?php if(isset($_GET[ 'match' ]) && $_GET[ 'match' ] == 'low_to_high'){
					echo "checked='checked'";
				} ?> />
								<label for="low_to_high">Price: low to high</label>
								<br/>
								<input type="checkbox" name="best_match" id="high_to_low" onclick="submit_match('high_to_low');" <?php if(isset($_GET[ 'match' ]) && $_GET[ 'match' ] == 'high_to_low'){
					echo "checked='checked'";
				} ?> />
								<label for="high_to_low">Price: high to low</label>
								<br/>
							</div>
							<a id="grid" class="btn btn-default btn-sm <?php if($grid == 'true'){
				 echo "active";
			 } ?>" onclick="submit_filter('true')" style="border-right: 1px solid #ccc;"><span class="glyphicon glyphicon-th"></span></a> <a id="list" class="btn btn-default btn-sm <?php if($grid == 'false'){
					echo "active";
				} ?>" onclick="submit_filter('false')"><span class="glyphicon glyphicon-align-justify"> </span></a></div>
					</div>
					<div class="produtcover">
			 <?php
			 
			 if(isset($categories) && !empty($categories)){
				 
				//$medicalModel = new medicalModel();
				//$parent = $medicalModel->nthLevelCategory($categories[ 0 ][ 'category_id' ], url(''));
				$parent = Helper::instance()->nthLevelCategory($categories[0]['category_id'], url(''));
				
				$arrayRev = array_reverse($parent);
				$parent = implode(' &raquo; ', $arrayRev);
					
				echo '<p style="font-weight:bold;">Selected Category: <span class="p-blue">'.stripslashes($parent).'</span></p>';
			 }
			 ?>
			 <?php
			 if(isset($_GET[ 'id' ]) != 'all'){
			 ?>
						<div class="col-lg-12">
				<?php
				//	echo '<pre>'.print_r($arrData['categoryArray'],true).'</pre>';
				
				/*	Sub Caregories Listing */
				if(isset($categoryArray) && !empty($categoryArray) && !isset($_GET[ 'attribute' ])){
				
				echo "<h1>Sub Categories</h1>";
				foreach($categoryArray as $sub_category) {
				?>
							<div class="col-lg-3" style="border: 1px solid #CCC; margin: 10px 5px; text-align: center; width: 31.8%;"><a href="{{ url('product-detail/' . $sub_category[ 'category_id' ]) }}" title="<?php echo $sub_category[ 'category_title' ]?>"> <img src="{{url('') . '/uploads/product/'.$sub_category[ 'category_image' ]}}" max-width="177" height="150"> </a><br>
								<a class="subCata" href="{{ url('product-detail/' .$sub_category[ 'category_image' ] ) }}"><?php echo $sub_category[ 'category_title' ]?></a></div>
				<?php }
				}
				?>
						</div>
			 <?php
			 }
			 ?>
			 <?php
			 
			 $count = 0;
			 $grid_num = 1;
			 /*echo "<br /><h1>Products</h1>";*/
			 if(isset($arrData[ 'product' ]) && !empty($arrData[ 'product' ])){
			 foreach($arrData[ 'product' ] as $post){
			 $count++;
			 $class = "pl15 pr25";
			 if($count%2 == 0){
				 $class = "pl15";
			 }
			 
			 
			 
			 $is_Special = 0;
			 $is_Special_Text = "";
			 $price_class = "";
			 if($post[ 'product_featured' ] == 2){
				 $is_Special = 1;
				 $is_Special_Text = " <div class='special_text special_text_tiles'>S</div>";
				 $price_class = "pricebox_special";
			 }
			 ?>
			 <?php
			 
			 
			 /*$medical = new medicalModel();
				$arrArgument[ 'join' ] = 'INNER JOIN';
				$arrArgument[ 'where' ] = 'up.product_id='.(int)($post[ 'product_id' ]);
				$arrArgument[ 'limit' ] = 'limit 0,1';
				$arrValue[ 'unit' ] = $medical->joinUnitandUnitProduct($arrArgument);*/
			 //echo '<pre>'.print_r($arrValue['unit_product'],true).'</pre>';
			 
			 $unit_title = trim(@$arrValue[ 'unit' ][ 0 ][ 'unit_title' ]);
			 /*
				
				$product_price = 0;
					if($arrValue[ 'unit' ][ 0 ][ 'product_sprice' ] > 0){
						$price_line = "<span style='text-decoration: line-through;'>$".number_format($arrValue[ 'unit' ][ 0 ][ 'product_price' ], 2)."</span><br>";
						$product_price = trim($arrValue[ 'unit' ][ 0 ][ 'product_sprice' ]);
					}else{
						$price_line = '';
						$product_price = trim($arrValue[ 'unit' ][ 0 ][ 'product_price' ]);
					}
					
					if($product_price == ''){
						$product_price = 0;
					}
					
					if($unit_title == ''){
						$unit_title = 'Pending';
					}
					*/
			 ?>
			 <?php if($grid == 'false'){ ?>
						<div class="col-lg-12 inner-prod bor-bot">
							<div class="col-lg-4" style="text-align: center;">
								<a href="<?php echo url('product-detail/'.$post[ 'product_id' ]); ?>"><img src="<?php echo url('').'/uploads/product/'.$post[ 'product_image' ]?>" class="img-responsive"/></a></div>
							<div class="col-lg-8 inner-prod">
								<p class="fi20"><a href="<?php echo url('').'/product-detail/'.(int) ($post[ 'product_id' ])?>"><?php echo stripslashes($post[ 'product_title' ])?></a></p>
								<br/>
								<p class="pr">Price:
					<?php
					echo $is_Special_Text."<label class='".$price_class."'>".@$price_line."$".( (isset(	$product_price ) && $product_price > 0  ) ? number_format(@$product_price, 2) : rand( 99 , 999) )."</label>";
					if($post[ 'product_dropship' ] == 1){
						if($post[ 'product_freeship' ] == 1){
							echo ' (Free shipping)';
						}else{
							echo ' (Call for shipping)';
						}
					}
					?>
								</p>
								<br/>
								<p class="pr">Item Number: <?php echo trim($post[ 'product_item_no' ])?></p>
								<br/>
								<div class="q-box" id="q-box">
									<p>
										
									<!-- Add to Cart -->
									<form action="{{ url('addto_cart') }}" method="post" id="form_<?php echo (int) ($post[ 'product_id' ])?>">
										{{ csrf_field() }}
                                        <input type="text" name="qty_cart" id="qty_cart" value="1" class="qty" style="display:none"/>
										<input type="hidden" name="product_id" value="<?php echo (int) ($post[ 'product_id' ])?>"/>
										<input type="hidden" name="cquantity" id="cquantity" value="1"/>
										<input type="hidden" name="unit_id" id="unit_id" value="<?php echo (int) ($post[ 'unit_id' ])?>"/>
									</form>
									
									<!-- Add to Quote -->
									<form action="{{ url('quote/index') }}" method="post" id="form_quote_<?php echo (int) ($post[ 'product_id' ])?>">
										{{ csrf_field() }}
                                        <input type="text" name="quantity" id="qty_quote" value="1" class="qty" style="display:none"/>
										<input type="hidden" name="product_id" value="<?php echo (int) ($post[ 'product_id' ])?>"/>
										<input type="hidden" name="unit_id_q" id="unit_id_q" value="<?php echo (int) ($post[ 'unit_id' ])?>"/>
									</form>
									
									<!-- Add to Whishlist -->
									<form action="<?php echo 'index.php?controller=favorites&function=index'?>" method="post" id="form_whish_<?php echo (int) ($post[ 'product_id' ])?>">
                                    {{ csrf_field() }}
										<input type="hidden" name="product_id" value="<?php echo (int) ($post[ 'product_id' ])?>"/>
										<input type="hidden" name="unit_id_f" id="unit_id_f" value="<?php echo (int) ($post[ 'unit_id' ])?>"/>
									</form>
	<?php if(trim($post[ 'product_out_of_stock' ]) == 0){  ?>
        <a onclick="document.getElementById('form_' + <?php echo (int) ($post[ 'product_id' ])?>).submit()" data-faisal2="2">
            <p class="add_cart">Add to cart</p>
        </a>
        &nbsp; &nbsp; <a onclick="document.getElementById('form_quote_' + <?php echo (int) ($post[ 'product_id' ])?>).submit()">
            <p class="add_quote">Add Quote </p>
        </a> &nbsp; &nbsp; <a data-toggle="modal" data-target="#myWishList">
            <p class="add_wishlist" style="margin-left:3px" onclick="get_wishlist(<?php echo (int) ($post[ 'product_id' ])?>);">Wishlist</p>
        </a>
	<?php } else{ ?>
        <p class="out_of_stock"></p>
    <?php } ?>
										</p>
								</div>
							</div>
						</div>
			 <?php }
			 else{ ?>
						<div class="col-lg-4" style="margin: 10px 5px; text-align: center; width: 23.5%; min-height: 520px;"><a href="<?php echo url('').'index.php?controller=product&function=index&id='.(int) ($post[ 'product_id' ])?>" title="<?php echo $post[ 'product_title' ]?>" style="line-height: 185px;"> <img src="image.php?height=186&amp;width=220&amp;image=<?php echo url('').'admin/'.IMAGE_PATH_PRODUCT.$post[ 'product_image' ]?>" class="img-responsive"/> </a><br>
							<div class="col-lg-12 inner-prod">
								<p class="fi20" style="height: 70px;"><a href="<?php echo url('').'index.php?controller=product&function=index&id='.(int) ($post[ 'product_id' ])?>"><?php echo stripslashes($post[ 'product_title' ])?></a></p>
								<br/>
								<p class="pr">Price: <?php echo $is_Special_Text."<label class='".$price_class."'>".$price_line."$".number_format($product_price, 2)."</label>"?></p>
								<br/>
								<p class="pr">Item Number: <?php echo trim($post[ 'product_item_no' ])?></p>
								<br/>
								<div class="q-box" id="q-box">
									<p>
										
										<!-- Add to Cart -->
									<form action="<?php echo url('').'index.php?controller=cart&function=index'?>" method="post" id="form_<?php echo (int) ($post[ 'product_id' ])?>">
										<input type="text" name="qty_cart" id="qty_cart" value="1" class="qty" style="display:none"/>
										<input type="hidden" name="product_id" value="<?php echo (int) ($post[ 'product_id' ])?>"/>
										<input type="hidden" name="cquantity" id="cquantity" value="1"/>
										<input type="hidden" name="unit_id" id="unit_id" value="<?php echo (int) ($post[ 'unit_id' ])?>"/>
									</form>
									
									<!-- Add to Quote -->
									<form action="<?php echo url('').'index.php?controller=quote&function=index'?>" method="post" id="form_quote_<?php echo (int) ($post[ 'product_id' ])?>">
										<input type="text" name="quantity" id="qty_quote" value="1" class="qty" style="display:none"/>
										<input type="hidden" name="product_id" value="<?php echo (int) ($post[ 'product_id' ])?>"/>
										<input type="hidden" name="unit_id_q" id="unit_id_q" value="<?php echo (int) ($post[ 'unit_id' ])?>"/>
									</form>
									
									<!-- Add to Whishlist -->
									<form action="<?php echo url('').'index.php?controller=favorites&function=index'?>" method="post" id="form_whish_<?php echo (int) ($post[ 'product_id' ])?>">
										<input type="hidden" name="product_id" value="<?php echo (int) ($post[ 'product_id' ])?>"/>
										<input type="hidden" name="unit_id_f" id="unit_id_f" value="<?php echo (int) ($post[ 'unit_id' ])?>"/>
									</form>
					<?php if(trim($post[ 'product_out_of_stock' ]) == 0){  ?>
									<a onclick="document.getElementById('form_' + <?php echo (int) ($post[ 'product_id' ])?>).submit()" data-faisal="">
										<p class="add_cart" style="margin-left: 20%;"></p>
									</a>
									&nbsp; &nbsp; <a onclick="document.getElementById('form_quote_' + <?php echo (int) ($post[ 'product_id' ])?>).submit()">
										<p class="add_quote" style="margin-left: 20%;"></p>
									</a> &nbsp; &nbsp; <a data-toggle="modal" data-target="#myWishList">
										<p class="add_wishlist" style="margin-left:20%" onclick="get_wishlist(<?php echo (int) ($post[ 'product_id' ])?>);"></p>
									</a>
					<?php }
					else{ ?>
									<p class="out_of_stock" style="margin-left: 20%;"></p>
					<?php } ?>
										</p>
								</div>
							</div>
						</div>
			 <?php if($grid_num%4 == 0){
				 echo '<div class="col-lg-12" style="border-bottom: 1px solid #CCC;"></div>';
			 }
			 $grid_num++;
			 } ?>
			 <?php
			 }
			 ?>
						<div class="aaa"><?php //echo @$arrData[ 'binary' ][ 'paging' ]
						echo @$binaries[ 'paging' ]
						?></div>
			 <?php
			 }
			 
			 else{
				 //	 echo '<br><br><p style="font-weight:bold; font-size: 20px;padding: 5%;">No product found!</p>';
			 }
			 ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearz"></div>
	<!-- Modal -->
	<div class="modal fade" id="myWishList" role="dialog">
		<div class="modal-dialog">
			
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" style="width: 5px; margin-top: -10px;">&times;</button>
				</div>
				<div class="modal-body">
			<?php if(isset($wishlists) && !empty($wishlists)){  ?>
					<form action="{{ url('favorites/index') }}" method="post" id="form_whish_">
						{{ csrf_field() }}
                        <table id="g-manage-table-wishlist1" class="a-keyvalue a-spacing-mini" style="width: 100%;">
							<tbody>
							<tr>
								<th class="a-span8"><input type="hidden" name="product_id" id="wish_product_id"/>
									<input type="hidden" name="unit_id_f" id="unit_id_f" value="7"/>
								</th>
							</tr>
							<tr>
								<td class="g-manage-name"><select name="w_id" id="w_id" required="required">
										<option value="">Select List</option>
						<?php
						foreach($wishlists as $wishlist){ ?>
										<option value="<?php echo $wishlist->id; ?>"><?php echo $wishlist->wishlist_name; ?></option>
						<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2"><input name="submit" class="button btncart add_cart" type="submit" value="Submit" style="border: none;"></td>
							</tr>
							</tbody>
						</table>
					</form>
			<?php }
			else{ ?>
					<form method="post" action="{{ url('favorites/add_wishlist') }}" class="a-spacing-top-small">
						<table id="g-manage-table-wishlist2" class="a-keyvalue a-spacing-mini" style="width: 100%;">
							<tbody>
							<tr>
								<th></th>
							</tr>
                            {{ csrf_field() }}
							<tr>
								<td class="a-span4 a-text-left a-align-bottom"><input type="hidden" name="u_id" value="<?php echo @$_SESSION[ 'front_id' ]; ?>">
									<input type="text" name="wishlist_name" class="inqury_ipput" placeholder="Enter Wish List Name" required="required"></td>
							</tr>
							<tr>
								<td>
									<button name="submitForm" class="button2 btn-proceed-checkout btn-checkout2 btncart add_cart" type="submit">Submit</button>
								</td>
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
	<script src="{{url('/')}}/frontend/js/jquery-1.11.0.js"></script>
	<script src="{{url('/')}}/frontend/js/expandy.js"></script>
	<script>
		 
		 function get_wishlist(pid) {
				 document.getElementById("wish_product_id").value = pid;
				 $('#myWishList').trigger('click');
		 }
		 
		 jQuery('.container1').makeExpander({
				 toggleElement : 'h2' ,
				 jqAnim : true ,
				 showFirst : false ,
				 accordion : true ,
				 speed : 400 ,
				 indicator : 'triangle'
		 });
		 jQuery('.container2').makeExpander({
				 toggleElement : 'h2' ,
				 jqAnim : true ,
				 showFirst : true ,
				 accordion : false ,
				 speed : 400 ,
				 indicator : 'plusminus'
		 });
		 
		 jQuery('.container3').makeExpander({
				 toggleElement : 'h2' ,
				 jqAnim : true ,
				 showFirst : true ,
				 accordion : false ,
				 speed : 1400 ,
				 indicator : 'arrow'
		 });
		 
		 jQuery("#flip").click(function () {
				 jQuery("#panel2").slideUp("fast");
				 jQuery("#panel3").slideUp("fast");
				 jQuery("#panel").slideToggle("fast");
		 });
		 
		 jQuery("#flip2").click(function () {
				 jQuery("#panel").slideUp("fast");
				 jQuery("#panel3").slideUp("fast");
				 jQuery("#panel2").slideToggle("fast");
		 });
		 
		 jQuery("#flip3").click(function () {
				 jQuery("#panel2").slideUp("fast");
				 jQuery("#panel").slideUp("fast");
				 jQuery("#panel3").slideToggle("fast");
		 });
	</script>
 <?php
 if(isset($_GET[ 'price' ]) && $_GET[ 'price' ] != '')
 { ?>
	<script type="text/javascript">
		 document.getElementById('expandy1').style.display = 'block';
	</script>
 <?php
 }
 if(isset($_GET[ 'size' ]) && $_GET[ 'size' ] != '')
 { ?>
	<script type="text/javascript">
		 document.getElementById('expandy2').style.display = 'block';
	</script>
 <?php
 }
 if(isset($_GET[ 'meterial' ]) && $_GET[ 'meterial' ] != '')
 { ?>
	<script type="text/javascript">
		 document.getElementById('expandy3').style.display = 'block';
	</script>
 <?php
 }
 if(isset($_GET[ 'special_offer' ]) && $_GET[ 'special_offer' ] != '')
 { ?>
	<script type="text/javascript">
		 document.getElementById('expandy4').style.display = 'block';
	</script>
 <?php
 }
 $url_attribute_string = "";
 if(isset($_GET[ 'attribute' ])){
	 $url_attribute_string = $_GET[ 'attribute' ];
 }
 ?>
	<input type="hidden" id="url_attribute_string" value="<?php echo $url_attribute_string?>"/>
	<script type="text/javascript">
	 <?php /*?><?php
if(isset($arrData['expendy_attribute']) && !empty($arrData['expendy_attribute'])){
foreach($arrData['expendy_attribute'] as $expendy){
?>
	document.getElementById('expandy' + <?php echo $expendy?>).style.display='block';
<?php
}
}
?><?php */?>
	 
	 <?php
	 if(!empty($open_collapse)){
	 foreach($open_collapse as $expendy){
	 ?>
	 document.getElementById('expandy' + <?php echo $expendy; ?>).style.display = 'block';
	 <?php
	 }
	 }
	 ?>
	
	</script>
	<script type="text/javascript">
		function getItem(str){
			<!-- Get attribute item id from comming string at position 3rd -->
			split_str=str.split('.');
			item_id=split_str[2];
			
			var url_attribute_string=document.getElementById('url_attribute_string').value;
			
			<!-- See if item checkbox is checked or not -->
			var checked_or_not=document.getElementById('item_' + item_id).checked;
			if(checked_or_not){
				
				if(url_attribute_string!=''){
					str=str + '_' + url_attribute_string;	
				}
			}
			else{
				
				str=removeUncheckAttributeItem(str, url_attribute_string);
			}
			
			
			var wlh = window.location.href
			var wlh2 = wlh.replace("category/", "category?id="); 
			
			var url2=removeParam('attribute', wlh2);
			var url = url2.replace("category?id=", "category/");
			
			if(str==''){	
				//url = url.replace("http://198.91.26.114/manager/category/2/", "http://198.91.26.114/manager/category/2");
				//url = url.replace("http://localhost/manager/category/2/", "http://localhost/manager/category/2");
				var n2 = url.endsWith("/");
								
				if(n2 == true){
					url = url.substring(0, url.length - 1);
				}
				window.location.href=url;
			} else {
				url = url + '/&attribute=' + str;		
				
				var n=url.search("//&attribute=");
				if(n==-1){
					url = url;	
				} else {	
					var url = url.replace("//&attribute=", "/&attribute=");
				}
				
				window.location.href=url;
			}
			
		}
		 
		 function removeParam(key , sourceURL) {
				 var rtn = sourceURL.split("?")[0] , param , params_arr = [] , queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
				 if (queryString !== "") {
						 params_arr = queryString.split("&");
						 for (var i = params_arr.length - 1; i >= 0; i -= 1) {
								 param = params_arr[i].split("=")[0];
								 if (param === key) {
										 params_arr.splice(i , 1);
								 }
						 }
						 rtn = rtn + "?" + params_arr.join("&");
				 }
				 return rtn;
		 }
		 
		 function removeUncheckAttributeItem(remove_string , full_string) {
				 
				 split_str = full_string.split('_');
				 new_string = '';
				 for (i = 0; i < split_str.length; i++) {
						 if (split_str[i] != remove_string) {
								 new_string += split_str[i] + '_';
						 }
				 }
				 new_string = new_string.slice(0 , -1);
				 return new_string;
		 }
		 
		 function searchRemove(str) {
				 actual_string = str;
				 split_str = str.split('.');
				 item_id = split_str[2];
				 var checked_or_not = document.getElementById('item_' + item_id).checked = false;
				 getItem(actual_string);
		 }
		 
		 $(document).ready(function () {
				 $('#attribute_work').removeClass();
		 });
	</script>
@endsection()