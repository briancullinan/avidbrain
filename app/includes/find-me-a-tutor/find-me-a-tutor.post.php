<?php

	if(isset($app->postjob)){
		
		//notify($app->postjob);
		
		if(empty($app->postjob->email)){
			new Flash(
				array('action'=>'required','message'=>'Email Required','formID'=>'postajob','field'=>'findasubjectemail-input')
			);
		}
		
		if(doesuserexist($app->connect,$app->postjob->email)){
			new Flash(
				array('action'=>'required','message'=>'Email address already used to signup','formID'=>'postajob','field'=>'findasubjectemail-input')
			);
		}
		
		if(empty($app->postjob->subject_name)){
			new Flash(array('action'=>'required','formID'=>'postajob','message'=>'Subject Required <i class="fa fa-warning"></i>','field'=>'findasubject-input'));
		}
		elseif(empty($app->postjob->job_description)){
			new Flash(array('action'=>'required','formID'=>'postajob','message'=>'Job Description Required <i class="fa fa-warning"></i>','field'=>'job_description-input'));
		}
		
		if(strlen($app->postjob->job_description)>1000){
			new Flash(array('action'=>'required','formID'=>'postajob','message'=>'<span>1,000</span> Characters Maximum '.strlen($app->postjob->job_description).'/1,000','field'=>'job_description-input'));
		}
		
		$validation_code = random_numbers_guarantee($app->connect,16);
		
		$inserttemp = array(
			'email'=>$app->postjob->email,
			'password'=>NULL,
			'usertype'=>'student',
			'signup_date'=>thedate(),
			'promocode'=>NULL,
			'validation_code'=>$validation_code,
			'first_name'=>NULL,
			'last_name'=>NULL,
			'terms_of_service'=>1,
			'temppass'=>NULL,
			'zipcode'=>NULL,
			'city'=>NULL,
			'state'=>NULL,
			'state_long'=>NULL,
			'`lat`'=>NULL,
			'`long`'=>NULL
		);
		
		if(empty($app->postjob->parent_slug)){
			$app->postjob->parent_slug = NULL;
		}
		if(empty($app->postjob->subject_slug)){
			$app->postjob->subject_slug = NULL;
		}
		if(empty($app->postjob->type)){
			$app->postjob->type = NULL;
		}
		if(empty($app->postjob->skill_level)){
			$app->postjob->skill_level = NULL;
		}
		if(empty($app->postjob->id)){
			$app->postjob->id = NULL;
		}
		
		$tempJob = array(
			'subject_id'=>$app->postjob->id,
			'subject_slug'=>$app->postjob->subject_slug,
			'parent_slug'=>$app->postjob->parent_slug,
			'email'=>$app->postjob->email,
			'subject_name'=>$app->postjob->subject_name,
			'job_description'=>$app->postjob->job_description,
			'type'=>$app->postjob->type,
			'skill_level'=>$app->postjob->skill_level,
			'price_range_low'=>$app->postjob->price_range_low,
			'price_range_high'=>$app->postjob->price_range_high,
			'date'=>thedate()
		);
		
		$insert = $app->connect->insert('avid___jobs',$tempJob);
		$insert = $app->connect->insert('avid___users_temp',$inserttemp);
		
		$message = '<p>Please login to finish your profile</p>';
		$message.= '<p>Your verification link is: <a href="'.DOMAIN.'/activate/'.$validation_code.'">Verify Email Address</a></p>';
		
		
		$app->mailgun->to = $app->postjob->email;
		$app->mailgun->subject = 'Thank you for posting a job at '.SITENAME_PROPPER;
		$app->mailgun->message = $message;
		$app->mailgun->send();
		
		
		new Flash(array('action'=>'jump-to','formID'=>'signup','location'=>'/confirmation/find-me-a-tutor','message'=>'Signup Success'));
		
	}