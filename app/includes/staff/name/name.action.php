<?php
	
	$sql = "SELECT email FROM avid___admins WHERE url = :url";
	$prepeare = array(':url'=>$app->request->getPath());
	$results = $app->connect->executeQuery($sql,$prepeare)->fetch();
	if(isset($results->email)){
		$app->staff = $results;
	}
	else{
		$app->redirect('/staff');
	}
