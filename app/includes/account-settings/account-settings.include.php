<div class="basic-block">

	<form method="post" class="switch-post" action="/account-settings" id="account-settings">

		<div class="row">
			<div class="col s6 m8 l8">
				<div class="switch-text">Do you want to receive emails when a tutor/student contacts you?</div>
			</div>
			<div class="col s6 m4 l4 right-align">
				<div class="switch">
					<label>
						No
						<input <?php if(isset($app->user->settings->getemails) && $app->user->settings->getemails=='yes'){ echo 'checked="checked"';} ?> name="accountsettings[getemails]" type="checkbox">
						<span class="lever"></span>
						Yes
					</label>
				</div>
			</div>
		</div>

		<?php if(isset($app->textmessages)): ?>
		<div class="row">
			<div class="col s6 m8 l8">
				<div class="switch-text">Do you want to receive text messages?</div>
			</div>
			<div class="col s6 m4 l4 right-align">
				<div class="switch">
					<label>
						No
						<input <?php if($app->user->settings->textmessages=='yes'){ echo 'checked="checked"';} ?> name="accountsettings[textmessages]" type="checkbox">
						<span class="lever"></span>
						Yes
					</label>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<?php if(isset($app->user->settings->showfullname)): ?>
		<div class="row">
			<div class="col s6 m8 l8">
				<div class="switch-text">Do you want to show your full name?</div>
			</div>
			<div class="col s6 m4 l4 right-align">
				<div class="switch">
					<label>
						No
						<input <?php if($app->user->settings->showfullname=='yes'){ echo 'checked="checked"';} ?> name="accountsettings[showfullname]" type="checkbox">
						<span class="lever"></span>
						Yes
					</label>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<?php if($app->user->usertype=='student'): ?>
		<div class="row">
			<div class="col s6 m8 l8">
				<div class="switch-text">Do you want your profile to show up on the Students page?</div>
			</div>
			<div class="col s6 m4 l4 right-align">
				<div class="switch">
					<label>
						No
						<input <?php if($app->user->settings->showmyprofile=='yes'){ echo 'checked="checked"';} ?> name="accountsettings[showmyprofile]" type="checkbox">
						<span class="lever"></span>
						Yes
					</label>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<?php if($app->user->usertype=='tutor' && isset($app->user->settings->newjobs)): ?>
		<div class="row">
			<div class="col s6 m8 l8">
				<div class="switch-text">Do you want to get an email when a student posts a new job in your field?</div>
			</div>
			<div class="col s6 m4 l4 right-align">
				<div class="switch">
					<label>
						No
						<input <?php if($app->user->settings->newjobs=='yes'){ echo 'checked="checked"';} ?> name="accountsettings[newjobs]" type="checkbox">
						<span class="lever"></span>
						Yes
					</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col s6 m8 l8">
				<div class="switch-text">Is your rate negotiable? If so, it will show on your profile as negotiable. </div>
			</div>
			<div class="col s6 m4 l4 right-align">
				<div class="switch">
					<label>
						No
						<input <?php if($app->user->settings->negotiableprice=='yes'){ echo 'checked="checked"';} ?> name="accountsettings[negotiableprice]" type="checkbox">
						<span class="lever"></span>
						Yes
					</label>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<?php if(isset($app->user->settings->avidbrainnews)): ?>
		<div class="row">
			<div class="col s6 m8 l8">
				<div class="switch-text">Do you want to receive emails when we post news?</div>
			</div>
			<div class="col s6 m4 l4 right-align">
				<div class="switch">
					<label>
						No
						<input <?php if($app->user->settings->avidbrainnews=='yes'){ echo 'checked="checked"';} ?> name="accountsettings[avidbrainnews]" type="checkbox">
						<span class="lever"></span>
						Yes
					</label>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<?php if(isset($app->enableaffiliates) && isset($app->user->settings->affiliateprogram)): ?>
			<div class="row">
				<div class="col s6 m8 l8">
					<div class="switch-text">Sign me up for the <a href="/affiliates">MindSpree Affiliate Program</a></div>
				</div>
				<div class="col s6 m4 l4 right-align">
					<div class="switch">
						<label>
							No
							<input <?php if($app->user->settings->affiliateprogram=='yes'){ echo 'checked="checked"';} ?> name="accountsettings[affiliateprogram]" type="checkbox">
							<span class="lever"></span>
							Yes
						</label>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if(isset($app->user->settings->loggedinprofile)): ?>
		<div class="row">
			<div class="col s6 m8 l8">
				<div class="switch-text">
					<strong>Account Visibilty:</strong> Only show profile to logged in users.
					<?php if($app->user->settings->loggedinprofile=='yes'): ?>
						<span class="red-text">You won't show up in search results, unless the user is logged in.</span>
					<?php endif; ?>
				</div>
			</div>
			<div class="col s6 m4 l4 right-align">
				<div class="switch">
					<label>
						No
						<input <?php if($app->user->settings->loggedinprofile=='yes'){ echo 'checked="checked"';} ?> name="accountsettings[loggedinprofile]" type="checkbox">
						<span class="lever"></span>
						Yes
					</label>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<input type="hidden" name="accountsettings[target]" value="accountsettings"  />
		<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

	</form>

