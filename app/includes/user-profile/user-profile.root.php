<?php

	//notify($app->target);

	if(DEBUG==false){
		foreach($app->target as $key=> $changeMe){
			$app->target->$key = str_replace('/view-user/','/view-userBak/',$changeMe);
		}
	}

	$usertype = explode('/',$app->request->getPath());
	$usertype=$usertype[1];

	if(isset($app->user->usertype) && isset($pagename) && isset($category) && $pagename=='my-photos'){

		$allowedCategories = array('crop-photo','delete-photo','rotate-right','rotate-left');

		if(isset($app->user->usertype) && $app->user->usertype=='admin'){
			$allowedCategories[] = 'approvephoto';
			$allowedCategories[] = 'disapprovephoto';
		}

		if(!in_array($category, $allowedCategories)){
			$app->redirect('/'.$usertype);
		}
		else{
			include($app->target->action);
			$app->target->action = APP_PATH.'includes/shared-pages/'.$category.'.action.php';
			$app->target->post = APP_PATH.'includes/shared-pages/'.$category.'.post.php';
			$app->target->include = APP_PATH.'includes/shared-pages/'.$category.'.include.php';
		}
	}

	$app->secondary = $app->target->secondaryNav;
