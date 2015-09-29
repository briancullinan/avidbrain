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
		<div class="hidden-avatar">
			<?php $app->currentuser->dontshow = 1; echo show_avatar($app->currentuser,$app->user,$app->dependents); ?>
		</div>
	</div>
</div>