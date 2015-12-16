<?php

	if(isset($app->search->target)){
		unset($app->search->target);
	}

	//notify($app->search);

	$prepared = array();
	$prepared[':usertype'] = 'tutor';

	$additional = NULL;
	$additionalWhere = NULL;
	$subjectJoin = NULL;


	if(isset($app->search->advanced) && $app->search->advanced=='on'){

		if(!empty($app->search->name)){
			$additionalWhere.= "\n AND CONCAT(user.first_name,' ',user.last_name) LIKE :name";
			$additional.= ', user.first_name ';//CONCAT(user.first_name," ",user.last_name)
			$searchname = $app->search->name;
			$prepared[':name'] = "%$searchname%";
		}

		if(!empty($app->search->gender)){
			$additionalWhere.= "\n AND profile.gender = :gender";
			$additional.= ', profile.gender';
			$searchgender = $app->search->gender;
			$prepared[':gender'] = $searchgender;
		}

		if(isset($app->search->pricerangeLower) && isset($app->search->pricerangeUpper)){

			$additionalWhere.= "\n AND profile.hourly_rate BETWEEN :pricerangeLower and :pricerangeUpper ";
			$prepared[':pricerangeLower'] = $app->search->pricerangeLower;
			$prepared[':pricerangeUpper'] = $app->search->pricerangeUpper;
		}
	}


	if(isset($app->search->search)){

		$searchkeyword = $app->search->search;

		$subjectJoin = "

			INNER JOIN

				avid___user_subjects subjects on user.email = subjects.email AND subjects.subject_name LIKE :searchSubject

		";
		$prepared[':searchSubject'] = "%$searchkeyword%";
	}

	//$additional = rtrim($additional,', ');
	//$additional = trim($additional, ", ");
	//notify($additional);

	$orderBy = NULL;
	$orderBy = "ORDER BY profile.hourly_rate DESC";
	$orderBy = "ORDER BY profile.hourly_rate ASC";

	$sql = "

		SELECT
			SQL_CALC_FOUND_ROWS
				user.email,
				user.url,
				user.last_active,
				profile.hourly_rate

				$additional

		FROM
			avid___user user

		$subjectJoin

		INNER JOIN

			avid___user_profile profile on profile.email = user.email


		WHERE

			user.usertype = :usertype
				AND
			user.status IS NULL
				AND
			user.hidden IS NULL
				AND
			profile.hourly_rate IS NOT NULL
				AND
			user.lock IS NULL
				AND
			user.last_active >= DATE_SUB(CURDATE(), INTERVAL 8 MONTH)

			$additionalWhere

		GROUP BY
			user.email

		$orderBy

		LIMIT 10


	";

	//notify($sql);


	$alltheresults = $app->connect->executeQuery($sql,$prepared)->fetchAll();
	$howmany = $app->connect->executeQuery("SELECT FOUND_ROWS() as count",array())->fetch();
	//notify($howmany->count);


	notify($alltheresults);
