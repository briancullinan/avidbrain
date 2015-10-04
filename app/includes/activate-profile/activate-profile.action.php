<?php
	
	if(isset($app->user->status) && $app->user->status=='needs-review'){
		
		/*
			
			Activate Student Profile
			
			set status to NULL
			set hidden to NULL
			set lock to NULL
			
			email an admin, so they know about the current student
			
		*/
		
		$app->user->status = NULL;
		$app->user->hidden = NULL;
		$app->user->lock = NULL;
		$app->user->save();
		
		$app->mailgun->to = 'david@avidbrain.com';
		$app->mailgun->subject = 'Student Account Activation';
			$message = '<p>'.$app->user->first_name.' '.$app->user->last_name.' has just activated their account.</p>';
			$message.= '<p>Please do a quick fly-by and make sure everything is kosher. </p>';
			$message.= '<p><a href="'.$app->user->url.'">View Student Profile</a></p>';
		$app->mailgun->message = $message;
		$app->mailgun->send();
		
		
		$app->redirect('/jobs');
		
	}