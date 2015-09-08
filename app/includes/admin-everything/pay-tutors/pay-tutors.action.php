<?php
	
	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('sessions.from_user, user.first_name, user.last_name, user.url, user.id')->from('avid___sessions','sessions');
	$data	=	$data->where('sessions.paidout IS NULL AND sessions.session_status = "complete"');
	$data	=	$data->innerJoin('sessions','avid___user_profile','profile','profile.email = sessions.from_user');
	$data	=	$data->innerJoin('sessions','avid___user','user','user.email = sessions.from_user');
	$data	=	$data->groupBy('sessions.from_user');
	$tutorswithsessions	=	$data->execute()->fetchAll();
	if(isset($tutorswithsessions[0])){
		$app->tutorswithsessions = $tutorswithsessions;
	}



	if(isset($id)){
		$data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select(everything().',user.*')->from('avid___user','user');
		$data	=	$data->where('user.id = :id')->setParameter(':id',$id);
		$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
		$data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
		$data	=	$data->execute()->fetch();
		
		$sql = "SELECT * FROM avid___sessions WHERE paidout IS NULL AND from_user = :from_user AND dispute IS NULL AND session_status IS NOT NULL AND session_cost != 0";
		$prepare = array(':from_user'=>$data->email);
		$results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
		
		if(isset($data->id)){
			$app->paytutor = $data;
			$app->paytutor->sessions = $results;
		}
	}