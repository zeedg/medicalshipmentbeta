@extends('frontwebsite._mainLayout')
@section('content')
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
	<div id="myCarousel" class="carousel slide" data-ride="carousel" ng-controller="sliderController as slider">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
			<li data-target="#myCarousel" data-slide-to="2"></li>
		</ol>
		
		<!-- Wrapper for slides -->
		<div class="carousel-inner" ng-controller="sliderController as sctrl">
	<?php
	if(isset($slider) && count($slider) > 0){
	$i = 0;
	foreach($slider as $s) {
	$i++;
	?>
		<!-- Wrapper for slides -->
			<div class="item <?=  ($i == 1) ? 'active' : ''; ?>">
				<img src="{{ url('/uploads/slider/' . $s->slider_image) }}" alt="image not available" style="width:100%;">
			</div>
		<?php
		}
		}
		?>
			
			{{--<div ng-repeat="s as sctrl " class="item">
				<img src="{{ url('/') }}/uploads/slider/@{{s.slider_image}}" alt="New york" style="width:100%;">
			</div>--}}
		
		</div>
	</div>
	
	
	<!-- Left and right controls -->
	<a class="left carousel-control" href="#myCarousel" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#myCarousel" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right"></span>
		<span class="sr-only">Next</span>
	</a>
	</div>
	{{--<div id="myCarousel" class="carousel slide" data-ride="carousel" onmousemove="show_control();" onmouseout="hide_control();">--}}
	{{--<!-- Indicators -->--}}
	{{--<ol class="carousel-indicators">--}}
	{{--<li data-target="#myCarousel" data-slide-to="0" class="active"></li>--}}
	{{--<li data-target="#myCarousel" data-slide-to="1"></li>--}}
	{{--<li data-target="#myCarousel" data-slide-to="2"></li>--}}
	{{--<li data-target="#myCarousel" data-slide-to="3"></li>--}}
	{{--<li data-target="#myCarousel" data-slide-to="4"></li>--}}
	{{--</ol>--}}
	{{----}}
	{{--<!-- Wrapper for slides -->--}}
	{{--<div class="carousel-inner" role="listbox">--}}
	{{----}}
	{{--<div class="item active"><a href="https://medicalshipment.com/index.php?controller=category&function=index&id=106"><img src="{{ url('/') }}/placeholder.jpg" usemap="#demo_pyxis"></a>--}}
	{{----}}
	{{--<a href="https://youtu.be/6i4AXEognco" target="_blank"><p id="demo1"></p></a>--}}
	{{--<a href="https://youtu.be/N7s6_sH-VR4" target="_blank"><p id="demo2"></p></a>--}}
	{{--</div>--}}
	{{--<div class="item "><a href="https://medicalshipment.com/index.php?controller=category&function=index&id=36">--}}
	{{--<img src="{{ url('/') }}/placeholder.jpg">--}}
	{{--</a>--}}
	{{--</div>--}}
	{{--<div class="item "><a href="https://medicalshipment.com/index.php?controller=quote&function=index"><img src="{{ url('/') }}/placeholder.jpg"></a>--}}
	{{--</div>--}}
	{{--</div>--}}
	{{--</div>--}}
	
	<!-- Left and right controls -->
	<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
	<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a></div>
	<!-- Page container -->
	<div class="container">
		<div class="row main-contant">
			<div class="container contant-con">
				<div class="col-lg-9">
					<div class="col-lg-12">
						<div class="product-row">
							<div class="sect" id="flat-theme">
								<div class="container" style="width: 100%;">
									<section class="row">
										<div class="col-sm-12">
											<div class="">
												<div class="moduletable">
													<div id="offlajn-universal-product-slider-90-1-container" class=" loading">
														<div class="off_uni_slider_header">
															<div class="title">Featured Products</div>
														</div>
														<div class="controller">
															<div class="off-uni-slider-left featured-left" onmouseover="show_overflow('feature');" onmouseout="hide_overflow('feature');"></div>
															<div class="off-uni-slider-right featured-right" onmouseover="show_overflow('feature');" onmouseout="hide_overflow('feature');"></div>
														</div>
														<div class="offlajn-universal-product-slider-90-1-container-inner" id="feature_scroller" onmouseover="show_overflow('feature');" onmouseout="hide_overflow('feature');">
								<?php
								
								if(isset($featured) && count($featured) > 0){
								foreach($featured as $f){
								
								?>
															<div class="off-uni-slider-item">
																<div class="img_container">
																	<a href="{{ url('product-detail/' .$f->product_id )  }}" style="height: 170px; line-height: 170px;">
																		<img class="off-uni-slider-img" src="{{ url('/uploads/product/'.$f->product_image) }} "/>
																	</a>
																	<span>
                                <span><?= $f->product_price ?></span>                                
																	</span>
																</div>
																<span class="item_name"><a href="{{ url('product-detail/' .$f->product_id )  }}"><?= $f->product_title ?></a></span>
																
																<form id="form3_<?php echo $f->product_id; ?>" action="{{ url('addto_cart') }}" method="post" style="float: left;">
            <input type="hidden" name="qty_cart" id="qty_cart<?php echo $f->product_id; ?>" value="1" class="qty" />
            <input type="hidden" name="product_id" value="<?php echo intval($f->product_id)?>" />
            <input type="hidden" name="cquantity" id="cquantity<?php echo $f->product_id; ?>" value="1" />
            <input type="hidden" name="unit_id" id="unit_id<?php echo $f->product_id; ?>" value="<?php echo intval($f->unit_id)?>" />
          </form>                                                    
		  <?php if(trim($f->product_out_of_stock) == 0){  ?>
          <button class="addtocart" onclick="addCarthome(<?php echo $f->product_id; ?>);" ></button>
          <?php } else{ ?>
          <button class="outofstock"></button>
          <?php } ?>
															
															</div>
								<?php
								}
								}
								?>
														
														</div>
													</div>
													<div id="offlajn-universal-product-slider-900-1-container" class=" loading">
														<div class="off_uni_slider_header">
															<div class="title">New Products</div>
														</div>
														<div class="controller">
															<div class="off-uni-slider-left new-product new-left" onmouseover="show_overflow('new');" onmouseout="hide_overflow('new');"></div>
															<div class="off-uni-slider-right new-product new-right" onmouseover="show_overflow('new');" onmouseout="hide_overflow('new');"></div>
														</div>
														<div class="offlajn-universal-product-slider-900-1-container-inner" id="new_scroller" onmouseover="show_overflow('new');" onmouseout="hide_overflow('new');">
								
								<?php
								
								if(isset($new) && count($new) > 0){
								foreach($new as $f){
								
								?>
															<div class="off-uni-slider-item">
																<div class="img_container">
																	<a href="{{ url('product-detail/' .$f->product_id )  }}" style="height: 170px; line-height: 170px;"><img class="off-uni-slider-img" src="<?=  url('/uploads/product/'.$f->product_image); ?>"/></a><span>
                                <span><?= $f->product_price ?></span>                                </span></div>
																<span class="item_name"><a href="{{ url('product-detail/' .$f->product_id )  }}"><?= $f->product_title ?></a></span>
																
																<form id="form3_<?php echo $f->product_id; ?>" action="{{ url('addto_cart') }}" method="post" style="float: left;">
                    <input type="hidden" name="qty_cart" id="qty_cart<?php echo $f->product_id; ?>" value="1" class="qty" />
                    <input type="hidden" name="product_id" value="<?php echo intval($f->product_id)?>" />
                    <input type="hidden" name="cquantity" id="cquantity<?php echo $f->product_id; ?>" value="1" />
                    <input type="hidden" name="unit_id" id="unit_id<?php echo $f->product_id; ?>" value="<?php echo intval($f->unit_id)?>" />
                  </form>
                  <?php if(trim($f->product_out_of_stock) == 0){  ?>
                  <button class="addtocart" onclick="addCarthome(<?php echo $f->product_id; ?>);" ></button>
                  <?php } else{ ?>
                  <button class="outofstock"></button>
                  <?php } ?>
															
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
									</section>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3" style="margin-left: 0.5%;">
					<div class="col-lg-12 catalog">
						<div class="heading">View Catalog</div>
						<div class="probox"><a onclick="virtual_catalog();" target="_blank" href="{{ url('/catalog') }}"><img src="{{ url('/placeholder.jpg') }}" class="img-responsive pdpic"/></a>
							<div class="clickview"><a href="{{ url('/')  }}images/Medical Shipment 2015_Web.pdf" target="_blank">Click to View Pdf</a></div>
						</div>
					</div>
					<div class="col-lg-12 testimonials">
						<div class="heading mt20">Testimonials</div>
						
						<script type="text/javascript">
					
					/*jQuery(document).ready(function () {
							
							jQuery('#slideshow_advance').cycle({
									
									fx : 'scrollUp' ,
									
									timeout : 10000
							});
							
							jQuery('#slideshow_advance').css('min-height' , '280px');
							
					});*/
						
						</script>
						<script type="text/javascript">
					
					var tb_pathToImage = "{{ url('/') }}/media/testimonial/loading.gif";
						
						</script>
						<div class="probox" style="height: 330px;">
							<div id="slideshow_advance" style="width: 100%;">
								<div class="testimonials">North Park University in Chicago has been purchasing equipment and supplies from Medical Shipment for several years. Both the Nursing Learning Resourc...<br/>
									<span>Jennifer Bulinski </span> <br/>
																																		Simulation Coordinator and Tec <br/>
																																		3305 W. Foster Avenue
																																		Box 65
																																		Chicago, IL 60625 <br/>
								</div>
								<div class="testimonials">I have found Medical Shipment to be the fastest and most competitively-priced company for quality equipment and supplies in the business. Their expert...<br/>
									<span>Dana Rollins </span> <br/>
																																		Instruction & Classroom Suppor <br/>
																																		Highline Community College
																																		2400 South 240th St. Bldg.26-219
																																		Des Moines, WA 98198-9800
																																		(206) 878-3710 ext. 3379 <br/>
								</div>
								<div class="testimonials">Medical Shipment is the premier supplier for the University of St. Francis nursing labs. The customer service is exceptional! The dedicated team at Me...<br/>
									<span>Amy Galetti RN, BSN </span> <br/>
																																		Nursing Lab Coordinator Ceci <br/>
																																		500 Wilcox Street
																																		(211A) Motherhouse
																																		Joliet, IL 60435
																																		815-740-3817 office
																																		815-740-4243 fax <br/>
								</div>
								<div class="testimonials">I began to work with Medical Shipment about one year ago when I was searching for hospital beds. They were able to do the fact finding and provide qua...<br/>
									<span>Deborah Jezuit PhD RN </span> <br/>
																																		Director of Nursing Education <br/>
																																		College of Lake County <br/>
								</div>
							</div>
							<div class="clickview"><a href="{{ url('/')  }}index.php?controller=testimonials&function=index">View all</a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearz"></div><!--Footer Start -->
	
	 
@endsection()