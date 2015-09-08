<?php
	
	$sql = "SELECT * FROM avid___help_contactus ORDER BY date DESC";
	$prepare = array();
	$results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
	
	if(isset($results[0])){
		$app->helpme = $results;
	}
	
	$app->meta = new stdClass();
	$app->meta->title = 'Help Requests';