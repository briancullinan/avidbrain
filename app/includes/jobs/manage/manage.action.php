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

	$name = 'tutors-near-me'.$app->user->email.'-'.$app->job->subject_slug.'-'.$app->job->id;
	$tutorsnearme = $app->connect->cache->get($name);
	if($tutorsnearme == null) {

		$getDistance = "round(((acos(sin((" . $app->user->lat . "*pi()/180)) * sin((user.lat*pi()/180))+cos((" . $app->user->lat . "*pi()/180)) * cos((user.lat*pi()/180)) * cos(((" .$app->user->long. "- user.long)* pi()/180))))*180/pi())*60*1.1515)";
		$asDistance = ' as distance ';

		$data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select('user.*, profile.hourly_rate, profile.custom_avatar, profile.showmyphotoas, profile.my_avatar')->from('avid___user','user');
		$data	=	$data->where('user.usertype = :usertype AND profile.hourly_rate IS NOT NULL')->setParameter(':usertype','tutor');
		$data	=	$data->addSelect('subjects.subject_name');
		$data	=	$data->innerJoin('user','avid___user_subjects','subjects','user.email = subjects.email');
		$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
		$data	=	$data->andWhere('subjects.subject_name LIKE :subject_name');
		$data	=	$data->andWhere('subjects.status = :verified')->setParameter(':verified','verified');
		$data	=	$data->setParameter(':subject_name',"%".$app->job->subject_name."%");
		$data	=	$data->groupBy('user.email');
		$data	=	$data->setMaxResults(3);
		$data	=	$data->addSelect($getDistance.$asDistance)->setParameter(':distance',50)->having("distance <= :distance");
		$data	=	$data->orderBy($getDistance,'ASC');
		$returnedData	=	$data->execute()->fetchAll();

	    $tutorsnearme = $returnedData;
	    $app->connect->cache->set($name, $returnedData, 3600);
	}

	if(isset($tutorsnearme[0])){
		$app->tutorsnearme = $tutorsnearme;
	}

	if(isset($applicants[0])){
		$job->applicants = $applicants;

		$sql = "SELECT * FROM avid___sessions WHERE jobid = :jobid";
		$prepeare = array(':jobid'=>$job->id);
		$jobsession = $app->connect->executeQuery($sql,$prepeare)->fetch();
		if(isset($jobsession->id)){
			$app->job->session = $jobsession;
		}

	}
