<?php

	$sql = "SELECT * FROM avid___users_temp WHERE validation_code = :validation_code";
	$prepeare = array(':validation_code'=>$code);
	$validateMe = $app->connect->executeQuery($sql,$prepeare)->fetch();


	if(isset($validateMe->usertype) && $validateMe->usertype=='student'){

		$state_slug = string_cleaner($validateMe->state_long);
		$city_slug = string_cleaner($validateMe->city);

		$app->setCookie('validation_email',$validateMe->email);

		$zipData = get_zipcode_data($app->connect,$validateMe->zipcode);
		$validateMe->username = unique_username($app->connect,1);

		$url = update_zipcode($validateMe,$zipData);

		$phone = NULL;
		if(isset($validateMe->phone)){
			$phone = $validateMe->phone;
		}

		$prepareUser = array(
			"email"=>$validateMe->email,
			"password"=>$validateMe->password,
			"usertype"=>$validateMe->usertype,
			"signup_date"=>$validateMe->signup_date,
			"promocode"=>$validateMe->promocode,
			"first_name"=>$validateMe->first_name,
			"last_name"=>$validateMe->last_name,
			"terms_of_service"=>1,
			"parent"=>$validateMe->parent,
			"zipcode"=>$validateMe->zipcode,
			"city"=>$validateMe->city,
			"city_slug"=>$city_slug,
			"state"=>$validateMe->state,
			"state_slug"=>$state_slug,
			"state_long"=>$validateMe->state_long,
			"lat"=>$validateMe->lat,
			"`long`"=>$validateMe->long,
			'url'=>$url,
			'username'=>$validateMe->username,
			'phone'=>$phone
		);

		if(isset($validateMe->qasignup)){
			$prepareUser['qasignup'] = 1;
		}

		$prepareProfile = array(
			"email"=>$validateMe->email
		);

		$makeUser = $app->connect->insert(PREFIX."user",$prepareUser);
		$makeProfile = $app->connect->insert(PREFIX."user_profile",$prepareProfile);
		$app->connect->delete(PREFIX.'users_temp', array('email' => $validateMe->email));

		$app->redirect('/login');

	}
	elseif(isset($validateMe->usertype) && $validateMe->usertype=='tutor'){

		$app->setCookie('validation_email',$validateMe->email);

		$prepareUser = array(
			"email"=>$validateMe->email,
			"password"=>$validateMe->password,
			"usertype"=>$validateMe->usertype,
			"signup_date"=>$validateMe->signup_date,
			"promocode"=>$validateMe->promocode,
			"first_name"=>$validateMe->first_name,
			"last_name"=>$validateMe->last_name,
			"terms_of_service"=>1,
			"parent"=>$validateMe->parent
		);

		$prepareProfile = array(
			"email"=>$validateMe->email
		);

		$makeUser = $app->connect->insert(PREFIX."user",$prepareUser);
		$makeProfile = $app->connect->insert(PREFIX."user_profile",$prepareProfile);
		$app->connect->delete(PREFIX.'users_temp', array('email' => $validateMe->email));

		$app->redirect('/login');

	}
	else{
		$app->redirect('/');
	}
