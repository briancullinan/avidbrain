<div class="new-signup">
	<div class="row">
		<div class="col s12 m6 l8">
			<div class="tutor-signup-title">
				<h1>We're Looking For <?php echo $app->titleAdd; ?> <?php if(isset($app->replace)){ echo $app->replace; }else{ echo ' Tutors ';} ?> </h1>
			</div>
			<div class="tutor-signup-sub"><h2>Just Like You</h2></div>
			<p class="signup-copy">
				<?php if(isset($app->replacetext)){ echo $app->replacetext; }else{ echo 'Teach with AvidBrain and earn money as an independent contractor. Get paid bi-monthly for teaching something you love.';} ?>
			</p>

			<?php if(isset($promocode) && $promocode == 'AvidTeach'): ?>
				<h3>So What Benefits do Teachers Get?</h3>
				<p>Anyone who signs up using our teacher promo page gets benefits that all teachers deserve!</p>
				<div><strong>Free background check</strong></div>
				<p>Let AvidBrain cover your start up costs on AvidBrain, so you can focus on what you do best- Teaching!</p>
				<div><strong>Make More</strong></div>
				<p>Start off taking home 80% of your take home pay as soon as you start.</p>
				<div><strong>Earn in other ways</strong></div>
				<p>Have teacher friends that may also want to tutor? Become an affiliate and make $20 for every other teacher that signs up and has a session.</p>
			<?php endif; ?>

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

				<div class="row see-how-much">
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
			<div class="complete-signup" data-status="closed">
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
			</div>
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

							<?php if(isset($promocode)): ?>
							<div class="affiliatetracking" data-tracker="<?php echo $promocode; ?>"></div>
							<?php endif; ?>
							<?php
								$affiliatetracking = $app->getCookie('affiliatetracking');
								if(!empty($affiliatetracking)){
									$promocode = $affiliatetracking;
								}
							?>
							<?php if(isset($app->promoactivate->text)): ?>
								<div class="promo-activate">
									<div class="<?php echo $app->promoactivate->class; ?>">
										<?php echo $app->promoactivate->text; ?>
									</div>
								</div>
							<?php endif; ?>

							<div class="col s12 m12 l12">
								<?php if(isset($app->titleAdd) && !empty($app->titleAdd)){ echo '<div class="input-wrapper-text">Promo Code</div>';} ?>
								<div class="input-wrapper <?php if(isset($app->promoactivate->class)){ echo $app->promoactivate->class; } ?> <?php if(isset($app->titleAdd) && !empty($app->titleAdd)){ echo 'active-wrapper';} ?>" id="ts_promocode"><input <?php if(isset($app->titleAdd) && !empty($app->titleAdd)){ echo 'readonly="readonly"';} ?> type="text" name="tutorsignup[tutor][promocode]" placeholder="Promo Code (Optional)" value="<?php if(isset($promocode)){ echo $promocode; } ?>" /></div>
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
										foreach(array('Facebook','Twitter','Craigslist','Indeed','Google','Bing','Friend') as $value){
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
									By signing up I agree that AvidBrain may contact me by email, phone, or SMS at the email address or number I provide. I have read, understand and agree to the <a href="/terms-of-use" target="_blank">Terms of Service</a>.
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

			<div class="application-process">
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
	</div>

</div>
