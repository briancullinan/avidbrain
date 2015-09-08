<?php

	if(isset($app->whiteboardstatus->status) && isset($app->whiteboardstatus->roomid) && $app->whiteboardstatus->status=='delete' && isset($app->roomid)){
		
		
		$deleteroom = array(
			'api_key'=>'27D1B127-9CCB-A496-810CC85CDECC42D1',
			'function'=>'rooms.delete',
			'roomid'=>$app->roomid
		);
		
		$newroom = scribblar($deleteroom);
		
		$app->connect->update('avid___sessions',array('roomid'=>NULL),array('from_user'=>$app->user->email,'roomid'=>$app->roomid,'id'=>$app->sessionid));
		
		$app->redirect('/resources/whiteboard');
		
	}
