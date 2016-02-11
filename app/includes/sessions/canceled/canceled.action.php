<?php

	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('sessions.*, '.everything())->from('avid___sessions','sessions');

	if($app->user->usertype=='student'){
		$data	=	$data->where('sessions.to_user = :myemail AND session_status = "canceled-session"')->setParameter(':myemail',$app->user->email);
		$data	=	$data->innerJoin('sessions','avid___user','user','sessions.from_user = user.email');
	}
	elseif($app->user->usertype=='tutor'){
		$data	=	$data->where('sessions.from_user = :myemail AND session_status = "canceled-session"')->setParameter(':myemail',$app->user->email);
		$data	=	$data->innerJoin('sessions','avid___user','user','sessions.to_user = user.email');
	}

	$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
	$data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');

	#$data	=	$data->orderBy('id','DESC');
	#$data	=	$data->execute()->fetchAll();


	$count = $data->execute()->rowCount();
	$offsets = new offsets((isset($number) ? $number : NULL),PERPAGE);
	$data	=	$data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart)->orderBy('session_timestamp,id','DESC')->execute()->fetchAll();
	foreach($data as $key => $cleanup){
		if(empty($cleanup->id)){
			unset($data[$key]);
		}
	}

	if(isset($data[0])){
		$app->sessions = $data;

		$pagify = new Pagify();
		$config = array(
			'total'    => $count,
			'url'      => '/sessions/canceled/page',
			'page'     => $offsets->number,
			'per_page' => $offsets->perpage
		);
		$pagify->initialize($config);
		$app->pagination = $pagify->get_links();

	}


	$app->meta = new stdClass();
	$app->meta->title = 'Canceled Sessions';
