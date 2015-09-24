<?php
	
	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('user.id,user.username,user.promocode,user.first_name,user.last_name,'.everything())->from('avid___user','user');
	$data	=	$data->where('user.promocode = :promocode')->setParameter(':promocode',$app->user->email);
	$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
	$data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
	$promocodeStudents	=	$data->execute()->fetchAll();
	
	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('sessions.id,user.promocode,'.everything())->from('avid___sessions','sessions');
	$data	=	$data->where('sessions.from_user = :email AND user.promocode != :email')->setParameter(':email',$app->user->email);//->setParameter(':mypromocode',$app->user->email);
	$data	=	$data->innerJoin('sessions','avid___user','user','sessions.to_user = user.email');
	$data	=	$data->innerJoin('sessions','avid___user_profile','profile','sessions.to_user = profile.email');
	$data	=	$data->innerJoin('sessions','avid___user_account_settings','settings','sessions.to_user = settings.email');
	$data	=	$data->groupBy('user.email');
	$sessionStudents	=	$data->execute()->fetchAll();
	
	$app->mystudents = array();
	
	if(isset($promocodeStudents[0])){
		$app->mystudents = $promocodeStudents;
	}
	if(isset($sessionStudents[0])){
		$app->mystudents = array_merge($app->mystudents, $sessionStudents);
	}