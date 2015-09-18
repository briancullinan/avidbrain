<?php
	if($app->user->usertype=='student'){
		$select1 = 'email';
		$select2 = 'recipient';
	}
	elseif($app->user->usertype=='tutor'){
		$select1 = 'recipient';
		$select2 = 'email';
	}
	
	
	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('payments.*,sessions.payrate,sessions.session_cost,'.everything())->from('avid___user_payments','payments');
	$data	=	$data->where('payments.'.$select1.' = :myemail OR payments.recipient = :myemail');
	$data	=	$data->setParameter(':myemail',$app->user->email);
		$data	=	$data->leftJoin('payments','avid___user','user','user.email = payments.'.$select2);
		$data	=	$data->leftJoin('payments','avid___user_profile','profile','user.email = profile.email');
		$data	=	$data->leftJoin('payments','avid___user_account_settings','settings','user.email = settings.email');
		$data	=	$data->leftJoin('payments','avid___sessions','sessions','sessions.id = payments.session_id');
	$data	=	$data->orderBy('payments.id','DESC');
	
	$offsets = new offsets((isset($number) ? $number : NULL),$app->dependents->pagination->items_per_page);
	$count	=	$data->execute()->rowCount();
	$data	=	$data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart);
	$data	=	$data->execute()->fetchAll();
	
	//notify($data);
	
	$pagify = new Pagify();
	$config = array(
		'total'    => $count,
		'url'      => '/payment/history/page/',
		'page'     => $offsets->number,
		'per_page' => $offsets->perpage
	);
	$pagify->initialize($config);
	$app->pagination = $pagify->get_links();
	
	if(isset($data[0])){
		$app->paymenthistory = $data;
	}
	
	$app->meta = new stdClass();
	$app->meta->title = 'Payment History';
	
	//notify((stripe_transaction(10000)/100)-100);
	
	$app->target->include = $app->target->user->include;