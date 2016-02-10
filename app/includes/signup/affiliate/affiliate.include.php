<div class="new-signup">
	<div class="row">
		<div class="col s12 m6 l8">

			<div><img class="responsive-img" src="/images/affiliate.jpg" /></div>
			<div class="affiliate-text">
				<p>Whatever walk of life you are in there are several ways anyone can advertise for AvidBrain and make a some extra cash.</p>
				<p>Become an AvidBrain affiliate and earn $20 for every student or tutor who signs up and completes a session.</p>
				<p>Earn Part-time Income By Doing What you Love.</p>
			</div>

			<div class="row affbens">

				<div class="col s12 m12 l4 center-align">
					<div class="block">

						<div class="affbens-title">
							Signup
						</div>

						<div class="afbens-icon">
							<div class="affbens-stack">
								<span class="fa-stack fa-lg">
									<i class="fa fa-circle fa-stack-2x green-text"></i>
									<i class="fa fa-pencil fa-stack-1x white-text"></i>
								</span>
							</div>
							<div class="affbens-drop">
								<i class="fa fa-sort-down"></i>
							</div>
						</div>

						<div class="affbens-text">
							Signup now and get a unique promo code that you can share, post, blog or do whatever you can think of with.
						</div>

					</div>
				</div>

				<div class="col s12 m12 l4 center-align">
					<div class="block">

						<div class="affbens-title">
							Download
						</div>

						<div class="afbens-icon">
							<div class="affbens-stack">
								<span class="fa-stack fa-lg">
									<i class="fa fa-circle fa-stack-2x green-text"></i>
									<i class="fa fa-download fa-stack-1x white-text"></i>
								</span>
							</div>
							<div class="affbens-drop">
								<i class="fa fa-sort-down"></i>
							</div>
						</div>

						<div class="affbens-text">
							Download our Flyers and Start sharing on your social media network or share your promo code with friends and colleagues.
						</div>

					</div>
				</div>

				<div class="col s12 m12 l4 center-align">
					<div class="block">

						<div class="affbens-title">
							Make Money
						</div>

						<div class="afbens-icon">
							<div class="affbens-stack">
								<span class="fa-stack fa-lg">
									<i class="fa fa-circle fa-stack-2x green-text"></i>
									<i class="fa fa-dollar fa-stack-1x white-text"></i>
								</span>
							</div>
							<div class="affbens-drop">
								<i class="fa fa-sort-down"></i>
							</div>
						</div>

						<div class="affbens-text">
							Start making passive income with our easy to use dashboard &amp; keep track of your earnings.
						</div>

					</div>
				</div>

			</div>


		</div>
		<div class="col s12 m6 l4">

			<div class="block affiliate-block">

				<form method="post" class="form-post" action="<?php echo $app->request->getPath(); ?>" id="affsignup">
					<div class="signup-title">
						Affiliate Signup
					</div>

					<div class="new-inputs">
						<div class="input-wrapper" id="aff_email"><input type="text" name="affsignup[email]" autofocus="autofocus" placeholder="Email" /></div>
					</div>

					<div class="new-inputs">
						<div class="input-wrapper" id="aff_password"><input type="password" name="affsignup[password]" placeholder="Password" /></div>
					</div>

					<input type="hidden" name="tutorsignup[target]" value="tutorsignup"  />
					<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

					<div class="new-inputs submit-affiliate">
						<button class="btn btn-l btn-block">
							Signup
						</button>
				  	</div>
				</form>

			</div>

			<!---->
			<h3 class="white-text">Affiliate Benefits</h3>
			<ul class="collection collection-fix">
				<li class="collection-item">
					Make great money working part-time
				</li>
				<li class="collection-item">
					Work from the convenient of your home
				</li>
				<li class="collection-item">
					Every tutor or student that you get to signup on our site and that have a session, you earn $20!
				</li>
				<li class="collection-item">
					Easy to promote, every student that signups with your PROMO CODE get $30 off their first session
				</li>
				<li class="collection-item">
					Every tutors that signups up with your PROMO CODE starts at 70% take-home rate. Highest in the Industry
				</li>
				<li class="collection-item">
					It is free for students and tutors to signup
				</li>

		    </ul>
			<!---->

		</div>

	</div>

</div>



<style type="text/css">
.collection-fix{
	float: left;
	width: 100%;
}
.affbens-title{

}
.affbens-title{
	font-family: 'Quicksand';
	font-weight: 400;
	font-size: 30px;
	margin-bottom: 10px;
}
.affbens-stack{
	font-size: 30px;
	position: relative;
	z-index: 11;
}
.affbens-drop{
	font-size: 75px;
	margin-top: -77px;
	color: #efefef;
	position: relative;
	z-index: 10;
	margin-bottom: -10px;
}
.affbens-text{
	font-size: 13px;
}
.new-signup .affbens .block{
	min-height: 270px;
}
#affsignup{
	padding: 0px;
}
.block.affiliate-block{

	min-height: inherit;
}
.affiliate-text{
	color: #fff;
    font-size: 20px;
    text-shadow: 2px 2px 5px #000;
}
.submit-affiliate{
	margin: 0px;
}
.mainaffiliate main{
	background-image: url('/images/subs/affiliate.jpg');

	background-size: cover;
    /*background-repeat: repeat-x;
    background-position: top left;
    background-attachment: scroll;*/
}
.mainaffiliate h1{
	color: #fff;
	font-size: 50px;
    padding: 0;
    text-shadow: 2px 2px 5px #000;
}
</style>
