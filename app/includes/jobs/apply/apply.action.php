<?php

	if(isset($app->user->email)){
		$email = $app->user->email;
	}
	else{
		$email = 'xxxxxxx123123123october@avidbrain.com';
	}

	$sql = "
		SELECT
			jobs.*,
			applicants.message,
			applicants.email as myapplication,
			user.first_name,
			user.last_name,
			user.zipcode,
			user.city,
			user.state,
			user.state_long
		FROM
			avid___jobs jobs

		INNER JOIN
			avid___user user on user.email = jobs.email

		LEFT JOIN
			avid___jobs_applicants applicants on applicants.jobid = :id and applicants.email = :myemail

		WHERE
			jobs.id = :id
	";
	$prepare = array(':id'=>$id,':myemail'=>$email);
	$results = $app->connect->executeQuery($sql,$prepare)->fetch();
	//notify($results);

	if(isset($results->id)){
		$app->job = $results;
	}
	else{
		$app->redirect('/jobs');
	}


	$app->meta = new stdClass();
	$app->meta->title = $results->city.' '.ucwords($results->state_long).' '.$results->subject_name.' Student';
	$app->meta->h1 = false;
