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
	elseif(isset($app->updatejob)){

		if(empty($app->updatejob->subject)){
            new Flash(array('action'=>'required','formID'=>'postanewjob','message'=>'Subject Required'));
        }
        elseif(empty($app->updatejob->why)){
            new Flash(array('action'=>'required','formID'=>'postanewjob','message'=>'Explain why you need tutored'));
        }

		if($app->updatejob->open=='OPEN'){
            $app->updatejob->open = 1;
        }
        elseif($app->updatejob->open=='CLOSED'){
            $app->updatejob->open = NULL;
        }

		$app->updatejob->subject_name = $app->updatejob->subject;
        $app->updatejob->job_description = $app->updatejob->why;

		if(empty($app->updatejob->subject_slug)){
            $app->updatejob->subject_slug = $app->thejob->subject_slug;
            $app->updatejob->parent_slug = $app->thejob->parent_slug;
            $app->updatejob->subject_id = $app->thejob->subject_id;
            //$app->updatejob->type = $app->thejob->type;
            $app->updatejob->skill_level = $app->thejob->skill_level;
            $app->updatejob->notes = $app->thejob->notes;
        }

		$updateJob = [];
		$updateJob['subject_name'] = $app->updatejob->subject_name;
        $updateJob['subject_slug'] = $app->updatejob->subject_slug;
        $updateJob['parent_slug'] = $app->updatejob->parent_slug;
        $updateJob['subject_id'] = $app->updatejob->subject_id;
        $updateJob['date'] = thedate();
        $updateJob['job_description'] = $app->updatejob->job_description;
        $updateJob['type'] = $app->updatejob->type;
        $updateJob['skill_level'] = $app->updatejob->skill_level;
        $updateJob['open'] = $app->updatejob->open;
        $updateJob['price_range_low'] = $app->updatejob->price_range_low;
        $updateJob['price_range_high'] = $app->updatejob->price_range_high;
        $updateJob['notes'] = $app->updatejob->notes;

		$app->connect->update('avid___jobs',$updateJob,array('id'=>$id));
		new Flash(array('action'=>'jump-to','location'=>'/jobs/manage/'.$id,'formID'=>'setupsession','message'=>'Job Updated'));

	}
