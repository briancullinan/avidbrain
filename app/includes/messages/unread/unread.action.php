<?php
	
	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->from('avid___messages','messages');
	$data	=	$data->where('messages.location = :location AND messages.status__read IS NULL')->setParameter(':location','inbox');
	$data	=	$data->andWhere('messages.to_user = :email')->setParameter(':email',$app->user->email);
	$data	=	$data->leftJoin('messages','avid___user','user','messages.from_user = user.email');
	$data	=	$data->leftJoin('messages','avid___user_profile','profile','messages.from_user = profile.email');
	$data	=	$data->leftJoin('messages','avid___user_account_settings','settings','messages.from_user = settings.email');
	$data	=	$data->orderBy('messages.send_date','DESC');
	$data	=	$data->groupBy('messages.id');
	
		$count	=	$data->select('messages.id')->execute()->rowCount();
		$offsets = new offsets((isset($number) ? $number : NULL),$app->dependents->pagination->items_per_page);
	
	$data->select('messages.*, '.user_select().', '.profile_select().', '.account_settings().'');
	$data	=	$data->orderBy('messages.send_date','DESC');
	$data	=	$data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart);
	$data	=	$data->execute()->fetchAll();
	
	if($count>0){
		$app->messages = $data;	
	}
	
	$pagify = new Pagify();
	$config = array(
		'total'    => $count,
		'url'      => $app->target->pagebase,
		'page'     => $offsets->number,
		'per_page' => $offsets->perpage
	);
	$pagify->initialize($config);
	$app->pagination = $pagify->get_links();
	
	$app->meta = new stdClass();
	$app->meta->title = 'View All Un-Read Messages';