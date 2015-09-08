<?php
	if(isset($app->passwordrecoverycenter)){
		
		if($app->passwordrecoverycenter->password!=$app->passwordrecoverycenter->password_confirm){
			new Flash(array('action'=>'required','formID'=>'signup','field'=>'field_signup_password_confirm','message'=>"Your password doesn't match <i class='fa fa-lock'></i>"));
		}
		elseif(strlen($app->passwordrecoverycenter->password) < 6){
			new Flash(array('action'=>'required','message'=>"Passwords must be at least <span>6 characters</span>"));
		}
		
		$password = password_hash($app->passwordrecoverycenter->password, PASSWORD_BCRYPT);
		$query = "UPDATE avid___user SET password = :password WHERE `email` = :email ";
		$prepare = array(':password'=>$password,':email'=>$app->recoveryinfo->email);
		$results = $app->connect->executeQuery($query,$prepare);
		
		$query = "DELETE FROM avid___user_resetpassword WHERE `email` = :email ";
		$prepare = array(':email'=>$app->recoveryinfo->email);
		$delete = $app->connect->executeQuery($query,$prepare);
		
		
		new Flash(array('action'=>'jump-to','formID'=>'passwordrecoverycenter','location'=>'/login','message'=>'Password Changed'));
		
	}