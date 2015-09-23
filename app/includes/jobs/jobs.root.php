<?php
	
	if($app->request->isPost()==false){
		$app->searchingforjobs = json_decode($app->getCookie('searchingforjobs'));
	}
	
	//$app->childen = $childen;
	$navtitle = (object)array('slug'=>'/jobs','text'=>'Jobs');
	$app->navtitle = $navtitle;
	
	if(isset($app->user->usertype) && $app->user->usertype=='student'){
		
	}
	else{
		$app->secondary = $app->target->secondary;
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
	
	
	if(isset($app->user->usertype) && $app->user->usertype=='student'){
		$sql = "SELECT * FROM avid___user_subjects WHERE email = :email";
		$prepare = array(':email'=>$app->user->email);
		$app->import = $app->connect->executeQuery($sql,$prepare)->fetchAll();
		if(isset($app->import[0])){
	
				$childen = array();
				$childen['jobsimport'] = (object) array('name'=>'Import','slug'=>'/jobs/import');
				
				$app->childen = $childen;
				$navtitle = (object)array('slug'=>'/jobs','text'=>'Jobs');
				$app->navtitle = $navtitle;
				
				$app->secondary = $app->target->secondaryNav;
			
		}
	}
	
	
	$app->jobOptions = $jobOptions;