<?php

	$job = $app->connect->createQueryBuilder()->select('
		jobs.*,
		user.zipcode, user.first_name, user.last_name, user.city, user.state, user.state_long, user.state_slug, user.city_slug, user.url,
		settings.showfullname, settings.getemails
	')->from('avid___jobs','jobs')
		//->where('open IS NOT NULL')
		->andWhere('user.status IS NULL')
		->andWhere('jobs.id = :id')->setParameter('id',$id)
		->leftJoin('jobs', 'avid___user', 'user', 'user.email = jobs.email')
		->leftJoin('jobs', 'avid___user_account_settings', 'settings', 'jobs.email = settings.email')->execute()->fetch();

	if(isset($job->id) && isset($app->user->email)){
		$sql = "SELECT * FROM avid___jobs_applicants WHERE jobid = :id AND email = :email";
		$prepeare = array(':id'=>$id,':email'=>$app->user->email);
		$myapplication = $app->connect->executeQuery($sql,$prepeare)->fetch();
		if(isset($myapplication->id)){
			$job->myapplication = $myapplication;
		}
	}


	if(empty($job->id)){
		$app->redirect('/jobs');
	}

	//notify($job);

	if(isset($job->id)){
		$app->job = $job;
	}

	$app->meta = new stdClass();
	$app->meta->title = $job->subject_name.' Student in '.$job->city.' '.$job->state_long;
	$app->meta->h1 = false;
	$app->meta->keywords = 'jobs,tutoring,avidbrain';
