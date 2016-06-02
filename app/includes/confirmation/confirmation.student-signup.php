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


<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '632834226863566');
fbq('track', "PageView");
fbq('track', 'Lead');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=632834226863566&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

<script type=text/javascript src="https://services.xg4ken.com/js/kenshoo.js?cid=99f5fa84-146a-4242-ac9c-17ce8d09aadd" ></script>
<script type=text/javascript>
kenshoo.trackConversion('1154','99f5fa84-146a-4242-ac9c-17ce8d09aadd',{
   //OPTIONAL PARAMETERS. FILL VALUES OR REMOVE UNNEEDED PARAMETERS
   conversionType: 'conv', //specific conversion type. example: type:'AppInstall' default is 'conv'
   revenue: 0, //numeric conversion value. example convValue: 12.34
   currency:'USD', //example currency:'USD'
   orderId:'',//example orderId: 'abc'
   promoCode:'',
   customParam1:'', //any custom parameter. example: Airport: 'JFK'
   customParam2:'', //any custom parameter. example: Rooms: '3'
   customParamN:'' })
</script>

<noscript>
   <img src="https://1154.xg4ken.com/pixel/v1?track=1&token=99f5fa84-146a-4242-ac9c-17ce8d09aadd&conversionType=conv&revenue=0&currency=USD&orderId=&promoCode=&customParam1=&customParam2=" width="1" height="1" />
</noscript>
