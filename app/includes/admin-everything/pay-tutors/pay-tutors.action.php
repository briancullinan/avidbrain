<?php

	// $data	=	$app->connect->createQueryBuilder();
	// $data	=	$data->select('sessions.id, user.first_name, user.last_name, user.url, user.id, user.account_id, sessions.from_user ')->from('avid___sessions','sessions');
	// $data	=	$data->where('sessions.paidout IS NULL AND sessions.session_status IS NOT NULL AND sessions.session_cost IS NOT NULL  AND from_user NOT LIKE "%---fraud%"');
	// $data	=	$data->setParameter(':usertype','tutor');
	// $data	=	$data->leftJoin('sessions','avid___user_profile','profile','profile.email = sessions.from_user');
	// $data	=	$data->leftJoin('sessions','avid___user','user','user.email = sessions.from_user');
	// $data	=	$data->groupBy('sessions.from_user');
	// $tutorswithsessions	=	$data->execute()->fetchAll();
	//notify($tutorswithsessions);

	$sql = "
		SELECT
			sessions.from_user as email,
			user.first_name,
			user.last_name,
			user.url,
			user.id,
			user.account_id,
			SUM(sessions.session_cost) as cost
		FROM
			avid___sessions sessions

		LEFT JOIN

			avid___user user on user.email = sessions.from_user

		WHERE
			sessions.paidout IS NULL
				AND
			sessions.session_status IS NOT NULL
				AND
			sessions.session_cost IS NOT NULL
				AND
			sessions.from_user NOT LIKE '%-fraud%'

		GROUP BY sessions.from_user
	";
	$prepare = array(

	);
	$results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
	if(isset($results[0])){
		$app->tutorswithsessions = $results;
		$cost = [];
		foreach($app->tutorswithsessions as $adding){
			$cost[] = $adding->cost;
		}
		$app->totalcost = array_sum($cost);

		try{
			$balance = \Stripe\Balance::retrieve();
			$app->availableBalance = numbers(($balance->available[0]->amount/100));
		}
		catch(\Stripe\Error\Card $e) {
			notify($e);
		}
	}

	if(isset($id)){
		$sql = "
			SELECT
				user.id,
				user.email,
				user.first_name,
				user.last_name,
				user.url,
				user.id,
				user.account_id,
				user.managed_id,
				SUM(sessions.session_cost) as cost,
				profile.getpaid
			FROM
				avid___user user

			INNER JOIN avid___sessions sessions on sessions.from_user = user.email

			INNER JOIN avid___user_profile profile on profile.email = user.email

			WHERE
				user.id = :id
					AND
				sessions.paidout IS NULL
					AND
				sessions.session_status IS NOT NULL
					AND
				sessions.session_cost IS NOT NULL
					AND
				sessions.from_user NOT LIKE '%-fraud%'
		";
		$prepare = array(
			':id'=>$id
		);
		$results = $app->connect->executeQuery($sql,$prepare)->fetch();
		if(isset($results->id)){

			$sql = "SELECT * FROM avid___sessions WHERE paidout IS NULL AND from_user = :from_user AND dispute IS NULL AND session_status IS NOT NULL AND session_cost != 0 ORDER BY ID DESC";
			$prepare = array(':from_user'=>$results->email);
			$results->sessions = $app->connect->executeQuery($sql,$prepare)->fetchAll();

			$sql = "SELECT first_name,last_name,address_line_1,address_line_2,city,state,zipcode,notes FROM avid___user_checks WHERE email = :email";
			$prepare = array(':email'=>$results->email);
			$check = $app->connect->executeQuery($sql,$prepare)->fetch();
			if(isset($check->first_name)){
				$results->check = $check;
			}

			$app->paytutor = $results;
		}
	}
