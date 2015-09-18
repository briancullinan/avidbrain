<?php

	if(isset($app->studentapplication)){
		
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
	elseif(isset($app->signup)){
		
		if($app->signup->password!=$app->signup->password_confirm){
			new Flash(array('action'=>'required','formID'=>'signup','field'=>'field_signup_password_confirm','message'=>"Your password doesn't match <i class='fa fa-lock'></i>"));
		}
		elseif(strlen($app->signup->password) < 6){
			new Flash(array('action'=>'required','message'=>"Passwords must be at least <span>6 characters</span>"));
		}
		elseif(strlen($app->signup->zipcode) != 5){
			new Flash(array('action'=>'required','formID'=>'signup','field'=>'field_signup_zipcode','message'=>"Invalid Zip Code"));
		}
		elseif(strlen($app->signup->phone) > 10){
			new Flash(array('action'=>'required','formID'=>'signup','field'=>'field_signup_phone','message'=>"Phone number must be 10 digits"));
		}
		
		$zipData = get_zipcode_data($app->connect,$app->signup->zipcode);
		
		if($zipData==false){
			new Flash(array('action'=>'required','message'=>"Zip Code Not Valid"));
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
		$validation_code = random_numbers(16);
		
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
			'`long`'=>$zipData->long
		);
		
		if(isset($app->signup->promocode) && $app->signup->promocode=='qa-signup'){
			$prepare['qasignup'] = 1;
		}
		
		if(isset($app->signup->promocode)){
			$sql = "SELECT * FROM avid___promotions WHERE promocode = :promocode";
			$prepare = array(':promocode'=>$app->signup->promocode);
			$isvalidpromo = $app->connect->executeQuery($sql,$prepare)->fetch();
			if(isset($isvalidpromo->id)){
				$app->isvalidpromo = $isvalidpromo;
			}
			
		}
		
		if(isset($app->isvalidpromo) && isset($app->freesessions)){
			
			$insertpromo = array(
				'email'=>$app->signup->email,
				'promocode'=>$app->isvalidpromo->promocode,
				'value'=>$app->isvalidpromo->value,
				'date'=>thedate(),
				'sharedwith'=>$app->isvalidpromo->email,
				'activated'=>1
			);
			
			
			$app->connect->insert('avid___promotions_active',$insertpromo);
			
			$insertpromo = array(
				'email'=>$app->isvalidpromo->email,
				'promocode'=>$app->isvalidpromo->promocode,
				'value'=>$app->isvalidpromo->value,
				'date'=>thedate(),
				'sharedwith'=>$app->signup->email,
				'activated'=>NULL
			);
			
			$app->mailgun->to = $app->isvalidpromo->email;
			$app->mailgun->subject = 'Promo Code Activated';
			$app->mailgun->message = 'A new student has signed up using your promo code.';
			$app->mailgun->send();
			
			$app->connect->insert('avid___promotions_active',$insertpromo);
			
		}
		
		$insert = $app->connect->insert('avid___users_temp',$inserttemp);
		
		// Email User
		// Do Things
		
		$app->mailgun->to = $app->signup->email;
		$app->mailgun->subject = 'Please authenticate your email address';
		$app->mailgun->message = 'Your verification link is: <a href="'.$app->dependents->DOMAIN.'/validate/'.$validation_code.'">Verify Email Address</a>';
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
		
		new Flash(array('action'=>'jump-to','formID'=>'signup','location'=>'/confirmation/student-signup','message'=>'Signup Success'));
		
		
	}