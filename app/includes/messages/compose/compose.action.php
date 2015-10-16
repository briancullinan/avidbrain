<?php

	$selectAdditions = ',user.first_name,user.last_name,user.email,user.url,user.promocode,user.customer_id,user.username';

	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('user.id'.$selectAdditions)->from('avid___user','user');
	$data	=	$data->where('user.promocode = :myemail');
	$data	=	$data->orWhere('messages.from_user = :myemail');
	//$data	=	$data->orWhere('messages.to_user = :myemail');
	$data	=	$data->setParameter(':myemail',$app->user->email);

	$data	=	$data->leftJoin('user','avid___messages','messages','messages.to_user = user.email');

	$data	=	$data->leftJoin('user','avid___user_profile','profile','profile.email = user.email');
	$data	=	$data->leftJoin('user','avid___user_account_settings','settings','settings.email = user.email');
	$data	=	$data->groupBy('user.email');
	$data	=	$data->orderBy('user.promocode,user.usertype');

	$data	=	$data->execute()->fetchAll();

	$app->alltheusers = $data;


	if(isset($username)){
		foreach($app->alltheusers as $check){
			if(isset($check->username) && $check->username==$username){
				$app->composemessage = $check;
				break;
			}
		}
		if(empty($app->composemessage)){
			$app->redirect('/messages/compose');
		}
	}
