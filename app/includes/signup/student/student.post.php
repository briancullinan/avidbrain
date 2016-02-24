<?php

	//notify('science');

	if(isset($app->signup)){
		//
		if($app->signup->password!=$app->signup->password_confirm){
			new Flash(array('action'=>'required','formID'=>'signup','field'=>'field_signup_password_confirm','message'=>"Your password doesn't match <i class='fa fa-lock'></i>"));
		}
		elseif(strlen($app->signup->password) < 6){
			new Flash(array('action'=>'required','message'=>"Passwords must be at least <span>6 characters</span>"));
		}
		elseif(strlen($app->signup->zipcode) != 5){
			new Flash(array('action'=>'required','formID'=>'signup','field'=>'field_signup_zipcode','message'=>"Invalid Zip Code"));
		}
		elseif(strlen($app->signup->phone) != 10){
			new Flash(array('action'=>'required','formID'=>'signup','field'=>'field_signup_phone','message'=>"Phone number must be 10 digits"));
		}

		$zipData = get_zipcode_data($app->connect,$app->signup->zipcode);

		if($zipData==false){
			new Flash(array('action'=>'required','message'=>"Zip Code Not Valid"));
		}

		if(isset($app->signup->phone) && $app->signup->phone=='666-666-6666'){
			$app->signup->phone = NULL;
		}


		if(doesuserexist($app->connect,$app->signup->email)){
			new Flash(array('action'=>'required','message'=>'Email address already used to signup'));
		}

		if(isset($app->signup->howdidyouhear)){

			$query = "
				INSERT INTO
					avid___howdidyouhear
				SET
					email = :email,
					date = :date,
					howdidyouhear = :howdidyouhear,
					howdidyouhear_other = :howdidyouhear_other
			";
			$prepare = array(
				':email'=>$app->signup->email,
				':date'=>thedate(),
				':howdidyouhear'=>$app->signup->howdidyouhear,
				':howdidyouhear_other'=>$app->signup->howdidyouhear_other
			);
			$app->connect->executeQuery($query,$prepare);

		}

		$password = password_hash($app->signup->password, PASSWORD_DEFAULT);
		$validation_code = random_numbers_guarantee($app->connect,16);

		$inserttemp = array(
			'email'=>$app->signup->email,
			'password'=>$password,
			'usertype'=>'student',
			'signup_date'=>thedate(),
			'promocode'=>$app->signup->promocode,
			'validation_code'=>$validation_code,
			'first_name'=>$app->signup->first_name,
			'last_name'=>$app->signup->last_name,
			'terms_of_service'=>1,
			//'parent'=>$app->signup->parent,
			'temppass'=>NULL,
			'zipcode'=>$zipData->zipcode,
			'city'=>$zipData->city,
			'state'=>$zipData->state,
			'state_long'=>$zipData->state_long,
			'`lat`'=>$zipData->lat,
			'`long`'=>$zipData->long,
			'phone'=>$app->signup->phone
		);

		if(isset($app->signup->promocode) && $app->signup->promocode=='qa-signup'){
			$inserttemp['qasignup'] = 1;
		}

		if(isset($app->signup->promocode)){
			$sql = "SELECT * FROM avid___promotions WHERE promocode = :promocode";
			$prepare = array(':promocode'=>$app->signup->promocode);
			$isvalidpromo = $app->connect->executeQuery($sql,$prepare)->fetch();
			if(isset($isvalidpromo->id)){
				$app->isvalidpromo = $isvalidpromo;
			}

		}

		if(isset($app->isvalidpromo) && isset($app->freesessions->enabled) && $app->freesessions->enabled==true){

			$insertpromo = array(
				'email'=>$app->signup->email,
				'promocode'=>$app->isvalidpromo->promocode,
				'value'=>$app->isvalidpromo->value,
				'date'=>thedate(),
				'sharedwith'=>$app->isvalidpromo->email,
				'activated'=>1
			);


			$app->connect->insert('avid___promotions_active',$insertpromo);

			if(parent_company_email($app->isvalidpromo->email)!=true){
				$insertpromo = array(
					'email'=>$app->isvalidpromo->email,
					'promocode'=>$app->isvalidpromo->promocode,
					'value'=>$app->isvalidpromo->value,
					'date'=>thedate(),
					'sharedwith'=>$app->signup->email,
					'activated'=>NULL
				);

				$app->connect->insert('avid___promotions_active',$insertpromo);
			}

			$promomessage = '<p>A new student has signed up using your promo code.</p>';
			$promomessage.= '<p>Date: '.formatdate(thedate()).'</p>';
			$promomessage.= '<p>User Info: '.$app->signup->first_name.' </p>';
			$promomessage.= '<p>Promo Code: '.$app->isvalidpromo->promocode.' </p>';

			$app->mailgun->to = $app->isvalidpromo->email;
			$app->mailgun->subject = 'Promo Code Activated';
			$app->mailgun->message = $promomessage;
			$app->mailgun->send();

		}

		$insert = $app->connect->insert('avid___users_temp',$inserttemp);

		// Email User
		// Do Things

		$emailcode = DOMAIN.'/validate/'.$validation_code;

		$welcomeMessage = '<p>Welcome to AvidBrain</p>';
		$welcomeMessage.= '<p>Your verification link is: <a href="'.$emailcode.'">Verify Email Address</a></p>';
		$welcomeMessage.= '<p>Text Link: '.$emailcode.'</p>';

		$app->mailgun->to = $app->signup->email;
		$app->mailgun->subject = 'Please authenticate your email address';
		$app->mailgun->message = $welcomeMessage;
		$app->mailgun->send();

		$serverinfo = (object)$_SERVER;
		if(isset($app->signup->first_name)){$firstname=$app->signup->first_name;}else{$firstname=NULL;}
		if(isset($app->signup->last_name)){$lastname=$app->signup->last_name;}else{$lastname=NULL;}
		if(isset($app->signup->phone)){$phone=$app->signup->phone;}else{$phone=NULL;}
		if(isset($app->signup->promocode)){$promocode=$app->signup->promocode;}else{$promocode=NULL;}
		if(isset($app->signup->zipcode)){$zipcode=$app->signup->zipcode;}else{$zipcode=NULL;}
		if(isset($serverinfo->REMOTE_ADDR)){$remoteAddress=$serverinfo->REMOTE_ADDR;}else{$remoteAddress=NULL;}
		if(isset($serverinfo->REQUEST_URI)){$url=$serverinfo->REQUEST_URI;}else{$url=NULL;}
		if(isset($serverinfo->HTTP_REFERER)){$referrer=$serverinfo->HTTP_REFERER;}else{$referrer=NULL;}

		$newstudentEmail = '';
		$newstudentEmail.= '<p>Date: '.formatdate(thedate(),'M. jS, Y @ g:i a').'</p>';
		$newstudentEmail.= '<p> Email: '.$app->signup->email.' </p>';
		$newstudentEmail.= '<p> Name: '.$firstname.' '.$lastname.' </p>';
		$newstudentEmail.= '<p> Phone: '.$phone.' </p>';
		$newstudentEmail.= '<p> Promo Code: '.$promocode.' </p>';
		$newstudentEmail.= '<p> Zip Code: '.$zipcode.' </p>';
		$newstudentEmail.= '<p> <strong>Server Info</strong> </p>';
		$newstudentEmail.= '<p> IP Address: '.$remoteAddress.' </p>';
		$newstudentEmail.= '<p> URL: '.$url.' </p>';
		$newstudentEmail.= '<p> Referrer: '.$referrer.' </p>';

		if(isset($serverinfo->REMOTE_ADDR)){
			try{
				$iplookip = ipaddresslookup($serverinfo->REMOTE_ADDR);
			}
			catch(Exception $e){
				//echo '<pre>'; print_r($e); echo '</pre>';
			}
			if(!empty($iplookip)){
				foreach($iplookip as $ip => $lookup){
					$newstudentEmail.= '<p> '.$ip.': '.$lookup.' </p>';
				}
			}
		}

		if(DOMAIN=='http://avidbrain.dev'){
			$toemails = 'david@avidbrain.com';
		}
		else{
			$toemails = 'jake.stoll@avidbrain.com,keith@avidbrain.com,david@avidbrain.com';
		}

		$app->mailgun->to = $toemails;
		$app->mailgun->subject = 'New Student Signup';
		$app->mailgun->message = $newstudentEmail;
		$app->mailgun->send();

		if(isset($app->signup->waiting_to_email)){
			$insert = array(
				'from_user'=>$app->signup->email,
				'to_user'=>$app->signup->to_user,
				'date'=>thedate(),
				'send_message'=>removeContacts($app->signup->signup_message),
			);
			$app->connect->insert('avid___waiting_to_email',$insert);
		}

		if($app->freesessions->enabled==false){
			$app->mailgun->to = 'david@avidbrain.com';
			$app->mailgun->subject = 'Maximum Free Sessions';
			$app->mailgun->message = 'You have reached the maximum free sessions of: $'.numbers($app->freesessions->maximum);
			$app->mailgun->send();
		}

		new Flash(array('action'=>'jump-to','formID'=>'signup','location'=>'/confirmation/student-signup','message'=>'Signup Success'));
		//
	}
	elseif(isset($app->studentapplication)){

		$sql = "SELECT email FROM avid___studentsignups WHERE email = :email";
		$prepeare = array(':email'=>$app->studentapplication->email);
		$sth = $app->connect->executeQuery($sql,$prepeare)->fetch();
		if(isset($sth->email)){

			new Flash(array('action'=>'required','message'=>'Email address already used'));

		}

		$query = "INSERT INTO avid___studentsignups SET `email` = :email, date = :date ";
		$prepare = array(':email'=>$app->studentapplication->email,':date'=>thedate());
		$results = $app->connect->executeQuery($query,$prepare);

		new Flash(array('action'=>'kill-form','formID'=>'studentapplication','message'=>'Signup Success <i class="fa fa-heart"></i>'));


	}
	elseif(isset($app->studentsignup)){

		if(isset($app->studentsignup->student->phone)){
			$app->studentsignup->student->phone = preg_replace("/[^0-9,.]/", "", $app->studentsignup->student->phone);
		}

		if(empty($app->studentsignup->student->first_name)){
			new Flash(array('action'=>'required','message'=>'First Name Required','formID'=>'studentsignup','field'=>'ts_first_name'));
		}
		elseif(empty($app->studentsignup->student->last_name)){
			new Flash(array('action'=>'required','message'=>'Last Name Required','formID'=>'studentsignup','field'=>'ts_last_name'));
		}
		elseif(empty($app->studentsignup->student->email)){
			new Flash(array('action'=>'required','message'=>'Email Address Required','formID'=>'studentsignup','field'=>'ts_email'));
		}
		elseif(doesuserexist($app->connect,$app->studentsignup->student->email)==true){
			new Flash(array('action'=>'required','message'=>'Email address already used to signup','formID'=>'studentsignup','field'=>'ts_email'));
		}
		elseif(empty($app->studentsignup->student->phone)){
			new Flash(array('action'=>'required','message'=>'Telephone Number Required','formID'=>'studentsignup','field'=>'ts_phone'));
		}
		elseif(empty($app->studentsignup->student->phone)){
			new Flash(array('action'=>'required','message'=>'Telephone Number Required','formID'=>'studentsignup','field'=>'ts_phone'));
		}
		elseif(strlen($app->studentsignup->student->phone)!=10){
			new Flash(array('action'=>'required','message'=>'Telephone Number Must Be 10 Digits','formID'=>'studentsignup','field'=>'ts_phone'));
		}
		elseif(empty($app->studentsignup->student->password)){
			new Flash(array('action'=>'required','message'=>'Password Required','formID'=>'studentsignup','field'=>'ts_password'));
		}
		elseif(strlen($app->studentsignup->student->password) < 6){
			new Flash(array('action'=>'required','message'=>'Password must be at least 6 characters','formID'=>'studentsignup','field'=>'ts_password'));
		}
		elseif(empty($app->studentsignup->student->zipcode)){
			new Flash(array('action'=>'required','message'=>'Zip Code Required','formID'=>'studentsignup','field'=>'ts_zipcode'));
		}
		$zipData = get_zipcode_data($app->connect,$app->studentsignup->student->zipcode);

		if($zipData==false){
			new Flash(array('action'=>'required','message'=>'Invalid Zip Code','formID'=>'studentsignup','field'=>'ts_zipcode'));
		}

		if(isset($app->studentsignup->student->phone) && $app->studentsignup->student->phone=='6666666666'){
			$app->studentsignup->student->phone = NULL;
		}

		$password = password_hash($app->studentsignup->student->password, PASSWORD_DEFAULT);
		$validation_code = random_numbers_guarantee($app->connect,16);

		if(isset($app->studentsignup->student->promocode)){
			$sql = "SELECT email FROM avid___user WHERE email = :promocode";
			$prepare = array(':promocode'=>$app->studentsignup->student->promocode);
			$results = $app->connect->executeQuery($sql,$prepare)->fetch();
			if(isset($results->email)){

				$app->connect->insert('avid___approved_tutors',array('tutor_email'=>$results->email,'student_email'=>$app->studentsignup->student->email,'date'=>thedate()));

			}
		}

		$inserttemp = array(
			'email'=>$app->studentsignup->student->email,
			'password'=>$password,
			'usertype'=>'student',
			'signup_date'=>thedate(),
			'promocode'=>$app->studentsignup->student->promocode,
			'validation_code'=>$validation_code,
			'first_name'=>$app->studentsignup->student->first_name,
			'last_name'=>$app->studentsignup->student->last_name,
			'terms_of_service'=>1,
			//'parent'=>$app->studentsignup->student->parent,
			'temppass'=>NULL,
			'zipcode'=>$zipData->zipcode,
			'city'=>$zipData->city,
			'state'=>$zipData->state,
			'state_long'=>$zipData->state_long,
			'`lat`'=>$zipData->lat,
			'`long`'=>$zipData->long,
			'phone'=>$app->studentsignup->student->phone
		);

		// START
			if(isset($app->studentsignup->student->promocode) && $app->studentsignup->student->promocode=='qa-signup'){
				$inserttemp['qasignup'] = 1;
			}

			if(isset($app->studentsignup->student->promocode)){
				$sql = "SELECT * FROM avid___promotions WHERE promocode = :promocode";
				$prepare = array(':promocode'=>$app->studentsignup->student->promocode);
				$isvalidpromo = $app->connect->executeQuery($sql,$prepare)->fetch();
				if(isset($isvalidpromo->id)){
					$app->isvalidpromo = $isvalidpromo;
				}

			}



			if(isset($app->isvalidpromo) && isset($app->freesessions->enabled) && $app->freesessions->enabled==true){

				$insertpromo = array(
					'email'=>$app->studentsignup->student->email,
					'promocode'=>$app->isvalidpromo->promocode,
					'value'=>$app->isvalidpromo->value,
					'date'=>thedate(),
					'sharedwith'=>$app->isvalidpromo->email,
					'activated'=>1
				);


				$app->connect->insert('avid___promotions_active',$insertpromo);

				if(parent_company_email($app->isvalidpromo->email)!=true){
					$insertpromo = array(
						'email'=>$app->isvalidpromo->email,
						'promocode'=>$app->isvalidpromo->promocode,
						'value'=>$app->isvalidpromo->value,
						'date'=>thedate(),
						'sharedwith'=>$app->studentsignup->student->email,
						'activated'=>NULL
					);

					$app->connect->insert('avid___promotions_active',$insertpromo);
				}

				$promomessage = '<p>A new student has signed up using your promo code.</p>';
				$promomessage.= '<p>Date: '.formatdate(thedate()).'</p>';
				$promomessage.= '<p>User Info: '.$app->studentsignup->student->first_name.' </p>';
				$promomessage.= '<p>Promo Code: '.$app->isvalidpromo->promocode.' </p>';

				$app->mailgun->to = $app->isvalidpromo->email;
				$app->mailgun->subject = 'Promo Code Activated';
				$app->mailgun->message = $promomessage;
				$app->mailgun->send();

			}

			$insert = $app->connect->insert('avid___users_temp',$inserttemp);

			// Email User
			// Do Things

			$textlink = DOMAIN.'/validate/'.$validation_code;

			$welcomeMessage = '<p>Welcome to AvidBrain</p>';
			$welcomeMessage.= '<p>Your verification link is:  '.DOMAIN.'/validate/'.$validation_code.'</p>';
			$welcomeMessage.= '<p><a href="'.$textlink.'">Verify Email Address</a></p>';
			$welcomeMessage.= '<p>Text Link: '.$textlink.'</p>';

			$app->mailgun->to = $app->studentsignup->student->email;
			$app->mailgun->subject = 'Please authenticate your email address';
			$app->mailgun->message = $welcomeMessage;
			$app->mailgun->send();

			$serverinfo = (object)$_SERVER;
			if(isset($app->studentsignup->student->first_name)){$firstname=$app->studentsignup->student->first_name;}else{$firstname=NULL;}
			if(isset($app->studentsignup->student->last_name)){$lastname=$app->studentsignup->student->last_name;}else{$lastname=NULL;}
			if(isset($app->studentsignup->student->phone)){$phone=$app->studentsignup->student->phone;}else{$phone=NULL;}
			if(isset($app->studentsignup->student->promocode)){$promocode=$app->studentsignup->student->promocode;}else{$promocode=NULL;}
			if(isset($app->studentsignup->student->zipcode)){$zipcode=$app->studentsignup->student->zipcode;}else{$zipcode=NULL;}
			if(isset($serverinfo->REMOTE_ADDR)){$remoteAddress=$serverinfo->REMOTE_ADDR;}else{$remoteAddress=NULL;}
			if(isset($serverinfo->REQUEST_URI)){$url=$serverinfo->REQUEST_URI;}else{$url=NULL;}
			if(isset($serverinfo->HTTP_REFERER)){$referrer=$serverinfo->HTTP_REFERER;}else{$referrer=NULL;}

			$newstudentEmail = '';
			$newstudentEmail.= '<p>Date: '.formatdate(thedate(),'M. jS, Y @ g:i a').'</p>';
			$newstudentEmail.= '<p> Email: '.$app->studentsignup->student->email.' </p>';
			$newstudentEmail.= '<p> Name: '.$firstname.' '.$lastname.' </p>';
			$newstudentEmail.= '<p> Phone: '.$phone.' </p>';
			$newstudentEmail.= '<p> Promo Code: '.$promocode.' </p>';
			$newstudentEmail.= '<p> Zip Code: '.$zipcode.' </p>';
			$newstudentEmail.= '<p> <strong>Server Info</strong> </p>';
			$newstudentEmail.= '<p> IP Address: '.$remoteAddress.' </p>';
			$newstudentEmail.= '<p> URL: '.$url.' </p>';
			$newstudentEmail.= '<p> Referrer: '.$referrer.' </p>';

			if(isset($serverinfo->REMOTE_ADDR)){
				$newstudentEmail.= '<p> IP Address Lookup </p>';
				$iplookip = ipaddresslookup($serverinfo->REMOTE_ADDR);
				if(!empty($iplookip)){
					foreach($iplookip as $ip => $lookup){
						$newstudentEmail.= '<p> '.$ip.': '.$lookup.' </p>';
					}
				}
			}

			if(DOMAIN=='http://avidbrain.dev'){
				$toemails = 'david@avidbrain.com';
			}
			else{
				$toemails = 'jake.stoll@avidbrain.com,keith@avidbrain.com,david@avidbrain.com';
			}

			$app->mailgun->to = $toemails;
			$app->mailgun->subject = 'New Student Signup';
			$app->mailgun->message = $newstudentEmail;
			$app->mailgun->send();

			if(isset($app->studentsignup->student->waiting_to_email)){
				$insert = array(
					'from_user'=>$app->studentsignup->student->email,
					'to_user'=>$app->studentsignup->student->to_user,
					'date'=>thedate(),
					'send_message'=>removeContacts($app->studentsignup->student->signup_message),
				);
				$app->connect->insert('avid___waiting_to_email',$insert);
			}

			if($app->freesessions->enabled==false){
				$app->mailgun->to = 'david@avidbrain.com';
				$app->mailgun->subject = 'Maximum Free Sessions';
				$app->mailgun->message = 'You have reached the maximum free sessions of: $'.numbers($app->freesessions->maximum);
				$app->mailgun->send();
			}

			new Flash(array('action'=>'jump-to','formID'=>'studentsignup','location'=>'/confirmation/student-signup','message'=>'Signup Success'));
		// FINISH

	}
