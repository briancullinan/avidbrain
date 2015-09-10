<?php
	if(isset($app->resetpassword)){
		
		$sql = "SELECT * FROM avid___users_temp WHERE email = :email";
		$prepare = array(':email'=>$app->resetpassword->email);
		$tempuser = $app->connect->executeQuery($sql,$prepare)->fetch();
		
		if(isset($tempuser->id)){
			$app->mailgun->to = $tempuser->email;
			$app->mailgun->subject = 'Please authenticate your email address';
			$app->mailgun->message = 'Your verification link is: <a href="'.$app->dependents->DOMAIN.'/validate/'.$tempuser->validation_code.'">Verify Email Address</a>';
			$app->mailgun->send();
			
			new Flash(
				array(
					'action'=>'kill-form',
					'message'=>'Email Sent',
					'formID'=>'resetpassword'
				)
			);
			
		}
		else{
			notify($app->dependents->SITE_NAME_PROPPER);
		}
		
	}
