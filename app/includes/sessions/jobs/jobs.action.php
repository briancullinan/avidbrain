<?php
	$data	=	$app->connect->createQueryBuilder()->
				select('sessions.to_user,sessions.id, sessions.jobid, sessions.session_subject, user.customer_id, user.first_name, user.last_name, user.url, user.usertype, profile.custom_avatar, profile.showmyphotoas, profile.my_avatar, profile.my_avatar_status, profile.my_upload, profile.my_upload_status, settings.showfullname')->
				from('avid___sessions','sessions')->
				where('from_user = :email')->setParameter(':email',$app->user->email)->
				andWhere('jobsetup IS NOT NULL')->
				innerJoin('sessions','avid___user','user','sessions.to_user = user.email')->
				innerJoin('user','avid___user_profile','profile','user.email = profile.email')->
				innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');


	$count = $data->execute()->rowCount();
	$offsets = new offsets((isset($number) ? $number : NULL),PERPAGE);
	$data	=	$data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart)->orderBy('id','DESC')->execute()->fetchAll();

	if(isset($app->user->needs_bgcheck)){
		//notify($data);
	}

	if(isset($data[0])){
		$app->jobsessions = $data;

		$pagify = new Pagify();
		$config = array(
			'total'    => $count,
			'url'      => '/sessions/jobs/page',
			'page'     => $offsets->number,
			'per_page' => $offsets->perpage
		);
		$pagify->initialize($config);
		$app->pagination = $pagify->get_links();

	}

	$app->meta = new stdClass();
	$app->meta->title = 'Job Sessions';
