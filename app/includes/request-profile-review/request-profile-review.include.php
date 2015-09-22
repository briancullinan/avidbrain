<h1>Request Profile Review</h1>

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
	elseif($app->user->usertype=='student'){
		
		$sql = "SELECT * FROM avid___jobs WHERE open IS NOT NULL AND email = :email ORDER BY `date` DESC";
		$prepeare = array(':email'=>$app->user->email);
		$myjobs = $app->connect->executeQuery($sql,$prepeare)->fetchAll();
		
		if(isset($myjobs[0])){
			$submitbutton = true;
		}
		elseif(!empty($app->user->short_description) && !empty($app->user->personal_statement)){
			$submitbutton = true;
		}
	}
?>

<?php if(isset($submitbutton)): ?>

<p>Once you've clicked the button you will be logged out of <?php echo $app->dependents->SITE_NAME_PROPPER; ?> and your account will be locked, so we can review your profile.</p>
<form method="post" action="<?php echo $app->request->getPath(); ?>">
	
	<input type="hidden" name="requestprofilereview[target]" value="requestprofilereview"  />
	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
	
	<button type="button" class="btn red confirm-submit" data-value="reviewmyprofile" data-name="requestprofilereview">Request Profile Review</button>
	
</form>

<?php else: ?>
	
	
	<?php if($app->user->usertype=='tutor'): ?>
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
	<?php elseif($app->user->usertype=='student'): ?>
	<p>Before you can submit your profile for review, we require that you do a couple things:</p>
	
	<ul class="collection">
		<?php
			if(empty($app->user->short_description)){
				echo '<li class="collection-item"><a href="'.$app->user->url.'"> <i class="fa fa-pencil"></i> Add A Short Description</a></li>';
			}
			if(empty($app->user->personal_statement)){
				echo '<li class="collection-item"><a href="'.$app->user->url.'"> <i class="fa fa-pencil"></i> Add A Personal Statement</a></li>';
			}
			if(empty($myjobs)){
				echo '<li class="collection-item"><a href="/jobs"> <i class="fa fa-check-square"></i> Add A Job Posting</a></li>';
			}
		?>
	</ul>
	<?php endif; ?>
	
	
	
<?php endif; ?>