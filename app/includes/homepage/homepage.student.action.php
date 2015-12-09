<?php

	// $data	=	$app->connect->createQueryBuilder();
	// $data	=	$data->select('user.id,user.username,user.promocode,user.first_name,user.last_name,'.everything())->from('avid___user','user');
	// $data	=	$data->where('user.email = :email');
	// $data	=	$data->setParameter(':email',$app->user->promocode);
	// $data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
	// $data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
	// $promocodeTutors	=	$data->execute()->fetchAll();
	//
	// $data	=	$app->connect->createQueryBuilder();
	// $data	=	$data->select('sessions.id,'.everything())->from('avid___sessions','sessions');
	// $data	=	$data->where('sessions.to_user = :email AND user.email != :mypromocode')->setParameter(':email',$app->user->email)->setParameter(':mypromocode',$app->user->promocode);
	// $data	=	$data->innerJoin('sessions','avid___user','user','sessions.from_user = user.email');
	// $data	=	$data->innerJoin('sessions','avid___user_profile','profile','sessions.from_user = profile.email');
	// $data	=	$data->innerJoin('sessions','avid___user_account_settings','settings','sessions.from_user = settings.email');
	// $data	=	$data->groupBy('user.email');
	// $sessionTutors	=	$data->execute()->fetchAll();
	//
	// $mytutors = array();
	// if(isset($promocodeTutors[0])){
	// 	$mytutors = $promocodeTutors;
	// }
	// if(isset($sessionTutors[0])){
	// 	$mytutors = array_merge($mytutors, $sessionTutors);
	// }
	// foreach($mytutors as $key => $cleanup){
	// 	if(empty($cleanup->id)){
	// 		unset($mytutors[$key]);
	// 	}
	// }
	// if(isset($mytutors[0])){
	// 	$app->mytutors = $mytutors;
	// }


		$sql = "
			SELECT
				approved.tutor_email,
				user.first_name,
				user.last_name,
				user.url
			FROM
				avid___approved_tutors approved

			INNER JOIN
				avid___user user on user.email = approved.tutor_email

			WHERE
				approved.student_email = :student_email
		";
		$prepare = array(':student_email'=>$app->user->email);
		$mytutors = $app->connect->executeQuery($sql,$prepare)->fetchAll();

		if(isset($mytutors[0])){
			$app->mytutors = $mytutors;
		}


	if(isset($app->user->usertype) && $app->user->usertype=='student'){
		$sql = "SELECT id FROM avid___jobs WHERE email = :email AND open IS NOT NULL ORDER BY applicants DESC";
		$prepeare = array(':email'=>$app->user->email);
		$my_jobs = $app->connect->executeQuery($sql,$prepeare)->rowCount();
		if($my_jobs>0){
			$app->my_jobs = $my_jobs;
		}
	}

	// Check for sessions without reviews
	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('sessions.*, user.first_name,user.last_name,user.url')->from('avid___sessions','sessions');
	$data	=	$data->where('sessions.to_user = :myemail AND sessions.session_status = "complete" AND sessions.review_name IS NULL')->setParameter(':myemail',$app->user->email);
	$data	=	$data->innerJoin('sessions','avid___user','user','user.email = sessions.from_user');
	$data	=	$data->execute()->fetchAll();
	//printer($data);
	if(isset($data[0])){
		$app->needsreview = $data;
	}
