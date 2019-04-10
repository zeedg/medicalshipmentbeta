<!DOCTYPE html>
<html lang="en">
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
												 $('body').html(data);
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

<body onLoad="getCartItemsTop();" ng-app="medicalngapp">
<div id="ajaxcart-overlay" onClick="close_popup();"></div>

<header>
	<div class="row">
		<div class="container top-con" style="background: transparent;">
			<div class="col-lg-3 med-logo"><a href="{{ url('/') }}/"><img src="{{ url('/') }}/logo.png" class="img-responsive" alt="Logo" id="logo"/></a></div>
			<div class="col-lg-9 med-menu">
				<nav class="navbar navbar-inverse pull-right" role="navigation">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2"><span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button>
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
						<ul class="nav navbar-nav m-top">
							<li><a href="{{ url('/') }}/">Home</a></li>
							<li><a href="{{ url('/') }}">Account</a></li>
							<li><a href="{{ url('/') }}">General Inquiry</a></li>
							<li><a href="{{ url('/') }}">Quick Order</a></li>
							<li><a href="{{ url('/') }}">News</a></li>
							<li><a href="{{ url('/') }}">Request Catalog</a></li>
							<li><a href="{{ url('/') }}">Shopping Cart</a></li>
							<li class="last"><a href="{{ url('/') }}">Help</a></li>
						</ul>
					</div>
					<!-- /.navbar-collapse -->
				</nav>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="container top">
			<div class="col-lg-1 nav-popup head">
				<div class="dropdown">
		{{--			<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Tutorials
						<span class="caret"></span></button>--}}
				
				</div>
				{{--here alert --}}
				<p class="arrow-head1" id="mainbutton"></strong>
				</p>
				<div class="dropdown">
					<button class="btn btn-default dropdown-toggle btn-default-bl" type="button" data-toggle="dropdown">
						Shop by <br/><strong>Category</strong>
						<span class="caret"></span></button>
					<ul class="dropdown-menu dropdown-menu-bl">
			 
			 <?php
			 if(isset($categories) && count($categories)){
			 foreach($categories as $k1 => $v1){
			 if($v1->category_parent == 0 ){
			 $subarr = [];
			 foreach($categories as $k2 => $v2){
				 if($k1 == $k2) continue;
				 if($v1->category_id == $v2->category_parent) $subarr[] = $v2;
			 }
			 ?>
						<li class="<?= (count($subarr) > 0) ? 'dropdown-submenu' : ''; ?>">
							<a tabindex="-1" class="<?= (count($subarr) > 0) ? 'test' : ''; ?>" href="{{ (count($subarr) > 0 ) ? '#' : url('/category/' . $v1->category_id)  }}"><?= $v1->category_title ?> <?= (count($subarr) > 0) ? '<span class="cart"></span>' : ''; ?></a>
				<?php if(count($subarr) > 0 ){  ?>
							<ul class="dropdown-menu">
				 <?php foreach($subarr as $sk => $sv){ ?> <li><a class="drp_sub_menu drp_sub_menu-bl" tabindex="-1" href="{{ url('/category/' .$sv->category_id) }}"><?= $sv->category_title ?></a></li> <?php } ?>
							</ul>
				<?php } ?>
						</li>
			 <?php }
			 }
			 }  ?>
					
					</ul>
				</div>
			
			</div>
			<div class="col-md-8 search-div">
				<select id="category" name="id" class="search_form b-field" style="height:38px; border-radius: 5px 0 0 5px; width: 8%; padding: 0 5px; border-left: 1px solid #bababa; display: none;">
					<option value="-1">All</option>
					<option value="1">Carts</option>
					<option value="5">&nbsp;&nbsp;»&nbsp;Computer Carts</option>
					<option value="6">&nbsp;&nbsp;»&nbsp;Crash Carts</option>
					<option value="4">&nbsp;&nbsp;»&nbsp;Emergency Carts</option>
					<option value="3">&nbsp;&nbsp;»&nbsp;Isolation Carts</option>
					<option value="2">&nbsp;&nbsp;»&nbsp;Medication Carts</option>
					<option value="7">&nbsp;&nbsp;»&nbsp;Utility Carts</option>
					<option value="8">Defibrillators & ECG'S</option>
					<option value="9">&nbsp;&nbsp;»&nbsp;Defibrillators</option>
					<option value="11">&nbsp;&nbsp;»&nbsp;ECG Accessories</option>
					<option value="10">&nbsp;&nbsp;»&nbsp;ECG'S</option>
					<option value="12">Diagnostics</option>
					<option value="14">&nbsp;&nbsp;»&nbsp;Aneroid</option>
					<option value="15">&nbsp;&nbsp;»&nbsp;Blood Pressure</option>
					<option value="17">&nbsp;&nbsp;»&nbsp;Dopplers</option>
					<option value="20">&nbsp;&nbsp;»&nbsp;Integrated Diagnostic System</option>
					<option value="19">&nbsp;&nbsp;»&nbsp;Otoscopes &amp; Opthalmoscopes</option>
					<option value="13">&nbsp;&nbsp;»&nbsp;Scales</option>
					<option value="16">&nbsp;&nbsp;»&nbsp;Stethoscopes</option>
					<option value="21">&nbsp;&nbsp;»&nbsp;Testing Supplies</option>
					<option value="18">&nbsp;&nbsp;»&nbsp;Thermometers</option>
					<option value="22">Gloves</option>
					<option value="23">&nbsp;&nbsp;»&nbsp;Latex</option>
					<option value="24">&nbsp;&nbsp;»&nbsp;Nitrile</option>
					<option value="25">&nbsp;&nbsp;»&nbsp;Sterile</option>
					<option value="28">&nbsp;&nbsp;»&nbsp;Surgical</option>
					<option value="26">&nbsp;&nbsp;»&nbsp;Vinyl</option>
					<option value="27">&nbsp;&nbsp;»&nbsp;Vytrile</option>
					<option value="29">Hospital Beds</option>
					<option value="34">&nbsp;&nbsp;»&nbsp;Accessories</option>
					<option value="31">&nbsp;&nbsp;»&nbsp;Birthing Beds</option>
					<option value="32">&nbsp;&nbsp;»&nbsp;ICU</option>
					<option value="30">&nbsp;&nbsp;»&nbsp;Med-Surg Beds</option>
					<option value="33">&nbsp;&nbsp;»&nbsp;Stretchers</option>
					<option value="35">Infusion Pumps / IV Supplies</option>
					<option value="40">&nbsp;&nbsp;»&nbsp;IV Catheters</option>
					<option value="36">&nbsp;&nbsp;»&nbsp;IV Pumps</option>
					<option value="38">&nbsp;&nbsp;»&nbsp;IV Sets</option>
					<option value="37">&nbsp;&nbsp;»&nbsp;IV Solutions</option>
					<option value="41">&nbsp;&nbsp;»&nbsp;IV Supplies</option>
					<option value="39">&nbsp;&nbsp;»&nbsp;Syringe Pumps</option>
					<option value="42">Labels</option>
					<option value="49">&nbsp;&nbsp;»&nbsp;Addmissions</option>
					<option value="46">&nbsp;&nbsp;»&nbsp;Allergy</option>
					<option value="45">&nbsp;&nbsp;»&nbsp;Central Sterile</option>
					<option value="44">&nbsp;&nbsp;»&nbsp;General Office</option>
					<option value="48">&nbsp;&nbsp;»&nbsp;Infection Control</option>
					<option value="43">&nbsp;&nbsp;»&nbsp;Nursing</option>
					<option value="47">&nbsp;&nbsp;»&nbsp;Pharmacy</option>
					<option value="50">Manikins/Simulators</option>
					<option value="52">&nbsp;&nbsp;»&nbsp;Basic Life Support</option>
					<option value="56">&nbsp;&nbsp;»&nbsp;Emergency Life Support</option>
					<option value="54">&nbsp;&nbsp;»&nbsp;Examination</option>
					<option value="51">&nbsp;&nbsp;»&nbsp;Nursing Skills Training</option>
					<option value="53">&nbsp;&nbsp;»&nbsp;Patient Care Manikins</option>
					<option value="57">&nbsp;&nbsp;»&nbsp;Pediatrics</option>
					<option value="55">&nbsp;&nbsp;»&nbsp;Simulators</option>
					<option value="58">Media</option>
					<option value="62">&nbsp;&nbsp;»&nbsp;Alcohol</option>
					<option value="61">&nbsp;&nbsp;»&nbsp;Drugs</option>
					<option value="64">&nbsp;&nbsp;»&nbsp;Health</option>
					<option value="63">&nbsp;&nbsp;»&nbsp;Nutrition</option>
					<option value="66">&nbsp;&nbsp;»&nbsp;Pregnancy/Childcare</option>
					<option value="65">&nbsp;&nbsp;»&nbsp;Sex Education</option>
					<option value="60">&nbsp;&nbsp;»&nbsp;Tobacco</option>
					<option value="59">&nbsp;&nbsp;»&nbsp;Women/Men's Health</option>
					<option value="128">Medical Equiment</option>
					<option value="129">&nbsp;&nbsp;»&nbsp;Anesthesia Machines</option>
					<option value="138">&nbsp;&nbsp;»&nbsp;C-Arm/Fluoroscopy</option>
					<option value="132">&nbsp;&nbsp;»&nbsp;Electrosurgical Units</option>
					<option value="136">&nbsp;&nbsp;»&nbsp;Exam Tables</option>
					<option value="130">&nbsp;&nbsp;»&nbsp;Patient Monitoring</option>
					<option value="135">&nbsp;&nbsp;»&nbsp;Procedure Tables</option>
					<option value="133">&nbsp;&nbsp;»&nbsp;Respiratory Ventilators</option>
					<option value="131">&nbsp;&nbsp;»&nbsp;Surgical Lights</option>
					<option value="137">&nbsp;&nbsp;»&nbsp;Surgical Microscopes</option>
					<option value="134">&nbsp;&nbsp;»&nbsp;Surgical Tables</option>
					<option value="67">Medical Shipment Brand Products</option>
					<option value="126">&nbsp;&nbsp;»&nbsp;Box/Bag</option>
					<option value="125">&nbsp;&nbsp;»&nbsp;Case</option>
					<option value="127">&nbsp;&nbsp;»&nbsp;Each</option>
					<option value="68">Monitors</option>
					<option value="69">&nbsp;&nbsp;»&nbsp;Complete Vital Signs Monitors</option>
					<option value="70">&nbsp;&nbsp;»&nbsp;Welch Allyn Spot Vital Signs Monitor</option>
					<option value="71">&nbsp;&nbsp;»&nbsp;Welch Allyn Vital Signs Monitor</option>
					<option value="72">New Products!</option>
					<option value="73">Patient Care</option>
					<option value="80">&nbsp;&nbsp;»&nbsp;Apparel</option>
					<option value="77">&nbsp;&nbsp;»&nbsp;Central Line Dressing</option>
					<option value="79">&nbsp;&nbsp;»&nbsp;Exam Room</option>
					<option value="74">&nbsp;&nbsp;»&nbsp;Foley Catheter</option>
					<option value="81">&nbsp;&nbsp;»&nbsp;IV Start Kit</option>
					<option value="76">&nbsp;&nbsp;»&nbsp;Patient Aids</option>
					<option value="75">&nbsp;&nbsp;»&nbsp;Sanitizers</option>
					<option value="78">&nbsp;&nbsp;»&nbsp;Wound Care</option>
					<option value="82">Patient Room</option>
					<option value="84">&nbsp;&nbsp;»&nbsp;Exam Room</option>
					<option value="85">&nbsp;&nbsp;»&nbsp;Feeding Pumps</option>
					<option value="83">&nbsp;&nbsp;»&nbsp;Linens</option>
					<option value="86">&nbsp;&nbsp;»&nbsp;Patient Lift</option>
					<option value="87">&nbsp;&nbsp;»&nbsp;Personal Protection Kit</option>
					<option value="88">&nbsp;&nbsp;»&nbsp;Response Sequential Compression Device (SCD)</option>
					<option value="89">Practice Meds</option>
					<option value="98">&nbsp;&nbsp;»&nbsp;Ampules</option>
					<option value="99">&nbsp;&nbsp;»&nbsp;Antibiotic Suspensions</option>
					<option value="104">&nbsp;&nbsp;»&nbsp;Flavors</option>
					<option value="91">&nbsp;&nbsp;»&nbsp;Glo Products</option>
					<option value="92">&nbsp;&nbsp;»&nbsp;Insulins</option>
					<option value="93">&nbsp;&nbsp;»&nbsp;Liquids</option>
					<option value="97">&nbsp;&nbsp;»&nbsp;Long Term Care</option>
					<option value="101">&nbsp;&nbsp;»&nbsp;Ophthalmic/ Otic/ Nasal</option>
					<option value="100">&nbsp;&nbsp;»&nbsp;Powder for Reconstitution</option>
					<option value="102">&nbsp;&nbsp;»&nbsp;Pre-Filled Syringes</option>
					<option value="90">&nbsp;&nbsp;»&nbsp;Pyxis Practice Meds Starter Kit</option>
					<option value="96">&nbsp;&nbsp;»&nbsp;Tablet/Capsule Packs</option>
					<option value="103">&nbsp;&nbsp;»&nbsp;Topical & Misc.</option>
					<option value="94">&nbsp;&nbsp;»&nbsp;Vaccines</option>
					<option value="105">&nbsp;&nbsp;»&nbsp;Variety Paks</option>
					<option value="95">&nbsp;&nbsp;»&nbsp;Vials</option>
					<option value="150">Pyxis</option>
					<option value="152">&nbsp;&nbsp;»&nbsp;4000</option>
					<option value="151">&nbsp;&nbsp;»&nbsp;ES</option>
					<option value="154">&nbsp;&nbsp;»&nbsp;Software</option>
					<option value="153">&nbsp;&nbsp;»&nbsp;Warranties</option>
					<option value="107">Respiratory</option>
					<option value="113">&nbsp;&nbsp;»&nbsp;Anesthesia</option>
					<option value="110">&nbsp;&nbsp;»&nbsp;Masks</option>
					<option value="108">&nbsp;&nbsp;»&nbsp;Pulse Oximeter</option>
					<option value="112">&nbsp;&nbsp;»&nbsp;Spirometer</option>
					<option value="111">&nbsp;&nbsp;»&nbsp;Suction Catheter</option>
					<option value="109">&nbsp;&nbsp;»&nbsp;Tracheostomy</option>
					<option value="114">Student Kits</option>
					<option value="115">&nbsp;&nbsp;»&nbsp;Student Kits</option>
					<option value="116">Syringes/Needles</option>
					<option value="118">&nbsp;&nbsp;»&nbsp;Insulin Syringe</option>
					<option value="117">&nbsp;&nbsp;»&nbsp;Safety Syringes/Needles</option>
					<option value="119">&nbsp;&nbsp;»&nbsp;Syringes &amp; Needles</option>
					<option value="120">&nbsp;&nbsp;»&nbsp;Tuberculin Syringes</option>
					<option value="121">Training Headwalls</option>
					<option value="124">&nbsp;&nbsp;»&nbsp;Accessories</option>
					<option value="122">&nbsp;&nbsp;»&nbsp;Functional</option>
					<option value="123">&nbsp;&nbsp;»&nbsp;Non-Functional</option>
				</select>
				<input id="dd_user_input" type="text" onKeyUp="suggest_users()" class="search_form b-field keypress" onBlur="if(this.value=='')this.value=this.defaultValue;" onFocus="if(this.value==this.defaultValue)this.value='';" value="Search Products Here" data-toggle="modal" data-target="#myModal"/>
				<input type="hidden" name="keyword" id="keyword" value="">
				<!--<input type="text" class="b-field" value="" name="keyword" id="keyword1" placeholder="Search....">-->
				<input type="button" value="" class="b-btn" onClick="urlEncode()">
			</div>
			<div class="col-rg-3">
				<?php if(session()->get('user_email')){ ?>
                	<div class="arrow-head2 left p-right nav-popup">
                        <a href="index.php?controller=account&function=index">
          <p>Hello, <?php echo session()->get('user_fname'); ?><br>
              <strong>Your Account</strong></p>
          </a>
                        <div id="menu1choices" class="menudropdown">
            <div class="nav-arrow-inner"></div>
            <a href="{{ url('account/index') }}" style="color: #428bca;">Your Account</a>
            <hr>
            <a href="{{ url('order/index') }}" style="color: #428bca;">Your Orders</a>
            <hr>
            <a href="{{ url('favorites/manage_wishlist') }}" style="color: #428bca;">Your Wish List</a>
            <hr>
            <a href="{{ url('frontlogout') }}" style="color: #428bca;">Logout</a>
                      </div>
          </div>
                <?php } else { ?>
                <div class="arrow-head2 left p-right nav-popup">
					<a href="index.php?controller=login&function=index">
						<p>Hello, Sign in <strong>Your Account</strong></p>
					</a>
					<div id="menu1choices" class="menudropdown">
						<div class="nav-arrow-inner"></div>
						<div id="nav-flyout-ya-signin" style="text-align: center;"><a href="{{ url('login_user') }}" rel="nofollow" class="nav-action-button" data-nav-role="signin" data-nav-ref="nav_signin">
								<p class="btn_login"></p>
							</a>
							<div id="nav-flyout-ya-newCust" class="nav_pop_new_cust" style="font-size: 12px;">New customer?<a href="{{ url('register/index') }}" class="start_here">Start here</a></div>
						</div>
					</div>
				</div>
                <?php } ?>
				<div class="arrow-head4 left p-right nav-popup quote">
					<p><a href="{{ url('quote/index') }}"><strong>Add to Quote</strong></a></p>
					<div id="menu1choices" class="menudropdown">
						<div class="nav-arrow-inner" id="quote_arraow"></div>
						<a href="{{ url('quote/index') }}">
							<p class="btn_quote"></p>
						</a></div>
				</div>
				<div class="arrow-head3 left p-right nav-popup">
					<p><strong> Wish List</strong></p>
					<div id="menu1choices" class="menudropdown">
						<div class="nav-arrow-inner" id="wishlist_arraow"></div>
						<a href="{{ url('favorites/manage_wishlist') }}">
							<p class="btn_wishlist"></p>
						</a>
						<a href="{{ url('favorites/add_wishlist') }}" style="color: #428bca;">
							Create a Wish List
						</a>
					
					</div>
				</div>
				<div class="nav-popup cart-txt cart-img"><a href="{{ url('addto_cart') }}">
						<span id="shopping_cart_menu">0</span>
						<p class="shopping_tabho" onMouseOver="getCartItemAjax();"></p></a>
					<div id="cart_menu" class="menudropdown" style="margin-left: -10%; width: 255px;"></div>
				</div>
			</div>
		</div>
	</div>
</header>
