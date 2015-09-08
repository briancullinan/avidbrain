<?php
	if(isset($app->authenticate->dualauth)){
		
		$sql = "SELECT * FROM avid___admins WHERE email = :email AND `dual` = :dual";
		$prepeare = array(':email'=>$app->dualauthemail,':dual'=>$app->authenticate->dualauth);
		$authenticate = $app->connect->executeQuery($sql,$prepeare)->fetch();
		
		$app->deleteCookie('dualauth');
		
		if(isset($authenticate->id)){
			
			$token = password_hash(uniqid().$app->dualauthemail.time(),PASSWORD_BCRYPT);
			
			$sql = "UPDATE avid___admins SET `sessiontoken` = :sessiontoken, `dual` = NULL WHERE `email` = :email AND `dual` = :dual";
			$prepeare = array(
				':email'=>$app->dualauthemail,
				':dual'=>$app->authenticate->dualauth,
				':sessiontoken'=>$token
			);
			$results = $app->connect->executeQuery($sql,$prepeare);
			
			$email = $app->crypter->encrypt($authenticate->email);
			$_SESSION['user']['email'] = $email;
			$sessiontoken = $app->crypter->encrypt($token);
			$_SESSION['user']['sessiontoken'] = $sessiontoken;
			
			
			$sql = "UPDATE avid___admins SET login_attempt = 0 WHERE email=:email";
			$prepeare = array(':email'=>$authenticate->email);
			$app->connect->executeQuery($sql,$prepeare);
			
			new Flash(array('action'=>'jump-to','location'=>'http://qa.avidbrain.dev/login.php?one='.$email.'&two='.$sessiontoken,'message'=>'You are now logged in'));
			
			
		}
		else{
			
			$sql = "UPDATE avid___admins SET `sessiontoken` = NULL, `dual` = NULL WHERE `email` = :email";
			$prepeare = array(
				':email'=>$app->dualauthemail,
				':dual'=>$app->authenticate->dualauth
			);
			$results = $app->connect->executeQuery($sql,$prepeare);
			
			$app->redirect('/login');
			
		}
		
		
	}
