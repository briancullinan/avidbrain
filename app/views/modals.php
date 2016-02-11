<?php if(empty($app->user->email)): ?>
<div id="loginModule" class="modal">
	<div class="modal-content">
		<h4><?php echo SITENAME_PROPPER; ?> Login</h4>
	</div>

		<div class="row">
			<div class="col s12 m8 l8">
				<?php
					$thelogin = new Forms($app->connect);
					$thelogin->formname = 'login';
					$thelogin->url = '/login';
					$thelogin->csrf_key = $csrf_key;
					$thelogin->csrf_token = $csrf_token;
					$thelogin->button = 'Login';
					$thelogin->makeform();
				?>
			</div>
			<div class="col s12 m4 l4">
				<a href="/help/forgot-password" class="btn red btn-block">Forgot Password?</a>
				<a href="/signup" class="btn btn-block blue">Signup</a>
				<?php if(isset($app->enableaffiliates)): ?>
					<a href="/login/affiliates" class="btn orange btn-block">Affiliate Login</a>
				<?php endif; ?>
			</div>
		</div>

	<div class="modal-footer">
		<a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat "> <i class="fa fa-times"></i> Dismiss </a>
	</div>
</div>
<?php endif; ?>

<?php
	if(isset($loadModal) && $loadModal=='what-is-a-whiteboard'){
		include($app->target->base.'what-is-a-whiteboard.php');
	}
?>

<div id="bgcheck_modal" class="modal">
	<div class="modal-content">
		<h4> <i class="mdi-action-assignment-ind"></i> Background Checks</h4>

		<p>At <?php echo SITENAME_PROPPER; ?>, we require all of our tutors to be background checked to ensure the safety of our students. By requiring all tutors to go through a thorough background check, we create a place that is both safe and an effective environment for our students.</p>

	</div>

	<div class="modal-footer">
		<a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">OK, Thanks</a>
	</div>
</div>

<div id="myrank" class="modal">
	<div class="modal-content">

		<h4><?php echo SITENAME_PROPPER; ?> Ranking</h4>

		<div class="row">
			<div class="col s12 m4 l4">
				<p>At <?php echo SITENAME_PROPPER; ?>, we rank all of our tutors with ranks and ranks and ranks and ranks.</p>
				<p><a href="/signup/tutor">Get Ranked</a></p>
			</div>
			<div class="col s12 m8 l8">
				<ul class="collection">
					<li class="collection-item badge-new-user">
						<div class="row">
							<div class="col s12 m6 l6">

								<div class="row">
									<div class="col s2 m2 l2">
										<i class="fa fa-check"></i>
									</div>
									<div class="col s10 m10 l10">
										New User
									</div>
								</div>

							</div>
							<div class="col s12 m6 l6">
								0 - 50 Hours
							</div>
						</div>
					</li>
					<li class="collection-item badge-instructor">
						<div class="row">
							<div class="col s12 m6 l6">

								<div class="row">
									<div class="col s2 m2 l2">
										<i class="fa fa-certificate"></i>
									</div>
									<div class="col s10 m10 l10">
										Instructor
									</div>
								</div>

							</div>
							<div class="col s12 m6 l6">
								51 - 200 Hours
							</div>
						</div>
					</li>
					<li class="collection-item badge-teachers-assistant">
						<div class="row">
							<div class="col s12 m6 l6">
								<div class="row">
									<div class="col s2 m2 l2">
										<i class="fa fa-bolt"></i>
									</div>
									<div class="col s10 m10 l10">
										Teacher's Assistant
									</div>
								</div>
							</div>
							<div class="col s12 m6 l6">
								201 - 1,000 Hours
							</div>
						</div>
					</li>
					<li class="collection-item badge-teacher">
						<div class="row">
							<div class="col s12 m6 l6">

								<div class="row">
									<div class="col s2 m2 l2">
										<i class="fa fa-rocket"></i>
									</div>
									<div class="col s10 m10 l10">
										Teacher
									</div>
								</div>

							</div>
							<div class="col s12 m6 l6">
								1,001 - 2,000 Hours
							</div>
						</div>
					</li>
					<li class="collection-item badge-assistant-professor">
						<div class="row">
							<div class="col s12 m6 l6">

								<div class="row">
									<div class="col s2 m2 l2">
										<i class="fa fa-trophy"></i>
									</div>
									<div class="col s10 m10 l10">
										Assistant Professor
									</div>
								</div>

							</div>
							<div class="col s12 m6 l6">
								2,001 - 4,000 Hours
							</div>
						</div>
					</li>
					<li class="collection-item badge-associate-professor">
						<div class="row">
							<div class="col s12 m6 l6">

								<div class="row">
									<div class="col s2 m2 l2">
										<i class="fa fa-star"></i>
									</div>
									<div class="col s10 m10 l10">
										Associate Professor
									</div>
								</div>

							</div>
							<div class="col s12 m6 l6">
								4,001 - 6,000 Hours
							</div>
						</div>
					</li>
					<li class="collection-item badge-professor">
						<div class="row">
							<div class="col s12 m6 l6">

								<div class="row">
									<div class="col s2 m2 l2">
										<i class="fa fa-university"></i>
									</div>
									<div class="col s10 m10 l10">
										Professor
									</div>
								</div>

							</div>
							<div class="col s12 m6 l6">
								6,001 - 12,000 Hours
							</div>
						</div>
					</li>
					<li class="collection-item badge-mad-scientist">
						<div class="row">
							<div class="col s12 m6 l6">

								<div class="row">
									<div class="col s2 m2 l2">
										<i class="fa fa-flask"></i>
									</div>
									<div class="col s10 m10 l10">
										Mad Scientist
									</div>
								</div>

							</div>
							<div class="col s12 m6 l6">
								12,001+ Hours
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>

	</div>

	<div class="modal-footer">
		<a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">OK, Thanks</a>
	</div>
