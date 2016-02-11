<?php


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
		//'liberal-arts'
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
	$offsets = new offsets((isset($number) ? $number : 1),PERPAGE);

	//notify($app->filterby);

	$userSelect = "
		user.last_active,
		user.state,
		user.state_long,
		user.state_slug,
		user.city,
		user.city_slug,
		user.zipcode,
		user.first_name,
		user.last_name,
		user.url,
		user.email,
		user.usertype,

		profile.short_description_verified,
		profile.personal_statement_verified,
		profile.my_avatar,
		profile.my_avatar_status,
		profile.my_upload,
		profile.my_upload_status,
		profile.hourly_rate,
		subjects.parent_slug
	";

	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('user.id')->from('avid___user','user');
	$data	=	$data->where('user.usertype = :usertype');

	// AND WHERE
	$data	=	$data->andWhere('user.status IS NULL');
	$data	=	$data->andWhere('user.hidden IS NULL');
	$data	=	$data->andWhere('user.lock IS NULL');
	$data	=	$data->andWhere('profile.hourly_rate IS NOT NULL');
	if(empty($app->user->email)){
		$data	=	$data->andWhere('settings.loggedinprofile = "no"');
	}

	$data	=	$data->andWhere('subjects.parent_slug = :parent_slug');

	// PARMAMETERS
	$data	=	$data->setParameter(':usertype','tutor');
	$data	=	$data->setParameter(':parent_slug',$broadMatch);

		$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
		$data	=	$data->innerJoin('user','avid___user_subjects','subjects','user.email = subjects.email');
		$data	=	$data->leftJoin('user','avid___sessions','sessions','user.email = sessions.from_user');
		$data	=	$data->leftJoin('user','avid___user_account_settings','settings','user.email = settings.email');

		$data = $data->addSelect(' (SELECT round((sum(sessions.session_length) / 60))  FROM avid___sessions sessions WHERE sessions.from_user = user.email) AS hours' );
		$data = $data->addSelect(' (SELECT count(sessions.id)  FROM avid___sessions sessions WHERE sessions.review_name IS NOT NULL AND sessions.from_user = user.email) AS count' );
		$data = $data->addSelect(' (SELECT sum(sessions.review_score)  FROM avid___sessions sessions WHERE sessions.review_name IS NOT NULL AND sessions.from_user = user.email) AS score' );
		$data = $data->addSelect(' (SELECT (sum(sessions.review_score) / count(sessions.id))  FROM avid___sessions sessions WHERE sessions.review_name IS NOT NULL AND sessions.from_user = user.email) AS average' );

		//notify($app->filterby);
		// ORDER BY --++--++--++
			$orderBy = "ORDER BY user.last_active DESC";
			$data	=	$data->orderBy('user.last_active','DESC');
			if(isset($app->filterby)){
				if($app->filterby=='highestrate'){
					$orderBy = "ORDER BY profile.hourly_rate DESC";
					$data	=	$data->orderBy('profile.hourly_rate','DESC');
				}
				elseif($app->filterby=='lowestrate'){
					$orderBy = "ORDER BY profile.hourly_rate ASC";
					$data	=	$data->orderBy('profile.hourly_rate','ASC');
				}
				elseif($app->filterby=='lastactive'){
					$orderBy = "ORDER BY user.last_active DESC";
					$data	=	$data->orderBy('user.last_active','DESC');
				}
				elseif($app->filterby=='higheststarscore'){

					$data =	$data->andWhere('sessions.review_name IS NOT NULL');
					$data	=	$data->orderBy('(average/count)','ASC');

				}
			}
		// ORDER BY --++--++--++

		// GROUP
		$data	=	$data->groupBy('user.email');


	$count	=	$data->execute()->rowCount();
	$data	=	$data->addSelect($userSelect);
	$data	=	$data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart);
	$data = make_search_key_cache($data,$app->connect);
	//$data	=	$data->execute()->fetchAll();

	//notify($data);

	if($count>0){
		$app->broadmatch = $data;
	}

	// PAGINATION
	$pagify = new Pagify();
	$config = array(
		'total'    => $count,
		'url'      => '/'.$parent_slug.'-tutors/page/',
		'page'     => $offsets->number,
		'per_page' => $offsets->perpage
	);
	$pagify->initialize($config);
	$app->pagination = $pagify->get_links();

	$app->meta = new stdClass();
	$app->meta->title = 'AvidBrain '.$app->broadMatchCap.' Tutors';
	$app->meta->h1 = $app->broadMatchCap.' Tutors';
	#$app->meta->keywords = 'examplekeys';
	#$app->meta->description = 'exampledescribers';
	//$app->broadMatchCap.' Tutors'


	$file = DOCUMENT_ROOT.'images/categories/'.$broadMatch.'.jpg';
	if(file_exists($file)){
		$app->meta->h1 = false;
		$app->wideconent = '<div class="widecontent '.$broadMatch.' valign-wrapper"> <div class="valign">'.$app->broadMatchCap.' Tutors</div> </div>';
	}
