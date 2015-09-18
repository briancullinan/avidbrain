<?php
	$app->meta = new stdClass();
	$app->meta->title = 'Reviews of '.$app->dependents->SITE_NAME_PROPPER;
	$app->meta->h1 = $app->dependents->SITE_NAME_PROPPER.' Reviews';
	$app->meta->keywords = 'avidbrain,review,tutor,review,tutoring,reviews,'.$app->dependents->SITE_NAME_PROPPER.'reviews';
	$app->meta->description = 'Looking for an '.$app->dependents->SITE_NAME_PROPPER.' review, we we will show you all of them';
	
	
	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('sessions.*,'.everything())->from('avid___sessions','sessions');
	$data	=	$data->where('sessions.review_name IS NOT NULL AND sessions.review_text IS NOT NULL');
	$data	=	$data->innerJoin('sessions','avid___user','user','user.email = sessions.to_user');
	$data	=	$data->innerJoin('sessions','avid___user_profile','profile','profile.email = sessions.to_user');
	$data	=	$data->innerJoin('sessions','avid___user_account_settings','settings','settings.email = sessions.to_user');
	$data	=	$data->orderBy('session_timestamp','DESC');

	
	$offsets = new offsets((isset($number) ? $number : NULL),$app->dependents->pagination->items_per_page);
	$count = $data->execute()->rowCount();
	$alljobs = $data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart)->execute()->fetchAll();
	$pagify = new Pagify();
	$config = array(
		'total'    => $count,
		'url'      => $app->target->pagebase,
		'page'     => $offsets->number,
		'per_page' => $offsets->perpage
	);
	$pagify->initialize($config);
	$app->pagination = $pagify->get_links();
	
	$data	=	$data->execute()->fetchAll();
	if(isset($data[0])){
		$app->reviews = $data;
	}