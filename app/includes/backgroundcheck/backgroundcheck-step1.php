<div class="bgcheck-step">Step 1</div>
<div class="bgcheck-step-info">Applicant Info</div>


<p>AvidBrain Inc. (the “Company”) has engaged Checkr, Inc. to obtain a consumer report and/or investigative consumer report for employment purposes. Checkr Inc. will provide a background investigation as a pre-condition of your engagement with the Company and in compliance with federal and state employment laws.</p>

<p>If you have any questions related to the screening process, please contact us at <a class="green-text" href="mailto:support@checkr.com">support@checkr.com</a>.</p>


<form method="post" action="/signup/tutor/" class="form-post" id="backgroundcheck-step1">

    <h3>Applicant Info</h3>
	<div class="red white-text alert" role="alert"><i class="fa fa-warning"></i> Please submit your <strong>full legal name.</strong></div>

	<div class="row">
		<div class="input-field col s12 m4 l4">
			<input placeholder="Please enter your first name" name="backgroundcheckstep1[first_name]" value="<?php if(isset($app->newtutor->first_name)){ echo $app->newtutor->first_name; } ?>" id="first_name" type="text" class="validate">
			<label for="first_name">First Name <i class="fa fa-asterisk red-text"></i></label>
		</div>
		<div class="input-field col s12 m4 l4">
			<input placeholder="" name="backgroundcheckstep1[middle_name]" value="<?php if(isset($app->newtutor->middle_name)){ echo $app->newtutor->middle_name; } ?>" id="middle_name" type="text" class="validate">
			<label for="middle_name">Middle Name</label>
		</div>
		<div class="input-field col s12 m4 l4">
			<input placeholder="Please enter last name" name="backgroundcheckstep1[last_name]" value="<?php if(isset($app->newtutor->last_name)){ echo $app->newtutor->last_name; } ?>" id="last_name" type="text" class="validate">
			<label for="last_name">Last Name <i class="fa fa-asterisk red-text"></i></label>
		</div>
	</div>

    <div class="row">
        <div class="input-field col s12 m12 l12">
            <input placeholder="Please enter social security number" maxlength="11" name="backgroundcheckstep1[ssn]" value="<?php if(isset($app->newtutor->ssn)){ echo $app->crypter->decrypt($app->newtutor->ssn); } ?>" id="ssn" type="text" class="validate">
            <label for="ssn">Social Security Number <i class="fa fa-asterisk red-text"></i></label>
        </div>
    </div>

	<div class="row">
		<div class="input-field col s12 m8 l8">
			<div class="labelclass">Birthday <i class="fa fa-asterisk red-text"></i></div>
			<?php
				$dob = NULL;
				if(isset($app->newtutor->dob)){
					$dob = explode('-',$app->crypter->decrypt($app->newtutor->dob));
					if(isset($dob[0]) && isset($dob[1]) && isset($dob[2])){
						$year = $dob[0];
						$month = $dob[1];
						$day = $dob[2];
					}
				}
			?>

			<div class="row">
				<div class="col s12 m4 l4"id="birthmonth">
					<select name="backgroundcheckstep1[dob][month]" class="validate   validate-required  browser-default">
						<?php
							$months = array(
								'1'=>'January',
								'2'=>'February',
								'3'=>'March',
								'4'=>'April',
								'5'=>'May',
								'6'=>'June',
								'7'=>'July',
								'8'=>'August',
								'9'=>'September',
								'10'=>'October',
								'11'=>'November',
								'12'=>'Descember'
							);
						?>
						<option value="">
							-- Select Month
						</option>
						<?php foreach($months as $key => $value): ?>
							<option <?php if(isset($month) && $month == $key){ echo 'selected="selected"';} ?> value="<?php echo $key; ?>">
								<?php echo $value; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col s12 m4 l4" id="birthdate">
					<select name="backgroundcheckstep1[dob][day]" class="validate   validate-required  browser-default">
						<?php
							$days = range(1,31);
						?>
						<option value="">
							-- Select Day
						</option>
						<?php foreach($days as  $value): ?>
							<option <?php if(isset($day) && $day == $value){ echo 'selected="selected"';} ?> value="<?php echo $value; ?>">
								<?php echo $value; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col s12 m4 l4" id="birthyear">
					<select name="backgroundcheckstep1[dob][year]" class="validate   validate-required  browser-default">
						<?php
							$years = range(1900,date('Y'));
							$years = array_reverse($years);
						?>
						<option value="">
							-- Select Year
						</option>
						<?php foreach($years as  $value): ?>
							<option <?php if(isset($year) && $year == $value){ echo 'selected="selected"';} ?> value="<?php echo $value; ?>">
								<?php echo $value; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

		</div>
		<div class="input-field col s12 m4 l4">
			<input placeholder="Please enter zipcode" maxlength="5" name="backgroundcheckstep1[zipcode]" value="<?php if(isset($app->newtutor->zipcode)){ echo $app->newtutor->zipcode; } ?>" id="zipcode" type="text" class="validate">
			<label for="zipcode">Zipcode <i class="fa fa-asterisk red-text"></i></label>
		</div>
	</div>

	<h3>Contact Info</h3>

	<div class="row">
		<div class="input-field col s12 m6 l6">
			<input placeholder="Please enter your phone number" name="backgroundcheckstep1[phone]"  value="<?php if(isset($app->newtutor->phone)){ echo $app->newtutor->phone; } ?>" id="phone" type="tel" class="validate">
			<label for="phone">Phone Number <i class="fa fa-asterisk red-text"></i></label>
		</div>
		<div class="input-field col s12 m6 l6">
			<input placeholder="Please enter email address" readonly="readonly" value="<?php echo $app->newtutor->email; ?>" id="email" type="text" class="validate">
			<label for="email">Email Address</label>
		</div>
	</div>

	<input type="hidden" name="backgroundcheckstep1[target]" value="backgroundcheckstep1"  />
	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

	<div class="row">
		<div class="col s12 m6 l6">
			&nbsp;
		</div>
		<div class="col s12 m6 l6 right-align">
			<button type="submit" class="btn green">
				Next
			</button>
		</div>
	</div>

</form>
