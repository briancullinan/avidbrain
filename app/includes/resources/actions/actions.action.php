<?php	

	if($type=='whiteboard'){
		
		
		$sql = "SELECT roomid,id FROM avid___sessions WHERE roomid = :roomid AND from_user = :myemail OR roomid = :roomid AND to_user = :myemail LIMIT 1";
		$prepare = array(':roomid'=>$action,':myemail'=>$app->user->email);
		$getroomdata = $app->connect->executeQuery($sql,$prepare)->fetch();
		//notify();
		
		$data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select('sessions.to_user,user.first_name,user.last_name,user.url')->from('avid___sessions','sessions');
		$data	=	$data->where('sessions.roomid = :roomid')->setParameter(':roomid',$getroomdata->roomid);
		$data	=	$data->innerJoin('sessions','avid___user','user','sessions.to_user = user.email');
		$data	=	$data->execute()->fetch();
		if(!empty($data)){
			$app->roominfo = $data;
		}
		
		if(isset($getroomdata->roomid)){
			$app->roomid = $getroomdata->roomid;
			$app->sessionid = $getroomdata->id;
			$app->target->include = $app->target->base.'whiteboard.view.php';
		}
		elseif(isset($app->whiteboardsession->roomid) && $action=='view'){
			$app->target->include = $app->target->base.'whiteboard.view.php';
		}
		
	}
