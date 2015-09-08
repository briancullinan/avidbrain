<?php
	if(isset($app->application) && isset($app->user->usertype) && $app->user->usertype=='tutor'){
	
		if($app->application->message>500){
			new Flash(array('action'=>'required','formID'=>'sessionreviews','message'=>'<span>500</span> Characters Maximum '.strlen($app->application->message).'/500'));
		}
		
		$doesexist = NULL;
		if(isset($app->application)){
			$sql = "SELECT id FROM avid___jobs_applicants WHERE jobid = :id AND email = :email";
			$prepeare = array(':id'=>$id,':email'=>$app->user->email);
			$doesexist = $app->connect->executeQuery($sql,$prepeare)->rowCount();
		}
		
		//notify($doesexist);
		
		if($doesexist!=0){
			new Flash(array('action'=>'required','formID'=>'findasubject','message'=>'Duplicate Application</span>'));
		}
		
		
		if(empty($app->application->message)){
			new Flash(array('action'=>'required','message'=>'Message Required'));
		}
		
		$subject = 'New Job Application';
		$message = '<p>'.the_users_name($app->user).' has applied to your <a href="'.$app->dependents->DOMAIN.'/jobs/manage/'.$app->job->id.'">'.$app->job->subject_name.'</a> job posting.</p>';
		$message.='<p>Message: '.$app->application->message.'</p>';
		$message.='<p><a class="btn blue" href="'.$app->dependents->DOMAIN.'/jobs/manage/'.$app->job->id.'">View Posting</a> </p>';
				
		if(isset($app->job->getemails) && $app->job->getemails=='yes'){
			
			$app->mailgun->to = $app->job->email;
			$app->mailgun->subject = $subject;
			$app->mailgun->message = $message;
			$app->mailgun->send();
			
		}
		
		$app->sendmessage->to_user = $app->job->email;
		$app->sendmessage->from_user = $app->user->email;
		$app->sendmessage->location = 'inbox';
		$app->sendmessage->send_date = thedate();
		$app->sendmessage->subject = $subject;
		$app->sendmessage->message = $message;
		$app->sendmessage->newmessage();
		
		$insert = array(
			'email'=>$app->user->email,
			'message'=>$app->application->message,
			'date'=>thedate(),
			'jobid'=>$id
		);
		
		$app->connect->insert('avid___jobs_applicants',$insert);
		
		$sql = "UPDATE avid___jobs SET applicants = IFNULL(applicants, 0) + 1 WHERE id = :id";
		$prepeare = array(':id'=>$id);
		$results = $app->connect->executeQuery($sql,$prepeare);

		
		new Flash(array('action'=>'jump-to','message'=>'Job Applied','location'=>'/jobs/apply/'.$id));
		
		
	}