<?php
	
	if(isset($id)){
		$app->path = str_replace($id,'',$app->request->getPath());
	}
	
	if($app->target->key!='/sessions/disputed'){
		$app->target->include = $app->target->user->include;
		$app->target->post = $app->target->user->post;
		//$app->target->actions = $app->target->user->action;	
	}
	
	
	$sql = "SELECT id FROM avid___sessions WHERE dispute IS NOT NULL AND from_user = :email OR dispute IS NOT NULL AND to_user = :email";
	$prepeare = array(':email'=>$app->user->email);
	$dispute = $app->connect->executeQuery($sql,$prepeare)->rowCount();
	
	$childen = array();
	if($app->user->usertype=='tutor'){
		$childen['/sessions/setup-new/'] = (object) array('name'=>'Setup Session','slug'=>'/sessions/setup-new');
		$childen['/sessions/jobs/'] = (object) array('name'=>'Job Sessions','slug'=>'/sessions/jobs');
	}
	elseif($app->user->usertype=='student'){
		$childen['/jobs'] = (object) array('name'=>'Request Tutoring Session','slug'=>'/jobs');
	}
	$childen['/sessions/pending/'] = (object) array('name'=>'Pending','slug'=>'/sessions/pending');
	$childen['/sessions/completed/'] = (object) array('name'=>'Completed','slug'=>'/sessions/completed');
	$childen['/sessions/canceled/'] = (object) array('name'=>'Canceled','slug'=>'/sessions/canceled');
	if($app->path=='/sessions/setup/'){
		$childen['/sessions/setup/'] = (object) array('name'=>'Modify Session','slug'=>'/sessions/setup/'.$id);
	}
	if($app->path=='/sessions/view/'){
		$childen['/sessions/view/'] = (object) array('name'=>'View Session','slug'=>'/sessions/view/'.$id);
	}
	if($dispute>0){	
		$childen['/sessions/disputed/'] = (object) array('name'=>'Disputed','slug'=>'/sessions/disputed');
	}
	
	$app->childen = $childen;
	$navtitle = (object)array('slug'=>'/sessions','text'=>'Sessions');
	$app->navtitle = $navtitle;
	
	$app->secondary = $app->target->secondaryNav;