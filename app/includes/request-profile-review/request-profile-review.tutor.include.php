

<p>We require all profiles to be reviewed before they are public. If you would like to have your profile reviewed by <?php echo $app->dependents->SITE_NAME_PROPPER; ?> Staff.</p>

<?php
	if($app->user->usertype=='tutor'){
		
		$sql = "SELECT id FROM avid___user_subjects WHERE email = :email ";
		$prepeare = array(':email'=>$app->user->email);
		$myjobs = $app->connect->executeQuery($sql,$prepeare)->rowCount();
		
		if(!empty($app->user->short_description) && !empty($app->user->personal_statement) && !empty($app->user->hourly_rate) && $myjobs!=0){
			$submitbutton = true;
		}
		
	}
?>

<?php if(isset($submitbutton)): ?>

<div class="row">
	<div class="col s12 m6 l6">
		<h3>Profile Review</h3>
		<div class="block">
			<div>Once you've clicked the button you will be logged out of <?php echo $app->dependents->SITE_NAME_PROPPER; ?> and your account will be locked, so we can review your profile.</div>
			<br>
			<form method="post" action="<?php echo $app->request->getPath(); ?>">
				
				<input type="hidden" name="requestprofilereview[target]" value="requestprofilereview"  />
				<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
				
				<?php if($app->user->status!='needs-review'): ?>
				<div>
					What would you like reviewed?
				</div>
				
				<div>
					<p>
						<input type="radio" id="mysubjects" name="requestprofilereview[type]" value="My Subjects" />
						<label for="mysubjects">My Subjects</label>
					</p>
					<p>
						<input type="radio" id="shortdescription" name="requestprofilereview[type]" value="Short Description / About Me" />
						<label for="shortdescription">My Short Description / About Me</label>
					</p>
					<p>
						<input type="radio" id="everything" name="requestprofilereview[type]" value="Everything" checked="checked" />
						<label for="everything">Everything</label>
					</p>
				</div>
				<br>
				<?php else: ?>
				<input type="hidden" name="requestprofilereview[type]" value="First Time Review"  />
				<?php endif; ?>
				
				<button type="button" class="btn red confirm-submit" data-value="reviewmyprofile" data-name="requestprofilereview">Request Profile Review</button>
				
			</form>
		</div>
	</div>
	<div class="col s12 m6 l6">
		<h3>Photo Review</h3>
		<div class="block">
			<div>If you would like your photo approved, without locking your account, click the submit button below.</div>
			<br>
			<form method="post" action="<?php echo $app->request->getPath(); ?>">
				
				<input type="hidden" name="requestprofilereview[target]" value="requestprofilereview"  />
				<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
				
				<?php if($app->user->status!='needs-review'): ?>
				<div>
					What would you like reviewed?
				</div>
				
				<div>
					<p>
						<input type="radio" checked="checked" id="myphoto" name="requestprofilereview[type]" value="My Photo" />
						<label for="myphoto">My Photo</label>
					</p>
				</div>
				<br>
				<?php else: ?>
				<input type="hidden" name="requestprofilereview[type]" value="First Time Review"  />
				<?php endif; ?>
				
				<button type="button" class="btn red confirm-submit" data-value="reviewmyprofile" data-name="requestprofilereview">Request Photo Review</button>
				
			</form>
		</div>
	</div>
</div>

<?php else: ?>
	

	<ul class="collection">
		<?php
			if(empty($app->user->hourly_rate)){
				echo '<li class="collection-item"><a href="'.$app->user->url.'"> <i class="fa fa-money"></i> Add Your Hourly Rate</a></li>';
			}
			if(empty($app->user->short_description)){
				echo '<li class="collection-item"><a href="'.$app->user->url.'"> <i class="fa fa-pencil"></i> Add A Short Description</a></li>';
			}
			if(empty($app->user->personal_statement)){
				echo '<li class="collection-item"><a href="'.$app->user->url.'"> <i class="fa fa-pencil"></i> Add A Personal Statement</a></li>';
			}
			if(empty($myjobs)){
				echo '<li class="collection-item"><a href="'.$app->user->url.'/my-subjects"> <i class="fa fa-check-square"></i> Add Tutored Subjects </a></li>';
			}
		?>
	</ul>

	
	
	
<?php endif; ?>