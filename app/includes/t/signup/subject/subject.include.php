<div class="new-signup">

	<div class="row">
		<div class="col s12 m6 l6">

			<div class="blockmin-main">
				<div class="blockmin-main-title1">Looking For A Tutor?</div>
				<div class="blockmin-main-title2">You've Come To The Right Place</div>
				<div class="blockmin-main-title3">Welcome to AvidBrain, the easiest way to find a tutor.</div>
			</div>

            <div class="signup-info hide-on-small-only">

				<?php if(isset($app->topresults)): ?>
					<h2>Top <?php echo $app->subjectName; ?> Tutors</h2>
					<?php foreach($app->topresults as $topresults): ?>
						<div class="block blockmin">
							<div class="row">
								<div class="col s12 m5 l5">
									<div class="blockmin-link">
										<a href="<?php echo $topresults->url; ?>">

											<?php echo short($topresults); ?>

										</a>
									</div>

									<div> <i class="mdi-action-room green-text"></i> <?php echo $topresults->city; ?>, <?php echo ucwords($topresults->state_long); ?></div>

									<div class="my-rate">$<?php echo $topresults->hourly_rate; ?>/ Hour</div>
								</div>
								<div class="col s12 m7 l7">
									<div class="blockmin-text"><?php echo nl2br(truncate($topresults->personal_statement_verified,400)); ?></div>
								</div>
							</div>


						</div>
					<?php endforeach; ?>
				<?php endif; ?>

			</div>



		</div>
		<div class="col s12 m6 l6">
			<div class="block tutor-block">

				<form class="form-post" action="/t/signup/algebra-1-tutors" method="post" id="studentsignup">
					<div class="signup-title">
						Signup Now &amp; Get A $30 Promo Code
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

			<h3 class="tsignup-h3">Student Benefits</h3>

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


			<?php if(isset($app->top)): ?>
				<div>Top Tutored Subjects</div>
				<div class="block">
					<ul class="top-listed-subjects">
						<?php foreach($app->top as $top): ?>
							<li <?php $topname = '/t/signup/'.$top->subject_slug.'-tutors'; if($topname==$app->request->getPath()){ echo ' class="active"';} ?>>
								<a href="/t/signup/<?php echo $top->subject_slug; ?>-tutors">
									<span class="top-count"><?php echo $top->count; ?></span> <?php echo $top->subject_name; ?> Tutors
								</a>

							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

		</div>

	</div>

	<?php
		//https://www.iconfinder.com/iconsets/anchor
	?>

</div>


<?php if(isset($app->purechat)): ?>
	<script type='text/javascript' data-cfasync='false'>window.purechatApi = { l: [], t: [], on: function () { this.l.push(arguments); } }; (function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({c: 'a450183c-ea47-4537-89d4-f8b55a44e006', f: true }); done = true; } }; })();</script>
<?php endif; ?>
