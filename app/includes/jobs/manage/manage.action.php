<?php

	$sql = "
		SELECT
			*
		FROM
			avid___jobs jobs
		WHERE
			email = :email
	";
	$prepare = array(':email'=>$app->user->email);
	$results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
	if(isset($results[0])){
		$app->myJobs = $results;
	}


	$jobOptions = array();
	$jobOptions['type'] = (object)array(
		'No Preference'=>'both',
		'Online'=>'online',
		'In Person'=>'offline'
	);
	$jobOptions['skill_level'] = (object)array(
		'Novice','Advanced Beginner','Competent','Proficient','Expert'
	);
	$app->jobOptions = $jobOptions;


	$sql = "
		SELECT
			jobs.*,
			(
                SELECT count(applicants.id) FROM avid___jobs_applicants applicants WHERE applicants.jobid = jobs.id
            ) as applicants
		FROM
			avid___jobs jobs
		WHERE
			jobs.id = :id
				AND
			jobs.email = :myemail
	";
	$prepare = array(
		':id'=>$id,
		':myemail'=>$app->user->email
	);
	$results = $app->connect->executeQuery($sql,$prepare)->fetch();
	if(isset($results->id)){
		$app->thejob = $results;
	}
	else{
		$app->redirect('/jobs');
	}


	if(isset($results->applicants) && $results->applicants > 0){
		$sql = "
			SELECT
				applicants.*,
				user.url,
				user.first_name
			FROM
				avid___jobs_applicants applicants

			INNER JOIN
				avid___user user on user.email = applicants.email

			WHERE
				applicants.jobid = :id
		";
		$prepare = array(':id'=>$id);
		$applicants = $app->connect->executeQuery($sql,$prepare)->fetchAll();

		if(isset($applicants[0])){
			$app->thejob->applicants = $applicants;
		}
	}