</div>

<div class="row">
	<div class="col s12 m6 l6">
		<h2>Change Password</h2>

		<?php
			$thelogin = new Forms($app->connect);
			$thelogin->formname = 'changepassword';
			$thelogin->url = $app->request->getPath();
			//$thelogin->dependents = $app->dependents;
			$thelogin->csrf_key = $csrf_key;
			$thelogin->csrf_token = $csrf_token;
			$thelogin->makeform();
		?>

		<h2>Add Your Phone Number</h2>

		<div class="box">
			<form method="post" class="form-post" action="<?php echo $app->request->getPath(); ?>">

				<div class="row">

					<label>Numbers Only</label>
					<input type="tel" class="swapnumber" name="phone[number]" value="<?php echo $app->user->phone; ?>" maxlength="10" />

				</div>

				<input type="hidden" name="phone[target]" value="phone"  />
				<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

				<div class="form-submit">
					<button class="btn blue" type="submit">
						Save
					</button>
				</div>

			</form>
		</div>

		<h3>Change Username</h3>
		<div class="block">
			<div>If you would like to change your username, just type in a new one below and see if it's available.</div>
			<p>Your current username is: <span class="green white-text"><?php echo $app->user->username; ?></span></p>
			<br>
			<form class="form-post" method="post" action="<?php echo $app->request->getPath(); ?>" id="checkusername">

				<div class="row">
					<div class="col s12 m12 l12">
						<div class="input-field">
							<input id="newusername" type="text" name="newusername[username]" class="validate">
							<label for="newusername">
								New Username
							</label>
						</div>
					</div>
					<div class="col s6 m6 l6">
						<div class="name-status"></div>
					</div>
					<div class="col s6 m6 l6">
						<div class="submit-me"></div>
					</div>
				</div>

				<input type="hidden" name="newusername[target]" value="newusername"  />
				<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

			</form>

		</div>


	</div>
	<div class="col s12 m6 l6">
		<h2>Change Your Email Address</h2>
		<div class="box">
			<div>Your Email Address: <?php echo $app->user->email; ?></div>
			<form method="post" class="form-post" id="changeaddress" action="<?php echo $app->request->getPath(); ?>">

				<div class="input-field">
					<input id="newemailaddress" type="email" name="changeaddress[email]" class="validate">
					<label for="newemailaddress">
						New Email Address
					</label>
				</div>

				<div class="input-field">
					<input id="confirmnewemailaddress" name="changeaddress[confirm_email]" type="email" class="validate">
					<label for="confirmnewemailaddress">
						Confirm New Email Address
					</label>
				</div>

				<input type="hidden" name="changeaddress[target]" value="changeaddress"  />
				<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

				<div class="form-submit">
					<button class="btn orange " type="submit">
						Change Email Address
					</button>
				</div>

			</form>


			<div class="alert orange white-text">
				You will be logged out once your email address has been changed.
			</div>
		</div>


		<h2>Delete Account</h2>
		<div class="box">

			<p>If you would like do delete your account, just click the button below.</p>
			<p>Once your account has been deleted, it will no longer be available.</p>

			<form method="post" class="form-post" id="deleteaccount" action="<?php echo $app->request->getPath(); ?>">

				<input type="hidden" name="deleteaccount[target]" value="deleteaccount"  />
				<input type="hidden" id="csrf" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

				<div class="form-submit">
					<button class="btn red confirm-submit" type="button">
						Delete Account
					</button>
				</div>

			</form>
		</div>
	</div>
</div>

<div id="accountsettings" class="thesettings"></div>
