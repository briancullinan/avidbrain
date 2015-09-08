<?php
	
	$app->howitworks = true;
	
	$app->meta = new stdClass();
	$app->meta->title = $app->dependents->SITE_NAME_PROPPER.' Student Signup';
	$app->meta->h1 = 'Student Signup';
	$app->meta->keywords = 'tutors,students,tutor,jobs';
	$app->meta->description = 'looking for a tutor, signup today and learn anything.';


	if(isset($promocode)){	
		$sql = "SELECT * FROM avid___promotions WHERE promocode = :promocode";
		$prepare = array(':promocode'=>$promocode);
		$isvalidpromo = $app->connect->executeQuery($sql,$prepare)->fetch();
		if(isset($isvalidpromo->id)){
			$app->isvalidpromo = $isvalidpromo;
		}
	}