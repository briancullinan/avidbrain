<?php
	
	$job = $app->connect->createQueryBuilder()->select('
		jobs.*,
		user.zipcode, user.first_name, user.last_name, user.city, user.state, user.state_long, user.state_slug, user.city_slug, user.url,
		settings.showfullname, settings.getemails
	')->from('avid___jobs','jobs')
		->where('user.email = :email')->setParameter('email',$app->user->email)
		->andWhere('jobs.id = :id')->setParameter('id',$id)
		->innerJoin('jobs', 'avid___user', 'user', 'user.email = jobs.email')
		->innerJoin('jobs', 'avid___user_account_settings', 'settings', 'jobs.email = settings.email')->execute()->fetch();
		
	if(empty($job->id)){
		$app->redirect('/jobs');
	}
	
	if(isset($job->id)){
		$app->job = $job;
	}
		
	if(isset($job->id)){
		$applicants = $app->connect->createQueryBuilder()->select('applicants.*, user.first_name, user.last_name, user.url, user.zipcode, settings.showfullname, settings.getemails, profile.hourly_rate')->from('avid___jobs_applicants','applicants')->where('jobid = :jobid')->setParameter(':jobid',$id)
						->innerJoin('applicants', 'avid___user_profile', 'profile', 'applicants.email = profile.email')
						->innerJoin('applicants', 'avid___user', 'user', 'applicants.email = user.email')
						->innerJoin('applicants', 'avid___user_account_settings', 'settings', 'applicants.email = settings.email')
						->execute()->fetchAll();
	}
		
	
	//notify($job);
					
	if(isset($applicants[0])){
		$job->applicants = $applicants;
		
		$sql = "SELECT * FROM avid___sessions WHERE jobid = :jobid";
		$prepeare = array(':jobid'=>$job->id);
		$jobsession = $app->connect->executeQuery($sql,$prepeare)->fetch();
		if(isset($jobsession->id)){
			$app->job->session = $jobsession;
		}
		
	}
	
	//notify($job);
	
	
