<?php
	if(isset($app->authenticate->dualauth)){
		
		$sql = "SELECT * FROM avid___admins WHERE email = :email AND `dual` = :dual";
		$prepeare = array(':email'=>$app->dualauthemail,':dual'=>$app->authenticate->dualauth);
		$results = $app->connect->executeQuery($sql,$prepeare)->fetch();
		
		$app->deleteCookie('dualauth');
		
		if(isset($results->id)){
			
			$token = password_hash(uniqid().$app->dualauthemail.time(),PASSWORD_BCRYPT);
			
			$sql = "UPDATE avid___admins SET `sessiontoken` = :sessiontoken, `dual` = NULL WHERE `email` = :email AND `dual` = :dual";
			$prepeare = array(
				':email'=>$app->dualauthemail,
				':dual'=>$app->authenticate->dualauth,
				':sessiontoken'=>$token
			);
			$results = $app->connect->executeQuery($sql,$prepeare);
			
			$_SESSION['user']['email'] = $app->crypter->encrypt($app->dualauthemail);
			$_SESSION['user']['sessiontoken'] = $app->crypter->encrypt($token);
			
			$app->redirect('/');
			
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
