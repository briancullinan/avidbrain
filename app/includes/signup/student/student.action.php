<?php
	
	$app->howitworks = true;
	
	$app->meta = new stdClass();
	$app->meta->title = $app->dependents->SITE_NAME_PROPPER.' Student Signup';
	$app->meta->h1 = 'Student Signup';
	$app->meta->keywords = 'tutors,students,tutor,jobs';
	$app->meta->description = 'looking for a tutor, signup today and learn anything.';

	
	$sql = "SELECT sum(value) as total_activated FROM avid___promotions_active WHERE activated IS NOT NULL";
	$results = $app->connect->executeQuery($sql,array())->fetch();
	
	if($results->total_activated >= $app->freesessions->maximum){
		$app->freesessions->enabled = false;
	}

	if(isset($promocode) && isset($app->freesessions->enabled) && $app->freesessions->enabled==true){	
		$sql = "SELECT * FROM avid___promotions WHERE promocode = :promocode";
		$prepare = array(':promocode'=>$promocode);
		$isvalidpromo = $app->connect->executeQuery($sql,$prepare)->fetch();
		if(isset($isvalidpromo->id)){
			$app->isvalidpromo = $isvalidpromo;
		}
	}