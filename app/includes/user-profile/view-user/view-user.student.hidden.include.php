<div class="hidden-profile center-align">
	<h1><?php
		if(isset($app->currentuser->settings) && $app->currentuser->settings->showfullname=='yes'){
			echo $app->currentuser->first_name.' '.$app->currentuser->last_name;
		}
		else{
			echo short($app->currentuser);
		}

	?></h1>

	<div class="profile-image center-align avatar">
		<div class="user-photograph">
			<img src="<?php echo userphotographs($app->user,$app->currentuser,$app->dependents); ?>" />
		</div>
	</div>
</div>
