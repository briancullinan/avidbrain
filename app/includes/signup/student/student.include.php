<div class="new-signup">

	<div class="row">
		<div class="col s12 m6 l8">
			<div class="tutor-signup-title"><h1>Looking For A Tutor?</h1></div>
			<div class="tutor-signup-sub"><h2>You've Come To The Right Place</h2></div>
			<p class="signup-copy">
				Welcome to AvidBrain, the easiest way to find a qualified tutor, who is interviewed and background checked. <br><br>
				Sign up and create your account in minutes.
			</p>

			<div class="blocks">

				<div class="row">
					<div class="col s12 m4 l4">
						<div class="center-align"><img src="/images/icons/money.png" class="responsive-img" /></div>
					</div>
					<div class="col s12 m8 l8">
						<div class="page-title">
							Free Job Posts
						</div>
						<div class="copy">
							Post a job and tutors will come to you, no searching needed.
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col s12 m4 l4">
						<div class="center-align"><img src="/images/icons/money.png" class="responsive-img" /></div>
					</div>
					<div class="col s12 m8 l8">
						<div class="page-title">
							Find The Price That Fits You
						</div>
						<div class="copy">
							With over 2,000 tutors available, you can pick and choose the best tutor to fit your price range.
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col s12 m4 l4">
						<div class="center-align"><img src="/images/icons/money.png" class="responsive-img" /></div>
					</div>
					<div class="col s12 m8 l8">
						<div class="page-title">
							Safe & Secure
						</div>
						<div class="copy">
							something about being safe and secure...
						</div>
					</div>
				</div>


			</div>


		</div>
		<div class="col s12 m6 l4">
			<div class="block tutor-block">

				<form class="form-post" action="/signup/student" method="post" id="studentsignup">
					<div class="signup-title">
						Student Signup
					</div>

					<div class="new-inputs">
						<div class="row">

							<div class="col s12 m6 l6">
								<div class="input-wrapper" id="ts_first_name"><input type="text" name="studentsignup[student][first_name]" autofocus="autofocus" placeholder="First Name" /></div>
							</div>

							<div class="col s12 m6 l6">
								<div class="input-wrapper" id="ts_last_name"><input type="text" name="studentsignup[student][last_name]" placeholder="Last Name" /></div>
							</div>

						</div>
					</div>

					<div class="new-inputs">
						<div class="row">

							<div class="col s12 m12 l12">
								<div class="input-wrapper" id="ts_email"><input type="email" name="studentsignup[student][email]" placeholder="Email Address" /></div>
							</div>

						</div>
					</div>

					<div class="new-inputs">
						<div class="row">

							<div class="col s12 m12 l12">
								<div class="input-wrapper" id="ts_phone"><input type="tel" name="studentsignup[student][phone]" placeholder="Phone Number" /></div>
							</div>

						</div>
					</div>

					<?php if(isset($app->isvalidpromo)): ?>
						<div class="promocode-activated">
							<div class="promocode-activated-message">
								Promo Code Applied: <span>$<?php echo $app->isvalidpromo->value; ?>.00</span>
							</div>
						</div>
					<?php endif; ?>

					<div class="new-inputs">
						<div class="row">

							<div class="col s12 m12 l12">
								<div class="input-wrapper" id="ts_promocode"><input type="text" name="studentsignup[student][promocode]" placeholder="Promo Code (Optional)" value="<?php if(isset($promocode)){ echo $promocode; } ?>" /></div>
							</div>

						</div>
					</div>

					<div class="new-inputs">
						<div class="row">

							<div class="col s12 m12 l12">
								<div class="input-wrapper" id="ts_password"><input type="password" name="studentsignup[student][password]" placeholder="Password (At least 6 characters)" /></div>
							</div>

						</div>
					</div>

					<div class="new-inputs">
						<div class="row">

							<div class="col s12 m12 l12">
								<div class="input-wrapper" id="ts_zipcode"><input type="text" name="studentsignup[student][zipcode]" placeholder="Your Zip Code" /></div>
							</div>

						</div>
					</div>

					<div class="new-inputs">
						<div class="row">
							<div class="col s12 m12 l12">
								<button class="btn btn-l btn-block">
									Submit
								</button>
							</div>
						</div>
				  	</div>

					<div class="new-inputs">
						<div class="row">
							<div class="col s12 m12 l12">
								<div class="the-disclaimer">
									By signing up I agree that AvidBrain may contact me by email, phone, or SMS at the email address or number I provide. I have read, understand and agree to the <a href="/terms-of-use" target="_blank">Terms of Service</a>.
								</div>
							</div>
						</div>
				  	</div>

					<input type="hidden" name="studentsignup[target]" value="studentsignup"  />
					<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
				</form>

			</div>

			<h3>Student Benefits</h3>

			<ul class="collection">
				<li class="collection-item">
					<div class="row">
						<div class="col s2 m2 l2">
							<i class="fa fa-search light-green-text accent-2-text"></i>
						</div>
						<div class="col s10 m10 l10">
							Choose a tutor that works for you
						</div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s2 m2 l2">
							<i class="fa fa-calendar-o  light-green-text accent-2-text"></i>
						</div>
						<div class="col s10 m10 l10">
							Choose your schedule
						</div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s2 m2 l2">
							<i class="fa fa-wifi light-green-text accent-2-text"></i>
						</div>
						<div class="col s10 m10 l10">
							Be tutored online or in person
						</div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s2 m2 l2">
							<i class="fa fa-exchange  light-green-text accent-2-text"></i>
						</div>
						<div class="col s10 m10 l10">
							Network with other students
						</div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s2 m2 l2">
							<i class="fa fa-check light-green-text accent-2-text"></i>
						</div>
						<div class="col s10 m10 l10">
							No long term contracts
						</div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s2 m2 l2">
							<i class="fa fa-globe light-green-text accent-2-text"></i>
						</div>
						<div class="col s10 m10 l10">
							Tutors are available nationwide
						</div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s2 m2 l2">
							<i class="fa fa-dollar light-green-text accent-2-text"></i>
						</div>
						<div class="col s10 m10 l10">
							No sign up cost
						</div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s2 m2 l2">
							<i class="fa fa-user light-green-text accent-2-text"></i>
						</div>
						<div class="col s10 m10 l10">
							Tutors are interviewed and background checked
						</div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s2 m2 l2">
							<i class="fa fa-thumbs-up  light-green-text accent-2-text"></i>
						</div>
						<div class="col s10 m10 l10">
							First hour guaranteed*
						</div>
					</div>
				</li>
			</ul>

			<small>*If you are not completely satisfied with your initial session, we will refund you the cost of the first hour.</small>



		</div>
	</div>

	<?php
		//https://www.iconfinder.com/iconsets/anchor
	?>

</div>


<style type="text/css">
.promocode-activated{
	width: 100%;
	float: left;
	margin-bottom: 20px;
	padding: 0px 13px;
}
.promocode-activated-message{
	background: #333;
	padding: 10px;
	color:#bdff00;
	text-align: center;
	font-size: 16px;
}
.promocode-activated-message span{
	color:#fff;
}
</style>
