<?php

	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->from('avid___messages','messages');
	$data	=	$data->where('messages.location = :location')->setParameter(':location','inbox');
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
	$app->meta->title = 'View All Messages';


	if(isset($app->user->needs_bgcheck)){
		foreach($data as $key => $scrub){
			$data[$key]->subject = '<span class="removed">Subject Removed</span>';
			$data[$key]->message = '<span class="removed">Message Removed</span>';
		}
	}


	if($count>0){
		$app->messages = $data;
	}
