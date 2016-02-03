<div class="new-signup">
	<div class="row">
		<div class="col s12 m6 l8">

			<div class="row">
				<div class="col s12 m12 l7">
					<div class="affiliate-text">
						<p>Whatever walk of life you are in there are several ways anyone can advertise for AvidBrain and make a some extra cash.</p>

						<p>Become an AvidBrain affiliate and earn $20 for every student or tutor who signs up and completes a session.</p>
					</div>

				</div>
				<div class="col s12 m12 l5">
					<ul class="collection">
				        	<li class="collection-item">
				        		<div class="row">
				        			<div class="col s1 m1 l1">
				        				<i class="fa fa-check green-text"></i>
				        			</div>
				        			<div class="col s11 m11 l11">
				        				Earn easy money
				        			</div>
				        		</div>
				        	</li>
							<li class="collection-item">
				        		<div class="row">
				        			<div class="col s1 m1 l1">
				        				<i class="fa fa-check green-text"></i>
				        			</div>
				        			<div class="col s11 m11 l11">
				        				Track signups
				        			</div>
				        		</div>
				        	</li>
							<li class="collection-item">
				        		<div class="row">
				        			<div class="col s1 m1 l1">
				        				<i class="fa fa-check green-text"></i>
				        			</div>
				        			<div class="col s11 m11 l11">
				        				Work when and where you want
				        			</div>
				        		</div>
				        	</li>
							<li class="collection-item">
				        		<div class="row">
				        			<div class="col s1 m1 l1">
				        				<i class="fa fa-check green-text"></i>
				        			</div>
				        			<div class="col s11 m11 l11">
				        				Be your own boss
				        			</div>
				        		</div>
				        	</li>
							<li class="collection-item">
				        		<div class="row">
				        			<div class="col s1 m1 l1">
				        				<i class="fa fa-check green-text"></i>
				        			</div>
				        			<div class="col s11 m11 l11">
				        				Sit back &amp; relax
				        			</div>
				        		</div>
				        	</li>
				        </ul>
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



		</div>
	</div>

</div>


<style type="text/css">
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
