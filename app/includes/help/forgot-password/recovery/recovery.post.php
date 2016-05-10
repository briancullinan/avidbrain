<?php
	if(isset($app->passwordrecoverycenter)){

		if($app->passwordrecoverycenter->password!=$app->passwordrecoverycenter->password_confirm){
			new Flash(array('action'=>'required','formID'=>'signup','field'=>'field_signup_password_confirm','message'=>"Your password doesn't match <i class='fa fa-lock'></i>"));
		}
		elseif(strlen($app->passwordrecoverycenter->password) < 6){
			new Flash(array('action'=>'required','message'=>"Passwords must be at least <span>6 characters</span>"));
		}

		$password = password_hash($app->passwordrecoverycenter->password, PASSWORD_BCRYPT);

		if(isset($app->recoveryinfo->location) && $app->recoveryinfo->location=='temptutor'){
			$query = "UPDATE avid___new_temps SET password = :password WHERE `email` = :email ";
			$prepare = array(':password'=>$password,':email'=>$app->recoveryinfo->email);
			$results = $app->connect->executeQuery($query,$prepare);
			$location = '/signup/tutor';
		}else{
	
			//look for the password in the admin table.
			$sql = 'SELECT email FROM avid___admins WHERE email = :email LIMIT 1';
			$prepeare = array(':email'=>$app->recoveryinfo->email);
			$results2 = $app->connect->executeQuery($sql,$prepeare)->fetch();

			//if you find this user in the admin table then update the admin table with the new password.
			if(isset($results2->email) && $app->recoveryinfo->email==$results2->email){

					$query = "UPDATE avid___admins SET password = :password WHERE `email` = :email ";
					$prepare = array(':password'=>$password,':email'=>$app->recoveryinfo->email);
					$results = $app->connect->executeQuery($query,$prepare);
					$location = '/login';
				}
				else{

					$query = "UPDATE avid___user SET password = :password WHERE `email` = :email ";
					$prepare = array(':password'=>$password,':email'=>$app->recoveryinfo->email);
					$results = $app->connect->executeQuery($query,$prepare);
					$location = '/login';
				}
		}

		$query = "DELETE FROM avid___user_resetpassword WHERE `email` = :email ";
		$prepare = array(':email'=>$app->recoveryinfo->email);
		$delete = $app->connect->executeQuery($query,$prepare);


		new Flash(array('action'=>'jump-to','formID'=>'passwordrecoverycenter','location'=>$location,'message'=>'Password Changed'));

	}
