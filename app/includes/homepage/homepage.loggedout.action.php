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
		$results->link = DOMAIN.$results->url;
		$results->name = short($results);
		$results->img = userphotographs($app->user,$results);
	    $cachedTestimonial = $results;
	    $app->connect->cache->set($cachedTestimonialKey, $results, 3600);
	}

	$app->cachedTestimonial = $cachedTestimonial;

//	$app->connect->cache->clean();

	$cachedTopTutorKey = "cachedFeaturedtutor---homepage";
	$cachedTOPTUTOR = $app->connect->cache->get($cachedTopTutorKey);
	if($cachedTOPTUTOR == null) {

		$sql = "
			SELECT
				user.first_name,
				user.last_name,
				user.city,
				user.state,
				user.state_long,
				user.username,
				user.url,
				user.email,
				profile.short_description_verified,
				profile.personal_statement_verified,
				profile.my_avatar,
				profile.my_avatar_status,
				profile.my_upload,
				profile.my_upload_status
			FROM
				avid___user user

			INNER JOIN

				avid___user_profile profile on profile.email = user.email

			WHERE
				user.state IS NOT NULL
					AND
				profile.my_upload IS NOT NULL
					AND
				profile.my_upload_status = 'verified'
					AND
				profile.short_description_verified IS NOT NULL
					AND
				profile.personal_statement_verified IS NOT NULL


			ORDER BY RAND()
			LIMIT 1
		";
		$prepare = array();
		$results = $app->connect->executeQuery($sql,$prepare)->fetch();
		$results->name = short($results);
		$results->img = userphotographs($app->user,$results);

		$sql = "
			SELECT
				subjects.subject_name
			FROM
				avid___user_subjects subjects
			WHERE
				subjects.email = :email
					AND
				subjects.status = 'verified'
			ORDER BY subjects.sortorder ASC
			LIMIT 10
		";
		$prepare = array(
			':email'=>$results->email
		);
		$results->mysubjects = $app->connect->executeQuery($sql,$prepare)->fetchAll();

	    $cachedTOPTUTOR = $results;
	    $app->connect->cache->set($cachedTopTutorKey, $results, 120);
	}
	$app->cachedTOPTUTOR = $cachedTOPTUTOR;


	$slides = function($root,$path){
		$slides = glob($root.$path);
		shuffle($slides);
		$slides = array_slice($slides, -5);
		$slider = '';
		foreach($slides as $slide){
			$slider.='<li><img src="'.str_replace($root,'/',$slide).'" /></li>';
		}
		return $slider;
	};

	$app->slider = $slides(DOCUMENT_ROOT,'images/homepage-slides/*.jpg');


	$featured = [];
	$featured[] = (object)[
		'title'=>'12 News NBC',
		'link'=>'http://www.12news.com/story/news/local/valley/2016/01/01/avid-brain-tutors-any-subject/78188836/',
		'img'=>'12-news-abc.png'
	];
	$featured[] = (object)[
		'title'=>'Arizona Republic',
		'link'=>'http://www.azcentral.com/story/news/local/scottsdale/2015/11/02/scottsdale-tutoring-company-joins-growing-online-industry-cns/75039918/',
		'img'=>'az-replublic.png'
	];
	$featured[] = (object)[
		'title'=>'Cronkite News',
		'link'=>'http://cronkitenews.azpbs.org/2015/10/30/scottsdale-tutoring-company-joins-growing-online-industry/',
		'img'=>'cronkite-news.png'
	];
	$featured[] = (object)[
		'title'=>'AZ Big Media',
		'link'=>'http://azbigmedia.com/ab/tech/teaching-students-on-the-web',
		'img'=>'az-big-media.png'
	];
	$featured[] = (object)[
		'title'=>'Phoenix Business Journal',
		'link'=>'http://www.bizjournals.com/phoenix/blog/techflash/2016/01/heres-the-64-startups-competing-in-the-2016.html',
		'img'=>'phoenix-business-journal.png'
	];

	$featuredlogos = '';
	foreach($featured as $item){
		$featuredlogos.='<div><a href="'.$item->link.'"><img src="/images/featured/'.$item->img.'" class="responsive-img" /></a></div>';
	}
	$app->featuredlogos = $featuredlogos;
