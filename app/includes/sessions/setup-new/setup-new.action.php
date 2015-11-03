<?php

	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select(everything().', user.username, user.promocode, user.email, user.customer_id')->from('avid___user','user');
	$data	=	$data->where('user.promocode = :myemail AND user.usertype = :usertype');
	$data	=	$data->orWhere('messages.to_user = :myemail AND user.usertype = :usertype');
	$data	=	$data->orWhere('messagesFrom.from_user = :myemail AND user.usertype = :usertype');
	$data	=	$data->setParameter(':myemail',$app->user->email);
	$data	=	$data->setParameter(':usertype','student');


	$data	=	$data->leftJoin('user','avid___messages','messagesFrom','messagesFrom.to_user = user.email');
	$data	=	$data->leftJoin('user','avid___messages','messages','messages.from_user = user.email');
	$data	=	$data->leftJoin('user','avid___user_profile','profile','profile.email = user.email');
	$data	=	$data->leftJoin('user','avid___user_account_settings','settings','settings.email = user.email');
	$data	=	$data->groupBy('user.url');
	$data	=	$data->orderBy('user.promocode,user.usertype');

	$data	=	$data->execute()->fetchAll();

	$app->alltheusers = $data;
	//printer($app->alltheusers,1);


	if(isset($username)){
		foreach($app->alltheusers as $check){
			if(isset($check->username) && $check->username==$username){
				$app->setupsessionwith = $check;
				break;
			}
		}
		if(isset($app->setupsessionwith->email)){
			$sql = "SELECT session_rate FROM avid___sessions WHERE to_user = :email ORDER BY id DESC";
			$prepare = array(':email'=>$app->setupsessionwith->email);
			$results = $app->connect->executeQuery($sql,$prepare)->fetch();
			if(isset($results->session_rate)){
				$app->previousRate = $results->session_rate;
			}
		}

		if(empty($app->setupsessionwith)){
			$app->redirect('/messages/compose');
		}
	}
