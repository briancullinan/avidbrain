<?php

	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('sessions.id, user.first_name, user.last_name, user.url, user.id, user.account_id, sessions.from_user ')->from('avid___sessions','sessions');
	$data	=	$data->where('sessions.paidout IS NULL AND sessions.session_status IS NOT NULL');
	$data	=	$data->setParameter(':usertype','tutor');
	$data	=	$data->leftJoin('sessions','avid___user_profile','profile','profile.email = sessions.from_user');
	$data	=	$data->leftJoin('sessions','avid___user','user','user.email = sessions.from_user');
	$data	=	$data->groupBy('sessions.from_user');
	$tutorswithsessions	=	$data->execute()->fetchAll();


	if(isset($tutorswithsessions[0])){

		foreach($tutorswithsessions as $key=> $getSum){


			$sql = "SELECT SUM(session_cost) as cost FROM avid___sessions WHERE from_user = :from_user AND paidout IS NULL AND session_status IS NOT NULL";
			$prepare = array(':from_user'=>$getSum->from_user);
			$results = $app->connect->executeQuery($sql,$prepare)->fetch();

			if(isset($results->cost)){
				$tutorswithsessions[$key]->cost = $results->cost;
			}

		}

		$app->tutorswithsessions = $tutorswithsessions;
	}



	if(isset($id)){
		$data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select(everything().',user.*')->from('avid___user','user');
		$data	=	$data->where('user.id = :id')->setParameter(':id',$id);
		$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
		$data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
		$data	=	$data->execute()->fetch();

		if(isset($data->id)){

			$sql = "SELECT * FROM avid___sessions WHERE paidout IS NULL AND from_user = :from_user AND dispute IS NULL AND session_status IS NOT NULL AND session_cost != 0";
			$prepare = array(':from_user'=>$data->email);
			$results = $app->connect->executeQuery($sql,$prepare)->fetchAll();

			$sql = "SELECT * FROM avid___paid_bgchecks WHERE email = :email";
			$prepare = array(':email'=>$data->email);
			$bgcheckrefund = $app->connect->executeQuery($sql,$prepare)->fetchAll();
			$app->bgcheckrefund = $bgcheckrefund;


			if(isset($data->id)){
				$app->paytutor = $data;
				$app->paytutor->sessions = $results;
			}

		}
	}
