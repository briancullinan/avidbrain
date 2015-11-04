<?php

	/*
		state,
		state_long,
		state_slug,
		city,
		city_slug,
		zipcode,
		signup_date,
		phone,
		lat,
		long,
		username,

		hourly_rate,
		travel_distance,
		cancellation_policy,
		cancellation_rate,
		gender,
		short_description,
		personal_statement,
		my_upload,
		my_upload_status,
		online_tutor
	*/


	if(isset($app->tutorsignup->tutor)){

		if(isset($app->tutorsignup->tutor->phone)){
			$app->tutorsignup->tutor->phone = preg_replace("/[^0-9,.]/", "", $app->tutorsignup->tutor->phone);
		}

		if(empty($app->tutorsignup->tutor->first_name)){
			new Flash(array('action'=>'required','message'=>'First Name Required','formID'=>'tutorsignup','field'=>'ts_first_name'));
		}
		elseif(empty($app->tutorsignup->tutor->last_name)){
			new Flash(array('action'=>'required','message'=>'Last Name Required','formID'=>'tutorsignup','field'=>'ts_last_name'));
		}
		elseif(empty($app->tutorsignup->tutor->email)){
			new Flash(array('action'=>'required','message'=>'Email Address Required','formID'=>'tutorsignup','field'=>'ts_email'));
		}
		elseif(doesuserexist($app->connect,$app->tutorsignup->tutor->email)==true){
			new Flash(array('action'=>'required','message'=>'Email address already used to signup','formID'=>'tutorsignup','field'=>'ts_email'));
		}
		elseif(empty($app->tutorsignup->tutor->phone)){
			new Flash(array('action'=>'required','message'=>'Telephone Number Required','formID'=>'tutorsignup','field'=>'ts_phone'));
		}
		elseif(empty($app->tutorsignup->tutor->phone)){
			new Flash(array('action'=>'required','message'=>'Telephone Number Required','formID'=>'tutorsignup','field'=>'ts_phone'));
		}
		elseif(strlen($app->tutorsignup->tutor->phone)!=10){
			new Flash(array('action'=>'required','message'=>'Telephone Number Must Be 10 Digits','formID'=>'tutorsignup','field'=>'ts_phone'));
		}
		elseif(empty($app->tutorsignup->tutor->password)){
			new Flash(array('action'=>'required','message'=>'Password Required','formID'=>'tutorsignup','field'=>'ts_password'));
		}
		elseif(strlen($app->tutorsignup->tutor->password) < 6){
			new Flash(array('action'=>'required','message'=>'Password must be at least 6 characters','formID'=>'tutorsignup','field'=>'ts_password'));
		}
		elseif(empty($app->tutorsignup->tutor->reasons)){
			new Flash(array('action'=>'required','message'=>'Why do you want to be a tutor?','formID'=>'tutorsignup','field'=>'ts_reasons'));
		}
		elseif(empty($app->tutorsignup->tutor->agerestrictions)){
			new Flash(array('action'=>'required','message'=>'Please verify your age','formID'=>'tutorsignup','field'=>'ts_agerestrictions'));
		}
		elseif(empty($app->tutorsignup->tutor->legalresident)){
			new Flash(array('action'=>'required','message'=>'Please verify your U.S. Work Status','formID'=>'tutorsignup','field'=>'ts_legalresident'));
		}

		$query = "SELECT email FROM signup_avidbrain.signup___signups WHERE email = :email ";
		$prepare = array(':email'=>$app->tutorsignup->tutor->email);
		$signupcount = $app->connect->executeQuery($query,$prepare)->rowCount();
		if($signupcount>0){
			new Flash(array('action'=>'required','message'=>'Email address already used to signup','formID'=>'tutorsignup','field'=>'ts_email'));
		}

		$password = password_hash($app->tutorsignup->tutor->password, PASSWORD_BCRYPT);
		$tutoredbefore = NULL;
		if(isset($app->tutorsignup->tutor->taughttutored) && $app->tutorsignup->tutor->taughttutored=='on'){
			$tutoredbefore = true;
		}

		$token = password_hash(uniqid().$app->tutorsignup->tutor->email.time(),PASSWORD_BCRYPT);

		$prepare = array(
			'usertype'=>'tutor',
			'first_name'=>$app->tutorsignup->tutor->first_name,
			'last_name'=>$app->tutorsignup->tutor->last_name,
			'email'=>$app->tutorsignup->tutor->email,
			'promocode'=>$app->tutorsignup->tutor->promocode,
			'whytutor'=>$app->tutorsignup->tutor->reasons,
			'signupdate'=>thedate(),
			'phone'=>$app->tutorsignup->tutor->phone,
			'password'=>$password,
			'over18'=>true,
			'legalresident'=>true,
			'tutoredbefore'=>$tutoredbefore,
			'linkedinprofile'=>$app->tutorsignup->tutor->linkedinprofile,
			'howdidyouhear'=>$app->tutorsignup->tutor->howdidyouhear,
			'token'=>$token
		);

		$insert = $app->connect->insert('avid___new_temps',$prepare);

		$_SESSION['temptutor']['email'] = $app->crypter->encrypt($app->tutorsignup->tutor->email);
		$_SESSION['temptutor']['token'] = $app->crypter->encrypt($token);

		new Flash(array('action'=>'jump-to','formID'=>'tutorsignup','location'=>'/signup/tutor','message'=>'Step 1 Complete'));

	}
	elseif(isset($app->li)){
		if(empty($app->li->email)){
			new Flash(array('action'=>'required','message'=>'Email Address Required','formID'=>'signuplogin','field'=>'li_email'));
		}
		elseif(empty($app->li->password)){
			new Flash(array('action'=>'required','message'=>'Password Required','formID'=>'signuplogin','field'=>'li_password'));
		}

		// Check to see if the user exists
		$sql = "SELECT * FROM avid___new_temps WHERE email = :email";
		$prepare = array(':email'=>$app->li->email);
		$results = $app->connect->executeQuery($sql,$prepare)->fetch();

		if(isset($results->id) && password_verify($app->li->password,$results->password)){
			$token = password_hash(uniqid().$results->email.time(),PASSWORD_BCRYPT);
			$_SESSION['temptutor']['email'] = $app->crypter->encrypt($results->email);
			$_SESSION['temptutor']['token'] = $app->crypter->encrypt($token);

			$app->connect->update('avid___new_temps',array('token'=>$token),array('email'=>$results->email));

			new Flash(array('action'=>'jump-to','formID'=>'signuplogin','location'=>'/signup/tutor','message'=>'You are now logged in'));
		}
		else{
			new Flash(array('action'=>'required','message'=>'Invalid Password','formID'=>'signuplogin','field'=>'li_password'));
		}
	}
	elseif(isset($app->aboutme)){

		if(isset($app->aboutme->zipcode)){
			$zipcode = get_zipcode_data($app->connect,$app->aboutme->zipcode);
		}
		if(isset($app->aboutme->hourly_rate)){
			$app->aboutme->hourly_rate = preg_replace("/[^0-9]/","",$app->aboutme->hourly_rate);
		}

		if(empty($app->aboutme->zipcode)){
			new Flash(array('action'=>'required','message'=>'Zip Code Required','formID'=>'aboutme','field'=>'aboutme_zipcode'));
		}
		elseif(empty($zipcode->id)){
			new Flash(array('action'=>'required','message'=>'Invalid Zip Code','formID'=>'aboutme','field'=>'aboutme_zipcode'));
		}
		elseif(empty($app->aboutme->short_description)){
			new Flash(array('action'=>'required','message'=>'Short Description Required','formID'=>'aboutme','field'=>'aboutme_short_description'));
		}
		elseif(empty($app->aboutme->personal_statement)){
			new Flash(array('action'=>'required','message'=>'Personal Statement Required','formID'=>'aboutme','field'=>'aboutme_personal_statement'));
		}
		elseif(empty($app->aboutme->hourly_rate)){
			new Flash(array('action'=>'required','message'=>'Houlry Rate Required','formID'=>'aboutme','field'=>'aboutme_hourly_rate'));
		}
		elseif(!is_numeric($app->aboutme->hourly_rate)){
			new Flash(array('action'=>'required','message'=>'Invalid Number','formID'=>'aboutme','field'=>'aboutme_hourly_rate'));
		}

		$updateaboutme = array(
			'zipcode'=>$app->aboutme->zipcode,
			'short_description'=>$app->aboutme->short_description,
			'personal_statement'=>$app->aboutme->personal_statement,
			'hourly_rate'=>$app->aboutme->hourly_rate,
			'gender'=>$app->aboutme->gender
		);

		$app->connect->update('avid___new_temps',$updateaboutme,array('email'=>$app->newtutor->email));

		new Flash(array('action'=>'alert','message'=>'About Me Saved'));

	}
	elseif(isset($app->tutoringinfo)){
		notify($app->tutoringinfo);
	}
	elseif(isset($app->xxx)){
		notify($app->xxx);
	}
	elseif(isset($app->xxx)){
		notify($app->xxx);
	}
	elseif(isset($app->xxx)){
		notify($app->xxx);
	}
	else{
		notify($app->keyname);
	}
