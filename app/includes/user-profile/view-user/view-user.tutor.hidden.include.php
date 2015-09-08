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
		<?php if(isset($app->currentuser->my_upload) && $app->currentuser->my_upload_status=='verified'): ?>
			<img class="responsive-img" src="/profiles/approved/<?php echo str_replace($app->dependents->APP_PATH.'uploads/photos/','',croppedfile($app->currentuser->my_upload)); ?>" />
		<?php elseif(isset($app->currentuser->my_upload) && isset($app->currentuser->thisisme)): ?>
			<img class="responsive-img" src="<?php echo $app->currentuser->url; ?>/thumbnail" />
		<?php else: ?>
			<img class="responsive-img" src="<?php echo $app->currentuser->my_avatar; ?>" />
		<?php endif; ?>
	</div>
</div>