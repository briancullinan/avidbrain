<?php
	
	$app->secondary = $app->target->secondary;
	$app->filterby = $app->getCookie('filterby');
	
	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('user.id')->from('avid___user','user');
	$data	=	$data->where('user.usertype = :usertype AND state_slug IS NOT NULL AND state_slug = :state_slug')->setParameter(':usertype','tutor')->setParameter(':state_slug',$state);
	$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
	$data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
	$data	=	$data->andWhere('user.status IS NULL');
	$data	=	$data->andWhere('user.hidden IS NULL');
	$data	=	$data->andWhere('user.lock IS NULL');
	
	$data	=	$data->orderBy('user.state_slug','ASC');
	$data	=	$data->groupBy('user.email');
	$count	=	$data->execute()->rowcount();
	
	$app->number = (isset($number) ? $number : NULL);
	$offsets = new offsets($app->number,$app->dependents->pagination->items_per_page);
	
	$data	=	$data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart);
	$data	=	$data->addSelect(everything().',user.email,user.id');
	$data	=	$data->execute()->fetchAll();
	
	$pagebase = '/tutors/'.$state.'/page';
	
	$pagify = new Pagify();
	$config = array(
		'total'    => $count,
		'url'      => $pagebase,
		'page'     => $offsets->number,
		'per_page' => $offsets->perpage
	);
	$pagify->initialize($config);
	$app->pagination = $pagify->get_links();
	
	$countpropper = str_replace('.00','',numbers($count));
	
	
	if(isset($data[0])){
		$zero = $data[0];
		$app->searchResults = $data;
		
		$app->meta = new stdClass();
		$app->meta->title = ucwords($zero->state_long).' Tutors';
		$app->meta->h1 = ' <span>'.$countpropper.'</span> '.ucwords($zero->state_long).' Tutors';
		$app->meta->keywords = $zero->state_long.' tutors, '.$zero->state_long.' tutoring, '.$zero->state_long.' lessons, '.$zero->state_long.' learning, '.$zero->state_long.' coaching';
		$app->meta->description = 'avid brain tutors are everywhere';
		
	}
	
	$app->filterbylocation = 'tutors---'.$state;