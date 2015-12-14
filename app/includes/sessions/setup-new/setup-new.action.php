<?php

	$sql = "
		SELECT
			approved.*,
			user.first_name,
			user.last_name,
			user.promocode,
			user.customer_id,
			user.url,
			user.username
		FROM
			avid___approved_tutors approved

		INNER JOIN
			avid___user user on user.email = approved.student_email

		WHERE
			approved.tutor_email = :tutor_email
	";
	$prepare = array(':tutor_email'=>$app->user->email);
	$approvedstudents = $app->connect->executeQuery($sql,$prepare)->fetchAll();


	if(isset($approvedstudents[0])){
		$app->approvedstudents = $approvedstudents;
	}


	if(isset($username)){

		$sql = "
			SELECT
				user.username,
				user.email,
				user.first_name,
				user.last_name,
				user.promocode,
				user.customer_id,
				user.url,
				approved.student_email as approved_email
			FROM
				avid___user user

			INNER JOIN

				avid___approved_tutors approved on user.email = approved.student_email

			WHERE
				user.username = :username
					AND
				user.usertype = 'student'
					AND
				approved.tutor_email = :myemail
		";
		$prepare = array(':username'=>$username,':myemail'=>$app->user->email);
		$validuser = $app->connect->executeQuery($sql,$prepare)->fetch();
		if(isset($validuser->approved_email)){

			$sql = "
				SELECT
					sessions.session_rate
				FROM
					avid___sessions sessions
				WHERE
					to_user = :to_user
						AND
					from_user = :from_user
				ORDER BY ID DESC
				LIMIT 1
			";
			$prepare = array(':to_user'=>$validuser->email,':from_user'=>$app->user->email);
			$sessioninfo = $app->connect->executeQuery($sql,$prepare)->fetch();
			if(isset($sessioninfo->session_rate)){
				$validuser->previousrate = $sessioninfo->session_rate;
			}

			$app->validuser = $validuser;
		}
	}
