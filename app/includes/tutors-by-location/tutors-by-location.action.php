<?php

	//$app->connect->cache->clean();

	$sql = "
		SELECT
			user.state,
			user.city_slug,
			user.state_long,
			user.state_slug,
			user.city,
			user.zipcode,
			COUNT(user.city) as count
		FROM
			avid___user user

		WHERE
			user.city IS NOT NULL
				AND
			user.usertype = 'tutor'
                AND
            user.status IS NULL
                AND
            user.hidden IS NULL
                AND
            user.lock IS NULL

		GROUP BY user.city

		ORDER BY COUNT(user.city) DESC

	";

	$cachedStatecountResults = "cached-state-count-results";
	$cachedStateReturn = $app->connect->cache->get($cachedStatecountResults);
	if($cachedStateReturn == null) {
	    $results = $app->connect->executeQuery($sql,array())->fetchAll();
	    $cachedStateReturn = $results;
	    $app->connect->cache->set($cachedStatecountResults, $results, 3600);
	}


	$sql = "
		SELECT
			user.id,
			user.state,
			user.city_slug,
			user.state_long,
			user.state_slug,
			user.city,
			user.zipcode,
			COUNT(user.state) as count
		FROM
			avid___user user

		WHERE
			user.city IS NOT NULL
				AND
			user.usertype = 'tutor'
				AND
			user.status IS NULL
				AND
			user.hidden IS NULL
				AND
			user.lock IS NULL

		GROUP BY user.state_long

		ORDER BY COUNT(user.state) DESC

	";

	$cachedCityReturn = "cached-city-return";
	$cachedcityvalues = $app->connect->cache->get($cachedCityReturn);
	if($cachedcityvalues == null) {
	    $results = $app->connect->executeQuery($sql,array())->fetchAll();
	    $cachedcityvalues = $results;
	    $app->connect->cache->set($cachedCityReturn, $results, 3600);
	}

	$app->cities = $cachedcityvalues;
	$app->states = $cachedStateReturn;


	$app->meta = new stdClass();
	$app->meta->title = SITENAME_PROPPER.' Tutors by Location';
	$app->meta->h1 = SITENAME_PROPPER.' Tutors by Location';
	
