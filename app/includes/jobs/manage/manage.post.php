<?php

	if(isset($app->acceptapplication)){

		$sql = "
			SELECT
				hourly_Rate
			FROM
				avid___user_profile
			WHERE
				email = :email
		";
		$prepare = array(':email'=>$app->acceptapplication->email);
		$results = $app->connect->executeQuery($sql,$prepare)->fetch();


		$update = [];
		$update['open'] = NULL;
		$update['active_applicant_id'] = $app->acceptapplication->id;


		$newSession = array(
			'to_user'=>$app->user->email,
			'from_user'=>$app->acceptapplication->email,
			'session_rate'=>$results->hourly_Rate,
			'session_subject'=>$app->thejob->subject_name,
			'jobsetup'=>1,
			'pending'=>NULL,
			'jobid'=>$id
		);

		$subject = the_users_name($app->user).' has accepted your tutoring application.';
		$message = '<p>You may now setup a tutoring session with '.the_users_name($app->user).'</p>';
		$message.='<p> <a class="btn" href="'.$app->dependents->DOMAIN.'/sessions/jobs">Setup Session</a> </p>';

		$app->mailgun->to = $app->acceptapplication->email;
		$app->mailgun->subject = $subject;
		$app->mailgun->message = $message;
		$app->mailgun->send();

		$app->sendmessage->to_user = $app->acceptapplication->email;
		$app->sendmessage->from_user = $app->user->email;
		$app->sendmessage->location = 'inbox';
		$app->sendmessage->send_date = thedate();
		$app->sendmessage->subject = $subject;
		$app->sendmessage->message = $message;
		$app->sendmessage->newmessage();


		$app->connect->update('avid___jobs', $update, array('id' => $id,'email'=>$app->user->email));
		$sessionSetup = $app->connect->insert('avid___sessions',$newSession);

		$app->redirect('/jobs/manage/'.$id);

	}
