<?php

	// STAFF
	if(isset($user)){
		$sql = "SELECT first_name,last_name,my_avatar,short_description,personal_statement FROM avid___admins WHERE url = :url";
		$prepeare = array(':url'=>'/staff/'.$user);
		$results = $app->connect->executeQuery($sql,$prepeare)->fetch();

		if(isset($results->first_name)){
			$app->userinfo = $results;

			$app->meta = new stdClass();
			$app->meta->title = $results->first_name.' '.$results->last_name.' - '.SITENAME_PROPPER.' '.$results->short_description;
			$app->meta->h1 = false;
		}
		else{
			$app->redirect('/staff');
		}
	}
	else{
		$app->redirect('/staff');
	}
