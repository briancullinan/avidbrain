<?php



	if(isset($promocode) && $promocode=='facebook'){
		$openGraph[] = '<meta property="og:url"                content="https://www.avidbrain.com/facebook" />';
		$openGraph[] = '<meta property="og:type"               content="website" />';
		$openGraph[] = '<meta property="og:title"              content="Signup now and get $30 off your first lesson." />';
		$openGraph[] = '<meta property="og:description"        content="Looking for a tutor? Look no further. Signup now with avidbrain and get $30 off your next tutoring session." />';
		$openGraph[] = '<meta property="og:image"              content="https://www.avidbrain.com/images/share/facebookpromo.jpg" />';
		$app->openGraph = $openGraph;

	}

	$app->howitworks = true;

	$app->meta = new stdClass();
	$app->meta->title = $app->dependents->SITE_NAME_PROPPER.' Student Signup';
	$app->meta->h1 = 'Student Signup';
	$app->meta->keywords = 'tutors,students,tutor,jobs';
	$app->meta->description = 'looking for a tutor, signup today and learn anything.';

	// $sql = "SELECT sum(value) as total_activated FROM avid___promotions_active WHERE activated IS NOT NULL";
	// $results = $app->connect->executeQuery($sql,array())->fetch();
	//
	// if($results->total_activated >= $app->freesessions->maximum){
	// 	$app->freesessions->enabled = false;
	// }


	
	/*
	if(isset($promocode) && isset($app->freesessions->enabled) && $app->freesessions->enabled==true){
		$sql = "SELECT * FROM avid___promotions WHERE promocode = :promocode";
		$prepare = array(':promocode'=>$promocode);
		$isvalidpromo = $app->connect->executeQuery($sql,$prepare)->fetch();

		$app->setCookie('promocode',$promocode, '2 days');

		if(isset($isvalidpromo->id)){
			$app->isvalidpromo = $isvalidpromo;
		}
	}
	notify($app->isvalidpromo);
	*/

	$app->meta->h1 = false;
	//$app->wideconent = '<div class="widecontent studentsignup valign-wrapper"> <div class="valign">Student Signup</div> </div>';

	$app->promocode = $promocode;
