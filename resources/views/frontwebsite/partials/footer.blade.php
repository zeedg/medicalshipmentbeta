<!--Footer Start -->

<div class="row footer">
	<div class="container">
		<div class="col-md-3 b-item1">
			<h3 class="b-head">ABOUT US</h3>
		</div>
		<div class="col-md-3 b-item1">
			<h3 class="b-head">MY ACCOUNT</h3>
		</div>
		<div class="col-md-3 b-item1">
			<h3 class="b-head">SHOP WITH US</h3>
		</div>
		<div class="col-md-3 b-item2">
			<h3 class="b-head">Subscribe</h3>
		</div>
	</div>
</div>
<div class="row">
	<div class="container">
		<div class="col-md-2 b-item1">
			<ul class="b-ul">
				<li><a href="{{ url('/')  }}">Home</a></li>
				<li><a href="{{ url('/')  }}index.php?controller=content&function=index&slug=about-us">About Us</a></li>
				<li><a href="{{ url('/')  }}index.php?controller=content&function=index&slug=shipping">Shipping</a></li>
				<li><a href="{{ url('/')  }}index.php?controller=kit_bag&function=index">Nursing Kit</a></li>
			</ul>
		</div>
		<div class="col-md-2 b-item1">
			<ul class="b-ul">
				<li><a href="{{ url('/')  }}index.php?controller=account&function=index"> My Account</a></li>
				<li><a href="{{ url('/')  }}index.php?controller=order&function=index">Order History</a></li>
				<li><a href="{{ url('/')  }}index.php?controller=testimonials&function=index">Testimonials</a></li>
				<li>&nbsp;</li>
			</ul>
		</div>
		<div class="col-md-2 b-item1">
			<ul class="b-ul">
				<li><a href="{{ url('/')  }}index.php?controller=content&function=index&slug=term-conditions">Terms & Conditions</a></li>
				<li><a href="{{ url('/')  }}index.php?controller=content&function=index&slug=privacy-policy">Privacy Notice</a></li>
				<li><a href="{{ url('/')  }}index.php?controller=contact&function=index">Contact Us</a></li>
			</ul>
		</div>
		<div class="col-md-3 b-item2">
			<div class="search-div-foot">
				<div class="ctct-embed-signup" style="font: 16px Helvetica Neue, Arial, sans-serif; font: 1rem Helvetica Neue, Arial, sans-serif; line-height: 1.5; -webkit-font-smoothing: antialiased;">
					<div style="color:#5b5b5b; background-color:#e8e8e8; border-radius:5px;"> <span id="success_message" style="display:none;color:#50B738">
            <div style="text-align:center;">Thanks for signing up!</div>
            </span>
						<form data-id="embedded_signup:form" class="ctct-custom-form Form" name="embedded_signup" method="POST" action="https://visitor2.constantcontact.com/api/signup">
							<input data-id="ca:input" type="hidden" name="ca" value="d8c9496b-029a-4041-88b5-4508d680ed72">
							<input data-id="list:input" type="hidden" name="list" value="1947438952">
							<input data-id="source:input" type="hidden" name="source" value="EFD">
							<input data-id="required:input" type="hidden" name="required" value="list,email">
							<input data-id="url:input" type="hidden" name="url" value="">
							<p data-id="Email Address:p"><!--<label data-id="Email Address:label" data-name="email" class="ctct-form-required">Email Address</label> -->
								<input data-id="Email Address:input" type="email" required name="email" class="b-fieldf" placeholder="Your Email" value="" maxlength="80">
							</p>
							<button type="submit" class="b-btnf" data-enabled="enabled"></button>
						</form>
					</div>
				</div>
			</div>
			<div class="clearz"></div>
			<br/>
			<h2 style="margin:0; padding:0">Find us at</h2>
			<div class="col-lg-12 socialmediaicons"><a href="https://www.facebook.com/MedicalShipment/" target="_blank"><img src="{{ url('/placeholder.jpg') }}" class="social1"></a> <a href="https://twitter.com/medicalshipment" target="_blank"><img src="{{ url('/') }}/" class="social1"></a> <a href="https://www.pinterest.com/medicalshipment/" target="_blank"><img src="{{ url('/placeholder.jpg') }}" class="social1"></a>
				<a href="https://www.linkedin.com/company/medical-shipment" target="_blank"><img src="{{ url('/placeholder.jpg') }}" class="social1"></a> <a href="https://plus.google.com/113914819075313734046/about" target="_blank"><img src="{{ url('/placeholder.jpg') }}" class="social1"></a></div>
		</div>
		<div class="col-lg-12 copyright"><span>Copyright © 2019 - www.medicalshipment- All Rights Reserved For questions or comments please contact <a href="mailto:info@medicalshipment.com">info@medicalshipment.com</a></span></div>
	</div>
</div>

<!--Footer End -->

<!-- Constant Contact -->
<script type='text/javascript'>
    var localizedErrMap = {};
    localizedErrMap['required'] = 'This field is required.';
    localizedErrMap['ca'] = 'An unexpected error occurred while attempting to send email.';
    localizedErrMap['email'] = 'Please enter your email address in name@email.com format.';
    localizedErrMap['birthday'] = 'Please enter birthday in MM/DD format.';
    localizedErrMap['anniversary'] = 'Please enter anniversary in MM/DD/YYYY format.';
    localizedErrMap['custom_date'] = 'Please enter this date in MM/DD/YYYY format.';
    localizedErrMap['list'] = 'Please select at least one email list.';
    localizedErrMap['generic'] = 'This field is invalid.';
    localizedErrMap['shared'] = 'Sorry, we could not complete your sign-up. Please contact us to resolve this.';
    localizedErrMap['state_mismatch'] = 'Mismatched State/Province and Country.';
    localizedErrMap['state_province'] = 'Select a state/province';
    localizedErrMap['selectcountry'] = 'Select a country';
    var postURL = 'https://visitor2.constantcontact.com/api/signup';
</script>
<script type="text/javascript">
		$(document).ready(function(){
				$('.dropdown-submenu a.test').on("click", function(e){
						$(this).next('ul').toggle();
						e.stopPropagation();
						e.preventDefault();
				});
		});
</script>
<!--Bootstrap Core JavaScript -->
<script src="{{ url('/frontend') }}/js/bootstrap.min.js"></script> 
<script type='text/javascript' src='https://static.ctctcdn.com/h/contacts-embedded-signup-assets/1.0.2/js/signup-form.js'></script>

</body>
</html>