<div class="row">
	<div class="col s12 m6 l6">
		<p>Welcome to <?php echo SITENAME_PROPPER; ?>, the largest tutoring marketplace of interviewed and background checked tutors! We have created a new account to help you communicate with potential tutors and schedule tutoring lessons.</p>
		<p>Please be sure to check your email to authenticate your account.</p>
		<p>If you have not received an email, you can have it resent. </p>
		<p>You may also want to check your spam folder.</p>
	</div>
	<div class="col s12 m6 l6">
		<h2>Resend Email</h2>
		<?php
			$resetpass = new Forms($app->connect);
			$resetpass->formname = 'resetpassword';
			$resetpass->url = '/confirmation/student-signup';
			$resetpass->csrf_key = $csrf_key;
			$resetpass->csrf_token = $csrf_token;
			$resetpass->makeform();
		?>
	</div>
</div>


<!-- Google Code for Student Sign Up Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 945094692;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "ZwOUCO_lrmMQpIDUwgM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/945094692/?label=ZwOUCO_lrmMQpIDUwgM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