</div>

<?php if(isset($app->user->usertype) && $app->user->usertype=='admin' && isset($app->modal) && $app->modal == 'studentmodal'): ?>
	<div id="adminModule" class="modal">

		<div class="modal-content">
			<h4>Admin Module</h4>
			<br>

			<?php if(isset($app->currentuser->email)): ?>
			<div>
				Email Address: <?php echo $app->currentuser->email; ?>
			</div><br>
			<?php endif; ?>

			<?php if(isset($app->currentuser->phone)): ?>
			<div>
				Phone Number: <?php echo $app->currentuser->phone; ?>
			</div><br>
			<?php endif; ?>

		</div>

		<div class="modal-footer">
			<a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Close</a>
		</div>
	</div>
<?php endif ?>


<?php if(isset($app->user->usertype) && $app->user->usertype=='admin' && isset($app->modal) && $app->modal == 'tutormodal'): ?>
	<div id="adminModule" class="modal">

		<div class="modal-content">
			<h4>Admin Module</h4>
			<br>

			<?php

				$sql = "SELECT * FROM avid___compedbgcheck WHERE email = :email";
				$prepare = array(':email'=>$app->currentuser->email);
				$comped = $app->connect->executeQuery($sql,$prepare)->fetch();


				if(isset($app->currentuser->emptybgcheck) && empty($comped)):
			?>
			<form method="post" action="<?php echo $app->request->getPath(); ?>">

				<button class="btn confirm-submit" type="button">Comp Background Check</button>

				<input type="text" name="adminmodulecomper[email]" value="<?php echo $app->currentuser->email; ?>" />

				<input type="text" name="adminmodulecomper[date]" value="<?php echo thedate(); ?>" />



				<input type="hidden" name="adminmodulecomper[target]" value="adminmodulecomper"  />
				<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
			</form>
			<?php endif; ?>

			<?php if(isset($app->currentuser->email)): ?>
			<div>
				<?php echo $app->currentuser->email; ?>
			</div><br>
			<?php endif; ?>

			<?php if(isset($app->currentuser->phone)): ?>
			<div>
				<?php echo $app->currentuser->phone; ?>
			</div><br>
			<?php endif; ?>

			<form method="post" action="<?php echo $app->request->getPath(); ?>">

				<div class="input-field">
					<label class="select-label" for="anotheragency">
						Is this a tutor from another agency?
					</label>
					<select id="anotheragency" class="browser-default" name="adminmodule[anotheragency]">

						<option <?php if($app->currentuser->anotheragency==1){ echo 'selected="selected"';} ?> value="1">Yes</option>
						<option <?php if(empty($app->currentuser->anotheragency)){ echo 'selected="selected"';} ?> value="">No</option>

					</select>
				</div>

				<div class="input-field">
					<label class="select-label" for="anotheragency">
						What should their rate be set to?
					</label>
					<select id="anotheragencyrate" class="browser-default" name="adminmodule[anotheragencyrate]">
						<?php foreach(array(70,75,80,85) as   $value): ?>
						<option <?php if(isset($app->currentuser->anotheragency_rate) && $app->currentuser->anotheragency_rate== $value){ echo 'selected="selected"';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="input-field">
					<input id="textid" name="adminmodule[assigntome]" type="checkbox" <?php if(isset($app->needsprofilereview->approvingnow)){ echo 'checked="checked"';} ?> class="validate">
					<label for="textid">
						Assign To Me
					</label>
				</div>

				<br>

				<div class="input-field">
					<textarea name="adminmodule[notes]" id="notes" class="materialize-textarea"><?php if(isset($app->needsprofilereview->notes)){ echo $app->needsprofilereview->notes;} ?></textarea>
					<label for="notes">Notes</label>
				</div>

			<br>

				<input type="hidden" name="adminmodule[target]" value="adminmodule"  />
				<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

				<div class="form-submit">
					<button class="btn blue" type="submit">
						Submit
					</button>
				</div>

			</form>

		</div>

		<div class="modal-footer">
			<a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Close</a>
		</div>
	</div>
<?php endif ?>
