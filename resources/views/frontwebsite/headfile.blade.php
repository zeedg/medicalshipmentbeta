<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Medical Shipment is a premium supplier of simulation nursing school training supplies and equipment. We are known as Nursing Education Supply experts, at your service.">
	<meta name="keywords" content="Nursing education products, Nursing training supplies, Nursing school training supplies, Medical simulation training products, Medical supplies for simulation, Medical supplies for education, Medical shipment supplies, Practice medication, Simulated medicine, Simulated drugs "/>
	<meta name="author" content="">
	<link rel="icon" href="{{ url('/') }}/images/favicon.ico" type="image/x-icon"/>
	<title>Medical Shipment | Nursing school training supplies</title>
	<link href="{{ url('/') }}/frontend/css/css.css" rel="stylesheet">
	<link href="{{ url('/') }}/frontend/css/bootstrap.min.css" rel="stylesheet">
	<link href="{{ url('/') }}/frontend/css/style.css" rel="stylesheet">
	<link href="{{ url('/') }}/frontend/css/print.css" rel="stylesheet" media="print" type="text/css">
	
	<script type="text/javascript">
		 var baseurl = '{{ url('/') }}';
		 var token = '{{ csrf_token() }}';
		 if (document.location.protocol != "https:") {
				 // document.location.href = "https://medicalshipment.com" + document.location.pathname;
		 }  </script>
	
	<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
	<script> $(function () { $("select option[value*='Sold Out']").prop('disabled' , true); }); </script>
	<script type="text/javascript" src="{{ url('/') }}/frontend/js/jquery-ui-1.8.2.custom.min.js"></script>
	
	{{--including --}}
	<script src="{{  url('/angular/angular.js') }}"></script>
	<script src="{{ url('/') }}/frontend/js/jquery.cycle.all.js"></script>
	<script src="{{  url('/ng-app.js') }}"></script>
	{{--<link rel="stylesheet" type="text/css" href="{{ url('/')  }}/frontend/css/testimonial/style.css">--}}
	
	<style>
		.socialmediaicons {}
		
		.socialmediaicons img {max-width: 20px;}
		
		#slideshow_advance, #mega-1 {display: none !important;}
		
		#myCarousel {}
		
		#myCarousel img {
			max-height: 300px;
			width: 100%;
		}
		
		
        
		
	</style>
	
	<script>
		 
		 function isNumber(evt) {
				 evt = (evt) ? evt : window.event;
				 var charCode = (evt.which) ? evt.which : evt.keyCode;
				 if (charCode > 31 && (charCode < 48 || charCode > 57)) {
						 return false;
				 }
				 return true;
		 }
		 
		 
		 function suggest_users() {
//alert('Here');
				 jQuery.noConflict();
				 var result = false;
				 category = $("#category").val();
				 var term = $("#dd_user_input").val();
				 
				 if (term.length > 1) {
						 $.ajax({
								 url : "global_search1.php?city=" + category + "&term=" + term ,
								 async : true ,
								 success : function (data) {
										 result = data;
								 }
						 });
				 }
				 
				 $("#dd_user_input").autocomplete({
						 source : "global_search.php?city=" + category ,
						 minLength : 2 ,
						 select : function (event , ui) {
								 var getUrl = ui.item.id;
								 if (getUrl != '#') {
										 location.href = getUrl;
								 }
						 } ,
						 
						 html : true ,
						 
						 open : function (event , ui) {
								 $(".ui-autocomplete").css("z-index" , 1000);
								 $(".ui-autocomplete li:nth-child(" + result + ")").css("border-bottom" , "1px solid #CCC");
						 }
				 });
				 
		 }
	
	</script>
	<link href="{{ url('/frontend') }}/css/vertical_menu_basic.css" rel="stylesheet" type="text/css"/>
	<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
	<script type='text/javascript' src='{{ url('') }}/frontend/js/jquery.hoverIntent.minified.js'></script>
	<script type='text/javascript' src='{{ url('') }}/frontend/js/jquery.dcverticalmegamenu.1.1.js'></script>
	<script type="text/javascript">
		 $(document).ready(function ($) {
				 $('#mega-1').dcVerticalMegaMenu({
						 rowItems : '3' ,
						 speed : 'fast' ,
						 effect : 'slide' ,
						 direction : 'right'
				 });
				 
				 var cc = document.getElementsByName('cc_id');
				 var booRadio;
				 var x = 0;
				 for (x = 0; x < cc.length; x++) {
						 //	paymentmethodcc('p_method_ccpayment');	
						 cc[x].onclick = function () {
								 if (booRadio == this) {
										 
										 this.checked = false;
										 booRadio = null;
								 } else {
										 
										 booRadio = this;
								 }
						 };
				 }
				 
				 $('.cc_radio').click(function () {
						 document.getElementById('p_method_ccpayment').checked = true;
				 });
				 
				 
				  $('#useAddress').click(function () {
						 if ($("input[name=ship_to_this]").is(':checked')) {
								 
								 pageurl = '{{ action('CheckOutController@checkoutAjax') }}';
								 
								 var shipto = $('input:radio[name=ship_to_this]:checked').val();
								 
								 $("#loading_address").show();
								 $("#slide_address").slideUp();
								 
								 $.ajax({
										 url : pageurl + '?ship_to_this=' + shipto ,
										 async : true ,
										 success : function (data) {
												 $("#loading_address").hide();
												 //$('body').html(data);
												 $('#htmldiv').html(data);
										 }
								 });
								 
								 //to change the browser URL to 'pageurl'
								 if (pageurl != window.location) {
										 window.history.pushState({path : pageurl} , '' , pageurl);
								 }
								 return false;
						 } else {
								 alert('Please select shipping address');
								 return false;
						 }
						 
				 });
				 
				 $('#checkoutContinue').click(function () {
						 
						 pageurl = '{{ url('/') }}/index.php?controller=cart&function=review';
						 
						 var paymentMethod = $('input:radio[name=payment_method]:checked').val();
						 
						 
						 if (paymentMethod == undefined) {
								 alert('Select payment method Plz');
								 return false;
						 }
						 
						 if (document.getElementById('p_method_checkmo').checked) {
								 
								 if (document.getElementById('check_radio').checked || document.getElementById('moneyorder_radio').checked || document.getElementById('po_radio').checked) {
								 } else {
										 alert('Select Check, Money Order or Purchase Order.');
										 return false;
								 }
						 }
						 
						 if (document.getElementById('po_radio').checked) {
								 if ($('#po_file').val() == '' || $('#po_no').val() == '') {
										 alert('Enter PO number and attach file.');
										 return false;
								 }
						 }
						 
						 $("#loading_payment").show();
						 $("#selectpayment").slideUp();
						 if (paymentMethod == 'ccpayment' || paymentMethod == 'echeckpayment') {
								 
								 var ccId = $('input:radio[name=cc_id]:checked').val();
								 
								 $.ajax({
										 method : "POST" ,
										 url : pageurl ,
										 data : {
												 payment_method : paymentMethod ,
												 cc_id : ccId
										 } ,
										 async : true ,
										 success : function (data) {
												 
												 $('body').html(data);
										 }
								 });
								 
						 }
						 if (paymentMethod == 'checkmo') {
								 
								 var checkmo = $('input:radio[name=check]:checked').val();
								 var poNo = $('#po_no').val();
								 //var poFile = new FormData(this);
								 
								 $.ajax({
										 method : "POST" ,
										 url : pageurl ,
										 data : {
												 payment_method : paymentMethod ,
												 checkmo : checkmo ,
												 poNo : poNo
										 } ,
										 async : true ,
										 success : function (response) {
												 $('body').html(response);
										 }
								 });
								 
						 }
						 
						 //to change the browser URL to 'pageurl'
						 if (pageurl != window.location) {
								 window.history.pushState({path : pageurl} , '' , pageurl);
						 }
						 return false;
						 
				 });
				 
				 $('#amzChangeAddress').click(function () {
						 pageurl = '{{ url('/') }}/index.php?controller=cart&function=payment';
						 
						 $("#selectpayment").slideUp();
						 $(".ship_speed").slideUp();
						 $("#slide_address").hide();
						 $("#loading_address").show();
						 $.ajax({
								 url : pageurl ,
								 async : true ,
								 success : function (data) {
										 $('body').html(data);
								 }
						 });
						 
						 //to change the browser URL to 'pageurl'
						 if (pageurl != window.location) {
								 window.history.pushState({path : pageurl} , '' , pageurl);
						 }
						 return false;
				 });
				 
				 $('#amzChangePayment').click(function () {
						 pageurl = '{{ url('/') }}/index.php?controller=cart&function=checkout';
						 
						 $("#tour_div_7").slideDown();
						 $("#selectpayment").hide();
						 $("#loading_payment").show();
						 $.ajax({
								 url : pageurl ,
								 async : true ,
								 success : function (data) {
										 $('body').html(data);
								 }
						 });
						 
						 //to change the browser URL to 'pageurl'
						 if (pageurl != window.location) {
								 window.history.pushState({path : pageurl} , '' , pageurl);
						 }
						 return false;
				 });
				 
				 $(".featured-left").click(function () {
						 var w = $(".owl-item").width();
						 $(".offlajn-universal-product-slider-90-1-container-inner .owl-wrapper-outer").animate({scrollLeft : "-=" + w});
				 });
				 $(".featured-right").click(function () {
						 var w = $(".owl-item").width();
						 $(".offlajn-universal-product-slider-90-1-container-inner .owl-wrapper-outer").animate({scrollLeft : "+=" + w});
				 });
				 
				 $(".new-left").click(function () {
						 var w = $(".owl-item").width();
						 $(".offlajn-universal-product-slider-900-1-container-inner .owl-wrapper-outer").animate({scrollLeft : "-=" + w});
				 });
				 $(".new-right").click(function () {
						 var w = $(".owl-item").width();
						 $(".offlajn-universal-product-slider-900-1-container-inner .owl-wrapper-outer").animate({scrollLeft : "+=" + w});
				 });
				 
		 });
	</script>
	<script type="text/javascript">
		 $(document).ready(function (e) {
				 $("#up_cart").click(function () {
						 $('#qty_cart').val(parseInt($('#qty_cart').val()) + 1);
				 });
				 
				 
				 $("#down_cart").click(function () {
						 if ($('#qty_cart').val() > 1) {
								 $('#qty_cart').val(parseInt($('#qty_cart').val()) - 1);
						 }
				 });
				 
				 $("#up_quote").click(function () {
						 $('#qty_quote').val(parseInt($('#qty_quote').val()) + 1);
				 });
				 
				 
				 $("#down_quote").click(function () {
						 if ($('#qty_quote').val() > 1) {
								 $('#qty_quote').val(parseInt($('#qty_quote').val()) - 1);
						 }
				 });
				 
				 $('.keypress').keypress(function (event) {
						 
						 cat = $('#category').val();
						 if (cat == -1) {
								 cat = 'all';
						 }
						 var keycode = (event.keyCode ? event.keyCode : event.which);
						 
						 if (keycode == '13') {
								 
								 
								 keyword = document.getElementById(this.id).value;
								 
								 if (!keyword.trim()) {
										 alert('Search field is empty');
										 return false;
								 }
								 
								 getUrl = "index.php?controller=category&function=index&id=" + cat + "&keyword=" + keyword;
								 window.location = getUrl;
								 
						 }
						 
						 //Stop the event from propogation to other handlers
						 
						 //If this line will be removed, then keypress event handler attached
						 
						 //at document level will also be triggered
						 
						 event.stopPropagation();
						 
				 });
				 
		 });
		 
		 
		 function uploadImage(val) {
				 $("#poattachment").on('change' , (function (e) {
						 e.preventDefault();
						 $.ajax({
								 url : "upload.php" ,
								 type : "POST" ,
								 data : new FormData(this) ,
								 contentType : false ,
								 cache : false ,
								 processData : false ,
								 success : function (data) {
										 //	alert(data);
								 } ,
								 error : function () {
								 }
						 });
				 }));
		 }
		 
		 function show_overflow(val) {
				 $('#' + val + '_scroller .owl-wrapper-outer').css('overflow-x' , 'auto');
		 }
		 
		 function hide_overflow(val) {
				 $('#' + val + '_scroller .owl-wrapper-outer').css('overflow-x' , 'hidden');
		 }
		 
		 function reviewSave() {
				 if ($("input:radio[name='shipping_method']").length > 0 && $("input:radio[name='shipping_method']").is(":checked") == false) {
						 alert("Please select shipping method");
						 $('#shipping_method').focus();
				 } else if ($("input:radio[name='ship_pref']").is(":checked") == false) {
						 alert("Please select shipping preference");
						 $('#ship_pref1').focus();
				 } else {
						 window.location = 'index.php?controller=cart&function=checkoutCustomer';
				 }
		 }
		 
		 function OrderSave() {
				 if ($("input:radio[name='ship_pref']").is(":checked") == false) {
						 alert("Please select shipping preference");
						 $('#ship_pref1').focus();
				 } else {
						 window.location = 'index.php?controller=cart&function=saveOrder';
				 }
		 }
		 
		 
		 function show_control() {
				 $('.carousel-control').show();
		 }
		 
		 function hide_control() {
				 $('.carousel-control').hide();
		 }
		 
		 function checkout_popup() {
				 $("#checkout_popup").show();
				 return false;
		 }
		 
		 function hide_checkout() {
				 $("#checkout_popup").hide();
				 return false;
		 }
		 
		 function return_cart() {
				 window.location.href = '{{ url('/') }}/index.php?controller=cart&function=index';
		 }
		 
		 function plus_cart(pro_id , unit_id) {
				 $('#1inp' + pro_id).val(parseInt($('#1inp' + pro_id).val()) + 1);
				 $('#update_' + pro_id).css('display' , 'block');
				 $('#save_' + pro_id).css('display' , 'none');
				 //	updateCart(pro_id,unit_id)
		 };
		 
		 
		 function minus_cart(pro_id , unit_id) {
				 if ($('#1inp' + pro_id).val() > 1) {
						 $('#1inp' + pro_id).val(parseInt($('#1inp' + pro_id).val()) - 1);
						 $('#update_' + pro_id).css('display' , 'block');
						 $('#save_' + pro_id).css('display' , 'none');
						 //updateCart(pro_id,unit_id)
						 
				 }
		 }
		 
		 function searchtop(href , view) {
				 
				 if (view == 'desktop') {
						 keyword = document.getElementById('keyword1').value;
				 } else {
						 keyword = document.getElementById('keyword2').value;
				 }
				 
				 
				 if (!keyword.trim()) {
						 alert('Search field is empty');
						 return false;
				 }
				 
				 if (window.XMLHttpRequest) {
						 // code for IE7+, Firefox, Chrome, Opera, Safari
						 xmlhttp = new XMLHttpRequest();
				 } else { // code for IE6, IE5
						 xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				 }
				 xmlhttp.onreadystatechange = function () {
						 if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
								 
								 window.location = xmlhttp.responseText;
								 
						 }
				 }
				 var con = 'search_server';
				 var site = 'http://localhost/MedicalShipment_New/';
				 var path = site + "index.php?controller=" + con + "&function=index" + "&href=" + href + "&keyword=" + keyword;
				 xmlhttp.open("GET" , path , true);
				 xmlhttp.send();
				 
		 }
		 
		 function getCartItemsTop() {
			 
			 	 $.post("{{ url('/cart/ajax_cart_items') }}", {_token : "{{ csrf_token() }}"} , function (response) {
			            			 
						 $('#shopping_cart_menu').html(response);
						 
				 });
				 
				 return false;
				 
		 }
		 
		 function varifyaddress() {
				 var address = document.getElementById('address').value;
				 var zip = document.getElementById('zip').value;
				 var city = document.getElementById('city').value;
				 var states = document.getElementById('states').value.split("_");
				 var state = states[0];
				 var truefalse = false;
				 
				 $.ajax({
						 url : '{{ url('/') }}/validate_address.php' ,
						 global : false ,
						 type : 'POST' ,
						 data : {
								 address : address ,
								 zip : zip ,
								 city : city ,
								 state : state
						 } ,
						 cache : false ,
						 async : false , //blocks window close
						 success : function (data) {
								 if (data == 'INVALID') {
										 document.getElementById('addr_error').innerHTML = 'Invalid Address';
										 $("#address").focus();
										 truefalse = false;
								 } else {
										 truefalse = true;
								 }
						 }
				 });
				 return truefalse;
		 }
		 
		 function addCartGroup() {
				 
				 $('#form3').submit();
				 
				 getCartItemsTop();
		 }
		 
		 function addCartConfigure() {
				 
				 $('#form3').submit();
				 
				 getCartItemsTop();
		 }
		 
		 function addCart() {
				 var qnty = $('#qty_cart').val();
				 $('#cquantity').val(qnty);
				 
				 $('#form3').submit();
				 
				 getCartItemsTop();
		 }
		 
		 
		 function addCarthome(id) {
			 
    		 var qnty = $('#qty_cart' + id).val();
    		 var unit_id = $('#unit_id' + id).val();
    		 $('#cquantity' + id).val(qnty);
    		 
    		 //$.post("{{ url('/') }}/cart/ajax", {_token : "{{ csrf_token() }}"} , {
    		$.post("{{ url('/') }}/cart/ajax", {		 
    				 product_id : id ,
    				 cquantity : qnty ,
    				 unit_id : unit_id,
    				 _token : "{{ csrf_token() }}"
    		 } , function (data) {
    				 if (data == 'login') {
    					//window.location = 'index.php?controller=login&function=index&pid=' + id;
    					window.location = '{{ url("login_user") }}';
    				 } else { 
    					$('#ajaxcart-overlay').show();
    					$('#ajaxcart-popup').show();
    				 }
    		 });
    		 
    		 getCartItemsTop();
    		 //$('#form3_'+id).submit();
    	}
		 
		 function virtual_catalog() {
				 $.post("{{ url('/') }}/index.php?controller=catalog&function=virtual_catalog" , function (data) {
						 
				 });
		 }
		 
		 function get_uom(val) {
				 $.post("{{ url('/') }}/index.php?controller=product&function=get_uom" , {cpo_id : val} , function (data) {
						 $("#uom").html(data);
				 });
		 }
		 
		 function close_popup() {
				 $("#ajaxcart-overlay").hide();
				 $("#ajaxcart-popup").hide();
		 }
		 
		 function getCartItemAjax() {
				 
				 $.post("{{ url('/') }}/cart/ajax_cart", {_token : "{{ csrf_token() }}"} , function (response) {
							 
						 //	var myArr = response.split('?/');
						 $('#cart_menu').html(response);
						 
						 //	document.getElementById('cart_menu').innerHTML =response;
						 
				 });
				 
				 return false;
				 
		 }
		 
		 function add_shipping(ship , name) {
				 $.post("{{ url('/') }}/index.php?controller=cart&function=set_delivery" , {
						 ship : ship ,
						 name : name
				 } , function () {
						 
				 });
				 
				 var total_amount = document.getElementById('total_amount').innerHTML.replace(/\,/g , "");
				 if (document.getElementById("discount") != null) {
						 var discount = document.getElementById('discount').innerHTML.replace(/\,/g , "");
				 } else {
						 var discount = 0;
				 }
//	var discount = document.getElementById('discount').innerHTML.replace(/\,/g,"");
				 var g_total = parseFloat(total_amount) + parseFloat(ship);
				 
				 document.getElementById('tax_amount').innerHTML = parseFloat(ship).toFixed(2);
//	$('#tax_amount').val(parseFloat(ship));
				 $('#name').val(name);
				 $('#total_befor_tax').val(g_total);
				 document.getElementById('total_befor_tax').innerHTML = g_total.toFixed(2);
				 document.getElementById('grand_total_amount_after_tax').innerHTML = (g_total - parseFloat(discount)).toFixed(2);
				 document.getElementById('order_total_bottom').innerHTML = (g_total - parseFloat(discount)).toFixed(2);
		 }
		 
		 function AddCard() {
				 var cardName = $("#card_name").val();
				 var cardHolderName = $("#card_holder_name").val();
				 var cardnum = $("#x_card_num").val();
				 var cardcvv = $("#x_card_cvv").val();
				 var expDatem = $("#x_exp_date_m").val();
				 var expDatey = $("#x_exp_date_y").val();
				 
				 if (cardName == '') {
						 $("#card_error").html('Select card required');
						 $("#card_name").focus();
						 return false;
				 }
				 
				 if (cardHolderName == '') {
						 $("#card_holder_name").html('Name on card is required');
						 $("#card_name").focus();
						 return false;
				 }
				 
				 if (cardnum == '') {
						 $("#card_error").html('Card number is required');
						 $("#x_card_num").focus();
						 return false;
				 }
				 
				 if (cardcvv == '') {
						 $("#card_error").html('Card CVV number is required');
						 $("#x_card_cvv").focus();
						 return false;
				 }
				 
				 if (expDatem == '') {
						 $("#card_error").html('Expire Date is required');
						 $("#x_exp_date_m").focus();
						 return false;
				 }
				 
				 if (expDatey == '') {
						 $("#card_error").html('Expire Date is required');
						 $("#x_exp_date_y").focus();
						 return false;
				 }
				 $("#card_error").hide();
				 //$.post("{{ url('/') }}/index.php?controller=cart&function=check_card" , {
				   $.post("{{ url('/') }}/cart/check_card" , {		 
						 cardnum : cardnum ,
						 cardname : cardName,
						 _token : "{{ csrf_token() }}"
				 } , function (response) {
						 //alert(response);
						 if (response != 1) {
								 $("#card_error").show();
								 $("#card_error").html(response);
						 } else {
								 //$.post("{{ url('/') }}/index.php?controller=cart&function=add_creditcard" , {
								 $.post("{{ url('/') }}/cart/add_creditcard" , {
										 cardnum : cardnum ,
										 cardcvv : cardcvv ,
										 card_holder_name : cardHolderName ,
										 cardname : cardName ,
										 expDatem : expDatem ,
										 expDatey : expDatey ,
										 _token : "{{ csrf_token() }}"
								 } , function (response) {
										 $("#credit_cards").append(response);
										 $("#add_a_card").trigger("click");
										 $("#p_method_ccpayment").prop("checked" , true);
										 $(".cc_radio").focus();
										 if (response == '') {
												 $("#CardSuccess").html('<span style="color:red">Card Number Already Exist!</p>');
										 } else {
												 $("#CardSuccess").html('Card added successfully');
										 }
								 });
						 }
				 });
		 }
		 
		 function EditCard() {
				 var cardId = $("#cardId").val();
				 var cardName = $("#card_name1").val();
				 var cardHolderName = $("#card_holder_name1").val();
				 var cardnum = $("#x_card_num1").val();
				 var cardcvv = $("#x_card_cvv1").val();
				 var expDatem = $("#x_exp_date_m1").val();
				 var expDatey = $("#x_exp_date_y1").val();
				 
				 if (cardName == '') {
						 $("#card_error1").html('Select card required');
						 $("#card_name1").focus();
						 return false;
				 }
				 
				 if (cardHolderName == '') {
						 $("#card_holder_name1").html('Name on card is required');
						 $("#card_name1").focus();
						 return false;
				 }
				 
				 if (cardnum == '') {
						 $("#card_error1").html('Card number is required');
						 $("#x_card_num1").focus();
						 return false;
				 }
				 
				 if (cardcvv == '') {
						 $("#card_error1").html('Card CVV number is required');
						 $("#x_card_cvv1").focus();
						 return false;
				 }
				 
				 if (expDatem == '') {
						 $("#card_error1").html('Expire Date is required');
						 $("#x_exp_date_m1").focus();
						 return false;
				 }
				 
				 if (expDatey == '') {
						 $("#card_error1").html('Expire Date is required');
						 $("#x_exp_date_y1").focus();
						 return false;
				 }
				 $("#card_error1").hide();
				 //$.post("{{ url('/') }}/index.php?controller=cart&function=check_card" , {
				 $.post("{{ url('/') }}/cart/check_card" , { 		 
						 cardnum : cardnum ,
						 cardname : cardName ,
						 _token : "{{ csrf_token() }}"
				 } , function (response) {
						 //alert(response);
						 if (response != 1) {
								 $("#card_error").show();
								 $("#card_error").html(response);
						 } else {
								 //$.post("{{ url('/') }}/index.php?controller=cart&function=edit_creditcard" , {
								   $.post("{{ url('/') }}/cart/edit_creditcard" , {		 
										 cardId : cardId ,
										 cardnum : cardnum ,
										 cardcvv : cardcvv ,
										 card_holder_name : cardHolderName ,
										 cardname : cardName ,
										 expDatem : expDatem ,
										 expDatey : expDatey ,
										 _token : "{{ csrf_token() }}"
								 } , function (response) {
										 $("#credit_cards").html(response);
										 $("#cc_opt_edit").hide();
										 $('html,body').animate({
												 scrollTop : $("#tour_div_9").offset().top
										 } , 'slow');
										 $("#CardSuccess").html('Card updated successfully');
										 
								 });
						 }
				 });
		 }
		 
		 function AddBank() {
				 var echeckName = $("#echeckpayment_echeck_name_account").val();
				 var routingNumber = $("#echeckpayment_echeck_routing_number").val();
				 var bankAcctNum = $("#echeckpayment_echeck_bank_acct_num").val();
				 var driverLicenseNumber = $("#echeckpayment_echeck_driver_license_number").val();
				 var accountType = $("#echeckpayment_echeck_account_type").val();
				 
				 
				 if (echeckName == '') {
						 $("#bank_error").html('Please enter bank account name');
						 $("#echeckpayment_echeck_name_account").focus();
						 return false;
				 }
				 
				 if (routingNumber == '') {
						 $("#bank_error").html('Please enter bank routing number');
						 $("#echeckpayment_echeck_routing_number").focus();
						 return false;
				 }
				 
				 if (bankAcctNum == '') {
						 $("#bank_error").html('Please enter bank account number');
						 $("#echeckpayment_echeck_bank_acct_num").focus();
						 return false;
				 }
				 
				 if (driverLicenseNumber == '') {
						 $("#bank_error").html('Please enter driver license number');
						 $("#echeckpayment_echeck_driver_license_number").focus();
						 return false;
				 }
				 
				 if (accountType == '') {
						 $("#bank_error").html('Please select account type');
						 $("#echeckpayment_echeck_account_type").focus();
						 return false;
				 }
				 
				 $.post("{{ url('/') }}/index.php?controller=cart&function=add_bank" , {
						 echeckName : echeckName ,
						 routingNumber : routingNumber ,
						 bankAcctNum : bankAcctNum ,
						 driverLicenseNumber : driverLicenseNumber ,
						 accountType : accountType
				 } , function (response) {
						 $("#credit_cards").append(response);
				 });
		 }
		 
		 function paymentmethodcc(id) {
//	alert(id);
				 document.getElementById(id).checked = true;
//	paymentMethod('ccpayment');
		 }
		 
		 function selectRadio(ids) {
				 
				 if (document.getElementById(ids).checked) {
						 
						 document.getElementById('ship_holder').style.display = 'none';
						 
				 } else {
						 
						 document.getElementById('ship_holder').style.display = 'block';
						 
				 }
				 
		 }
		 
		 function urlEncode() {
				 cat = $('#category').val();
				 if (cat == -1) {
						 cat = 'all';
				 }
				 q = $('#dd_user_input').val();
				 q.replace(" " , "+");
				 if (q == "Search Products Here") {
						 q = "";
				 }
				 getUrl = "index.php?controller=category&function=index&id=" + cat + "&keyword=" + q;
				 window.location = getUrl;
				 
		 }
		 
		 function limit_string(limit) {
				 var url = window.location.href
				 var n = url.search("limit");
				 
				 if (n == -1) {
						 url = url + "&limit=" + limit;
				 } else {
						 array = url.split("&");
						 str = "";
						 for (i = 0; i < array.length; i++) {
								 
								 var n = array[i].search("limit");
								 if (n == -1) {
										 str += array[i] + "&";
								 } else {
										 if (limit.trim() != '') {
												 str = str + "limit=" + limit;
										 } else {
												 str = str.substring(0 , str.length - 1);
										 }
								 }
						 }
						 url = str;
				 }
				 return url;
		 }
		 
		 function apply_limit(val) {
				 var url = limit_string(val);
				 window.location = url;
		 }
		 
		 function paymentMethod(method) {
				 if (method == 'ccpayment') {
						 $("#cc_opt").toggle();
						 var text = $('#add_a_card').text();
						 $('#add_a_card').text(text == "Add a card" ? "Close" : "Add a card");
						 
						 document.getElementById("mo_opt").style.display = 'none';
						 document.getElementById("ec_opt").style.display = 'none';
						 $('#send_check').text("Send Check / Money order to medicalshipment");
						 $('#checking_account').text("Add a checking account");
						 $('#checkoutContinue').toggleClass('signin_btn_grey');
						 //	document.getElementById("p_method_ccpayment").checked = true;
				 }
				 
				 if (method == 'checkmo') {
						 $("#mo_opt").toggle();
						 var text = $('#send_check').text();
						 $('#send_check').text(text == "Send Check / Money order to medicalshipment" ? "Close" : "Send Check / Money order to medicalshipment");
						 
						 document.getElementById("cc_opt").style.display = 'none';
						 document.getElementById("ec_opt").style.display = 'none';
						 $('#add_a_card').text("Add a card");
						 $('#checking_account').text("Add a checking account");
						 document.getElementById("p_method_checkmo").checked = true;
						 $('#checkoutContinue').removeClass('signin_btn_grey');
				 }
				 
				 if (method == 'echeckpayment') {
						 $("#ec_opt").toggle();
						 var text = $('#checking_account').text();
						 $('#checking_account').text(text == "Add a checking account" ? "Close" : "Add a checking account");
						 
						 document.getElementById("cc_opt").style.display = 'none';
						 document.getElementById("mo_opt").style.display = 'none';
						 $('#add_a_card').text("Add a card");
						 $('#send_check').text("Send Check / Money order to medicalshipment");
						 document.getElementById("p_method_echeckpayment").checked = true;
						 $('#checkoutContinue').removeClass('signin_btn_grey');
				 }
				 
		 }
		 
		 
		 function showEditCard(id) {
				 $("#cc_opt_edit").show();
				 $('html,body').animate({
						 scrollTop : $("#cc_opt_edit").offset().top
				 } , 'slow');
				 var text = $('#add_a_card').text();
				 $('#add_a_card').text(text == "Edit card" ? "Close" : "Edit card");
				 
				 //$.post("{{ url('/') }}/index.php?controller=cart&function=get_card" , {id : id} , function (response) {
				 $.post("{{ url('/') }}/cart/get_card" , {id : id, _token : "{{ csrf_token() }}"} , function (response) {		 
						 $("#cc_opt_edit").html(response);
				 });
		 }
	</script>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" href="{{ url('/') }}/frontend/css/owl.carousel.css" type="text/css"/>
	<link rel="stylesheet" href="{{ url('/') }}/frontend/css/scroller.css" type="text/css"/>
	<script src="{{ url('/') }}/frontend/js/jquery.min.js" type="text/javascript"></script>
	<script src="{{ url('/') }}/frontend/js/owl.carousel.js" type="text/javascript"></script>
	<script type="text/javascript">
		 
		 $.noConflict();
		 ;(window.jq183 || jQuery)(document).ready(function ($) {
				 $("#dd_user_input").focus(function () {
							 $('#category').addClass("focus");
					 })
					 .blur(function () {
							 $('#category').removeClass("focus");
					 });
				 var cont = "offlajn-universal-product-slider-90-1-container";
				 var theme = "flat";
				 $("#" + cont).removeClass("loading loading2");
				 
				 var res = function () {
						 var cont = "offlajn-universal-product-slider-90-1-container";
						 var theme = "flat";
						 if (theme == "light" || theme == "modern") {
								 var w = jQuery(window).outerWidth();
								 var p = $("#" + cont).parent();
								 $("#" + cont + " .cont").width(w).css({"left" : "-" + p.offset().left + "px"});
						 }
						 
						 
						 var h = $("#" + cont + " .off-uni-slider-item.showdesc img").height();
						 
						 
						 var showheader = "1";
						 var h = $("#" + cont + " .off-uni-slider-item.showdesc img").height();
						 $("#" + cont + " .off-uni-slider-item.truncdesc, #" + cont + " .off-uni-slider-item .truncdesc").css({height : h + "px"});
						 $(owl90).trigger("owlafterUpdate");
						 
						 if (theme == "simple" || theme == "elegant") {
								 var h = $("#" + cont + " .owl-item .item_header").outerHeight();
								 if (showheader != "1") {
										 h = 0;
								 }
								 var mainH = $("#" + cont + " .owl-item .main").outerHeight();
								 if (mainH - 150 > 0) {
										 h += ($("#" + cont + " .owl-item .main").outerHeight() - 150) / 2;
								 }
								 $("#" + cont + " .off-uni-slider-left-container, #" + cont + " .off-uni-slider-right-container").css({marginTop : h + "px"});
						 } else {
								 var headerW = $("#" + cont + " .off_uni_slider_header").outerWidth();
								 var titleW = $("#" + cont + " .title").outerWidth();
								 var controllerW = $("#" + cont + " .controller").outerWidth();
								 var paginations = $("#" + cont + " .controller .owl-pagination .owl-page");
								 /* if(titleW + controllerW > headerW) {
											$(paginations).css({display: "none"});
										} else {
											$(paginations).css({display: "inline-block"});
										}*/
						 }
				 };
				 
				 owl90 = $(".offlajn-universal-product-slider-90-1-container-inner");
				 owl90.owlCarousel({
						 
						 afterInit : function (c) {
								 that = this;
								 var cont = "offlajn-universal-product-slider-90-1";
								 var controller = "#" + cont + "-container .controller";
								 var c = $("" + controller + "");
								 that.owlControls.prependTo(c);
								 //res();          
						 } ,
						 afterUpdate : res ,
						 itemsCustom : [[0 , 1] , [469 , 2] , [569 , 3] , [769 , 4] , [1025 , 4] , [1400 , 5]] ,
						 singleItem : false ,
						 autoPlay : false ,
						 lazyLoad : true ,
						 slideSpeed : 500 ,
						 rewindNav : false ,
						 stopOnHover : true ,
						 autoDraggerLength : false ,
				 });
				 owl90.trigger("owl.afterUpdate");
				 $(window).load(function () {
						 res();
				 });
				 var cont = "offlajn-universal-product-slider-90-1-container";
				 var theme = "flat";
				 var lArrow = $("#" + cont + " .off-uni-slider-left-container").on("click" , function () {owl90.trigger("owl.prev");});
				 var rArrow = $("#" + cont + " .off-uni-slider-right-container").on("click" , function () {owl90.trigger("owl.next");});
				 if (theme == "flat" || theme == "plastic" || theme == "modern" || theme == "light" || theme == "simple" || theme == "blank") {
						 var lArrow = $("#" + cont + " .off-uni-slider-left").on("click" , function () {owl90.trigger("owl.prev");});
						 var rArrow = $("#" + cont + " .off-uni-slider-right").on("click" , function () {owl90.trigger("owl.next");});
				 }
				 var lArrowInner = $("#" + cont + " .off-uni-slider-left-arrow");
				 var rArrowInner = $("#" + cont + " .off-uni-slider-right-arrow");
				 $(document).on("keypress" , function (e) {
						 switch (e.key) {
								 case "Left":
										 owl90.trigger("owl.prev");
										 break;
								 case "Right":
										 owl90.trigger("owl.next");
										 break;
						 }
				 });
				 
				 
		 });
		 
		 ;(window.jq183 || jQuery)(document).ready(function ($) {
				 
				 var cont = "offlajn-universal-product-slider-900-1-container";
				 var theme = "flat";
				 $("#" + cont).removeClass("loading loading2");
				 
				 var res = function () {
						 var cont = "offlajn-universal-product-slider-900-1-container";
						 var theme = "flat";
						 if (theme == "light" || theme == "modern") {
								 var w = jQuery(window).outerWidth();
								 var p = $("#" + cont).parent();
								 $("#" + cont + " .cont").width(w).css({"left" : "-" + p.offset().left + "px"});
						 }
						 
						 
						 var h = $("#" + cont + " .off-uni-slider-item.showdesc img").height();
						 
						 
						 var showheader = "1";
						 var h = $("#" + cont + " .off-uni-slider-item.showdesc img").height();
						 $("#" + cont + " .off-uni-slider-item.truncdesc, #" + cont + " .off-uni-slider-item .truncdesc").css({height : h + "px"});
						 $(owl90).trigger("owlafterUpdate");
						 
						 if (theme == "simple" || theme == "elegant") {
								 var h = $("#" + cont + " .owl-item .item_header").outerHeight();
								 if (showheader != "1") {
										 h = 0;
								 }
								 var mainH = $("#" + cont + " .owl-item .main").outerHeight();
								 if (mainH - 150 > 0) {
										 h += ($("#" + cont + " .owl-item .main").outerHeight() - 150) / 2;
								 }
								 $("#" + cont + " .off-uni-slider-left-container, #" + cont + " .off-uni-slider-right-container").css({marginTop : h + "px"});
						 } else {
								 var headerW = $("#" + cont + " .off_uni_slider_header").outerWidth();
								 var titleW = $("#" + cont + " .title").outerWidth();
								 var controllerW = $("#" + cont + " .controller").outerWidth();
								 var paginations = $("#" + cont + " .controller .owl-pagination .owl-page");
								 /* if(titleW + controllerW > headerW) {
											$(paginations).css({display: "none"});
										} else {
											$(paginations).css({display: "inline-block"});
										}*/
						 }
				 };
				 
				 owl900 = $(".offlajn-universal-product-slider-900-1-container-inner");
				 owl900.owlCarousel({
						 
						 afterInit : function (c) {
								 that = this;
								 var cont = "offlajn-universal-product-slider-900-1";
								 var controller = "#" + cont + "-container .controller";
								 var c = $("" + controller + "");
								 that.owlControls.prependTo(c);
								 //res();          
						 } ,
						 afterUpdate : res ,
						 itemsCustom : [[0 , 1] , [469 , 2] , [569 , 3] , [769 , 4] , [1025 , 4] , [1400 , 5]] ,
						 singleItem : false ,
						 autoPlay : false ,
						 lazyLoad : true ,
						 slideSpeed : 500 ,
						 rewindNav : false ,
						 stopOnHover : true ,
				 });
				 owl900.trigger("owl.afterUpdate");
				 $(window).load(function () {
						 res();
				 });
				 var cont = "offlajn-universal-product-slider-900-1-container";
				 var theme = "flat";
				 var lArrow = $("#" + cont + " .off-uni-slider-left-container").on("click" , function () {owl900.trigger("owl.prev");});
				 var rArrow = $("#" + cont + " .off-uni-slider-right-container").on("click" , function () {owl900.trigger("owl.next");});
				 if (theme == "flat" || theme == "plastic" || theme == "modern" || theme == "light" || theme == "simple" || theme == "blank") {
						 var lArrow = $("#" + cont + " .off-uni-slider-left").on("click" , function () {owl900.trigger("owl.prev");});
						 var rArrow = $("#" + cont + " .off-uni-slider-right").on("click" , function () {owl900.trigger("owl.next");});
				 }
				 var lArrowInner = $("#" + cont + " .off-uni-slider-left-arrow");
				 var rArrowInner = $("#" + cont + " .off-uni-slider-right-arrow");
				 $(document).on("keypress" , function (e) {
						 switch (e.key) {
								 case "Left":
										 owl900.trigger("owl.prev");
										 break;
								 case "Right":
										 owl900.trigger("owl.next");
										 break;
						 }
				 });
				 
				 
		 });
		 
		 $(window).load(function () {
				 /*$('#ddm_amazon').show();*/
				 // document.getElementById('ddm_amazon').style.visibility = "visible";
		 });
	</script>
	<!--<script type="text/javascript" src="https://mylivechat.com/chatinline.aspx?hccid=45259882"></script>-->
	
	<script type="text/javascript" async defer data-cfasync="false" src="https://mylivechat.com/chatinline.aspx?hccid=45259882"></script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-111658423-1"></script>
	<script>
		 window.dataLayer = window.dataLayer || [];
		 
		 function gtag() {dataLayer.push(arguments);}
		 
		 gtag('js' , new Date());
		 
		 gtag('config' , 'UA-111658423-1');
		 
		 
		 $(document).ready(function () {
				 var menu = $('.menus')
				 var timeout = 0;
				 var hovering = false;
				 menu.hide();
				 
				 $('#mainbutton')
					 .on("mouseenter" , function () {
							 hovering = true;
							 
							 setTimeout(function () {
									 if (hovering) {
											 $("#ajaxcart-overlay").show();
											 // Open the menu
											 $('.menus')
												 .stop(true , true)
												 .slideDown(400);
											 //    $('#tooltip-' + $this.data('id')).show();
									 }
							 } , 1000);
							 
							 if (timeout > 0) {
									 clearTimeout(timeout);
							 }
					 })
					 .on("mouseleave" , function () {
							 resetHover();
					 });
				 
				 $(".menus")
					 .on("mouseenter" , function () {
							 // reset flag
							 hovering = true;
							 // reset timeout
							 startTimeout();
					 })
					 .on("mouseleave" , function () {
							 // The timeout is needed incase you go back to the main menu
							 resetHover();
					 });
				 
				 function startTimeout() {
						 // This method gives you 1 second to get your mouse to the sub-menu
						 timeout = setTimeout(function () {
								 closeMenu();
						 } , 1000);
				 };
				 
				 function closeMenu() {
						 // Only close if not hovering
						 if (!hovering) {
								 $('.menus').stop(true , true).slideUp(400);
								 $("#ajaxcart-overlay").hide();
						 }
				 };
				 
				 function resetHover() {
						 // Allow the menu to close if the flag isn't set by another event
						 hovering = false;
						 // Set the timeout
						 startTimeout();
				 };
				 
				 $('#selectAll').click(function (event) {
						 if (this.checked) {
								 // Iterate each checkbox
								 $('.quoteProduct').each(function () {
										 this.checked = true;
								 });
								 $('.quote1Product').each(function () {
										 this.checked = true;
								 });
						 } else {
								 $('.quoteProduct').each(function () {
										 this.checked = false;
								 });
								 $('.quote1Product').each(function () {
										 this.checked = false;
								 });
						 }
				 });
				 
				 
		 });
	
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
	</style>
	<style type="text/css">
		.next {
			margin-top: 0px;
		}
		
		.item { margin: 0 !important; padding: 0 !important; }
		
		#demo1 {
			width: 144px;
			height: 35px;
			margin-top: -70px;
			position: absolute;
			margin-left: 350px;
			border-radius: 15px;
		}
		
		#demo2 {
			width: 144px;
			height: 34px;
			margin-top: -70px;
			position: absolute;
			margin-left: 537px;
			border-radius: 15px;
		}
		
		.dropdown-menu > li > a {
			z-index: 9999999999;
			color: #141212 !important;
		}
	</style>
</head>