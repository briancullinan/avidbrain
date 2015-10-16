<?php

	$selectAdditions = "
		,user.first_name,user.last_name,user.email,user.url,user.promocode,user.customer_id
	";

	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('user.id'.$selectAdditions)->from('avid___user','user');
	$data	=	$data->where('user.promocode = :promocode')->setParameter(':promocode',$app->user->email);
	$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
	$data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
	$promocodeStudents	=	$data->execute()->fetchAll();
	//notify($promocodeStudents);

	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('user.id'.$selectAdditions)->from('avid___sessions','sessions');
	$data	=	$data->where('sessions.from_user = :email AND user.promocode != :email')->setParameter(':email',$app->user->email);//->setParameter(':mypromocode',$app->user->email);
	$data	=	$data->innerJoin('sessions','avid___user','user','sessions.to_user = user.email');
	$data	=	$data->innerJoin('sessions','avid___user_profile','profile','sessions.to_user = profile.email');
	$data	=	$data->innerJoin('sessions','avid___user_account_settings','settings','sessions.to_user = settings.email');
	$data	=	$data->groupBy('user.email');
	$sessionStudents	=	$data->execute()->fetchAll();

	$mystudents = array();

	if(isset($promocodeStudents[0])){
		$mystudents = $promocodeStudents;
	}
	if(isset($sessionStudents[0])){
		$mystudents = array_merge($mystudents, $sessionStudents);
	}

	foreach($mystudents as $key=> $check){
		if(empty($check->id)){
			unset($mystudents[$key]);
		}
	}
	$app->mystudents = $mystudents;
