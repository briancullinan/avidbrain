<?php
	//notify($_COOKIE);

	// $allowed_parent_slugs = $app->connect->cache->get("allowed_parent_slugs");
	// if($allowed_parent_slugs == null) {
	//
	// 	$sql = "SELECT parent_slug FROM avid___available_subjects GROUP BY parent_slug";
	// 	$prepare = array(':usertype'=>'tutor');
	// 	$returnedData = $app->connect->executeQuery($sql,$prepare)->fetchAll();
	// 	$returnedArray = array();
	// 	foreach($returnedData as $parent){
	// 		$returnedArray[] = $parent->parent_slug;
	// 	}
	//     $allowed_parent_slugs = $returnedArray;
	//     $app->connect->cache->set("allowed_parent_slugs", $returnedArray, 10800);
	// }

	$allowed_parent_slugs = array(
		'art',
		'business',
		'college-prep',
		'computer',
		'elementary-education',
		'english',
		'games',
		'history',
		'language',
		'math',
		'music',
		'science',
		'special-needs',
		'sports-and-recreation',
		'test-preparation',
		'liberal-arts'
	);
	if(!in_array($parent_slug, $allowed_parent_slugs)){
		$app->redirect('/tutors');
	}

	$app->filterby = $app->getCookie('filterby');
	$app->secondary = $app->target->secondary;

	$broadMatch = $parent_slug;
	$app->broadMatchCap = ucwords(str_replace('-',' ',$broadMatch));
	$app->filterbylocation = 'maincats-'.$broadMatch.'-tutors';

	$cachedBroadMatch = 'broadmatch---'.$broadMatch.'---'.$app->filterby;
	$offsets = new offsets((isset($number) ? $number : NULL),$app->dependents->pagination->items_per_page);

	//notify($app->filterby);

	$orderBy = "ORDER BY user.last_active DESC";
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
			//notify('GET HIGH');
			$score = true;
			$orderBy = "ORDER BY average DESC";
		}
	}


	$bigSelect = "
		SELECT
			settings.*,
			profile.*,
			user.*,
			subjects.parent_slug
	";

	$sessionSelect = "

		sum(sessions.review_score) as score,
		count(sessions.review_score) as count,
		(sum(sessions.review_score) / count(sessions.review_score)) as average

	";

	$littleSelect = "SELECT user.id ";

	$sessionJoin = "

		INNER JOIN avid___sessions sessions
			ON user.email=sessions.from_user

	";
	if(empty($score)){
		$sessionJoin = NULL;
		$sessionSelect = NULL;
	}

	$sql = "


		FROM
			avid___user user

		INNER JOIN avid___user_profile profile
			ON user.email=profile.email

		INNER JOIN avid___user_account_settings settings
			ON user.email=settings.email

		INNER JOIN avid___user_subjects subjects
			ON user.email=subjects.email

		$sessionJoin

		WHERE
			user.usertype = 'tutor'
				AND
			user.hidden IS NULL
				AND
			user.status IS NULL
				AND
			user.lock IS NULL
				AND
			profile.hourly_rate IS NOT NULL
				AND
			subjects.parent_slug = '$broadMatch'

		GROUP BY user.email




	";

	$orderLimit = $orderBy." LIMIT $offsets->number,$offsets->perpage";
	notify($orderLimit);

	$results = $app->connect->executeQuery($bigSelect.$sql.$orderLimit,array())->fetchAll();
	$count	=	$app->connect->executeQuery($littleSelect.$sql,array())->rowCount();
	//notify(($count/$app->dependents->pagination->items_per_page));
	//notify(($count/11));

	$app->broadmatch = $results;

	$pagify = new Pagify();
	$config = array(
		'total'    => $count,
		'url'      => '/'.$parent_slug.'-tutors/page/',
		'page'     => $offsets->number,
		'per_page' => $offsets->perpage
	);
	$pagify->initialize($config);
	$app->pagination = $pagify->get_links();


	//$data	=	$data->innerJoin('user','avid___user_subjects','subjects','user.email = subjects.email');
