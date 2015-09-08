<?php	
	
	if(isset($app->user->usertype) && $app->user->usertype=='student'){
		$sql = "SELECT * FROM avid___jobs WHERE email = :email AND open IS NOT NULL ORDER BY applicants DESC";
		$prepeare = array(':email'=>$app->user->email);
		$my_jobs = $app->connect->executeQuery($sql,$prepeare)->fetchAll();
		if(isset($my_jobs[0])){
			$app->my_jobs = $my_jobs;
		}
	
		
	}
	
	if($app->request->isPost()==false){
		$app->searchingforjobs = json_decode($app->getCookie('searchingforjobs'));
		include($app->target->post);
	}
	else{
		
	}
	
	
	if(isset($app->user->usertype) && $app->user->usertype=='student'){
		$sql = "SELECT * FROM avid___contest WHERE email = :email";
		$prepare = array(':email'=>$app->user->email);
		$results = $app->connect->executeQuery($sql,$prepare)->fetch();
		if(isset($results->id)){
			$app->contestApplication = true;
		}
	}
	
		
	$app->meta = new stdClass();
	$app->meta->title = $app->dependents->SITE_NAME_PROPPER.' Jobs';
	$app->meta->h1 = 'Find A Tutoring Job';
	$app->meta->keywords = 'jobs,tutoring,'.$app->dependents->SITE_NAME_PROPPER;