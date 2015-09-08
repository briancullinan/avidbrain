<?php
	if(isset($validationcode)){
		$query = "SELECT * FROM avid___user_resetpassword WHERE `validation_code` = :validation_code ";
		$prepare = array(':validation_code'=>$validationcode);
		$results = $app->connect->executeQuery($query,$prepare)->fetch();
		
		$datediff = sessionDateDiff($results->date,thedate());
		
		if($datediff->h>0){
			$delete = true;
		}
		elseif($datediff->i>30){
			$delete = true;
		}
		
		if(isset($delete)){
			unset($results);
			$app->connect->delete('avid___user_resetpassword',array('validation_code'=>$validationcode));
		}
		
		
		if(isset($results->email)){
			$app->recoveryinfo = $results;
		}
		else{
			$app->redirect('/help/forgot-password');
		}
		
	}
	
	
	$app->meta = new stdClass();
	$app->meta->title = 'Change Your Password';
	$app->meta->h1 = 'Password Reset';