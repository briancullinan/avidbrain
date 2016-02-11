<?php

	if(isset($app->user->usertype) && $app->user->usertype=='admin'){

		$userM = new stdClass();
		$userM->usertype = 'student';
		$userM->email = $app->job->email;

		$app->user = $userM;

	}

	function applicantinfo($acceptapplication,$job){
		if(isset($acceptapplication->id) && isset($job->applicants)){
			foreach($job->applicants as $applicants){
				if($acceptapplication->id==$applicants->id){
					$applicantinfo = $applicants;
					break;
				}
			}
		}
		if(isset($applicantinfo)){
			return $applicantinfo;
		}
	}


	if(isset($app->acceptapplication) && $app->acceptapplication->status=='accept'){

		$applicantinfo = applicantinfo($app->acceptapplication,$app->job);

		$update = array(
			'open'=>NULL,
			'active_applicant_id'=>$app->acceptapplication->id
		);
		$app->connect->update('avid___jobs', $update, array('id' => $id,'email'=>$app->user->email));

		$subject = the_users_name($app->user).' has accepted your tutoring application.';
		$message = '<p>You may now setup a tutoring session with '.the_users_name($app->user).'</p>';
		$message.='<p> <a class="btn" href="'.DOMAIN.'/sessions/jobs">Setup Session</a> </p>';

		if(isset($applicantinfo->getemails) && $applicantinfo->getemails=='yes'){
			$app->mailgun->to = $applicantinfo->email;
			$app->mailgun->subject = $subject;
			$app->mailgun->message = $message;
			$app->mailgun->send();
		}

		$app->sendmessage->to_user = $applicantinfo->email;
		$app->sendmessage->from_user = $app->user->email;
		$app->sendmessage->location = 'inbox';
		$app->sendmessage->send_date = thedate();
		$app->sendmessage->subject = $subject;
		$app->sendmessage->message = $message;
		$app->sendmessage->newmessage();

		$newSession = array(
			'to_user'=>$app->user->email,
			'from_user'=>$applicantinfo->email,
			'session_rate'=>$applicantinfo->hourly_rate,
			'session_subject'=>$app->job->subject_name,
			'jobsetup'=>1,
			'pending'=>NULL,
			'jobid'=>$app->job->id
		);

		$sessionSetup = $app->connect->insert('avid___sessions',$newSession);

		$app->redirect('/jobs/manage/'.$id);

	}
	elseif(isset($app->redactapplication) && $app->redactapplication->status=='redact'){

		$applicantinfo = applicantinfo($app->redactapplication,$app->job);

		$subject = the_users_name($app->user).' has redacted your tutoring application.';
		$message = '<p>'.the_users_name($app->user).'</p>';

		if(isset($applicantinfo->getemails) && $applicantinfo->getemails=='yes'){
			$app->mailgun->to = $applicantinfo->email;
			$app->mailgun->subject = $subject;
			$app->mailgun->message = $message;
			$app->mailgun->send();
		}

		$app->sendmessage->to_user = $applicantinfo->email;
		$app->sendmessage->from_user = $app->user->email;
		$app->sendmessage->location = 'inbox';
		$app->sendmessage->send_date = thedate();
		$app->sendmessage->subject = $subject;
		$app->sendmessage->message = $message;
		$app->sendmessage->newmessage();

		$delete = $app->connect->delete('avid___sessions',array('to_user'=>$app->user->email,'jobid'=>$app->job->id));


		$update = array(
			'open'=>1,
			'active_applicant_id'=>NULL
		);

		$app->connect->update('avid___jobs', $update, array('id' => $id,'email'=>$app->user->email));

		$app->redirect('/jobs/manage/'.$id);

	}
	elseif(isset($app->updatejob) && $app->user->usertype=='student'){

		$update = array(
			'job_description'=>$app->updatejob->job_description,
			'parent_slug'=>$app->updatejob->parent_slug,
			'skill_level'=>$app->updatejob->skill_level,
			'subject_name'=>$app->updatejob->subject_name,
			'subject_slug'=>$app->updatejob->subject_slug,
			'type'=>$app->updatejob->type,
			'date'=>thedate(),
			'price_range_low'=>$app->updatejob->price_range_low,
			'price_range_high'=>$app->updatejob->price_range_high
		);

		$message = 'Job Posting Updated';

		if(isset($app->updatejob->status) && $app->updatejob->status=='closejob'){
			//$update['closed'] = 1;
			$message = 'Job Posting Removed';
			$app->connect->delete('avid___jobs', array('id' => $id,'email'=>$app->user->email));
		}

		$app->connect->update('avid___jobs', $update, array('id' => $id,'email'=>$app->user->email));

		new Flash(array('action'=>'jump-to','location'=>'/jobs/manage/'.$id,'message'=>$message));

	}
