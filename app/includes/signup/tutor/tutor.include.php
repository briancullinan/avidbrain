<div class="row">
	<div class="col s12 m6 l8">
		<div class="tutor-signup-title"><h1>We're Looking For Tutors</h1></div>
		<div class="tutor-signup-sub"><h2>Just Like You</h2></div>
		<p class="signup-copy">
			Teach with AvidBrain and earn money as an independent contractor. Get paid bi-weekly for teaching something you love.
		</p>

		<div class="blocks">
			<div class="row">
				<div class="col s12 m4 l4">
					<div class="center-align"><img src="/images/icons/money.png" class="responsive-img" /></div>
				</div>
				<div class="col s12 m8 l8">
					<div class="page-title">
						Make Extra Money
					</div>
					<div class="copy">
						Are you an expert in a subject? Turn it into a revenue stream. School is in session and AvidBrain makes it easy for you to cash in on the action.
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12 m4 l4">
					<div class="center-align"><img src="/images/icons/choose.png" class="responsive-img" /></div>
				</div>
				<div class="col s12 m8 l8">
					<div class="page-title">
						Choose Subjects You Love
					</div>
					<div class="copy">
						Love chemistry but hate math? No problem! At AvidBrain you choose what subjects you want to tutor in. You also choose how you want to tutor them. So if you have a better way to teach a concept to help a student, Go For It!
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12 m4 l4">
					<div class="center-align"><img src="/images/icons/time.png" class="responsive-img" /></div>
				</div>
				<div class="col s12 m8 l8">
					<div class="page-title">
						Tutor When You Want
					</div>
					<div class="copy">
						Looking to work on the weekends, or maybe even after work? As an independent contractor for AvidBrain you have the freedom to set your own schedule and work when you want to.
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col s12 m4 l4">
					<div class="center-align"><img src="/images/icons/see.png" class="responsive-img" /></div>
				</div>
				<div class="col s12 m8 l8">
					<div class="page-title">
						See How Much You Can Make
					</div>

					<div class="getprices">
						<?php
						    $variablename = new Forms($app->connect);
						    $variablename->formname = 'getprices';
						    $variablename->url = $app->request->getPath();
						    $variablename->dependents = $app->dependents;
						    $variablename->csrf_key = $csrf_key;
						    $variablename->csrf_token = $csrf_token;
						    $variablename->button = 'Get Prices';
						    $variablename->classname = 'getprices';
						    $variablename->makeform();
						?>
					</div>
					<div class="show-prices">&nbsp;</div>

				</div>
			</div>
		</div>


	</div>
	<div class="col s12 m6 l4">
		<div class="block tutor-block">

			<form class="form-post" action="/signup/tutor" method="post" id="tutorsignup">
				<div class="signup-title">
					Sign Up Now
				</div>

				<div class="new-inputs">
					<div class="row">

						<div class="col s12 m6 l6">
							<div class="input-wrapper" id="ts_first_name"><input type="text" name="tutorsignup[tutor][first_name]" autofocus="autofocus" placeholder="First Name" /></div>
						</div>

						<div class="col s12 m6 l6">
							<div class="input-wrapper" id="ts_last_name"><input type="text" name="tutorsignup[tutor][last_name]" placeholder="Last Name" /></div>
						</div>

					</div>
				</div>

				<div class="new-inputs">
					<div class="row">

						<div class="col s12 m12 l12">
							<div class="input-wrapper" id="ts_email"><input type="email" name="tutorsignup[tutor][email]" placeholder="Email Address" /></div>
						</div>

					</div>
				</div>

				<div class="new-inputs">
					<div class="row">

						<div class="col s12 m12 l12">
							<div class="input-wrapper" id="ts_phone"><input type="tel" name="tutorsignup[tutor][phone]" placeholder="Phone Number" /></div>
						</div>

					</div>
				</div>

				<div class="new-inputs">
					<div class="row">

						<div class="col s12 m12 l12">
							<div class="input-wrapper" id="ts_promocode"><input type="text" name="tutorsignup[tutor][promocode]" placeholder="Promo Code (Optional)" value="<?php if(isset($promocode)){ echo $promocode; } ?>" /></div>
						</div>

					</div>
				</div>

				<div class="new-inputs">
					<div class="row">

						<div class="col s12 m12 l12">
							<div class="input-wrapper" id="ts_password"><input type="password" name="tutorsignup[tutor][password]" placeholder="Password (At least 6 characters)" /></div>
						</div>

					</div>
				</div>

				<div class="new-inputs">
					<div class="row">

						<div class="col s12 m12 l12">
							<div class="input-wrapper" id="ts_reasons">
								<textarea class="materialize-textarea" name="tutorsignup[tutor][reasons]" placeholder="Why do you want to be a tutor?"></textarea>
							</div>
						</div>

					</div>
				</div>

				<div class="new-inputs">
					<div class="row">

						<div class="col s12 m12 l12">
							<div class="input-wrapper" id="ts_linkedinprofile"><input type="text" name="tutorsignup[tutor][linkedinprofile]" placeholder="Linked In Profile (Optional)" /></div>
						</div>

					</div>
				</div>

				<div class="new-inputs">
					<div class="row">
						<div class="col s12 m12 l12" id="ts_taughttutored">
							<input type="checkbox" class="filled-in" name="tutorsignup[tutor][taughttutored]" id="taughttutored" />
							<label for="taughttutored">I have tought or tutored before</label>
						</div>
					</div>
			  	</div>

				<div class="new-inputs">
					<div class="row">
						<div class="col s12 m12 l12" id="ts_agerestrictions">
							<input type="checkbox" class="filled-in" name="tutorsignup[tutor][agerestrictions]" id="agerestrictions" />
							<label for="agerestrictions">I am a 18 Years or Older</label>
						</div>
					</div>
			  	</div>

				<div class="new-inputs">
					<div class="row">
						<div class="col s12 m12 l12" id="ts_legalresident">
							<input type="checkbox" class="filled-in" name="tutorsignup[tutor][legalresident]" id="legalresident" />
							<label for="legalresident">I am a permanent resident/ citizen of the U.S.</label>
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
								I agree that AvidBrain may contact me by email, phone, or SMS at the email address or number I provide. I have read and understand the relevant <a href="/terms-of-use" target="_blank">Terms of Service</a>.
							</div>
						</div>
					</div>
			  	</div>
				<input type="hidden" name="tutorsignup[target]" value="tutorsignup"  />
				<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
			</form>

		</div>

		<h3>Tutor Benefits</h3>
		<ul class="collection">

			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1"><i class="fa fa-check light-green-text accent-2-text"></i></div>
					<div class="col s11 m11 l11"> Choose your rate </div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1"><i class="fa fa-check light-green-text accent-2-text"></i></div>
					<div class="col s11 m11 l11"> Choose your hours </div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1"><i class="fa fa-check light-green-text accent-2-text"></i></div>
					<div class="col s11 m11 l11"> Choose your clients </div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1"><i class="fa fa-check light-green-text accent-2-text"></i></div>
					<div class="col s11 m11 l11"> Work remotely or in person </div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1"><i class="fa fa-check light-green-text accent-2-text"></i></div>
					<div class="col s11 m11 l11"> Access to teaching resources </div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1"><i class="fa fa-check light-green-text accent-2-text"></i></div>
					<div class="col s11 m11 l11"> Network with other tutors </div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1"><i class="fa fa-check light-green-text accent-2-text"></i></div>
					<div class="col s11 m11 l11"> <strong>Highest pay percentage in the industry!</strong> </div>
				</div>
			</li>

		</ul>

		<h3>Application Process</h3>
		<ul class="collection">

			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1"><i class="fa fa-check light-green-text accent-2-text"></i></div>
					<div class="col s11 m11 l11"> Submit your application and resume </div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1"><i class="fa fa-check light-green-text accent-2-text"></i></div>
					<div class="col s11 m11 l11"> Schedule a phone interview with one of our staff members </div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1"><i class="fa fa-check light-green-text accent-2-text"></i></div>
					<div class="col s11 m11 l11"> Mandatory Background Check <span class="green-text">($29.99)</span> </div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1"><i class="fa fa-check light-green-text accent-2-text"></i></div>
					<div class="col s11 m11 l11"> Profile Creation </div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1"><i class="fa fa-check light-green-text accent-2-text"></i></div>
					<div class="col s11 m11 l11"> Start Tutoring </div>
				</div>
			</li>

		</ul>

	</div>
</div>

<?php
	//https://www.iconfinder.com/iconsets/anchor
?>
