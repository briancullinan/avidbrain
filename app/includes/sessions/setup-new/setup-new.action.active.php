<?php

	$sql = "
		SELECT
			messages.from_user as email,
			user.first_name,
			user.last_name,
			user.username,
			user.promocode

		FROM
			avid___messages messages

		INNER JOIN

			avid___user user on user.email = messages.from_user

		WHERE
			messages.to_user = :myemail
				AND
			messages.from_user NOT LIKE '%@avidbrain.com%'

				GROUP BY messages.from_user


	";

	$prepared = array(
		':myemail'=>$app->user->email
	);

	$allmessages = $app->connect->executeQuery($sql,$prepared)->fetchAll();




	$allowed = array();
	foreach($allmessages as $key=> $email){
		$sql = "
			SELECT
				count(messages.id) as count, to_user, from_user
			FROM
				avid___messages messages
			WHERE
				from_user = :email
					AND
				to_user = :myemail
		";
		$prepared = array(
			':email'=>$email->email,
			':myemail'=>$app->user->email
		);
		$count = $app->connect->executeQuery($sql,$prepared)->fetch();

		if(isset($count->count) && $count->count < 2){
			unset($allmessages[$key]);
		}
		else{
			$allowed[] = $email->username;
		}
	}

	if(isset($username) && in_array($username, $allowed)){

		$sql = "
			SELECT
				user.username,
				user.promocode,
				user.email,
				user.customer_id,
				user.url
			FROM
				avid___user user

			WHERE
				user.username = :username
		";
		$prepared = array(':username'=>$username);
		$app->thestudent = $app->connect->executeQuery($sql,$prepared)->fetch();

		$sql = "SELECT session_rate FROM avid___sessions WHERE to_user = :email ORDER BY id DESC LIMIT 1";
		$prepare = array(':email'=>$app->thestudent->email);
		$results = $app->connect->executeQuery($sql,$prepare)->fetch();


		if(isset($results->session_rate)){
			$app->thestudent->previousrate = $results->session_rate;
		}


	}

	$app->setupsessionusers = $allmessages;
