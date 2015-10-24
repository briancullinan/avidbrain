<?php
	$tutorsbycityvar = $app->connect->cache->get("tutorsbycity");
	if($tutorsbycityvar == null) {

	    $data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select('user.state, user.state_long, user.state_slug, user.city, user.city_slug, user.zipcode')->from('avid___user','user');
		$data	=	$data->setParameter(':usertype','tutor');
		$data	=	$data->where('user.usertype = :usertype');
		$data	=	$data->andWhere('user.status IS NULL');
		$data	=	$data->andWhere('user.hidden IS NULL');
		$data	=	$data->andWhere('user.lock IS NULL');
		$data	=	$data->andWhere('user.state_slug IS NOT NULL');
		$data	=	$data->andWhere('settings.loggedinprofile = "no"');

		$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
		$data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');

		$data	=	$data->andWhere('user.state_slug IS NOT NULL');

		$data	=	$data->orderBy('user.state_slug','ASC');
		$data	=	$data->groupBy('user.city_slug');

		$returnedData	=	$data->execute()->fetchAll();

	    $tutorsbycityvar = $returnedData;
	    $app->connect->cache->set("tutorsbycity", $returnedData, 3600);
	}




	$app->tutorsbycity = $tutorsbycityvar;

	$keywords=array();
	foreach($tutorsbycityvar as $key=> $category){
		$keywords[] = $category->city.' '.ucwords($category->state_long).' Tutors';

	}
	shuffle($keywords);
	$keywords = array_slice($keywords,0, 10);
	$key='';
	foreach($keywords as $keys){
		$key.=$keys.', ';
	}

	$app->meta = new stdClass();
	$app->meta->title = $app->dependents->SITE_NAME_PROPPER.' Tutors by Location';
	$app->meta->h1 = $app->dependents->SITE_NAME_PROPPER.' Tutors In Your City';
	$app->meta->keywords = $key;
	$app->meta->description = 'avid brain tutors are everywhere';
