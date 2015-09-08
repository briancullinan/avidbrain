<?php
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
			$app->target->action = $app->dependents->APP_PATH.'includes/shared-pages/'.$category.'.action.php';
			$app->target->post = $app->dependents->APP_PATH.'includes/shared-pages/'.$category.'.post.php';
			$app->target->include = $app->dependents->APP_PATH.'includes/shared-pages/'.$category.'.include.php';
		}
	}
	
	$app->secondary = $app->target->secondaryNav;