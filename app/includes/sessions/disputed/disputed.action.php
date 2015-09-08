<?php
	
	if($app->user->usertype=='student'){
		$dispute	=	$app->connect->createQueryBuilder()->
					select('sessions.*, user.first_name, user.last_name, user.url, user.customer_id, user.usertype, profile.my_avatar, profile.my_avatar_status, profile.my_upload, profile.my_upload_status, settings.showfullname')->
					from('avid___sessions','sessions')->
					where('to_user = :email')->setParameter(':email',$app->user->email)->
					andWhere('dispute is not null')->
					innerJoin('sessions','avid___user','user','sessions.from_user = user.email')->
					innerJoin('user','avid___user_profile','profile','user.email = profile.email')->
					orderBy('sessions.session_timestamp','DESC')->
					innerJoin('user','avid___user_account_settings','settings','user.email = settings.email')->execute()->fetchAll();
	}
	elseif($app->user->usertype=='tutor'){
		$dispute	=	$app->connect->createQueryBuilder()->
					select('sessions.*, user.first_name, user.last_name, user.url, user.customer_id, user.usertype, profile.my_avatar, profile.my_avatar_status, profile.my_upload, profile.my_upload_status, settings.showfullname')->
					from('avid___sessions','sessions')->
					where('from_user = :email')->setParameter(':email',$app->user->email)->
					andWhere('dispute is not null')->
					innerJoin('sessions','avid___user','user','sessions.to_user = user.email')->
					innerJoin('user','avid___user_profile','profile','user.email = profile.email')->
					orderBy('sessions.session_timestamp','DESC')->
					innerJoin('user','avid___user_account_settings','settings','user.email = settings.email')->execute()->fetchAll();
	}
	
	
	if(isset($dispute[0])){
		$app->dispute = $dispute;
	}