<?php
	$sql = "SELECT first_name,last_name,my_avatar,short_description,personal_statement FROM avid___admins WHERE url = :url";
	$prepeare = array(':url'=>$app->request->getPath());
	$results = $app->connect->executeQuery($sql,$prepeare)->fetch();

	if(isset($results->first_name)){
		$app->userinfo = $results;

		$app->meta = new stdClass();
		$app->meta->title = $results->first_name.' '.$results->last_name.' - '.$app->dependents->SITE_NAME_PROPPER.' '.$results->short_description;
		$app->meta->h1 = false;
	}
	else{
		$app->redirect('/staff');
	}
