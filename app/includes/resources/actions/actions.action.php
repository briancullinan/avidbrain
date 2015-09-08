<?php	

	if($type=='whiteboard'){
		
		
		$sql = "SELECT roomid,id FROM avid___sessions WHERE roomid = :roomid AND from_user = :myemail OR roomid = :roomid AND to_user = :myemail LIMIT 1";
		$prepare = array(':roomid'=>$action,':myemail'=>$app->user->email);
		$getroomdata = $app->connect->executeQuery($sql,$prepare)->fetch();
		if(isset($getroomdata->roomid)){
			$app->roomid = $getroomdata->roomid;
			$app->sessionid = $getroomdata->id;
			$app->target->include = $app->target->base.'whiteboard.view.php';
		}
		elseif(isset($app->whiteboardsession->roomid) && $action=='view'){
			$app->target->include = $app->target->base.'whiteboard.view.php';
		}
		
	}
