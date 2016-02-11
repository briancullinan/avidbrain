<?php
	if(isset($app->create)){



		if(empty($app->create->first_name)){
			new Flash(
				array('action'=>'required','message'=>'First Name Required')
			);
		}

		if(empty($app->create->last_name)){
			new Flash(
				array('action'=>'required','message'=>'Last Name Required')
			);
		}

		if(empty($app->create->email)){
			new Flash(
				array('action'=>'required','message'=>'Email Required')
			);
		}

		if(empty($app->create->password)){
			new Flash(
				array('action'=>'required','message'=>'Password Required')
			);
		}

		$check = doesuserexist($app->connect,$app->create->email);

		if($check==true){
			new Flash(
				array('action'=>'required','message'=>'User Already Exists <i class="fa fa-warning"></i>')
			);
		}

		$validation_code = random_all(22);

		$app->mailgun->to = $app->create->email;
		$app->mailgun->subject = 'Account Activation';
			$message = '<p>Welcome to '.SITENAME_PROPPER.', please activate your profile by clicking the link below.</p>';
			$message.= '<p> Your password is: '.$app->create->password.' </p>';
			$message.= '<p> <a href="'.DOMAIN.'/validate/'.$validation_code.'">Activate Account</a> </p>';
		$app->mailgun->message = $message;
		$app->mailgun->send();

		$insert = array(
			'email'=>$app->create->email,
			'password'=>password_hash($app->create->password, PASSWORD_BCRYPT),
			'usertype'=>'tutor',
			'signup_date'=>thedate(),
			'validation_code'=>$validation_code,
			'first_name'=>$app->create->first_name,
			'last_name'=>$app->create->last_name,
			'terms_of_service'=>1
		);

		$app->connect->insert('avid___users_temp',$insert);

		new Flash(
			array('action'=>'kill-form','formID'=>'createtutor','message'=>'Tutor Created')
		);

	}
