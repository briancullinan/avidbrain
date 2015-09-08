<?php
	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('COUNT(user.state_slug) as count, user.*')->from('avid___user','user');
	$data	=	$data->setParameter(':usertype','tutor');
	$data	=	$data->where('user.usertype = :usertype');
	$data	=	$data->andWhere('user.status IS NULL');
	$data	=	$data->andWhere('user.hidden IS NULL');
	$data	=	$data->andWhere('user.lock IS NULL');
	$data	=	$data->andWhere('user.state_slug IS NOT NULL');
	
	
	$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
	$data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
	
	$data	=	$data->andWhere('user.state_slug IS NOT NULL');
	
	$data	=	$data->orderBy('COUNT(user.state_slug)','DESC');
	$data	=	$data->groupBy('user.state_slug');
	
	$data	=	$data->execute()->fetchAll();
	
	//notify($data);

	
	$app->tutorsbylocation = $data;
	$keywords='';
	foreach($data as $category){
		$keywords.= $category->state_slug.' tutors,';
	}
	
	$app->meta = new stdClass();
	$app->meta->title = $app->dependents->SITE_NAME_PROPPER.' Tutors by Location';
	$app->meta->h1 = $app->dependents->SITE_NAME_PROPPER.' Tutors by Location';
	$app->meta->keywords = $keywords;
	$app->meta->description = 'avid brain tutors are everywhere';