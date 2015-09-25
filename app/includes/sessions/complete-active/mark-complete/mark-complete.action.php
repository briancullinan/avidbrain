<?php
	
	$markcomplete	=	$app->connect->createQueryBuilder()->
			select('sessions.*, user.first_name, user.last_name, user.usertype, user.url, user.promocode, user.customer_id, profile.custom_avatar, profile.showmyphotoas, profile.my_avatar, profile.my_avatar_status, profile.my_upload, profile.my_upload_status, '.account_settings())->from('avid___sessions','sessions')->
			where('sessions.id = :id')->setParameter(':id',$id)->
			andWhere('from_user = :from_user')->setParameter(':from_user',$app->user->email)->
			innerJoin('sessions','avid___user','user','user.email = sessions.to_user')->
			innerJoin('sessions','avid___user_profile','profile','profile.email = sessions.to_user')->
			innerJoin('sessions','avid___user_account_settings','settings','settings.email = sessions.to_user')->
			execute()->fetch();
			
			//notify($markcomplete);
			
			if(empty($markcomplete->id)){
				$app->redirect('/sessions');
			}
			else{
				$app->markcomplete = $markcomplete;
				$app->markcomplete->dateDiff = sessionDateDiff($app->markcomplete->session_timestamp);
			}
			
	$app->meta = new stdClass();
	$app->meta->title = 'Complete Tutoring Session';
	$app->meta->h1 = 'Complete Tutoring Session';