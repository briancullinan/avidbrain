<?php
	

	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select(everything().', user.username, user.promocode')->from('avid___user','user');
	$data	=	$data->where('user.promocode = :myemail');
	$data	=	$data->orWhere('messages.to_user = :myemail');
	$data	=	$data->orWhere('messagesFrom.from_user = :myemail');
	$data	=	$data->setParameter(':myemail',$app->user->email);
	
	
	$data	=	$data->leftJoin('user','avid___messages','messagesFrom','messagesFrom.to_user = user.email');
	$data	=	$data->leftJoin('user','avid___messages','messages','messages.from_user = user.email');
	$data	=	$data->leftJoin('user','avid___user_profile','profile','profile.email = user.email');
	$data	=	$data->leftJoin('user','avid___user_account_settings','settings','settings.email = user.email');
	$data	=	$data->groupBy('user.url');
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