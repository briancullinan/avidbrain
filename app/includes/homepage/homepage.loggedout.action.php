<?php


	$limit = 15;

	$sql = "
		SELECT
			subjects.subject_slug,
			subjects.parent_slug,
			subjects.subject_name,
			count(subject_slug) as count
		FROM
			avid___user_subjects subjects

		INNER JOIN

		avid___user user on user.email = subjects.email

		WHERE
			subjects.usertype = 'tutor'
				AND
			user.status IS NULL
				AND
			user.hidden IS NULL
				AND
			user.lock IS NULL

		GROUP BY subjects.subject_slug

		ORDER BY count DESC

		LIMIT $limit
	";
	$prepare = array(

	);


	$cachedKey = "toptutoredsubjects--".$limit."limit";
	$results = $app->connect->cache->get($cachedKey);
	if($results == null) {
		$results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
		$app->connect->cache->set($cachedKey, $results, 3600);
	}

	if(isset($results[0])){
		$app->top = $results;
	}

	//$app->connect->cache->clean();

	$cachedTestimonialKey = "cachedtesimonials--homepage";
	$cachedTestimonial = $app->connect->cache->get($cachedTestimonialKey);
	if($cachedTestimonial == null) {
		$sql = "
			SELECT
				testimonials.*,
				user.url,
				user.first_name,
				user.last_name,
				user.username,

				profile.my_avatar,
	            profile.my_avatar_status,
	            profile.my_upload,
	            profile.my_upload_status

			FROM
				avid___testimonials testimonials

			INNER JOIN
				avid___user user on user.id = testimonials.userid

			INNER JOIN
				avid___user_profile profile on user.email = profile.email

			ORDER BY RAND()
			LIMIT 1
		";
		$prepare = array();
		$results = $app->connect->executeQuery($sql,$prepare)->fetch();
		$results->link = $app->dependents->DOMAIN.$results->url;
		$results->name = short($results);
		$results->img = userphotographs($app->user,$results,$app->dependents);
	    $cachedTestimonial = $results;
	    $app->connect->cache->set($cachedTestimonialKey, $results, 3600);
	}

	$app->cachedTestimonial = $cachedTestimonial;
