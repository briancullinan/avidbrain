<?php
	if(isset($app->resetpassword)){
		
		$doesuser = doesuserexist($app->connect,$app->resetpassword->email);
		
		if($doesuser==true){
			$query = "SELECT email FROM avid___user WHERE `email` = :email LIMIT 1";
			$prepare = array(':email'=>$app->resetpassword->email);
			$resetuserpass = $app->connect->executeQuery($query,$prepare)->fetch();
			
			$query = "SELECT email FROM avid___users_temp WHERE `email` = :email LIMIT 1";
			$prepare = array(':email'=>$app->resetpassword->email);
			$resetTemp = $app->connect->executeQuery($query,$prepare)->fetch();
			
			$location = NULL;
			if(isset($resetuserpass->email)){
				$location = 'user';
				$emailuser = $resetuserpass->email;
			}
			elseif(isset($resetTemp->email)){
				$location = 'users_temp';
				$emailuser = $resetTemp->email;
			}
			
			$random_numbers = random_all(rand(8,30));
				
			$query = "SELECT email FROM avid___user_resetpassword WHERE email = :email";
			$prepare = array(':email'=>$app->resetpassword->email);
			$forgotCheck = $app->connect->executeQuery($query,$prepare)->rowCount();
			
			if($forgotCheck > 0){
				$query = "UPDATE avid___user_resetpassword SET date = :date, validation_code = :validation_code, location = :location WHERE email = :email";
				$prepare = array(':email'=>$app->resetpassword->email,':date'=>thedate(),':validation_code'=>$random_numbers,':location'=>$location);
				$update = $app->connect->executeQuery($query,$prepare);
			}
			else{
				$query = "INSERT INTO avid___user_resetpassword SET email = :email, date = :date, validation_code = :validation_code, location = :location";
				$prepare = array(':email'=>$app->resetpassword->email,':date'=>thedate(),':validation_code'=>$random_numbers,':location'=>$location);
				$forgot = $app->connect->executeQuery($query,$prepare);	
			}
	
			
			$app->mailgun->to = $app->resetpassword->email;
			$app->mailgun->subject = $app->dependents->SITE_NAME_PROPPER.' Password Reset';
			$app->mailgun->message = 'Did you forget your password? Click <a href="'.$app->dependents->DOMAIN.'/help/forgot-password/recovery/'.$random_numbers.'">this link</a> to start the recovery process. If you didn\'t forget your password, just ignore this email.';
			$app->mailgun->send();
		}
		
		new Flash(array('action'=>'kill-form','formID'=>'resetpassword','message'=>'Password Reset Email Sent'));
		
	}
