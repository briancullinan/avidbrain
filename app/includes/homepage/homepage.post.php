<?php
	
	if(isset($app->userzip)){
		$zipData = get_zipcode_data($app->connect,$app->userzip->zipcode);
		if($zipData==false){
			new Flash(array('action'=>'required','message'=>"Invalid Zip Code"));
		}
		$username = unique_username($app->connect,1);
		
		$app->user->username = $username;
		$app->user->url = update_zipcode($app->user,$zipData);
		
		$app->user->city = $zipData->city;
		$app->user->city_slug = $zipData->city_slug;
		$app->user->zipcode = $zipData->zipcode;
		$app->user->state = $zipData->state;
		$app->user->state_long = $zipData->state_long;
		$app->user->state_slug = $zipData->state_slug;
		
		$app->user->lat = $zipData->lat;
		$app->user->long = $zipData->long;
		$app->user->save();
		
		new Flash(array('action'=>'jump-to','location'=>'/','message'=>'Zip Code Added'));
		
	}
	elseif(isset($app->textnumber->number) && isset($app->user->usertype) && $app->user->usertype=='student'){
		
		$length = strlen($app->textnumber->message);
		
		if($length>160){
			new Flash(array('action'=>'required','formID'=>'potato','message'=>'Message must be less than 160 characters'));
		}
		
		$app->textnumber->number = preg_replace("/[^0-9,.]/", "", $app->textnumber->number);
		if(strlen($app->textnumber->number)!=10){
			new Flash(array('action'=>'required','formID'=>'potato','message'=>'Phone number must be 10 digits'));
		}
		
		$app->textnumber->message = strip_tags($app->textnumber->message);
		
		$app->twilio->account->messages->create(array( 
			'To' => $app->textnumber->number, 
			'From' => "+14803511893", 
			'Body' => $app->textnumber->message
		));
		
		new Flash(array('action'=>'jump-to','location'=>'/','message'=>'Text Message Sent'));
	}