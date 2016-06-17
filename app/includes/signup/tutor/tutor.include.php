<div class="new-signup">
	<div class="row">
		<div class="col s12 m6 l8">
			<div class="tutor-signup-title">
				<h1>We're Looking For <?php echo $app->titleAdd; ?> <?php if(isset($app->replace)){ echo $app->replace; }else{ echo ' Tutors ';} ?> </h1>
			</div>
			<div class="tutor-signup-sub"><h2>Just Like You</h2></div>
			<p class="signup-copy">
				<?php if(isset($app->replacetext)){ echo $app->replacetext; }else{ echo 'Teach with MindSpree and earn money as an independent contractor. Get paid bi-monthly for teaching something you love.';} ?>
			</p>

			<?php if(isset($promocode) && $promocode == 'iteach'): ?>


				<div class="blocks">

					<div class="row">
						<div class="col s12 m4 l4">
							&nbsp;
						</div>
						<div class="col s12 m8 l8">
							<h3>So What Benefits Do Teachers Get?</h3>
							<p>Anyone who signs up using our teacher promo page gets benefits that all teachers deserve!</p>
						</div>
					</div>

					<div class="row">
						<div class="col s12 m4 l4">
							<div class="center-align"><img src="/images/icons/money.png" class="responsive-img" /></div>
						</div>
						<div class="col s12 m8 l8">
							<div class="page-title">
								Free background check
							</div>
							<div class="copy">
								Let MindSpree cover your start up costs on MindSpree, so you can focus on what you do best- Teaching!
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col s12 m4 l4">
							<div class="center-align"><img src="/images/icons/books.png" class="responsive-img" /></div>
						</div>
						<div class="col s12 m8 l8">
							<div class="page-title">
								Make More
							</div>
							<div class="copy">
								Start off taking home 80% of your take home pay as soon as you start.
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col s12 m4 l4">
							<div class="center-align"><img src="/images/icons/calendar.png" class="responsive-img" /></div>
						</div>
						<div class="col s12 m8 l8">
							<div class="page-title">
								Earn in other ways
							</div>
							<div class="copy">
								Have teacher friends that may also want to tutor? Become an affiliate and make $20 for every other teacher that signs up and has a session.
							</div>
						</div>
					</div>
				</div>

			<?php else: ?>
				<div class="blocks">
					<div class="row">
						<div class="col s12 m4 l4">
							<div class="center-align"><img src="/images/icons/Money2.png" class="responsive-img" /></div>
						</div>
						<div class="col s12 m8 l8">
							<br/>
							<div class="page-title">
								Make Extra Money
							</div>
							<div class="copy">
								Are you an expert in a subject? Turn it into a revenue stream. School is in session and MindSpree makes it easy for you to cash in on the action.
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col s12 m4 l4">
							<div class="center-align"><img src="/images/icons/books.png" class="responsive-img" /></div>
						</div>
						<div class="col s12 m8 l8">
							<div class="page-title">
								Choose Subjects You Love
							</div>
							<div class="copy">
								Love chemistry but hate math? No problem! At MindSpree you choose what subjects you want to tutor in. You also choose how you want to tutor them. So if you have a better way to teach a concept to help a student, Go For It!
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col s12 m4 l4">
							<div class="center-align"><img src="/images/icons/calendar.png" class="responsive-img" /></div>
						</div>
						<div class="col s12 m8 l8">
							<div class="page-title">
								Tutor When You Want
							</div>
							<div class="copy">
								Looking to work on the weekends, or maybe even after work? As an independent contractor for MindSpree you have the freedom to set your own schedule and work when you want to.
							</div>
						</div>
					</div>

					<div class="row see-how-much">
						<div class="col s12 m4 l4">
							<div class="center-align"><img src="/images/icons/money3.png" class="responsive-img" /></div>
						</div>
						<div class="col s12 m8 l8">
							<br/>
							<div class="page-title">
								See How Much You Can Make
							</div>

							<div class="getprices">
								<?php
								    $variablename = new Forms($app->connect);
								    $variablename->formname = 'getprices';
								    $variablename->url = $app->request->getPath();
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
			<?php endif; ?>


		</div>
		<div class="col s12 m6 l4">
			<!-- <div class="complete-signup" data-status="closed">
				<span>Complete Signup Process <i class="fa fa-sign-in"></i> </span>
			</div>
			<div class="complete-signup-form">
				<div class="complete-signup-form-text">Already start the signup process? Log in and complete it now.</div>
				<form method="post" action="/signup/tutor" class="form-post" id="signuplogin">
					<div class="new-inputs">
						<div class="row">

							<div class="col s12 m6 l6">
								<div class="input-wrapper" id="li_email"><input type="email" name="li[email]" placeholder="Your Email Address" /></div>
							</div>

							<div class="col s12 m6 l6">
								<div class="input-wrapper" id="li_password"><input type="password" name="li[password]" placeholder="Your Password" /></div>
							</div>

						</div>

						<div class="new-inputs login-button">
							<div class="row">
								<div class="col s12 m12 l12">
									<button class="btn blue btn-block">
										Log In
									</button>
								</div>
							</div>
					  	</div>

					</div>

					<input type="hidden" name="li[target]" value="li"  />
					<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

				</form>
			</div> -->
			<div class="block tutor-block">

				<form class="form-post" action="/signup/tutor" method="post" id="tutorsignup">
					<div class="signup-title">
						Tutor Signup
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
								<div class="input-wrapper" id="ts_promocode"><input type="text" name="studentsignup[student][promocode]" placeholder="Promo Code (Optional)" value="<?php if(isset($app->promocode)){ echo $app->promocode; } ?>" /></div>
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
									<textarea class="materialize-textarea" name="tutorsignup[tutor][reasons]" placeholder="Why do you want to be a tutor? (Explain In Detail)"></textarea>
								</div>
							</div>

						</div>
					</div>

					<div class="new-inputs">
						<div class="row">
							<div class="col s12 m12 l12" id="ts_taughttutored">
								<select name="tutorsignup[tutor][howdidyouhear]" class="browser-default">
									<option value="">How Did You Hear About Us?</option>
									<?php
										foreach(array('Facebook','Twitter','Craigslist','Friend','Indeed','Google','Bing') as $value){
											echo '<option value="'.$value.'">'.$value.'</option>';
										}
									?>
								</select>
							</div>
						</div>
				  	</div>

					<div class="new-inputs">
						<div class="row">
							<div class="col s12 m12 l12" id="ts_taughttutored">
								<input type="checkbox" class="filled-in" name="tutorsignup[tutor][taughttutored]" id="taughttutored" />
								<label for="taughttutored">I have taught or tutored before</label>
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

					<?php
						/*

						<div class="new-inputs">
							<div class="row">
								<div class="col s12 m12 l12" id="ts_stats">
									<input type="checkbox" class="filled-in" name="tutorsignup[tutor][stats]" id="stats" />
									<label for="stats">I have all these items:

										<ul>
											<li>
												Photo of Myself
											</li>
											<li>
												3 References
											</li>
										</ul>

									</label>
								</div>
							</div>
					  	</div>

						*/
					?>

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
									By signing up I agree that MindSpree may contact me by email, phone, or SMS at the email address or number I provide. I have read, understand and agree to the <a href="/terms-of-use" target="_blank">Terms of Service</a>.
								</div>
							</div>
						</div>
				  	</div>
					<input type="hidden" name="tutorsignup[target]" value="tutorsignup"  />
					<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
				</form>

			</div>

			<h3>As a Tutor You Will...</h3>
			<ul class="collection">

				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1">
							<i class="material-icons  turquoise-text ">play_arrow</i>
						</div>
						<div class="col s11 m11 l11"> Choose your rate </div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1">
							<i class="material-icons  turquoise-text ">play_arrow</i>
						</div>
						<div class="col s11 m11 l11"> Choose your hours </div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1">
							<i class="material-icons  turquoise-text ">play_arrow</i>
						</div>
						<div class="col s11 m11 l11"> Choose your clients </div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1">
							<i class="material-icons  turquoise-text ">play_arrow</i>
						</div>
						<div class="col s11 m11 l11"> Work remotely or in person </div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1">
							<i class="material-icons  turquoise-text ">play_arrow</i>
						</div>
						<div class="col s11 m11 l11"> Access to teaching resources </div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1">
							<i class="material-icons  turquoise-text ">play_arrow</i>
						</div>
						<div class="col s11 m11 l11"> Network with other tutors </div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1">
							<i class="material-icons  turquoise-text ">play_arrow</i>
						</div>
						<div class="col s11 m11 l11"> <strong>Highest pay percentage in the industry!</strong> </div>
					</div>
				</li>

			</ul>

			<div class="application-process">
				<h3>The Application Process</h3>
				<ol class="collection">
					<li class="collection-item">
								Submit your application and resume
					</li>
					<li class="collection-item">
						 Schedule a phone interview with one of our staff members
					</li>
					<li class="collection-item">
						 Mandatory Background Check <span class="green-text">($29.99)</span>
					</li>
					<li class="collection-item">
 								Create a Profile
					</li>
					<li class="collection-item">
						 Start Tutoring
					</li>

				</ol>
			</div>

		</div>
	</div>

</div>
