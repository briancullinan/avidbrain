<?php
	$app->meta = new stdClass();
	$app->meta->title = 'Page Not Found';
	$app->meta->h1 = 'OH NO! Page Not Found';
	$app->meta->keywords = 'avid, '.$app->dependents->SITE_NAME_PROPPER.', brain, tutoring, tutor';
	$app->meta->description = 'avid brain tutoring, teach something, learn anything';

	$select = '
		settings.*,
		user.usertype,user.first_name,user.last_name,user.city,user.state_long,user.url,user.state_slug,user.city_slug,
		profile.my_upload,profile.my_upload_status,profile.hourly_rate,profile.my_avatar,profile.short_description_verified,profile.personal_statement_verified
	';

	//$app->connect->cache->delete("random_tutor");
	$randomtutor = $app->connect->cache->get("random_tutor");
	if($randomtutor == null) {

		$data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select($select)->from('avid___user','user');
		$data	=	$data->where('user.usertype = :usertype')->setParameter(':usertype','tutor');
		$data	=	$data->where('user.usertype = "tutor"');
		$data	=	$data->andWhere('user.status IS NULL');
		$data	=	$data->andWhere('user.hidden IS NULL');
		$data	=	$data->andWhere('user.lock IS NULL');

		$data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
		$data	=	$data->andWhere('settings.loggedinprofile = "no"');
		$data	=	$data->andWhere('profile.my_upload IS NOT NULL AND profile.my_upload_status = "verified"');

		$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');

		$data	=	$data->orderBy('RAND()');
		$data	=	$data->setMaxResults(1);
		$data	=	$data->execute()->fetch();


	    $returnedData = $data;
	    $randomtutor = $returnedData;
	    $app->connect->cache->set("random_tutor", $returnedData, 3600);
	}
	$app->randomtutor = $randomtutor;
