<?php



	$app->filterbylocation = 'tutorssearch';

	if(isset($app->search->target)){
		unset($app->search->target);
	}

	$jsonSearch = json_encode($app->search);
	$app->setCookie('searching',$jsonSearch, '2 days');

	$prepared = array();
	$prepared[':usertype'] = 'tutor';

	$additional = NULL;
	$additionalWhere = NULL;
	$subjectJoin = NULL;
	$having = NULL;


	if(isset($app->search->advanced) && $app->search->advanced=='on' || isset($app->search->advanced) && $app->search->advanced==true){

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

	if(!empty($app->search->zipcode)){

		if(empty($app->search->distance)){
			$app->search->distance = 15;
		}

		$cachedKey = "cachedzipcode----".$app->search->zipcode;
		$cachedZipcode = $app->connect->cache->get($cachedKey);
		if($cachedZipcode == null) {
			$zipcodedata = get_zipcode_data($app->connect,$app->search->zipcode);
		    $results = $zipcodedata;
		    $cachedZipcode = $results;
		    $app->connect->cache->set($cachedKey, $results, 3600);
		}

		if(empty($cachedZipcode)){
			new Flash(
				array('action'=>'alert','message'=>'Invalid Zipcode')
			);
		}

		if(isset($cachedZipcode->lat)){
				$getDistance = "
					, round(((acos(sin((" . $cachedZipcode->lat . "*pi()/180)) * sin((user.lat*pi()/180))+cos((" . $cachedZipcode->lat . "*pi()/180)) * cos((user.lat*pi()/180)) * cos(((" .$cachedZipcode->long. "- user.long)* pi()/180))))*180/pi())*60*1.1515)
				";

				$asDistance = ' as distance ';

				$additional.= $getDistance.$asDistance;

				$having = "HAVING distance <= :distance";


				$prepared[':distance'] = $app->search->distance;
			}
	}


	if(!empty($app->search->search)){

		$additional.= "

			, subjects.subject_slug
			, subjects.subject_name
			, subjects.parent_slug

		";

		$subjectJoin = "

			INNER JOIN
				avid___user_subjects subjects
					on subjects.email = user.email

		";

		$additionalWhere.="
			AND
				CONCAT(subjects.subject_name,' ',subjects.subject_slug,' ',subjects.parent_slug) LIKE :searchSubject

		";

		$searchkeyword = $app->search->search;
		$prepared[':searchSubject'] = "%$searchkeyword%";

		//notify($additionalWhere);
	}

	$orderBy = NULL;
	$starsJoin = NULL;

	$additional.= "
	,

	round(
		(
			SELECT
				sum(sessions.review_score) as sum
			FROM
				avid___sessions sessions
			WHERE
				sessions.from_user = user.email
		) /

		(
			SELECT
				count(sessions.review_score) as count
			FROM
				avid___sessions sessions
			WHERE
				sessions.from_user = user.email
		) ,2) as star_score

	";



	if(isset($app->filterby)){
		if($app->filterby=='highestrate'){
			$orderBy = "ORDER BY profile.hourly_rate DESC";
		}
		elseif($app->filterby=='lowestrate'){
			$orderBy = "ORDER BY profile.hourly_rate ASC";
		}
		elseif($app->filterby=='lastactive'){
			$orderBy = "ORDER BY user.last_active DESC";
		}
		elseif($app->filterby=='higheststarscore'){

			$additionalWhere.= "

				AND
				(
					SELECT
						sum(sessions.review_score) as sum
					FROM
						avid___sessions sessions
					WHERE
						sessions.from_user = user.email
				) IS NOT NULL
			";

			$orderBy = "ORDER BY star_score DESC";
		}
		elseif(!empty($app->search->zipcode) && $app->filterby=='furthestdistance'){
			$orderBy = "ORDER BY distance DESC";
		}
		elseif(!empty($app->search->zipcode) && $app->filterby=='closestdistance'){
			$orderBy = "ORDER BY distance ASC";
		}
		else{

		}
	}
	else{
		$orderBy = "ORDER BY user.last_active DESC";
	}


	$offsets = new offsets($app->number,10);



	$limitOffset = "
		LIMIT
			".$offsets->perpage."
		OFFSET
			".$offsets->offsetStart."
	";

	$sql = "

		SELECT
			SQL_CALC_FOUND_ROWS
				user.first_name,
				user.last_name,
				user.username,
				user.email,
				user.url,
				user.last_active,
				user.usertype,
				user.last_active,
				user.emptybgcheck,
				user.city_slug,
				user.state_slug,
				user.city,
				user.state_long,
				user.zipcode,


				profile.hourly_rate,
				profile.my_avatar,
				profile.my_avatar_status,
				profile.my_upload,
				profile.my_upload_status,
				profile.short_description_verified,
				profile.personal_statement_verified,

				settings.negotiableprice

				$additional

		FROM
			avid___user user

		$subjectJoin

		$starsJoin

		INNER JOIN

			avid___user_profile profile on profile.email = user.email

		INNER JOIN

			avid___user_account_settings settings on settings.email = user.email

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
			user.last_active >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)

			$additionalWhere

		GROUP BY
			user.email

		$having

		$orderBy

		$limitOffset


	";

	

	$alltheresults = $app->connect->executeQuery($sql,$prepared)->fetchAll();
	//notify($alltheresults);


	$howmany = $app->connect->executeQuery("SELECT FOUND_ROWS() as count",array())->fetch();
	$app->count = $howmany->count;
	if($app->count>0){
		$pagify = new Pagify();
		$config = array(
			'total'    => $app->count,
			'url'      => $app->target->pagebase,
			'page'     => $offsets->number,
			'per_page' => $offsets->perpage
		);

		$pagify->initialize($config);
		$app->pagination = $pagify->get_links();

		$app->searchResults = $alltheresults;
	}
	else{

	}


	$filtertype = array(
		'closestdistance'=>'Closest Distance',
		'furthestdistance'=>'Furthest Distance',
		'highestrate'=>'Highest Hourly Rate',
		'lowestrate'=>'Lowest Hourly Rate',
		'lastactive'=>'Last Active',
		'higheststarscore'=>'Highest Star Score'
	);

	if(empty($getDistance)){
		unset($filtertype['closestdistance']);
		unset($filtertype['furthestdistance']);
	}

	$app->filtertype = $filtertype;
