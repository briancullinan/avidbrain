<?php

	if($app->user->usertype=='student'){
		$whatami1 = 'to_user';
		$whatami2 = 'from_user';
	}
	elseif($app->user->usertype=='tutor'){
		$whatami1 = 'from_user';
		$whatami2 = 'to_user';
	}

	if(isset($whatami1)){
		$data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select('sessions.*, user.username, user.first_name, user.last_name ')->from('avid___sessions','sessions');
		$data	=	$data->where($whatami1.' = :myemail AND sessions.roomid IS NOT NULL')->setParameter(':myemail',$app->user->email);

		$data	=	$data->innerJoin('sessions','avid___user','user','user.email = sessions.'.$whatami2);
		$data	=	$data->innerJoin('sessions','avid___user_profile','profile','profile.email = sessions.'.$whatami2);
		$data	=	$data->innerJoin('sessions','avid___user_account_settings','settings','settings.email = sessions.'.$whatami2);

		$data	=	$data->orderBy('session_timestamp','DESC');
		$data	=	$data->execute()->fetchAll();
	}

	//notify($data);

	if(!empty($data)){
		$app->getroomdata = $data;
	}


	$childen = array();
	//$childen['resources-whiteboard'] = (object) array('name'=>'Whiteboard','slug'=>'/resources/whiteboard');
	$childen['resources-qanda'] = (object) array('name'=>'Questions & Answers','slug'=>'/resources/questions-and-answers');
	// if(isset($action) && isset($type) && $type=='whiteboard' && $app->user->usertype=='tutor'){
	// 	$app->tertiary = $app->target->secondary;
	// }

	$app->childen = $childen;
	$navtitle = (object)array('slug'=>'/resources','text'=>'Resources');
	$app->navtitle = $navtitle;

	$app->secondary = $app->target->secondaryNav;
