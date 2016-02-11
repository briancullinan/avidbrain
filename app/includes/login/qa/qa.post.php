<?php

	if(isset($app->login)){

		$authenticate = new Authenticate($app->connect);
		$authenticate->email = $app->login->email;
		$authenticate->password = $app->login->password;
		$authenticate->authenticate();

		if(isset($authenticate->admins) && isset($authenticate->authenticate)){

			$app->twilio->account->messages->create(array(
				'To' => $authenticate->phone,
				'From' => TWILIO_NUMBER,
				'Body' => 'Your authentication code is: '.$authenticate->code
			));

			#$app->mailgun->to = $authenticate->phone;
			#$app->mailgun->subject = 'Authenticate';
			#$app->mailgun->message = 'Code: '.$authenticate->code;
			#$app->mailgun->send();

			setcookie("dualauth", $app->crypter->encrypt($app->login->email), time()+3600);

			new Flash(array('action'=>'jump-to','location'=>'/login/authenticate','formID'=>'login','message'=>'Dual Authentication Required'));

		}

		if(isset($authenticate->lock)){
			new Flash(array('action'=>'required','formID'=>'login','message'=>'Your Account Is Locked <i class="fa fa-lock"></i>'));
		}

		$sql = "SELECT login_attempt, login_attempt_date FROM ".$authenticate->table." WHERE email = :email";
		$prepare = array(':email'=>$app->login->email);
		$howmany = $app->connect->executeQuery($sql,$prepare)->fetch();

		if(isset($howmany->login_attempt)){
			$start_date = new DateTime($howmany->login_attempt_date);
			$since_start = $start_date->diff(new DateTime(thedate()));
			$minutes = $since_start->days * 24 * 60;
			$minutes += $since_start->h * 60;
			$minutes += $since_start->i;
			$left = 6 - $minutes;

			if($howmany->login_attempt >= 5 && $minutes <= 5){
				new Flash(array('action'=>'required','formID'=>'login','message'=>'You Are Locked Out. Please Wait: <span>'.$left.' Minutes</span>'));
			}
		}



		if(isset($authenticate->authenticate)){

			if($validation_email = $app->getCookie('validation_email')){
				$app->deleteCookie('validation_email');
			}

			$email = $app->crypter->encrypt($authenticate->email);
			$_SESSION['user']['email'] = $email;
			$sessiontoken = $app->crypter->encrypt($authenticate->sessiontoken);
			$_SESSION['user']['sessiontoken'] = $sessiontoken;


			$sql = "UPDATE ".$authenticate->table." SET login_attempt = 0 WHERE email=:email";
			$prepeare = array(':email'=>$app->login->email);
			$app->connect->executeQuery($sql,$prepeare);

			new Flash(array('action'=>'jump-to','location'=>socialQa.'/login.php?one='.$email.'&two='.$sessiontoken,'message'=>'You are now logged in'));

		}
		else{

			if(isset($howmany->login_attempt)){
				$sql = "UPDATE ".$authenticate->table." SET login_attempt = login_attempt + 1, login_attempt_date = :login_attempt_date WHERE email = :email";
				$prepare = array(':email'=>$app->login->email,':login_attempt_date'=>thedate());
				$update = $app->connect->executeQuery($sql,$prepare);
			}

			new Flash(array('action'=>'required','formID'=>'login','message'=>'Invalid Password <i class="fa fa-lock"></i>'));

		}

	}
