<?php
	if(isset($app->signup)){
		
		if($app->signup->password!=$app->signup->password_confirm){
			new Flash(array('action'=>'required','formID'=>'signup','field'=>'field_signup_password_confirm','message'=>"Your password doesn't match <i class='fa fa-lock'></i>"));
		}
		elseif(strlen($app->signup->password) < 6){
			new Flash(array('action'=>'required','message'=>"Passwords must be at least <span>6 characters</span>"));
		}
		elseif(strlen($app->signup->zipcode) != 5){
			new Flash(array('action'=>'required','formID'=>'signup','field'=>'field_signup_zipcode','message'=>"Invalid Zip Code"));
		}
		elseif(strlen($app->signup->phone) < 10){
			new Flash(array('action'=>'required','formID'=>'signup','field'=>'field_signup_phone','message'=>"Phone number must be 10 digits"));
		}
		
		$zipData = get_zipcode_data($app->connect,$app->signup->zipcode);
		
		if($zipData==false){
			new Flash(array('action'=>'required','message'=>"Zip Code Not Valid"));
		}
		
		$password = password_hash($app->signup->password, PASSWORD_DEFAULT);
		$token = password_hash(uniqid().$app->signup->email.time(),PASSWORD_BCRYPT);
		$newusername = unique_username($app->connect,3);
		
		$myinfo = new stdClass();
		$myinfo->usertype = 'student';
		$myinfo->state_slug = $zipData->state_slug;
		$myinfo->city_slug = $zipData->state_slug;
		$myinfo->username = $newusername;
		
		$insertUser = array(
			'email'=>$app->signup->email,
			'password'=>$password,
			'usertype'=>'student',
			'signup_date'=>thedate(),
			'promocode'=>$app->signup->promocode,
			'first_name'=>$app->signup->first_name,
			'last_name'=>$app->signup->last_name,
			'terms_of_service'=>1,
			'temppass'=>NULL,
			'zipcode'=>$zipData->zipcode,
			'city'=>$zipData->city,
			'state'=>$zipData->state,
			'state_long'=>$zipData->state_long,
			'`lat`'=>$zipData->lat,
			'`long`'=>$zipData->long,
			'sessiontoken'=>$token,
			'username'=>$newusername,
			'url'=>$url = update_zipcode($myinfo,$zipData)
		);
		
		$prepareProfile = array(
			"email"=>$app->signup->email
		);
		
		$makeUser = $app->connect->insert("avid___user",$insertUser);
		$makeProfile = $app->connect->insert("avid___user_profile",$prepareProfile);
		$app->connect->delete('avid___users_temp', array('id'=>$app->activateprofile->id));
		
		$_SESSION['user']['email'] = $app->crypter->encrypt($app->signup->email);
		$_SESSION['user']['sessiontoken'] = $app->crypter->encrypt($token);
		
		new Flash(array('action'=>'jump-to','location'=>'/','message'=>'You are now logged in'));	
		
		
	}
