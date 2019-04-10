

</div>
<!--Footer Start -->



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
