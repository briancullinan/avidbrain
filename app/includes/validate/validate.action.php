<?php
	
	$sql = "SELECT * FROM avid___users_temp WHERE validation_code = :validation_code";
	$prepeare = array(':validation_code'=>$code);
	$validateMe = $app->connect->executeQuery($sql,$prepeare)->fetch();
	
	
	if(isset($validateMe->usertype) && $validateMe->usertype=='student'){
		
		$data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select('waiting.*, settings.getemails')->from('avid___waiting_to_email','waiting');
		$data	=	$data->where('waiting.from_user = :email')->setParameter(':email',$validateMe->email);
		$data	=	$data->innerJoin('waiting','avid___user_account_settings','settings','settings.email = waiting.to_user');
		$data	=	$data->execute()->fetch();
		
		if(isset($data->id)){
			$waiting_to_email = $data;
		
			$subject = 'You have a message from a new student';
			$message = '<p>A new student has signed up, through your profile, after they complete their profile you will be able to view it</p>';
			$message.= '<p>Message from student: '.$waiting_to_email->send_message.'</p>';
			
			
			if(isset($waiting_to_email->getemails) && $waiting_to_email->getemails=='yes'){
				
				$app->mailgun->to = $waiting_to_email->to_user;
				$app->mailgun->subject = $subject;
				$app->mailgun->message = $message;
				$app->mailgun->send();
				
			}
			
			$app->sendmessage->to_user = $waiting_to_email->to_user;
			$app->sendmessage->from_user = $waiting_to_email->from_user;
			$app->sendmessage->location = 'inbox';
			$app->sendmessage->send_date = thedate();
			$app->sendmessage->subject = $subject;
			$app->sendmessage->message = $message;
			$app->sendmessage->newmessage();
		}
		
		$state_slug = string_cleaner($validateMe->state_long);
		$city_slug = string_cleaner($validateMe->city);
		
		$app->setCookie('validation_email',$validateMe->email);
		
		$zipData = get_zipcode_data($app->connect,$validateMe->zipcode);
		$validateMe->username = unique_username($app->connect,1);
		
		$url = update_zipcode($validateMe,$zipData);
		
		
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
			'username'=>$validateMe->username
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
	