@extends('frontwebsite._mainLayout')
@section('content')
	<?php
	$bs_height = 65;
	?>
		<script src="js/easyzoom.js"></script>
		<script type="text/javascript">
			
			jQuery(function (jQuery) {
					
					jQuery('a.zoom').easyZoom();
					
			});
			
			function popWin(url , win , para) {
					var win = window.open(url , win , para);
					win.focus();
			}
			
			function get_wishlist(pid) {
					document.getElementById("wish_product_id").value = pid;
					$('#myWishList').trigger('click');
			}
		    
		    function addCart(){
				var qnty=$('#qty_cart').val();
				$('#cquantity').val(qnty);
				
				$('#form3').submit();
				
				getCartItemsTop();
			}
		    
		</script>
		<style type="text/css">
			input[type='radio'] {
				width: auto;
				height: auto;
				margin: 0;
				padding: 0;
			}
			
			.bold {
				font-size: 18px;
			}
			
			.rew span {
				float: left;
			}
			
			.star {
			}
			
			.name {
				margin-left: 5px;
			}
			
			.date {
				margin-left: 5px;
			}
			
			input, button, select, textarea {
				border: 1px solid #f0f0f0;
				margin: 0;
				height: 34px;
				font-size: inherit;
			}
			
			.tbl label {
				display: block;
				font-weight: bold;
			}
			
			.tbl tr {
				height: 60px;
			}
			
			.tbl label b {
				color: #F00;
				font-weight: bold;
			}
			
			.code {
				font-size: 24px;
				font-weight: bold;
				background-color: #2692da;
				color: #fff;
				padding: 4px;
				font-family: sans-serif;
				margin-left: 4px;
				float: left;
				border-radius: 4px 0px 0px 4px;
			}
			
			#easy_zoom {
				width: 620px;
				height: 440px;
				border: 5px solid #eee;
				background: #fff;
				color: #333;
				position: absolute;
				top: 50px;
				left: 32.5%;
				overflow: hidden;
				-moz-box-shadow: 0 0 10px #777;
				-webkit-box-shadow: 0 0 10px #777;
				box-shadow: 0 0 10px #777;
				/* vertical and horizontal alignment used for preloader text */
				
				line-height: 400px;
				text-align: center;
				margin-top: 100px
			}
			
			.more_view {
				font-size: 11px;
				border-bottom: 1px solid #ccc;
				margin: 0 0 8px;
				text-transform: uppercase;
				color: #72b84c;
			}
			
			.side-prod {
				padding: 33px 10px;
			}
			
			.q-box {
				padding-left: 0 !important;
			}
			
			@media only screen and (max-width: 1199px) {
				/*.side-prod{
								padding:15px 10px;
					float:left;
					margin-right:50px;
				}
				.probox{
					min-height:inherit !important
				}
				#best_seller{
					width:100% !important;
					margin-left:0 !important;
				}*/
			}
			
			@media screen and (min-width: 1025px) and (max-width: 1199px) {
				<?php $bs_height = 65 ; ?>
.side-prod {
					padding: 15px 10px;
					float: left;
					margin-right: 50px;
				}
				
				.probox {
					min-height: inherit !important
				}
				
				#best_seller {
					width: 100% !important;
					margin-left: 0 !important;
				}
			}
		</style>
	<?php $image = url('').'/uploads/product/'.$product[ 0 ]->product_image; ?>
		<div class="container">
			<div class="row main-contant">
				<div class="container contant-con">
					<div class="col-lg-9">
						<div class="col-lg-12">
							<div class="col-lg-6 p-img">
								<div class="col-lg-12" style="text-align:center;"><a href="#" class="zoom img-responsive"> <img src="<?= @$image ?>?>" alt="<?=$product[ 0 ]->product_title; ?>" class="img-responsive"> </a> <br/>
									<br/>
									<h2 class="more_view">More Views</h2>
									<a href="#" onclick="popWin('<?= @$image ?>', 'gallery', 'width=<?php echo @$width+20?>,height=<?php echo @$height+20?>,left=0,top=0,location=no,scrollbars=no,resizable=no'); return false;">
										<img style="border:2px solid #ddd;    max-width: 134px;" src="<?= @$image ?>"/></a>
								</div>
							
							</div>
							<div class="col-lg-6 p-dec">
								<div class="row p-cont">
									<div class="headingc">
										<h3 class="fi20"><a href="#"><?php echo $product[ 0 ]->product_title; ?></a></h3>
									</div>
					<?php if($product[ 0 ]->pt_id == 2){ ?>
									<div class="cartpad">
										<div class="soc-img">
											<p class="p-blue">Review </p>
											<div class="row">
												<a href="https://twitter.com/medicalshipment" target="_blank"><img src="{{url('/twitter.jpg')}}"></a>
												<a href="https://www.facebook.com/MedicalShipment/" target="_blank"><img src="{{url('/facebook.jpg')}}"></a>
												<a href="https://www.linkedin.com/company/medical-shipment" target="_blank"><img src="{{url('/linkedin.jpg')}}"></a>
												<a href="https://plus.google.com/113914819075313734046/about" target="_blank"><img src="{{url('/gplus.jpg')}}"></a>
												<a href="https://www.pinterest.com/medicalshipment/" target="_blank"><img src="{{url('/pinterest.png')}}"></a>
											</div>
										</div>
										<div class="clearz"></div>
										<hr>
										<p><span class="p-blue">Item Number:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $product[ 0 ]->product_item_no; ?> </p>
										<hr>
										<p><span class="p-blue">Price:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $<?php echo $product[ 0 ]->product_price;
						if($product[ 0 ]->product_dropship == 1){
							if($product[ 0 ]->product_freeship == 1){
								echo ' (Free shipping)';
							}else{
								echo ' (Call for shipping)';
							}
						}
						?> </p>
										<hr>
									</div>
					<?php
					$manufacturer = $uom = '';
					
					$configure_product = $medical->configure_product($product[ 'product_id' ]);
					
					if(isset($configure_product) && !empty($configure_product)){
						
						foreach($configure_product as $c_product){
							
							if($c_product[ 'cp_label' ] == 'Manufacturer'){
								
								$manufacturer .= "<option value=".$c_product[ 'cpo_id' ]." price='0'>".$c_product[ 'cpa_option' ]."</option>";
							}
						}
					}
					
					?>
									<table id="shopping-cart-table" class="data-table cart-table">
										<tbody>
										<form id="form3" action="<?php echo SITE_PATH.'index.php?controller=cart&function=add_configure_product'?>" method="post" style="float: left;">
											<input type="hidden" name="product_id" value="<?php echo $_GET[ 'id' ]?>"/>
											<input type="hidden" name="unit_id" id="unit_id" value="7"/>
											<tr class="first odd">
												<td><label class="required"><em>*</em>Manufacturer</label></td>
												<td><select name="manufacturer" id="manufacturer" required="required" onchange="get_uom(this.value);">
														<option value="">Choose an Option...</option>
								<? echo $manufacturer; ?>
													</select></td>
											</tr>
											<tr class="first odd">
												<td><label class="required"><em>*</em>UOM</label></td>
												<td><select name="uom" id="uom" required="required">
														<option value="">Choose an Option...</option>
								<? echo $uom; ?>
													</select></td>
											</tr>
											<tr class="first odd">
												<td><label class="required"><em>*</em>Qty</label></td>
												<td><span class="price">
                        <input type="text" name="cquantity" value="1" class="qty"/>
                        </span></td>
											</tr>
											<tr>
												<td></td>
												<td>
													<button type="submit" name="submit" value="1" class="add_cart group_cart_button"></button>
												</td>
										</form>
										</tbody>
									
									</table>
									<br>
					<?php
					}
									
									elseif($product[ 0 ]->pt_id == 3){
					
					
					
					
					
					if(isset($group_product) && !empty($group_product)){
					
					?>
									<div class="cartpad">
										<div class="soc-img">
											<p class="p-blue">Review </p>
											<div class="row">
												<a href="https://twitter.com/medicalshipment" target="_blank"><img src="{{ url('/twitter.jpg') }}"></a>
												<a href="https://www.facebook.com/MedicalShipment/" target="_blank"><img src="{{ url('/facebook.jpg') }}"></a>
												<a href="https://www.linkedin.com/company/medical-shipment" target="_blank"><img src="{{ url('/linkedin.jpg') }}"></a>
												<a href="https://plus.google.com/113914819075313734046/about" target="_blank"><img src="{{ url('/gplus.jpg') }}"></a>
												<a href="https://www.pinterest.com/medicalshipment/" target="_blank"><img src="{{ url('/pinterest.png') }}"></a>
											</div>
										</div>
										<div class="clearz"></div>
										<hr>
										<p><span class="p-blue">Item Number:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $product[ 'product_item_no' ]; ?> </p>
										<hr>
									</div>
									<table id="shopping-cart-table" class="data-table cart-table">
										<thead>
										<tr class="carttop">
											<th><span class="nobr">Product Name</span></th>
											<th><span class="nobr">Unit Price</span></th>
											<th class="qty_height"><span class="nobr">Qty</span></th>
										</tr>
										</thead>
										<tbody>
										<form id="form3" action="<?php echo SITE_PATH.'index.php?controller=cart&function=add_group_product'?>" method="post" style="float: left;">
						<?php
						
						
						
						foreach($group_product as $g_product){
						
						?>
											<input type="hidden" name="product_id[]" value="<?php echo $g_product[ 'product_id' ]?>"/>
											<input type="hidden" name="unit_id[]" id="unit_id" value="<?php echo intval($g_product[ 'unit_id' ])?>"/>
											<tr class="first odd">
												<td><a href="<?php echo SITE_PATH.'index.php?controller=product&function=index&id='.$g_product[ 'product_id' ]; ?>"><?php echo $g_product[ 'product_title' ]?></a></td>
												<td><span class="price">$<?php echo number_format(trim($g_product[ 'product_price' ]), 2)?></span></td>
												<td><span class="price">
                        <input type="text" name="cquantity[]" value="1" class="qty"/>
                        </span></td>
											</tr>
						<?php } ?>
										</form>
										</tbody>
									
									</table>
									<a onclick="addCartGroup()" style="float:right;">
										<p class="add_cart group_cart_button"></p>
									</a><br>
					<?php  }
						
					}
									
									elseif($product[ 0 ]->pt_id == 4){ ?>
									<div class="cartpad">
					 <?php
					 
					 $price = $medical->get_from_to_bundle_price($_GET[ 'id' ]);
					 
					 ?>
										<p class="pr3"><?php echo $price; ?></p>
										<p class="pr3">Price as configured: $<span id="config_price">0.00</span>
						<? if($product[ 'product_dropship' ] == 1){
							if($product[ 'product_freeship' ] == 1){
								echo ' (Free shipping)';
							}else{
								echo ' (Call for shipping)';
							}
						}
						?></p>
										<hr>
										<div class="soc-img">
											<p class="p-blue">Review </p>
											<div class="row">
												<a href="https://twitter.com/medicalshipment" target="_blank"><img src="{{ url('/twitter.jpg') }}"></a>
												<a href="https://www.facebook.com/MedicalShipment/" target="_blank"><img src="{{ url('/facebook.jpg') }}"></a>
												<a href="https://www.linkedin.com/company/medical-shipment" target="_blank"><img src="{{ url('/linkedin.jpg') }}"></a>
												<a href="https://plus.google.com/113914819075313734046/about" target="_blank"><img src="{{ url('/gplus.jpg') }}"></a>
												<a href="https://www.pinterest.com/medicalshipment/" target="_blank"><img src="{{ url('/pinterest.png') }}"></a>
											</div>
										</div>
										<div class="clearz"></div>
										<hr>
										<p><span class="p-blue">Item Number:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $product[ 'product_item_no' ]; ?> </p>
										<br/>
					 <?php if(trim($product[ 'product_package' ]) != ''){?>
										<p><span class="p-blue">Packaging:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $product[ 'product_package' ]; ?></p>
										<br/>
					 <?php
						 
					 }
					 
					 
					 
					 $bundle_group = $medical->bundle_group($_GET[ 'id' ]);
					 
					 
					 
					 ?>
										<form id="form3" action="<?php echo SITE_PATH.'index.php?controller=cart&function=add_group_product'?>" method="post" style="float: left;">
						<?php
						
						
						
						foreach($bundle_group as $b_group){
						
						
						
						$bundle_product = $medical->bundle_product($b_group[ 'bp_id' ]);
						
						?>
											<table id="shopping-cart-table" class="data-table cart-table">
												<h2><?php echo $b_group[ 'bp_title' ]?></h2>
												<thead>
												<tr class="carttop">
													<th><span class="nobr">Product Name</span></th>
													<th><span class="nobr">Unit Price</span></th>
													<th class="qty_height"><span class="nobr">Qty</span></th>
												</tr>
												</thead>
												<tbody>
						<?php
						
						foreach($bundle_product as $b_product){
						
						?>
												<tr class="first odd">
													<td><input type="hidden" name="product_id[]" value="<?php echo $b_product[ 'product_id' ]?>"/>
														<input type="hidden" name="unit_id[]" id="unit_id" value="<?php echo intval($b_product[ 'unit_id' ])?>"/>
														<a href="<?php echo SITE_PATH.'index.php?controller=product&function=index&id='.$b_product[ 'product_id' ]; ?>"><?php echo $b_product[ 'product_title' ]?></a></td>
													<td><span class="price">$<?php echo number_format(trim($b_product[ 'product_price' ]), 2)?></span></td>
													<td><span class="price">
                            <input type="text" name="cquantity[]" value="1" class="qty"/>
                            </span></td>
												</tr>
						<?php } ?>
						<?php } ?>
												</tbody>
											</table>
										</form>
										<div class="q-box">
											<div style="width: auto; float: left; line-height: 40px;">Qty:
												<form id="form3" action="<?php echo SITE_PATH.'index.php?controller=cart&function=index'?>" method="post" style="float: left;">
													<input type="text" name="qty_cart" id="qty_cart" value="1" class="qty"/>
													<input type="hidden" name="product_id" value="<?php echo intval($arrData[ 'product' ][ 0 ][ 'product_id' ])?>"/>
													<input type="hidden" name="cquantity" id="cquantity" value="1"/>
													<input type="hidden" name="unit_id" id="unit_id" value="<?php echo intval($arrData[ 'unit' ][ 0 ][ 'unit_id' ])?>"/>
												</form>
											</div>
										</div>
										<div class="qty_chnange"><img src="{{url('up.png')}}" class="up" id="up_cart"> <img src="{{url('down.png')}}" class="down" id="down_cart"></div>
										<a onclick="addCart()">
											<p class="add_cart"></p>
										</a><br>
										<br>
										<br>
									</div>
					<?php }
					
					else{ ?>
									<div class="cartpad">
										<p class="pr3">
						<?php if($product[ 0 ]->product_sprice > 0){
							echo "<span style='text-decoration: line-through;'>$".number_format(trim($product[ 'product_price' ]), 2)."</span><br>";
							echo '$'.number_format(trim($product[ 0 ]->product_sprice), 2);
						}else{
							echo '$'.number_format(trim($product[ 0 ]->product_price), 2);
						}
						if($product[ 0 ]->product_dropship == 1){
							if($product[ 0 ]->product_freeship == 1){
								echo ' (Free shipping)';
							}else{
								echo ' (Call for shipping)';
							}
						}
						?></p>
										<hr>
										<div class="soc-img">
											<p class="p-blue">Review </p>
											<div class="row">
												<a href="https://twitter.com/medicalshipment" target="_blank"><img src="{{ url('/twitter.jpg') }}"></a>
												<a href="https://www.facebook.com/MedicalShipment/" target="_blank"><img src="{{ url('/facebook.jpg') }}"></a>
												<a href="https://www.linkedin.com/company/medical-shipment" target="_blank"><img src="{{ url('/linkedin.jpg') }}"></a>
												<a href="https://plus.google.com/113914819075313734046/about" target="_blank"><img src="{{ url('/gplus.jpg') }}"></a>
												<a href="https://www.pinterest.com/medicalshipment/" target="_blank"><img src="{{ url('/pinterest.png') }}"></a>
											</div>
										</div>
										<div class="clearz"></div>
										<hr>
										<p><span class="p-blue">Item Number:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $product[ 0 ]->product_item_no; ?> </p>
										<br/>
					 <?php if(trim($product[ 0 ]->product_package) != ''){?>
										<p><span class="p-blue">Packaging:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $product[ 0 ]->product_package; ?></p>
										<br/>
					 <?php
						 
					 }
					 
					 ?>
										<div class="q-box">
											<div style="width: auto; float: left; line-height: 40px;">Qty:
												<form id="form3" action="{{ url('addto_cart') }}" method="post" style="float: left;">
												    {{ csrf_field() }}
													<input type="text" name="qty_cart" id="qty_cart" value="1" class="qty"/>
													<input type="hidden" name="product_id" value="<?php echo (int) ($product[ 0 ]->product_id)?>"/>
													<input type="hidden" name="cquantity" id="cquantity" value="1"/>
													<input type="hidden" name="unit_id" id="unit_id" value="<?php echo (int) $unit[ 0 ]->unit_id?>"/>
												</form>
											</div>
										</div>
										<div class="qty_chnange"><img src="{{url('up.png')}}" class="up" id="up_cart"> <img src="{{url('down.png')}}" class="down" id="down_cart"></div>
										<a onclick="addCart()">
											<p class="add_cart"></p>
										</a><br>
										<br>
										<br>
										<div class="q-box">
											<p style="width: auto; float: left; line-height: 40px;"> Qty:
											<form id="form1" action="{{ url('quote/index') }}" method="post" style="float: left;">
												<div class="priceleft2"></div>
												{{ csrf_field() }}
												<input type="text" name="quantity" id="qty_quote" value="1" class="qty"/>
												<input type="hidden" name="product_id" value="<?php echo (int) ($product[ 0 ]->product_id)?>"/>
												<input type="hidden" name="unit_id_q" id="unit_id_q" value="<?php echo (int) ($unit[ 0 ]->unit_id)?>"/>
											</form>
											<form id="form2" action="#" method="post">
												<input type="hidden" name="product_id" value="<?php echo (int) ($product[ 0 ]->product_id)?>"/>
												<input type="hidden" name="unit_id_f" id="unit_id_f" value="<?php echo (int) ($unit[ 0 ]->unit_id)?>"/>
											</form>
										</div>
										<div class="qty_chnange"><img src="{{url('up.png')}}" class="up" id="up_quote"> <img src="{{url('down.png')}}" class="down" id="down_quote"></div>
										<a onclick="document.getElementById('form1').submit();">
											<p class="add_quote"></p></a>
										<a data-toggle="modal" data-target="#myWishList">
											<p class="add_wishlist wishlist" style="margin-left: 10px;" onclick="get_wishlist(<?php echo (int) ($product[ 0 ]->product_id)?>);"></p>
										</a> <br>
										<br>
										<br>
									</div>
					<?php }
					
					?>
								</div>
							
							</div>
						
						</div>
					
					</div>
					<div class="col-lg-3" id="best_seller" style="width: 25.5%; margin: 0;">
						<div class="col-lg-12">
							<div class="heading1" style="line-height:46px">Best Seller</div>
							<div class="probox" style=" height:auto; min-height:396px;">
				 <?php
				 
				 # echo '<pre>'.print_r($arrData['product'],true).'</pre>';
				 
				 if(isset($bsp) && !empty($bsp)){
				 
				 foreach($bsp as $productb){
				 ?>
								<div class="side-prod col-lg-12">
									<div class="col-lg-4"><a href="#"> <img src="" class="img-responsive"/></a></div>
									<div class="col-lg-8">
										<p class="fi13"><a href=""><?php echo substr($productb->product_title, 0, 25).'...'; ?></a></p>
										<p class="pr2">$<?php echo number_format(trim($productb->product_price), 2)?></p>
									</div>
								</div>
				 <?php
					 
				 }
					 
				 }
				 
				 ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearz"></div>
		
		<div class="container contant-con">
			<div id="prd-des" class="col-lg-12">
				<ul id="myTab" class="nav nav-prod">
					<li class="active"><a href="#description" data-toggle="tab">Description</a></li>
					<li><a href="#info" data-toggle="tab">Product Specs</a></li>
					<li><a href="#video" data-toggle="tab">Videos</a></li>
					<li><a href="#literature" data-toggle="tab">Literature</a></li>
					<li><a href="#reviews" data-toggle="tab">Reviews (<?php echo (empty($review)) ? '0' : count($review)?>)</a></li>
				</ul>
				<div id="myTabContent" class="tab-content">
					<div class="tab-pane fade in active" id="description"> <?php echo trim(stripslashes($product[ 0 ]->product_detail));?><br/>
			 <?php if(trim(stripslashes($product[ 0 ]->product_pdf)) != ''){ ?>
						<p><span style="color:#888888; font-size:medium"><img alt="" src="http://medicalshipment.com/images/pdf.gif"> <a href="<?php // echo SITE_PATH.'admin/'.IMAGE_PATH_PRODUCT.trim(stripslashes($arrData[ 'product' ][ 0 ][ 'product_pdf' ])); ?>" rel="nofollow" target="_blank">Product Manual</a></span></p>
			 <?php } ?>
						<br/>
					</div>
					<div class="tab-pane fade" id="info">
						<table style="width:39.3%; background:#fff; margin-top:5px; float:left;">
							<tbody>
							<tr>
								<td class="aitd" style="color:#000 !important; border:1px solid #CCC; font-weight:bold; width:270px;">Item Number</td>
								<td class="aitd" style="border:1px solid #CCC;"><?php echo trim(stripslashes($product[ 0 ]->product_item_no));?></td>
							</tr>
							<tr style="background:#fff;">
								<td class="aitd" style="color:#000 !important; border:1px solid #CCC; font-weight:bold; width:270px;">Length</td>
								<td style="border:1px solid #CCC;" class="aitd"><?php echo trim(stripslashes($product[ 0 ]->product_length));?> in</td>
							</tr>
							<tr style="background:#fff;">
								<td class="aitd" style="color:#000 !important; border:1px solid #CCC; font-weight:bold; width:270px;">Width</td>
								<td style="border:1px solid #CCC;" class="aitd"><?php echo trim(stripslashes($product[ 0 ]->product_width));?> in</td>
							</tr>
							<tr style="background:#fff;">
								<td class="aitd" style="color:#000 !important; border:1px solid #CCC; font-weight:bold; width:270px;">Height</td>
								<td style="border:1px solid #CCC;" class="aitd"><?php echo trim(stripslashes($product[ 0 ]->product_height));?> in</td>
							</tr>
							<tr style="background:#fff;">
								<td class="aitd" style="color:#000 !important; border:1px solid #CCC; font-weight:bold; width:270px;">Dimensions (inches) (LxWxH)</td>
								<td style="border:1px solid #CCC;" class="aitd"><?php echo trim(stripslashes($product[ 0 ]->product_length));?>x<?php echo trim(stripslashes($product[ 0 ]->product_width));?>x<?php echo trim(stripslashes($product[ 0 ]->product_height));?></td>
							</tr>
							<tr style="background:#fff;">
								<td class="aitd" style="color:#000 !important; border:1px solid #CCC; font-weight:bold; width:270px;">Product Weight</td>
								<td style="border:1px solid #CCC;" class="aitd">
					<?php echo $product[ 0 ]->product_weight?> lbs
								</td>
							</tr>
							<tr style="background:#fff;">
								<td class="aitd" colspan="2">&nbsp;</td>
							</tr>
							</tbody>
						</table>
					</div>
					<div class="tab-pane fade" id="video">
						<h2>Video's here</h2>
					</div>
					
					<div class="tab-pane fade" id="literature">
						<h2>Literature here</h2>
					</div>
					
					<div class="tab-pane fade" id="reviews"><br/>
			 <?php
			 
			 function getStar($no){
				 
				 $str = '';
				 
				 for($i = 1 ; $i <= $no ; $i++){
					 
					 $str .= '<img src='.url('').'/star.png'.' />';
				 }
				 
				 return $str;
			 }
			 
			 $_SESSION[ 'cap' ] = rand(1000, 100000);
			 
			 
			 
			 if(isset($arrData[ 'review' ]) && !empty($arrData[ 'review' ])){
				 
				 foreach($arrData[ 'review' ] as $rew){
					 
					 
					 $date = strtotime($rew[ 'rew_date' ]);
					 
					 $date = date("y/m/d g:i a", $date);
					 
					 echo "<div class='rew'><span class='star'>".getStar($rew[ 'rew_rating' ])."</span><span class='name'><b class='bold'>".trim(stripslashes($rew[ 'user_fname' ])).' '.trim(stripslashes($rew[ 'user_lname' ]))."</b></span><span class='date'>".$date."</span><div style='clear:both'></div>

                                <p>".trim(stripslashes($rew[ 'rew_comment' ]))."</p></div>";
				 }
			 }
			 
			 ?>
						<h1 class="h1">Write Review</h1>
						<form action="#" method="post">
							<input type="hidden" name="product_id" value="<?php echo $product[ 0 ]->product_id ?>"/>
							<table class="tbl">
								<tr>
									<td><label>Rating <b>*</b></label>
										<p>
											<input name="rating" value="5" type="radio" required/>
											&nbsp;&nbsp;&nbsp; <img src=" {{ url('') }}/star.png"/> <img src="{{ url('') }}/star.png"/> <img src="{{url('')}}/star.png"/> <img src="{{url('')}}/star.png"/> <img src="{{ url('') }}/star.png"/></p>
										<p>
											<input name="rating" value="4" type="radio" required/>
											&nbsp;&nbsp;&nbsp; <img src="{{ url('') }}/star.png"/> <img src="{{url('')}}/star.png"/> <img src="{{url('')}}/star.png"/> <img src="{{url('')}}/star.png"/></p>
										<p>
										<p>
											<input name="rating" value="3" type="radio" required/>
											&nbsp;&nbsp;&nbsp; <img src="{{url('')}}/star.png"/> <img src="{{url('')}}/star.png"/> <img src="{{url('')}}/star.png"/></p>
										<p>
											<input name="rating" value="2" type="radio" required/>
											&nbsp;&nbsp;&nbsp; <img src="{{url('')}}/star.png"/> <img src="{{url('')}}/star.png"/></p>
										<input name="rating" value="1" type="radio" required/>
										&nbsp;&nbsp;&nbsp;<img src="{{url('')}}/star.png"/>
									
									</td>
								</tr>
								<tr>
									<td><label>Comment <b>*</b></label>
										<textarea name="comment" placeholder="Comment" class="" spellcheck="false" style="height:100px" required></textarea></td>
								</tr>
								<tr>
									<td><?php
					 
					 echo "<span class='code'>

													&nbsp;".$_SESSION[ 'cap' ]."&nbsp;

												</span>";
					 
					 ?>
										<input type="text" style="border-radius:0px 4px 4px 0px;width:293px;" name="captcha" class="" placeholder="Enter Security Code" required/></td>
								</tr>
								<tr>
									<label>&nbsp;</label>
									<td><input type="submit" class="loginsubmit2" value="Send"/></td>
								</tr>
							</table>
						</form>
						<br/>
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
			 
			 <?php 
			 if(isset($wishlists) && !empty($wishlists)){ 
			 ?>		
				<?php /*?><form action="<?php echo 'index.php?controller=favorites&function=index'?>" method="post" id="form_whish_<?php echo (int) ($product[ 'p_id' ])?>"><?php */?>
                <form action="{{ url('favorites/index') }}" method="post" id="form_whish_">
                    <table id="g-manage-table-wishlist1" class="a-keyvalue a-spacing-mini" style="width: 100%;">
                        <tbody>
                        <tr>
                            <th class="a-span8">
                                <input type="hidden" name="product_id" id="wish_product_id"/>
                                <input type="hidden" name="unit_id_f" id="unit_id_f" value="7"/>
                            </th>
                        </tr>
                        {{ csrf_field() }}
                        <tr>
                            <td class="g-manage-name">
                                <select name="w_id" id="w_id" required="required">
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
			 <?php } else { ?>
                <form method="post" action="{{ url('favorites/add_wishlist') }}" class="a-spacing-top-small">
                    <table id="g-manage-table-wishlist2" class="a-keyvalue a-spacing-mini" style="width: 100%;">
                        <tbody>
                        <tr>
                            <th></th>
                        </tr>
                        {{ csrf_field() }}
                        <tr>
                            <td class="a-span4 a-text-left a-align-bottom"><input type="hidden" name="u_id" value="<?php echo session()->get('user_id'); ?>">
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
					</div>
                    
				</div>
			</div>
		</div>
		
@endsection()