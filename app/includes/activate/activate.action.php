<?php

	if(isset($code)){

		$sql = "SELECT * FROM avid___users_temp WHERE validation_code = :validation_code";
		$prepare = array(':validation_code'=>$code);
		$results = $app->connect->executeQuery($sql,$prepare)->fetch();


		if(isset($results->id)){

			$sql = "SELECT * FROM avid___jobs WHERE email = :email";
			$prepare = array(':email'=>$results->email);
			$jobinfo = $app->connect->executeQuery($sql,$prepare)->fetch();
			if(isset($jobinfo->id)){
				$app->jobinfo = $jobinfo;
			}

			$app->activateprofile = $results;
		}
		else{
			$app->redirect('/');
		}

	}


	$app->meta = new stdClass();
	$app->meta->title = 'Activate Your Account';
	//$app->meta->h1 = 'pageh1';
	//$app->meta->keywords = 'activate ';
	$app->meta->description = 'activate your account';
