<?php
	$app->target->include = str_replace('.'.$app->user->usertype.'.','.',$app->target->include);
	
	if($app->user->usertype=='tutor'){
		$selec1='from_user';
		$selec2='to_user';
	}
	elseif($app->user->usertype=='student'){
		$selec1='to_user';
		$selec2='from_user';
	}
	
	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('sessions.*,'.everything())->from('avid___sessions','sessions');
	$data	=	$data->where($selec1.' = :myemail AND pending IS NOT NULL')->setParameter(':myemail',$app->user->email);
	
		$data	=	$data->innerJoin('sessions','avid___user','user','user.email = sessions.'.$selec2);
		$data	=	$data->innerJoin('sessions','avid___user_profile','profile','profile.email = sessions.'.$selec2);
		$data	=	$data->innerJoin('sessions','avid___user_account_settings','settings','settings.email = sessions.'.$selec2);
		$data	=	$data->groupBy('sessions.id');
	
	$count = $data->execute()->rowCount();
	$offsets = new offsets((isset($number) ? $number : NULL),PERPAGE);
	$data	=	$data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart)->orderBy('session_timestamp,id','DESC')->execute()->fetchAll();
			
	if(isset($data[0])){
		$app->pendingsessions = $data;
		
		$pagify = new Pagify();
		$config = array(
			'total'    => $count,
			'url'      => '/sessions/pending/page',
			'page'     => $offsets->number,
			'per_page' => $offsets->perpage
		);
		$pagify->initialize($config);
		$app->pagination = $pagify->get_links();
		
	}


	$app->meta = new stdClass();
	$app->meta->title = 'Pending Sessions';