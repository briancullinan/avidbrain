<?php

	$sql = "SELECT id FROM avid___jobs WHERE email = :email";
	$prepare = array(':email'=>$app->user->email);
	$jobCount = $app->connect->executeQuery($sql,$prepare)->rowCount();

	if(isset($app->user->status) && $app->user->status=='needs-review'){

		$activate = NULL;
		if($jobCount>0){
			$activate=true;
		}
		if(isset($app->user->short_description) && isset($app->user->personal_statement)){
			$activate = true;
		}

		if($activate==true){

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

			$app->mailgun->to = 'support@mindspree.com';
			$app->mailgun->subject = 'Student Account Activation';
				$message = '<p>'.$app->user->first_name.' '.$app->user->last_name.' has just activated their account.</p>';
				$message.= '<p>Please do a quick fly-by and make sure everything is kosher. </p>';
				$message.= '<p><a href="https://www.mindspree.com'.$app->user->url.'">View Student Profile</a></p>';
			$app->mailgun->message = $message;
			$app->mailgun->send();


			$app->redirect('/activate-profile/complete');

		}


	}
	else{
		$app->redirect('/activate-profile/complete');
	}


	$app->meta = new stdClass();
	$app->meta->title = 'Activate Your Profile';
