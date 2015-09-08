<?php
	
	if($app->user->usertype=='tutor'){
		$app->target->include = str_replace('.tutor.','.',$app->target->include);
			
		$completed	=	$app->connect->createQueryBuilder()->
					select('sessions.*, user.first_name, user.last_name, user.customer_id, user.url, user.usertype, profile.my_avatar, profile.my_avatar_status, profile.my_upload, profile.my_upload_status, settings.showfullname')->
					from('avid___sessions','sessions')->
					where('from_user = :email')->setParameter(':email',$app->user->email)->
					andWhere('sessions.session_status = :paid')->setParameter(':paid','complete')->
					innerJoin('sessions','avid___user','user','sessions.to_user = user.email')->
					innerJoin('user','avid___user_profile','profile','user.email = profile.email')->
					innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
					
	
		$count = $completed->execute()->rowCount();
		$offsets = new offsets((isset($number) ? $number : NULL),$app->dependents->pagination->items_per_page);
		$completed	=	$completed->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart)->orderBy('session_timestamp','DESC')->execute()->fetchAll();
				
		if(isset($completed[0])){
			$app->completed = $completed;
			
			$pagify = new Pagify();
			$config = array(
				'total'    => $count,
				'url'      => '/sessions/completed/page',
				'page'     => $offsets->number,
				'per_page' => $offsets->perpage
			);
			$pagify->initialize($config);
			$app->pagination = $pagify->get_links();
			
		}
	
	
		$app->meta = new stdClass();
		$app->meta->title = 'Pending Sessions';
	}
	elseif($app->user->usertype=='student'){
		$app->target->include = str_replace('.student.','.',$app->target->include);
			
		$completed	=	$app->connect->createQueryBuilder()->
					select('sessions.*, user.first_name, user.last_name, user.customer_id, user.url, user.usertype, profile.my_avatar, profile.my_avatar_status, profile.my_upload, profile.my_upload_status, settings.showfullname')->
					from('avid___sessions','sessions')->
					where('to_user = :email')->setParameter(':email',$app->user->email)->
					andWhere('sessions.session_status = :paid')->setParameter(':paid','complete')->
					innerJoin('sessions','avid___user','user','sessions.from_user = user.email')->
					innerJoin('user','avid___user_profile','profile','user.email = profile.email')->
					innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
					
	
		$count = $completed->execute()->rowCount();
		$offsets = new offsets((isset($number) ? $number : NULL),$app->dependents->pagination->items_per_page);
		$completed	=	$completed->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart)->orderBy('session_timestamp','DESC')->execute()->fetchAll();
				
		if(isset($completed[0])){
			$app->completed = $completed;
			
			$pagify = new Pagify();
			$config = array(
				'total'    => $count,
				'url'      => '/sessions/completed/page',
				'page'     => $offsets->number,
				'per_page' => $offsets->perpage
			);
			$pagify->initialize($config);
			$app->pagination = $pagify->get_links();
			
		}
	
	
		$app->meta = new stdClass();
		$app->meta->title = 'Completed Sessions';
	}
	
	//